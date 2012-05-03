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
		parent::member_purview(0, $this->mlink['enquirylist']);
		include_once admin_ROOT . 'public/class_pagebotton.php';
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;

		$page = $this->fun->accept('page', 'G');
		$page = isset($page) ? intval($page) : 1;

		$pagesylte = 1;

		$pagemax = intval($this->CON['order_max_list']);
		$userid = $this->ec_member_username_id;
		if (empty($userid)) {
			$this->callmessage($this->lng['db_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
		}

		$db_table = db_prefix . 'enquiry';
		$db_where = " WHERE userid=$userid";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {

			$numpage = ceil($countnum / $pagemax);
		} else {
			$numpage = 1;
		}
		$sql = "SELECT eid,enquirysn,userid,linkman,country,province,city,district,address,zipcode,tel,fax,mobile,email,content,isclass,addtime,edittime,editresult FROM $db_table $db_where LIMIT 0,$pagemax";
		$this->htmlpage = new PageBotton($sql, $pagemax, $page, $countnum, $numpage, $pagesylte, $this->CON['file_fileex'], 5, $this->lng['pagebotton'], $this->lng['gopageurl'], $this->CON['is_rewrite']);
		$sql = $this->htmlpage->PageSQL('eid', 'down');
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {

			$validtime = $this->fun->formatdate(4, $rsList['addtime']) + 3600;

			$rsList['editclass'] = time() - $validtime > 1800 ? 'false' : 'true';
			$rsList['link'] = $this->get_link('enquiryread', $rsList, admin_LNG);
			$rsList['dlink'] = $this->get_link('enquirydel', $rsList, admin_LNG);
			$array[] = $rsList;
		}

		$templatesDIR = $this->get_templatesdir('member');

		$templatefilename = $lng . '/' . $templatesDIR . '/member_center';
		$this->pagetemplate->assign('out', 'enquirylist');
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('pagetext', $this->htmlpage->PageStat($this->lng['pagetext']));
		$this->pagetemplate->assign('pagebotton', $this->htmlpage->PageList());
		$this->pagetemplate->assign('pagenu', $this->htmlpage->Bottonstyle(false));
		$this->pagetemplate->assign('pagese', $this->htmlpage->pageSelect());
		$this->pagetemplate->assign('pagevt', $this->htmlpage->Prevbotton());
		$this->pagetemplate->assign('array', $array);
		$this->pagetemplate->assign('path', 'member');
		unset($array, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'member_enquiry_list', false, '', admin_LNG);
	}

	function in_read() {
		parent::start_pagetemplate();
		parent::member_purview(0, $this->mlink['enquirylist']);
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$eid = $this->fun->accept('eid', 'G');
		if (empty($eid)) {
			$this->callmessage($this->lng['db_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
		}
		$eid = isset($eid) ? intval($eid) : 0;
		$db_table = db_prefix . 'enquiry';
		$db_where = 'eid=' . $eid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$db_table = db_prefix . "enquiry_info a," . db_prefix . "document b";
		$db_where = " WHERE a.eid=$eid AND a.did=b.did";
		$sql = 'SELECT a.*,b.filename,b.filepath,b.ishtml FROM ' . $db_table . $db_where;
		$rs = $this->db->query($sql);
		$arrayList = array();
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rsList['link'] = $this->get_link('doc', $rsList, admin_LNG);
			$array[] = $rsList;
		}
		$this->pagetemplate->assign('read', $read);
		$this->pagetemplate->assign('array', $array);
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('path', 'member');
		$this->pagetemplate->assign('mem_isaddress', $this->CON['mem_isaddress']);

		$templatesDIR = $this->get_templatesdir('member');

		$templatefilename = $lng . '/' . $templatesDIR . '/member_center';
		$this->pagetemplate->assign('out', 'enquiryread');
		unset($array, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'member_enquiry_read', false, '', admin_LNG);
	}

	function in_enquiryeditsave() {
		parent::start_pagetemplate();
		parent::member_purview(0, $this->mlink['orderlist']);
		$eid = $this->fun->accept('eid', 'P');
		if (empty($eid)) {
			$this->callmessage($this->lng['db_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
		}
		$linkman = trim($this->fun->accept('linkman', 'P', true, true));
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
		$fax = trim($this->fun->accept('fax', 'P', true, true));
		$mobile = trim($this->fun->accept('mobile', 'P', true, true));
		$content = trim($this->fun->accept('content', 'P', true, true));
		$db_where = 'eid=' . $eid;
		$db_table = db_prefix . 'enquiry';
		$db_set = "linkman='$linkman',sex=$sex,country=$country,province=$province,city=$city,district=$district,address='$address',
		zipcode='$zipcode',tel='$tel',fax='$fax',mobile='$mobile',content='$content'";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->callmessage($this->lng['enquiry_memberinfoedit_ok'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
	}

	function in_del() {
		parent::member_purview(0, $this->mlink['enquirylist']);
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$eid = $this->fun->accept('eid', 'G');
		if (empty($eid)) {
			$this->callmessage($this->lng['db_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
		}

		$db_table = db_prefix . 'enquiry';
		$db_where = 'isclass=0 and eid=' . $eid;
		$db_set = "isclass=2";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->callmessage($this->lng['enquiry_edit_del'], $this->mlink['enquirylist'], $this->lng['gobackurlbotton']);
	}

}

?>
