<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
    <table width="100%" cellspacing="0" class="table-list nHover">
        <thead>
        <tr>
            <th></th>
            <th >名称</th>
            <th width="160"><?php echo L('operations_manage')?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(is_array($infos)){
            foreach($infos as $info){
                ?>
                <tr>
                    <td width="100"><img src="<?php echo $info['thumb']?>" style="height: 100px;"></td>
                    <td align="center"><?php echo $info['title']?></td>
                    <td align="center">
                        <span style="height:22"><a href="?m=product&c=market&a=add&id=<?php echo $info['id']?>&menuid=<?php echo $_GET['menuid']?>">修改</a></span> |
                        <span style="height:22"><a href="?m=product&c=market&a=delete&id=<?php echo $info['id']?>" onclick="return confirm('<?php echo L('confirm', array('message'=>addslashes(new_html_special_chars($info['title']))))?>')">删除</a></span>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
<script type="text/javascript">
    function edit(id, name) {
        window.top.art.dialog({id:'edit'}).close();
        window.top.art.dialog({title:'<?php echo L('edit_special')?>--'+name, id:'edit', iframe:'?m=special&c=special&a=edit&specialid='+id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;// 使用内置接口获取iframe对象
            var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
    }
</script>