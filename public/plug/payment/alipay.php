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

	$modules[$i]['plugname'] = '支付宝插件';

	$modules[$i]['code'] = basename(__FILE__, '.php');

	$modules[$i]['desc'] = '支付宝（中国）网络技术有限公司是国内领先的独立第三方支付平台，由阿里巴巴集团创办。支付宝致力于为中国电子商务提供“简单、安全、快速”的在线支付解决方案。';

	$modules[$i]['is_cod'] = '0';

	$modules[$i]['is_online'] = '1';

	$modules[$i]['pay_fee'] = '0';

	$modules[$i]['website'] = 'http://www.alipay.com';

	$modules[$i]['version'] = '1.0.2';
	$modules[$i]['config'] = array(
	    array('name' => 'alipay_account', 'type' => 'text', 'value' => '', 'botname' => '支付宝帐户', 'bakcontent' => ''),
	    array('name' => 'alipay_key', 'type' => 'text', 'value' => '', 'botname' => '交易安全校验码', 'bakcontent' => ''),
	    array('name' => 'alipay_partner', 'type' => 'text', 'value' => '', 'botname' => '合作者身份ID', 'bakcontent' => ''),
	    array('name' => 'alipay_pay_method', 'type' => 'select', 'value' => '0', 'sevalue' => array(0 => '使用标准双接口', 1 => '使用担保交易接口', 2 => '使用即时到帐交易接口'), 'botname' => '选择接口类型', 'bakcontent' => '您可以选择支付时采用的接口类型，不过这和支付宝的帐号类型有关，具体情况请咨询支付宝'),
	);
	return;
}

class alipay {

	function alipay() {
		
	}

	function __construct() {
		$this->alipay();
	}







	function get_code($order, $payment, $return_url, $notify_url) {

		$charset = 'utf-8';




		$service_method = $payment['alipay_pay_method'];
		switch ($service_method) {
			case '0':
				$service = 'trade_create_by_buyer';
				break;
			case '1':
				$service = 'create_partner_trade_by_buyer';
				break;
			case '2':
				$service = 'create_direct_pay_by_user';
				break;
		}
		$parameter = array(

		    'service' => $service,

		    'partner' => $payment['alipay_partner'],

		    'return_url' => $return_url,

		    'notify_url' => $notify_url,

		    '_input_charset' => $charset,

		    'subject' => $order['ordersn'],



		    'out_trade_no' => $order['ordersn'] . $order['id'],

		    'price' => $order['orderamount'],

		    'quantity' => 1,

		    'payment_type' => 1,


		    'logistics_type' => 'EXPRESS',

		    'logistics_fee' => 0,

		    'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE',


		    'seller_email' => $payment['alipay_account'],
		);

		ksort($parameter);

		reset($parameter);
		$param = '';
		$sign = '';
		foreach ($parameter AS $key => $val) {
			$param .= "$key=" . urlencode($val) . "&";
			$sign .= "$key=$val&";
		}

		$param = substr($param, 0, -1);
		$sign = substr($sign, 0, -1) . $payment['alipay_key'];
		$link = '<input type="button" class="inputsubmit01" onclick="window.open(\'https://www.alipay.com/cooperate/gateway.do?' . $param . '&sign=' . md5($sign) . '&sign_type=MD5\')" value="我要在线支付"/>';
		return $link;
	}



	function respond($payment=null, $orderread=array()) {
		if (!empty($_POST)) {
			foreach ($_POST as $key => $data) {
				$_GET[$key] = $data;
			}
		}
		$seller_email = rawurldecode($_GET['seller_email']);
		$order_sn = str_replace($_GET['subject'], '', $_GET['out_trade_no']);
		$order_sn = trim($order_sn);
		$trade_no = $_GET['trade_no'];

		if (!check_money($order_sn, $_GET['total_fee'])) {
			return false;
		}

		ksort($_GET);
		reset($_GET);
		$sign = '';
		foreach ($_GET AS $key => $val) {
			if ($key != 'sign' && $key != 'sign_type' && $key != 'code') {
				$sign .= "$key=$val&";
			}
		}
		$sign = substr($sign, 0, -1) . $payment['alipay_key'];





		if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {

			return $trade_no;
		} elseif ($_GET['trade_status'] == 'TRADE_FINISHED') {


			return $trade_no;
		} else {
			return false;
		}
	}

}

?>