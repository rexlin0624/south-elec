<?php
set_time_limit(300);
defined('IN_PHPCMS') or exit('No permission resources.');
require_once __DIR__ . '/../../../vendor/autoload.php';
use Knp\Snappy\Pdf;

pc_base::load_sys_func('dir');
pc_base::load_app_class('admin','admin',0);

class product extends admin {
    private $db_setting, $db, $db_market, $db_functions, $db_series, $db_linkage;
    private $db_market_setting, $db_function_setting, $db_series_setting, $db_site, $db_contact_setting, $db_queue;
    private $_snappy;
    private $_product_props = null;

    public function __construct() {
        parent::__construct();

        $this->db_site = pc_base::load_model('site_model');

        $this->db_linkage = pc_base::load_model('linkage_model');

        $this->db_setting = pc_base::load_model('productions_setting_model');
        $this->db = pc_base::load_model('productions_model');

        $this->db_market = pc_base::load_model('productions_market_list_model');
        $this->db_functions = pc_base::load_model('productions_functions_list_model');
        $this->db_series = pc_base::load_model('productions_series_list_model');

        $this->db_market_setting = pc_base::load_model('productions_market_model');
        $this->db_function_setting = pc_base::load_model('productions_functions_model');
        $this->db_series_setting = pc_base::load_model('productions_series_model');
        $this->db_contact_setting = pc_base::load_model('productions_contact_setting_model');

        $this->db_queue = pc_base::load_model('queues_model');

        $this->_snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
    }

    public function get_pdf_template() {
        $pdf_path = PC_PATH.'modules'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR.'pdf.template';
        return file_get_contents($pdf_path);
    }

    public function get_pdf_path($id) {
        $pdf_name = $id;
        return CACHE_PATH . 'pdf/' . $pdf_name . '.pdf';
    }

    public function config_list() {
		$page = $_GET['page'] ? $_GET['page'] : 1;
		$page = $page == 0 ? 1 : $page;
        $items = $this->db->listinfo([], 'id DESC', $page, 10);
        $functions = $this->db_functions->listinfo([], '', 1, 10);

        $map_func = [];
        foreach ($functions as $function) {
            $map_func[$function['id']] = $function['title'];
        }

        $infos = [];
        foreach ($items as $item) {
            $item['function'] = $map_func[$item['functions_id']];
            $infos[] = $item;
        }

        include $this->admin_tpl('product_list');
    }

    /**
     * 生成PDF
     */
    public function toPdf($id, $setting, $product_props, $product = false) {
        if (!$product) {
            $product = $this->db->get_one(['id' => $id]);
        }
        $code = $product['code'];

        $pdf_path = $this->get_pdf_path($id);
        $pdf_content = $this->get_pdf_template();
        $pdf_content = preg_replace('/{pdf_title}/', $setting['pdf_title'], $pdf_content);
        $pdf_content = preg_replace('/{pdf_desc}/', $setting['pdf_desc'], $pdf_content);
        $pdf_content = preg_replace('/{pdf_header_bgcolor}/', $setting['header_bgcolor'], $pdf_content);
        $pdf_content = preg_replace('/{title}/', $code . ' - ' . $product['title'], $pdf_content);
        $pdf_content = preg_replace('/{description}/', $product['description'], $pdf_content);
        $pdf_content = preg_replace('/{thumb}/', 'http://' . $_SERVER['HTTP_HOST'] . $product['thumb'], $pdf_content);

        // 工程图
        $project_images = [];
        for ($i = 1;$i <= 4;$i++) {
            $img = $product['project_image_' . $i];
            if (empty($img)) {
                continue;
            }

            // 把eps转为png图片
            if (!$product) {
                $eps_path = PHPCMS_PATH . substr($img, 1, strlen($img));
                $png_path = substr($eps_path, 0, -4) . '.png';
                $image = new Imagick();
                $image->setResolution(1200, 1200);
                $image->readimage($eps_path);
                $image->setBackgroundColor(new ImagickPixel('transparent'));
                $image->setImageFormat('png');
                $image->writeImage($png_path);
            }

            $url = 'http://' . $_SERVER['HTTP_HOST'] . substr($img, 0, -4) . '.png';
            $project_images[] = '<div style="overflow: hidden;page-break-after: always;"></div><div><img src="' . $url . '" /></div>';
        }
        $pdf_content = preg_replace('/{project_images}/', implode('', $project_images), $pdf_content);

        $prop_string = [];
        foreach ($product_props as $key => $prop) {
            $prop_string[] = '<li>' . $prop['title'] . '：' . $prop['options'][$product[$key]] . '</li>';
        }
        $pdf_content = preg_replace('/{props}/', implode('', $prop_string), $pdf_content);

        // generate pdf
        $this->_snappy->setOptions([
            'margin-left' => 0,
            'margin-top' => 0,
            'margin-right' => 0,
        ]);
        $this->_snappy->generateFromHtml($pdf_content, $pdf_path, [], true);
    }

    public function add() {
        pc_base::load_sys_class('form','',0);
        $id = (int)$_GET['id'];
        $info = [];

        $product_props = $this->db_linkage->product_props();

        if (isset($_POST['product'])) {
            $id = (int)$_POST['product']['id'];
            unset($_POST['product']['id']);
            $product = $_POST['product'];

            $function = $this->db_functions->get_one(['id' => $product['functions_id']]);

            // 产品编码组合
            // 规则：系列-{前圈尺寸}{前圈/按键材料}{前圈/按键形状}{前圈/按键颜色}.{开关元件}{照明形式}{LED灯颜色}{LED灯电压}.{其它}
            $series = $this->db_series->get_one(['id' => $function['series_id']]);
            $code  = $series['title'] . '-' . $product['front_shape'] . $product['front_button_material'] . $product['front_button_shape'] . $product['front_button_color'];
            $code .= '.' . $product['switch_element'] . $product['light_style'] . $product['led_color'] . $product['led_voltage'] . '.' . $product['front_magnetic'];
            $product['code'] = $code;

            if ($id > 0) {
                $this->db->update($product, ['id' => $id]);
            } else {
                $product['created_at'] = time();
                $id = $this->db->insert($product, true);
            }

            $setting = $this->db_setting->get_one(['id' => 1]);

            $pdf_path = $this->get_pdf_path($id);
            $pdf_content = $this->get_pdf_template();
            $pdf_content = preg_replace('/{pdf_title}/', $setting['pdf_title'], $pdf_content);
            $pdf_content = preg_replace('/{pdf_desc}/', $setting['pdf_desc'], $pdf_content);
            $pdf_content = preg_replace('/{pdf_header_bgcolor}/', $setting['header_bgcolor'], $pdf_content);
            $pdf_content = preg_replace('/{title}/', $code . ' - ' . $product['title'], $pdf_content);
            $pdf_content = preg_replace('/{description}/', $product['description'], $pdf_content);
            $pdf_content = preg_replace('/{thumb}/', 'http://' . $_SERVER['HTTP_HOST'] . $product['thumb'], $pdf_content);

            // 工程图
            $project_images = [];
            for ($i = 1;$i <= 4;$i++) {
                $img = $product['project_image_' . $i];
                if (empty($img)) {
                    continue;
                }

                // 把eps转为png图片
                $eps_path = PHPCMS_PATH . substr($img, 1, strlen($img));
                $png_path = substr($eps_path, 0, -4) . '.png';
                $image = new Imagick();
                $image->setResolution(1200, 1200);
                $image->readimage($eps_path);
                $image->setBackgroundColor(new ImagickPixel('transparent'));
                $image->setImageFormat('png');
                $image->writeImage($png_path);

                $url = 'http://' . $_SERVER['HTTP_HOST'] . substr($img, 0, -4) . '.png';
                $project_images[] = '<div style="overflow: hidden;page-break-after: always;"></div><div><img src="' . $url . '" /></div>';
            }
            $pdf_content = preg_replace('/{project_images}/', implode('', $project_images), $pdf_content);

            $prop_string = [];
            foreach ($product_props as $key => $prop) {
                $prop_string[] = '<li>' . $prop['title'] . '：' . $prop['options'][$product[$key]] . '</li>';
            }
            $pdf_content = preg_replace('/{props}/', implode('', $prop_string), $pdf_content);

            // generate pdf
            $this->_snappy->setOptions([
                'margin-left' => 0,
                'margin-top' => 0,
                'margin-right' => 0,
            ]);
            $this->_snappy->generateFromHtml($pdf_content, $pdf_path, [], true);

            echo 'success';
            exit;
        } else {
            $series = $this->db_series->listinfo([], '', 1, 100);

            $functions = $this->db_functions->listinfo([], '', 1, 100);
            $message = '';
        }

        if ($id > 0) {
            $info = $this->db->get_one(['id' => $id]);
        }

        include $this->admin_tpl('product_add');
    }

    public function get_functions_by_series_id()
    {
        $series_id = (int)$_GET['series_id'];
        $where = 'series_id LIKE \'%,' . $series_id . ',%\'';
        $functions = $this->db_functions->listinfo($where, '', 1, 10);

        echo json_encode($functions);
        exit;
    }

    public function delete()
    {
        $id = (int)$_GET['id'];
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->delete(['id' => $id]);

        // remove pdf
        $pdf_path = $this->get_pdf_path($id);
        @unlink($pdf_path);

        showmessage('删除成功', HTTP_REFERER);
    }

    public function setting() {
        pc_base::load_sys_class('form', '', 0);

        if (isset($_POST['product'])) {
            $id = (int)$_POST['product']['id'];
            unset($_POST['product']['id']);
            $product = $_POST['product'];

            if ($id > 0) {
                $this->db_setting->update($product, ['id' => $id]);
            } else {
                $product['created_at'] = time();

                $this->db_setting->insert($product, true);
            }
            showmessage('配置成功', HTTP_REFERER);
        } else {
            $info = $this->db_setting->get_one(['id' => 1]);
        }

        include $this->admin_tpl('product_setting');
    }

    /**
     * 生成离线版本
     */
    public function generate_offline() {
        if (isset($_POST['generate'])) {
            $zip_name = '华南电子网_' . date('YmdHis');

            $usb_template_path = PHPCMS_PATH . 'usb' . DIRECTORY_SEPARATOR;
            $output_path = CACHE_PATH . 'offline/' . $zip_name . DIRECTORY_SEPARATOR;
            if (!is_dir($output_path)) {
                mkdir($output_path);
            }

            /*
             * 复制JS和CSS文件
             */
            dir_copy($usb_template_path . 'statics', $output_path . 'statics');
            dir_copy(PHPCMS_PATH . 'uploadfile', $output_path . 'uploadfile');

            $this->db_setting = pc_base::load_model('productions_setting_model');
            $setting = $this->db_setting->get_one(['id' => 1]);
            $index_template = file_get_contents($usb_template_path . 'index.html');

            /*
             * 网站LOGO
             */
            $site = $this->db_site->get_one(['siteid' => 1]);
            $settings = string2array($site['setting']);
            $logo = substr($settings['logo'], 1, strlen($settings['logo']));
            $index_template = preg_replace('/{logo}/', $logo, $index_template);

            /*
             * 生成首页数据：市场分类、功能分类、系列分类、配置数据
             */
            $index_template = preg_replace('/{setting_title}/', $setting['title'], $index_template);
            $index_template = preg_replace('/{setting_content}/', $setting['description'], $index_template);

            // 市场
            $market_setting = $this->db_market_setting->get_one(['id' => 1]);
            $market_list = $this->db_market->listinfo([], '', 1, 100);
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
            $function_list = $this->db_functions->listinfo([], '', 1, 100);
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
            $list = $this->db_series->listinfo([], '', 1, 100);
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
            $category_template = preg_replace('/{logo}/', $logo, $category_template);
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
                $fids = $item['functions'];
                $functions = $this->db_functions->listinfo('id IN(' . $fids . ')', '', 1, 1000);
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

                $sql = 'SELECT DISTINCT functions_id FROM `se_productions` WHERE series_id = ' . $item['id'];
                $query = $this->db->query($sql);
                $rows = $this->db->fetch_array();
                $functions_ids = [];
                foreach ($rows as $row) {
                    $functions_ids[] = $row['functions_id'];
                }

                // 生成对应的功能列表页面
                $where = 'id IN(' . implode(',', $functions_ids) . ')';
                $series = $this->db_functions->listinfo($where, '', 1, 1000);
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
             * 转移css
             */
            $modal_css = file_get_contents($usb_template_path . 'modal.css');
            file_put_contents($output_path . 'modal.css', $modal_css);

            /*
             * 产品配置器列表页
             */
            // 获取工程师联系方式
            $contacts = $this->db_contact_setting->get_one(['id' => 1]);
            $contact_info = '联系电话：' . $contacts['telephone'] . '<br />QQ：' . $contacts['qq'] . '<br />微信：' . $contacts['wechat'] . '<br />邮箱：' . $contacts['email'];

            $list_template = file_get_contents($usb_template_path . 'list.html');
            $list_template = preg_replace('/{setting_title}/', $setting['title'], $list_template);
            $list_template = preg_replace('/{logo}/', $logo, $list_template);
            $list_template = preg_replace('/{setting_content}/', $setting['description'], $list_template);
            $list_template = preg_replace('/{market_menus}/', implode('', $market_menus), $list_template);
            $list_template = preg_replace('/{function_menus}/', implode('', $function_menus), $list_template);
            $list_template = preg_replace('/{series_menus}/', implode('', $series_menus), $list_template);
            $list_template = preg_replace('/{contact-enginer-info}/', $contact_info, $list_template);
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

            /*
             * zip offline
             */
            $zip_path = CACHE_PATH . 'offline/' . $zip_name . '.zip';
            dir_zip($output_path, $zip_path, $output_path);

            // 删除临时文件夹
            dir_delete($output_path);

            echo $zip_name;
            exit;
        }
        include $this->admin_tpl('product_generate_offline');
    }

    /**
     * 下载离线版本
     */
    public function download_offline() {
        $filename = trim($_GET['file']) . '.zip';
        $file_path = CACHE_PATH . 'offline/' . $filename;
        $fileHandle = fopen($file_path,"rb");

        header('Content-type:application/octet-stream; charset=utf-8');
        header("Content-Transfer-Encoding: binary");
        header("Accept-Ranges: bytes");
        header("Content-Length: " . filesize($file_path));
        header('Content-Disposition:attachment;filename="' . urlencode($filename) . '"');
        while(!feof($fileHandle)) {
            echo fread($fileHandle, 10240);
        }
        fclose($fileHandle);
    }

    /**
     * 联系工程师
     */
    public function contact() {
        pc_base::load_sys_class('form', '', 0);

        if (isset($_POST['contact'])) {
            $id = (int)$_POST['contact']['id'];
            unset($_POST['contact']['id']);
            $product = $_POST['contact'];

            if ($id > 0) {
                $this->db_contact_setting->update($product, ['id' => $id]);
            } else {
                $product['created_at'] = time();

                $this->db_contact_setting->insert($product, true);
            }
            showmessage('配置成功', HTTP_REFERER);
        } else {
            $info = $this->db_contact_setting->get_one(['id' => 1]);
        }

        include $this->admin_tpl('product_contact_setting');
    }

    public static function encode_cn($txt) {
        if (is_object($txt)) {
            $txt = $txt->__toString();
        }

        return $txt;
    }

    /**
     * 获取属性编码值
     * @param $propid
     * @param $prop_value
     * @param $linkages
     * @return string
     */
    private function _get_property($propid, $prop_value, $linkages) {
        $prop_key = '';
        foreach ($linkages as $linkage) {
            if ($linkage['keyid'] != $propid) {
                continue;
            }

            if ($linkage['name'] == $prop_value) {
                $prop_key = $linkage['description'];
                break;
            }
        }

        return $prop_key;
    }

    private function _unzip($extractTo) {
        $zip = new ZipArchive();
        $oldmask = umask(0);
        mkdir($extractTo, 0777);
        umask($oldmask);

        // 解压zip
        $filename = $_FILES["file"]["tmp_name"];
        $flag = $zip->open($filename);
        if($flag !== true){
            echo "解压zip失败: {$flag}\n";
            exit();
        }
        $zip->extractTo($extractTo);
        $zip->close();
    }

    private function _ce($prop) {
        return !empty($prop) ? $prop : '-';
    }
    /**
     * 生成产品编码
     * 规则：系列-{前圈尺寸}{前圈/按键材料}{前圈/按键形状}{前圈/按键颜色}.{开关元件}{照明形式}{LED灯颜色}{LED灯电压}.{其它}
     */
    private function _generateCode($row) {
        return $row[0] . '-' . 
            $this->_ce($row[1]) . $this->_ce($row[2]) . $this->_ce($row[3]) . $this->_ce($row[4]) . '.' . 
            $this->_ce($row[5]) . $this->_ce($row[6]) . $this->_ce($row[7]) . $this->_ce($row[8]) . '.' .
            $this->_ce($row[9]);
    }

    /**
     * 导入
     */
    public function import() {
        ini_set('memory_limit', '-1');
        $time = time();
        $pc_hash = $_POST['pc_hash'];

        // 获取产品数据表中最大的产品ID
        $product = $this->db->get_one('', 'id', 'id DESC');
        $lastId = $product['id'] ? $product['id'] : 0;

        $unzipPath = PHPCMS_PATH . 'uploadfile/zip/' . date('YmdHis') . mt_rand(100, 999) . '/';
        $this->_unzip($unzipPath);
        $filename = $unzipPath . 'data.xls';
        $importPath = explode('uploadfile', $unzipPath)[1];
        
        require(PC_PATH . 'libs/classes/Classes/PHPExcel/IOFactory.php');
        $fileType = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load($filename);
        $sheet = $objPHPExcel->getSheet(0);

        $highestRowNum = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnNum = PHPExcel_Cell::columnIndexFromString($highestColumn);

        $functions = $this->db_functions->listinfo([], '', 1, 100);
        $mapFunction = [];
        foreach ($functions as $item) {
            $mapFunction[$item['code']] = $item['title'];
        }

        $mapSeriesId = [
            '4.0' => 6,
            '5.0' => 7,
            '6.0' => 8
        ];

        $mapIndexProp = [
            0 => 'series_id',
            1 => 'front_shape',
            2 => 'front_button_material',
            3 => 'front_button_shape',
            4 => 'front_button_color',
            5 => 'switch_element',
            6 => 'light_style',
            7 => 'led_color',
            8 => 'led_voltage',
            9 => 'others',
            10 => 'functions_id',
            11 => 'install_size',
            12 => 'description',
            21 => 'title',
            23 => 'project_image_1',
            24 => 'project_image_2',
            25 => 'project_image_3',
            26 => 'thumb'
        ];

        $data = [];
        $values = [];
        for($i = 3; $i <= $highestRowNum; $i++) {
            if ($i >= 10) {
                // break;
            }

            $rowDef = [];
            $row = [];
            $series = '';
            // 遍历每一行数据
            for($j = 0; $j < $highestColumnNum; $j++) {
                $idx = isset($mapIndexProp[$j]) ? $mapIndexProp[$j] : $j;
                if (is_numeric($idx)) {
                    continue;
                }
                $cellName = PHPExcel_Cell::stringFromColumnIndex($j) . $i;
                $cellVal = $sheet->getCell($cellName)->getValue();
                $encode = self::encode_cn($cellVal);
                $rowDef[] = $encode;

                if ($idx == 'series_id') {
                    $series = $encode;
                    $encode = $mapSeriesId[$encode];
                }
                if (empty($series)) {
                    continue;
                }
                if ($idx == 'functions_id') {
                    // $encode = $mapFunction[$encode];
                }

                if (!empty($encode)) {                
                    if ($idx == 'project_image_1') {
                        $encode = '/uploadfile' . $importPath . $series . '/' . $encode . '.jpg';
                    }
                    if ($idx == 'project_image_2') {
                        $encode = '/uploadfile' . $importPath . $series . '/' . $encode . '.jpg';
                    }
                    if ($idx == 'project_image_3') {
                        $encode = '/uploadfile' . $importPath . $series . '/' . $encode . '.jpg';
                    }
                    if ($idx == 'thumb') {
                        $encode = '/uploadfile' . $importPath . $series . '/' . $encode . '.jpg';
                    }
                }

                $row[$idx] = $encode;
            }

            if (!empty($row)) {
                $data[] = $row;
                $code = $this->_generateCode($rowDef);
                $values[] = '(\'' . $code . '\', \'' . implode('\',\'', $row) . '\', '. $time .')';
            }
        }
        // echo '<pre>';
        // var_export($data);
        if (empty($data)) {
            echo 'Excel数据为空！！！';
            exit;
        }

        // echo '<pre>';
        // var_export($data);
        // 组装插入sql
        $fields = '`code`,`' . implode('`,`', array_values($mapIndexProp)) . '`,`created_at`';
        $sql = 'INSERT INTO se_productions (' . $fields . ') VALUES ' . implode(',', $values);
        $this->db->query($sql);

        // 生成pdf，插入队列中，运行bash脚本异步处理
        // 获取生成的产品ID
        $productIds = $this->db->listinfo('id > ' . $lastId, '', 1, 100000);
        $product_props = $this->db_linkage->product_props();
        $setting = $this->db_setting->get_one(['id' => 1]);
        $values = [];
        foreach ($productIds as $prod) {
            $values[] = '(' . $prod['id'] . ', 0, ' . $time . ', ' . $time . ')';
            // $this->toPdf($prod['id'], $setting, $product_props, $prod);
        }
        $sql = 'INSERT INTO se_queues(`product_id`, `status`, `created_at`, `updated_at`) VALUES ' . implode(',', $values);
        $this->db_queue->query($sql);

        echo '导入成功！<a href="/index.php?m=product&c=product&a=config_list&menuid=1604&pc_hash=' . $pc_hash . '">返回列表</a>';
    }
}
