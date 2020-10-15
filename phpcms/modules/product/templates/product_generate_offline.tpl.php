<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
    <input type="button" id="generate_offline" value="点击生成离线版本" class="button">
</div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
    $('#generate_offline').click(function () {
        location.href = '?m=product&c=product&a=download_offline&pc_hash=<?php echo $_GET['pc_hash']; ?>';
        /*$.ajax({
            type: 'POST',
            url: '?m=product&c=product&a=generate_offline&pc_hash=<?php echo $_GET['pc_hash']; ?>',
            data: {generate: 1},
            beforeSend: function () {
                $('#generate_offline').val('正在生成，请稍候...').attr('disabled', 'disabled');
            },
            success: function (response) {
                $('#generate_offline').val('点击生成离线版本').removeAttr('disabled');
                console.log('response ===>', response);

                // redirect to download url
                location.href = '?m=product&c=product&a=download_offline&file=' + response + '&pc_hash=<?php echo $_GET['pc_hash']; ?>';
            }
        });*/
    });
});
</script>