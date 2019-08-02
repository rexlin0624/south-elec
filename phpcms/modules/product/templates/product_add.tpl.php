<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
$id = isset($info['id']) ? $info['id'] : 0;
$title = isset($info['title']) ? $info['title'] : '';
$thumb = isset($info['thumb']) ? $info['thumb'] : '';
$functions_id = isset($info['functions_id']) ? $info['functions_id'] : 0;
?>
<div class="pad-10">
    <form method="post" action="?m=product&c=product&a=add" name="myform" id="myform">
        <input type="hidden" name="product[id]" id="product_id" value="<?php echo $id; ?>">
        <table class="table_form" width="100%" cellspacing="0">
            <tbody>
            <tr>
                <th width="120"><strong>产品名称：</strong></th>
                <td><input name="product[title]" id="title" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo $title; ?>"></td>
            </tr>
            <tr>
                <th><strong>缩略图：</strong></th>
                <td>
                    <?php echo form::images('product[thumb]', 'thumb', $thumb, 'product', '', 40)?>
                </td>
            </tr>
            <tr>
                <th width="120"><strong>功能：</strong></th>
                <td>
                    <select name="product[functions_id]" id="functions_id">
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
                    <select name="product[<?php echo $name; ?>]" id="<?php echo $name; ?>">
                        <option value="">--请选择<?php echo $prop['title']; ?>--</option>
                        <?php
                        foreach ($prop['options'] as $key => $option) {
                            $selected = ($key == $info[$name]) ? ' selected="selected"' : '';
                        ?>
                        <option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $key, ' ', $option; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="bk15"></div>
        <input type="button" name="dosubmit" id="dosubmit" value="提交" class="button">
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
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
                functions_id: $('#functions_id').val()
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
                        //alert('操作成功');
                        //location.href = '?m=product&c=product&a=config_list&pc_hash=<?php //echo $_GET['pc_hash']; ?>//';
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