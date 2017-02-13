<!DOCTYPE html>
<html>
<head>
	<title>商品列表</title>
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" >
</head>
<body>


<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			
			<h3 style="text-align: center;color:green;">商品列表</h3>
			<table class="table">
				<tr>
					<th>编号</th>
					<th>商品名称</th>
					<th>库存</th>
					<th>redis库存</th>
					<th>操作</th>
				</tr>
				<?php
					foreach($list as $v){
						echo '<tr><td>'.$v['id'].'</td><td>'.$v['goods_name'].'</td><td>'.$v['counts'].'</td><td>'.$v['rediscount'].'</td><td><a href="javascript:void(0);" class="btn btn-default setcount" data-id='.$v['id'].' data-goodsname='.$v['goods_name'].' data-counts='.$v['counts'].'>修改库存</a><a href="./index.php?app=app&c=order&a=orderList&gid='.$v['id'].'" class="btn btn-default">查看订单</a></td></tr>';
					}
				?>
				</table>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">修改库存</h4>
      </div>
      <div class="modal-body">
        
      	<form id="post-form-gs">
      		<input type="hidden" id="gid" name='gid' value=0>
			<div class="form-group">
				<label for="goods_name">商品名称</label>
				<input type="text" class="form-control" id="goods_name" readonly >
			</div>
			<div class="form-group">
				<label for="counts">库存</label>
				<input type="text" name="counts" class="form-control" id="counts" placeholder="请填写整数库存" >
			</div>
      	</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="post-modal-data" data-posttarget="./index.php?app=app&c=goods&a=setGoodsCount">Save</button>
      </div>
    </div>
  </div>
</div>



</body>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script>

	var formGroupValur = {
		'id':0,
		'goods_name':'',
		'counts':0
	};



	/*
	 * 设置商品库存
	 *
	*/
	$('.setcount').bind('click',function(){
		formGroupValur.id 			= $(this).data('id');
		formGroupValur.goods_name 	= $(this).data('goodsname');
		formGroupValur.counts 		= $(this).data('counts');
		$('#myModal').modal('show');
	});

	
	/*
	 * 监听打开事件，渲染modal模板
	 *
	*/
	$('#myModal').on('show.bs.modal', function (e) {
		$('#goods_name').val(formGroupValur.goods_name);
		$('#gid').val(formGroupValur.id);
		$('#counts').val(formGroupValur.counts);
	});


	/**
	 * 提交事件
	 *
	*/
	$('#post-modal-data').bind('click',function(e){

		var target = $(this).data('posttarget');
		var pdata = $('#post-form-gs').serialize();
		$.post(target,pdata,function(data){
			if(data.status){
				alert(data.info);
				document.location.href = document.location.href;
			}
		},'JSON');
	})



</script>

</html>