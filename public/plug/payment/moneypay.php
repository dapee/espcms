<?php

/*
  PHP version 5
  Copyright (c) 2002-2008 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn
  moneypay.php 2008-11-3 $
 */
if (isset($modulesid) && $modulesid == TRUE) {
	$i = isset($modules) ? count($modules) : 0;
	$modules[$i]['plugname'] = 'Moneybookers'; //插件名称
	$modules[$i]['code'] = basename(__FILE__, '.php'); //返回文件名部分,basename — 返回路径中的文件名部分
	$modules[$i]['desc'] = '请填写Moneybookers的帐户信息'; //描述对应的语言项
	$modules[$i]['is_cod'] = '1';  //是否支持货到付款
	$modules[$i]['is_online'] = '0'; //是否支持在线支付
	$modules[$i]['pay_fee'] = '0'; //是否有手续费
	$modules[$i]['website'] = 'http://www.ecisp.cn'; //插件网址
	$modules[$i]['version'] = '1.0.1'; // 版本号
	$modules[$i]['config'] = array();
	return;
}

/**
 * 类
 */
class moneypay {

	function moneypay() {

	}

	function __construct() {
		$this->moneypay();
	}

	function get_code($order, $payment, $return_url, $notify_url) {
		$def_url = '<br /><form style="text-align:center;" action="?order-memberorder-list.html" method="post">' . // 不能省略
			"<input type='submit' value='Finished'>" . // 按钮
			"</form><br />";

		return $def_url;
	}

	function respond($payment=null, $orderread=array()) {
		return false;
	}

}
?>