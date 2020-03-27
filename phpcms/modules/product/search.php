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
        // 其它
        'others' => 9,
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
        return isset($this->_filter_params[$param]) ? $this->_filter_params[$param] : 'X';
    }

    /**
     * 关系约束
     */
    private function relactionRestrict($property) {
        $serial_id = $property['serial_id'];
        $function_id = $property['function_id'];
        $front_shape = $property['front_shape'];
        $front_button_material = $property['front_button_material'];
        $front_button_shape = $property['front_button_shape'];
        $front_button_color = $property['front_button_color'];
        $switch_element = $property['switch_element'];
        $light_style = $property['light_style'];
        $led_color = $property['led_color'];
        $led_voltage = $property['led_voltage'];
        $others = $property['others'];
        $install_size = $property['install_size'];

        $restrict = [];
        if (!empty($serial_id)) {
            foreach ($this->_relaction as $relactions) {
                foreach ($relactions as $index => $relaction) {
                    if ($index == 0) {
                        if ($relaction[0] == $serial_id) {
                            $restrict = $relactions;
                            break;
                        }
                    }
                }
            }
        }

        return $restrict;
    }

	// 参数搜索页
	public function init() {
        $props = $this->db_linkage->product_props();

        $serials = $this->db_series_list->listinfo();
        $functions = $this->db_function_list->listinfo([], '', 1, 1000);

        $mapSerialIdTitle = [];
        foreach ($serials as $item) {
            $mapSerialIdTitle[$item['id']] = $item['title'];
        }

        $serial_id = (int)$_GET['serial_id'];
        $function_id = (int)$_GET['function_id'];

        $restrict = $this->relactionRestrict($_GET);
        var_export($restrict);

        // 根据$serial_id获取function list
        if (!empty($serial_id)) {
            $sql = 'SELECT DISTINCT functions_id FROM `se_productions` WHERE series_id = ' . $serial_id;
            $query = $this->db->query($sql);
            $rows = $this->db->fetch_array();
            $functions_ids = [];
            foreach ($rows as $row) {
                if (!$row['functions_id']) {
                    continue;
                }

                $functions_ids[] = $row['functions_id'];
            }

            $where = 'id IN(' . implode(',', $functions_ids) . ')';
            $functions = $this->db_function_list->listinfo($where);

            $serial = $this->db_series_list->get_one(['id' => $serial_id]);
        }

        $setting = $this->db_setting->get_one(['id' => 1]);
        $contacts = $this->db_contact_setting->get_one(['id' => 1]);
        $page = (int)$_GET['page'];
        $page = $page > 1 ? $page : 1;
        $where = '1 = 1';
        if (!empty($function_id)) {
            $where .= ' AND functions_id = ' . $function_id;
        }
        $props_total = [];
        foreach ($props as $k => $v) {
            $ww = $where . ' AND ' . $k . ' IN(\'' . implode('\',\'', array_keys($v['options'])) . '\')';
            $props_total[$k] = $this->db->count($ww);
        }

        $filter = $_GET;
        if (!empty($filter['serial_id'])) {
            $filter['series_id'] = $filter['serial_id'];
        }
		unset($filter['page']);
        unset($filter['m']);
        unset($filter['c']);
        unset($filter['a']);
        unset($filter['serial_id']);
        unset($filter['function_id']);
        $condition = [];
        $is_display_contact = 'none';
        if (!empty($filter)) {
            foreach ($filter as $field => $flt) {
                if ($flt == '-') {
                    continue;
                }
                if ($flt == 'Z') {
                    $is_display_contact = 'block';
                    continue;
                }

                $condition[] = $field . ' = "' . $flt . '"';
            }
        }
        if (!empty($condition)) {
            $where .= ' AND (' . implode(' OR ', $condition) . ')';
        }

        $contact_info = '联系电话：' . $contacts['telephone'] . '<br />QQ：' . $contacts['qq'] . '<br />微信：' . $contacts['wechat'] . '<br />邮箱：' . $contacts['email'];

        $total = $this->db->count($where);
        $lists = $this->db->listinfo($where, 'id DESC', $page, 10);
        $pages = $this->db->pages;

        // 规则：系列-{前圈尺寸}{前圈/按键材料}{前圈/按键形状}{前圈/按键颜色}.{开关元件}{照明形式}{LED灯颜色}{LED灯电压}.{前圈/磁}{序列号}
        $this->_filter_params = $filter;
        $code  = !empty($serial) ? ($serial['title'] . '-') : '';
        $code .= $this->_c('front_shape') . $this->_c('front_button_material') . $this->_c('front_button_shape') . $this->_c('front_button_color');
        $code .= '.' . $this->_c('switch_element') . $this->_c('light_style') . $this->_c('led_color') . $this->_c('led_voltage');
        $code .= '.' . $this->_c('front_magnetic');

		include template('product', 'search');
	}
}
