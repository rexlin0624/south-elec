<?php
defined('IN_PHPCMS') or exit('No permission resources.');

//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
pc_base::load_sys_func('dir');
pc_base::load_sys_class('form', '', '');
class index {
	private $db, $db_setting, $db_market_setting, $db_function_setting, $db_series_setting;
	private $db_market_list, $db_function_list, $db_series_list, $db_contact_setting, $db_linkage;

	const MARKET = 1;
    const SERIES = 2;
    
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

	private $_product_props = null;
	private $_filter_params = [];

	function __construct() {
		$this->db = pc_base::load_model('productions_model');
		$this->db_setting = pc_base::load_model('productions_setting_model');

		$this->db_market_setting = pc_base::load_model('productions_market_model');
		$this->db_function_setting = pc_base::load_model('productions_functions_model');
		$this->db_series_setting = pc_base::load_model('productions_series_model');

		$this->db_market_list = pc_base::load_model('productions_market_list_model');
		$this->db_function_list = pc_base::load_model('productions_functions_list_model');
		$this->db_series_list = pc_base::load_model('productions_series_list_model');
        $this->db_contact_setting = pc_base::load_model('productions_contact_setting_model');

        $this->db_linkage = pc_base::load_model('linkage_model');

		$this->_product_props = $this->db_linkage->product_props();;
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
        $id = isset($_GET['id']) ? (int)$_GET['id'] : -1000;
        $setting = $this->db_setting->get_one(['id' => 1]);

        if (empty($type) && $id == -1000) {
            $title = '功能';
            $lists = $this->db_function_list->listinfo([], '', 1, 1000);
        } else {
            if ($type == self::MARKET) {
                $item = $this->db_market_list->get_one(['id' => $id]);
                $title = $item['title'];

                $id = -1000;
                $where = 'id IN(' . $item['functions'] . ')';
                $lists = $this->db_function_list->listinfo($where, '', 1, 1000);
            } elseif ($type == self::SERIES) {
                $item = $this->db_series_list->get_one(['id' => $id]);
                $title = $item['title'];

                $sql = 'SELECT DISTINCT functions_id FROM `se_productions` WHERE series_id = ' . $id;
                $query = $this->db->query($sql);
                $rows = $this->db->fetch_array();
                $functions_ids = [];
                foreach ($rows as $row) {
                    $functions_ids[] = $row['functions_id'];
                }

                $where = '`code` IN(' . implode(',', $functions_ids) . ')';
                $lists = $this->db_function_list->listinfo($where, '', 1, 1000);
            }
        }

        include template('product', 'functions');
    }

    private function _c($param) {
	    return isset($this->_filter_params[$param]) ? $this->_filter_params[$param] : 'X';
    }

    public function lists() {
        $functions_id = (int)$_GET['functions_id'];
        $series_id = (int)$_GET['series_id'];
        $setting = $this->db_setting->get_one(['id' => 1]);
        $contacts = $this->db_contact_setting->get_one(['id' => 1]);
        $props = $this->_product_props;
        $page = (int)$_GET['page'];
        $page = $page > 1 ? $page : 1;
        
        // $where = 'functions_id = ' . $functions_id;
        $where = '1 = 1';
        $function = $this->db_function_list->get_one(['id' => $functions_id]);

        $props_total = [];
        foreach ($props as $k => $v) {
            $ww = $where . ' AND ' . $k . ' IN(\'' . implode('\',\'', array_keys($v['options'])) . '\')';
            $props_total[$k] = $this->db->count($ww);
        }

        $serials = $this->db_series_list->listinfo();

        $series_info = $this->db_series_list->get_one(['id' => $series_id]);
        $se = $series_info['title'];

        $filter = $_GET;
        unset($filter['siteid']);
        unset($filter['m']);
        unset($filter['c']);
        unset($filter['a']);
        $condition = [];
        $is_display_contact = 'none';
        if (!empty($filter)) {
            foreach ($filter as $field => $flt) {
                if ($flt == self::EMPTY) {
                    continue;
                }
                if ($field == 'serial_id') {
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
            $where .= ' AND (' . implode(' AND ', $condition) . ')';
        }

        $function_info = $this->db_function_list->get_one(['id' => $functions_id]);

        $contact_info = '联系电话：' . $contacts['telephone'] . '<br />QQ：' . $contacts['qq'] . '<br />微信：' . $contacts['wechat'] . '<br />邮箱：' . $contacts['email'];

        $total = $this->db->count($where);
        $lists = $this->db->listinfo($where, 'id DESC', $page, 10);
        $pages = $this->db->pages;

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

                if (in_array($val, $search[$sch])) {
                    continue;
                }
                if (!isset($search[$sch])) {
                    $search[$sch] = [];
                }

                $search[$sch][] = $val;
            }
        }
        // var_export($search);

        // 规则：系列-{前圈尺寸}{前圈/按键材料}{前圈/按键形状}{前圈/按键颜色}.{开关元件}{照明形式}{LED灯颜色}{LED灯电压}.{前圈/磁}{序列号}
        $this->_filter_params = $filter;
        $code  = $se . '-';
        $code .= $this->_c('front_shape') . $this->_c('front_button_material') . $this->_c('front_button_shape') . $this->_c('front_button_color');
        $code .= '.' . $this->_c('switch_element') . $this->_c('light_style') . $this->_c('led_color') . $this->_c('led_voltage');
        $code .= '.' . $this->_c('front_magnetic');

        include template('product', 'lists');
    }

    public function show() {
	    $id = (int)$_GET['id'];
        $setting = $this->db_setting->get_one(['id' => 1]);
        $props = $this->_product_props;

        $item = $this->db->get_one(['id' => $id]);

        $series_title = self::$_map_series_id_title[$item['series_id']];

        $g = (int)$_GET['g'];
        if ($g == 0) {
            $item['code'] = str_replace('J', '-', $item['code']);
        }

        include template('product', 'show');
    }

    /**
     *
     */
    public function generate_usb_version() {
	    $usb_template_path = PHPCMS_PATH . 'usb' . DIRECTORY_SEPARATOR;
	    $output_path = PHPCMS_PATH . 'usb_output' . DIRECTORY_SEPARATOR;

	    /*
	     * 复制JS和CSS文件
	     */
        dir_copy($usb_template_path . 'statics', $output_path . 'statics');
        dir_copy(PHPCMS_PATH . 'uploadfile', $output_path . 'uploadfile');

        /*
         * 生成首页数据：市场分类、功能分类、系列分类、配置数据
         */
        $this->db_setting = pc_base::load_model('productions_setting_model');
        $setting = $this->db_setting->get_one(['id' => 1]);
        $index_template = file_get_contents($usb_template_path . 'index.html');

        $index_template = preg_replace('/{setting_title}/', $setting['title'], $index_template);
        $index_template = preg_replace('/{setting_content}/', $setting['description'], $index_template);

        // 市场
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

        /*
         * 生成二级页面数据
         */
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
                $tmp .= '<a href="list.html?fid=' . $item1['id'] . '" class="c_3x2">';
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
            $tmp .= '<a href="list.html?fid=' . $item['id'] . '" class="c_3x2">';
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
                $tmp .= '<a href="list.html?fid=' . $item1['id'] . '" class="c_3x2">';
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

        /*
         * 把所有产品数据生成到一个JS变量中，并独立生成JS文件
         */
        $products = $this->db->listinfo([], 'id DESC', 1, 1000000);
        $js_list_template = file_get_contents($usb_template_path . 'list.js');
        $js_list_template = preg_replace('/{products}/', json_encode($products), $js_list_template);
        $js_list_template = preg_replace('/{properties}/', json_encode($this->_product_props), $js_list_template);
        file_put_contents($output_path . 'list.js', $js_list_template);

        /*
         * 产品配置器列表页
         */
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

        /*
         * 产品配置器详情页
         */
        $show_template = file_get_contents($usb_template_path . 'show.html');
        $show_template = preg_replace('/{setting_title}/', $setting['title'], $show_template);
        $show_template = preg_replace('/{setting_content}/', $setting['description'], $show_template);
        $show_template = preg_replace('/{market_menus}/', implode('', $market_menus), $show_template);
        $show_template = preg_replace('/{function_menus}/', implode('', $function_menus), $show_template);
        $show_template = preg_replace('/{series_menus}/', implode('', $series_menus), $show_template);
        foreach ($products as $product) {
            $show_template_tmp = $show_template;
            $product_id = $product['id'];

            // 产品属性
            $show_props = [];
            foreach ($this->_product_props as $kk => $props) {
                $tmp  = '<tr style="line-height: 30px;">';
                $tmp .= '<td>' . $props['title'] . '</td>';
                $tmp .= '<td class="right">' . $props['options'][$product[$kk]] . '</td>';
                $tmp .= '</tr>';

                $show_props[] = $tmp;
            }
            $show_template_tmp = preg_replace('/{title}/', $product['title'], $show_template_tmp);
            $show_template_tmp = preg_replace('/{thumb}/', substr($product['thumb'], 1, strlen($product['thumb'])), $show_template_tmp);
            $show_template_tmp = preg_replace('/{props_list}/', implode('', $show_props), $show_template_tmp);

            // 工程图
            $project_images = [];
            for ($p = 1;$p <= 4;$p++) {
                $proj_img = $product['project_image_' . $p];
                if (empty($proj_img)) {
                    continue;
                }
                $proj_img = substr($proj_img, 1, strlen($proj_img));
                $project_images[] = '<a href="' . $proj_img . '" target="_blank">工程图' . $p . ' (eps)</a>';
            }
            $show_template_tmp = preg_replace('/{project_images}/', implode('', $project_images), $show_template_tmp);
            $show_template_tmp = preg_replace('/{pdf_name}/', $product_id, $show_template_tmp);

            file_put_contents($output_path . 'show-' . $product_id . '.html', $show_template_tmp);
        }

        // 复制PDF到USB版本目录下
        dir_copy(CACHE_PATH . 'pdf', $output_path . 'pdf');

        echo 'ok';
    }
}
