<?php


	/*
	 * 订单表
	 *
	 *
	*/

	class order extends common{


		private $_orderModel = null;
		private $_goodsModel = null;

		/*
		 * 构造器
		 *
		*/
		public function __construct(){

			if($this->_orderModel === null){
				$this->_orderModel = new OrderModel();
			}

			if($this->_goodsModel === null){
				$this->_goodsModel = new GoodsModel();
			}
			
		}


		/*
		 * 查看订单列表
		 *
		*/
		public function orderList(){

			$gid 		= $_GET['gid'];
			$goodsInfo 	= $this->_goodsModel->getGoods($gid);
			if(!$goodsInfo){
				exit('商品不存在');
			}
			$list = $this->_orderModel->getOrdersByGid($gid);
			$this->render('',['list'=>$list]);
		}







	}