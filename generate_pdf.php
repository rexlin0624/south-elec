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

// 获取空闲数量
$totalFree = $db->getTotalFree();
if ($totalFree == 0) {
	die('No generate pdf queue.' . chr(10) . chr(13));
}
echo '$totalFree = ', $totalFree, chr(10), chr(13);

// 获取是否在处理中
$isProcessing = $db->getProcessing();
if ($isProcessing) {
	die('Processing, skip...');
}

// 若非处理中，则处理下一条PDF生成
$row = $db->get_one('`status` = 0', 'id, product_id');
// $db->markProcessing($row['id']);
$productId = $row['product_id'];
echo 'productId = ' , $productId , ' Processing...', chr(10), chr(13);

$product = $db_product->get_one(['id' => $productId]);
$code = $product['code'];
$product_props = $db_linkage->product_props();
$setting = $db_setting->get_one(['id' => 1]);
$host = 'http://south.elec.local';

$pdf_path = __DIR__ . '/caches/pdf/' . $productId . '.pdf';
$pdf_template = __DIR__.'/phpcms/modules'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR.'pdf.template';
$pdf_content = file_get_contents($pdf_template);
$pdf_content = preg_replace('/{pdf_title}/', $setting['pdf_title'], $pdf_content);
$pdf_content = preg_replace('/{pdf_desc}/', $setting['pdf_desc'], $pdf_content);
$pdf_content = preg_replace('/{pdf_header_bgcolor}/', $setting['header_bgcolor'], $pdf_content);
$pdf_content = preg_replace('/{title}/', $code . ' - ' . $product['title'], $pdf_content);
$pdf_content = preg_replace('/{description}/', $product['description'], $pdf_content);
$pdf_content = preg_replace('/{thumb}/', $host . $product['thumb'], $pdf_content);

// 工程图
$project_images = [];
for ($i = 1;$i <= 4;$i++) {
	$img = $product['project_image_' . $i];
	if (empty($img)) {
		continue;
	}

	$url = $host . substr($img, 0, -4) . '.png';
	$project_images[] = '<div style="overflow: hidden;page-break-after: always;"></div><div><img src="' . $url . '" /></div>';
}

$pdf_content = preg_replace('/{project_images}/', implode('', $project_images), $pdf_content);

$prop_string = [];
foreach ($product_props as $key => $prop) {
	$prop_string[] = '<li>' . $prop['title'] . '：' . $prop['options'][$product[$key]] . '</li>';
}
$pdf_content = preg_replace('/{props}/', implode('', $prop_string), $pdf_content);

// generate pdf
$pdfkit->setOptions([
	'margin-left' => 0,
	'margin-top' => 0,
	'margin-right' => 0,
]);
$pdfkit->generateFromHtml($pdf_content, $pdf_path, [], true);

echo 'Finish...', chr(10), chr(13);
$db->markFinished($row['id']);