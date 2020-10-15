<?php
/**
 *  生成PDF离线版
 */
ini_set('memory_limit', -1);
define('SYS_TIME', time());
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/console.php';
pc_base::load_sys_func('dir');
$db_site = pc_base::load_model('site_model');
$db_setting = pc_base::load_model('productions_setting_model');
$db_market = pc_base::load_model('productions_market_list_model');
$db_functions = pc_base::load_model('productions_functions_list_model');
$db_series = pc_base::load_model('productions_series_list_model');
$db_market_setting = pc_base::load_model('productions_market_model');
$db_function_setting = pc_base::load_model('productions_functions_model');
$db_series_setting = pc_base::load_model('productions_series_model');
$db_contact_setting = pc_base::load_model('productions_contact_setting_model');
$db = pc_base::load_model('productions_model');
$db_linkage = pc_base::load_model('linkage_model');
$_product_props = $db_linkage->product_props();

/**
 * 图片转换为base64
 * @param $image
 * @return string
 */
function image2base64($image) {
    $exp = explode('.', $image);
    $type = $exp[count($exp) - 1];

    return $logo = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents(PHPCMS_PATH . $image));
}

echo 'generating offline...',chr(10),chr(13);

$zip_name = '华南电子网_离线版';

$usb_template_path = PHPCMS_PATH . 'usb' . DIRECTORY_SEPARATOR;
$output_path = CACHE_PATH . 'offline/' . $zip_name . DIRECTORY_SEPARATOR;
if (!is_dir($output_path)) {
    mkdir($output_path);
}
$zip_path = CACHE_PATH . 'offline/' . $zip_name . '.zip';
if (file_exists($zip_path)) {
    @unlink($zip_path);
}

/*
 * 复制JS和CSS文件
 */
echo '复制JS和CSS文件',chr(10),chr(13);
dir_copy($usb_template_path . 'statics', $output_path . 'statics');

$setting = $db_setting->get_one(['id' => 1]);
$index_template = file_get_contents($usb_template_path . 'index.html');
echo '复制JS和CSS文件 ok....................',chr(10),chr(13);

/*
 * 网站LOGO
 */
echo '复制网站LOGO',chr(10),chr(13);
$site = $db_site->get_one(['siteid' => 1]);
$settings = string2array($site['setting']);
$logo = substr($settings['logo'], 1, strlen($settings['logo']));
$logo = image2base64($logo);
$index_template = preg_replace('/{logo}/', $logo, $index_template);
echo '复制网站LOGO ok....................',chr(10),chr(13);

/*
 * 生成首页数据：市场分类、功能分类、系列分类、配置数据
 */
$index_template = preg_replace('/{setting_title}/', $setting['title'], $index_template);
$index_template = preg_replace('/{setting_content}/', $setting['description'], $index_template);

// 市场
echo '市场',chr(10),chr(13);
$market_setting = $db_market_setting->get_one(['id' => 1]);
$market_list = $db_market->listinfo([], '', 1, 100);
//$market_menus = [];
//foreach ($market_list as $item) {
//    $market_menus[] = '<li><a href="functions-1-' . $item['id'] . '.html"></a>' . $item['title'] . '</li>';
//}
$market_thumb = substr($market_setting['thumb'], 1, strlen($market_setting['thumb']));
$market_thumb = image2base64($market_thumb);
//$index_template = preg_replace('/{market_menus}/', implode('', $market_menus), $index_template);
$index_template = preg_replace('/{market_menus}/', '', $index_template);
$index_template = preg_replace('/{market_thumb}/', $market_thumb, $index_template);
$index_template = preg_replace('/{market_title}/', $market_setting['title'], $index_template);
$index_template = preg_replace('/{market_description}/', $market_setting['description'], $index_template);
echo '市场 ok....................',chr(10),chr(13);

// 功能
echo '功能',chr(10),chr(13);
$function_setting = $db_function_setting->get_one(['id' => 1]);
$function_list = $db_functions->listinfo([], '', 1, 100);
//$function_menus = [];
//foreach ($function_list as $item) {
//    $function_menus[] = '<li><a href="functions-' . $item['id'] . '.html"></a>' . $item['title'] . '</li>';
//}
$thumb = substr($function_setting['thumb'], 1, strlen($function_setting['thumb']));
$thumb = image2base64($thumb);
//$index_template = preg_replace('/{function_menus}/', implode('', $function_menus), $index_template);
$index_template = preg_replace('/{function_menus}/', '', $index_template);
$index_template = preg_replace('/{function_thumb}/', $thumb, $index_template);
$index_template = preg_replace('/{function_title}/', $function_setting['title'], $index_template);
$index_template = preg_replace('/{function_description}/', $function_setting['description'], $index_template);
echo '功能 ok....................',chr(10),chr(13);

// 系列
echo '系列',chr(10),chr(13);
$series_setting = $db_series_setting->get_one(['id' => 1]);
$list = $db_series->listinfo([], '', 1, 100);
$series_list = $list;
//$series_menus = [];
//foreach ($list as $item) {
//    $series_menus[] = '<li><a href="functions-2-' . $item['id'] . '.html"></a>' . $item['title'] . '</li>';
//}
$thumb = substr($series_setting['thumb'], 1, strlen($series_setting['thumb']));
$thumb = image2base64($thumb);
//$index_template = preg_replace('/{series_menus}/', implode('', $series_menus), $index_template);
$index_template = preg_replace('/{series_menus}/', '', $index_template);
$index_template = preg_replace('/{series_thumb}/', $thumb, $index_template);
$index_template = preg_replace('/{series_title}/', $series_setting['title'], $index_template);
$index_template = preg_replace('/{series_description}/', $series_setting['description'], $index_template);

file_put_contents($output_path . 'index.html', $index_template);
echo '系列 ok....................',chr(10),chr(13);

/*
 * 生成二级页面数据
 */
echo '生成二级页面数据',chr(10),chr(13);
$category_template = file_get_contents($usb_template_path . 'category.html');
$category_template = preg_replace('/{setting_title}/', $setting['title'], $category_template);
$category_template = preg_replace('/{logo}/', $logo, $category_template);
$category_template = preg_replace('/{setting_content}/', $setting['description'], $category_template);
$category_template = preg_replace('/{market_menus}/', implode('', $market_menus), $category_template);
$category_template = preg_replace('/{function_menus}/', implode('', $function_menus), $category_template);
$category_template = preg_replace('/{series_menus}/', implode('', $series_menus), $category_template);
echo '生成二级页面数据 ok....................',chr(10),chr(13);

// 市场
echo '市场',chr(10),chr(13);
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
    $functions = $db_functions->listinfo('id IN(' . $fids . ')', '', 1, 1000);
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
echo '市场 ok....................',chr(10),chr(13);

// 功能
echo '功能',chr(10),chr(13);
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
echo '功能 ok....................',chr(10),chr(13);

// 系列
echo '系列',chr(10),chr(13);
$series_category_template = $category_template;
$series_category_template = preg_replace('/{category_title}/', '系列', $series_category_template);
$categories = [];
foreach ($list as $item) {
    // 只生成6.0
    if ($item['id'] != 8) {
        continue;
    }

    $tmp  = '<div class="column grid_2 column_margin">';
    $tmp .= '<a href="functions-2-' . $item['id'] . '.html" class="c_3x2">';
    $tmp .= '<span><h5>' . $item['title'] . '</h5></span>';
    $tmp .= '</a>';
    $tmp .= '</div>';
    $categories[] = $tmp;

    $sql = 'SELECT DISTINCT functions_id FROM `se_productions` WHERE series_id = ' . $item['id'];
    $query = $db->query($sql);
    $rows = $db->fetch_array();
    $functions_ids = [];
    foreach ($rows as $row) {
        $functions_ids[] = $row['functions_id'];
    }

    // 生成对应的功能列表页面
    $where = 'id IN(' . implode(',', $functions_ids) . ')';
    $series = $db_functions->listinfo($where, '', 1, 1000);
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
echo '系列 ok....................',chr(10),chr(13);

/*
 * 把所有产品数据生成到一个JS变量中，并独立生成JS文件
 */
echo '把所有产品数据生成到一个JS变量中，并独立生成JS文件',chr(10),chr(13);
$products = $db->listinfo([], 'id DESC', 1, 1000000);

// 图片base64处理
//$productData = [];
//foreach ($products as $item) {
//    $item['thumb'] = image2base64($item['thumb']);
//    $item['project_image_1'] = image2base64($item['project_image_1']);
//
//    $productData[] = $item;
//}

$js_list_template = file_get_contents($usb_template_path . 'product.js');
$js_list_template = preg_replace('/{products}/', json_encode($products), $js_list_template);
$js_list_template = preg_replace('/{properties}/', json_encode($_product_props), $js_list_template);
file_put_contents($output_path . 'product.js', $js_list_template);
file_put_contents($output_path . 'list.js', file_get_contents($usb_template_path . 'list.js'));
echo '把所有产品数据生成到一个JS变量中，并独立生成JS文件 ok....................',chr(10),chr(13);

/*
 * 转移css
 */
echo '转移css',chr(10),chr(13);
$modal_css = file_get_contents($usb_template_path . 'modal.css');
file_put_contents($output_path . 'modal.css', $modal_css);
echo '转移css ok....................',chr(10),chr(13);

/*
 * 产品配置器列表页
 */
// 获取工程师联系方式
echo '产品配置器列表页',chr(10),chr(13);
$contacts = $db_contact_setting->get_one(['id' => 1]);
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
foreach ($_product_props as $kk => $props) {
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
echo '产品配置器列表页 ok....................',chr(10),chr(13);

/*
 * 产品配置器详情页
 */
echo '产品配置器详情页',chr(10),chr(13);
$show_template = file_get_contents($usb_template_path . 'show.html');
$show_template = preg_replace('/{setting_title}/', $setting['title'], $show_template);
$show_template = preg_replace('/{setting_content}/', $setting['description'], $show_template);
$show_template = preg_replace('/{market_menus}/', implode('', $market_menus), $show_template);
$show_template = preg_replace('/{function_menus}/', implode('', $function_menus), $show_template);
$show_template = preg_replace('/{series_menus}/', implode('', $series_menus), $show_template);
foreach ($products as $product) {
    $show_template_tmp = $show_template;
    $product_id = $product['id'];
    $pdf_name = $product['code'];

    // 产品属性
    $show_props = [];
    foreach ($_product_props as $kk => $props) {
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
    $show_template_tmp = preg_replace('/{pdf_name}/', $pdf_name, $show_template_tmp);

    file_put_contents($output_path . 'show-' . $product_id . '.html', $show_template_tmp);
}
echo '产品配置器详情页 ok....................',chr(10),chr(13);

// 参数搜索
echo '参数搜索页',chr(10),chr(13);
$search_template = file_get_contents($usb_template_path . 'search.html');
$search_template = preg_replace('/{setting_title}/', $setting['title'], $search_template);
$search_template = preg_replace('/{logo}/', $logo, $search_template);
$search_template = preg_replace('/{setting_content}/', $setting['description'], $search_template);
$search_template = preg_replace('/{market_menus}/', implode('', $market_menus), $search_template);
$search_template = preg_replace('/{function_menus}/', implode('', $function_menus), $search_template);
$search_template = preg_replace('/{series_menus}/', implode('', $series_menus), $search_template);
$search_template = preg_replace('/{contact-enginer-info}/', $contact_info, $search_template);
//$search_filter = [];
//foreach ($_product_props as $kk => $props) {
//    $tmp  = '<fieldset class="filter column grid_filter product-prop-filter">';
//    $tmp .= '<label>' . $props['title'] . '(' . count($props['options']) . ')</label>';
//    $tmp .= '<select onchange="setSeFilter();" name="' . $kk . '" id="' . $kk . '" class="prodFinder" style="display: inline-block;">';
//    $tmp .= '<option value="-"></option>';
//    foreach ($props['options'] as $key => $option) {
//        $tmp .= '<option value="' . $key . '">' . ($key . '  ' . $option) . '</option>';
//    }
//    $tmp .= '</select>';
//    $tmp .= '</fieldset>';
//
//    $search_filter[] = $tmp;
//}
//$search_template = preg_replace('/{search_filter}/', implode('', $search_filter), $search_template);
$search_series_select = '';
foreach ($series_list as $item) {
    $search_series_select .= '<option value="' . $item['id'] . '">' . $item['title'] . '</option>';
}
$search_template = preg_replace('/{search_series_select}/', $search_series_select, $search_template);
$search_function_select = '';
foreach ($function_list as $item) {
    $search_series_select .= '<option value="' . $item['id'] . '">' . $item['title'] . '</option>';
}
$search_template = preg_replace('/{search_function_select}/', $search_function_select, $search_template);
file_put_contents($output_path . 'search.html', $search_template);
echo '参数搜索页 ok....................',chr(10),chr(13);

// 复制PDF到USB版本目录下
echo '复制PDF到USB版本目录下',chr(10),chr(13);
dir_copy(CACHE_PATH . 'pdf', $output_path . 'pdf');
dir_copy(PHPCMS_PATH . 'uploadfile', $output_path . 'uploadfile');
echo '产品配置器详情页 ok....................',chr(10),chr(13);

/*
 * zip offline
 */
echo 'zip offline',chr(10),chr(13);
dir_zip($output_path, $zip_path, $output_path);
echo 'zip offline ok....................',chr(10),chr(13);

echo 'ok',chr(10),chr(13);