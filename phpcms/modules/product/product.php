<?php
set_time_limit(300);
defined('IN_PHPCMS') or exit('No permission resources.');
require_once __DIR__ . '/../../../vendor/autoload.php';
use Knp\Snappy\Pdf;

pc_base::load_app_class('admin','admin',0);

class product extends admin {
    private $db_setting, $db, $db_functions;

    private static $_product_props = [
        // 前圈尺寸
        'front_shape' => [
            'title' => '前圈尺寸',
            'options' => [
                'A' => '12mm 圆形',
                'B' => '16mm 圆形',
                '1' => '24mm 圆形',
                '2' => '24mm 方形',
                '3' => '22mm 圆形',
                '4' => '20mm 圆形',
                'Z' => '定制',
            ],
        ],
        // 前圈/按钮材料
        'front_button_material' => [
            'title' => '前圈/按钮材料',
            'options' => [
                'A' => '12mm 圆形',
                'B' => '16mm 圆形',
                '1' => '24mm 圆形',
                '2' => '24mm 方形',
                '3' => '22mm 圆形',
                '4' => '20mm 圆形',
                'Z' => '定制',
            ],
        ],
        // 前圈/按钮形状
        'front_button_shape' => [
            'title' => '前圈/按钮形状',
            'options' => [
                'A' => '平面/平面（12mm开关)',
                'B' => '平面/平面 (16mm开关)',
                '1' => '凹面/凸弧面',
                '2' => '凹面/凸弧面',
                '3' => '平面/凸弧面',
                'Z' => '定制',
            ]
        ],
        // 前圈/按钮颜色
        'front_button_color' => [
            'title' => '前圈/按钮颜色',
            'options' => [
                '1' => '哑光（不锈钢）',
                '2' => '金色（不锈钢）',
                '3' => '黑色（不锈钢）',
                '4' => '自然色 (铝）',
                '5' => '红色 (铝）',
                '6' => '黄色 (铝）',
                '7' => '绿色 (铝）',
                'Z' => '定制',
            ],
        ],
        // 开关元件
        'switch_element' => [
            'title' => '开关元件',
            'options' => [
                '0' => '指示灯',
                '1' => '瞬时 1 NO / 1 NC ( 5.0系列 3 NO / 3 NC)',
                '2' => '自锁 1 NO / 1 NC ( 5.0系列 3 NO / 3 NC)',
                '3' => '瞬时 3 NO / 3 NC',
                '4' => '自锁 3 NO / 3 NC',
                'Z' => '定制',
            ],
        ],
        // 照明形式
        'light_style' => [
            'title' => '照明形式',
            'options' => [
                '1' => '环形照明',
                '2' => '点照明',
                '3' => '无照明',
                'Z' => '定制',
            ]
        ],
        // LED灯颜色
        'led_color' => [
            'title' => 'LED灯颜色',
            'options' => [
                '0' => '无',
                '1' => '红色',
                '2' => '黄色',
                '3' => '绿色',
                '4' => '白色',
                'Z' => '定制',
            ]
        ],
        // LED灯电压
        'led_voltage' => [
            'title' => 'LED灯电压',
            'options' => [
                '0' => '无',
                '1' => '6V',
                '2' => '24V',
                '3' => '110V',
                '4' => '230V',
                'Z' => '定制',
            ]
        ],
        // 前圈/磁
        'front_magnetic' => [
            'title' => '前圈/磁',
            'options' => [
                'A' => 'Ø 8',
                'B' => 'Ø 12',
                'C' => 'Ø 19',
                'D' => 'Ø 22',
                'M' => '磁场灭弧',
            ],
        ],
    ];
    private $_snappy;

    public function __construct() {
        parent::__construct();

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
        $product_props = self::$_product_props;
        $message = '';

        if (isset($_POST['product'])) {
            $id = (int)$_POST['product']['id'];
            unset($_POST['product']['id']);
            $product = $_POST['product'];
            if ($id > 0) {
                $this->db->update($product, ['id' => $id]);
                $message = '修改成功';
            } else {
                $series['created_at'] = time();
                $id = $this->db->insert($series, true);
                $message = '添加成功';
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

            showmessage($message, '?m=product&c=product&a=config_list');
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