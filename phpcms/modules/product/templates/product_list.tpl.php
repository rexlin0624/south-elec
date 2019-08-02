<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
    <form name="myform" action="?m=special&c=special&a=listorder" method="post">
        <table width="100%" cellspacing="0" class="table-list nHover">
            <thead>
            <tr>
                <th></th>
                <th>功能</th>
                <th >产品名称</th>
                <th >添加时间</th>
                <th width="160"><?php echo L('operations_manage')?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(is_array($infos)){
                foreach($infos as $info){
                    ?>
                    <tr>
                        <td><img src="<?php echo $info['thumb']?>" style="height: 100px;"></td>
                        <td align="center"><?php echo $info['function']?></td>
                        <td align="center"><?php echo $info['title']?></td>
                        <td align="center"><?php echo date('Y-m-d H:i:s', $info['created_at'])?></td>
                        <td align="center">
                            <span style="height:22">
                                <span style="height:22"><a href="/caches/pdf/<?php echo $info['id']; ?>.pdf" target="_blank">PDF</a></span> |
                                <span style="height:22"><a href="?m=product&c=product&a=add&id=<?php echo $info['id']?>&menuid=<?php echo $_GET['menuid']?>">修改</a></span> |
                                <span style="height:22"><a href="?m=product&c=product&a=delete&id=<?php echo $info['id']?>" onclick="return confirm('<?php echo L('confirm', array('message'=>addslashes(new_html_special_chars($info['title']))))?>')">删除</a>
                            </span>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>

        <div id="pages"><?php echo $this->db->pages;?></div><script>window.top.$("#display_center_id").css("display","none");</script>
    </form>
</div>
</body>
</html>