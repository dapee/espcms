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

	$modules[$i]['plugname'] = '财付通即时到帐插件';

	$modules[$i]['code'] = basename(__FILE__, '.php');

	$modules[$i]['desc'] = '财付通是腾讯公司创办的中国领先的在线支付平台，致力于为互联网用户和企业提供安全、便捷、专业的在线支付服务';

	$modules[$i]['is_cod'] = '0';

	$modules[$i]['is_online'] = '1';

	$modules[$i]['pay_fee'] = '0';

	$modules[$i]['website'] = 'http://www.tenpay.com';

	$modules[$i]['version'] = '1.0.1';

	$modules[$i]['config'] = array(
	    array('name' => 'tenpay_account', 'type' => 'text', 'value' => '', 'botname' => '财付通商户号', 'bakcontent' => ''),
	    array('name' => 'tenpay_key', 'type' => 'text', 'value' => '', 'botname' => '财付通密钥', 'bakcontent' => ''),
	    array('name' => 'magic_string', 'type' => 'text', 'value' => '', 'botname' => '自定义签名', 'bakcontent' => '')
	);
	return;
}

class tenpay {








	function tenpay() {

	}

	function __construct() {
		$this->tenpay();
	}







	function get_code($order, $payment, $return_url, $notify_url) {
		$cmd_no = '1';

		$sp_billno = $order['ordersn'];

		$today = date('Ymd');

		$bill_no = str_pad($order['id'], 10, 0, STR_PAD_LEFT);
		$transaction_id = $payment['tenpay_account'] . $today . $bill_no;

		$bank_type = '0';

		if (!empty($order['ordersn'])) {
			$desc = $order['ordersn'];
			$attach = '';
		} else {
			return false;
		}

		$total_fee = floatval($order['orderamount']) * 100;

		$fee_type = '1';



		$sign_text = "cmdno=" . $cmd_no . "&date=" . $today . "&bargainor_id=" . $payment['tenpay_account'] .
			"&transaction_id=" . $transaction_id . "&sp_billno=" . $sp_billno .
			"&total_fee=" . $total_fee . "&fee_type=" . $fee_type . "&return_url=" . $return_url .
			"&attach=" . $attach . "&key=" . $payment['tenpay_key'];
		$sign = strtoupper(md5($sign_text));

		$parameter = array(

		    'cmdno' => $cmd_no,

		    'date' => $today,

		    'bank_type' => $bank_type,

		    'desc' => $desc,

		    'purchaser_id' => '',

		    'bargainor_id' => $payment['tenpay_account'],

		    'transaction_id' => $transaction_id,

		    'sp_billno' => $sp_billno,

		    'total_fee' => $total_fee,

		    'fee_type' => $fee_type,

		    'return_url' => $return_url,

		    'attach' => $attach,

		    'sign' => $sign,

		    'sys_id' => '0'
		);
		$button = '<form action="https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi" target="_blank">';
		foreach ($parameter AS $key => $val) {
			$button .= "<input type='hidden' name='$key' value='$val' />";
		}
		$button .= '<input type="submit" class="inputsubmit01" value="我要支付" /></form>';
		return $button;
	}

	function respond($payment=null, $orderread=array()) {

		$cmd_no = $_GET['cmdno'];
		$pay_result = $_GET['pay_result'];
		$pay_info = $_GET['pay_info'];
		$bill_date = $_GET['date'];
		$bargainor_id = $_GET['bargainor_id'];
		$transaction_id = $_GET['transaction_id'];
		$sp_billno = $_GET['sp_billno'];
		$total_fee = $_GET['total_fee'];
		$fee_type = $_GET['fee_type'];
		$attach = $_GET['attach'];
		$sign = $_GET['sign'];

		if ($pay_result > 0) {
			return false;
		}

		$sign_text = "cmdno=" . $cmd_no . "&pay_result=" . $pay_result .
			"&date=" . $bill_date . "&transaction_id=" . $transaction_id .
			"&sp_billno=" . $sp_billno . "&total_fee=" . $total_fee .
			"&fee_type=" . $fee_type . "&attach=" . $attach .
			"&key=" . $payment['tenpay_key'];
		$sign_md5 = strtoupper(md5($sign_text));
		if ($sign_md5 != $sign) {
			return false;
		} else {
			return $transaction_id;
		}
	}

}
?>