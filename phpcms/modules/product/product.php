<?php
set_time_limit(300);
defined('IN_PHPCMS') or exit('No permission resources.');
require_once __DIR__ . '/../../../vendor/autoload.php';
use Knp\Snappy\Pdf;

pc_base::load_app_class('admin','admin',0);

class product extends admin {
    private $db_setting, $db, $db_functions;
    private $_snappy;
    private $_product_props = null;

    public function __construct() {
        parent::__construct();

        require_once __DIR__ . '/../../../product_props.php';
        $this->_product_props = $product_props;

        $this->db_setting = pc_base::load_model('productions_setting_model');
        $this->db = pc_base::load_model('productions_model');

        $this->db_functions = pc_base::load_model('productions_functions_list_model');

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

        $functions = $this->db_functions->listinfo([], '', 1, 10);
        $product_props = $this->_product_props;
        $message = '';

        if (isset($_POST['product'])) {
            $id = (int)$_POST['product']['id'];
            unset($_POST['product']['id']);
            $product = $_POST['product'];
            if ($id > 0) {
                $this->db->update($product, ['id' => $id]);
            } else {
                $product['created_at'] = time();
                $id = $this->db->insert($product, true);
            }

            $pdf_path = $this->get_pdf_path($id);
            $pdf_content = $this->get_pdf_template();

            // generate pdf
            $this->_snappy->setOptions([
                'margin-left' => 0,
                'margin-top' => 0,
                'margin-right' => 0,
            ]);
            $this->_snappy->generateFromHtml($pdf_content, $pdf_path, [], true);

            echo 'success';
            exit;
        }

        if ($id > 0) {
            $info = $this->db->get_one(['id' => $id]);
        }

        include $this->admin_tpl('product_add');
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