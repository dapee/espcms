<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */
if (isset($modulesid) && $modulesid == TRUE) {
	$i = isset($modules) ? count($modules) : 0;

	$modules[$i]['plugname'] = '货到付款';

	$modules[$i]['code'] = basename(__FILE__, '.php');

	$modules[$i]['desc'] = '货到付款支付的城市有北京、上海、广州、深圳、武汉、长春、重庆';

	$modules[$i]['is_cod'] = '1';

	$modules[$i]['is_online'] = '0';

	$modules[$i]['pay_fee'] = '0';

	$modules[$i]['website'] = 'http://www.ecisp.cn';

	$modules[$i]['version'] = '1.0.1';
	$modules[$i]['config'] = array();
	return;
}


class downpay {

	function downpay() {

	}

	function __construct() {
		$this->downpay();
	}

	function get_code($order, $payment, $return_url, $notify_url) {
		return '货到付款';
	}

	function respond($payment=null, $orderread=array()) {
		return false;
	}

}
?>