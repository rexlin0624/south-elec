<?php
/**
 *  extention.func.php 用户自定义函数库
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-10-27
 */
/**
 * 根据box字段获取名称和值
 * @param $field 字段名称
 * @param $modelid 字段所在模型id
 */
function getBox($field,$modelid){
    $modelAll=getcache('model_field_'.$modelid,'model');
    $fieldSet=string2array($modelAll[$field]['setting']);
    $datas = explode("\r\n", $fieldSet['options']);
    foreach($datas as $_k) {
        $v = explode("|",$_k);
        $k = trim($v[1]);
        $option[$k] = $v[0];
    }
    return $option;
}
/**
 * 计算几分钟前、几小时前、几天前、几月前、几年前。
 * $agoTime string Unix时间
 * @author tangxinzhuan
 * @version 2016-10-28
 */
function time_ago($agoTime)
{
    $agoTime = (int)$agoTime;

    // 计算出当前日期时间到之前的日期时间的毫秒数，以便进行下一步的计算
    $time = time() - $agoTime;

    if ($time >= 31104000) { // N年前
        $num = (int)($time / 31104000);
        return $num.'年前';
    }
    if ($time >= 2592000) { // N月前
        $num = (int)($time / 2592000);
        return $num.'月前';
    }
    if ($time >= 86400) { // N天前
        $num = (int)($time / 86400);
        return $num.'天前';
    }
    if ($time >= 3600) { // N小时前
        $num = (int)($time / 3600);
        return $num.'小时前';
    }
    if ($time > 60) { // N分钟前
        $num = (int)($time / 60);
        return $num.'分钟前';
    }
    return '1分钟前';
}

/**
 * 后台栏目管理中添加组图上传
 * 返回多图上传
 * @param $field
 * @param $catid
 * @param $value
 * @return string
 */
function catimages($field,$catid,$value) {
    $list_str = '';
    if($value) {
        $value = string2array(new_html_entity_decode($value));
        if(is_array($value)) {
            foreach($value as $_k=>$_v) {
                $list_str .= "<div id='image_{$field}_{$_k}' style='padding:1px'><input type='text' name='{$field}_url[]' value='{$_v[url]}' style='width:310px;' ondblclick='image_priview(this.value);' class='input-text'> <input type='text' name='{$field}_alt[]' value='{$_v[alt]}' style='width:160px;' class='input-text'> <a href=\"javascript:remove_div('image_{$field}_{$_k}')\">".L('remove_out', '', 'content')."</a></div>";
            }
        }
    } else {
        $list_str .= "<center><div class='onShow' id='nameTip'>".L('upload_pic_max', '', 'content')." <font color='red'>50</font> ".L('tips_pics', '', 'content')."</div></center>";
    }
    $string = '<input name="info['.$field.']" type="hidden" value="1">
    <fieldset class="blue pad-10">
    <legend>'.L('pic_list').'</legend>';
    $string .= $list_str;
    $string .= '<div id="'.$field.'" class="picList"></div>
    </fieldset>
    <div class="bk10"></div>
    ';
    if(!defined('IMAGES_INIT')) {
        $str = '<script type="text/javascript" src="statics/js/swfupload/swf2ckeditor.js"></script>';
        define('IMAGES_INIT', 1);
    }
    $str = '<script language="javascript" type="text/javascript" src="statics/js/content_addtop.js"></script>';
    $authkey = upload_key("50,gif|jpg|jpeg|png|bmp,1");
    $string .= $str."<div class='picBut cu'><a href='javascript:void(0);' onclick=\"javascript:flashupload('{$field}_images', '".L('attachment_upload')."','{$field}',change_images,'50,gif|jpg|jpeg|png|bmp,1','content','{$catid}','{$authkey}')\"/> ".L('select_pic')." </a></div>";
    return $string;
}
?>