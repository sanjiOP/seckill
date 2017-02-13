<!DOCTYPE html>
<html>
<head>
	<title>订单列表</title>
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" >
</head>
<body>


<div class="container">
	<div class="row">
		<div class="col-md-2"><a href="./index.php" class="btn btn-default">商品列表</a></div>
		<div class="col-md-8">
			<h3 style="text-align: center;color:green;">订单列表</h3>
			<table class="table">
				<tr>
					<th>序号</th>
					<th>订单编号</th>
					<th>商品id</th>
					<th>用户id</th>
					<th>操作时间</th>
				</tr>
				<?php
					foreach($list as $v){
						echo '<tr><td>'.$v['id'].'</td><td>'.$v['order_id'].'</td><td>'.$v['goods_id'].'</td><td>'.$v['uid'].'</td><td>'.$v['addtime'].'</td></tr>';
					}
				?>
				</table>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>

</body>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>