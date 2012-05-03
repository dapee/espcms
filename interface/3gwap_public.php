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

	function in_index() {
		parent::start_pagetemplate();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('path', 'index');
		$this->pagetemplate->display(admin_LNGDIR . 'index', 'index', false, null, admin_LNG);
	}

	function in_seccodelist() {
		$seccode = rand(100000, 999999);
		$this->fun->setcookie('ecisp_home_seccode', $this->fun->eccode($seccode . "\t" . time(), 'ENCODE'));
		@header("Expires: -1");
		@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
		@header("Pragma: no-cache");
		include_once admin_ROOT . 'public/class_seccode.php';
		$code = new seccode();
		$code->code = $seccode;
		$code->type = 0;
		$code->width = 70;
		$code->height = 23;
		$code->background = 30;

		$code->adulterate = $this->CON['scode_adulterate'];

		$code->ttf = 0;
		$code->angle = 0;

		$code->color = 0;
		$code->size = 1;

		$code->shadow = $this->CON['scode_shadow'];
		$code->animator = 0;

		$code->bgcolor = $this->CON['scode_bgcolor'];

		$code->fontcolor = $this->CON['scode_fontcolor'];

		$code->datapath = admin_ROOT . 'datacache/';
		$code->includepath = '';
		$code->display();
	}

	function in_citylist() {
		$parentid = $this->fun->accept('parentid', 'R');
		$parentid = empty($parentid) ? 1 : intval($parentid);
		$verid = $this->fun->accept('verid', 'R');
		$verid = empty($verid) ? 0 : intval($verid);
		$db_table = db_prefix . 'city';
		$sql = "SELECT * FROM $db_table WHERE parentid=$parentid";
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_array($rs)) {
			$citylist[] = $rsList;
		}
		foreach ($citylist as $key => $val) {
			if ($verid == $val['id']) {
				$list.='<option selected value="' . $val['id'] . '">' . $val['cityname'] . '</option>';
			} else {
				$list.='<option value="' . $val['id'] . '">' . $val['cityname'] . '</option>';
			}
		}
		if (admin_LNG == 'big5') {
			$list = $this->fun->codeing($list, 'gb');
		}
		exit($list);
	}

	function in_checkusername() {
		$username = $this->fun->accept('username', 'R');
		$email = $this->fun->accept('email', 'R');

		if (!preg_match("/^[^!@~`\'\"#\$\%\^&\*\(\)\+\-\{\}\[\]\|\\/\?\<\>\,\.\:\;]{2,16}$/i", $username) && !empty($username)) {
			exit('false');
		} elseif (!preg_match("/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i", $email) && !empty($email)) {
			exit('false');
		}
		if ($this->CON['mem_isucenter']) {
			include_once admin_ROOT . 'public/uc_client/client.php';
			if (!empty($username)) {

				$data = uc_get_user($username);
				if ($data) {
					exit('false');
				}
			} elseif (!empty($email)) {
				$ucresult = uc_user_checkemail($email);
				if ($ucresult == -6 || $ucresult == -5) {
					exit('false');
				}
			}
		}
		$db_table = db_prefix . 'member';
		if (!empty($username)) {

			$lockusername = explode(',', $this->CON['mem_lock']);
			if (in_array($username, $lockusername)) {
				exit('false');
			}
			$db_where = " WHERE username='$username'";
		} elseif (!empty($email)) {
			$db_where = " WHERE email='$email'";
		}
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			$exportAjax = 'false';
		} else {
			$exportAjax = 'true';
		}
		exit($exportAjax);
	}

	function in_typepuv() {
		if (!$this->CON['is_html']) {
			return true;
		}
		$tid = intval($this->fun->accept('tid', 'G'));
		$typeread = $this->get_type($tid);
		$userrank = $typeread['purview'];

		if ($typeread['styleid'] == 3) {
			$typelink = $this->get_waplink('type', $typeread, admin_LNG);
			$text = "javascript:location.href='" . $typelink . "';";
			exit($text);
		}
		if (!$userrank) {
			return true;
		}

		$this->ec_member_username = $this->fun->eccode($this->fun->accept('ecisp_member_username', 'C'), 'DECODE', db_pscode);

		$this->ec_member_username_id = $this->fun->accept('ecisp_member_username_id', 'C');
		$user_info = explode('|', $this->fun->eccode($this->fun->accept('ecisp_member_info', 'C'), 'DECODE', db_pscode));
		$mlink = $this->memberlink(array(), admin_LNG);
		if (empty($this->ec_member_username) || empty($this->ec_member_username_id)) {
			$this->fun->setcookie('ecisp_login_link', $_SERVER['HTTP_REFERER'], 3600);
			$linkURL = $this->get_waplink('memberlogin', array(), admin_LNG);
			if (admin_LNG == 'big5') {
				$str = $this->fun->codeing($this->lng['memberloginerr'], 'ub');
			} else {
				$str = $this->lng['memberloginerr'];
			}
			$text = "javascript:if (confirm('" . $str . "')){location.href='" . $linkURL . "'}else{location.href='" . $mlink['reg'] . "'};";
			exit($text);
		} else {
			list($this->ec_member_alias, $this->ec_member_integral, $this->ec_member_mcid, $this->ec_member_email, $this->ec_member_lastip) = $user_info;
			if ($this->ec_member_mcid < $userrank && $userrank) {
				$linkURL = $this->get_waplink('memberlogin', array(), admin_LNG);
				if (admin_LNG == 'big5') {
					$str = $this->fun->codeing($this->lng['memberpuverr'], 'ub');
				} else {
					$str = $this->lng['memberpuverr'];
				}
				$text = "javascript:if (confirm('" . $str . "')){location.href='" . $linkURL . "'}else{location.href='" . $mlink['reg'] . "'};";
				exit($text);
			}
		}
	}

	function in_readpuv() {
		if (!$this->CON['is_html']) {
			return true;
		}
		$did = intval($this->fun->accept('did', 'G'));
		if (empty($did)) {
			return false;
		}
		$readinfo = $this->get_documentview($did);
		if (empty($readinfo['tid'])) return false;
		$typeread = $this->get_type($readinfo['tid']);

		$userrank = $typeread['purview'];

		$userrank2 = $readinfo['purview'];
		if (!$readinfo['isclass']) {
			$text = "javascript:location.href='" . $this->CON['domain'] . "';";
			exit($text);
		}

		if ($readinfo['islink']) {
			$urladd = $readinfo['link'];
			$text = "javascript:location.href='" . $urladd . "';";
			exit($text);
		}

		$db_table = db_prefix . 'document';
		$db_where = "isclass=1 AND did=$did";
		$db_set = "click=click+1";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		if (!$userrank && !$userrank2) {

			return true;
		} elseif ($userrank < $userrank2) {

			$userrank = $userrank2;
		}

		$this->ec_member_username = $this->fun->eccode($this->fun->accept('ecisp_member_username', 'C'), 'DECODE', db_pscode);

		$this->ec_member_username_id = $this->fun->accept('ecisp_member_username_id', 'C');
		$user_info = explode('|', $this->fun->eccode($this->fun->accept('ecisp_member_info', 'C'), 'DECODE', db_pscode));
		$mlink = $this->memberlink(array(), admin_LNG);
		if (empty($this->ec_member_username) || empty($this->ec_member_username_id)) {
			$this->fun->setcookie('ecisp_login_link', $_SERVER['HTTP_REFERER'], 3600);
			$linkURL = $this->get_waplink('memberlogin', array(), admin_LNG);
			if (admin_LNG == 'big5') {
				$str = $this->fun->codeing($this->lng['memberloginerr'], 'ub');
			} else {
				$str = $this->lng['memberloginerr'];
			}
			$text = "javascript:if (confirm('" . $str . "')){location.href='" . $linkURL . "'}else{location.href='" . $mlink['reg'] . "'};";
			exit($text);
		} else {
			list($this->ec_member_alias, $this->ec_member_integral, $this->ec_member_mcid, $this->ec_member_email, $this->ec_member_lastip) = $user_info;
			if ($this->ec_member_mcid < $userrank && $userrank) {
				$linkURL = $this->get_waplink('memberlogin', array(), admin_LNG);
				if (admin_LNG == 'big5') {
					$str = $this->fun->codeing($this->lng['memberpuverr'], 'ub');
				} else {
					$str = $this->lng['memberpuverr'];
				}
				$text = "javascript:if (confirm('" . $str . "')){location.href='" . $linkURL . "'}else{location.href='" . $mlink['reg'] . "'};";
				exit($text);
			}
		}
	}

	function in_invite() {
		$linkURL = $_SERVER['HTTP_REFERER'];
		$mlvid = intval($this->fun->accept('mlvid', 'R'));
		$lng = $this->fun->accept('lng', 'R');
		if (!$mlvid) {
			$this->callmessage($this->lng['db_err'], $linkURL, $this->lng['gobackbotton']);
		}
		$email = $this->fun->accept('email', 'R');
		if (!preg_match("/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i", $email) || empty($email)) {
			$this->callmessage($this->lng['email_err'], $linkURL, $this->lng['gobackbotton']);
		}

		$db_table = db_prefix . "mailinvite_list";
		$db_where = " WHERE email='$email' AND mlvid=$mlvid";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			$this->callmessage($this->lng['mem_regemail_no'], $linkURL, $this->lng['gobackbotton']);
		}

		$addtime = time();
		$ec_member_username_id = $this->member_cookieview('userid');
		if ($ec_member_username_id) {
			$rsMember = $this->get_member_attvalue($ec_member_username_id);
		}
		$userid = $ec_member_username_id ? $ec_member_username_id : 0;
		$name = $rsMember['alias'] ? $rsMember['alias'] : '';

		$sex = $rsMember['sex'] ? $rsMember['sex'] : 0;
		$tel = $rsMember['tel'] ? $rsMember['tel'] : '';
		$address = $rsMember['address'] ? $rsMember['address'] : '';

		$db_field = 'mlvid,userid,name,sex,email,tel,address,isclass,addtime';
		$db_values = "$mlvid,$userid,'$name',$sex,'$email','$tel','$address',1,$addtime";
		$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');

		$this->callmessage($this->lng['invite_ok'], $linkURL, $this->lng['gobackbotton']);
	}

}

?>