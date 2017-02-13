<?php

	/*
	 * 订单模型
	 *
	 *
	*/

	class OrderModel extends Model{
		
		
		
		/*
		 * 获取单个订单信息
		 *
		*/
		public function getOrder($order_id){
			
			$sql = 'select * from orders where order_id = '.$order_id;
			$result = $this->query($sql);
			return $result;
			
		}
		
		
		/*
		 * 查看商品所有订单
		 *
		*/
		public function getOrdersByGid($gid){
			
			$sql = 'select * from orders where goods_id = '.$gid;
			$result = $this->query($sql);
			return $result;
			
		}


		/*
		 * 创建订单
		 *
		*/
		public function create_order($data){
			$sql = 'insert into orders (order_id,goods_id,uid,addtime) values ("'.$data['order_id'].'","'.$data['goods_id'].'","'.$data['uid'].'","'.$data['addtime'].'")';
			$result = $this->exect($sql);
			return $result;
		}

		

		/*
		 * 生成订单号
		 *
		*/
		public function buildOrderNo(){
			return date('ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
		}

		
	}