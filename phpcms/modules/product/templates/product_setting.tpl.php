<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<link rel="stylesheet" type="text/css" href="/statics/jquery_ui/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/statics/colorpicker/jquery.colorpicker.css" />
<div class="pad-10">
    <form method="post" action="?m=product&c=product&a=setting" name="myform" id="myform">
        <input type="hidden" name="product[id]" value="<?php echo !empty($info) ? $info['id'] : 0; ?>">
        <table class="table_form" width="100%" cellspacing="0">
            <tbody>
            <tr>
                <th width="120"><strong>标题：</strong></th>
                <td><input name="product[title]" id="title" class="input-text" type="text" size="50" style="width: 350px;" value="<?php echo !empty($info) ? $info['title'] : ''; ?>"></td>
            </tr>
            <tr>
                <th><strong>描述：</strong></th>
                <td><textarea name="product[description]" id="description" style="width: 350px;height:80px;"><?php echo !empty($info) ? $info['description'] : ''; ?></textarea></td>
            </tr>
            <tr>
                <th><strong>PDF头部：</strong></th>
                <td>
                    <script type="text/javascript" src="/statics/js/ckeditor/ckeditor.js"></script>
                    <textarea name="product[pdf_title]" cols="50" rows="8" id="pdf_title"><?php echo !empty($info) ? $info['pdf_title'] : ''; ?></textarea>
                    <script type="text/javascript">
                        CKEDITOR.replace( 'pdf_title',{height:200,width:600,pages:false,subtitle:false,textareaid:'content',module:'',catid:'',
                            flashupload:true,alowuploadexts:'',allowbrowser:'1',allowuploadnum:'10',authkey:'c8e07e653e467f2f1b2058ee44db799c',
                            filebrowserUploadUrl : '/index.php?m=attachment&c=attachments&a=upload&module=&catid=&dosubmit=1',
                            toolbar :
                                [
                                    [ 'Font', 'TextColor', 'FontSize' ],    //这是工具列表
                                ]
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <th><strong>PDF描述：</strong></th>
                <td>
                    <textarea name="product[pdf_desc]" cols="50" rows="8" id="pdf_desc"><?php echo !empty($info) ? $info['pdf_desc'] : ''; ?></textarea>
                    <script type="text/javascript">
                        CKEDITOR.replace( 'pdf_desc',{height:200,width:600,pages:false,subtitle:false,textareaid:'content',module:'',catid:'',
                            flashupload:true,alowuploadexts:'',allowbrowser:'1',allowuploadnum:'10',authkey:'c8e07e653e467f2f1b2058ee44db799c',
                            filebrowserUploadUrl : '/index.php?m=attachment&c=attachments&a=upload&module=&catid=&dosubmit=1',
                            toolbar :
                                [
                                    [ 'Font', 'TextColor', 'FontSize' ],    //这是工具列表
                                ]
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <th><strong>PDF头部背景颜色：</strong></th>
                <td>
                    <input type="text" id="colorpicker-popup" name="product[header_bgcolor]" value="<?php echo !empty($info) ? $info['header_bgcolor'] : '939598'; ?>">
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
<script type="text/javascript" src="/statics/jquery_ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/statics/colorpicker/jquery.colorpicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#colorpicker-popup').colorpicker({
        parts:      'full',
        alpha:      true,
        showOn:     'both',
        buttonColorize: true,
        showNoneButton: true
    });

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