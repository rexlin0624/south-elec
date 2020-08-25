<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class linkage_model extends model {
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'linkage';
		parent::__construct();
	}

	/**
     * 获取产品规格属性
     */
	public function product_props() {
        $arr_ids = [
            3360 => [
                'key' => 'front_shape',
                'title' => '前圈尺寸',
                'options' => []
            ],
            3368 => [
                'key' => 'front_button_material',
                'title' => '前圈/按键材料',
                'options' => []
            ],
            3372 => [
                'key' => 'front_button_shape',
                'title' => '前圈/按键形状',
                'options' => []
            ],
            3379 => [
                'key' => 'front_button_color',
                'title' => '前圈/按键颜色',
                'options' => []
            ],
            3388 => [
                'key' => 'switch_element',
                'title' => '开关元件',
                'options' => []
            ],
            3395 => [
                'key' => 'light_style',
                'title' => '照明形式',
                'options' => []
            ],
            3400 => [
                'key' => 'led_color',
                'title' => 'LED灯颜色',
                'options' => []
            ],
            3407 => [
                'key' => 'led_voltage',
                'title' => 'LED灯电压',
                'options' => []
            ],
            /*3414 => [
                'key' => 'front_magnetic',
                'title' => '前圈/磁',
                'options' => []
            ]*/
            3433 => [
                'key' => 'others',
                'title' => '军标',
                'options' => []
            ],
            3436 => [
                'key' => 'install_size',
                'title' => '安装尺寸',
                'options' => []
            ]
        ];
        $propids = implode(',', array_keys($arr_ids));
        $linkages = $this->listinfo('keyid IN(' . $propids . ')', 'listorder ASC', 1, 1000);

        $product_props = [];
        foreach ($arr_ids as $keyid => $props) {

            foreach ($linkages as $linkage) {
                if ($linkage['keyid'] != $keyid) {
                    continue;
                }
                if ($linkage['description'] == 'Z') {
                    continue;
                }

                $props['options'][$linkage['description']] = $linkage['name'];
            }

            $product_props[$props['key']] = [
                'title' => $props['title'],
                'options' => $props['options'],
            ];
        }

        return $product_props;
    }
}
