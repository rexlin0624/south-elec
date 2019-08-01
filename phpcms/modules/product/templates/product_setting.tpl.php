<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
    <form method="post" action="?m=product&c=product&a=setting" name="myform" id="myform">
        <input type="hidden" name="product[id]" value="<?php echo !empty($info) ? $info['id'] : 0; ?>">
        <table class="table_form" width="100%" cellspacing="0">
            <tbody>
            <tr>
                <th width="80"><strong>标题：</strong></th>
                <td><input name="product[title]" id="title" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['title'] : ''; ?>"></td>
            </tr>
            <tr>
                <th><strong>描述：</strong></th>
                <td><textarea name="product[description]" id="description" style="width: 350px;height:80px;"><?php echo !empty($info) ? $info['description'] : ''; ?></textarea></td>
            </tr>
            <tr>
                <th><strong>PDF头部：</strong></th>
                <td><input name="product[pdf_title]" id="pdf_title" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['pdf_title'] : ''; ?>"></td>
            </tr>
            <tr>
                <th><strong>PDF描述：</strong></th>
                <td><input name="product[pdf_desc]" id="pdf_desc" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['pdf_desc'] : ''; ?>"></td>
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
        var description = $.trim($('#description').val());

        if (!title) {
            alert('请输入标题');
            return false;
        }
        if (!description) {
            alert('请输入描述');
            return false;
        }

        $('#myform').submit();
    });
});
</script>