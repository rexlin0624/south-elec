<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<style type="text/css">
    .tab-setting {
        list-style-type: none;
        padding: 5px;
    }
    .tab-setting li {
        display: inline-block;
        width: 60px;
        text-align: center;
        cursor: pointer;
    }
    .tab-setting li.active {
        background-color: #32514b;
        color: #FFFFFF;
    }
</style>
<div class="pad-10">
    <form method="post" action="?m=product&c=functions&a=setting" name="myform" id="myform">
        <input type="hidden" name="functions[id]" value="<?php echo !empty($info) ? $info['id'] : 0; ?>">
        <ul id="product-setting-tab" class="tab-setting">
            <li data-lang="cn" class="active">中文</li>
            <li data-lang="en">English</li>
        </ul>
        <table id="tbl-cn" class="table_form" width="100%" cellspacing="0">
            <tbody>
            <tr>
                <th width="80"><strong>标题：</strong></th>
                <td><input name="functions[title]" id="title" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['title'] : ''; ?>"></td>
            </tr>
            <tr>
                <th><strong>描述：</strong></th>
                <td><textarea name="functions[description]" id="description" style="width: 350px;height:50px;"><?php echo !empty($info) ? $info['description'] : ''; ?></textarea></td>
            </tr>
            <tr>
                <th><strong>缩略图：</strong></th>
                <td>
                    <?php echo form::images('functions[thumb]', 'thumb', !empty($info) ? $info['thumb'] : '', 'functions', '', 40)?>
                    <br /><br />
                    <img id="thumb_preview" src="<?php echo !empty($info) ? $info['thumb'] : ''; ?>">
                </td>
            </tr>
            </tbody>
        </table>
        <table id="tbl-en" class="table_form" width="100%" cellspacing="0" style="display: none;">
            <tbody>
            <tr>
                <th width="80"><strong>标题：</strong></th>
                <td><input name="functions[title_en]" id="title_en" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['title_en'] : ''; ?>"></td>
            </tr>
            <tr>
                <th><strong>描述：</strong></th>
                <td><textarea name="functions[description_en]" id="description_en" style="width: 350px;height:50px;"><?php echo !empty($info) ? $info['description_en'] : ''; ?></textarea></td>
            </tr>
            <tr>
                <th><strong>缩略图：</strong></th>
                <td>
                    <?php echo form::images('functions[thumb_en]', 'thumb_en', !empty($info) ? $info['thumb_en'] : '', 'functions', '', 40)?>
                    <br /><br />
                    <img id="thumb_preview" src="<?php echo !empty($info) ? $info['thumb_en'] : ''; ?>">
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
    $('#thumb').bind('input', function() {
        console.log($(this).val());
    });

    $('#dosubmit').click(function () {
        var title = $.trim($('#title').val());
        var description = $.trim($('#description').val());
        var thumb = $.trim($('#thumb').val());

        if (!title) {
            alert('请输入标题');
            return false;
        }
        if (!description) {
            alert('请输入描述');
            return false;
        }
        if (!thumb) {
            alert('请上传缩略图');
            return false;
        }

        $('#myform').submit();
    });

    $('#product-setting-tab').find('li').click(function () {
        var lang = $(this).attr('data-lang');

        $('#product-setting-tab').find('li').removeClass('active');
        $(this).addClass('active');

        $('.table_form').hide();
        $('#tbl-' + lang).show();
    });
});
</script>