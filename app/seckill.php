<?php


/**********************************************
* 抢购模块
*
* @author liubin
* @date 2016-02-10
*
*/
class seckill extends common
{
	

	private $_orderModel = null;
	private $_goodsModel = null;
	private $_redis = null;

	/*
	 * 错误信息
	*/
	protected $_error = '';

	/**
	 * 构造器
	 *
	*/
	public function __construct()
	{
		if($this->_orderModel === null){
			$this->_orderModel = new OrderModel();
		}

		if($this->_goodsModel === null){
			$this->_goodsModel = new GoodsModel();
		}

		if($this->_redis === null){
			$this->_redis = new QRedis(); 
		}
	}




	/*
	 * 秒杀API
	 * 
	 * @author liubin
	 * @date 2017-02-10
	*/
	public function addQsec(){

		$gid 	= intval($_GET['gid']);
		$type	= isset($_GET['type']) ? $_GET['type'] : 'mysql';
		switch ($type) {
			case 'mysql':
				$this->order_check_mysql($gid);
				echo $this->getError();
				break;
			case 'redis':
				$this->order_check_redis($gid);
				echo $this->getError();
				break;
			case 'transaction':
				$this->order_check_transaction($gid);
				echo $this->getError();
				break;
			default:
				echo '类型错误';
				break;
		}


	}

	/*
	 * 获取错误信息
	 * 
	 * @author liubin
	 * @date 2017-02-10
	*/
	public function getError(){
		return $this->_error;
	}



	/*
	 * 基于mysql验证库存信息
	 * @desc 高并发下会导致超卖
	 *
	 * @author liubin
	 * @date 2017-02-10
	*/
	protected function order_check_mysql($gid){

		$goodsInfo 	= $this->_goodsModel->getGoods($gid);
		if(!$goodsInfo){
			$this->_error = '商品不存在';
			return false;
		}

		if($goodsInfo['counts']>0){
			
			//创订单
			$data 				= [];
			$data['order_id'] 	= $this->_orderModel->buildOrderNo();
			$data['goods_id'] 	= $goodsInfo['id'];
			$data['addtime'] 	= time();
			$data['uid']		= 1;
			$order_rs 			= $this->_orderModel->create_order($data);
			
			//去库存
			$gid 	= $goodsInfo['id'];
			$sql	= 'UPDATE goods SET counts = counts - 1 WHERE id = '.$gid;
			$result = $this->_goodsModel->exect($sql);
			$this->_error = '购买成功';
			return true;
		}else{
			$this->_error = '库存不足';
			return false;
		}
	}





	/*
	 * 基于redis队列验证库存信息
	 * @desc Redis是底层是单线程的,命令执行是原子操作,包括lpush,lpop等.高并发下不会导致超卖
	 *
	 * @author liubin
	 * @date 2017-02-10
	*/
	protected function order_check_redis($gid){

		$goodsInfo 	= $this->_goodsModel->getGoods($gid);
		if(!$goodsInfo){
			$this->_error = '商品不存在';
			return false;
		}

		$key 	= 'goods_list_'.$goodsInfo['id'];
		$count 	= $this->_redis->getHandel()->lpop($key);
		if(!$count){
			$this->_error = '库存不足';
			return false;
		}

		//生成订单
		$data 				= [];
		$data['order_id'] 	= $this->_orderModel->buildOrderNo();
		$data['goods_id'] 	= $goodsInfo['id'];
		$data['addtime'] 	= time();
		$data['uid']		= 1;
		$order_rs 			= $this->_orderModel->create_order($data);
		
		//库存减少
		$gid 	= $goodsInfo['id'];
		$sql	= 'UPDATE goods SET counts = counts - 1 WHERE id = '.$gid;
		$result = $this->_goodsModel->exect($sql);
		$this->_error = '购买成功';
		return true;
	}




	/*
	 * 基于mysql事务验证库存信息
	 * @desc 事务 和 行锁 模式,高并发下不会导致超卖，但效率会慢点
	 * 
	 * @link http://www.cnblogs.com/ymy124/p/3718439.html
	 * @author liubin
	 * @date 2017-02-10
	*/
	protected function order_check_transaction($gid){



	}




	/*
	 * 创建订单
	 * mysql 事物处理，也可以用存储过程
	 *
	*/
	private function create_order($goodsInfo){
		//生成订单
		$data 				= [];
		$data['order_id'] 	= $this->_orderModel->buildOrderNo();
		$data['goods_id'] 	= $goodsInfo['id'];
		$data['addtime'] 	= time();
		$data['uid']		= 1;
		$order_rs 			= $this->_orderModel->create_order($data);
		
		//库存减少
		$gid 	= $goodsInfo['id'];
		$sql	= 'UPDATE goods SET counts = counts - 1 WHERE id = '.$gid;
		$result = $this->_goodsModel->exect($sql);
		return true;
	}




}
