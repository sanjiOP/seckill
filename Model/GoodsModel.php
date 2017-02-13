<?php

	/*
	 * 商品模型
	 *
	 *
	*/

	class GoodsModel extends Model{
		
		
		
		/*
		 * 获取商品信息
		 *
		 *
		*/
		public function getGoods($id){
			$sql = 'select * from goods where id = '.$id;
			$result = $this->query($sql);
			if($result[0]){
				return $result[0];
			}else{
				return false;
			}
		}
		
		
		
		/*
		 * 获取所有商品信息
		 *
		*/
		public function getGoodses(){
			
			$sql = 'select * from goods';
			$result = $this->query($sql);
			return $result;
			
		}



		/*
		 * 更新商品库存
		 *
		*/
		public function setGoodsCount($gid,$count){
			$sql = 'UPDATE goods SET counts = '.$count.' WHERE id = '.$gid;
			$result = $this->exect($sql);
			return $result;
		}
		
		
	}