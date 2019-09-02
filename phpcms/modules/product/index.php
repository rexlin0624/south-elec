<?php
defined('IN_PHPCMS') or exit('No permission resources.');

//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
pc_base::load_sys_func('dir');
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
        $market_list = $this->db_market_list->listinfo([], '', 1, 100);

        // functions setting
        $function_setting = $this->db_function_setting->get_one(['id' => 1]);
        $function_list = $this->db_function_list->listinfo([], '', 1, 1000);

        // series setting
        $series_setting = $this->db_series_setting->get_one(['id' => 1]);
        $series_list = $this->db_series_list->listinfo([], '', 1, 100);

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
        $page = (int)$_GET['page'];
        $page = $page > 1 ? $page : 1;
        $where = 'functions_id = ' . $functions_id;

        $filter = $_POST;
        $conditon = [];
        if (!empty($filter)) {
            foreach ($filter as $field => $flt) {
                if ($flt == '-') {
                    continue;
                }

                $conditon[] = $field . ' = "' . $flt . '"';
            }
        }
        if (!empty($conditon)) {
            $where .= ' AND (' . implode(' OR ', $conditon) . ')';
        }

        $function_info = $this->db_function_list->get_one(['id' => $functions_id]);

        $total = $this->db->count($where);
        $lists = $this->db->listinfo($where, 'id DESC', $page, 10);
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

    /**
     *
     */
    public function generate_usb_version() {
	    $usb_template_path = PHPCMS_PATH . 'usb' . DIRECTORY_SEPARATOR;
	    $output_path = PHPCMS_PATH . 'usb_output' . DIRECTORY_SEPARATOR;

	    // 复制JS和CSS文件
        dir_copy($usb_template_path . 'statics', $output_path . 'statics');
        dir_copy(PHPCMS_PATH . 'uploadfile', $output_path . 'uploadfile');

        // 生成首页数据：市场分类、功能分类、系列分类、配置数据
        $this->db_setting = pc_base::load_model('productions_setting_model');
        $setting = $this->db_setting->get_one(['id' => 1]);
        $index_template = file_get_contents($usb_template_path . 'index.html');

        $index_template = preg_replace('/{setting_title}/', $setting['title'], $index_template);
        $index_template = preg_replace('/{setting_content}/', $setting['description'], $index_template);

        // market
        $market_setting = $this->db_market_setting->get_one(['id' => 1]);
        $market_list = $this->db_market_list->listinfo([], '', 1, 100);
        $market_menus = [];
        foreach ($market_list as $item) {
            $market_menus[] = '<li><a href="functions-1-' . $item['id'] . '.html"></a>' . $item['title'] . '</li>';
        }
        $market_thumb = substr($market_setting['thumb'], 1, strlen($market_setting['thumb']));
        $index_template = preg_replace('/{market_menus}/', implode('', $market_menus), $index_template);
        $index_template = preg_replace('/{market_thumb}/', $market_thumb, $index_template);
        $index_template = preg_replace('/{market_title}/', $market_setting['title'], $index_template);
        $index_template = preg_replace('/{market_description}/', $market_setting['description'], $index_template);

        // 功能
        $function_setting = $this->db_function_setting->get_one(['id' => 1]);
        $function_list = $this->db_function_list->listinfo([], '', 1, 100);
        $function_menus = [];
        foreach ($function_list as $item) {
            $function_menus[] = '<li><a href="functions-' . $item['id'] . '.html"></a>' . $item['title'] . '</li>';
        }
        $thumb = substr($function_setting['thumb'], 1, strlen($function_setting['thumb']));
        $index_template = preg_replace('/{function_menus}/', implode('', $function_menus), $index_template);
        $index_template = preg_replace('/{function_thumb}/', $thumb, $index_template);
        $index_template = preg_replace('/{function_title}/', $function_setting['title'], $index_template);
        $index_template = preg_replace('/{function_description}/', $function_setting['description'], $index_template);

        // 系列
        $series_setting = $this->db_series_setting->get_one(['id' => 1]);
        $list = $this->db_series_list->listinfo([], '', 1, 100);
        $series_menus = [];
        foreach ($list as $item) {
            $series_menus[] = '<li><a href="functions-2-' . $item['id'] . '.html"></a>' . $item['title'] . '</li>';
        }
        $thumb = substr($series_setting['thumb'], 1, strlen($series_setting['thumb']));
        $index_template = preg_replace('/{series_menus}/', implode('', $series_menus), $index_template);
        $index_template = preg_replace('/{series_thumb}/', $thumb, $index_template);
        $index_template = preg_replace('/{series_title}/', $series_setting['title'], $index_template);
        $index_template = preg_replace('/{series_description}/', $series_setting['description'], $index_template);

        file_put_contents($output_path . 'index.html', $index_template);

        // 生成二级页面数据
        $category_template = file_get_contents($usb_template_path . 'category.html');
        $category_template = preg_replace('/{setting_title}/', $setting['title'], $category_template);
        $category_template = preg_replace('/{setting_content}/', $setting['description'], $category_template);
        $category_template = preg_replace('/{market_menus}/', implode('', $market_menus), $category_template);
        $category_template = preg_replace('/{function_menus}/', implode('', $function_menus), $category_template);
        $category_template = preg_replace('/{series_menus}/', implode('', $series_menus), $category_template);

        // 市场
        $market_category_template = $category_template;
        $market_category_template = preg_replace('/{category_title}/', '市场', $market_category_template);
        $categories = [];
        foreach ($market_list as $item) {
            $thumb = substr($item['thumb'], 1, strlen($item['thumb']));
            $tmp  = '<div class="column grid_2 column_margin">';
            $tmp .= '<a href="functions-1-' . $item['id'] . '.html" class="c_3x2">';
            $tmp .= '<div class="img_chapter">';
            $tmp .= '<img src="' . $thumb . '" width="230" height="60"></div><span><h5>' . $item['title'] . '</h5>';
            $tmp .= '</span>';
            $tmp .= '</a>';
            $tmp .= '</div>';
            $categories[] = $tmp;

            // 生成对应的功能列表页面
            $functions = $this->db_function_list->listinfo(['market_id' => $item['id']], '', 1, 1000);
            $market_functions_template = $market_category_template;
            $arr_functions = [];
            foreach ($functions as $item1) {
                $thumb = substr($item1['thumb'], 1, strlen($item1['thumb']));
                $tmp  = '<div class="column grid_2 column_margin">';
                $tmp .= '<a href="functions-1-' . $item1['id'] . '.html" class="c_3x2">';
                $tmp .= '<div class="img_chapter">';
                $tmp .= '<img src="' . $thumb . '" width="230" height="60"></div><span><h5>' . $item1['title'] . '</h5>';
                $tmp .= '</span>';
                $tmp .= '</a>';
                $tmp .= '</div>';
                $arr_functions[] = $tmp;
            }
            $market_functions_template = preg_replace('/{category_list}/', implode('', $arr_functions), $market_functions_template);
            file_put_contents($output_path . 'functions-1-' . $item['id'] . '.html', $market_functions_template);
        }
        $market_category_template = preg_replace('/{category_list}/', implode('', $categories), $market_category_template);
        file_put_contents($output_path . 'functions-1.html', $market_category_template);

        // 功能
        $function_category_template = $category_template;
        $function_category_template = preg_replace('/{category_title}/', '功能', $function_category_template);
        $categories = [];
        foreach ($function_list as $item) {
            $thumb = substr($item['thumb'], 1, strlen($item['thumb']));
            $tmp  = '<div class="column grid_2 column_margin">';
            $tmp .= '<a href="functions-' . $item['id'] . '.html" class="c_3x2">';
            $tmp .= '<div class="img_chapter">';
            $tmp .= '<img src="' . $thumb . '" width="230" height="60"></div><span><h5>' . $item['title'] . '</h5>';
            $tmp .= '</span>';
            $tmp .= '</a>';
            $tmp .= '</div>';
            $categories[] = $tmp;
        }
        $function_category_template = preg_replace('/{category_list}/', implode('', $categories), $function_category_template);
        file_put_contents($output_path . 'functions.html', $function_category_template);

        // 系列
        $series_category_template = $category_template;
        $series_category_template = preg_replace('/{category_title}/', '系列', $series_category_template);
        $categories = [];
        foreach ($list as $item) {
            $tmp  = '<div class="column grid_2 column_margin">';
            $tmp .= '<a href="functions-2-' . $item['id'] . '.html" class="c_3x2">';
            $tmp .= '<span><h5>' . $item['title'] . '</h5></span>';
            $tmp .= '</a>';
            $tmp .= '</div>';
            $categories[] = $tmp;

            // 生成对应的功能列表页面
            $series = $this->db_function_list->listinfo(['series_id' => $item['id']], '', 1, 1000);
            $series_functions_template = $series_category_template;
            $arr_series = [];
            foreach ($series as $item1) {
                $tmp  = '<div class="column grid_2 column_margin">';
                $tmp .= '<a href="functions-2-' . $item1['id'] . '.html" class="c_3x2">';
                $tmp .= '<span><h5>' . $item1['title'] . '</h5>';
                $tmp .= '</span>';
                $tmp .= '</a>';
                $tmp .= '</div>';
                $arr_series[] = $tmp;
            }
            $series_functions_template = preg_replace('/{category_list}/', implode('', $arr_series), $series_functions_template);
            file_put_contents($output_path . 'functions-2-' . $item['id'] . '.html', $series_functions_template);
        }
        $series_category_template = preg_replace('/{category_list}/', implode('', $categories), $series_category_template);
        file_put_contents($output_path . 'functions-2.html', $series_category_template);

        // 把所有产品数据生成到一个JS变量中，并独立生成JS文件
        $products = $this->db->listinfo([], 'id DESC', 1, 1000000);
        $js_list_template = file_get_contents($usb_template_path . 'list.js');
        $js_list_template = preg_replace('/{products}/', json_encode($products), $js_list_template);
        $js_list_template = preg_replace('/{properties}/', json_encode($this->_product_props), $js_list_template);
        file_put_contents($output_path . 'list.js', $js_list_template);

        // 生成产品列表数据
        $list_template = file_get_contents($usb_template_path . 'list.html');
        $list_template = preg_replace('/{setting_title}/', $setting['title'], $list_template);
        $list_template = preg_replace('/{setting_content}/', $setting['description'], $list_template);
        $list_template = preg_replace('/{market_menus}/', implode('', $market_menus), $list_template);
        $list_template = preg_replace('/{function_menus}/', implode('', $function_menus), $list_template);
        $list_template = preg_replace('/{series_menus}/', implode('', $series_menus), $list_template);
        $list_filter = [];
        foreach ($this->_product_props as $kk => $props) {
            $tmp  = '<fieldset class="filter column grid_filter">';
            $tmp .= '<label>' . $props['title'] . '(' . count($props['options']) . ')</label>';
            $tmp .= '<select onchange="setSeFilter();" name="' . $kk . '" id="' . $kk . '" class="prodFinder" style="display: inline-block;">';
            $tmp .= '<option value="-"></option>';
            foreach ($props['options'] as $key => $option) {
                $tmp .= '<option value="' . $key . '">' . ($key . '  ' . $option) . '</option>';
            }
            $tmp .= '</select>';
            $tmp .= '</fieldset>';

            $list_filter[] = $tmp;
        }
        $list_template = preg_replace('/{list_filter}/', implode('', $list_filter), $list_template);
        file_put_contents($output_path . 'list.html', $list_template);

        echo 'ok';
    }
}
