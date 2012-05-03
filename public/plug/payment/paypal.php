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

	$modules[$i]['plugname'] = 'PayPal支付插件';

	$modules[$i]['code'] = basename(__FILE__, '.php');

	$modules[$i]['desc'] = 'PayPal支付插件';

	$modules[$i]['is_cod'] = '0';

	$modules[$i]['is_online'] = '1';

	$modules[$i]['pay_fee'] = '0';

	$modules[$i]['website'] = 'http://www.paypal.com';

	$modules[$i]['version'] = '1.0.1';
	$modules[$i]['config'] = array(
	    array('name' => 'paypal_account', 'type' => 'text', 'value' => '', 'botname' => '贝宝商户号', 'bakcontent' => ''),
	    array('name' => 'paypal_currency', 'type' => 'select', 'value' => 'USD', 'sevalue' => array(0 => '美金', 1 => '欧元'), 'botname' => '结算货币', 'bakcontent' => '')
	);
	return;
}

class paypal {

	function paypal() {

	}

	function __construct() {
		$this->paypal();
	}






	function get_code($order, $payment, $return_url, $notify_url) {

		$data_order_id = $order['ordersn'];

		$data_amount = $order['orderamount'];

		$data_pay_account = $payment['paypal_account'];

		$currency_code = 'USD';

		$data_return_url = $return_url;

		$data_notify_url = $return_url;

		$cancel_return = $notify_url;

		$def_url  = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">' .

			"<input type='hidden' name='cmd' value='_xclick'>" .

			"<input type='hidden' name='business' value='$data_pay_account'>" .

			"<input type='hidden' name='item_name' value='$order[ordersn]'>" .

			"<input type='hidden' name='amount' value='$data_amount'>" .

			"<input type='hidden' name='currency_code' value='$currency_code'>" .

			"<input type='hidden' name='return' value='$data_return_url'>" .

			"<input type='hidden' name='invoice' value='$data_order_id'>" .

			"<input type='hidden' name='charset' value='utf-8'>" .

			"<input type='hidden' name='no_shipping' value='1'>" .

			"<input type='hidden' name='no_note' value=''>" .
			"<input type='hidden' name='notify_url' value='$data_notify_url'>" .
			"<input type='hidden' name='rm' value='2'>" .
			"<input type='hidden' name='cancel_return' value='$cancel_return'>" .

			"<input type='submit' class='inputsubmit01' value='我要在线支付'>" .
			"</form>";

		return $def_url;
	}

	function respond($payment=null, $orderread=array()) {

		$merchant_id = $payment['paypal_account'];
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

		$fp = @fsockopen('www.paypal.com', 80, $errno, $errstr, 30);
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$payment_status = $_POST['payment_status'];
		$payment_amount = $_POST['mc_gross'];
		$payment_currency = $_POST['mc_currency'];
		$txn_id = $_POST['txn_id'];
		$receiver_email = $_POST['receiver_email'];
		$payer_email = $_POST['payer_email'];
		$order_sn = $_POST['invoice'];
		$memo = !empty($_POST['memo']) ? $_POST['memo'] : '';
		if (!$fp) {
			@fclose($fp);
			return false;
		} else {
			@fputs($fp, $header . $req);
			while (!feof($fp)) {
				$res = @fgets($fp, 1024);
				if (strcmp($res, 'VERIFIED') == 0) {
					if ($payment_status != 'Completed' && $payment_status != 'Pending') {
						fclose($fp);
						return false;
					}
					fclose($fp);
					return $txn_id;
				} elseif (strcmp($res, 'INVALID') == 0) {
					@fclose($fp);
					return false;
				}
			}
		}
	}

}
?>