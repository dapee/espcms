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
	$modules[$i]['plugname'] = '财付通担保支付插件';

	$modules[$i]['code'] = basename(__FILE__, '.php');

	$modules[$i]['desc'] = '财付通是腾讯公司创办的中国领先的在线支付平台，致力于为互联网用户和企业提供安全、便捷、专业的在线支付服务';

	$modules[$i]['is_cod'] = '0';

	$modules[$i]['is_online'] = '1';

	$modules[$i]['pay_fee'] = '0';

	$modules[$i]['website'] = 'http://www.tenpay.com';

	$modules[$i]['version'] = '1.0.0';

	$modules[$i]['config'] = array(
	    array('name' => 'tenpay_account', 'type' => 'text', 'value' => '', 'botname' => '财付通商户号', 'bakcontent' => ''),
	    array('name' => 'tenpay_key', 'type' => 'text', 'value' => '', 'botname' => '财付通密钥', 'bakcontent' => ''),
	    array('name' => 'tenpay_type', 'type' => 'select', 'value' => '1', 'sevalue' => array(1 => '实物商品交易', 2 => '虚拟物品交易'), 'botname' => '交易类型', 'bakcontent' => ''),
	);
	return;
}

class tenpayc2c {

	function tenpayc2c() {

	}

	function __construct() {
		$this->tenpayc2c();
	}







	function get_code($order, $payment, $return_url, $notify_url) {

		$version = '2';

		$cmdno = '12';

		$encode_type = 2;

		$chnid = $payment['tenpay_account'];

		$seller = $payment['tenpay_account'];

		if (!empty($order['ordersn'])) {
			$mch_name = $order['ordersn'];
		} else {
			return false;
		}

		$mch_price = floatval($order['orderamount']) * 100;

		$transport_desc = '';
		$transport_fee = '';

		$mch_desc = $order['ordersn'];
		$need_buyerinfo = '2';

		$mch_type = $payment['tenpay_type'];

		$mch_vno = $order['ordersn'];

		$mch_returl = $return_url;
		$show_url = $notify_url;
		$attach = '';

		$sign_text = "chnid=" . $chnid . "&cmdno=" . $cmdno . "&encode_type=" . $encode_type . "&mch_desc=" . $mch_desc . "&mch_name=" . $mch_name . "&mch_price=" . $mch_price . "&mch_returl=" . $mch_returl . "&mch_type=" . $mch_type . "&mch_vno=" . $mch_vno . "&need_buyerinfo=" . $need_buyerinfo . "&seller=" . $seller . "&show_url=" . $show_url . "&version=" . $version . "&key=" . $payment['tenpay_key'];
		$sign = md5($sign_text);

		$parameter = array(
		    'attach' => $attach,
		    'chnid' => $chnid,

		    'cmdno' => $cmdno,

		    'encode_type' => $encode_type,
		    'mch_desc' => $mch_desc,
		    'mch_name' => $mch_name,

		    'mch_price' => $mch_price,

		    'mch_returl' => $mch_returl,

		    'mch_type' => $mch_type,

		    'mch_vno' => $mch_vno,

		    'need_buyerinfo' => $need_buyerinfo,

		    'seller' => $seller,
		    'show_url' => $show_url,
		    'transport_desc' => $transport_desc,
		    'transport_fee' => $transport_fee,

		    'version' => $version,

		    'sign' => $sign,
		);
		$button = '<form style="text-align:center;" action="https://www.tenpay.com/cgi-bin/med/show_opentrans.cgi " target="_blank" style="margin:0px;padding:0px" >';
		foreach ($parameter AS $key => $val) {
			$button .= "<input type='hidden' name='$key' value='$val' />";
		}
		$button .= '<input type="submit" class="inputsubmit01" value="我要支付" /></form>';
		return $button;
	}



	function respond($payment=null, $orderread=array()) {

		$cmd_no = $_GET['cmdno'];
		$retcode = $_GET['retcode'];
		$status = $_GET['status'];
		$seller = $_GET['seller'];
		$total_fee = $_GET['total_fee'];
		$trade_price = $_GET['trade_price'];
		$transport_fee = $_GET['transport_fee'];
		$buyer_id = $_GET['buyer_id'];
		$chnid = $_GET['chnid'];
		$cft_tid = $_GET['cft_tid'];
		$mch_vno = $_GET['mch_vno'];
		$attach = !empty($_GET['attach']) ? $_GET['attach'] : '';
		$version = $_GET['version'];
		$sign = $_GET['sign'];


		if ($retcode > 0) {

			return false;
		}

		if ($orderread['orderamount'] == ($total_fee / 100)) {
			return false;
		}

		$sign_text = "buyer_id=" . $buyer_id . "&cft_tid=" . $cft_tid . "&chnid=" . $chnid . "&cmdno=" . $cmd_no . "&mch_vno=" . $mch_vno . "&retcode=" . $retcode . "&seller=" . $seller . "&status=" . $status . "&total_fee=" . $total_fee . "&trade_price=" . $trade_price . "&transport_fee=" . $transport_fee . "&version=" . $version . "&key=" . $payment['tenpay_key'];
		$sign_md5 = strtoupper(md5($sign_text));
		if ($sign_md5 != $sign) {

			return false;
		} elseif ($status = 3) {

			return $cft_tid;
		} else {

			return false;
		}
	}

}
?>