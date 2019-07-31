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
                        <span style="height:22"><a href="?m=product&c=functions&a=add&id=<?php echo $info['id']?>&menuid=<?php echo $_GET['menuid']?>">修改</a></span> |
                        <span style="height:22"><a href="?m=product&c=functions&a=delete&id=<?php echo $info['id']?>" onclick="return confirm('<?php echo L('confirm', array('message'=>addslashes(new_html_special_chars($info['title']))))?>')">删除</a></span>
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