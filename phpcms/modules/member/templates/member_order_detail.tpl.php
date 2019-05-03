<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member&a=edit" method="post" id="myform">
<fieldset>
	<legend>订单信息</legend>
	<table width="100%" class="table_form">
		<tr>
			<td>订单号</td>
			<td><?php echo $info['order_no']; ?></td>
		</tr>
        <tr>
            <td>订单金额</td>
            <td><?php echo $info['order_sum']; ?></td>
        </tr>
		<tr>
			<td>收货人</td>
			<td><?php echo $info['name']; ?></td>
		</tr>
		<tr>
			<td>联系电话</td>
			<td><?php echo $info['phone']; ?></td>
		</tr>
		<tr>
			<td>收货地址</td>
			<td><?php echo $info['addressee']; ?></td>
		</tr>
		<tr>
			<td>订单状态</td>
			<td><?php echo $info['order_status']; ?></td>
		</tr>
		<tr>
			<td>下单时间</td>
			<td><?php echo $info['order_time']; ?></td>
		</tr>
	</table>
</fieldset>
<br />
<fieldset>
    <legend>订单商品</legend>
    <table width="100%" class="table_form">
        <tr>
            <td style="font-weight: bold;">商品名称</td>
            <td style="font-weight: bold;">购买数量</td>
            <td style="font-weight: bold;">金额</td>
        </tr>
        <?php
            if (!empty($arr_order_detail) && is_array($arr_order_detail)) {
                foreach ($arr_order_detail as $item) {
                    ?>
                    <tr>
                        <td><?php echo $item['title']; ?></td>
                        <td><?php echo $item['total']; ?></td>
                        <td><?php echo $item['price']; ?></td>
                    </tr>
                    <?php
                }
            }
        ?>
    </table>
</fieldset>
</form>
</div>
</div>
</body>
</html>