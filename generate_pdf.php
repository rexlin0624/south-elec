<?php 
/**
 *  生成PDF后台程序
 */
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
require_once __DIR__ . '/vendor/autoload.php';
use Knp\Snappy\Pdf;

include PHPCMS_PATH.'phpcms/base.php';
$db = pc_base::load_model('queues_model');
$db_product = pc_base::load_model('productions_model');
$db_linkage = pc_base::load_model('linkage_model');
$db_setting = pc_base::load_model('productions_setting_model');
$pdfkit = new Pdf('/usr/local/bin/wkhtmltopdf');

$isDebug = false;

// 获取空闲数量
$totalFree = $db->getTotalFree();
if ($totalFree == 0) {
	die('No generate pdf queue.' . chr(10) . chr(13));
}
if (!$isDebug) {
    echo '$totalFree = ', $totalFree, chr(10), chr(13);
}

// 获取是否在处理中
$isProcessing = $db->getProcessing();
if ($isProcessing) {
	die('Processing, skip...');
}

// 若非处理中，则处理下一条PDF生成
$row = $db->get_one('`status` = 0', 'id, product_id', 'id DESC');
//$row = $db->get_one('`id` = 31173', 'id, product_id', 'id DESC');
if (!$isDebug) {
    $db->markProcessing($row['id']);
}
$productId = $row['product_id'];
if (!$isDebug) {
    echo 'productId = ', $productId, ' Processing...', chr(10), chr(13);
}

$product = $db_product->get_one(['id' => $productId]);
$code = $product['code'];
$product_props = $db_linkage->product_props();
$setting = $db_setting->get_one(['id' => 1]);
$host = 'http://south.china';
//$host = 'https://www.hmie.com.cn';

$thumb = 'data:image/jpeg;base64,' . base64_encode(file_get_contents(__DIR__ . $product['thumb']));

$pdf_path = __DIR__ . '/caches/pdf/' . $code . '.pdf';
$pdf_template = __DIR__.'/phpcms/modules'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR.'pdf.template';
$pdf_content = file_get_contents($pdf_template);
$pdf_content = preg_replace('/{pdf_background_base64}/', file_get_contents(__DIR__ . '/pdf_background.base64'), $pdf_content);
$pdf_content = preg_replace('/{pdf_header_bgcolor}/', $setting['header_bgcolor'], $pdf_content);
$pdf_content = preg_replace('/{title}/', $product['title'] . '：' . $code, $pdf_content);
$pdf_content = preg_replace('/{description}/', $product['description'], $pdf_content);
$pdf_content = preg_replace('/{thumb}/', $thumb, $pdf_content);

// 工程图
$project_images = [];
for ($i = 1;$i <= 4;$i++) {
	$img = $product['project_image_' . $i];
	if (empty($img)) {
		continue;
	}

	//$url = $host . substr($img, 0, -4) . '.png';
	$url = $host . $img;
	$project_images[] = '<div style="overflow: hidden;page-break-after: always;"></div><div><img src="' . $url . '" /></div>';
}

$pdf_content = preg_replace('/{project_images}/', implode('', $project_images), $pdf_content);

$prop_string = [];
foreach ($product_props as $key => $prop) {
	$prop_string[] = '<li>' . $prop['title'] . '：' . $prop['options'][$product[$key]] . '</li>';
}
//$pdf_content = preg_replace('/{props}/', implode('', $prop_string), $pdf_content);

// 前圈尺寸
$pdf_content = preg_replace('/{front_shape}/', $product_props['front_shape']['options'][$product['front_shape']], $pdf_content);

// 前圈/按键材料
$pdf_content = preg_replace('/{front_button_material}/', $product_props['front_button_material']['options'][$product['front_button_material']], $pdf_content);

// 前圈/按键形状
$pdf_content = preg_replace('/{front_button_shape}/', $product_props['front_button_shape']['options'][$product['front_button_shape']], $pdf_content);

// 前圈/按键颜色
$pdf_content = preg_replace('/{front_button_color}/', $product_props['front_button_color']['options'][$product['front_button_color']], $pdf_content);

// 开关元件
$pdf_content = preg_replace('/{switch_element}/', $product_props['switch_element']['options'][$product['switch_element']], $pdf_content);

// 照明形式
$pdf_content = preg_replace('/{light_style}/', $product_props['light_style']['options'][$product['light_style']], $pdf_content);

// 灯罩/LED灯颜色
$pdf_content = preg_replace('/{led_color}/', $product_props['led_color']['options'][$product['led_color']], $pdf_content);

// LED灯电压
$pdf_content = preg_replace('/{led_voltage}/', $product_props['led_voltage']['options'][$product['led_voltage']], $pdf_content);

// 军标
$pdf_content = preg_replace('/{military_standard}/', $product_props['military_standard']['options'][$product['military_standard']], $pdf_content);

// 安装尺寸
$pdf_content = preg_replace('/{install_size}/', $product_props['install_size']['options'][$product['install_size']], $pdf_content);

// 产品尺寸图
$product_images = 'data:image/jpeg;base64,' . base64_encode(file_get_contents(__DIR__ . $product['project_image_1']));
$pdf_content = preg_replace('/{product_images}/', $product_images, $pdf_content);

// logo
$logo = 'data:image/png;base64,' . file_get_contents(__DIR__ . '/pdf_logo.base64');
$pdf_content = preg_replace('/{logo}/', $logo, $pdf_content);

// bottom
$bottom = 'data:image/png;base64,' . file_get_contents(__DIR__ . '/pdf_bottom.base64');

// 产品图底纹
$product_bg = 'data:image/png;base64,' . file_get_contents(__DIR__ . '/pdf_product_bg.base64');
$pdf_content = preg_replace('/{product_background}/', $product_bg, $pdf_content);

if ($isDebug) {
    echo $pdf_content;
    //exit;
}


// generate pdf
$pdfkit->setOptions([
//	'margin-left' => 0,
//    'margin-right' => 0,
//	'margin-top' => 0,
//	'margin-bottom' => 0,
//    'page-size' => 'A4',
    'footer-html' => '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body><img src="' . $bottom . '" style="width:100%;height:60px;" /></body></html>'
//    'page-width' => '210mm',
//    'page-height' => '297mm',
]);
$pdfkit->generateFromHtml($pdf_content, $pdf_path, [], true);

if (!$isDebug) {
    echo 'Finish...', chr(10), chr(13);
    $db->markFinished($row['id']);
}