<?php
defined('IN_PHPCMS') or exit('No permission resources.');

//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
pc_base::load_sys_func('dir');
pc_base::load_sys_class('form', '', '');
class search {
    private $db, $db_setting, $db_market_setting, $db_function_setting, $db_series_setting;
    private $db_market_list, $db_function_list, $db_series_list, $db_contact_setting, $db_linkage;

    const MARKET = 1;
    const SERIES = 2;

    private $_product_props = null;
    private $_filter_params = [];

    const EMPTY = -1000;

    private static $_map_series_id_title = [
        6 => '4.0',
        7 => '5.0',
        8 => '6.0',
    ];

    private $_relactionIndex = [
        // 系列
        'serial_id' => 0,
        // 前圈尺寸
        'front_shape' => 1,
        // 前圈/按键材料
        'front_button_material' => 2,
        // 前圈/按键形状
        'front_button_shape' => 3,
        // 前圈/按键颜色
        'front_button_color' => 4,
        // 开关元件
        'switch_element' => 5,
        // 照明形式
        'light_style' => 6,
        // 灯罩/LED灯颜色
        'led_color' => 7,
        // LED灯电压
        'led_voltage' => 8,
        // 军标
        'military_standard' => 9,
        // 功能
        'function_id' => 10,
        // 安装尺寸
        'install_size' => 11
    ];

    private $_seria4 = '6-1,2,3,4,A,B,D-0,1,2-1,2,3,A,B-1,2,3,4,5,6,7-0,1,2,3,4-1,2,3-0,1,2,3,4-0,1,2,3,4-C-0,1,2,4,6-A,B,C,D,E';
    private $_seria5 = '7-1,2,3,4,A,B,D-1,2-1,2,3,A,B-1,2,3,4,5,6,7-1,2-1,2,3-0,1,2,3,4-0,1,2,3,4-C-1,2-A,B,C,D,E';
    private $_seria6 = '8-0,1,2,3-0,1,2,3-0,1-1,2,3,4,5-0,1,2,3,4,5,6-0,1,2,3-0,1,2,3,4,7,8-0,1,2,3,4-n-0,1,2,3,4,5,6-E,F,G';

    private $_relaction = [];

	function __construct() {
        $this->db = pc_base::load_model('productions_model');
        $this->db_setting = pc_base::load_model('productions_setting_model');

        $this->db_linkage = pc_base::load_model('linkage_model');

        $this->db_market_setting = pc_base::load_model('productions_market_model');
        $this->db_function_setting = pc_base::load_model('productions_functions_model');
        $this->db_series_setting = pc_base::load_model('productions_series_model');

        $this->db_market_list = pc_base::load_model('productions_market_list_model');
        $this->db_function_list = pc_base::load_model('productions_functions_list_model');
        $this->db_series_list = pc_base::load_model('productions_series_list_model');
        $this->db_contact_setting = pc_base::load_model('productions_contact_setting_model');

        $this->_relaction = [
            $this->splitSerial($this->_seria4),
            $this->splitSerial($this->_seria5),
            $this->splitSerial($this->_seria6)
        ];

        // var_export($this->_relaction);
    }
    
    private function splitSerial($seria) {
        $seria1 = explode('-', $seria);
        $seria2 = [];
        foreach ($seria1 as $item) {
            $seria2[] = explode(',', $item);
        }

        return $seria2;
    }

    private function _c($param) {
        return isset($this->_filter_params[$param]) ? ($this->_filter_params[$param] == self::EMPTY ? '-' : $this->_filter_params[$param]) : 'X';
    }

    private function _propRestrict($relactions, $prop, $index) {
        $restricts = [];
        foreach ($relactions as $relaction) {
            if (in_array($prop, $relaction[$index])) {
                $restricts[] = $relaction;
            }
        }
        return $restricts;
    }

    /**
     * 关系约束
     */
    private function relactionRestrict($property) {
        $restricts = [];
        foreach ($this->_relactionIndex as $prop => $rIndex) {
            $propValue = (isset($property[$prop]) && $property[$prop] != '') ? $property[$prop] : -100;
            if ($propValue != -100 && $propValue != self::EMPTY) {
                if (empty($restricts)) {
                    $restricts = $this->_propRestrict($this->_relaction, $propValue, $rIndex);
                } else {
                    $restricts = $this->_propRestrict($restricts, $propValue, $rIndex);
                }
            }
        }

        $unionRestricts = [];
        foreach ($restricts as $restrict) {
            foreach ($restrict as $idx => $items) {
                foreach ($items as $item) {
                    if (!in_array($item, $unionRestricts[$idx])) {
                        $unionRestricts[$idx][] = $item;
                    }
                }
            }
        }
        
        return $unionRestricts;
    }

	// 参数搜索页
	public function init() {
        $empty = self::EMPTY;
        $props = $this->db_linkage->product_props();
        $series_id = isset($_GET['serial_id']) ? (int)$_GET['serial_id'] : 0;
        $series_title = self::$_map_series_id_title[$series_id];

        $serials = $this->db_series_list->listinfo();
        $functions = $this->db_function_list->listinfo([], '', 1, 1000);

        $mapFunctionCode = [];
        foreach ($functions as $fun) {
            $mapFunctionCode[$fun['id']] = $fun['code'];
        }

        $mapSerialIdTitle = [];
        foreach ($serials as $item) {
            $mapSerialIdTitle[$item['id']] = $item['title'];
        }

        $serial_id = $_GET['serial_id'];
        $function_id = $_GET['function_id'];

        $propertyGET = $_GET;
        $propertyGET['function_id'] = isset($mapFunctionCode[$function_id]) ? $mapFunctionCode[$function_id] : '';
        $restrict = $this->relactionRestrict($propertyGET);
        $restrictIndex = $this->_relactionIndex;

        // restrict serials
        $restrictSerials = $serials;
        if (!empty($restrict)) {
            $restrictSerials = [];
            foreach ($serials as $item) {
                if (empty($serial_id) && !in_array($item['id'], $restrict[0])) {
                    // continue;
                }

                $restrictSerials[] = $item;
            }
        }

        // restrict functions
        $restrictFunctions = $functions;
        if (!empty($restrict)) {
            $restrictFunctions = [];
            foreach ($functions as $item) {
                if (!in_array($item['id'], $restrict[10])) {
                    // continue;
                }

                $restrictFunctions[] = $item;
            }
        }

        // restrict props
        $restrictProps = $props[$series_title];
        if (!empty($restrict)) {
            $restrictProps = [];
            foreach ($props[$series_title] as $kk => $prop) {
                $options = [];
                foreach ($prop['options'] as $key => $option) {
                    if (!in_array($key, $restrict[$restrictIndex[$kk]])) {
                        // continue;
                    }

                    $options[$key] = $option;
                }
                $prop['options'] = $options;

                $restrictProps[$kk] = $prop;
            }
        }
//        var_dump($restrictProps);exit;

        // 根据$serial_id获取function list
        if (!empty($serial_id)) {
            $serial = $this->db_series_list->get_one(['id' => $serial_id]);
        }

        $filter = $_GET;
        if (!empty($filter['serial_id'])) {
            $series_id = $filter['serial_id'];
            $filter['series_id'] = $filter['serial_id'];
        }
        $product_code = $filter['product_code'];
        $is_military_standard = false;
        if (isset($filter['military_standard']) && $filter['military_standard'] != $empty) {
            $is_military_standard = true;
        }

        unset($filter['page']);
        unset($filter['m']);
        unset($filter['c']);
        unset($filter['a']);
        unset($filter['serial_id']);
        unset($filter['function_id']);
        unset($filter['siteid']);
        unset($filter['product_code']);

        $setting = $this->db_setting->get_one(['id' => 1]);
        $contacts = $this->db_contact_setting->get_one(['id' => 1]);
        $page = (int)$_GET['page'];
        $page = $page > 1 ? $page : 1;
        $where = '1 = 1';
        if (!empty($product_code)) {
            $where .= ' AND `code` LIKE \'%' . $product_code . '%\'';
        }

        if (isset($_GET['function_id']) && $function_id != self::EMPTY) {
            $where .= ' AND functions_id = ' . $function_id;
        }
        $props_total = [];
        foreach ($props as $k => $v) {
            $ww = $where . ' AND ' . $k . ' IN(\'' . implode('\',\'', array_keys($v['options'])) . '\')';
            $props_total[$k] = $this->db->count($ww);
        }

        $condition = [];
        $is_display_contact = 'none';
        if (!empty($filter)) {
            foreach ($filter as $field => $flt) {
                if ($flt == self::EMPTY) {
                    continue;
                }
                if ($flt == 'Z') {
                    $is_display_contact = 'block';
                    continue;
                }

                // 军标不参与搜索
                if ($field == 'military_standard') {
                    continue;
                }

//                if ($field == 'military_standard' && $flt == 'G') {
//                    continue;
//                }

                $condition[] = $field . ' = "' . $flt . '"';
            }
        }
        if (!empty($condition)) {
            $where .= ' AND (' . implode(' AND ', $condition) . ')';
        }

        $contact_info = '联系电话：' . $contacts['telephone'] . '<br />QQ：' . $contacts['qq'] . '<br />微信：' . $contacts['wechat'] . '<br />邮箱：' . $contacts['email'];

        $total = $this->db->count($where);
        $products = $this->db->listinfo($where, 'id DESC', $page, 10);
        $pages = $this->db->pages;

        $lists = [];
        foreach ($products as $product) {
            // 当选择军标的时候
            if (!$is_military_standard) {
                $product['code'] = str_replace('G', '-', $product['code']);
                $product['military_standard'] = '-';
            }

            $lists[] = $product;
        }

        // filter production search props
        $fields = implode(',', array_keys($this->_relactionIndex));
        $fields = str_replace('serial_id', 'series_id', $fields);
        $fields = str_replace('function_id', 'functions_id', $fields);
        $sql = 'SELECT DISTINCT ' . $fields . ' FROM se_productions WHERE ' . $where;
        $this->db->query($sql);
        $rows = $this->db->fetch_array();
        $search = [];
        foreach ($rows as $row) {
            foreach ($row as $sch => $val) {
                if ($sch == 'series_id') {
                    $sch = 'serial_id';
                }
                if ($sch == 'functions_id') {
                    $sch = 'function_id';
                }

                if (!isset($search[$sch])) {
                    $search[$sch] = [];
                }
                if (in_array($val, $search[$sch])) {
                    continue;
                }

                $search[$sch][] = $val;
            }
        }
//        if (!in_array('J', $search['military_standard'])) {
//            $search['military_standard'][] = 'J';
//        }
//        var_dump($search);
//        exit;

        // 规则：系列-{前圈尺寸}{前圈/按键材料}{前圈/按键形状}{前圈/按键颜色}.{开关元件}{照明形式}{LED灯颜色}{LED灯电压}.{前圈/磁}{序列号}
        $this->_filter_params = $filter;
        $code  = !empty($serial) ? ($serial['title'] . '-') : '';
        $code .= $this->_c('front_shape') . $this->_c('front_button_material') . $this->_c('front_button_shape') . $this->_c('front_button_color');
        $code .= '.' . $this->_c('switch_element') . $this->_c('light_style') . $this->_c('led_color') . $this->_c('led_voltage');

        //
        $code .= '.' . $this->_c('military_standard');

		include template('product', 'search');
	}
}
