<?php
    defined('IN_ADMIN') or exit('No permission resources.');
    $addbg = 1;
    include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
var charset = '<?php echo CHARSET;?>';
var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
</script>
<style type="text/css">
    .form-list {
        padding: 0;
        margin: 0;
        list-style-type: none;
    }
    .form-list li {
        line-height: 26px;
    }
    .form-list input {
        width: 60%;
    }
    .label-product {
        display: inline-block;
        width: 100px;
    }
</style>
<form name="myform" id="myform" action="?m=product&c=product&a=add" method="post" enctype="multipart/form-data">
    <div class="addContent">
        <div class="crumbs">添加产品</div>
        <div class="col-right"></div>
        <div class="col-auto">
            <div class="col-1">
                <div class="content pad-6">
                    <ul class="form-list">
                        <li>
                            <span class="label-product">产品名称：</span>
                            <input type="text" name="product_name" id="product_name" />
                        </li>
                        <li>
                            <span class="label-product">产品系列：</span>
                            <select name="product_serial" id="product_serial">
                                <option value="">--请选择系列--</option>
                                <option value="4.0">4.0</option>
                                <option value="5.0">5.0</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">前圈尺寸：</span>
                            <select name="front_shape" id="front_shape">
                                <option value="">--请选择前圈尺寸--</option>
                                <option value="A">A 12mm 圆形</option>
                                <option value="B">B 16mm 圆形</option>
                                <option value="1">1 24mm 圆形</option>
                                <option value="2">2 24mm 方形</option>
                                <option value="3">3 22mm 圆形</option>
                                <option value="4">4 20mm 圆形</option>
                                <option value="Z">Z 定制</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">前圈/按钮材料：</span>
                            <select name="front_button_material" id="front_button_material">
                                <option value="">--请选择前圈/按钮材料--</option>
                                <option value="1">1 不锈钢</option>
                                <option value="2">2 铝合金</option>
                                <option value="Z">Z 定制</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">前圈/按钮形状：</span>
                            <select name="front_button_shape" id="front_button_shape">
                                <option value="">--请选择前圈/按钮形状--</option>
                                <option value="A">A 平面/平面（12mm开关)</option>
                                <option value="B">B 平面/平面 (16mm开关)</option>
                                <option value="1">1 凹面/凸弧面</option>
                                <option value="2">2 凹面/凸弧面</option>
                                <option value="3">3 平面/凸弧面</option>
                                <option value="Z">Z 定制</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">前圈/按钮颜色：</span>
                            <select name="front_button_color" id="front_button_color">
                                <option value="">--请选择前圈/按钮形状--</option>
                                <option value="1">1 哑光（不锈钢）</option>
                                <option value="2">2 金色（不锈钢）</option>
                                <option value="3">3 黑色（不锈钢）</option>
                                <option value="4">4 自然色 (铝）</option>
                                <option value="5">5 红色 (铝）</option>
                                <option value="6">6 黄色 (铝）</option>
                                <option value="7">7 绿色 (铝）</option>
                                <option value="Z">Z 定制</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">开关元件：</span>
                            <select name="switch_element" id="switch_element">
                                <option value="">--请选择前圈/按钮形状--</option>
                                <option value="0">0 指示灯</option>
                                <option value="1">1 瞬时 1 NO / 1 NC ( 5.0系列 3 NO / 3 NC)</option>
                                <option value="2">2 自锁 1 NO / 1 NC ( 5.0系列 3 NO / 3 NC)</option>
                                <option value="3">3 瞬时 3 NO / 3 NC</option>
                                <option value="4">4 自锁 3 NO / 3 NC</option>
                                <option value="Z">Z 定制</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">照明形式：</span>
                            <select name="light_style" id="light_style">
                                <option value="">--请选择照明形式--</option>
                                <option value="1">1 环形照明</option>
                                <option value="2">2 点照明</option>
                                <option value="3">3 无照明</option>
                                <option value="Z">Z 定制</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">LED灯颜色：</span>
                            <select name="light_style" id="light_style">
                                <option value="">--请选择LED灯颜色--</option>
                                <option value="0">0 无</option>
                                <option value="1">1 红色</option>
                                <option value="2">2 黄色</option>
                                <option value="3">3 绿色</option>
                                <option value="4">4 白色</option>
                                <option value="Z">Z 定制</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">LED灯电压：</span>
                            <select name="light_style" id="light_style">
                                <option value="">--请选择LED灯电压--</option>
                                <option value="0">0 无</option>
                                <option value="1">1 6V</option>
                                <option value="2">2 24V</option>
                                <option value="3">3 110V</option>
                                <option value="4">4 230V</option>
                                <option value="Z">Z 定制</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">前圈/磁：</span>
                            <select name="light_style" id="light_style">
                                <option value="">--请选择前圈/磁--</option>
                                <option value="A">A Ø 8</option>
                                <option value="B">B Ø 12</option>
                                <option value="C">C Ø 19</option>
                                <option value="D">D Ø 22</option>
                                <option value="M">M 磁场灭弧</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">序列号：</span>
                            <select name="light_style" id="light_style">
                                <option value="">--请选择照明形式--</option>
                                <option value="1">1 环形照明</option>
                                <option value="2">2 点照明</option>
                                <option value="3">3 无照明</option>
                                <option value="Z">Z 定制</option>
                            </select>
                        </li>
                        <li>
                            <span class="label-product">产品缩略图：</span>
                            <?php echo form::images('thumb', 'thumb', '', 'product');?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed-bottom">
        <div class="fixed-but text-c">
            <div class="button"><input value="保存并关闭" type="submit" name="dosubmit" class="cu" style="width:145px;"></div>
            <div class="button"><input value="关闭窗口" type="button" name="close" onclick="close_window();" class="cu" style="width:70px;"></div>
        </div>
    </div>
</form>

</body>
</html>
<script type="text/javascript">
function close_window() {
    window.close();
}
</script>