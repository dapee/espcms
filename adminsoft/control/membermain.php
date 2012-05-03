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

	function onmemberlist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_where = " WHERE userid>0";
		$mcid = $this->fun->accept('mcid', 'R');
		if (!empty($mcid)) {
			$db_where.=' AND mcid=' . $mcid;
		}
		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
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
		$limitkey = empty($limitkey) ? 'userid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;

		$db_table = db_prefix . 'member';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rankname = $this->get_member_purview($rsList['mcid'], 'rankname');
			$rsList['rankname'] = $rankname;
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('member/member_list');
	}

	function onsearch() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$memberpuv = $this->get_member_purview_array();
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);
		$this->ectemplates->display("member/member_search");
	}

	function onmemberadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$this->ectemplates->assign('tab', $tab);

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$attrread = $this->get_memberatt_array($lng);
		$this->ectemplates->assign('modelatt', $attrread);

		$memberpuv = $this->get_member_purview_array();
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);

		$this->ectemplates->assign('defaultinput', $this->CON);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->display('member/member_add');
	}

	function onmemberedit() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$isclose = $this->fun->accept('isclose', 'G');
		$isclose = empty($isclose) ? 0 : $isclose;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$userid = $this->fun->accept('userid', 'R');
		if (empty($userid)) exit('false');
		$rsList = $this->get_member_attvalue($userid);

		$modelatt = $this->get_memberatt_array($lng, false);
		if (is_array($modelatt)) {
			foreach ($modelatt as $key => $value) {
				if ($value['inputtype'] == 'select' || $value['inputtype'] == 'radio') {
					foreach ($value['attrvalue'] as $key2 => $value2) {
						if ($rsList[$value['attrname']] == $value2['name']) {
							$modelatt[$key]['attrvalue'][$key2]['selected'] = 'selected';
						}
					}
				} elseif ($value['inputtype'] == 'checkbox') {
					$expvale = explode(',', $rsList[$value['attrname']]);
					foreach ($value['attrvalue'] as $key2 => $value2) {
						if (in_array($value2['name'], $expvale)) {
							$modelatt[$key]['attrvalue'][$key2]['selected'] = 'selected';
						}
					}
				} else {
					$modelatt[$key]['attrvalue'] = $rsList[$value['attrname']];
				}
			}
		}
		$this->ectemplates->assign('modelatt', $modelatt);

		$memberpuv = $this->get_member_purview_array($rsList['mcid']);
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);

		$this->ectemplates->assign('defaultinput', $this->CON);
		$this->ectemplates->assign('memread', $rsList);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('isclose', $isclose);
		$this->ectemplates->display('member/member_edit');
	}

	function onmembersave() {
		parent::start_template();
		if ($this->CON['mem_isucenter']) {
			require admin_ROOT . 'public/uc_client/client.php';
		}
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$username = $this->fun->accept('username', 'P');
		$email = $this->fun->accept('email', 'P');
		$question = $this->fun->accept('question', 'P');
		$answer = $this->fun->accept('answer', 'P');
		$mcid = $this->fun->accept('mcid', 'P');
		$mcid = empty($mcid) ? 1 : $mcid;
		$alias = $this->fun->accept('alias', 'P');
		$sex = $this->fun->accept('sex', 'P');
		$sex = empty($sex) ? 0 : $sex;
		$tel = $this->fun->accept('tel', 'P');
		$mobile = $this->fun->accept('mobile', 'P');
		$birthday = $this->fun->accept('birthday', 'P');
		$birthday = empty($birthday) ? 0 : $this->fun->formatdate($birthday, 4);
		$country = $this->fun->accept('cityone', 'P');
		$country = empty($country) ? 0 : $country;
		$province = $this->fun->accept('citytwo', 'P');
		$province = empty($province) ? 0 : $province;
		$city = $this->fun->accept('citythree', 'P');
		$city = empty($city) ? 0 : $city;
		$district = $this->fun->accept('district', 'P');
		$district = empty($district) ? 0 : $district;
		$address = $this->fun->accept('address', 'P');
		$zipcode = $this->fun->accept('zipcode', 'P');
		$zipcode = empty($zipcode) ? 0 : $zipcode;
		$msn = $this->fun->accept('msn', 'P');
		$qq = $this->fun->accept('qq', 'P');
		$qq = empty($qq) ? 0 : $qq;
		$integral = $this->fun->accept('integral', 'P');
		$integral = empty($integral) ? 0 : $integral;
		$memberatt = $this->fun->accept('memberatt', 'P');
		if (!preg_match("/^[^!@~`\'\"#\$\%\^&\*\(\)\+\-\{\}\[\]\|\\/\?\<\>\,\.\:\;]{2,16}$/i", $username)) {
			exit('false');
		}

		$isclass = $this->CON['mem_isclass'] ? 0 : 1;

		$modelatt = $this->get_memberatt_array($lng);

		$modelarray = array();

		$modelsysarray = array();
		if (is_array($modelatt)) {
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
				if (!$value['lockin'] && !$value['issys']) {
					$modelarray[] = $value;
				} else {
					$modelsysarray[] = $value;
				}
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

		$db_table = db_prefix . 'member';
		$db_table2 = db_prefix . 'member_value';
		$date = time();
		if ($inputclass == 'add') {
			$password = md5($this->fun->accept('password', 'P'));
			$password2 = $this->fun->accept('password', 'P');

			$db_field = 'username,password,email,question,answer,sex,birthday,country,province,city,district,alias,address,zipcode,tel,mobile,qq,msn,integral,visitcount,lastip,addtime,lasttime,mcid,isclass';
			$db_values = "'$username','$password','$email','$question','$answer',$sex,$birthday,$country,$province,$city,$district,'$alias','$address',$zipcode,'$tel','$mobile',$qq,'$msn',$integral,0,0,$date,$date,$mcid,$isclass";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$insert_id = $this->db->insert_id();

			if (!empty($userinstalldb) && !empty($userinstall)) {
				$db_field = $userinstall . 'userid';
				$db_values = $userinstalldb . $insert_id;
				$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			}

			if ($this->CON['mem_isucenter']) {
				$uid = uc_user_register($username, $password2, $email);
			}
			$this->writelog($this->lng['membermain_add_log'], $this->lng['log_extra_ok'] . ' username=' . $username);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$password = $this->fun->accept('password', 'P');
			$password_uc = $this->fun->accept('password', 'P');
			$passwordold = $this->fun->accept('passwordold', 'P');
			$password = empty($password) ? $passwordold : md5($password);
			$userid = $this->fun->accept('userid', 'P');
			$mvid = $this->fun->accept('mvid', 'P');
			$db_where = 'userid=' . $userid;
			$db_set = "password='$password',email='$email',question='$question',answer='$answer',sex=$sex,birthday=$birthday,country=$country,province=$province,city=$city,district=$district,alias='$alias',address='$address',zipcode=$zipcode,tel='$tel',mobile='$mobile',qq=$qq,msn='$msn',mcid=$mcid,integral=$integral";
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
			if ($this->CON['mem_isucenter'] && !empty($$password_uc)) {
				$data = uc_get_user($username);
				if ($data) {
					list($uid2, $username2, $email2) = $data;
					if ($email == $email2) {
						uc_user_edit($username, $password_uc, $password_uc, $email, 1);
					}
				}
			}
			$this->writelog($this->lng['membermain_edit_log'], $this->lng['log_extra_ok'] . ' username=' . $username . ' userid=' . $userid);
			exit('true');
		}
	}

	function onpasswordrest() {
		require admin_ROOT . adminfile . '/include/skintitle/skintitle_member.php';
		require admin_ROOT . '/public/uc_client/client.php';
		require admin_ROOT . adminfile . '/include/inc_member.php';
		parent::start_template();
		$this->load('dbuser', 'inc', 1);
		$db_table = db_prefix . 'member';
		$id = $this->accept('id', 'R');
		$username = $this->accept('username', 'R');
		$db_where = "id=$id";
		$newpassword = md5(888888);
		$db_set = "password='$newpassword'";

		if ($MEM['ucmemberclass']) {
			$datalist = uc_get_user($username);
			if ($datalist) {
				list($uid2, $username2, $email2) = $datalist;
				uc_user_edit($username, 888888, 888888, $email2, 1);
			}
		}
		$this->dbuser->db_update($db_table, $db_set, $db_where);
		$this->writelog($ST['TITLE_PASSWORD_LOGTITLE'], $ST['TITLE_LOG_OK'] . ' id=' . $id);
		exit('true');
	}

	function onmemberdel() {
		if ($this->CON['mem_isucenter']) {
			require admin_ROOT . 'public/uc_client/client.php';
		}
		$db_table = db_prefix . 'member';
		$db_table2 = db_prefix . 'member_value';
		$selectinfoid = $this->fun->accept('memberselectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "userid=$infoarray[$i]";

			if ($this->CON['mem_isucenter']) {
				$username = $this->get_member(null, $infoarray[$i], 'username');
				$data = uc_get_user($username);

				if ($data) {
					$delid = uc_user_delete($data[0]);
				}
			}
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
			$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['membermain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'member';
		$selectinfoid = $this->fun->accept('memberselectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "userid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['membermain_setting_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function oncheckmemberuser() {
		$username = $this->fun->accept('username', 'R');
		$mem_lock = $this->CON['mem_lock'];
		if (!empty($mem_lock)) {
			$mem_lockarray = explode(',', $mem_lock);
			if (in_array($username, $mem_lockarray)) {
				exit('false');
			}
		}
		$db_table = db_prefix . 'member';
		$db_where = " WHERE username='$username'";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			$exportAjax = 'false';
		} else {
			$exportAjax = 'true';
		}
		exit($exportAjax);
	}

	function checkdid($did, $dbname) {
		$db_table = db_prefix . $dbname;
		$db_where = " WHERE userid='$did'";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			return true;
		} else {
			return false;
		}
	}

	function oncheckusername() {
		$username = $this->fun->accept('username', 'R');
		if (empty($username)) {
			exit('{"postvlue":"false"}');
		}
		$info = $this->get_member($username);
		if (!is_array($info)) {
			exit('{"postvlue":"false"}');
		}

		$str = '{';
		$str.= '"postvlue":"true","alias":"' . $info['alias'] . '",';
		$str.= '"userid":"' . $info['userid'] . '",';
		$str.= '"tel":"' . $info['tel'] . '",';
		$str.= '"mobile":"' . $info['mobile'] . '",';
		$str.= '"email":"' . $info['email'] . '",';
		$str.= '"country":"' . $info['country'] . '",';
		$str.= '"province":"' . $info['province'] . '",';
		$str.= '"city":"' . $info['city'] . '",';
		$str.= '"district":"' . $info['district'] . '",';
		$str.= '"address":"' . $info['address'] . '",';
		$str.= '"zipcode":"' . $info['zipcode'] . '"';
		$str.= '}';
		exit($str);
	}

}

?>