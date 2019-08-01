<?php
defined('IN_PHPCMS') or exit('No permission resources.');

//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
pc_base::load_app_func('global');
pc_base::load_sys_class('form', '', '');
class index {
	private $db, $db_setting, $db_market_setting, $db_function_setting, $db_series_setting;
	private $db_market_list, $db_function_list, $db_series_list;

	const MARKET = 1;
	const SERIES = 2;

	private $_product_props = null;

	function __construct() {
        require_once __DIR__ . '/../../../product_props.php';

		$this->db = pc_base::load_model('productions_model');
		$this->db_setting = pc_base::load_model('productions_setting_model');

		$this->db_market_setting = pc_base::load_model('productions_market_model');
		$this->db_function_setting = pc_base::load_model('productions_functions_model');
		$this->db_series_setting = pc_base::load_model('productions_series_model');

		$this->db_market_list = pc_base::load_model('productions_market_list_model');
		$this->db_function_list = pc_base::load_model('productions_functions_list_model');
		$this->db_series_list = pc_base::load_model('productions_series_list_model');

		$this->_product_props = $product_props;
	}

	//首页
	public function init() {
	    $setting = $this->db_setting->get_one(['id' => 1]);

	    // market setting
        $market_setting = $this->db_market_setting->get_one(['id' => 1]);

        // functions setting
        $function_setting = $this->db_function_setting->get_one(['id' => 1]);

        // series setting
        $series_setting = $this->db_series_setting->get_one(['id' => 1]);

		include template('product', 'index');
	}

	public function step() {
	    $type = (int)$_GET['type'];
        $setting = $this->db_setting->get_one(['id' => 1]);

        if ($type == self::MARKET) {
            $market_setting = $this->db_market_setting->get_one(['id' => 1]);
            $step_title = $market_setting['title'];

            $lists = $this->db_market_list->listinfo([], '', 1, 10);
        } elseif ($type == self::SERIES) {
            $series_setting = $this->db_series_setting->get_one(['id' => 1]);
            $step_title = $series_setting['title'];

            $lists = $this->db_series_list->listinfo([], '', 1, 10);
        }

        include template('product', 'step');
    }

    public function functions() {
        $type = (int)$_GET['type'];
        $id = (int)$_GET['id'];
        $setting = $this->db_setting->get_one(['id' => 1]);

        if (empty($type) && empty($id)) {
            $title = '功能';
            $lists = $this->db_function_list->listinfo([], '', 1, 1000);
        } else {
            if ($type == self::MARKET) {
                $item = $this->db_market_list->get_one(['id' => $id]);
                $title = $item['title'];

                $lists = $this->db_function_list->listinfo(['market_id' => $id], '', 1, 1000);
            } elseif ($type == self::SERIES) {
                $item = $this->db_series_list->get_one(['id' => $id]);
                $title = $item['title'];

                $lists = $this->db_function_list->listinfo(['series_id' => $id], '', 1, 1000);
            }
        }

        include template('product', 'functions');
    }

    public function lists() {
        $functions_id = (int)$_GET['functions_id'];
        $setting = $this->db_setting->get_one(['id' => 1]);
        $props = $this->_product_props;
        $page = 1;

        $function_info = $this->db_function_list->get_one(['id' => $functions_id]);

        $total = $this->db->count('functions_id = ' . $functions_id);
        $lists = $this->db->listinfo(['functions_id' => $functions_id], 'id DESC', $page, 1);
        $pages = $this->db->pages;

        include template('product', 'lists');
    }

    public function show() {
	    $id = (int)$_GET['id'];
        $setting = $this->db_setting->get_one(['id' => 1]);
        $props = $this->_product_props;

        $item = $this->db->get_one(['id' => $id]);

        include template('product', 'show');
    }
}
