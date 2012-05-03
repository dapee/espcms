<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class mainpage extends connector {

	function mainpage() {
		$this->softbase(false);
		$this->mlink = $this->memberlink(array(), admin_LNG);
	}

	function in_payok() {
		parent::start_pagetemplate();
		parent::member_purview(0, $this->mlink['login']);
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$linkURL = $_SERVER['HTTP_REFERER'];
		$paycode = $this->fun->accept('code', 'G');
		$ordersn = $this->fun->accept('ordersn', 'G');
		$oid = $this->fun->accept('oid', 'G');
		$codesn = $this->fun->accept('codesn', 'G');
		$integral = $this->CON['order_integral'];
		$sncode = $this->fun->eccode($paycode . $ordersn . $oid, 'ENCODE', db_pscode);
		if ($sncode != $codesn) {
			$linkURL = $this->mlink['center'];
			$this->callmessage($this->lng['order_pay_no'], $linkURL, $this->lng['member_center_botton']);
		}
		if (!empty($paycode)) {
			$db_table1 = db_prefix . 'order_pay';
			$db_table2 = db_prefix . 'order';
			$db_table3 = db_prefix . 'order_payreceipt';
			$db_where = "paycode='$paycode'";
			$rsList = $this->db->fetch_first('SELECT * FROM ' . $db_table1 . ' WHERE ' . $db_where);
			if ($rsList) {
				$config_list = unserialize($rsList['pluglist']);
				foreach ($config_list as $config) {
					$paymentvlue[$config['name']] = $config['value'];
				}

				include_once admin_ROOT . 'public/plug/payment/' . $paycode . '.php';

				$payment = new $paycode();

				$paymentType = $payment->respond($paymentvlue, $rsList);
				$db_where = "oid=$oid AND ordertype<>2";
				$rsRead = $this->db->fetch_first('SELECT * FROM ' . $db_table2 . ' WHERE ' . $db_where);
				if ($paymentType && $rsRead) {

					$ipadd = $this->fun->ip($_SERVER['REMOTE_ADDR']);
					$addtime = time();
					if (!empty($integral)) {
						$integral = intval($rsRead['orderamount'] / intval($integral));
					} else {
						$integral = 0;
					}
					$db_set = "ordertype=2,paysn='$paymentType',paytime='$addtime',integral=$integral";
					$this->db->query('UPDATE ' . $db_table2 . ' SET ' . $db_set . ' WHERE ' . $db_where);
					$db_field = 'oid,opid,paysn,ordersn,orderamount,bankaccount,bankname,username,content,userid,isclass,paytime,addtime';
					$db_values = "$oid,$rsRead[opid],'$rsRead[paysn]','$ordersn',$rsRead[orderamount],'$paymentvlue[paypal_account]','$paycode','onlineuser','',$rsRead[userid],1,$addtime,$addtime";
					$this->db->query('INSERT INTO ' . $db_table3 . ' (' . $db_field . ') VALUES (' . $db_values . ')');

					if ($rsRead[userid] > 0) {
						$this->set_member_integral($rsRead['userid'], $integral);
					}

					if ($this->CON['is_email'] == 1) {

						$this->ordermailsend('orderpal', $oid, $rsRead['email']);

						$this->ordermailsend('orderpayadmin', $insert_id, $this->CON['admine_mail']);
					}
					$this->pagetemplate->assign('order', $rsRead);
					$this->pagetemplate->assign('pay', $rsList);
					$this->pagetemplate->assign('paysn', $paymentType);

					$linkURL = $this->mlink['center'];
					$readlink = $this->get_link('orderread', $rsRead, admin_LNG);
					$this->callmessage($this->lng['order_pay_ok'], $linkURL, $this->lng['member_center_botton'], 1, $this->lng['order_read_botton'], 1, $readlink);
				} else {
					$linkURL = $this->mlink['center'];
					$this->callmessage($this->lng['order_pay_no'], $linkURL, $this->lng['member_center_botton']);
				}
			} else {
				$linkURL = $this->mlink['center'];
				$this->callmessage($this->lng['order_pay_no'], $linkURL, $this->lng['member_center_botton']);
			}
		} else {
			$linkURL = $this->mlink['center'];
			$this->callmessage($this->lng['order_pay_no'], $linkURL, $this->lng['member_center_botton']);
		}
	}

}

?>
