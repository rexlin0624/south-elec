<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
    <form method="post" action="?m=product&c=product&a=contact" name="myform" id="myform">
        <input type="hidden" name="contact[id]" value="<?php echo !empty($info) ? $info['id'] : 0; ?>">
        <table class="table_form" width="100%" cellspacing="0">
            <tbody>
            <tr>
                <th width="100"><strong>联系电话：</strong></th>
                <td><input name="contact[telephone]" id="telephone" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['telephone'] : ''; ?>"></td>
            </tr>
            <tr>
                <th width="120"><strong>QQ：</strong></th>
                <td><input name="contact[qq]" id="qq" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['qq'] : ''; ?>"></td>
            </tr>
            <tr>
                <th width="120"><strong>微信：</strong></th>
                <td><input name="contact[wechat]" id="wechat" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['wechat'] : ''; ?>"></td>
            </tr>
            <tr>
                <th width="120"><strong>邮箱：</strong></th>
                <td><input name="contact[email]" id="email" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['email'] : ''; ?>"></td>
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
        var telephone = $.trim($('#telephone').val());
        var qq = $.trim($('#qq').val());
        var wechat = $.trim($('#wechat').val());
        var email = $.trim($('#email').val());

        /*if (!telephone) {
            alert('联系电话');
            return false;
        }
        if (!qq) {
            alert('请输入QQ');
            return false;
        }
        if (!wechat) {
            alert('请输入微信');
            return false;
        }
        if (!email) {
            alert('请输入邮箱');
            return false;
        }*/

        $('#myform').submit();
    });
});
</script>