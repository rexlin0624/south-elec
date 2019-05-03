<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="member" name="m">
<input type="hidden" value="member" name="c">
<input type="hidden" value="orders" name="a">
<input type="hidden" value="1592" name="menuid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				下单时间：
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>
							
				<select name="status">
					<option value='-2' <?php if(isset($_GET['status']) && $_GET['status']==-2){?>selected<?php }?>><?php echo L('status')?></option>
					<option value='-1' <?php if(isset($_GET['status']) && $_GET['status']==-1){?>selected<?php }?>>已作废</option>
					<option value='0' <?php if(isset($_GET['status']) && $_GET['status']==0){?>selected<?php }?>>未支付</option>
					<option value='1' <?php if(isset($_GET['status']) && $_GET['status']==1){?>selected<?php }?>>已支付</option>
					<option value='2' <?php if(isset($_GET['status']) && $_GET['status']==2){?>selected<?php }?>>已发货</option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" placeholder="请输入关键字" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form name="myform" action="?m=member&c=member&a=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left">订单号</th>
			<th align="left">收货人</th>
			<th align="left">联系电话</th>
			<th align="left">收货地址</th>
			<th align="left">下单时间</th>
			<th align="left">订单状态</th>
			<th align="left"><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($order_list)){
	foreach($order_list as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['id']?>" name="id[]"></td>
		<td align="left"><?php echo $v['order_no']?></td>
		<td align="left"><?php echo $v['name']?></td>
		<td align="left"><?php echo $v['phone']?></td>
		<td align="left"><?php echo $v['addressee']?></td>
		<td align="left"><?php echo $v['order_time']?></td>
        <td align="left"><?php echo $v['order_status']?></td>
		<td align="left">
			<a href="javascript:edit(<?php echo $v['id']?>, '<?php echo $v['order_no']?>')">[详细]</a>
            |
            <a href="javascript:dispatch(<?php echo $v['id']?>, '<?php echo $v['order_no']?>')">[发货]</a>
            |
            <a href="javascript:remove(<?php echo $v['id']?>, '<?php echo $v['order_no']?>')">[作废]</a>
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
function edit(id, order_no) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'查看订单《'+order_no+'》',id:'edit',iframe:'?m=member&c=member&a=order_detail&id='+id,width:'700',height:'500'}, function(){window.top.art.dialog({id:'edit'}).close()}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function dispatch(id, order_no) {
    window.top.art.dialog({content:'确定发货订单-' + order_no + '？',lock:true,width:'200',height:'50'},function(){
        $.ajax({
            type: 'POST',
            url: '?m=member&c=member&a=order_dispatch&pc_hash=<?php echo $_GET["pc_hash"]; ?>',
            data: {
              id: id
            },
            beforeSend: function () {
                //
            },
            success: function (response) {
                window.top.art.dialog({content:'发货成功',lock:true,width:'200',height:'50',time:1.5}, function(){ });
                location.reload();
            }
        });
    });
}
function remove(id, order_no) {
    window.top.art.dialog({content:'确定作废订单-' + order_no + '？',lock:true,width:'200',height:'50'},function(){
        $.ajax({
            type: 'POST',
            url: '?m=member&c=member&a=order_remove&pc_hash=<?php echo $_GET["pc_hash"]; ?>',
            data: {
                id: id
            },
            beforeSend: function () {
                //
            },
            success: function (response) {
                window.top.art.dialog({content:'作废成功',lock:true,width:'200',height:'50',time:1.5}, function(){ });
                location.reload();
            }
        });
    });
}
</script>
</body>
</html>