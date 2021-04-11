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
    private static $_cache_key_en = 'product_props_en';

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

    public function product_props_en() {
	    $props = array (
            '6.0' =>
                array (
                    'front_shape' =>
                        array (
                            'title' => 'Front ring Dim',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => '38mm round',
                                    2 => '32mm round',
                                    3 => '30mm round',
                                    'A' => '36mm handwheel',
                                    'B' => '36mm cone',
                                    'C' => '28mm cylindrical',
                                ),
                        ),
                    'front_button_material' =>
                        array (
                            'title' => 'Front ring/button material',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => 'SUS',
                                    2 => 'Aluminium alloy',
                                    3 => 'Plastic',
                                ),
                        ),
                    'front_button_shape' =>
                        array (
                            'title' => 'Front ring/button shape',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => 'convex/convex',
                                    2 => 'concave/convex',
                                    'A' => '60mm Umbelliform surface',
                                    'B' => '45mm Conical surface',
                                    'C' => '60mm legend  panel',
                                ),
                        ),
                    'front_button_color' =>
                        array (
                            'title' => 'Front ring/button colour',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => 'Natural（SUS）',
                                    4 => 'Natural（AL）',
                                    5 => 'grey（Plastic）',
                                    6 => 'Aluminium alloy（Yellow）',
                                    7 => 'Plastic（Yellow）',
                                ),
                        ),
                    'switch_element' =>
                        array (
                            'title' => 'Switch function',
                            'options' =>
                                array (
                                    0 => 'Indicator',
                                    1 => 'momentary，1 NO/1 NC',
                                    2 => 'Maintained，1 NO/1 NC',
                                    3 => 'momentary，2 NO',
                                    4 => 'maintained，2 NC',
                                    5 => 'momentary，2 NC',
                                    6 => 'maintained，2 NC',
                                ),
                        ),
                    'light_style' =>
                        array (
                            'title' => 'illuminated',
                            'options' =>
                                array (
                                    0 => 'Full illuminated',
                                    1 => 'Ring illuminated',
                                    2 => 'Dot illuminated',
                                    3 => 'Non illuminated',
                                    4 => 'pattern illuminated（E-stop Pushbutton）',
                                ),
                        ),
                    'led_color' =>
                        array (
                            'title' => 'LED Color',
                            'options' =>
                                array (
                                    0 => 'Non LED',
                                    1 => 'Red',
                                    2 => 'Yellow',
                                    3 => 'Green',
                                    4 => 'white',
                                    5 => 'blue',
                                    6 => 'Red+Green',
                                    7 => 'Natural（Metal）',
                                ),
                        ),
                    'led_voltage' =>
                        array (
                            'title' => 'LED Voltage',
                            'options' =>
                                array (
                                    0 => 'Non LED',
                                    1 => '6V',
                                    2 => '24V',
                                    3 => '110V',
                                    4 => '230V',
                                ),
                        ),
                    'military_standard' =>
                        array (
                            'title' => 'Optional',
                            'options' =>
                                array (
                                    'J' => 'GJB',
                                ),
                        ),
                    'install_size' =>
                        array (
                            'title' => 'Installation dimension',
                            'options' =>
                                array (
                                    'A' => '8mm',
                                    'B' => '12mm',
                                    'C' => '19mm',
                                    'D' => '16mm',
                                    'E' => '22mm',
                                    'F' => '28mm',
                                    'G' => '30mm',
                                ),
                        ),
                ),
            '5.0' =>
                array (
                    'front_shape' =>
                        array (
                            'title' => 'Front ring Dim',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => '24mm round',
                                    2 => '24mm square',
                                    3 => '22mm round',
                                    4 => '20mm round',
                                    5 => '24mm round',
                                    6 => '24mm square',
                                    7 => '26mm round',
                                    'A' => '12mm round',
                                    'B' => '16mm round',
                                    'D' => '28mm round',
                                ),
                        ),
                    'front_button_material' =>
                        array (
                            'title' => 'Front ring/button material',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => 'SUS',
                                    2 => 'Aluminium alloy',
                                ),
                        ),
                    'front_button_shape' =>
                        array (
                            'title' => 'Front ring/button shape',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => 'convex/convex',
                                    2 => 'concave/convex',
                                    3 => 'flat/convex',
                                    4 => 'convex/mushroom',
                                    'A' => 'flat/flat',
                                    'B' => 'flat/flat（12mm）',
                                ),
                        ),
                    'front_button_color' =>
                        array (
                            'title' => 'Front ring/button colour',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => 'Natural（SUS）',
                                    2 => 'Gold（SUS）',
                                    3 => 'Black（SUS）',
                                    4 => 'Natural（AL）',
                                    5 => 'Red（AL）',
                                    6 => 'Yellow（AL）',
                                    7 => 'Green（AL）',
                                ),
                        ),
                    'switch_element' =>
                        array (
                            'title' => 'Switch function',
                            'options' =>
                                array (
                                    0 => 'Indicator',
                                    1 => 'momentary，3 NO/3 NC',
                                    2 => 'maintained，3 NO/3 NC',
                                ),
                        ),
                    'light_style' =>
                        array (
                            'title' => 'illuminated',
                            'options' =>
                                array (
                                    1 => 'Ring illuminated',
                                    2 => 'Dot illuminated',
                                    3 => 'Non illuminated',
                                    4 => 'Full illuminated',
                                ),
                        ),
                    'led_color' =>
                        array (
                            'title' => 'LED Color',
                            'options' =>
                                array (
                                    0 => 'Non LED',
                                    1 => 'Red',
                                    2 => 'Yellow',
                                    3 => 'Green',
                                    4 => 'white',
                                ),
                        ),
                    'led_voltage' =>
                        array (
                            'title' => 'LED Voltage',
                            'options' =>
                                array (
                                    0 => 'Non LED',
                                    1 => '6V',
                                    2 => '24V',
                                    3 => '110V',
                                    4 => '230V',
                                ),
                        ),
                    'military_standard' =>
                        array (
                            'title' => 'Optional',
                            'options' =>
                                array (
                                    'J' => 'GJB',
                                ),
                        ),
                    'install_size' =>
                        array (
                            'title' => 'Installation dimension',
                            'options' =>
                                array (
                                    'A' => '8mm',
                                    'B' => '12mm',
                                    'C' => '19mm',
                                    'D' => '16mm',
                                    'E' => '22mm',
                                    'F' => '28mm',
                                    'G' => '30mm',
                                ),
                        ),
                ),
            '4.0' =>
                array (
                    'front_shape' =>
                        array (
                            'title' => 'Front ring Dim',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => '24mm round',
                                    2 => '24mm square',
                                    3 => '22mm round',
                                    4 => '20mm round',
                                    5 => '24mm round',
                                    6 => '24mm square',
                                    7 => '26mm round',
                                    'A' => '12mm round',
                                    'B' => '16mm round',
                                    'D' => '28mm round',
                                ),
                        ),
                    'front_button_material' =>
                        array (
                            'title' => 'Front ring/button material',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => 'SUS',
                                    2 => 'Aluminium alloy',
                                ),
                        ),
                    'front_button_shape' =>
                        array (
                            'title' => 'Front ring/button shape',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => 'convex/convex',
                                    2 => 'concave/convex',
                                    3 => 'flat/convex',
                                    4 => 'convex/mushroom',
                                    'A' => 'flat/flat',
                                    'B' => 'flat/flat（12mm）',
                                ),
                        ),
                    'front_button_color' =>
                        array (
                            'title' => 'Front ring/button colour',
                            'options' =>
                                array (
                                    0 => '-',
                                    1 => 'Natural（SUS）',
                                    2 => 'Gold（SUS）',
                                    3 => 'Black（SUS）',
                                    4 => 'Natural（AL）',
                                    5 => 'Red（AL）',
                                    6 => 'Yellow（AL）',
                                    7 => 'Green（AL）',
                                    8 => '-',
                                    9 => '-',
                                ),
                        ),
                    'switch_element' =>
                        array (
                            'title' => 'Switch function',
                            'options' =>
                                array (
                                    0 => 'Indicator',
                                    1 => 'Momentary，1 NO/1 NC',
                                    2 => 'Maintained，1 NO/1 NC',
                                    3 => 'Momentary，3 NO/3 NC',
                                    4 => 'Maintained，3 NO/3 NC',
                                ),
                        ),
                    'light_style' =>
                        array (
                            'title' => 'illuminated',
                            'options' =>
                                array (
                                    1 => 'Ring illuminated',
                                    2 => 'Dot illuminated',
                                    3 => 'Non illuminated',
                                    4 => 'Full illuminated',
                                ),
                        ),
                    'led_color' =>
                        array (
                            'title' => 'LED Color',
                            'options' =>
                                array (
                                    0 => 'Non LED',
                                    1 => 'Red',
                                    2 => 'Yellow',
                                    3 => 'Green',
                                    4 => 'white',
                                ),
                        ),
                    'led_voltage' =>
                        array (
                            'title' => 'LED Voltage',
                            'options' =>
                                array (
                                    0 => 'Non LED',
                                    1 => '6V',
                                    2 => '24V',
                                    3 => '110V',
                                    4 => '230V',
                                ),
                        ),
                    'military_standard' =>
                        array (
                            'title' => 'Optional',
                            'options' =>
                                array (
                                    'J' => 'GJB',
                                ),
                        ),
                    'install_size' =>
                        array (
                            'title' => 'Installation dimension',
                            'options' =>
                                array (
                                    'A' => '8mm',
                                    'B' => '12mm',
                                    'C' => '19mm',
                                    'D' => '16mm',
                                    'E' => '22mm',
                                    'F' => '28mm',
                                    'G' => '30mm',
                                ),
                        ),
                ),
        );

        $cacheFile = CACHE_PATH . self::$_cache_key_en;
        file_put_contents($cacheFile, json_encode($props, JSON_UNESCAPED_UNICODE));

        return $props;
    }
}
