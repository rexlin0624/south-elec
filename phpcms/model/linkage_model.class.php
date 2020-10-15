<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class linkage_model extends model {
    private static $_map_title = [
        'front_shape' => [
            'title' => '前圈尺寸',
            'options' => [],
        ],
        'front_button_material' => [
            'title' => '前圈/按键材料',
            'options' => [],
        ],
        'front_button_shape' => [
            'title' => '前圈/按键形状',
            'options' => [],
        ],
        'front_button_color' => [
            'title' => '前圈/按键颜色',
            'options' => [],
        ],
        'switch_element' => [
            'title' => '开关元件',
            'options' => [],
        ],
        'light_style' => [
            'title' => '照明形式',
            'options' => [],
        ],
        'led_color' => [
            'title' => '灯罩/LED灯颜色',
            'options' => [],
        ],
        'led_voltage' => [
            'title' => 'LED灯电压',
            'options' => [],
        ],
        'military_standard' => [
            'title' => '军标',
            'options' => [],
        ],
        'install_size' => [
            'title' => '安装尺寸',
            'options' => [],
        ],
    ];

    private static $_cache_key = 'product_props';

	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'linkage';
		parent::__construct();
	}

	private static function _product_title_to_key($title) {
	    $key = '';
	    $map_title = self::$_map_title;
	    foreach ($map_title as $k => $item) {
	        if ($title == $item['title']) {
	            $key = $k;
	            break;
            }
        }

	    return $key;
    }

	/**
     * 获取产品规格属性
     */
	public function product_props() {
	    $cacheFile = CACHE_PATH . self::$_cache_key;

	    if (file_exists($cacheFile)) {
	        return json_decode(file_get_contents($cacheFile), true);
        }

	    $map_serial = [
            3456 => '4.0',
            3457 => '5.0',
            3458 => '6.0',
        ];
        $linkages = $this->listinfo('keyid IN(' . implode(',', array_keys($map_serial)) . ') AND parentid = 0', 'listorder ASC', 1, 1000);

        $product_props = [];
        foreach ($linkages as $item) {
            $product_key = self::_product_title_to_key($item['name']);
            if (empty($product_key)) {
                continue;
            }

            $opts = $this->listinfo('parentid = ' . $item['linkageid'], 'listorder ASC, linkageid ASC', 1, 100);
            $options = [];
            foreach ($opts as $opt) {
                $options[$opt['description']] = $opt['name'];
            }

            $serial = $map_serial[$item['keyid']];
            $product_props[$serial][$product_key] = [
                'title' => $item['name'],
                'options' => $options
            ];
        }

        file_put_contents($cacheFile, json_encode($product_props, JSON_UNESCAPED_UNICODE));

        return $product_props;
    }
}
