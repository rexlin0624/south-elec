<?php
set_time_limit(300);
defined('IN_PHPCMS') or exit('No permission resources.');
require_once __DIR__ . '/../../../vendor/autoload.php';
use Knp\Snappy\Pdf;

pc_base::load_app_class('admin','admin',0);

class product extends admin {
    private $db_setting, $db, $db_functions, $db_series;
    private $_snappy;
    private $_product_props = null;

    public function __construct() {
        parent::__construct();

        require_once __DIR__ . '/../../../product_props.php';
        $this->_product_props = $product_props;

        $this->db_setting = pc_base::load_model('productions_setting_model');
        $this->db = pc_base::load_model('productions_model');

        $this->db_functions = pc_base::load_model('productions_functions_list_model');
        $this->db_series = pc_base::load_model('productions_series_list_model');

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
        $items = $this->db->listinfo([], '', 1, 10);
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

    public function add() {
        pc_base::load_sys_class('form','',0);
        $id = (int)$_GET['id'];
        $info = [];

        $product_props = $this->_product_props;

        if (isset($_POST['product'])) {
            $id = (int)$_POST['product']['id'];
            unset($_POST['product']['id']);
            $product = $_POST['product'];

            $function = $this->db_functions->get_one(['id' => $product['functions_id']]);

            // 产品编码组合
            // 规则：系列-{前圈尺寸}{前圈/按键材料}{前圈/按键形状}{前圈/按键颜色}.{开关元件}{照明形式}{LED灯颜色}{LED灯电压}.{前圈/磁}{序列号}
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
            $pdf_content = preg_replace('/{title}/', $code . ' - ' . $product['title'], $pdf_content);
            $pdf_content = preg_replace('/{description}/', $product['description'], $pdf_content);
            $pdf_content = preg_replace('/{thumb}/', 'http://' . $_SERVER['HTTP_HOST'] . $product['thumb'], $pdf_content);

            // 工程图
            $project_images = [];
            for ($i = 1;$i <= 4;$i++) {
                if (empty($product['project_image_' . $i])) {
                    continue;
                }
                $url = 'http://' . $_SERVER['HTTP_HOST'] . $product['project_image_' . $i];

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

//            $functions = $this->db_functions->listinfo([], '', 1, 10);
            $functions = [];
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
        $functions = $this->db_functions->listinfo(['series_id' => $series_id], '', 1, 10);

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
        pc_base::load_sys_class('form','',0);

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
}