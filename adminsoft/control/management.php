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

	function onhome() {
		parent::start_template();

		$db_table = db_prefix . 'admin_member';
		$db_where = "username='$this->esp_username'";
		$rsMember = $this->db->fetch_first('SELECT id,username,password,name,sex,intotime,intime,outtime,ipadd,hit,powergroup,inputclassid,isclass FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('username', $rsMember['username']);
		$this->ectemplates->assign('name', $rsMember['name']);
		if ($rsMember['sex'] == 1) {
			$rsMember['sextype'] = $this->lng['select_sex_1'];
		} else {
			$rsMember['sextype'] = $this->lng['select_sex_0'];
		}


		$db_table = db_prefix . 'admin_powergroup';
		if (empty($rsMember['powergroup']) && empty($rsMember['username'])) {
			exit('Cookie err');
		}
		$db_where = 'id=' . $rsMember['powergroup'];

		$rsPower = $this->db->fetch_first('SELECT id,powername,powerlist,delclass FROM ' . $db_table . ' WHERE ' . $db_where);

		$serverinfo['phpinfo'] = PHP_OS . ' / PHP v' . PHP_VERSION;
		$serverinfo['getprc'] = get_magic_quotes_gpc() ? 'ON' : 'OFF';
		$serverinfo['upinfo'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '<font color="red">' . $this->lng['management_login_phpinfo07'] . '</font>';
		$serverinfo['gdver'] = GD_VERSION;
		$serverinfo['register'] = @ini_get('register_globals') ? 'ON' : 'OFF';
		$serverinfo['safemode'] = @ini_get('safe_mode') ? 'ON' : 'OFF';
		$serverinfo['sqlver'] = mysql_get_server_info();
		$serverinfo['gzip'] = strstr($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip") ? 'ON' : 'OFF';

		$db_table = db_prefix . 'lng';
		$db_where = "isopen=1 ORDER BY pid DESC,id DESC";
		$sql = ('SELECT id,lngtitle,lng FROM ' . $db_table . ' WHERE ' . $db_where);
		$rs = $this->db->query($sql);
		while ($rsLanlist = $this->db->fetch_assoc($rs)) {
			$lngarray[] = $rsLanlist;
		}

		$db_table = db_prefix . 'menulink';
		$db_where = "ismenu=1 ORDER BY topmlid";
		$sql = ('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$rs = $this->db->query($sql);
		while ($rsMenu = $this->db->fetch_assoc($rs)) {
			if (!in_array($rsMenu['loadfun'], $this->esp_powerlist)) {
				$menubotton[] = $rsMenu;
			}
		}
		$outstr = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">

		<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>' . $this->CON['sitename'] . '</title>
		<link href="templates/css/baselist.css" rel="stylesheet" type="text/css" />
		<link href="templates/css/all.css" rel="stylesheet" type="text/css" />
		<link href="templates/css/formdiv.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/control.js"></script>
		<script type="text/javascript" src="js/form.js"></script>
		<script type="text/javascript" src="js/pngfix.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){sdmenuvol();});

			function locationout(){
				window.location.replace(\'index.php?archive=adminuser&action=loingout\');
			}

			function sizewindow(){
				if ($.browser.version==6.0){
					var h=document.body.clientHeight;
				}else{
					var h = $(window).height();
				}
				$(\'.managebottonadd\').css({height:h});
			}

			var resizewindow= null;

			window.onresize = function(){
				var h = $(window).height();
				if(resizewindow!=h){
					sizewindow();
					resizewindow=h;
				}
			}
			document.oncontextmenu=new Function(\'event.returnValue=false;\');
			document.onselectstart=new Function(\'event.returnValue=false;\');
		</script>
		</head>

		<body>
		<div id="mainbodybottonauto" class="managebottonadd">
			<div class="maindobycontent">
				<div id="softmessage"></div>
				<div class="menssageadmin">
					<span class="fontsize14">' . $this->fun->get_timemessage(time()) . '<span class="padding-left5 strong">' . $rsMember['username'] . '（' . $rsMember['name'] . '）</span><span class="padding-left5">' . $this->lng['management_login_welcomtitle'] . '</span> <span class="padding-left5">' . $this->lng['management_login_versiontitle'] . '：' . db_version . '</span></span>
				</div>
				<div class="loginmessage">
					<div class="logincenterdiv">
						<div class="volmessage">
							<span class="padding-left5 colorgorningage" id="softkyemessage">' . $this->lng['management_login_vol'] . $this->lng['management_login_vol_messvol_mess'] . '</span>
						</div>
						<table class="logincenterdivtable">
							<tr class="trstyle1">
								<td class="trtitle01">' . $this->lng['management_login_nowlogininfotitle02'] . '：</td>
								<td class="trtitle02 colorgorning3 fontdec">' . long2ip($rsMember['ipadd']) . '</td>
								<td class="trtitle01">' . $this->lng['management_login_nowlogininfotitle01'] . '：</td>
								<td class="trtitle02 colorgorning3 fontdec">' . $rsMember['hit'] . '</td>
								<td class="trtitle01">' . $this->lng['management_login_xtjetitle01'] . '：</td>
								<td class="trtitle02 colorgorning3">' . $rsPower['powername'] . '</td>
							</tr>
							<tr class="trstyle1">
								<td class="trtitle01">' . $this->lng['management_login_logininfotitle02'] . '：</td>
								<td class="trtitle02 colorgorning3 fontdec">' . date('Y-m-d H:i:s', $rsMember['intotime']) . '</td>
								<td class="trtitle01">' . $this->lng['management_login_logininfotitle03'] . '：</td>
								<td class="trtitle02 colorgorning3 fontdec">' . date('Y-m-d H:i:s', $rsMember['intime']) . '</td>
								<td class="trtitle01">' . $this->lng['management_login_logininfotitle04'] . '：</td>
								<td class="trtitle02 colorgorning3 fontdec">' . date('Y-m-d H:i:s', $rsMember['outtime']) . '</td>
							</tr>
							<tr class="trstyle1">
								<td class="trtitle01">' . $this->lng['management_login_phpinfo01'] . '</td>
								<td class="trtitle02 colorgorning3 fontdec">' . $serverinfo['phpinfo'] . '</td>
								<td class="trtitle01">' . $this->lng['management_login_phpinfo08'] . '</td>
								<td class="trtitle02 colorgorning3 fontdec">' . $serverinfo['sqlver'] . '</td>
								<td class="trtitle01">' . $this->lng['management_login_phpinfo02'] . '</td>
								<td class="trtitle02 colorgorning3">' . $serverinfo['gdver'] . '</td>
							</tr>
							<tr class="trstyle1">
								<td class="trtitle01">' . $this->lng['management_login_phpinfo03'] . '</td>
								<td class="trtitle02 colorgorning3 fontdec">' . $serverinfo['safemode'] . '</td>
								<td class="trtitle01">' . $this->lng['management_login_phpinfo04'] . '</td>
								<td class="trtitle02 colorgorning3 fontdec">' . $serverinfo['register'] . '</td>
								<td class="trtitle01">' . $this->lng['management_login_phpinfo05'] . '</td>
								<td class="trtitle02 colorgorning3 fontdec">' . $serverinfo['getprc'] . '</td>
							</tr>
							<tr class="trstyle1">
								<td class="trtitle01">' . $this->lng['management_login_phpinfo09'] . '</td>
								<td class="trtitle02 colorgorning3 fontdec">' . $serverinfo['gzip'] . '</td>
								<td class="trtitle01">' . $this->lng['management_login_phpinfo06'] . '</td>
								<td class="trtitle02 colorgorning3 fontdec">' . $serverinfo['upinfo'] . '</td>
								<td class="trtitle01">' . $this->lng['management_login_xtjetitle03'] . '：</td>
								<td class="trtitle02 colorgorning3 fontdec">
							';
		foreach ($lngarray as $key => $value) {
			$outstr.=$value['lngtitle'] . ' ';
		}
		$outstr.='</td></tr></table></div></div><table style="width: 100%"><tr><td valign="top" style="padding-top: 30px;"><table style="width: 100%"><tr><td><div class="formdiv"><ul class="orderbottonlist" class="style:100%;">';
		foreach ($menubotton as $key => $value) {
			$outstr.= '<li><a class="' . $value['classname'] . '" target="_top" title="' . $value['menuname'] . '" href="' . $value['linkurl'] . '&menuid=' . $value['topmlid'] . '"></a></li>';
		}
		$outstr.='</ul></div></td></tr></table></td></tr></table></div></div><div id="loadingmessage"></div></body></html>';
		exit($outstr);







	}

	function onpassword() {
		parent::start_template();
		$db_table = db_prefix . 'admin_member';
		$db_where = 'id=' . $this->esp_adminuserid . ' and username=\'' . $this->esp_username . '\' and isclass=1';
		$rsMember = $this->db->fetch_first('SELECT id,username,password,name,sex,outtime,ipadd FROM ' . $db_table . ' WHERE ' . $db_where);

		$digheight = $this->fun->accept('digheight', 'R');
		$this->ectemplates->assign('digheight', $digheight);
		$this->ectemplates->assign('memberinfo', $rsMember);
		$this->ectemplates->display('admin/admin_password');
	}

	function oneditpassword() {
		parent::start_template();
		$db_table = db_prefix . 'admin_member';
		$password1 = md5($this->fun->accept('password1', 'P'));
		$passwordlog = $this->fun->accept('password1', 'P');
		$password = md5($this->fun->accept('password', 'P'));
		$name = $this->fun->accept('name', 'P');
		$sex = $this->fun->accept('sex', 'P');
		$db_where = 'id=' . $this->esp_adminuserid . ' and username=\'' . $this->esp_username . '\' and password=\'' . $password1 . '\' and isclass=1';
		$rsMember = $this->db->fetch_first('SELECT id FROM ' . $db_table . ' WHERE ' . $db_where);
		if (!$rsMember) {
			$errconter = $this->lng['management_password_password_error'];
			$this->writelog($this->lng['management_password_log'], $this->lng['log_extra_no'] . ' user=' . $this->esp_username . ' password=' . $passwordlog);
		} else {
			$db_set = "password='$password',name='$name',sex=$sex";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['management_password_log'], $this->lng['log_extra_ok']);
			$this->calldialogmessage($this->lng['management_password_message'], $this->lng['message_botton'], '', 0, 1, 'locationout');
		}
		$db_where = 'id=' . $this->esp_adminuserid . ' and username=\'' . $this->esp_username . '\' and isclass=1';
		$rsMember = $this->db->fetch_first('SELECT id,username,password,name,sex,outtime,ipadd FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('memberinfo', $rsMember);
		$this->ectemplates->assign('errconter', $errconter);
		$this->ectemplates->display('admin/admin_password');
	}

	function ontab() {
		parent::start_template();
		$loadfun = $this->fun->accept('loadfun', 'G');
		if (empty($loadfun)) {
			exit('err');
		}
		$lng = $this->fun->accept('lng', 'G');
		$mid = $this->fun->accept('mid', 'G');
		$tid = $this->fun->accept('tid', 'G');
		$mcid = $this->fun->accept('mcid', 'G');
		$atid = $this->fun->accept('atid', 'G');
		$menuname_title = $this->fun->accept('menuname_title', 'G');
		$groupid = $this->fun->accept('groupid', 'G');

		$out = $this->fun->accept('out', 'G');
		$loadfun = $this->fun->accept('loadfun', 'G');
		include_once admin_ROOT . adminfile . '/include/command_list.php';

		$tab['url'] = $CONLIST[$loadfun]['tabloadurl'];

		$tab['title'] = $menuname_title ? $menuname_title : $CONLIST[$loadfun]['tabloadtitle'];

		$tabarray = $mid . '-' . $tid . '-' . $mcid . '-' . $atid;
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('tid', $tid);
		$this->ectemplates->assign('atid', $atid);

		$this->ectemplates->assign('mcid', $mcid);
		$this->ectemplates->assign('loadfun', $loadfun);
		$this->ectemplates->assign('tabarray', $tabarray);

		if ($out == 'tabcenter') {
			$out = 'admin/admin_tab_center';
		} elseif ($out == 'tabeditor') {
			$out = 'admin/admin_tab_editor';
		}
		$fileout = empty($out) ? 'admin/admin_tab' : $out;
		$this->ectemplates->display($fileout);
	}

	function onlist() {
		parent::start_template();
		$listfunction = $this->fun->accept('listfunction', 'G');
		$mid = $this->fun->accept('mid', 'G');
		$tid = $this->fun->accept('tid', 'G');
		$sid = $this->fun->accept('sid', 'G');
		$isclass = $this->fun->accept('isclass', 'G');
		$pagetype = $this->fun->accept('pagetype', 'G');
		$mcid = $this->fun->accept('mcid', 'G');
		$fgid = $this->fun->accept('fgid', 'G');
		$atid = $this->fun->accept('atid', 'G');
		$did = $this->fun->accept('did', 'G');
		$btid = $this->fun->accept('btid', 'G');
		$upbid = $this->fun->accept('upbid', 'G');
		$amid = $this->fun->accept('amid', 'G');
		$mlvid = $this->fun->accept('mlvid', 'G');
		$logusername = $this->fun->accept('logusername', 'G');
		if (empty($listfunction)) {
			exit('err');
		}
		include_once admin_ROOT . adminfile . '/include/command_list.php';

		$tabarray = $mid . '-' . $tid . '-' . $fgid . '-' . $atid . '-' . $did;

		$cookpage = $this->fun->accept($CONLIST[$listfunction]['pagecoock'], 'C');
		$nowpage = empty($cookpage) ? 0 : $cookpage;
		$this->ectemplates->assign('nowpage', $nowpage);
		$this->ectemplates->assign('loadurl', $CONLIST[$listfunction]['loadurl']);

		$this->ectemplates->assign('MaxPerPage', $this->CON['max_list']);

		$this->ectemplates->assign('MaxHit', $this->CON['max_page']);
		$this->ectemplates->assign('listtype', $listtype);
		$this->ectemplates->assign('listfunction', $listfunction);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('tid', $tid);
		$this->ectemplates->assign('sid', $sid);
		$this->ectemplates->assign('fgid', $fgid);
		$this->ectemplates->assign('did', $did);
		$this->ectemplates->assign('atid', $atid);
		$this->ectemplates->assign('mcid', $mcid);
		$this->ectemplates->assign('tabarray', $tabarray);
		$this->ectemplates->assign('isclass', $isclass);

		$fileout = empty($pagetype) ? 'admin_tab_list' : $pagetype;
		$this->ectemplates->display('admin/' . $fileout);
	}

	function onloglist() {
		parent::start_template();

		$MinPageid = intval($this->fun->accept('MinPageid', 'R'));
		$loguser = $this->fun->accept('loguser', 'R');
		$logusername = $this->fun->accept('logusername', 'R');

		$counttype = $this->fun->accept('countnum', 'R');

		$page_id = intval($this->fun->accept('page_id', 'R'));
		$MaxPerPage = intval($this->fun->accept('MaxPerPage', 'R'));
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}

		$db_table = db_prefix . 'logs';
		if (!empty($loguser) && empty($logusername)) {
			$db_where = ' WHERE username=\'' . $loguser . '\'';
		} elseif (!empty($logusername)) {
			$db_where = ' WHERE username=\'' . $logusername . '\'';
		}
		if (!empty($counttype)) {

			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT id,username,onlineip,addtime,actions,remarks FROM ' . $db_table . $db_where . ' ORDER BY id DESC LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}

		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->display('admin/admin_log_list');
	}

	function onmangerlist() {
		parent::start_template();

		$MinPageid = intval($this->fun->accept('MinPageid', 'R'));
		$loguser = $this->fun->accept('loguser', 'R');

		$page_id = intval($this->fun->accept('page_id', 'R'));

		$countnum = $this->fun->accept('countnum', 'R');
		$MaxPerPage = intval($this->fun->accept('MaxPerPage', 'R'));
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$wheretext = null;
		$isclass = intval($this->fun->accept('isclass', 'R'));
		$inputclassid = intval($this->fun->accept('inputclassid', 'R'));
		$powergroup = intval($this->fun->accept('powergroup', 'R'));
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$wheretext.=' AND isclass=' . $isclass;
		}
		if (!empty($inputclassid)) {
			if ($inputclassid == 2) $inputclassid = 0;
			$wheretext.=' AND inputclassid=' . $inputclassid;
		}
		if (!empty($powergroup)) {
			$wheretext.=' AND powergroup=' . $powergroup;
		}
		$db_where = " WHERE id>0" . $wheretext;
		$db_table = db_prefix . 'admin_member';
		if (!empty($countnum)) {

			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT id,username,password,name,sex,intotime,intime,outtime,ipadd,hit,powergroup,inputclassid,isclass FROM ' . $db_table . $db_where . ' ORDER BY id DESC LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rsList['powername'] = $this->get_power_view($rsList['powergroup'], 'powername');
			$array[] = $rsList;
		}

		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('admin/admin_manager_list');
	}

	function onload() {
		$this->start_template();

		$this->ectemplates->assign('calltitle', $calltitle);

		$this->ectemplates->assign('bottonName', $bottonName);
		$this->ectemplates->display('admin/admin_load');
	}

	function onbannload() {
		$this->start_template();
		echo 'sdafsaf';
	}

	function onmanageradd() {
		parent::start_template();

		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$powergrouplist = $this->get_power_array();
		$this->ectemplates->assign('powerlist', $powergrouplist['list']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('admin/admin_manager_add');
	}

	function onmanageedit() {
		parent::start_template();
		$db_table = db_prefix . 'admin_member';
		$id = intval($this->fun->accept('id', 'G'));
		$copytype = $this->fun->accept('copytype', 'G');
		$db_where = 'id=' . $id;
		$rsMember = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$powergrouplist = $this->get_power_array($rsMember['powergroup']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('memberinfo', $rsMember);
		$this->ectemplates->assign('copytype', $copytype);
		$this->ectemplates->assign('powerlist', $powergrouplist['list']);
		$this->ectemplates->display('admin/admin_manager_edit');
	}

	function onmanagesava() {
		$db_table = db_prefix . 'admin_member';
		$inputclass = $this->fun->accept('inputclass', 'P');
		$username = $this->fun->accept('username', 'R');
		if (!preg_match("/^[a-zA-Z]{1}[a-zA-Z0-9]{4,19}$/i", $username)) {
			exit('false');
		}
		$password = md5($this->fun->accept('password', 'P'));
		$passwordlog = $this->fun->accept('password', 'P');
		$name = $this->fun->accept('name', 'P');
		$sex = $this->fun->accept('sex', 'P');
		$powergroup = intval($this->fun->accept('powergroup', 'P'));
		$inputclassid = intval($this->fun->accept('inputclassid', 'P'));
		if ($inputclass == 'add') {
			$date = time();
			$ipadd = $this->fun->ip($_SERVER['REMOTE_ADDR']);
			$db_field = 'username,password,name,sex,intotime,intime,outtime,ipadd,hit,powergroup,inputclassid,isclass';
			$db_values = "'$username','$password','$name',$sex,$date,0,0,$ipadd,0,$powergroup,$inputclassid,1";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['mangerlist_add_log'], $this->lng['log_extra_ok'] . ' user=' . $username);
			exit('true');
		}

		if ($inputclass == 'edit') {
			$id = $this->fun->accept('id', 'P');
			$db_where = "id=$id";
			$db_set = "name='$name',sex=$sex,powergroup=$powergroup,inputclassid=$inputclassid";
			if (!empty($passwordlog)) {
				$db_set.=",password='$password'";
			}
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['mangerlist_edit_log'], $this->lng['log_extra_ok'] . ' user=' . $username);
			exit('true');
		}
	}

	function onusercheck() {
		$db_table = db_prefix . 'admin_member';
		$username = $this->fun->accept('username', 'R');
		if (!preg_match("/^[a-zA-Z]{1}[a-zA-Z0-9]{4,16}$/i", $username)) {
			exit('false');
		}
		$db_where = "username='$username'";
		$rs = $this->db->query('SELECT username FROM ' . $db_table . ' WHERE ' . $db_where);
		$rsList = $this->db->fetch_assoc($rs);
		if (!$rsList) {
			exit('true');
		} else {
			exit('false');
		}
	}

	function ondelmanage() {
		$db_table = db_prefix . 'admin_member';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "id=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['mangerlist_del_log'], $this->lng['log_extra_ok'] . ' userid=' . $selectinfoid);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'admin_member';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');

		$value = $this->fun->accept('value', 'P');

		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "id IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['mangerlist_isclass_log'], $this->lng['log_extra_ok'] . ' userid=' . $selectinfoid);
		exit('true');
	}

	function onsysinfo() {
		parent::start_template();

		$templatesdirsize = $this->fun->format_size($this->fun->dirsize(admin_ROOT . '/cache/admin/templates'));

		$cachedirsize = $this->fun->format_size($this->fun->dirsize(admin_ROOT . '/cache/admin/cache'));

		$backupdirsize = $this->fun->format_size($this->fun->dirsize(admin_ROOT . '/public/backup/'));

		$upfiledirsize = $this->fun->format_size($this->fun->dirsize("../upfile/"));

		$serverinfo = PHP_OS . ' / PHP v' . PHP_VERSION;
		$dbversion = $this->db->version();
		$fileupload = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '<font color="red">' . $lang['no'] . '</font>';
		$query = $tables = $this->db->fetch_all("SHOW TABLE STATUS LIKE '$tablepre%'");
		foreach ($tables as $table) {
			$dbsize+=$table['Data_length'] + $table['Index_length'];
		}

		$serverip = $_SERVER['SERVER_ADDR'];

		$web_server = $_SERVER['SERVER_SOFTWARE'];
		$this->ectemplates->assign('lngselect', $this->lngselect($lng));
		$this->ectemplates->assign('templatesdirsize', $templatesdirsize);
		$this->ectemplates->assign('cachedirsize', $cachedirsize);
		$this->ectemplates->assign('backupdirsize', $backupdirsize);
		$this->ectemplates->assign('upfiledirsize', $upfiledirsize);
		$this->ectemplates->assign('getGPC', get_magic_quotes_gpc());
		$this->ectemplates->assign('md5link', md5(time()));

		$this->ectemplates->assign('serverinfo', $serverinfo);
		$this->ectemplates->assign('serverip', $serverip);
		$this->ectemplates->assign('web_server', $web_server);

		$this->ectemplates->assign('dbversion', $dbversion);

		$this->ectemplates->assign('fileupload', $fileupload);

		$this->ectemplates->assign('dbsize', $this->fun->format_size($dbsize));
		$this->ectemplates->assign('skintitle', $this->lng);
		$this->ectemplates->display('admin/admin_sysinfo');
	}

	function onlinkecisp() {
		parent::start_template();
		$getnetval = convert_uudecode($this->CON['getnetval']);
		$xmlfile = $getnetval . 'sitemap/rss_news.xml';

		$inforss = @simplexml_load_file($xmlfile, 'SimpleXMLElement', LIBXML_NOCDATA);

		$this->fun->objectToArray($inforss);

		$outrssinfo = $inforss['channel']['item'];
		$this->ectemplates->assign('array', $outrssinfo);
		$this->ectemplates->assign('infoclass', 'news');
		$this->ectemplates->display('admin/admin_xmlinfo');
	}

	function onverecisp() {
		parent::start_template();
		$getnetval = convert_uudecode($this->CON['getnetval']);
		$xmlfile = $getnetval . 'sitemap/rss_news.xml';

		$inforss = @simplexml_load_file($xmlfile, 'SimpleXMLElement', LIBXML_NOCDATA);
		$this->fun->objectToArray($inforss);
		$this->ectemplates->assign('valinfo', $inforss['channel']['val']);
		$this->ectemplates->assign('softmessage', $inforss['channel']['softmessage']);
		$this->ectemplates->assign('softurl', $inforss['channel']['softurl']);
		$this->ectemplates->assign('infoclass', 'val');
		$this->ectemplates->display('admin/admin_xmlinfo');
	}

	function onclearlog() {
		parent::start_template();
		$execute = $this->fun->accept('execute', 'R');
		if ($execute == 1) {
			$deltype = $this->fun->accept('deltype', 'R');
			$username = $this->fun->accept('username', 'R');
			$db_table = db_prefix . 'logs';
			if (!$deltype) {
				$db_where = " WHERE username='$username'";
			}
			$this->db->query('DELETE FROM ' . $db_table . $db_where);
			$this->writelog($this->lng['clear_log_del_log'], $this->lng['log_extra_ok']);
			exit('true');
		}

		$digheight = $this->fun->accept('digheight', 'R');
		$this->ectemplates->assign('digheight', $digheight);
		$this->ectemplates->display('admin/admin_clear_log');
	}

	function onclearcache() {
		parent::start_template();
		$execute = $this->fun->accept('execute', 'P');
		if (!empty($execute)) {
			if (!$this->CON['is_caching']) {
				exit('close');
			}
			$retrun = $this->dbcache->clearcache();
			if ($retrun) {
				exit('true');
			} else {
				exit('false');
			}
		}
		$digheight = $this->fun->accept('digheight', 'R');
		$this->ectemplates->assign('digheight', $digheight);
		$this->ectemplates->display('admin/admin_manager_clearcache');
	}

	function onfilecheck() {
		parent::start_template();
		$execute = $this->fun->accept('execute', 'R');

		$file_htmldir = admin_ROOT . $this->CON['file_htmldir'];

		$file_sitemapdir = admin_ROOT . $this->CON['file_sitemapdir'];

		$file_sqlbakdir = admin_ROOT . $this->CON['file_sqlbakdir'];

		$upfile_dir = admin_ROOT . $this->CON['upfile_dir'];

		$cache_dir = admin_ROOT . "datacache/";
		$cache_dirlist = array(
		    0 => array('dir' => 'datacache/dbcache/', 'key' => '1'),
		    1 => array('dir' => 'datacache/admin/cache/', 'key' => '1'),
		    2 => array('dir' => 'datacache/admin/templates/', 'key' => '1'),
		    3 => array('dir' => 'datacache/main/cache/', 'key' => '1'),
		    4 => array('dir' => 'datacache/pic/', 'key' => '1'),
		    5 => array('dir' => 'datacache/main/templates/', 'key' => '1')
		);
		if ($execute == 1) {
			$str = '{';
			if (!$this->fun->filemode($file_htmldir)) {
				$str .='"htmldir":"false",';
			} else {
				$str .='"htmldir":"true",';
			}
			if (!$this->fun->filemode($file_sitemapdir)) {
				$str .='"sitemapdir":"false",';
			} else {
				$str .='"sitemapdir":"true",';
			}
			if (!$this->fun->filemode($file_sqlbakdir)) {
				$str .='"sqlbakdir":"false",';
			} else {
				$str .='"sqlbakdir":"true",';
			}
			if (!$this->fun->filemode($upfile_dir)) {
				$str .='"upfiledir":"false",';
			} else {
				$str .='"upfiledir":"true",';
			}
			$filestr = '';
			foreach ($cache_dirlist as $key => $value) {
				if (!$this->fun->filemode(admin_ROOT . $value['dir'])) {
					$cache_dirlist[$key]['key'] = '0';
					$filestr .='0';
				} else {
					$cache_dirlist[$key]['key'] = '1';
					$filestr .='1';
				}
			}
			if ($filestr == '111111') {
				$str .='"cachedir":"true",';
			} else {
				$str .='"cachedir":"false",';
			}
			$str .='"cachedirkey":"' . $filestr . '"';
			$str.='}';
			exit($str);
		}
		$filedirlist = array(
		    'htmldir' => $this->CON['file_htmldir'],
		    'sitemapdir' => $this->CON['file_sitemapdir'],
		    'sqlbakdir' => $this->CON['file_sqlbakdir'],
		    'upfiledir' => $this->CON['upfile_dir'],
		    'cachedir' => "/datacache/",
		);
		$digheight = $this->fun->accept('digheight', 'R');
		$this->ectemplates->assign('digheight', $digheight);
		$this->ectemplates->assign('filedirlist', $filedirlist);
		$this->ectemplates->assign('cachelist', $cache_dirlist);
		$this->ectemplates->display('admin/admin_manager_filecheck');
	}

	function onsyssetting() {
		parent::start_template();
		$db_table = db_prefix . 'config';
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$nowgroupid = $this->fun->accept('groupid', 'G');
		$nowgroupid = empty($nowgroupid) ? 1 : $nowgroupid;
		for ($i = 0; $i < 6; $i++) {
			$array = array();
			$groupid = $i + 1;
			$db_where = " WHERE groupid=$groupid";
			$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid,groupid';
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				if ($rsList['valtype'] == 'bool') {
					$bottonname = array();
					$bottonname = explode(',', $rsList['bottonname']);
					$rsList['b1'] = $bottonname[0];
					$rsList['b2'] = $bottonname[1];
				} elseif ($rsList['valtype'] == 'selectkey') {
					$bottonname = array();
					$bottonname = explode(',', $rsList['bottonname']);
					$newarray = array();
					foreach ($bottonname as $key => $value) {
						$bottonvalue = explode('|', $value);
						$newarray[$key]['selected'] = $rsList['value'] == $bottonvalue[0] ? 'selected' : '';
						$newarray[$key]['key'] = $bottonvalue[0];
						$newarray[$key]['name'] = $bottonvalue[1];
					}
					$rsList['selectkey'] = $newarray;
				}
				$array[] = $rsList;
			}
			$setingarray[$i]['key'] = $groupid;
			$setingarray[$i]['list'] = $array;
		}

		$lngarray = $this->get_lng_array($this->CON['home_lng'], 1);

		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('lngarray', $lngarray['list']);
		$this->ectemplates->assign('groupid', $nowgroupid);
		$this->ectemplates->assign('array', $setingarray);
		$this->ectemplates->display('admin/admin_manager_setting');
	}

	function onsetsave() {
		$db_table = db_prefix . 'config';
		$commandfile = admin_ROOT . 'datacache/command.php';
		if (!$this->fun->filemode($commandfile)) {
			exit('false');
		}
		$sql = 'SELECT id,valname,value FROM ' . $db_table . ' WHERE groupid<7 AND isline=0 ORDER BY groupid';
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$db_set = "value='" . $this->fun->accept($rsList['valname'], 'P') . "'";
			$db_where = 'id=' . $rsList['id'];
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		}
		$this->systemfile(true);
		$this->writelog($this->lng['setting_edit_log'], $this->lng['log_extra_ok']);
		exit('true');
	}

	function onupcerfile() {
		parent::start_template();

		$digheight = $this->fun->accept('digheight', 'R');
		$this->ectemplates->assign('digheight', $digheight);
		$this->ectemplates->display('admin/admin_upfile');
	}

	function oncerfilecheck() {
		parent::start_template();

		$filename = $_FILES['cerupfilepath']['name'];



		$filetmpname = $_FILES['cerupfilepath']['tmp_name'];




		$digheight = $this->fun->accept('digheight', 'R');
		$isupfiletrue = 'true';
		if (empty($filename) || empty($filetmpname)) {
			$isupfiletrue = 'false';
		}

		if (!file_exists($filetmpname)) {
			$isupfiletrue = 'false';
		}
		$datacontent = file_get_contents($filetmpname);
		if (empty($datacontent)) {
			$isupfiletrue = 'false';
		}
		if ($isupfiletrue != 'false') {
			$db_table = db_prefix . 'config';
			$db_where = "valname='cer_key'";
			$db_set = "value='$datacontent'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$db_where = "valname='cer_file'";
			$db_set = "value='111111'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->systemfile(true);
			$this->calldialogmessage($this->lng['management_upfile_text_ok_js'], $this->lng['management_upfile_text_exit_bottonok'], '', 0, 1, 'locationout');
		}
		$this->ectemplates->assign('digheight', $digheight);
		$this->ectemplates->assign('isupfiletrue', $isupfiletrue);
		$this->ectemplates->display('admin/admin_upfile');
	}

}

?>