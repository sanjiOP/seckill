<?php


	defined('SEC_ROOT_PATH') or define('SEC_ROOT_PATH',dirname(dirname(__FILE__)));

	include 'function.php';
	include 'app/common.php';
	include 'Model/Model.php';
	include 'Model/OrderModel.php';
	include 'Model/GoodsModel.php';
	include 'Redis/QRedis.php';
