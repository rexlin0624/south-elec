<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
$id = isset($info['id']) ? $info['id'] : 0;
$code = isset($info['code']) ? $info['code'] : '';
$title = isset($info['title']) ? $info['title'] : '';
$thumb = isset($info['thumb']) ? $info['thumb'] : '';
$market_id = isset($info['market_id']) ? $info['market_id'] : '';
$series_id = isset($info['series_id']) ? $info['series_id'] : '';

$arr_market_id = explode(',', $market_id);
$arr_series_id = explode(',', $series_id);
?>
<div class="pad-10">
    <form method="post" action="?m=product&c=functions&a=add" name="myform" id="myform">
        <input type="hidden" name="functions[id]" value="<?php echo $id; ?>">
<!--        <input type="hidden" name="functions[market_id]" id="s_market_id" value="--><?php //echo $market_id; ?><!--">-->
<!--        <input type="hidden" name="functions[series_id]" id="s_series_id" value="--><?php //echo $series_id; ?><!--">-->
        <table class="table_form" width="100%" cellspacing="0">
            <tbody>
            <!--<tr>
                <th width="80"><strong>市场：</strong></th>
                <td>
                    <select id="market_id">
                        <?php /*foreach ($markets as $market) { */?>
                        <option value="<?php /*echo $market['id']; */?>"<?php /*echo in_array($market['id'], $arr_market_id) ? ' selected="selected"' : ''; */?>><?php /*echo $market['title']; */?></option>
                        <?php /*} */?>
                    </select>
                </td>
            </tr>
            <tr>
                <th width="80"><strong>系列：</strong></th>
                <td>
                    <select id="series_id">
                        <?php /*foreach ($series as $item) { */?>
                        <option value="<?php /*echo $item['id']; */?>"<?php /*echo in_array($item['id'], $arr_series_id) ? ' selected="selected"' : ''; */?>><?php /*echo $item['title']; */?></option>
                        <?php /*} */?>
                    </select>
                </td>
            </tr>-->
            <tr>
                <th width="80"><strong>代码：</strong></th>
                <td><input name="functions[code]" id="code" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo $code; ?>"></td>
            </tr>
            <tr>
                <th width="80"><strong>标题：</strong></th>
                <td><input name="functions[title]" id="title" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo $title; ?>"></td>
            </tr>
            <tr>
                <th><strong>缩略图：</strong></th>
                <td>
                    <?php echo form::images('functions[thumb]', 'thumb', $thumb, 'functions', '', 40)?>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="bk15"></div>
<!--        <div style="color: #FF0000;font-size: 10px;">注：按住Ctrl可多选</div>-->
        <input type="button" name="dosubmit" id="dosubmit" value="提交" class="button">
    </form>
</div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
    $('#market_id').click(function () {
        var values = $(this).val();
        $('#s_market_id').val(',' + values.join(',') + ',');
    });

    $('#series_id').click(function () {
        var values = $(this).val();
        $('#s_series_id').val(',' + values.join(',') + ',');
    });

    $('#dosubmit').click(function () {
        var code = $.trim($('#code').val());
        var title = $.trim($('#title').val());
        var thumb = $.trim($('#thumb').val());

        /*if (!$('#s_market_id').val()) {
            alert('请选择市场');
            return false;
        }
        if (!$('#s_series_id').val()) {
            alert('请选择系列');
            return false;
        }*/

        if (!code) {
            alert('请输入代码');
            return false;
        }
        if (!title) {
            alert('请输入标题');
            return false;
        }
        if (!thumb) {
            alert('请上传缩略图');
            return false;
        }

        $('#myform').submit();
    });
});
</script>