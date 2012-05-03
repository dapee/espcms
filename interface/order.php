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

	function in_list() {
		parent::start_pagetemplate();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$cartid = $this->fun->accept('ecisp_order_list', 'C');
		$cartid = stripslashes(htmlspecialchars_decode($cartid));
		$uncartid = !empty($cartid) ? unserialize($cartid) : 0;
		if ($uncartid && is_array($uncartid)) {
			$didarray = $this->fun->key_array_name($uncartid, 'did', 'amount');
			$didlist = $this->fun->format_array_text(array_keys($didarray), ',');
			if (!empty($didlist)) {
				$db_table = db_prefix . 'document';
				$db_where = "isclass=1 AND isorder=1 AND did in($didlist) ORDER BY did DESC";
				$sql = "SELECT did,lng,pid,mid,aid,tid,sid,fgid,linkdid,isclass,islink,ishtml,ismess,isorder,purview,recommend,tsn,title,longtitle,
					color,author,source,pic,link,oprice,bprice,click,addtime,template,filename,filepath FROM $db_table WHERE $db_where";
				$rs = $this->db->query($sql);

				$productmoney = 0;
				while ($rsList = $this->db->fetch_assoc($rs)) {
					$rsList['link'] = $this->get_link('doc', $rsList, admin_LNG);
					$rsList['buylink'] = $this->get_link('buylink', $rsList, admin_LNG);
					$rsList['enqlink'] = $this->get_link('enqlink', $rsList, admin_LNG);

					$rsList['dellink'] = $this->get_link('buydel', $rsList, admin_LNG);
					$rsList['ctitle'] = empty($rsList['color']) ? $rsList['title'] : "<font color='" . $rsList['color'] . "'>" . $rsList['title'] . "</font>";
					$rsList['amount'] = $didarray[$rsList['did']];

					$countprice = sprintf("%01.2f", $didarray[$rsList['did']] * $rsList['bprice']);
					$rsList['countprice'] = $countprice;

					$productmoney = $productmoney + $countprice;
					$array[] = $rsList;
				}

				$this->fun->setcookie('ecisp_order_productmoney', $productmoney, 7200);
			}

			$this->pagetemplate->assign('ordertotal', number_format($productmoney, 2));
			$this->pagetemplate->assign('array', $array);
			$this->pagetemplate->assign('moneytype', $this->CON['order_moneytype']);
		} else {
			$this->pagetemplate->assign('ordervirtue', 'false');
		}
		$this->pagetemplate->assign('mlink', $this->mlink);

		$templatesDIR = $this->get_templatesdir('order');
		$this->pagetemplate->assign('path', 'order');
		$templatefilename = $lng . '/' . $templatesDIR . '/order_buy_center';
		$this->pagetemplate->assign('out', 'buylist');
		unset($array, $this->mlink, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'order_list', false, '', admin_LNG);
	}

	function in_buy() {
		$did = intval($this->fun->accept('did', 'G'));
		if (empty($did)) trigger_error("Parameter error!", E_USER_ERROR);
		$db_table = db_prefix . 'document';
		$db_sql = "SELECT did,tsn,title,oprice,bprice FROM $db_table WHERE isclass=1 AND did=$did AND isorder=1";
		$readdid = $this->db->fetch_first($db_sql);
		if ($readdid) {

			$cartid = $this->fun->accept('ecisp_order_list', 'C');
			$cartid = stripslashes(htmlspecialchars_decode($cartid));

			$arraykeyname = 'k' . $did;

			if (empty($cartid) || strlen($cartid) < 7) {

				$orderlist = array($arraykeyname => array('did' => $did, 'amount' => 1));
				$orderlist = serialize($orderlist);
			} else {
				$orderid = unserialize($cartid);

				if (is_array($orderid) && array_key_exists($arraykeyname, $orderid)) {

					$amount = $orderid[$arraykeyname]['amount'] + 1;

					unset($orderid[$arraykeyname]);
					$nowcart = array($arraykeyname => array('did' => $did, 'amount' => $amount));
					$newcart = array_merge($orderid, $nowcart);
					$orderlist = serialize($newcart);
				} elseif (is_array($orderid)) {

					$nowcart = array($arraykeyname => array('did' => $did, 'amount' => 1));
					$newcart = array_merge_recursive($nowcart, $orderid);
					$orderlist = serialize($newcart);
				} else {
					$nowcart = array($arraykeyname => array('did' => $did, 'amount' => 1));
					$orderlist = serialize($newcart);
				}
			}
			$this->fun->setcookie('ecisp_order_list', $orderlist, 7200);
			$buylink = $this->get_link('order', array(), admin_LNG);
			$linkURL = $_SERVER['HTTP_REFERER'];
			$this->callmessage($this->lng['order_buy_ok'], $linkURL, $this->lng['oder_buy_goback'], 1, $this->lng['order_buy_listbotton'], 1, $buylink);
		} else {
			$linkURL = $_SERVER['HTTP_REFERER'];
			$this->callmessage($this->lng['order_buy_err'], $linkURL, $this->lng['gobackbotton']);
		}
	}

	function in_orderpay() {
		parent::start_pagetemplate();
		parent::member_purview(0, $this->mlink['orderpay']);
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$cartid = $this->fun->accept('ecisp_order_list', 'C');
		$cartid = stripslashes(htmlspecialchars_decode($cartid));
		$uncartid = !empty($cartid) ? unserialize($cartid) : 0;

		if (!empty($this->ec_member_username_id) && !empty($this->ec_member_username)) {

			$rsMember = $this->get_member(null, $this->ec_member_username_id);
		} else {

			$linkURL = $this->get_link('memberlogin');
			$this->callmessage($this->lng['memberloginerr'], $linkURL, $this->lng['memberlogin'], 1, $this->lng['member_regbotton'], 1, $this->mlink['reg']);
		}

		if ($uncartid && is_array($uncartid)) {
			$didarray = $this->fun->key_array_name($uncartid, 'did', 'amount');
			$didlist = $this->fun->format_array_text(array_keys($didarray), ',');
			if (!empty($didlist)) {
				$db_table = db_prefix . 'document';
				$db_where = "isclass=1 AND isorder=1 AND did in($didlist) ORDER BY did DESC";
				$sql = "SELECT * FROM $db_table WHERE $db_where";
				$rs = $this->db->query($sql);

				$productmoney = 0;
				while ($rsList = $this->db->fetch_assoc($rs)) {
					$rsList['link'] = $this->get_link('doc', $rsList, admin_LNG);
					$rsList['buylink'] = $this->get_link('buylink', $rsList, admin_LNG);
					$rsList['enqlink'] = $this->get_link('enqlink', $rsList, admin_LNG);

					$rsList['dellink'] = $this->get_link('buydel', $rsList, admin_LNG);
					$rsList['ctitle'] = empty($rsList['color']) ? $rsList['title'] : "<font color='" . $rsList['color'] . "'>" . $rsList['title'] . "</font>";
					$rsList['amount'] = $didarray[$rsList['did']];

					$countprice = sprintf("%01.2f", $didarray[$rsList['did']] * $rsList['bprice']);
					$rsList['countprice'] = $countprice;

					$productmoney = $productmoney + $countprice;
					$array[] = $rsList;
				}

				$this->fun->setcookie('ecisp_order_productmoney', $productmoney, 7200);
			}

			$this->pagetemplate->assign('moneytype', $this->CON['order_moneytype']);

			$order_discount = $this->CON['order_discount'];
			$discountmoney = 0;
			if ($order_discount > 0) {

				$discountmoney = $productmoney > 0 ? $productmoney - ($order_discount / 100) * $productmoney : 0;
			}

			$discount_productmoney = $productmoney - $discountmoney;
			$payplug = $this->get_payplug_array();
			$shipplug = $this->get_shipplug_array();

			$cookiceprice = md5("$productmoney|$discount_productmoney");
			$this->fun->setcookie('ecisp_order_sncode', $this->fun->eccode($cookiceprice, 'ENCODE', db_pscode));

			$this->pagetemplate->assign('discount', $order_discount);

			$this->pagetemplate->assign('productmoney', $productmoney);

			$this->pagetemplate->assign('discount_productmoney', $discount_productmoney);

			$this->pagetemplate->assign('discountmoney', $discountmoney);
			$this->pagetemplate->assign('discount_productmoney_f', number_format($discount_productmoney, 2, '.', ','));
			$this->pagetemplate->assign('productmoney_f', number_format($productmoney, 2, '.', ','));
			$this->pagetemplate->assign('discountmoney_f', number_format($discountmoney, 2, '.', ','));
			$this->pagetemplate->assign('payplug', $payplug['list']);
			$this->pagetemplate->assign('shipplug', $shipplug['list']);
			$this->pagetemplate->assign('array', $array);
		} else {
			$buylink = $this->get_link('order', array(), admin_LNG);
			$this->callmessage($this->lng['order_nolist'], $buylink, $this->lng['oder_buy_goback']);
		}
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('member', $rsMember);
		$this->pagetemplate->assign('path', 'order');
		$this->pagetemplate->assign('mem_isaddress', $this->CON['mem_isaddress']);

		$templatesDIR = $this->get_templatesdir('order');

		$templatesDIR = $this->get_templatesdir('order');
		$templatefilename = $lng . '/' . $templatesDIR . '/order_buy_center';
		$this->pagetemplate->assign('out', 'buyedit');
		unset($array, $this->mlink, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'order_list', false, '', admin_LNG);
	}

	function in_ordersave() {
		parent::start_pagetemplate();
		parent::member_purview(0, $this->mlink['orderpay']);
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$cartid = $this->fun->accept('ecisp_order_list', 'C');
		$cartid = stripslashes(htmlspecialchars_decode($cartid));
		$uncartid = !empty($cartid) ? unserialize($cartid) : 0;

		$ordersncode = $this->fun->accept('ecisp_order_sncode', 'C');

		$userid = intval($this->fun->accept('userid', 'P'));
		$consignee = trim($this->fun->accept('alias', 'P', true, true));
		$email = $this->fun->accept('email', 'P');
		$country = intval($this->fun->accept('cityone', 'P'));
		$country = empty($country) ? 0 : $country;
		$province = intval($this->fun->accept('citytwo', 'P'));
		$province = empty($province) ? 0 : $province;
		$city = intval($this->fun->accept('citythree', 'P'));
		$city = empty($city) ? 0 : $city;
		$district = intval($this->fun->accept('district', 'P'));
		$district = empty($district) ? 0 : $district;

		$address = trim($this->fun->accept('address', 'P', true, true));
		$zipcode = trim($this->fun->accept('zipcode', 'P', true, true));
		$tel = trim($this->fun->accept('tel', 'P', true, true));
		$mobile = trim($this->fun->accept('mobile', 'P', true, true));
		$sendtime = $this->fun->accept('sendtime', 'P');
		$content = trim($this->fun->accept('content', 'P', true, true));
		$invpayee = trim($this->fun->accept('invpayee', 'P', true, true));
		$invcontent = trim($this->fun->accept('invcontent', 'P', true, true));

		$opid = intval($this->fun->accept('opid', 'P'));
		$opid = empty($opid) ? 0 : $opid;

		$osid = intval($this->fun->accept('osid', 'P'));
		$osid = empty($osid) ? 0 : $osid;

		$productmoney = $this->fun->accept('productmoney', 'P');

		$discount_productmoney = $this->fun->accept('discount_productmoney', 'P');
		$discountmoney = $this->fun->accept('discountmoney', 'P');
		$cookiceprice = $this->fun->eccode(md5("$productmoney|$discount_productmoney"), 'ENCODE', db_pscode);
		if ($uncartid && is_array($uncartid) && !empty($ordersncode) && $cookiceprice == $ordersncode) {
			$ptitle = $this->fun->accept('ptitle', 'P');
			$tsn = $this->fun->accept('tsn', 'P');
			$bprice = $this->fun->accept('bprice', 'P');
			$oprice = $this->fun->accept('oprice', 'P');
			$did = $this->fun->accept('did', 'P');
			$amount = $this->fun->accept('amount', 'P');
			$countprice = $this->fun->accept('countprice', 'P');
			if (empty($did) || empty($bprice) || empty($amount) || empty($countprice) || empty($opid) || empty($osid)) {
				$buylink = $this->get_link('order', array(), admin_LNG);
				$this->callmessage($this->lng['order_input_err'], $buylink, $this->lng['oder_buy_goback']);
			}
			if (!preg_match("/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i", $email)) {
				$this->callmessage($this->lng['email_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackbotton']);
			}

			$payprice = 0;
			$shipprice = 0;

			$payread = !empty($opid) ? $this->get_payplug_view($opid) : 0;

			$shipprice = !empty($osid) ? $this->get_shipplug_view($osid, 'price') : 0;
			if ($payread['payis'] > 0) {

				$payprice = ($payread['payis'] / 100) * $discount_productmoney;
			}

			$orderamount = $discount_productmoney + $payprice + $shipprice;

			$order_snfont = $this->CON['order_snfont'];
			$ordersn = $order_snfont . date('YmdHis') . rand(100, 9999);

			$db_table = db_prefix . 'order';
			$db_table2 = db_prefix . 'order_info';
			$addtime = time();
			$db_field = 'ordersn,userid,ordertype,osid,opid,shippingsn,paysn,consignee,country,province,city,district,address,
				zipcode,tel,mobile,email,sendtime,invpayee,invcontent,content,treatnote,paytime,shippingtime,productmoney,shippingmoney,
				paymoney,orderamount,discount,integral,addtime';
			$db_values = "'$ordersn',$userid,1,$osid,$opid,'','','$consignee',$country,$province,$city,$district,'$address',
				'$zipcode','$tel','$mobile','$email','$sendtime','$invpayee','$invcontent','$content','',0,0,$productmoney,$shipprice,
				$payprice,$orderamount,$discountmoney,0,$addtime";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$insert_id = $this->db->insert_id();

			$db_values = '';
			$arraycount = count($did) - 1;
			foreach ($did as $key => $value) {
				if ($key == $arraycount) {
					$db_values.= "($insert_id,$value,'$tsn[$key]','$ptitle[$key]',$oprice[$key],$bprice[$key],$countprice[$key],$amount[$key],1)";
				} else {
					$db_values.= "($insert_id,$value,'$tsn[$key]','$ptitle[$key]',$oprice[$key],$bprice[$key],$countprice[$key],$amount[$key],1),";
				}
			}
			$db_field = 'oid,did,tsn,title,oprice,bprice,countprice,amount,inventory';
			$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field . ') VALUES ' . $db_values);

			if ($this->CON['is_email'] == 1) {

				$this->ordermailsend('orderen', $insert_id, $email);

				$this->ordermailsend('orderwarn', $insert_id, $this->CON['admine_mail']);
			}
			if (!empty($opid)) {

				$rsOrder = array('ordersn' => $ordersn, 'orderamount' => $orderamount, 'oid' => $insert_id);

				$paylist = $this->fun->formatarray($payread['pluglist']);
				$plugcode = $payread['paycode'];

				if (!empty($plugcode)) {

					include_once admin_ROOT . 'public/plug/payment/' . $plugcode . '.php';

					$payobj = new $plugcode();
					$codesn = $this->fun->eccode($plugcode . $ordersn . $insert_id, 'ENCODE', db_pscode);
					$respondArray = array('code' => $plugcode, 'ordersn' => $ordersn, 'oid' => $insert_id, 'codesn' => $codesn);

					$return_url = $this->get_link('paybackurl', $respondArray, admin_LNG);

					$orderonline = $payobj->get_code($rsOrder, $paylist, $return_url, $return_url);
				}
			}
			$this->pagetemplate->assign('mlink', $this->mlink);
			$this->pagetemplate->assign('orderonline', $orderonline);

			$this->pagetemplate->assign('ordersn', $ordersn);

			$this->pagetemplate->assign('orderamount', number_format($orderamount, 2));

			$this->pagetemplate->assign('payprice', number_format($payprice, 2));

			$this->pagetemplate->assign('shipprice', number_format($shipprice, 2));

			$this->pagetemplate->assign('discount', number_format($discount_productmoney, 2));

			$this->pagetemplate->assign('productmoney', number_format($productmoney, 2));

			$this->pagetemplate->assign('discountmoney', number_format($discountmoney, 2));

			$this->pagetemplate->assign('moneytype', $this->CON['order_moneytype']);

			$this->fun->setcookie('ecisp_order_list', null);
			$this->fun->setcookie('ecisp_order_productmoney', null);

			$templatesDIR = $this->get_templatesdir('order');
			$templatefilename = $lng . '/' . $templatesDIR . '/order_buy_center';
			$this->pagetemplate->assign('out', 'buyok');
			$this->pagetemplate->assign('path', 'order');
			unset($this->mlink, $LANPACK, $this->lng);
			$this->pagetemplate->display($templatefilename, 'order_ok', false, '', admin_LNG);
		} else {
			$buylink = $this->get_link('order', array(), admin_LNG);
			$this->callmessage($this->lng['order_nolist'], $buylink, $this->lng['oder_buy_goback']);
		}
	}

	function in_orderupdae() {
		$bprice = $this->fun->accept('bprice', 'P');
		$didlist = $this->fun->accept('did', 'P');
		$amountlist = $this->fun->accept('amount', 'P');
		foreach ($didlist as $key => $value) {
			$arraykeyname = 'k' . $value;
			$amount = intval($amountlist[$key]);
			$orderlist[$arraykeyname] = array('did' => $value, 'amount' => $amount);
		}
		$orderlist_ser = serialize($orderlist);

		$this->fun->setcookie('ecisp_order_list', $orderlist_ser, 7200);
		$buylink = $this->get_link('order', array(), admin_LNG);
		$this->callmessage($this->lng['order_amout_updateok'], $buylink, $this->lng['oder_buy_goback']);
	}

	function in_delcart() {
		$did = intval($this->fun->accept('did', 'R'));
		if (empty($did)) trigger_error("Product parameter error!", E_USER_ERROR);
		$cartid = $this->fun->accept('ecisp_order_list', 'C');
		$cartid = stripslashes(htmlspecialchars_decode($cartid));
		$uncartid = !empty($cartid) ? unserialize($cartid) : 0;
		$arraykeyname = 'k' . $did;
		unset($uncartid[$arraykeyname]);
		$orderlist = serialize($uncartid);

		$this->fun->setcookie('ecisp_order_list', $orderlist, 7200);
		$buylink = $this->get_link('order', array(), admin_LNG);
		$this->callmessage($this->lng['order_delcartok'], $buylink, $this->lng['oder_buy_goback']);
	}

	function in_clearcart() {
		$this->fun->setcookie('ecisp_order_list', null);
		$this->fun->setcookie('ecisp_order_productmoney', null);
		$buylink = $this->get_link('order', array(), admin_LNG);
		$this->callmessage($this->lng['order_clearcart'], $buylink, $this->lng['oder_buy_goback']);
	}

}

?>
