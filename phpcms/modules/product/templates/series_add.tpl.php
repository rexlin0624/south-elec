<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
    <form method="post" action="?m=product&c=series&a=add" name="myform" id="myform">
        <input type="hidden" name="series[id]" value="<?php echo isset($info['id']) ? $info['id'] : ''; ?>">
        <table class="table_form" width="100%" cellspacing="0">
            <tbody>
            <tr>
                <th width="80"><strong>语言：</strong></th>
                <td>
                    <input type="radio" name="series[lang]" value="1"<?php echo (!isset($info['lang']) || $info['lang'] == 1) ? ' checked="checked"' : ''; ?>>&nbsp;中文
                    <input type="radio" name="series[lang]" value="2"<?php echo (isset($info['lang']) && $info['lang'] == 2) ? ' checked="checked"' : ''; ?>>&nbsp;English
                </td>
            </tr>
            <tr>
                <th width="80"><strong>标题：</strong></th>
                <td><input name="series[title]" id="title" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo isset($info['title']) ? $info['title'] : ''; ?>"></td>
            </tr>
            <tr style="display: none;">
                <th><strong>缩略图：</strong></th>
                <td>
                    <?php echo form::images('series[thumb]', 'thumb', isset($info['thumb']) ? $info['thumb'] : '', 'series', '', 40)?>
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
        /*if (!thumb) {
            alert('请上传缩略图');
            return false;
        }*/

        $('#myform').submit();
    });
});
</script>