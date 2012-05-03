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

	function in_center() {
		if ($this->CON['mem_isucenter']) {
			include_once admin_ROOT . 'public/uc_client/client.php';
		}
		parent::start_pagetemplate();
		parent::member_purview();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$db_where = "userid=$this->ec_member_username_id AND username='$this->ec_member_username' ";
		$db_table1 = db_prefix . 'member AS a';
		$db_table2 = db_prefix . 'member_value AS b';
		$db_sql = "SELECT * FROM $db_table1 LEFT JOIN $db_table2 ON a.userid = b.userid  WHERE a.userid = $this->ec_member_username_id ";
		$rsMember = $this->db->fetch_first($db_sql);

		$rsMember['rankname'] = $this->get_member_purview($rsMember['mcid'], 'rankname');
		$userid = $this->ec_member_username_id;
		if (empty($userid)) {
			exit('user err!');
		}
		$db_table = db_prefix . "order";

		$db_where = " WHERE userid=$userid";

		$db_where2 = " WHERE userid=$userid and ordertype=1";

		$db_where3 = " WHERE userid=$userid and ordertype=3";
		$this->pagetemplate->assign('ordernum', $this->db_numrows($db_table, $db_where));
		$this->pagetemplate->assign('ordernum2', $this->db_numrows($db_table, $db_where2));
		$this->pagetemplate->assign('ordernum3', $this->db_numrows($db_table, $db_where3));

		$db_table = db_prefix . "bbs";
		$db_where = " WHERE userid=$userid";

		$this->pagetemplate->assign('messagenum', $this->db_numrows($db_table, $db_where));

		$templatesDIR = $this->get_templatesdir('member');

		$templatefilename = $lng . '/' . $templatesDIR . '/member_center';
		$this->pagetemplate->assign('out', 'center');
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('member', $rsMember);
		$this->pagetemplate->assign('path', 'member');
		unset($rsMember, $mlink, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'center', false, null, admin_LNG);
	}

	function in_editinfo() {
		parent::start_pagetemplate();
		parent::member_purview();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$rsMember = $this->get_member_attvalue($this->ec_member_username_id);

		$modelatt = $this->get_memberatt_array($lng, false);
		if (is_array($modelatt)) {
			foreach ($modelatt as $key => $value) {
				if ($value['inputtype'] == 'select' || $value['inputtype'] == 'radio') {
					foreach ($value['attrvalue'] as $key2 => $value2) {
						if ($rsMember[$value['attrname']] == $value2['name']) {
							$modelatt[$key]['attrvalue'][$key2]['selected'] = 'selected';
						}
					}
				} elseif ($value['inputtype'] == 'checkbox') {
					$expvale = explode(',', $rsMember[$value['attrname']]);
					foreach ($value['attrvalue'] as $key2 => $value2) {
						if (in_array($value2['name'], $expvale)) {
							$modelatt[$key]['attrvalue'][$key2]['selected'] = 'selected';
						}
					}
				} else {
					$modelatt[$key]['attrvalue'] = $rsMember[$value['attrname']];
				}
			}
		}
		$templatesDIR = $this->get_templatesdir('member');

		$templatefilename = $lng . '/' . $templatesDIR . '/member_center';
		$this->pagetemplate->assign('mem_isaddress', $this->CON['mem_isaddress']);
		$this->pagetemplate->assign('out', 'editinfo');
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('modelatt', $modelatt);
		$this->pagetemplate->assign('member', $rsMember);
		$this->pagetemplate->assign('upurl', $_SERVER['HTTP_REFERER']);
		$this->pagetemplate->assign('path', 'member');
		unset($rsMember, $mlink, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'center', false, null, admin_LNG);
	}

	function in_editpassword() {
		parent::start_pagetemplate();
		parent::member_purview();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$rsMember = $this->get_member_attvalue($this->ec_member_username_id);

		$templatesDIR = $this->get_templatesdir('member');

		$templatefilename = $lng . '/' . $templatesDIR . '/member_center';
		$this->pagetemplate->assign('out', 'editpassword');
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('attrread', $attlist);
		$this->pagetemplate->assign('member', $rsMember);
		$this->pagetemplate->assign('upurl', $_SERVER['HTTP_REFERER']);
		$this->pagetemplate->assign('path', 'member');
		unset($rsMember, $mlink, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'center', false, null, admin_LNG);
	}

	function in_editemail() {
		parent::start_pagetemplate();
		parent::member_purview();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$rsMember = $this->get_member_attvalue($this->ec_member_username_id);
		$templatesDIR = $this->get_templatesdir('member');

		$templatefilename = $lng . '/' . $templatesDIR . '/member_center';
		$this->pagetemplate->assign('out', 'editemail');
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('attrread', $attlist);
		$this->pagetemplate->assign('member', $rsMember);
		$this->pagetemplate->assign('upurl', $_SERVER['HTTP_REFERER']);
		$this->pagetemplate->assign('path', 'member');
		unset($rsMember, $mlink, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'center', false, null, admin_LNG);
	}

	function in_save() {
		parent::start_pagetemplate();
		parent::member_purview();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$inputclass = $this->fun->accept('inputclass', 'R');
		$upurl = $this->fun->accept('upurl', 'R');
		$userid = intval($this->fun->accept('userid', 'P'));
		$username = $this->fun->accept('username', 'P');
		if (empty($userid) || empty($username)) {
			$linkURL = $this->mlink['center'];
			$this->callmessage($this->lng['member_edit_ok'], $linkURL, $this->lng['gobackurlbotton']);
		}
		$email = trim($this->fun->accept('email', 'P'));
		$question = trim($this->fun->accept('question', 'P', true, true));
		$answer = trim($this->fun->accept('answer', 'P', true, true));
		$alias = trim($this->fun->accept('alias', 'P', true, true));
		$sex = $this->fun->accept('sex', 'P');
		$sex = empty($sex) ? 0 : $sex;
		$tel = trim($this->fun->accept('tel', 'P', true, true));
		$mobile = trim($this->fun->accept('mobile', 'P', true, true));
		$birthday = $this->fun->accept('birthday', 'P');
		$birthday = empty($birthday) ? 0 : $this->fun->formatdate($birthday, 4);
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
		$zipcode = empty($zipcode) ? 0 : $zipcode;
		$msn = trim($this->fun->accept('msn', 'P', true, true));
		$qq = $this->fun->accept('qq', 'P');
		$qq = empty($qq) ? 0 : $qq;

		$db_table = db_prefix . 'member';
		$db_table2 = db_prefix . 'member_value';
		$date = time();
		$linkURL = $_SERVER['HTTP_REFERER'];

		if ($inputclass == 'editinfo') {
			$mvid = intval($this->fun->accept('mvid', 'P'));

			$modelatt = $this->get_memberatt_array($lng);
			if (is_array($modelatt)) {
				$modelarray = array();
				foreach ($modelatt as $key => $value) {

					if ($value['inputtype'] == 'htmltext') {

						$value['accept'] = 'html';
					} elseif ($value['inputtype'] == 'checkbox') {

						$value['accept'] = 'checkbox';
					} elseif ($value['inputtype'] == 'string' || $value['inputtype'] == 'img' || $value['inputtype'] == 'addon' || $value['inputtype'] == 'video' || $value['inputtype'] == 'select' || $value['inputtype'] == 'radio' || $value['inputtype'] == 'selectinput') {

						$value['accept'] = 'text';
					} elseif ($value['inputtype'] == 'editor' || $value['inputtype'] == 'text') {

						$value['accept'] = 'editor';
					} elseif ($value['inputtype'] == 'int' || $value['inputtype'] == 'float' || $value['inputtype'] == 'decimal') {

						$value['accept'] = 'int';
					} elseif ($value['inputtype'] == 'datetime') {

						$value['accept'] = 'data';
					}
					$modelarray[] = $value;
				}


				$userinstall = null;

				$userinstalldb = null;
				foreach ($modelarray as $key => $value) {
					$userinstall.=$value['attrname'] . ',';
					if ($value['accept'] == 'int') {
						$valuestr = $this->fun->accept($value['attrname'], 'P');
						$valuestr = empty($valuestr) ? 0 : $valuestr;
						$userinstalldb.="$valuestr,";
						$userupdatedb.=$value['attrname'] . "=$valuestr,";
					} elseif ($value['accept'] == 'html') {
						$valuestr = $this->fun->accept($value['attrname'], 'P');
						$valuestr = empty($valuestr) ? '' : $this->fun->Text2Html($valuestr);
						$userinstalldb.="'$valuestr',";
						$userupdatedb.=$value['attrname'] . "='$valuestr',";
					} elseif ($value['accept'] == 'editor' || $value['accept'] == 'text') {
						$valuestr = $this->fun->accept($value['attrname'], 'P');
						$userinstalldb.="'$valuestr',";
						$userupdatedb.=$value['attrname'] . "='$valuestr',";
					} elseif ($value['accept'] == 'data') {
						$valuestr = $this->fun->accept($value['attrname'], 'P');
						$valuestr = empty($valuestr) ? 0 : strtotime($valuestr);
						$userinstalldb.="$valuestr,";
						$userupdatedb.=$value['attrname'] . "=$valuestr,";
					} elseif ($value['accept'] == 'checkbox') {
						$valuestr = $this->fun->accept($value['attrname'], 'P');
						$valuestr = is_array($valuestr) ? implode(',', $valuestr) : '';
						$userinstalldb.="'$valuestr',";
						$userupdatedb.=$value['attrname'] . "='$valuestr',";
					}
				}
			}

			$db_where = 'userid=' . $userid;
			$db_set = "sex=$sex,birthday=$birthday,country=$country,province=$province,city=$city,district=$district,alias='$alias',
			address='$address',zipcode=$zipcode,tel='$tel',mobile='$mobile',qq=$qq,msn='$msn'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

			if ($userinstalldb) {

				if ($mvid) {
					$db_where = 'userid=' . $userid . ' AND mvid=' . $mvid;
					$db_values = substr($userupdatedb, 0, strlen($userupdatedb) - 1);
					$this->db->query('UPDATE ' . $db_table2 . ' SET ' . $db_values . ' WHERE ' . $db_where);
				} else {
					$db_field = $userinstall . 'userid';
					$db_values = $userinstalldb . $userid;
					$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field . ') VALUES (' . $db_values . ')');
				}
			}
			$linkURL = $this->mlink['center'];
			$this->callmessage($this->lng['member_edit_ok'], $linkURL, $this->lng['gobackurlbotton']);
		}

		if ($inputclass == 'editpassword') {
			if ($this->CON['mem_isucenter']) {
				include_once admin_ROOT . 'public/uc_client/client.php';
			}
			$oldpassword = md5($this->fun->accept('oldpassword', 'P'));
			$password = md5($this->fun->accept('password', 'P'));
			$password_uc = $this->fun->accept('password', 'P');
			$oldpassword_uc = $this->fun->accept('oldpassword', 'P');

			$db_where = "userid= $userid AND username='$username' AND password='$oldpassword'";
			$db_sql = "SELECT * FROM $db_table WHERE $db_where";
			$rsMember = $this->db->fetch_first($db_sql);
			if (!$rsMember) {
				$linkURL = $this->mlink['memedit_password'];
				$this->callmessage($this->lng['password_input_err'], $linkURL, $this->lng['gobackbotton']);
			} else {
				$db_set = "password='$password'";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
				if ($this->CON['mem_isucenter']) {
					$data = uc_get_user($username);
					if ($data) {
						list($uid2, $username2, $email2) = $data;
						uc_user_edit($username, $oldpassword_uc, $password_uc, $email2);
					}
				}
				$linkURL = $this->mlink['quit'];
				$this->callmessage($this->lng['password_ok'], $linkURL, $this->lng['out_botton']);
			}
		}

		if ($inputclass == 'editmail') {
			if ($this->CON['mem_isucenter']) {
				include_once admin_ROOT . 'public/uc_client/client.php';
			}
			$linkURL = $this->mlink['memedit_email'];

			if (!preg_match("/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i", $email)) {
				$this->callmessage($this->lng['email_err'], $linkURL, $this->lng['gobackbotton']);
			}
			$password = md5($this->fun->accept('password', 'P'));
			$password_uc = $this->fun->accept('password', 'P');
			$db_where = "userid= $userid AND username='$username' AND password='$password'";
			$db_sql = "SELECT * FROM $db_table WHERE $db_where";
			$rsMember = $this->db->fetch_first($db_sql);
			if (!$rsMember) {
				$this->callmessage($this->lng['password_input_err'], $linkURL, $this->lng['gobackbotton']);
			} else {
				$db_set = "email='$email'";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
				if ($this->CON['mem_isucenter']) {
					$data = uc_get_user($username);
					if ($data) {
						list($uid2, $username2, $email2) = $data;
						uc_user_edit($username, $password_uc, $password_uc, $email);
					}
				}
				$linkURL = $this->mlink['center'];
				$this->callmessage($this->lng['email_edit_ok'], $linkURL, $this->lng['gobackurlbotton']);
			}
		}
	}

	function checkdid($did, $dbname) {
		if (empty($did)) {
			return false;
		}
		$db_table = db_prefix . $dbname;
		$db_where = " WHERE userid='$did'";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			return true;
		} else {
			return false;
		}
	}

}

?>