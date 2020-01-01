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
	}

    private function _c($param) {
        return isset($this->_filter_params[$param]) ? $this->_filter_params[$param] : 'X';
    }

	// 参数搜索页
	public function init() {
        $props = $this->db_linkage->product_props();

        $serials = $this->db_series_list->listinfo();
        $functions = [];

        $serial_id = (int)$_GET['serial_id'];
        $function_id = (int)$_GET['function_id'];

        // 根据$serial_id获取function list
        if (!empty($serial_id)) {
            /*if (!empty($function_id)) {
                $where = ['id' => $function_id];
            } else {
                $where = 'series_id LIKE \'%' . $serial_id . '%\'';
            }*/

            $where = 'series_id LIKE \'%' . $serial_id . '%\'';
            $functions = $this->db_function_list->listinfo($where);
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
        $code  = '';
//        $code  = $serial['title'] . '-';
        $code .= $this->_c('front_shape') . $this->_c('front_button_material') . $this->_c('front_button_shape') . $this->_c('front_button_color');
        $code .= '.' . $this->_c('switch_element') . $this->_c('light_style') . $this->_c('led_color') . $this->_c('led_voltage');
        $code .= '.' . $this->_c('front_magnetic');

		include template('product', 'search');
	}
}