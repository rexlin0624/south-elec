<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
$id = isset($info['id']) ? $info['id'] : 0;
$title = isset($info['title']) ? $info['title'] : '';
$thumb = isset($info['thumb']) ? $info['thumb'] : '';
$market_id = isset($info['market_id']) ? $info['market_id'] : 0;
$series_id = isset($info['series_id']) ? $info['series_id'] : 0;
?>
<div class="pad-10">
    <form method="post" action="?m=product&c=functions&a=add" name="myform" id="myform">
        <input type="hidden" name="functions[id]" value="<?php echo $id; ?>">
        <table class="table_form" width="100%" cellspacing="0">
            <tbody>
            <tr>
                <th width="80"><strong>市场：</strong></th>
                <td>
                    <select name="functions[market_id]" id="market_id">
                        <option value="">--请选择市场--</option>
                        <?php foreach ($markets as $market) { ?>
                        <option value="<?php echo $market['id']; ?>"<?php echo $market['id'] == $market_id ? ' selected="selected"' : ''; ?>><?php echo $market['title']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th width="80"><strong>系列：</strong></th>
                <td>
                    <select name="functions[series_id]" id="series_id">
                        <option value="">--请选择系列--</option>
                        <?php foreach ($series as $item) { ?>
                        <option value="<?php echo $item['id']; ?>"<?php echo $item['id'] == $series_id ? ' selected="selected"' : ''; ?>><?php echo $item['title']; ?></option>
                        <?php } ?>
                    </select>
                </td>
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

        $('#myform').submit();
    });
});
</script>