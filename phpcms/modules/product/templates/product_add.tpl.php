<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
$id = isset($info['id']) ? $info['id'] : 0;
$title = isset($info['title']) ? $info['title'] : '';
$thumb = isset($info['thumb']) ? $info['thumb'] : '';
$project_image_1 = isset($info['project_image_1']) ? $info['project_image_1'] : '';
$project_image_2 = isset($info['project_image_2']) ? $info['project_image_2'] : '';
$project_image_3 = isset($info['project_image_3']) ? $info['project_image_3'] : '';
$functions_id = isset($info['functions_id']) ? $info['functions_id'] : 0;
$series_id = isset($info['series_id']) ? $info['series_id'] : 0;
?>
<div class="pad-10">
    <form method="post" action="?m=product&c=product&a=add" name="myform" id="myform">
        <input type="hidden" name="product[id]" id="product_id" value="<?php echo $id; ?>">
        <table class="table_form" width="100%" cellspacing="0">
            <tbody>
            <tr>
                <th width="120"><strong>产品编号：</strong></th>
                <td><input id="code" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo $code; ?>" readonly="readonly"></td>
            </tr>
            <tr>
                <th width="120"><strong>产品名称：</strong></th>
                <td><input name="product[title]" id="title" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo $title; ?>"></td>
            </tr>
            <tr>
                <th><strong>系列：</strong></th>
                <td>
                    <select name="product[series_id]" id="series_id">
                        <option value="">--请选择系列--</option>
                        <?php foreach ($series as $serie) { ?>
                            <option value="<?php echo $serie['id']; ?>"<?php echo $serie['id'] == $series_id ? ' selected="selected"' : ''; ?>><?php echo $serie['title']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th width="120"><strong>功能：</strong></th>
                <td>
                    <select name="product[functions_id]" id="functions_id" onchange="generate_code()">
                        <option value="">--请选择功能--</option>
                        <?php foreach ($functions as $item) { ?>
                            <option value="<?php echo $item['id']; ?>"<?php echo $item['id'] == $functions_id ? ' selected="selected"' : ''; ?>><?php echo $item['title']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php foreach ($product_props as $name => $prop) { ?>
            <tr>
                <th width="120"><strong><?php echo $prop['title']; ?>：</strong></th>
                <td>
                    <select name="product[<?php echo $name; ?>]" id="<?php echo $name; ?>" onchange="generate_code()">
                        <option value="">--请选择<?php echo $prop['title']; ?>--</option>
                        <?php
                        foreach ($prop['options'] as $key => $option) {
                            $selected = ($info[$name] !== null && $key == $info[$name]) ? ' selected="selected"' : '';
                        ?>
                        <option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $key, ' ', $option; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <th><strong>缩略图：</strong></th>
                <td>
                    <?php echo form::images('product[thumb]', 'thumb', $thumb, 'product', '', 40)?>
                </td>
            </tr>
            <tr>
                <th><strong>工程图1：</strong></th>
                <td>
                    <?php echo form::images('product[project_image_1]', 'project_image_1', $project_image_1, 'product', '', 40)?>
                </td>
            </tr>
            <tr>
                <th><strong>工程图2：</strong></th>
                <td>
                    <?php echo form::images('product[project_image_2]', 'project_image_2', $project_image_2, 'product', '', 40)?>
                </td>
            </tr>
            <tr>
                <th><strong>工程图3：</strong></th>
                <td>
                    <?php echo form::images('product[project_image_3]', 'project_image_3', $project_image_3, 'product', '', 40)?>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="bk15"></div>
        <input type="button" name="dosubmit" id="dosubmit" value="提交" class="button">
    </form>
</div>
</body>
</html>
<script type="text/javascript">
// 生成编号
// 规则：系列-{前圈尺寸}{前圈/按键材料}{前圈/按键形状}{前圈/按键颜色}.{开关元件}{照明形式}{LED灯颜色}{LED灯电压}.{前圈/磁}{序列号}
function generate_code() {
    if (!$('#series_id').val()) {
        return true;
    }

    var series_id = $('#series_id').find('option:selected').text();     // 系列
    var front_shape = $('#front_shape').val();                          // 前圈尺寸
    var front_button_material = $('#front_button_material').val();      // 前圈/按键材料
    var front_button_shape = $('#front_button_shape').val();            // 前圈/按键形状
    var front_button_color = $('#front_button_color').val();            // 前圈/按键颜色
    var switch_element = $('#switch_element').val();                    // 开关元件
    var light_style = $('#light_style').val();                          // 照明形式
    var led_color = $('#led_color').val();                              // LED灯颜色
    var led_voltage = $('#led_voltage').val();                          // LED灯电压
    var front_magnetic = $('#front_magnetic').val();                    // 前圈/磁

    var code = [
        series_id, '-', front_shape, front_button_material, front_button_shape, front_button_color, '.',
        switch_element, light_style, led_color, led_voltage, '.', front_magnetic
    ].join('');
    $('#code').val(code);
}

$(document).ready(function(){
    generate_code();

    $('#series_id').change(function () {
        var series_id = $(this).val();
        if (!series_id) {
            return true;
        }

        generate_code();
        var functions_id = <?php echo $functions_id; ?>

        $.get('?m=product&c=product&a=get_functions_by_series_id&series_id=' + series_id + '&pc_hash=<?php echo $_GET['pc_hash']; ?>', function(response) {
            var functions = $.parseJSON(response);
            $('#functions_id').find('option:gt(0)').remove();
            if (functions.length === 0) {
                return true;
            }

            var html = [], tmp = {}, selected = '';
            for (var i = 0;i < functions.length;i++) {
                tmp = functions[i];
                selected = tmp['id'] == functions_id ? ' selected="selected"' : '';
                html.push('<option value="' + tmp['id'] + '"' + selected + '>' + tmp['title'] + '</option>');
            }
            $('#functions_id').find('option:eq(0)').after(html.join(''));
        });
    });
    $('#series_id').change();

    $('#dosubmit').click(function () {
        var title = $.trim($('#title').val());
        var thumb = $.trim($('#thumb').val());

        if (!title) {
            alert('请输入标题');
            return false;
        }
        if (!thumb) {
            alert('请上传缩略图');
            return false;
        }
        var data = {
            id: $.trim($('#product_id').val()) - 0,
            title: title,
            thumb: thumb,
            functions_id: $('#functions_id').val(),
            series_id: $('#series_id').val(),
            project_image_1: $('#project_image_1').val(),
            project_image_2: $('#project_image_2').val(),
            project_image_3: $('#project_image_3').val()
        };

        <?php
            foreach ($product_props as $name => $prop) {
                echo 'var ',$name,' = $.trim($("#',$name,'").val());',"\r\n";
                echo 'if (!',$name,') { alert("请选择',$prop['title'],'"); return false; }',"\r\n";
                echo 'data["',$name,'"] = ',$name,';';
            }
        ?>

        $.ajax({
            type: 'POST',
            url: '?m=product&c=product&a=add&pc_hash=<?php echo $_GET['pc_hash']; ?>',
            data: {
                product: data
            },
            beforeSend: function () {
                $('#dosubmit').attr('disabled', 'disabled');
                $('#dosubmit').val('正在提交数据，请稍候...');
            },
            success: function (response) {
                $('#dosubmit').removeAttr('disabled');
                $('#dosubmit').val('提交');

                if (response === 'success') {
                    alert('操作成功');
                    location.href = '?m=product&c=product&a=config_list&pc_hash=<?php echo $_GET['pc_hash']; ?>';
                }
            },
            error: function (error) {
                $('#dosubmit').removeAttr('disabled');
                $('#dosubmit').val('提交');
            }
        });
    });
});
</script>