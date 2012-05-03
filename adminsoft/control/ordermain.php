<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class important extends connector {

	function important() {
		$this->softbase(true);
	}

	function onorderlist() {
		$this->powercheck(135, 136);
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_where = " WHERE oid>0";
		$ordertype = $this->fun->accept('ordertype', 'R');
		if (!empty($ordertype)) {
			$db_where.=' AND ordertype=' . $ordertype;
		}
		$ispaysn = $this->fun->accept('ispaysn', 'R');
		if (!empty($ispaysn)) {
			$db_where.= ( $ispaysn == 1) ? ' AND paytime=0' : ' AND paytime>0';
		}
		$isshippingsn = $this->fun->accept('isshippingsn', 'R');
		if (!empty($isshippingsn)) {
			$db_where.= ( $isshippingsn == 1) ? ' AND shippingtime=0' : ' AND shippingtime>0';
		}
		$country = $this->fun->accept('country', 'R');
		if (!empty($country)) {
			$db_where.=' AND country=' . $country;
		}
		$province = $this->fun->accept('province', 'R');
		if (!empty($province)) {
			$db_where.=' AND province=' . $province;
		}
		$city = $this->fun->accept('city', 'R');
		if (!empty($city)) {
			$db_where.=' AND city=' . $city;
		}
		$district = $this->fun->accept('district', 'R');
		if (!empty($district)) {
			$db_where.=' AND district=' . $district;
		}
		$osid = $this->fun->accept('osid', 'R');
		if (!empty($osid)) {
			$db_where.=' AND osid=' . $osid;
		}
		$opid = $this->fun->accept('opid', 'R');
		if (!empty($opid)) {
			$db_where.=' AND opid=' . $opid;
		}
		$serchekey = $this->fun->accept('serchekey', 'R');
		$keyname = $this->fun->accept('keyname', 'R');
		$keyname = empty($keyname) ? 'username' : $keyname;
		if (!empty($serchekey)) {
			$db_where.=" AND $keyname like '%$serchekey%'";
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'oid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'order';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rsList['ordertypename'] = $this->get_ordertype($rsList['ordertype']);
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('order/order_list');
	}

	function onsearch() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;
		$payplug = $this->get_payplug_array($this->CON['order_pay']);
		$shipplug = $this->get_shipplug_array($this->CON['order_shipping']);
		$this->ectemplates->assign('payplug', $payplug['list']);
		$this->ectemplates->assign('shipplug', $shipplug['list']);
		$this->ectemplates->display("order/order_search");
	}

	function onorderadd() {
		parent::start_template();
		$payplug = $this->get_payplug_array($this->CON['order_pay']);
		$shipplug = $this->get_shipplug_array($this->CON['order_shipping']);
		$this->ectemplates->assign('payplug', $payplug['list']);
		$this->ectemplates->assign('shipplug', $shipplug['list']);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->display('order/order_add');
	}

	function onorderedit() {
		parent::start_template();

		$type = $this->fun->accept('type', 'G');
		$oid = $this->fun->accept('oid', 'G');
		$db_table = db_prefix . 'order';
		$db_where = 'oid=' . $oid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		if (!empty($read['userid'])) {
			$rsMember = $this->get_member(null, $read['userid']);
		}

		$db_table = db_prefix . 'order_info';
		$db_where = " WHERE oid=$oid";
		$sql = 'SELECT oiid,oid,did,tsn,title,oprice,bprice,countprice,amount,inventory FROM ' . $db_table . $db_where . ' ORDER BY oiid DESC';
		$rs = $this->db->query($sql);
		$arrayList = array();
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$didlist.=$rsList['did'] . ',';

			$endid = $rsList['did'];
			$array[] = $rsList;
		}
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('didlist', $didlist);
		$this->ectemplates->assign('endid', $endid);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('member', $rsMember);
		if ($type == 'edit') {
			$payplug = $this->get_payplug_array($read['opid']);
			$shipplug = $this->get_shipplug_array($read['osid']);
			$productmoney = $read['productmoney'];

			$dis = 100 - ($read['discount'] / $productmoney) * 100;

			$this->ectemplates->assign('productmoney', $productmoney);
			$this->ectemplates->assign('dis', $dis);
			$this->ectemplates->assign('payplug', $payplug['list']);
			$this->ectemplates->assign('shipplug', $shipplug['list']);
			$this->ectemplates->display('order/order_edit');
		} else if ($type == 'read') {
			$payList = $this->get_payplug_view($read['opid']);
			$shipList = $this->get_shipplug_view($read['osid']);

			$paylist = $this->fun->formatarray($payList['pluglist']);

			$plugcode = $payList['paycode'];
			if (!empty($plugcode)) {

				include_once admin_ROOT . 'public/plug/payment/' . $plugcode . '.php';

				$payobj = new $plugcode();

				$codesn = $this->fun->eccode($plugcode . $read['ordersn'] . $oid, 'ENCODE', db_pscode);
				$respondArray = array('code' => $plugcode, 'ordersn' => $read['ordersn'], 'oid' => $oid, 'codesn' => $codesn);

				$return_url = $this->get_link('paybackurl', $respondArray, admin_LNG);

				$orderonline = $payobj->get_code($rsOrder, $paylist, $return_url, $return_url);
			}
			$productmoney = $read['productmoney'];

			$dis = 100 - ($read['discount'] / $productmoney) * 100;

			$this->ectemplates->assign('payList', $payList);
			$this->ectemplates->assign('shipList', $shipList);
			$this->ectemplates->assign('productmoney', $productmoney);
			$this->ectemplates->assign('dis', $dis);
			$this->ectemplates->assign('orderonline', $orderonline);
			$this->ectemplates->display('order/order_read');
		}
	}

	function onsave() {
		$inputclass = $this->fun->accept('inputclass', 'P');
		$userid = $this->fun->accept('userid', 'R');
		$osid = $this->fun->accept('osid', 'R');
		$osid = empty($osid) ? 0 : $osid;
		$opid = $this->fun->accept('opid', 'R');
		$opid = empty($opid) ? 0 : $opid;

		$alias = $this->fun->accept('alias', 'R');
		$sex = $this->fun->accept('sex', 'R');
		$tel = $this->fun->accept('tel', 'R');
		$mobile = $this->fun->accept('mobile', 'R');
		$email = $this->fun->accept('email', 'R');
		$country = $this->fun->accept('cityone', 'R');
		$province = $this->fun->accept('citytwo', 'R');
		$city = $this->fun->accept('citythree', 'R');
		$district = $this->fun->accept('district', 'R');
		$address = $this->fun->accept('address', 'R');
		$zipcode = $this->fun->accept('zipcode', 'R');
		$sendtime = $this->fun->accept('sendtime', 'R');
		$content = $this->fun->accept('content', 'R');
		$invpayee = $this->fun->accept('invpayee', 'R');
		$invcontent = $this->fun->accept('invcontent', 'R');
		$orderdid = $this->fun->accept('orderdid', 'R');
		$didlist = $this->fun->accept('didlist', 'R');

		$db_table = db_prefix . 'order';
		$db_table2 = db_prefix . 'order_info';
		$db_table3 = db_prefix . 'document';
		if ($inputclass == 'add') {

			$install_values = '';
			$arraycount = count($orderdid);
			$did = substr($didlist, 0, strlen($didlist) - 1);
			$db_where = " WHERE did IN ($did)";
			$sql = 'SELECT did,tsn,title,oprice,bprice FROM ' . $db_table3 . $db_where . ' ORDER BY did DESC';
			$rs = $this->db->query($sql);
			$key = 1;

			$productmoney = 0;
			while ($rsList = $this->db->fetch_assoc($rs)) {

				$amount = $this->fun->accept('orderhow' . $rsList[did], 'R');

				$countprice = $amount * $rsList['bprice'];
				if ($key == $arraycount) {
					$install_values.= "('insert_id',$rsList[did],'$rsList[tsn]','$rsList[title]',$rsList[oprice],$rsList[bprice],$countprice,$amount,1)";
				} else {
					$install_values.= "('insert_id',$rsList[did],'$rsList[tsn]','$rsList[title]',$rsList[oprice],$rsList[bprice],$countprice,$amount,1),";
				}

				$productmoney = $productmoney + $countprice;
				$key++;
			}

			$order_discount = $this->CON['order_discount'];
			if ($order_discount > 0) {

				$discountmoney = $productmoney > 0 ? $productmoney - ($order_discount / 100) * $productmoney : 0;
			}

			$discount_productmoney = $productmoney - $discountmoney;

			$productmoney_dis = $discountmoney > 0 ? $productmoney - $discountmoney : $productmoney;
			$payprice = 0;
			$shipprice = 0;

			$payis_temp = $opid ? $this->get_payplug_view($opid, 'payis') : 0;

			$shipprice = $osid ? $this->get_shipplug_view($osid, 'price') : 0;
			if ($payis_temp > 0) {

				$payprice = ($payis_temp / 100) * $productmoney_dis;
			}

			$orderamount = $productmoney_dis + $payprice + $shipprice;

			$order_snfont = $this->CON['order_snfont'];
			$ordersn = $order_snfont . date('YmdHis') . rand(100, 9999);

			$addtime = time();
			$db_field = 'ordersn,userid,ordertype,osid,opid,shippingsn,paysn,consignee,country,province,city,district,address,
				zipcode,tel,mobile,email,sendtime,invpayee,invcontent,content,treatnote,paytime,shippingtime,productmoney,shippingmoney,
				paymoney,orderamount,discount,integral,addtime';
			$db_values = "'$ordersn',$userid,1,$osid,$opid,'','','$alias',$country,$province,$city,$district,'$address',
				'$zipcode','$tel','$mobile','$email','$sendtime','$invpayee','$invcontent','$content','$treatnote',0,0,$productmoney,$shipprice,
				$payprice,$orderamount,$discountmoney,0,$addtime";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$insert_id = $this->db->insert_id();
			$install_values = str_replace('\'insert_id\'', "$insert_id", $install_values);
			$db_field = 'oid,did,tsn,title,oprice,bprice,countprice,amount,inventory';
			$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field . ') VALUES ' . $install_values);
			$this->writelog($this->lng['ordermain_add_log'], $this->lng['log_extra_ok'] . ' OrderSN=' . $ordersn);
			exit('true');
		} else if ($inputclass == 'edit') {

			$didlist = $this->fun->accept('orderdid', 'P');
			if (count($didlist) < 1 && !is_array($didlist)) {
				exit('false');
			}
			$amountnewarray = array();
			foreach ($didlist as $key => $value) {
				$amountnewarray[$key]['id'] = $value;
				$amountnewarray[$key]['amount'] = $this->fun->accept('orderhow' . $value, 'P');
			}

			$oid = $this->fun->accept('oid', 'P');
			$db_where = 'oid=' . $oid;

			$productmoney = $this->fun->accept('productmoney', 'R');

			$ordersn = $this->fun->accept('ordersn2', 'R');

			$orderamount = $this->fun->accept('orderamount', 'R');

			$shippingmoney = $this->fun->accept('shippingmoney', 'R');

			$paymoney = $this->fun->accept('paymoney', 'R');

			$orderamountold = $this->fun->accept('orderamountold', 'R');

			$discount = $productmoney - ($orderamount - $shippingmoney - $paymoney);

			$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where);

			$db_values = '';
			$arraycount = count($amountnewarray) - 1;
			foreach ($amountnewarray as $key => $value) {
				$rsList = $this->get_documentview($value['id']);
				$amount = $value['amount'];
				$countprice = $amount * $rsList['bprice'];
				$title = $this->fun->acceptset($rsList['title']);
				$tsn = $this->fun->acceptset($rsList['tsn']);
				if ($key == $arraycount) {
					$db_values.= "($oid,$rsList[did],'$tsn','$title',$rsList[oprice],$rsList[bprice],$countprice,$amount,1)";
				} else {
					$db_values.= "($oid,$rsList[did],'$tsn','$title',$rsList[oprice],$rsList[bprice],$countprice,$amount,1),";
				}
			}
			$db_field = 'oid,did,tsn,title,oprice,bprice,countprice,amount,inventory';
			$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field . ') VALUES ' . $db_values);
			$db_set = "osid=$osid,opid=$opid,consignee='$alias',country=$country,province=$province,city=$city,district=$district,address='$address',
				zipcode='$zipcode',tel='$tel',mobile='$mobile',email='$email',sendtime='$sendtime',invpayee='$invpayee',invcontent='$invcontent',content='$content',
				productmoney=$productmoney,shippingmoney=$shippingmoney,paymoney=$paymoney,orderamount=$orderamount,discount=$discount";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['ordermain_edit_log'], $this->lng['log_extra_ok'] . ' OrderSN=' . $ordersn);
			exit('true');
		}
	}

	function onordermode() {
		$db_table = db_prefix . 'order';
		$oid = $this->fun->accept('oid', 'P');
		$value = $this->fun->accept('value', 'P');
		if (empty($oid)) exit('false');
		$db_set = "ordertype=$value";
		$db_where = "oid=$oid";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['ordermain_edit_log'], $this->lng['log_extra_ok'] . ' oid=' . $oid);
		exit('true');
	}

	function onorderdel() {
		$db_table = db_prefix . 'order';
		$db_table1 = db_prefix . 'order_info';
		$db_table2 = db_prefix . 'order_payreceipt';
		$db_table3 = db_prefix . 'order_shipreceipt';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		$selectinfoid = $selectinfoid . '0';
		$db_where = "oid in ($selectinfoid)";
		$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->db->query('DELETE FROM ' . $db_table1 . ' WHERE ' . $db_where);
		$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where);
		$this->db->query('DELETE FROM ' . $db_table3 . ' WHERE ' . $db_where);
		$this->writelog($this->lng['ordermain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onshipprintselect() {
		parent::start_template();
		$oid = $this->fun->accept('oid', 'G');
		$array = $this->get_templates_array(0, $this->CON['is_lancode'], 2, 'print');
		$this->ectemplates->assign('oid', $oid);
		$this->ectemplates->assign('array', $array['list']);
		$this->ectemplates->display('order/order_shipprintselect');
	}

	function onprintlist() {
		parent::start_template();

		$title = $this->fun->accept('title', 'R');

		$othercontent = $this->fun->accept('othercontent', 'R');

		$oid = $this->fun->accept('oid', 'G');

		$printid = $this->fun->accept('printid', 'R');

		$db_table = db_prefix . 'order';
		$db_where = 'oid=' . $oid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$read['province'] = $this->get_cityview($read['province'], 'cityname');
		$read['city'] = $this->get_cityview($read['city'], 'cityname');
		$read['district'] = $this->get_cityview($read['district'], 'cityname');

		$sread = array();
		$sread['order_companyname'] = $this->CON['order_companyname'];
		$sread['order_contact'] = $this->CON['order_contact'];
		$sread['order_province'] = $this->CON['order_province'];
		$sread['order_city'] = $this->CON['order_city'];
		$sread['order_add'] = $this->CON['order_add'];
		$sread['order_post'] = $this->CON['order_post'];
		$sread['order_tel'] = $this->CON['order_tel'];
		$sread['order_moblie'] = $this->CON['order_moblie'];
		$sread['admine_mail'] = $this->CON['admine_mail'];
		$sread['domain'] = $this->CON['domain'];

		$rstemp = $this->get_templates_view($printid);
		$tempcontent = stripslashes(htmlspecialchars_decode($rstemp['templatecontent']));
		;
		require admin_ROOT . adminfile . '/include/inc_print.php';
		foreach ($printinc as $key => $vlaue) {

			$tempcontent = str_replace($vlaue['title'], $vlaue['content'], $tempcontent);
		}
		$this->ectemplates->assign('templist', $tempcontent);
		$this->ectemplates->assign('pic', $rstemp['pic']);
		$this->ectemplates->display('order/order_shipprint');
	}

	function onprintorder() {
		parent::start_template();

		$class = $this->fun->accept('class', 'G');
		$oid = $this->fun->accept('oid', 'G');

		$db_table = db_prefix . 'order';
		$db_where = 'oid=' . $oid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$read['payname'] = $this->get_payplug_view($read['opid'], 'payname');
		$read['shipname'] = $this->get_shipplug_view($read['osid'], 'title');

		$read['province'] = $this->get_cityview($read['province'], 'cityname');
		$read['city'] = $this->get_cityview($read['city'], 'cityname');
		$read['district'] = $this->get_cityview($read['district'], 'cityname');

		$productmoney = $read['productmoney'];

		$dis = 100 - ($read['discount'] / $productmoney) * 100;

		$db_table = db_prefix . 'order_info';
		$db_where = " WHERE oid=$oid";
		$sql = 'SELECT oiid,oid,did,tsn,title,oprice,bprice,countprice,amount,inventory FROM ' . $db_table . $db_where . ' ORDER BY oiid DESC';
		$rs = $this->db->query($sql);
		$arrayList = array();
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$didlist.=$rsList['did'] . ',';

			$endid = $rsList['did'];
			$array[] = $rsList;
		}

		$sread = array();
		$sread['order_companyname'] = $this->CON['order_companyname'];
		$sread['order_contact'] = $this->CON['order_contact'];
		$sread['order_province'] = $this->CON['order_province'];
		$sread['order_city'] = $this->CON['order_city'];
		$sread['order_add'] = $this->CON['order_add'];
		$sread['order_post'] = $this->CON['order_post'];
		$sread['order_tel'] = $this->CON['order_tel'];
		$sread['order_moblie'] = $this->CON['order_moblie'];
		$sread['admine_mail'] = $this->CON['admine_mail'];
		$sread['domain'] = $this->CON['domain'];

		$this->ectemplates->assign('dis', $dis);
		$this->ectemplates->assign('sread', $sread);
		$this->ectemplates->assign('order', $read);
		$this->ectemplates->assign('array', $array);
		if ($class == 1) $this->ectemplates->display('order/order_orderprint1');
		if ($class == 2) $this->ectemplates->display('order/order_orderprint2');
	}

}

?>