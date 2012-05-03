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

	function in_into() {
		$did = intval($this->fun->accept('did', 'G'));
		if (empty($did)) trigger_error("Parameter error!", E_USER_ERROR);
		$db_table = db_prefix . 'document';
		$db_sql = "SELECT did,tsn,title FROM $db_table WHERE isclass=1 AND did=$did";
		$readdid = $this->db->fetch_first($db_sql);
		if ($readdid) {

			$cartid = $this->fun->accept('ecisp_enquiry_list', 'C');
			$cartid = stripslashes(htmlspecialchars_decode($cartid));

			$arraykeyname = 'k' . $did;

			if (empty($cartid) || strlen($cartid) < 7) {

				$enquerylist = array($arraykeyname => array('did' => $did, 'amount' => 1));
				$enquerylist = serialize($enquerylist);
			} else {
				$orderid = unserialize($cartid);

				if (is_array($orderid) && array_key_exists($arraykeyname, $orderid)) {

					$amount = $orderid[$arraykeyname]['amount'] + 1;

					unset($orderid[$arraykeyname]);
					$nowcart = array($arraykeyname => array('did' => $did, 'amount' => $amount));
					$newcart = array_merge($orderid, $nowcart);
					$enquerylist = serialize($newcart);
				} elseif (is_array($orderid)) {

					$nowcart = array($arraykeyname => array('did' => $did, 'amount' => 1));
					$newcart = array_merge_recursive($nowcart, $orderid);
					$enquerylist = serialize($newcart);
				} else {
					$nowcart = array($arraykeyname => array('did' => $did, 'amount' => 1));
					$enquerylist = serialize($newcart);
				}
			}
			$this->fun->setcookie('ecisp_enquiry_list', $enquerylist, 7200);
			$enquirylink = $this->get_link('enquiry', array(), admin_LNG);
			$linkURL = $_SERVER['HTTP_REFERER'];
			$this->callmessage($this->lng['enqiry_into_ok'], $linkURL, $this->lng['enquiry_into_goback'], 1, $this->lng['enquiry_into_listbotton'], 1, $enquirylink);
		} else {
			$linkURL = $_SERVER['HTTP_REFERER'];
			$this->callmessage($this->lng['enqiry_into_err'], $linkURL, $this->lng['gobackbotton']);
		}
	}

	function in_list() {
		parent::start_pagetemplate();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;

		if ($this->CON['is_enquiry_memclass']) {
			parent::member_purview(0, $this->get_link('enquiry', array(), admin_LNG));
			if (!empty($this->ec_member_username_id) && !empty($this->ec_member_username)) {

				$rsMember = $this->get_member(null, $this->ec_member_username_id);
			}
			$this->pagetemplate->assign('member', $rsMember);
		} else {
			$membercookieview = $this->member_cookieview();
			if (!empty($membercookieview['userid']) && !empty($membercookieview['username'])) {

				$rsMember = $this->get_member(null, $membercookieview['userid']);
			}
			$this->pagetemplate->assign('member', $rsMember);
		}
		$cartid = $this->fun->accept('ecisp_enquiry_list', 'C');
		$cartid = stripslashes(htmlspecialchars_decode($cartid));
		$uncartid = !empty($cartid) ? unserialize($cartid) : 0;
		if ($uncartid && is_array($uncartid)) {

			$didarray = $this->fun->key_array_name($uncartid, 'did', 'amount');
			$didlist = $this->fun->format_array_text(array_keys($didarray), ',');
			if (!empty($didlist)) {
				$db_table = db_prefix . 'document';
				$db_where = "isclass=1 AND did in($didlist) ORDER BY did DESC";
				$sql = "SELECT * FROM $db_table WHERE $db_where";
				$rs = $this->db->query($sql);

				$productmoney = 0;
				while ($rsList = $this->db->fetch_assoc($rs)) {
					$rsList['link'] = $this->get_link('doc', $rsList, admin_LNG);
					$rsList['buylink'] = $this->get_link('buylink', $rsList, admin_LNG);
					$rsList['enqlink'] = $this->get_link('enqlink', $rsList, admin_LNG);
					$rsList['dellink'] = $this->get_link('enqdel', $rsList, admin_LNG);
					$rsList['ctitle'] = empty($rsList['color']) ? $rsList['title'] : "<font color='" . $rsList['color'] . "'>" . $rsList['title'] . "</font>";
					$rsList['amount'] = $didarray[$rsList['did']];
					$array[] = $rsList;
				}
			}
			$this->pagetemplate->assign('array', $array);
		} else {
			$this->pagetemplate->assign('ordervirtue', 'false');
		}
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('mem_isaddress', $this->CON['mem_isaddress']);

		$templatesDIR = $this->get_templatesdir('order');
		$this->pagetemplate->assign('path', 'enquiry');
		$templatefilename = $lng . '/' . $templatesDIR . '/enquiry_center';
		$this->pagetemplate->assign('out', 'list');
		unset($array, $this->mlink, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'enquiry_list', false, '', admin_LNG);
	}

	function in_enquirysave() {
		parent::start_pagetemplate();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		if ($this->CON['is_enquiry_memclass']) {
			parent::member_purview(0, $this->get_link('enquiry', array(), admin_LNG));
		}
		$cartid = $this->fun->accept('ecisp_enquiry_list', 'C');
		$cartid = stripslashes(htmlspecialchars_decode($cartid));
		$uncartid = !empty($cartid) ? unserialize($cartid) : 0;

		$userid = intval($this->fun->accept('userid', 'P'));
		$userid = !empty($userid) ? $userid : 0;
		$linkman = trim($this->fun->accept('linkman', 'P', true, true));
		$email = $this->fun->accept('email', 'P');
		$sex = $this->fun->accept('sex', 'P');
		$sex = empty($sex) ? 0 : $sex;
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
		$fax = trim($this->fun->accept('fax', 'P', true, true));
		$content = trim($this->fun->accept('content', 'P', true, true));
		$amount = $this->fun->accept('amount', 'P');
		$ptitle = $this->fun->accept('ptitle', 'P');
		$tsn = $this->fun->accept('tsn', 'P');
		$did = $this->fun->accept('did', 'P');
		if (empty($did) || empty($amount) || empty($ptitle)) {
			$enquirylink = $this->get_link('enquiry', array(), admin_LNG);
			$this->callmessage($this->lng['enquiry_input_err'], $enquirylink, $this->lng['enquiry_into_listbotton']);
		}
		if (!preg_match("/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i", $email)) {
			$this->callmessage($this->lng['email_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackbotton']);
		}
		$enquirysn = date('YmdHis') . rand(100, 9999);
		$db_table = db_prefix . 'enquiry';
		$db_table2 = db_prefix . 'enquiry_info';
		$addtime = time();
		$db_field = 'enquirysn,userid,linkman,sex,country,province,city,district,address,zipcode,tel,fax,mobile,email,content,isclass,addtime,edittime';
		$db_values = "'$enquirysn',$userid,'$linkman',$sex,$country,$province,$city,$district,'$address','$zipcode','$tel','$fax','$mobile','$email','$content',0,$addtime,0";
		$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
		$insert_id = $this->db->insert_id();
		$db_values = '';
		$arraycount = count($did) - 1;
		foreach ($did as $key => $value) {
			if ($key == $arraycount) {
				$db_values.= "($insert_id,$value,'$tsn[$key]','$ptitle[$key]',$amount[$key],'')";
			} else {
				$db_values.= "($insert_id,$value,'$tsn[$key]','$ptitle[$key]',$amount[$key],''),";
			}
		}
		$db_field = 'eid,did,tsn,title,amount,comment';
		$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field . ') VALUES ' . $db_values);

		if ($this->CON['is_email'] == 1) {

			$this->enquirymailsend('enquirywarn', $insert_id, $this->CON['admine_mail']);

			$this->enquirymailsend('enquiryre', $insert_id, $email);
		}

		$this->fun->setcookie('ecisp_enquiry_list', null);
		$enquirylink = $this->get_link('enquiry', array(), admin_LNG);
		$this->callmessage($this->lng['enquiry_ok'], $enquirylink, $this->lng['enquiry_into_listbotton']);
	}

	function in_delenq() {
		$did = intval($this->fun->accept('did', 'R'));
		if (empty($did)) trigger_error("Product parameter error!", E_USER_ERROR);
		$cartid = $this->fun->accept('ecisp_enquiry_list', 'C');
		$cartid = stripslashes(htmlspecialchars_decode($cartid));
		$uncartid = !empty($cartid) ? unserialize($cartid) : 0;
		$arraykeyname = 'k' . $did;
		unset($uncartid[$arraykeyname]);
		$enquerylist = serialize($uncartid);

		$this->fun->setcookie('ecisp_enquiry_list', $enquerylist, 7200);
		$enquirylink = $this->get_link('enquiry', array(), admin_LNG);
		$this->callmessage($this->lng['enquiry_delok'], $enquirylink, $this->lng['enquiry_into_listbotton']);
	}

	function in_cleargoods() {
		$this->fun->setcookie('ecisp_enquiry_list', null);
		$enquirylink = $this->get_link('enquiry', array(), admin_LNG);
		$this->callmessage($this->lng['enquiry_cleargoods'], $enquirylink, $this->lng['enquiry_into_goback']);
	}

}

?>
