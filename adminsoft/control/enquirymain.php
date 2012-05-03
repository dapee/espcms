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

	function onlist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_where = " WHERE eid>0";
		$isclass = intval($this->fun->accept('isclass', 'R'));
		if (!empty($isclass)) {
			$isclass = $isclass - 1;
			$db_where.=' AND isclass=' . $isclass;
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
		$serchekey = $this->fun->accept('serchekey', 'R');
		$keyname = $this->fun->accept('keyname', 'R');
		$keyname = empty($keyname) ? 'username' : $keyname;
		if (!empty($serchekey)) {
			$db_where.=" AND $keyname like '%$serchekey%'";
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'eid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'enquiry';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('enquiry/enquiry_list');
	}

	function onsearch() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;
		$this->ectemplates->display("enquiry/enquiry_search");
	}

	function onenquiryedit() {
		parent::start_template();

		$type = $this->fun->accept('type', 'G');
		$eid = $this->fun->accept('eid', 'G');
		$db_table = db_prefix . 'enquiry';
		$db_where = ' WHERE eid=' . $eid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . $db_where);

		$db_table = db_prefix . 'enquiry_info';
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY eiid DESC';
		$rs = $this->db->query($sql);
		$arrayList = array();
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		if (!empty($read['userid'])) {
			$rsMember = $this->get_member(null, $read['userid']);
		}
		$this->ectemplates->assign('member', $rsMember);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('array', $array);
		if ($type == 'edit') {
			$this->ectemplates->display('enquiry/enquiry_edit');
		} else if ($type == 'read') {
			$this->ectemplates->display('enquiry/enquiry_read');
		}
	}

	function onsave() {
		$inputclass = $this->fun->accept('inputclass', 'P');
		$enquirysn = $this->fun->accept('enquirysn', 'R');
		$userid = $this->fun->accept('userid', 'R');
		$linkman = $this->fun->accept('linkman', 'R');
		$sex = $this->fun->accept('sex', 'R');
		$country = $this->fun->accept('cityone', 'R');
		$province = $this->fun->accept('citytwo', 'R');
		$city = $this->fun->accept('citythree', 'R');
		$district = $this->fun->accept('district', 'R');
		$address = $this->fun->accept('address', 'R');
		$zipcode = $this->fun->accept('zipcode', 'R');
		$tel = $this->fun->accept('tel', 'R');
		$fax = $this->fun->accept('fax', 'R');
		$mobile = $this->fun->accept('mobile', 'R');
		$email = $this->fun->accept('email', 'R');
		$content = $this->fun->accept('content', 'R');
		$editresult = $this->fun->accept('editresult', 'R');
		$db_table = db_prefix . 'enquiry';

		$eid = $this->fun->accept('eid', 'P');
		if (empty($eid)) {
			exit('false');
		}
		$addtime = time();
		$db_where = 'eid=' . $eid;
		$db_set = "linkman='$linkman',sex=$sex,country=$country,province=$province,city=$city,district=$district,address='$address',
		zipcode='$zipcode',tel='$tel',fax='$fax',mobile='$mobile',email='$email',content='$content',edittime=$addtime,editresult='$editresult'";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['enquirymain_edit_log'], $this->lng['log_extra_ok'] . ' enquirysn=' . $enquirysn);
		exit('true');
	}

	function onenquirymode() {
		$db_table = db_prefix . 'enquiry';
		$eid = $this->fun->accept('eid', 'P');
		$value = $this->fun->accept('value', 'P');
		if (empty($eid)) exit('false');
		$addtime = time();
		$db_set = "isclass=$value,edittime=" . $addtime;
		$db_where = "eid=$eid";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['enquirymain_edit_log'], $this->lng['log_extra_ok'] . ' eid=' . $eid);
		exit('true');
	}

	function onenquirydel() {
		$db_table = db_prefix . 'enquiry';
		$db_table1 = db_prefix . 'enquiry_info';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		$selectinfoid = $selectinfoid . '0';
		$db_where = "eid in ($selectinfoid)";
		$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->db->query('DELETE FROM ' . $db_table1 . ' WHERE ' . $db_where);
		$this->writelog($this->lng['enquirymain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onprint() {
		parent::start_template();
		$eid = $this->fun->accept('eid', 'G');
		$db_table = db_prefix . 'enquiry';
		$db_where = ' WHERE eid=' . $eid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . $db_where);

		$db_table = db_prefix . 'enquiry_info';
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY eiid DESC';
		$rs = $this->db->query($sql);
		$arrayList = array();
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}

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

		$this->ectemplates->assign('sread', $sread);
		$this->ectemplates->assign('order', $read);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->display('enquiry/enquiry_print');
	}

}

?>