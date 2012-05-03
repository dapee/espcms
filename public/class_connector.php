<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class connector {

	function softbase($admin_purview = false) {

		header("Content-Type: text/html; charset=utf-8");
		$this->dbmysql();
		$this->commandinc();
		$this->systemfile();
		$this->cachedb();
		if ($admin_purview) {

			$this->admin_purview();

			$this->sitelng = $this->getlng();

			$action = $this->fun->accept('action', 'R');
			if (in_array($action, $this->esp_powerlist) && !in_array('all', $this->esp_powerlist)) {
				exit('Permissions errors');
			}
		}

		if ($this->CON['is_gzip'] == 1 && !function_exists('ob_gzhandler')) {
			ob_start('ob_gzhandler');
		} else {
			ob_start();
		}

		if ($runpage && $this->CON['is_close']) {
			exit($this->CON['close_content']);
		}

		if (!admin_FROM) {
			include admin_ROOT . adminfile . '/include/admin_language_' . db_lan . '.php';
			$this->lng = $ST;
			unset($ST);
		} else {
			$lngpack = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
			if ($this->creat_lanpack($lngpack)) {
				include admin_ROOT . 'datacache/' . $lngpack . '_pack.php';
			}
			$this->lng = $LANPACK;
			$runpage = true;
		}
	}

	function dbmysql() {
		include_once admin_ROOT . '/public/class_dbmysql.php';
		$this->db = new dbmysql();
		$this->db->connect(db_host, db_user, db_pw, db_name, db_charset, db_link);
	}


	function creat_lanpack($lng = '', $trueclass = false) {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$lanpackfile = admin_ROOT . 'datacache/' . $lng . '_pack.php';
		if (!is_file($lanpackfile) || $trueclass) {

			$sConfig = "<?php\n";
			$sConfig = $sConfig . '// uptime:' . date('Y-m-d H:i:s', time()) . "\n";
			$sConfig = $sConfig . "// ECISP.CN \n";
			$sConfig = $sConfig . "\$LANPACK=Array(\n";
			$db_table = db_prefix . 'lngpack';
			$sql = "SELECT * FROM $db_table WHERE lng='$lng' ORDER BY lpid";
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$keycode = $rsList['keycode'];
				$langstr = addslashes($rsList['langstr']);
				$title = $rsList['title'];
				$sConfig = $sConfig . "\x20\x20\x20\x20 //$title\n";
				$sConfig = $sConfig . "\x20\x20\x20\x20 '" . $keycode . '\'=>\'' . $langstr . "',\n";
			}
			$sConfig = $sConfig . ")\n";
			$sConfig = $sConfig . '?' . '>';
			if (!$this->fun->filewrite($lanpackfile, $sConfig)) {
				exit('System File Error!');
			}
		}
		return true;
	}

	function getlng() {
		$sitesoftlng = $this->fun->accept('sitesoftlng', 'G');
		if (empty($sitesoftlng)) {
			$lngcookie = $this->fun->accept('sitesoftlng', 'C');
			$sitesoftlng = empty($sitesoftlng) ? !empty($lngcookie) ? $lngcookie : 'cn'  : $sitesoftlng;
		} else {
			$this->fun->setcookie('sitesoftlng', $sitesoftlng);
		}
		return $sitesoftlng;
	}

	function commandinc() {
		include_once admin_ROOT . 'public/class_function.php';
		$this->fun = new functioninc();
	}

	function start_template() {
		include_once admin_ROOT . 'public/ectemplates/ectemplates_class.php';
		include admin_ROOT . 'datacache/command.php';
		$this->ectemplates = new Ectemplates();

		$this->ectemplates->tpl_dir = admin_ROOT . adminfile . '/templates/';

		$this->ectemplates->tpl_c_dir = admin_ROOT . 'datacache/admin/templates/';

		$this->ectemplates->cache_dir = admin_ROOT . 'datacache/admin/cache/';

		$this->ectemplates->dbcache_dir = admin_ROOT . 'datacache/admin/dbcache/';

		$this->ectemplates->libdir = adminfile . '/control/lib_menu.php';

		$this->ectemplates->caching = false;
		$this->ectemplates->cache_time = 60 * 60 * 24;
		$this->ectemplates->templatesfileex = '.html';
		$this->ectemplates->left_delimiter = '[%';
		$this->ectemplates->right_delimiter = '%]';
		$this->ectemplates->esp_powerlist = $this->esp_powerlist;

		$this->ectemplates->assign('ST', $this->lng);
		$this->ectemplates->assign('softtitle', $CONFIG['sitename']);
		$this->ectemplates->assign('codesoftdb', $this->CON['checkkeylist']);
		$this->ectemplates->assign('softhttp', admin_http);
		$this->ectemplates->assign('softversion', db_version);
		$this->ectemplates->assign('adminurl', admin_URL);
		$this->ectemplates->assign('admin_ClassURL', admin_ClassURL);

		$this->ectemplates->assign('order_moneytype', $CONFIG['order_moneytype']);
		$this->ectemplates->assign('refalse', $CONFIG['is_inputclose']);

		$iframename = $this->fun->accept('iframename', 'R');
		$iframeheightwindow = $this->fun->accept('iframeheightwindow', 'R');
		$this->ectemplates->assign('iframeheightwindow', $iframeheightwindow);
		$iframewidthwindow = $this->fun->accept('iframewidthwindow', 'R');
		$this->ectemplates->assign('iframewidthwindow', $iframewidthwindow);
		if (!empty($iframename)) {
			$this->ectemplates->assign('iframename', $iframename);
		}
		$jsstr = "sdmenuvol();esptabkey.buildTree();esptabkey.buildTabpanel();esptabkey.removeLoader();";
		$this->ectemplates->assign('jsstr', $jsstr);
		$jsstrlist = "$(document).ready(function(){sdmenuvol();});";
		$this->ectemplates->assign('jsstrlist', $jsstrlist);
	}



	function start_pagetemplate($lng_templates = null, $lan_pack = array()) {
		include_once admin_ROOT . 'public/ectemplates/ectemplates_class.php';
		include admin_ROOT . 'datacache/command.php';
		$this->pagetemplate = new Ectemplates();

		if (defined('admin_WAP') && admin_WAP) {

			$this->pagetemplate->tpl_dir = admin_ROOT . 'templates/';

			$this->pagetemplate->tpl_c_dir = admin_ROOT . 'datacache/main/3gwap/templates/';

			$this->pagetemplate->cache_dir = admin_ROOT . 'datacache/main/3gwap/cache/';

			$this->pagetemplate->dbcache_dir = admin_ROOT . 'datacache/dbcache/3gwap/';

			$this->pagetemplate->cache_pic = admin_ROOT . 'datacache/pic/3gwap/';

			$this->pagetemplate->templatesDIR = 'wap/';

			$this->pagetemplate->libdir = 'interface/3gwap_lib_public.php';
		} else {

			$this->pagetemplate->tpl_dir = admin_ROOT . 'templates/';

			$this->pagetemplate->tpl_c_dir = admin_ROOT . 'datacache/main/templates/';

			$this->pagetemplate->cache_dir = admin_ROOT . 'datacache/main/cache/';

			$this->pagetemplate->dbcache_dir = admin_ROOT . 'datacache/dbcache/';

			$this->pagetemplate->cache_pic = admin_ROOT . 'datacache/pic/';

			$this->pagetemplate->templatesDIR = $this->CON['default_templates'] . '/';

			$this->pagetemplate->libdir = 'interface/lib_public.php';
		}
		$this->pagetemplate->caching = false;
		$this->pagetemplate->cache_time = 86400;
		$this->pagetemplate->templatesfileex = '.' . $this->CON['templates_fileex'];
		$this->pagetemplate->left_delimiter = '{%';
		$this->pagetemplate->right_delimiter = '%}';
		$this->pagetemplate->codesoftdb = $this->checkkeylist;
		$this->pagetemplate->assign('softtitle', softtitle);
		$this->pagetemplate->assign('softversion', db_version);
		$this->pagetemplate->assign('icp', $this->CON['icpbeian']);
		$this->pagetemplate->assign('domain', $this->CON['domain']);
		$this->pagetemplate->assign('email', $this->CON['admine_mail']);

		$this->pagetemplate->assign('url', admin_URL);

		$this->pagetemplate->assign('tempdir', $this->CON['default_templates']);

		if (admin_FROM) {

			if ($this->CON['is_alonelng']) {
				$pathurl = admin_URL;
			} else {
				$pathurl = admin_ClassURL;
			}

			$this->pagetemplate->assign('pathurl', $pathurl);
			$this->pagetemplate->assign('url', admin_URL);

			$this->pagetemplate->assign('rootdir', admin_rootDIR);

			if (defined('admin_WAP') && admin_WAP) {
				$this->pagetemplate->assign('rootpath', admin_rootDIR . 'templates/wap/');
			} else {
				$this->pagetemplate->assign('rootpath', admin_rootDIR . 'templates/' . $this->CON['default_templates'] . '/');
			}
			$this->pagetemplate->assign('lng', admin_LNG);
			$this->pagetemplate->assign('lngpack', $this->lng);
			$homelink = $this->get_link('home', '', admin_LNG);

			$this->pagetemplate->assign('homelink', $homelink);

			$this->pagetemplate->assign('piclngkey', admin_LNG == 'cn' ? '' : admin_LNG);
		} else {


			$lng = ($lng_templates == 'big5') ? $this->CON['is_lancode'] : $lng_templates;

			$lngurl = $this->get_lan_view($lng, 'url');
			if ($this->CON['is_alonelng']) {
				$pathurl = empty($lngurl) ? admin_URL . $this->CON['file_htmldir'] : $lngurl . '/';
			} else {
				$pathurl = empty($lngurl) ? admin_URL . $this->CON['file_htmldir'] . $lng_templates . '/' : $lngurl . '/';
			}
			$this->pagetemplate->assign('url', admin_URL);
			$this->pagetemplate->assign('pathurl', $pathurl);
			$this->pagetemplate->assign('lng', $lng_templates);
			$this->pagetemplate->assign('lngpack', $lan_pack);
			$this->pagetemplate->assign('homelink', $this->get_link('home', '', $lng_templates));
			$this->pagetemplate->assign('mlink', $this->memberlink(array(), $lng_templates));
			$this->pagetemplate->assign('piclngkey', $lng_templates == 'cn' ? '' : $lng_templates);

			$lngpack = ($lng_templates == 'big5') ? $this->CON['is_lancode'] : $lng_templates;
			$admin_rootDIR = $lngpack . '/';

			$rootDIR = $this->CON['http_pathtype'] ? admin_URL : str_replace('http://' . admin_http, '', admin_URL);
			$this->pagetemplate->assign('rootdir', $rootDIR);

			$this->pagetemplate->assign('rootpath', $rootDIR . 'templates/' . $this->CON['default_templates'] . '/');
		}
	}

	function cachedb() {
		include_once admin_ROOT . 'public/class_cache.php';

		$dbcacheDIR = admin_ROOT . 'datacache/dbcache/';

		$dbcacheTIME = $this->CON['cache_time'];
		$this->dbcache = new cacheDB();

		$this->dbcache->cachefile = $dbcacheDIR;
		$this->dbcache->cachetime = $dbcacheTIME;
		$this->dbcache->cachefiletype = 'php';

		$this->dbcache->caching = ($this->CON['is_caching'] == 1) ? true : false;
	}




	function db_numrows_ds($db_table, $db_where, $field) {
		$resulted = $this->db->query('SELECT COUNT(DISTINCT ' . $field . ') AS num FROM ' . $db_table . $db_where);
		$resulted = $this->db->fetch_assoc($resulted);
		return $resulted['num'];
	}




	function db_numrows($db_table, $db_where) {
		$resulted = $this->db->query('SELECT COUNT(*) AS num FROM ' . $db_table . $db_where);
		$resulted = $this->db->fetch_assoc($resulted);
		return $resulted['num'];
	}



	function writelog($action, $extra = '', $inuser = null) {
		if (!$this->CON['is_log']) return false;
		$username = $this->esp_username;
		if (empty($username)) {
			$username = $inuser;
		}
		$onlineip = $this->fun->ip($_SERVER['REMOTE_ADDR']);
		$addtime = time();
		$this->db->query("INSERT INTO " . db_prefix . "logs (username,onlineip,addtime,actions,remarks) VALUES ('$username',$onlineip,$addtime,'$action','$extra')");
	}


	function admin_cookieview($keyword = false) {
		$retrunstr = array();
		$retrunstr['powerlist'] = explode('|', $this->fun->eccode($this->fun->accept('esp_powerlist', 'C'), 'DECODE', db_pscode));
		$arr_purview = explode('|', $this->fun->eccode($this->fun->accept('ecisp_admininfo', 'C'), 'DECODE', db_pscode));

		list($retrunstr['id'], $retrunstr['username'], $retrunstr['password'], $retrunstr['useragent'], $retrunstr['powerid'], $retrunstr['inputclassid'], $retrunstr['softurl']) = $arr_purview;
		return !$keyword ? $retrunstr : $retrunstr[$keyword];
	}

	function admin_purview() {
		if ($this->fun->accept('archive', 'R') == 'filemanage' && $this->fun->accept('action', 'R') == 'batupfilesave') {

			$ecisp_admininfo = $this->fun->accept('ecisp_admininfo', 'G');
			$esp_powerlist = $this->fun->accept('esp_powerlist', 'G');





			$gettype = false;
		} else {
			$ecisp_admininfo = $this->fun->accept('ecisp_admininfo', 'C');
			$esp_powerlist = $this->fun->accept('esp_powerlist', 'C');
			$gettype = true;
		}

		$arr_purview = explode('|', $this->fun->eccode($ecisp_admininfo, 'DECODE', db_pscode));

		$this->esp_powerlist = explode('|', $this->fun->eccode($esp_powerlist, 'DECODE', db_pscode));

		list($this->esp_adminuserid, $this->esp_username, $this->esp_password, $this->esp_useragent, $this->esp_powerid, $this->esp_inputclassid, $this->esp_softurl) = $arr_purview;
		if ($gettype) {
			if (empty($this->esp_username) || empty($this->esp_adminuserid) || md5(admin_AGENT) != $this->esp_useragent || md5(admin_ClassURL) != $this->esp_softurl) {
				$condition = 0;
			} else {
				$condition = 1;
			}
		} else {
			if (empty($this->esp_username) || empty($this->esp_adminuserid) || md5(admin_ClassURL) != $this->esp_softurl) {
				$condition = 0;
			} else {
				$condition = 1;
			}
		}
		if ($condition == 0) {

			if ($this->fun->accept('archive', 'R') != 'adminuser' && $this->fun->accept('action', 'R') != 'login') {
				header('location: index.php?archive=adminuser&action=login');
				exit();
			}
		} else {

			if ($condition == 1 && $this->fun->accept('point', 'R') == '' && $this->fun->accept('archive', 'R') == '' && $this->fun->accept('action', 'R') == '') {
				header('location: index.php?archive=management&action=tab&loadfun=mangercenter&out=tabcenter');
				exit();
			}
		}
	}





	function powercheck($funtionname = null, $funtionname_ex = null) {
		if (!in_array('all', $this->esp_powerlist) && (!empty($funtionname) || !empty($funtionname_ex))) {
			if (in_array($funtionname, $this->esp_powerlist)) {
				exit('Permissions errors');
			}
			if (in_array($funtionname_ex, $this->esp_powerlist)) {
				exit('Permissions errors');
			}
		} else {
			if (!in_array('all', $this->esp_powerlist)) {
				exit('Permissions errors');
			}
		}
	}


	function member_cookieview($keyword = false) {
		$retrunstr = array();
		$retrunstr['username'] = $this->fun->eccode($this->fun->accept('ecisp_member_username', 'C'), 'DECODE', db_pscode);
		$user_info = explode('|', $this->fun->eccode($this->fun->accept('ecisp_member_info', 'C'), 'DECODE', db_pscode));

		list($retrunstr['userid'], $retrunstr['alias'], $retrunstr['integral'], $retrunstr['mcid'], $retrunstr['email'], $retrunstr['lastip'], $retrunstr['ipadd'], $retrunstr['useragent'], $retrunstr['adminclassurl']) = $user_info;
		return !$keyword ? $retrunstr : $retrunstr[$keyword];
	}






	function member_purview($userrank = false, $url = null, $upurl = false) {

		$this->ec_member_username = $this->fun->eccode($this->fun->accept('ecisp_member_username', 'C'), 'DECODE', db_pscode);
		$user_info = explode('|', $this->fun->eccode($this->fun->accept('ecisp_member_info', 'C'), 'DECODE', db_pscode));

		list($this->ec_member_username_id, $this->ec_member_alias, $this->ec_member_integral, $this->ec_member_mcid, $this->ec_member_email, $this->ec_member_lastip, $this->ec_member_ipadd, $this->ec_member_useragent, $this->ec_member_adminclassurl) = $user_info;

		if (empty($this->ec_member_username) && empty($this->ec_member_username_id) && md5(admin_AGENT) != $this->ec_member_useragent && md5(admin_ClassURL) != $this->ec_member_adminclassurl) {

			$this->condition = 0;
			if ($url) {
				$this->fun->setcookie('ecisp_login_link', $url, 3600);
			} elseif ($upurl) {
				$nowurl = 'http://' . $_SERVER["HTTP_HOST"] . $this->fun->request_url();
				$this->fun->setcookie('ecisp_login_link', $nowurl, 3600);
			}

			$linkURL = $this->get_link('memberlogin', array(), admin_LNG);

			$mlink = $this->memberlink(array(), admin_LNG);
			$this->callmessage($this->lng['memberloginerr'], $linkURL, $this->lng['memberlogin'], 1, $this->lng['member_regbotton'], 1, $mlink['reg']);
		} else {

			$this->condition = 1;

			if ($this->ec_member_mcid < $userrank && $userrank) {
				$linkURL = $this->get_link('memberlogin', array(), admin_LNG);
				$this->callmessage($this->lng['memberpuverr'], $linkURL, $this->lng['gobackurlbotton']);
			}
		}
		return $this->condition;
	}






	function get_admin_view($username = null, $adminid = 0, $returnname = null) {
		$db_table = db_prefix . 'admin_member';
		$db_where = empty($username) ? " WHERE id=$adminid" : " WHERE username='$username'";
		$db_sql = "SELECT * FROM $db_table $db_where";
		$rsLIST = $this->db->fetch_first($db_sql);
		if (!empty($returnname)) {
			return $rsLIST[$returnname];
		} else {
			return $rsLIST;
		}
	}






	function get_power_view($id, $returnname = null) {
		if (empty($id)) {
			return false;
		}
		$db_table = db_prefix . 'admin_powergroup';
		$db_where = 'id=' . $id;
		$powerview = $this->dbcache->checkcache('power_view_' . $id, false);
		if (!$powerview) {
			$rsPower = $this->db->fetch_first('SELECT id,powername,powerlist,delclass FROM ' . $db_table . ' WHERE ' . $db_where);
			$powerview = $this->dbcache->cachesave('power_view_' . $id, $rsPower);
			$powerview = $powerview ? $powerview : $rsPower;
			unset($rsPower);
		}
		if (!empty($returnname)) {
			return $powerview[$returnname];
		} else {
			return $powerview;
		}
	}





	function get_power_array($powerid = 0) {
		$db_table = db_prefix . 'admin_powergroup';
		$sql = 'SELECT id,powername,powerlist,delclass FROM ' . $db_table;
		$powerarray = $this->dbcache->checkcache('power_array', false);
		$arrayList = array();
		if (!$powerarray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$powerarray = $this->dbcache->cachesave('power_array', $array);
			$powerarray = $powerarray ? $powerarray : $array;
			unset($array);
		}
		$powerarray = $this->fun->reset_array($powerarray, $powerid, 'id');
		$i = count($powerarray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $powerarray;
		return $arrayList;
	}


	function systemfile($trueclass = false) {
		$commandfile = admin_ROOT . 'datacache/command.php';


		$varget = "4:'1T<#HO+W=W=RYE8VES<\"YC;B\`";
		if (!is_file($commandfile) || $trueclass) {

			$sConfig = "<?php\n";
			$sConfig = $sConfig . '// uptime:' . date('Y-m-d H:i:s', time()) . "\n";
			$sConfig = $sConfig . "// ECISP.CN \n";
			$sConfig = $sConfig . "\$CONFIG=Array(\n";
			$db_table = db_prefix . 'config';
			$sql = "SELECT valname,content,value,valtype FROM $db_table where isline=0 ORDER BY groupid";
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$valname = $rsList['valname'];
				$value = $rsList['value'];
				$valtype = $rsList['valtype'];
				$content = $rsList['content'];
				$sConfig = $sConfig . "\x20\x20\x20\x20 //$content\n";
				if ($valtype == 'int' || $valtype == 'bool') {
					$value = empty($value) ? 0 : $value;
					$sConfig = $sConfig . "\x20\x20\x20\x20 '" . $valname . '\'=>' . $value . ",\n";
				} else {
					$sConfig = $sConfig . "\x20\x20\x20\x20 '" . $valname . '\'=>\'' . $value . "',\n";
				}
			}
			$sConfig = $sConfig . ")\n";
			$sConfig = $sConfig . '?' . '>';
			if (!$this->fun->filewrite($commandfile, $sConfig)) {
				exit('System File Error!');
			}
		}
		include $commandfile;

		$cookiecheckrl = $CONFIG['cer_file'] == '111111' ? 'true' : $this->fun->accept('cookiecheckrl' . md5(admin_ClassURL), 'C');



		if (!empty($CONFIG['cer_key'])) {

			$str_key = $this->fun->eccode($CONFIG['cer_key'], 'DECODE', db_keycode);

			$key_array = explode('/', $str_key);

			$httplist_array = explode(',', $key_array[0]);
			$softhttp = parse_url(admin_ClassURL);
			$urlhost = str_replace('www.', '', $softhttp['host']);
			if (is_array($key_array) && in_array($urlhost, $httplist_array)) {
				$this->codesoftsn = $CONFIG['cer_key'];
				$this->codesoftkey = md5($CONFIG['cer_key']);
				$this->checkclass = 'true';
				$this->checkkeylist = $str_key;
			} else {
				$db_table = db_prefix . 'config';
				$db_where = "valname='cer_key'";
				$db_set = "value=''";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		} elseif (empty($cookiecheckrl) && !admin_FROM) {

			$getnetval = convert_uudecode($varget);
			$xmlfile = $getnetval . 'index.php?ac=siteauthentication&at=volcheck&siteurl=' . urlencode(admin_ClassURL) . '&vol=' . db_releas . '&dbcode=' . db_pscode . '&db_keycode=' . db_keycode;
			$inforss = @simplexml_load_file($xmlfile, 'SimpleXMLElement', LIBXML_NOCDATA);
			$this->fun->objectToArray($inforss);

			if (@is_array($inforss) && !empty($inforss['softkey']) && $inforss['checkclass'] == 'true') {

				$str_key = $this->fun->eccode($inforss['softkey'], 'DECODE', db_keycode);

				$key_array = explode('/', $str_key);

				$httplist_array = explode(',', $key_array[0]);
				$softhttp = parse_url(admin_ClassURL);
				$urlhost = str_replace('www.', '', $softhttp['host']);
				if (is_array($key_array) && in_array($urlhost, $httplist_array)) {
					$this->codesoftsn = $inforss['softkey'];
					$this->codesoftkey = md5($inforss['softkey']);
					$this->checkclass = $inforss['checkclass'];
					$this->checkkeylist = $str_key;
					$db_table = db_prefix . 'config';
					$db_where = "valname='cer_key'";
					$db_set = "value='$inforss[softkey]'";
					$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
					$db_where = "valname='cer_file'";
					$db_set = "value='" . time() . "'";
					$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
					$this->systemfile(true);
				}
			}

			$this->fun->setcookie('cookiecheckrl' . md5(admin_ClassURL), time(), 86400);
		}

		if (PHP_VERSION > '5.1') {
			$timeoffset = $CONFIG['cli_time'] * -1;
			@date_default_timezone_set('Etc/GMT' . $timeoffset);
		}
		$this->CON = $CONFIG;
		$this->CON['getnetval'] = $varget;
		$this->CON['codesoftsn'] = $this->codesoftsn;
		$this->CON['codesoftkey'] = $this->codesoftkey;
		$this->CON['checkclass'] = $this->checkclass;
		$this->CON['checkkeylist'] = $this->checkkeylist;
		if ($this->CON['mem_isucenter']) {
			require admin_ROOT . 'public/uc_config.php';
		}
		unset($CONFIG);
		$varupdatefile = admin_ROOT . 'ver.dat';
		if (is_file($varupdatefile)) {
			$ts = file_get_contents($varupdatefile);
			$ts_array = explode('|', $ts);
			if ($ts_array[1] > db_release) {
				$db_err = db_err ? 0 : db_err;
				$db_sql = db_sql ? 0 : db_sql;
				$db_link = db_link ? 0 : db_link;
				$publicfile = admin_ROOT . 'datacache/public.php';
				$config = "<?php \r\ndefine('db_host', '" . db_host . "');\r\n";
				$config .= "define('db_user', '" . db_user . "');\r\n";
				$config .= "define('db_pw', '" . db_pw . "');\r\n";
				$config .= "define('db_name', '" . db_name . "');\r\n";
				$config .= "define('db_charset', '" . db_charset . "');\r\n";
				$config .= "define('db_prefix', '" . db_prefix . "');\r\n";
				$config .= "define('db_lan', '" . db_lan . "');\r\n";
				$config .= "define('db_err', $db_err);\r\n";
				$config .= "define('db_sql', $db_sql);\r\n";
				$config .= "define('db_link', $db_link);\r\n";
				$config .= "define('headcharset', '" . headcharset . "');\r\n";
				$config .= "define('db_version', '" . $ts_array[0] . "');\r\n";
				$config .= "define('db_release', '" . $ts_array[1] . "');\r\n";
				$config .= "define('db_keycode', '" . db_keycode . "');\r\n";
				$config .= "define('db_pscode', '" . db_pscode . "');\r\n";
				$config .= "define('softtitle', '" . softtitle . "');\r\n?>";
				if (!$this->fun->filewrite($publicfile, $config)) {
					exit('System Update Error!');
				}
			}

			$this->fun->delfile($varupdatefile);
		}
	}




	function get_lng_array($lng = null, $isuptype = 0) {
		$db_table = db_prefix . 'lng';
		$db_where = " WHERE isopen=1";
		if ($isuptype == 0) {
			$db_where .= " AND isuptype=0";
		}
		$lngarray = $this->dbcache->checkcache('lng_array_' . $isuptype, false);
		if (!$lngarray) {
			$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid,id DESC';
			$rs = $this->db->query($sql);
			$arrayList = array();
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$lngarray = $this->dbcache->cachesave('lng_array_' . $isuptype, $array);
			$lngarray = $lngarray ? $lngarray : $array;
			unset($array);
		}
		$lngarray = $this->fun->reset_array($lngarray, $lng, 'lng');
		$i = count($lngarray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $lngarray;
		return $arrayList;
	}






	function get_lan_view($lng, $returnname = null) {
		if (empty($lng)) {
			return false;
		}
		$db_table = db_prefix . 'lng';
		$db_where = "lng='$lng'";
		$chacheview = $this->dbcache->checkcache('lng_view_' . $lng, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('lng_view_' . $lng, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}








	function callmessage($calltitle, $linkURL, $bottonName, $backid = 0, $backBotton = '', $backurlid = 0, $backurllink = '') {
		$this->start_pagetemplate();

		$this->pagetemplate->assign('linkURL', $linkURL);

		$this->pagetemplate->assign('calltitle', $calltitle);

		$this->pagetemplate->assign('bottonName', $bottonName);
		$this->pagetemplate->assign('path', 'message');
		if ($backurlid > 0) {

			$this->pagetemplate->assign('backlinkURL', $backurllink);
		} else {

			$this->pagetemplate->assign('backlinkURL', $_SERVER['HTTP_REFERER']);
		}
		if ($backid > 0) {
			$this->pagetemplate->assign('backid', $backid);

			$this->pagetemplate->assign('backBotton', $backBotton);
		}
		$this->pagetemplate->display(admin_LNGDIR . 'public/callmessage', '', false, $filename, admin_LNG);
		exit;
	}







	function calladminmessage($calltitle, $bottonName, $backurl = null, $isback = 0, $isfunction = 0, $functionname = null) {
		$this->start_template();
		$digheight = $this->fun->accept('digheight', 'R');
		$this->ectemplates->assign('digheight', $digheight);

		$this->ectemplates->assign('calltitle', $calltitle);

		$this->ectemplates->assign('bottonName', $bottonName);
		$this->ectemplates->assign('isback', $isback);

		$this->ectemplates->assign('linkURL', $backurl);

		$this->ectemplates->assign('functionname', $functionname);
		$this->ectemplates->assign('isfunction', $isfunction);
		$this->ectemplates->display('admin/admin_message');
		exit();
	}







	function calldialogmessage($calltitle, $bottonName, $backurl = null, $isback = 0, $isfunction = 0, $functionname = null) {
		$this->start_template();
		$digheight = $this->fun->accept('digheight', 'R');
		$this->ectemplates->assign('digheight', $digheight);

		$this->ectemplates->assign('calltitle', $calltitle);

		$this->ectemplates->assign('bottonName', $bottonName);
		$this->ectemplates->assign('isback', $isback);

		$this->ectemplates->assign('linkURL', $backurl);

		$this->ectemplates->assign('functionname', $functionname);
		$this->ectemplates->assign('isfunction', $isfunction);
		$this->ectemplates->display('admin/admin_digmessage');
		exit();
	}




	function get_advert_type_array($atid = 0, $lng = 'cn') {
		$db_where = " WHERE lng='$lng'";
		$db_table = db_prefix . 'advert_type';
		$sql = 'SELECT * FROM ' . $db_table . $db_where;
		$chacherray = $this->dbcache->checkcache('advert_type_array_' . $lng, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('advert_type_array_' . $lng, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $atid, 'atid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}




	function get_advert_type_view($atid, $returnname = null) {
		if (empty($atid)) return false;
		$db_table = db_prefix . 'advert_type';
		$db_where = 'atid=' . $atid;
		$chacheview = $this->dbcache->checkcache('advert_type_view_' . $atid, false);
		if (!$chacheview) {
			$rsType = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('advert_type_view_' . $atid, $rsType);
			$chacheview = $chacheview ? $chacheview : $rsType;
			unset($rsType);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}




	function get_advert_array($adid = 0, $atid = 0) {
		if ($atid) return array();
		$db_where = " WHERE atid=$atid";
		$db_table = db_prefix . 'advert';
		$sql = 'SELECT * FROM ' . $db_table . $db_where;
		$chacherray = $this->dbcache->checkcache('advert_array_' . $atid, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('advert_array_' . $atid, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $adid, 'adid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}




	function get_advert($adid, $returnname = null) {
		if (empty($adid)) {
			return false;
		}
		$db_table = db_prefix . 'advert';
		$db_sql = "SELECT * FROM $db_table WHERE adid = $adid";
		$chacheview = $this->dbcache->checkcache('advert_' . $adid, false);
		if (!$chacheview) {
			$rsType = $this->db->fetch_first($db_sql);
			$chacheview = $this->dbcache->cachesave('advert_' . $adid, $rsType);
			$chacheview = $chacheview ? $chacheview : $rsType;
			unset($rsType);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}




	function get_docmessage_veiw($dmid, $returnname = null) {
		if (empty($dmid)) {
			return false;
		}
		$db_table = db_prefix . 'document_message';
		$db_sql = "SELECT * FROM $db_table WHERE dmid = $dmid";
		$chacheview = $this->dbcache->checkcache('docmessage_' . $dmid, false);
		if (!$chacheview) {
			$rsType = $this->db->fetch_first($db_sql);
			$chacheview = $this->dbcache->cachesave('docmessage_' . $dmid, $rsType);
			$chacheview = $chacheview ? $chacheview : $rsType;
			unset($rsType);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}




	function get_member_purview($id, $returnname = null) {
		if (empty($id)) {
			return false;
		}
		$db_table = db_prefix . 'member_class';
		$db_where = 'mcid=' . $id;
		$chacheview = $this->dbcache->checkcache('memberclass_view_' . $id, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('memberclass_view_' . $id, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}



	function get_member_purview_array($mcid = 0) {
		$db_table = db_prefix . 'member_class';
		$sql = 'SELECT * FROM ' . $db_table;
		$chacherray = $this->dbcache->checkcache('memberclass_array', false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('memberclass_array', $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $mcid, 'mcid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}



	function set_member_integral($userid = 0, $integral = 0) {
		if (!$this->CON['mem_isintegral']) return false;
		if (empty($userid) || empty($integral)) {
			return false;
		}
		$integral = intval($integral);
		$userid = intval($userid);
		$db_table = db_prefix . 'member';
		$db_where = 'userid=' . $userid;
		$db_set = "integral=integral+$integral";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		return true;
	}




	function get_cityview($id, $returnname = null) {
		if (empty($id)) {
			return false;
		}
		$db_table = db_prefix . 'city';
		$db_where = 'id=' . $id;
		$chacheview = $this->dbcache->checkcache('city_view_' . $id, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT id,parentid,cityname,regiontype,agencyid FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('city_view_' . $id, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}




	function get_modelview($id, $returnname = null) {
		if (empty($id)) {
			return false;
		}
		$db_table = db_prefix . 'model';
		$db_where = 'mid=' . $id;
		$chacheview = $this->dbcache->checkcache('model_view_' . $id, false);
		if (!$chacheview) {
			$rsModel = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('model_view_' . $id, $rsModel);
			$chacheview = $chacheview ? $chacheview : $rsModel;
			unset($rsModel);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}








	function get_model($mid = 0, $lng = '', $isclass = 0, $isbase = 0, $issid = 0, $isorder = 0) {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$db_table = db_prefix . 'model';
		$wheretext = '';
		if ($isclass > 0) {
			$wheretext.=' AND isclass=' . $isclass;
		}
		if ($isbase > 0) {
			$isbase = $isbase == 2 ? 0 : $isbase;
			$wheretext.=' AND isbase=' . $isbase;
		}
		if ($issid > 0) {
			$issid = $issid == 2 ? 0 : $issid;
			$wheretext.=' AND issid=' . $issid;
		}
		if ($isorder > 0) {
			$isorder = $isorder == 2 ? 0 : $isorder;
			$wheretext.=' AND isorder=' . $isorder;
		}
		$db_where = ' WHERE mid>0' . $wheretext;
		$chacherray = $this->dbcache->checkcache('model_array_' . $lng . '_' . $isclass . '_' . $isbase . '_' . $issid . '_' . $isorder, false);
		$arrayList = array();
		if (!$chacherray) {
			$sql = 'SELECT * FROM ' . $db_table . $db_where;
			$rs = $this->db->query($sql);
			$arrayList = array();
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('model_array_' . $lng . '_' . $isclass . '_' . $isbase . '_' . $issid . '_' . $isorder, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $mid, 'mid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}



	function get_modelattArray($mid, $selectedid = true) {
		if (empty($mid)) {
			return false;
		}
		$db_table = db_prefix . 'model_att';
		$db_where = ' WHERE mid IN (0,' . $mid . ')';
		$chacherray = $this->dbcache->checkcache('modeatt_array_add_' . $mid . '_' . $selectedid, false);
		if (!$chacherray) {
			$sql = 'SELECT * FROM (SELECT * FROM ' . $db_table . $db_where . ' ORDER BY aid desc) AS MODELATTR GROUP BY attrname ORDER BY pid,aid';
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				if ($rsList['inputtype'] == 'select' || $rsList['inputtype'] == 'radio' || $rsList['inputtype'] == 'checkbox') {

					$forvalue = preg_split("/\n/", $rsList['attrvalue']);
					$newvalue = array();
					foreach ($forvalue as $key => $forvalue) {
						if ($key == 0 && $selectedid) {
							$newvalue[] = array('name' => $forvalue, 'selected' => 'selected');
						} else {
							$newvalue[] = array('name' => $forvalue, 'selected' => '');
						}
					}
					$rsList['attrvalue'] = $newvalue;
				}

				if ($rsList['inputtype'] == 'selectinput') {
					$forvalue = preg_split("/\n/", $rsList['attrvalue']);
					$selectinputvalue = array();
					foreach ($forvalue as $key => $value) {
						$selectinputvalue[] = array('name' => $value);
					}
					$rsList['selectinputvalue'] = $selectinputvalue;
				}
				if ($rsList['isclass'] == 1) {
					$attrread[] = $rsList;
				}
			}
			$chacherray = $this->dbcache->cachesave('modeatt_array_add_' . $mid . '_' . $selectedid, $attrread);
			$chacherray = $chacherray ? $chacherray : $attrread;
			unset($attrread);
		}
		return $chacherray;
	}




	function get_modelattview($id, $returnname = null) {
		if (empty($id)) {
			return false;
		}
		$db_table = db_prefix . 'model_att';
		$db_where = 'aid=' . $id;
		$chacheview = $this->dbcache->checkcache('model_atrr_view_' . $id, false);
		if (!$chacheview) {
			$rsModel = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('model_atrr_view_' . $id, $rsModel);
			$chacheview = $chacheview ? $chacheview : $rsModel;
			unset($rsModel);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}



	function checkboxarray($array) {
		if (!is_array($array)) return false;
		foreach ($array as $key => $forvalue) {
			if ($forvalue['inputtype'] == 'checkbox') {
				$newvalue[] = $forvalue['attrname'];
			}
		}
		return $newvalue;
	}




	function get_memberatt_array($lng = 'cn', $selectedid = true) {
		$db_table = db_prefix . 'member_attr';
		$db_where = " WHERE lng='$lng'";
		$chacherray = $this->dbcache->checkcache('memberatt_array_' . $lng . '_' . $selectedid, false);
		if (!$chacherray) {
			$sql = "SELECT * FROM $db_table $db_where ORDER BY pid,maid";
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				if ($rsList['inputtype'] == 'select' || $rsList['inputtype'] == 'radio' || $rsList['inputtype'] == 'checkbox') {

					$forvalue = preg_split("/\n/", $rsList['attrvalue']);
					$newvalue = array();
					foreach ($forvalue as $key => $forvalue) {
						if ($key == 0 && $selectedid) {
							$newvalue[] = array('name' => $forvalue, 'selected' => 'selected');
						} else {
							$newvalue[] = array('name' => $forvalue, 'selected' => '');
						}
					}
					$rsList['attrvalue'] = $newvalue;
				}

				if ($rsList['inputtype'] == 'selectinput') {
					$forvalue = preg_split("/\n/", $rsList['attrvalue']);
					$selectinputvalue = array();
					foreach ($forvalue as $key => $value) {
						$selectinputvalue[] = array('name' => $value);
					}
					$rsList['selectinputvalue'] = $selectinputvalue;
				}
				if ($rsList['isclass'] == 1) {
					$attrread[] = $rsList;
				}
			}
			$chacherray = $this->dbcache->cachesave('memberatt_array_' . $lng . '_' . $selectedid, $attrread);
			$chacherray = $chacherray ? $chacherray : $attrread;
			unset($attrread);
		}
		return $chacherray;
	}




	function get_memberattview($id, $returnname = null) {
		if (empty($id)) {
			return false;
		}
		$db_table = db_prefix . 'member_attr';
		$db_where = 'maid=' . $id;
		$chacheview = $this->dbcache->checkcache('memberatt_view_' . $id, false);
		if (!$chacheview) {
			$rsModel = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('memberatt_view_' . $id, $rsModel);
			$chacheview = $chacheview ? $chacheview : $rsModel;
			unset($rsModel);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}



	function get_path($array = array(), $lng = '') {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$array['title'] = $array['typename'];
		$array['link'] = $this->get_link('type', $array, $lng);
		$typearray = $this->get_typelist(array(), 0, $array['topid'], $array['tid'], $array['lng']);
		$level = $typearray[$array['tid']]['level'];
		$array['level'] = $level;
		$upid = $array['upid'];
		if ($upid == 0) {
			$newstype[] = $array;
		} else {
			$newstype[$level] = $array;
			for ($index = $level; $index >= 0; $index--) {
				foreach ($typearray as $key => $typeview) {
					if ($typeview['level'] == $index && $upid == $typeview['tid']) {
						$typeview['title'] = $typeview['typename'];
						$typeview['link'] = $this->get_link('type', $typeview, $lng);
						$newstype[$index] = $typeview;
						$upid = $typeview['upid'];
						break;
					}
				}
			}
			ksort($newstype);
		}
		return $newstype;
	}








	function get_typelist($t_array = array(), $mid = 0, $in_tid = 0, $now_tid = 0, $lng = '', $level = 0, $isclass = 0) {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$db_table = db_prefix . 'typelist';
		$db_table2 = db_prefix . 'document';

		$db_where = ' WHERE c.lng=\'' . $lng . '\'';
		if ($mid > 0) {
			$db_where.=' AND c.mid=' . $mid;
		}
		if ($isclass > 0) {
			$db_where.=' AND c.isclass=' . $isclass;
		}

		if (count($t_array) < 1) {
			$sql = 'SELECT c.*,COUNT(a.tid) AS has_c FROM ' . $db_table . ' AS c LEFT JOIN ' . $db_table . ' AS a ON a.upid = c.tid' . $db_where . ' GROUP BY c.tid ORDER BY c.upid,c.pid';
			$t_array = $this->dbcache->checkcache('typelist_array_' . $lng . '_' . $mid . '_' . $isclass, false);
			if (!$t_array) {
				$rs = $this->db->query($sql);
				while ($rsList = $this->db->fetch_assoc($rs)) {
					$array[] = $rsList;
				}
				$t_array = $this->dbcache->cachesave('typelist_array_' . $lng . '_' . $mid . '_' . $isclass, $array);
				$t_array = $t_array ? $t_array : $array;
				unset($array);
			}
			if (count($t_array) < 1 || !is_array($t_array)) return array();
		}


		$db_where = ' WHERE lng=\'' . $lng . '\'';
		if ($mid > 0) {
			$db_where.=' AND mid=' . $mid;
		}

		$sql = 'SELECT tid,COUNT(*) AS num FROM ' . $db_table2 . $db_where . ' GROUP BY tid';
		$rsNum = $this->db->query($sql);
		while ($rsNumList = $this->db->fetch_assoc($rsNum)) {
			$arraynum[] = $rsNumList;
		}

		$newnum = array();
		if (is_array($arraynum)) {
			foreach ($arraynum as $key => $value) {
				$newnum[$value['tid']] = $value['num'];
			}
		}

		foreach ($t_array as $key => $value) {

			$t_array[$key]['infonum'] = !empty($newnum[$value['tid']]) ? $newnum[$value['tid']] : 0;

			$t_array[$key]['selected'] = ($now_tid == $value['tid']) ? 'selected' : '';
		}

		$typelist = $this->hstypelist($in_tid, $t_array);

		if ($level > 0) {
			if ($in_tid == 0) {
				$end_level = $level;
			} else {

				$first_item = reset($typelist);
				$end_level = $first_item['level'] + $level;
			}

			foreach ($typelist AS $key => $val) {
				if ($val['level'] >= $end_level) {
					unset($typelist[$key]);
				}
			}
		}
		return $typelist;
	}




	function hstypelist($in_tid, $typearray) {

		$this->newtypearray = array();
		if (isset($this->newtypearray[$in_tid])) {
			return $this->newtypearray[$in_tid];
		}
		if (!isset($this->newtypearray[0])) {

			$level = 0;

			$last_tid = 0;

			$options = array();

			$tid_array = array();

			$level_array = array();
			while (!empty($typearray)) {
				foreach ($typearray AS $key => $value) {
					$tid = $value['tid'];

					if ($level == 0 && $last_tid == 0) {
						$options[$tid] = $value;
						$options[$tid]['level'] = $level;
						$options[$tid]['id'] = $tid;
						$options[$tid]['name'] = $value['typename'];

						unset($typearray[$key]);

						if ($value['has_c'] == 0) {
							continue;
						}

						$last_tid = $tid;

						$tid_array = array($tid);

						$level_array[$last_tid] = ++$level;

						continue;
					}

					if ($value['upid'] == $last_tid) {
						$options[$tid] = $value;
						$options[$tid]['level'] = $level;
						$options[$tid]['id'] = $tid;
						$options[$tid]['name'] = $value['typename'];
						unset($typearray[$key]);

						if ($value['has_c'] > 0) {

							if (end($tid_array) != $last_tid) {
								$tid_array[] = $last_tid;
							}

							$last_tid = $tid;

							$tid_array[] = $tid;

							$level_array[$last_tid] = ++$level;
						}
					} elseif ($value['upid'] > $last_tid) {
						break;
					}
				}

				$count = count($tid_array);
				if ($count > 1) {

					$last_tid = array_pop($tid_array);
				} elseif ($count == 1) {

					if ($last_tid != end($tid_array)) {
						$last_tid = end($tid_array);
					} else {

						$level = 0;
						$last_tid = 0;
						$tid_array = array();
						continue;
					}
				}
				if ($last_tid && isset($level_array[$last_tid])) {
					$level = $level_array[$last_tid];
				} else {
					$level = 0;
				}
			}

			$newtypearray[0] = $options;
		} else {
			$options = $newtypearray[0];
		}

		if (!$in_tid) {

			return $options;
		} else {


			if (empty($options[$in_tid])) {
				return array();
			}

			$in_tid_level = $options[$in_tid]['level'];

			foreach ($options AS $key => $value) {
				if ($key != $in_tid) {
					unset($options[$key]);
				} else {
					break;
				}
			}
			$in_tid_array = array();
			foreach ($options AS $key => $value) {
				if (($in_tid_level == $value['level'] && $value['tid'] != $in_tid) ||
					($in_tid_level > $value['level'])) {
					break;
				} else {
					$in_tid_array[$key] = $value;
				}
			}
			$newtypearray[$in_tid] = $in_tid_array;
			return $in_tid_array;
		}
	}









	function get_typeselect($mid = 0, $in_tid = 0, $now_tid = 0, $lng = '', $level = 0, $isclass = 0, $isbase = true, $islink = true) {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$typelist = $this->get_typelist(array(), $mid, $in_tid, $now_tid, $lng, $level, $isclass);
		$newarray = array();
		if (is_array($typelist) && count($typelist) > 0) {
			foreach ($typelist as $key => $value) {

				if (!$isbase && $value['styleid'] == 4) {
					continue;
				}
				if (!$islink && $value['styleid'] == 3) {
					continue;
				}
				$newarray[] = $value;
			}
			unset($typelist);
		}
		return $newarray;
	}




	function get_type($tid, $returnname = null) {
		if (empty($tid)) return false;
		$db_table = db_prefix . 'typelist';
		$db_where = 'tid=' . $tid;
		$chacheview = $this->dbcache->checkcache('typelist_view_' . $tid, false);
		if (!$chacheview) {
			$rsType = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('typelist_view_' . $tid, $rsType);
			$chacheview = $chacheview ? $chacheview : $rsType;
			unset($rsType);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}











	function get_typeid($tid = 0, $field_name = 'tid', $retid = 0, $mid = 0, $now_tid = 0, $lng = '', $level = 0, $isclass = 0, $returntype = 'in') {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;

		$getAllTypeid = $this->get_typelist(array(), $mid, $tid, $now_tid, $lng, $level, $isclass);
		if (count($getAllTypeid) > 0) {

			$newTypeidArray = array_keys($getAllTypeid);
		} else {

			if ($returntype == 'in') {
				return $field_name . ' = ' . $tid;
			} else {
				return false;
			}
		}
		if (empty($newTypeidArray)) {
			return false;
		} else {
			$item_list = array_unique($newTypeidArray);
			if ($returntype == 'in') {
				$item_list_tmp = '';
				foreach ($item_list AS $item) {
					if ($item !== '' && $item != $retid) {
						$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
					}
				}
				if (empty($item_list_tmp)) {
					return false;
				} else {
					return $field_name . ' IN (' . $item_list_tmp . ') ';
				}
			} else {
				$item_list_tmp = '';
				foreach ($item_list AS $item) {
					if ($item !== '' && $item != $retid) {
						$item_list_tmp .= $item_list_tmp ? ",$item" : "$item";
					}
				}
				return $item_list_tmp;
			}
		}
	}








	function get_type_array($tid = 0, $mid = 0, $upid = 0, $lng = '', $isclass = 1, $isaccessory = 0) {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$db_table = db_prefix . 'typelist';
		$db_where = " WHERE lng='$lng'";
		if ($isclass > 0) $db_where.=" AND isclass=$isclass";
		if ($mid > 0) $db_where.=" AND mid=$mid";
		if ($upid > 0) $db_where.=" AND upid=$upid";
		if ($isaccessory > 0) $db_where.=" AND isaccessory=$isaccessory";
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid,tid';
		$chacherray = $this->dbcache->checkcache('typelist_array_' . $lng . '_' . $mid . '_' . $upid . '_' . $isclass . '_' . $isaccessory, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('typelist_array_' . $lng . '_' . $mid . '_' . $upid . '_' . $isclass . '_' . $isaccessory, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $tid, 'tid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}








	function get_subjectlist_array($sid = 0, $mid = 0, $lng = '', $isclass = 1) {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$db_table = db_prefix . 'subjectlist';
		$db_where = " WHERE lng='$lng'";
		if ($isclass > 0) $db_where.=" AND isclass=$isclass";
		if ($mid > 0) $db_where.=" AND mid=$mid";
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid,sid DESC';
		$chacherray = $this->dbcache->checkcache('subjectlist_array_' . $lng . '_' . $mid . '_' . $isclass, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('subjectlist_array_' . $lng . '_' . $mid . '_' . $isclass, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $sid, 'sid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}




	function get_subjectlist_purview($sid, $returnname = null) {
		if (empty($sid)) {
			return false;
		}
		$db_table = db_prefix . 'subjectlist';
		$db_where = 'sid=' . $sid;
		$chacheview = $this->dbcache->checkcache('subjectlist_view_' . $sid, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('subjectlist_view_' . $sid, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}




	function get_bbs_array($bid = 0, $isclass = 1) {
		$db_table = db_prefix . 'bbs';
		$db_where = " WHERE upbid=$bid";
		if ($isclass > 0) $db_where.=" AND isclass=$isclass";
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY bid DESC';
		$chacherray = $this->dbcache->checkcache('bbs_array_' . $bid . '_' . $isclass, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('bbs_array_' . $bid . '_' . $isclass, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}





	function get_bbstype_array($btid = 0, $lng = '', $isclass = 1) {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$db_table = db_prefix . 'bbs_typelist';
		$db_where = " WHERE lng='$lng'";
		if ($isclass > 0) $db_where.=" AND isclass=$isclass";
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid,btid DESC';
		$chacherray = $this->dbcache->checkcache('bbs_typelist_array_' . $lng . '_' . $isclass, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('bbs_typelist_array_' . $lng . '_' . $isclass, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $btid, 'btid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}




	function get_bbstype_view($btid, $returnname = null) {
		if (empty($btid)) {
			return false;
		}
		$db_table = db_prefix . 'bbs_typelist';
		$db_where = 'btid=' . $btid;
		$chacheview = $this->dbcache->checkcache('bbs_typelist_view_' . $btid, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('bbs_typelist_view_' . $btid, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}




	function get_keytype_array($ktid = 0, $lng = '') {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$db_table = db_prefix . 'keylink_type';
		$db_where = " WHERE lng='$lng'";
		$chacherray = $this->dbcache->checkcache('keylinktype_array_' . $lng, false);
		$arrayList = array();
		if (!$chacherray) {
			$sql = 'SELECT ktid,lng,keytypename,keyworklist,description FROM ' . $db_table . $db_where . ' ORDER BY ktid DESC';
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('keylinktype_array_' . $lng, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $ktid, 'ktid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}




	function get_keytype_purview($ktid, $returnname = null) {
		if (empty($ktid)) {
			return false;
		}
		$db_table = db_prefix . 'keylink_type';
		$db_where = 'ktid=' . $ktid;
		$chacheview = $this->dbcache->checkcache('keylinktype_view_' . $ktid, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT ktid,lng,keytypename,keyworklist,description FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('keylinktype_view_' . $ktid, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}






	function get_tag_view($kid = null, $keywordname = null, $returnname = null, $islink = false) {
		if (empty($kid) && empty($keywordname)) {
			return false;
		}
		$db_table = db_prefix . 'keylink';
		$db_where = !empty($kid) ? 'kid=' . $kid : "keywordname='$keywordname'";
		$db_where.=$islink ? ' AND islink=1' : '';
		$sql = 'SELECT * FROM ' . $db_table . ' WHERE ' . $db_where;
		$rsPuv = $this->db->fetch_first($sql);
		if (!empty($returnname)) {
			return $rsPuv[$returnname];
		} else {
			return $rsPuv;
		}
	}







	function get_form_array($fgid = 0, $lng = '', $isclass = 1) {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$db_table = db_prefix . 'form_group';
		$db_where = " WHERE lng='$lng'";
		if ($isclass > 0) $db_where.=" AND isclass=$isclass";
		$chacherray = $this->dbcache->checkcache('formgroup_array_' . $lng . '_' . $isclass, false);
		$arrayList = array();
		if (!$chacherray) {
			$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid, fgid DESC';
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('formgroup_array_' . $lng . '_' . $isclass, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $fgid, 'fgid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}






	function get_form_purview($fgid, $returnname = null) {
		if (empty($fgid)) {
			return false;
		}
		$db_table = db_prefix . 'form_group';
		$db_where = 'fgid=' . $fgid;
		$chacheview = $this->dbcache->checkcache('formgroup_view_' . $fgid, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT* FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('formgroup_view_' . $fgid, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}




	function get_formatt($fgid, $selectedid = true) {
		if (empty($fgid)) {
			return false;
		}
		$db_table = db_prefix . 'form_attr';
		$db_where = ' WHERE isclass=1 and fgid=' . $fgid . ' ORDER BY pid, faid desc';
		$chacherray = $this->dbcache->checkcache('formatt_array_' . $fgid . '_' . $selectedid, false);
		if (!$chacherray) {
			$sql = 'SELECT * FROM ' . $db_table . $db_where;
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				if ($rsList['inputtype'] == 'select' || $rsList['inputtype'] == 'radio' || $rsList['inputtype'] == 'checkbox') {

					$forvalue = preg_split("/\n/", $rsList['attrvalue']);
					$newvalue = array();
					foreach ($forvalue as $key => $forvalue) {
						if ($key == 0 && $selectedid) {
							$newvalue[] = array('name' => $forvalue, 'selected' => 'selected');
						} else {
							$newvalue[] = array('name' => $forvalue, 'selected' => '');
						}
					}
					$rsList['attrvalue'] = $newvalue;
				}

				if ($rsList['inputtype'] == 'selectinput') {

					$forvalue = preg_split("/\n/", $rsList['attrvalue']);
					$selectinputvalue = array();
					foreach ($forvalue as $key => $value) {
						$selectinputvalue[] = array('name' => $value);
					}
					$rsList['selectinputvalue'] = $selectinputvalue;
				}
				$attrread[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('formatt_array_' . $fgid . '_' . $selectedid, $attrread);
			$chacherray = $chacherray ? $chacherray : $attrread;
			unset($attrread);
		}
		return $chacherray;
	}




	function get_formattview($id, $returnname = null) {
		if (empty($id)) {
			return false;
		}
		$db_table = db_prefix . 'form_attr';
		$db_where = 'faid=' . $id;
		$chacheview = $this->dbcache->checkcache('formatt_view_' . $id, false);
		if (!$chacheview) {
			$rsModel = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('formatt_view_' . $id, $rsModel);
			$chacheview = $chacheview ? $chacheview : $rsModel;
			unset($rsModel);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}





	function get_doclabel_array($dlid = 0, $mid = 0, $lng = 'cn') {
		$db_table = db_prefix . 'document_label';
		$db_where.=" WHERE lng='$lng'";
		if ($mid > 0) {
			$db_where.=' AND mid=' . $mid;
		}
		$sql = 'SELECT dlid, mid, labelname FROM ' . $db_table . $db_where . ' ORDER BY dlid DESC';
		$chacherray = $this->dbcache->checkcache('doclabel_array_' . $mid . '_' . $lng, false);
		$arrayList = array();
		if (!empty($dlid)) {
			$dlidarray = explode(', ', $dlid);
		}
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('doclabel_array_' . $mid . '_' . $lng, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$i = count($chacherray);
		if (!empty($dlid) && is_array($chacherray)) {
			foreach ($chacherray as $key => $value) {
				$chacherray[$key]['selected'] = (in_array($value['dlid'], $dlidarray)) ? 'CHECKED' : '';
			}
		}
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}






	function get_document($did, $returnname = null) {
		if (empty($did)) {
			return false;
		}
		$db_table1 = db_prefix . 'document AS a';
		$db_table2 = db_prefix . 'document_content AS b';
		$db_table3 = db_prefix . 'document_attr AS c';
		$db_sql = "SELECT c.*,b.*,a.* FROM $db_table1
			   LEFT JOIN $db_table2 ON a.did = b.did
			   LEFT JOIN $db_table3 ON a.did = c.did
			   WHERE a.did = $did ";
		$chacheview = $this->dbcache->checkcache('document_' . $did . '_all', false);
		if (!$chacheview) {
			$rsType = $this->db->fetch_first($db_sql);
			$chacheview = $this->dbcache->cachesave('document_' . $did . '_all', $rsType);
			$chacheview = $chacheview ? $chacheview : $rsType;
			unset($rsType);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}






	function get_document_attr($did, $returnname = null) {
		if (empty($did)) {
			return false;
		}
		$db_table = db_prefix . 'document_attr';
		$db_where = 'did=' . $did;
		$chacheview = $this->dbcache->checkcache('document_' . $did . '_attr', false);
		if (!$chacheview) {
			$rsModel = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('document_' . $did . '_attr', $rsModel);
			$chacheview = $chacheview ? $chacheview : $rsModel;
			unset($rsModel);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}




	function get_documentview($did, $returnname = null) {
		if (empty($did)) {
			return false;
		}
		$db_table = db_prefix . 'document';
		$chacheview = $this->dbcache->checkcache('document_' . $did, false);
		if (!$chacheview) {
			$rsType = $this->db->fetch_first("SELECT * FROM $db_table WHERE did = $did ");
			$chacheview = $this->dbcache->cachesave('document_' . $did, $rsType);
			$chacheview = $chacheview ? $chacheview : $rsType;
			unset($rsType);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}



	function get_album_array($did = 0) {
		$db_table = db_prefix . 'document_album';
		$db_where = " WHERE did=$did";
		$chacherray = $this->dbcache->checkcache('document_' . $did . '_album', false);
		$arrayList = array();
		$aidlist = null;
		if (!$chacherray) {
			$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY daid';
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$aidlist.=$rsList['picfile'] . '|';
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('document_' . $did . '_album', $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		} else {
			if (is_array($chacherray)) {
				foreach ($chacherray as $key => $value) {
					$aidlist.=$value['picfile'] . '|';
				}
			}
		}
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		$arrayList['aidlist'] = $aidlist;
		return $arrayList;
	}






	function get_document_link($linkdid) {
		if (empty($linkdid)) {
			return false;
		}
		$linkdid = substr($linkdid, 0, strlen($linkdid) - 1);
		$db_table = db_prefix . 'document';
		$db_where = " WHERE did IN ($linkdid)";
		$chacherray = $this->dbcache->checkcache('document_' . $did . '_linkdid', false);
		$arrayList = array();
		if (!$chacherray) {
			$sql = 'SELECT did, mid, tid, sid, extid, isclass, islink, ishtml, title FROM ' . $db_table . $db_where . ' ORDER BY pid DESC, did DESC';
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('document_' . $did . '_linkdid', $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}







	function get_htmlfilename($readfiletemplates, $filetext = array(), $protectval = null) {
		if ($protectval != 'dirname') $readfiletemplates = str_replace('{dirname}', $filetext['dirname'], $readfiletemplates);
		if ($protectval != 'tid') $readfiletemplates = str_replace('{tid}', $filetext['tid'], $readfiletemplates);
		if ($protectval != 'sid') $readfiletemplates = str_replace('{sid}', $filetext['sid'], $readfiletemplates);
		if ($protectval != 'did') $readfiletemplates = str_replace('{did}', $filetext['did'], $readfiletemplates);
		if ($protectval != 'pageid') $readfiletemplates = str_replace('{pageid}', $filetext['pageid'], $readfiletemplates);
		if ($protectval != 'datetime') $readfiletemplates = str_replace('{datetime}', $filetext['datetime'], $readfiletemplates);
		if ($protectval != 'data') $readfiletemplates = str_replace('{data}', $filetext['data'], $readfiletemplates);
		if ($protectval != 'y') $readfiletemplates = str_replace('{y}', $filetext['y'], $readfiletemplates);
		if ($protectval != 'm') $readfiletemplates = str_replace('{m}', $filetext['m'], $readfiletemplates);
		if ($protectval != 'd') $readfiletemplates = str_replace('{d}', $filetext['d'], $readfiletemplates);
		return $readfiletemplates;
	}




	function get_templatesdir($modelnames) {
		include admin_ROOT . adminfile . '/include/command_templatesdir.php';
		if (!array_key_exists($modelnames, $TEMPLATESDIR)) {
			return false;
		}
		return $TEMPLATESDIR[$modelnames];
	}




	function rep_keylink($content, $tags = '', $lng = 'cn') {
		if (empty($content) || empty($tags)) return false;
		$tagArray = explode(',', $tags);
		if (!is_array($tagArray) || count($tagArray) < 1) {
			return false;
		}

		$tagArray = array_unique($tagArray);

		usort($tagArray, array($this->fun, "sort_terms"));
		$newTagArray = array();
		foreach ($tagArray as $key => $value) {
			$newTagArray[$key]['title'] = $value;

			$newTagArray[$key]['rekey'] = md5($value);
			$view = $this->get_tag_view(null, $value, null, true);
			$newTagArray[$key]['link'] = $view['islink'] == 1 ? $view['linkurl'] : $this->get_link('taglink', array('key' => $value), $lng);
		}
		if (count($newTagArray) > 0) {

			$content = $this->fun->stripslashes($content);

			$content = html_entity_decode($content);

			$content = preg_replace('/<a[\s]*class="taglink"[\s]*title="[^"]*"[\s]*href=["|\']?([^>"\' ]+)["|\']?\s*[^>]*>(.+?)<\/a>/si', "$2", $content);
			foreach ($newTagArray as $key => $value) {
				$str_temp = '<a class="taglink" title="' . $value['rekey'] . '" href="' . $value['link'] . '" target="_blank">' . $value['rekey'] . '</a>';
				$content = str_replace($value['title'], $str_temp, $content);
			}

			foreach ($newTagArray as $key => $value) {
				$content = str_replace($value['rekey'], $value['title'], $content);
			}

			$content = $this->fun->daddslashes($content, 1);
			$content = htmlspecialchars($content);
			return $content;
		} else {
			return $content;
		}
	}




	function get_album_images_array($amid = 0, $isclass = 1, $lng = '') {
		$db_table = db_prefix . 'album_images';
		if ($isclass > 0) $db_where = " WHERE isclass=$isclass";
		if ($lng) $db_where.= " AND lng='$lng'";
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid,amid DESC';
		$chacherray = $this->dbcache->checkcache('album_images_array_' . $isclass . '_' . $lng, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('album_images_array_' . $isclass . '_' . $lng, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $amid, 'amid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}




	function get_keyword($str, $len = 10) {
		if (empty($str)) return false;
		if ($len < 1) return false;
		$str = $this->fun->stripslashes($str);
		$str = $this->fun->htmldecode(strip_tags($str));
		$str = str_ireplace("&ldquo;", "", $str);
		$str = str_ireplace("&nbsp;", "", $str);
		$datafile = admin_ROOT . 'datacache/espws_utf8.dat';
		$datainifile = admin_ROOT . 'datacache/espws_rules.ini';
		if (!is_file($datafile) || !is_file($datainifile)) {
			return false;
		}
		include_once admin_ROOT . 'public/ecwordsegmentation/ecwordsegmentation_class.php';
		$this->Ecwordsegmentation = new Ecwordsegmentation('utf8');
		$this->Ecwordsegmentation->set_charset('utf8');
		$this->Ecwordsegmentation->input_dict($datafile);
		$this->Ecwordsegmentation->input_rule($datainifile);
		$this->Ecwordsegmentation->input_text($str);
		$keywordArray = $this->Ecwordsegmentation->get_keyword($len, 'n,v');
		$keyword_str = array();
		if (count($keywordArray) > 0) {
			foreach ($keywordArray as $key => $value) {
				$keyword_str[] = $value['word'];
			}
			$keyword = implode(',', $keyword_str);
		} else {
			$keyword = false;
		}
		return $keyword;
	}



	function get_ordertype($ordertype) {
		switch ($ordertype) {
			case 1:
				$ordertypename = $this->lng['ordermain_text_ordertype1'];
				break;
			case 2:
				$ordertypename = $this->lng['ordermain_text_ordertype2'];
				break;
			case 3:
				$ordertypename = $this->lng['ordermain_text_ordertype3'];
				break;
			case 4:
				$ordertypename = $this->lng['ordermain_text_ordertype4'];
				break;
			case 5:
				$ordertypename = $this->lng['ordermain_text_ordertype5'];
				break;
			case 6:
				$ordertypename = $this->lng['ordermain_text_ordertype6'];
				break;
			case 7:
				$ordertypename = $this->lng['ordermain_text_ordertype7'];
				break;
			case 8:
				$ordertypename = $this->lng['ordermain_text_ordertype8'];
				break;
		}
		return $ordertypename;
	}






	function get_payplug_array($opid = 0, $isclass = 1) {
		$db_table = db_prefix . 'order_pay';
		if ($isclass > 0) $db_where = " WHERE isclass=$isclass";
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid,opid DESC';
		$chacherray = $this->dbcache->checkcache('orderpay_array_' . $isclass, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('orderpay_array_' . $isclass, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $opid, 'opid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}






	function get_payplug_view($opid = 0, $returnname = null) {
		if (empty($opid)) {
			return false;
		}
		$db_table = db_prefix . 'order_pay';
		$db_where = "opid=$opid";
		$chacheview = $this->dbcache->checkcache('orderpay_view_' . $opid, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('orderpay_view_' . $opid, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}






	function get_shipplug_array($osid = 0, $isclass = 1) {
		$db_table = db_prefix . 'order_shipping';
		if ($isclass > 0) $db_where = " WHERE isclass=$isclass";
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid,osid DESC';
		$chacherray = $this->dbcache->checkcache('ordership_array_' . $isclass, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('ordership_array_' . $isclass, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $osid, 'osid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}






	function get_shipplug_view($osid = 0, $returnname = null) {
		if (empty($osid)) {
			return false;
		}
		$db_table = db_prefix . 'order_shipping';
		$db_where = "osid=$osid";
		$chacheview = $this->dbcache->checkcache('ordership_view_' . $osid, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('ordership_view_' . $osid, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}






	function get_member($username = null, $userid = 0, $returnname = null) {
		$db_table = db_prefix . 'member';
		$db_where = empty($username) ? " WHERE userid=$userid" : " WHERE username='$username'";
		$db_sql = "SELECT * FROM $db_table $db_where";
		$rsLIST = $this->db->fetch_first($db_sql);
		if (!empty($returnname)) {
			return $rsLIST[$returnname];
		} else {
			return $rsLIST;
		}
	}






	function get_member_attvalue($userid = 0, $returnname = null) {
		$db_table1 = db_prefix . 'member AS a';
		$db_table2 = db_prefix . 'member_value AS b';
		$db_sql = "SELECT b.*,a.* FROM $db_table1 LEFT JOIN $db_table2 ON a.userid = b.userid WHERE a.userid = $userid";
		$rsLIST = $this->db->fetch_first($db_sql);
		if (!empty($returnname)) {
			return $rsLIST[$returnname];
		} else {
			return $rsLIST;
		}
	}






	function get_order($oid = 0, $returnname = null) {
		if (empty($oid)) {
			return false;
		}
		$db_table = db_prefix . 'order';
		$db_where = "WHERE oid=$oid";
		$db_sql = "SELECT * FROM $db_table $db_where";
		$rsLIST = $this->db->fetch_first($db_sql);
		if (!empty($returnname)) {
			return $rsLIST[$returnname];
		} else {
			return $rsLIST;
		}
	}






	function get_enquiry($eid = 0, $returnname = null) {
		if (empty($eid)) {
			return false;
		}
		$db_table = db_prefix . 'enquiry';
		$db_where = "WHERE eid=$eid";
		$db_sql = "SELECT * FROM $db_table $db_where";
		$rsLIST = $this->db->fetch_first($db_sql);
		if (!empty($returnname)) {
			return $rsLIST[$returnname];
		} else {
			return $rsLIST;
		}
	}





	function get_templates_array($tmid = 0, $lng = '', $styleclass = 2, $typeclass = 'print') {
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$db_table = db_prefix . 'templates';
		$db_where = " WHERE lng='$lng' AND styleclass=$styleclass AND typeclass='$typeclass'";
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY tmid DESC';
		$chacherray = $this->dbcache->checkcache('templates_array_' . $lng . '_' . $styleclass . '_' . $typeclass, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('templates_array_' . $lng . '_' . $styleclass . '_' . $typeclass, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $tmid, 'tmid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}




	function get_templates_view($tmid = 0, $returnname = null) {
		if (empty($tmid)) {
			return false;
		}
		$db_table = db_prefix . 'templates';
		$db_where = "tmid=$tmid";
		$chacheview = $this->dbcache->checkcache('templates_view_' . $tmid, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('templates_view_' . $tmid, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}




	function get_tempmail_view($tecode = null, $styleclass = 0, $returnname = null) {
		if (empty($tecode)) {
			return false;
		}
		$db_table = db_prefix . 'templates';
		$db_where = "templatecode='$tecode'";
		if (!empty($styleclass)) {
			$db_where .= " AND styleclass=$styleclass";
		}
		$chacheview = $this->dbcache->checkcache('templates_view_' . $tecode, false);
		if (!$chacheview) {
			$rsPuv = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
			$chacheview = $this->dbcache->cachesave('templates_view_' . $tecode, $rsPuv);
			$chacheview = $chacheview ? $chacheview : $rsPuv;
			unset($rsPuv);
		}
		if (!empty($returnname)) {
			return $chacheview[$returnname];
		} else {
			return $chacheview;
		}
	}



	function get_lng_dirpack($lng) {
		if (empty($lng)) {
			return false;
		}
		$db_table = db_prefix . 'lng';
		$db_sql = "SELECT * FROM $db_table WHERE lng = '$lng'";
		$rsPower = $this->db->fetch_first($db_sql);
		if ($rsPower['ispack']) {
			return $rsPower['packname'];
		} else {
			return $rsPower['lng'];
		}
	}






	function get_bbs($bid, $returnname = null) {
		if (empty($bid)) {
			return false;
		}
		$db_table = db_prefix . 'bbs';
		$db_sql = "SELECT * FROM $db_table WHERE bid = $bid ";
		$rsPower = $this->db->fetch_first($db_sql);
		if (!empty($returnname)) {
			return $rsPower[$returnname];
		} else {
			return $rsPower;
		}
	}






	function get_formcontent($fvid, $returnname = null) {
		if (empty($fvid)) {
			return false;
		}
		$db_table = db_prefix . 'form_value';
		$db_sql = "SELECT * FROM $db_table  WHERE fvid = $fvid ";
		$rsPower = $this->db->fetch_first($db_sql);
		if (!empty($returnname)) {
			return $rsPower[$returnname];
		} else {
			return $rsPower;
		}
	}





	function get_powermenulist($out = 'layer') {
		$db_table = db_prefix . 'menulink';
		if ($out == 'all') {
			$sqlTop = "SELECT * FROM $db_table ORDER BY pid DESC,mlid ASC";
		} else {
			$sqlTop = "SELECT * FROM $db_table WHERE topmlid=0 ORDER BY pid DESC,mlid ASC";
		}

		$rsTop = $this->db->query($sqlTop);
		while ($rsTopList = $this->db->fetch_assoc($rsTop)) {
			if ($out == 'layer') {
				$typeid = $rsTopList['mlid'];
				$menulinkarray = array();
				$sql = "SELECT * FROM $db_table WHERE topmlid=$typeid  ORDER BY pid DESC,mlid ASC";
				$rs = $this->db->query($sql);
				while ($rsList = $this->db->fetch_assoc($rs)) {
					$topmlid = $rsList['mlid'];
					$menulink = array();

					$sqlnext = "SELECT * FROM $db_table WHERE topmlid=$topmlid ORDER BY pid DESC,mlid ASC";
					$rsNext = $this->db->query($sqlnext);
					while ($rsNList = $this->db->fetch_assoc($rsNext)) {
						$menulink[] = $rsNList;
					}
					$rsList['linked'] = $menulink;
					$menulinkarray[] = $rsList;
				}
				$rsTopList['menu'] = $menulinkarray;
			}
			$powernenulist[] = $rsTopList;
		}
		return $powernenulist;
	}






	function get_calling_array($cid = 0, $isclass = 1, $lng = 'cn') {
		$db_table = db_prefix . 'calling';
		$db_where.=' WHERE lng=\'' . $lng . '\'';
		if ($isclass > 0) {
			$db_where.=' AND isclass=' . $isclass;
		}
		$sql = 'SELECT cid,lng,pid,type,style,name,code,addtime,isclass FROM ' . $db_table . $db_where . ' ORDER BY pid,cid DESC';
		$chacherray = $this->dbcache->checkcache('calling_array_' . $lng . '_' . $isclass, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('calling_array_' . $lng . '_' . $isclass, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $cid, 'cid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}






	function install_pic($did, $picfile = null, $picname = array(), $filedes = array(), $del = true) {
		if (empty($did)) {
			return false;
		}

		$db_table = db_prefix . 'document_album';
		if ($del) {
			$db_where = "did=$did";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		if (empty($picfile)) {
			return false;
		}

		$picfile = substr($picfile, 0, strlen($picfile) - 1);
		$picArray = explode('|', $picfile);

		$time = time();
		$db_field = 'did,picname,filedes,picfile,addtime';
		$keynow = count($picArray) - 1;
		foreach ($picArray as $key => $value) {
			if ($key == $keynow) {
				$install.="($did,'$picname[$key]','$filedes[$key]','$value',$time)";
			} else {
				$install.="($did,'$picname[$key]','$filedes[$key]','$value',$time),";
			}
		}

		$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES ' . $install . '');
		return true;
	}



	function articlehtml($did, $smilan = '') {
		$smilan = empty($smilan) ? $this->CON['is_lancode'] : $smilan;
		$db_table = db_prefix . 'document';

		$arrayout = array('c' => 0, 's' => null);

		$readinfo = $this->get_document($did);
		if ($readinfo['ishtml'] == 0 || $readinfo['islink'] == 1) return $arrayout;
		if (!empty($readinfo['linkdid'])) {
			$readinfo['linkdid'] = str_replace(',', '/', $readinfo['linkdid']);
		}
		$lng = $readinfo['lng'];
		$lng_templates = ($smilan != $this->CON['is_lancode']) ? $smilan : $lng;
		include admin_ROOT . 'datacache/' . $lng . '_pack.php';
		$this->start_pagetemplate($lng_templates, $LANPACK);

		$readinfo['content'] = html_entity_decode($readinfo['content']);

		$typeview = $this->get_type($readinfo['tid']);

		$exCotnet = explode('<!-- pagebreak -->', $readinfo['content']);
		$filepage = count($exCotnet);
		if (empty($readinfo['filename']) || empty($readinfo['filepath'])) {

			$type_styleid = $typeview['styleid'];

			$type_templates = $typeview['template'];

			$filenamestyle = $typeview['filenamestyle'];

			$readnamestyle = $typeview['readnamestyle'];

			$dirname = $typeview['dirname'];

			$dirpath = $typeview['dirpath'];

			$readfileArray = array('dirname' => $dirname, 'tid' => $readinfo['tid'], 'did' => $did, 'datetime' => date("YmdHis"), 'data' => date("Ymd"), 'y' => date("Y"), 'm' => date("m"), 'd' => date("d"));
			$filename = empty($readinfo['filename']) ? $this->get_htmlfilename($readnamestyle, $readfileArray) : $readinfo['filename'];

			$filepath = empty($readinfo['filepath']) ? $dirpath : $readinfo['filepath'];

			$db_where = 'did=' . $did;
			$db_set = "filename='$filename',filepath='$filepath',filepage=$filepage";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$readinfo['filename'] = $filename;
			$readinfo['filepath'] = $filepath;
		} else {

			if ($filepage != $readinfo['filepage']) {

				$db_where = 'did=' . $did;
				$db_set = "filepage=$filepage";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
			$filename = $readinfo['filename'];
			$filepath = $readinfo['filepath'];
		}
		if ($readinfo['isclass'] == 0 || !$this->CON['is_html'] || $readinfo['isbase']) return $arrayout;

		$read_templates = ($readinfo['istemplates'] && !empty($readinfo['template'])) ? $readinfo['template'] : $typeview['readtemplate'];

		$current = !$typeview['upid'] ? $typeview['tid'] : $typeview['topid'];
		$this->pagetemplate->assign('path', 'article');
		$this->pagetemplate->assign('current', $current);

		$homelink = $this->get_link('home', '', $smilan);
		$this->pagetemplate->assign('homelink', $homelink);
		$readinfo['buylink'] = $this->get_link('buylink', $readinfo, $lng_templates);
		$readinfo['enqlink'] = $this->get_link('enqlink', $readinfo, $lng_templates);

		if (!empty($readinfo['tags'])) {
			$tagArray = explode(',', $readinfo['tags']);
			$tagArray = array_unique($tagArray);
			$newTagArray = array();
			foreach ($tagArray as $key => $value) {
				$newTagArray[$key]['title'] = $value;
				$view = $this->get_tag_view(null, $value, null, true);
				$newTagArray[$key]['link'] = $view['islink'] == 1 ? $view['linkurl'] : $this->get_link('taglink', array('key' => $value), $lng_templates);
			}
		}
		$this->pagetemplate->assign('tag', $newTagArray);



		$htmdirpath = admin_ROOT . $this->CON['file_htmldir'];

		$lngdir = $this->get_lng_dirpack($lng_templates);

		if ($this->CON['is_alonelng']) {
			$docfilepath = $htmdirpath . $filepath;
		} else {
			$docfilepath = $htmdirpath . $lngdir . '/' . $filepath;
		}

		$readfilepath = $docfilepath . '/' . $filename . '.' . $this->CON['file_fileex'];

		if ($this->fun->filemode($htmdirpath)) {

			$creatDIR = pathinfo($readfilepath);
			if (!is_dir($creatDIR['dirname'])) {
				if (!@mkdir($creatDIR['dirname'], 0777, true)) {
					$arrayout = array('c' => 2, 's' => $docfilepath);
					return $arrayout;
				}
			}
		} else {
			$arrayout = array('c' => 3, 's' => $this->CON['file_htmldir']);
			return $arrayout;
		}

		if (!$this->CON['is_alonelng']) {

			$pathurl = admin_URL . $this->CON['file_htmldir'] . $lngdir . '/';
		} else {
			$pathurl = admin_URL . $this->CON['file_htmldir'];
		}

		$this->pagetemplate->assign('pathurl', $pathurl);

		$albumarray = $this->get_album_array($did);

		if (!empty($readinfo['keywords'])) {
			$LANPACK['keyword'] = $readinfo['keywords'];
		}
		if (!empty($readinfo['description'])) {
			$LANPACK['description'] = $readinfo['description'];
		}

		$templatesDIR = $this->get_templatesdir('article');
		if ($templatesDIR) {

			$tpl_filename = $lng . '/' . $templatesDIR . '/' . $read_templates;

			$tpl_file = $this->pagetemplate->tpl_dir . $this->pagetemplate->templatesDIR . $tpl_filename . $this->pagetemplate->templatesfileex;

			if (file_exists($tpl_file)) {
				$this->pagetemplate->caching = false;
				$this->pagetemplate->assign('type', $typeview);

				$this->pagetemplate->assign('lngpack', $LANPACK);
				$this->pagetemplate->assign('photo', $albumarray['list']);

				if ($filepage > 1 && is_array($exCotnet)) {
					$this->pagetemplate->assign('exid', $filepage);
					for ($page = 1; $page <= $filepage; $page++) {

						$pageArray = array();

						$nkey = $page + 1;

						$pkey = $page > 1 ? $page - 1 : 1;

						$readinfo['nlink'] = $nkey <= $filepage ? $this->get_link('doc', $readinfo, $lng_templates, $nkey) : null;

						if ($page == 2) {
							$readinfo['plink'] = $this->get_link('doc', $readinfo, $lng_templates);
						} elseif ($page > 2) {
							$readinfo['plink'] = $this->get_link('doc', $readinfo, $lng_templates, $pkey);
						}

						for ($index = 0; $index < $filepage; $index++) {
							$num = $index + 1;
							$pageArray[$index]['num'] = $num;
							$pageArray[$index]['n'] = $num == $page ? 1 : 0;
							$pageArray[$index]['link'] = $index == 0 ? $this->get_link('doc', $readinfo, $lng_templates) : $this->get_link('doc', $readinfo, $lng_templates, $num);
						}
						$outkey = $page - 1;
						$readinfo['content'] = $exCotnet[$outkey];
						$this->pagetemplate->assign('page', $pageArray);
						$this->pagetemplate->assign('read', $readinfo);
						if ($page > 1) {

							$readfilepath = $docfilepath . '/' . $filename . '_' . $page . '.' . $this->CON['file_fileex'];
						}
						$this->pagetemplate->display($tpl_filename, $dirname . '_read', true, $readfilepath, $lng_templates);
					}


















				} else {
					$this->pagetemplate->assign('read', $readinfo);
					$this->pagetemplate->display($tpl_filename, $dirname . '_read', true, $readfilepath, $lng_templates);
				}
			} else {

				$arrayout = array('c' => 4, 's' => $tpl_file);
			}
		} else {

			$arrayout = array('c' => 1, 's' => $templatesDIR);
		}
		unset($typeview);
		unset($readinfo);
		unset($albumarray);
		unset($LANPACK);
		return $arrayout;
	}




	function get_mailinvite_type_array($mlvid = 0, $lng = 'cn') {
		$db_where = " WHERE lng='$lng'";
		$db_table = db_prefix . 'mailinvite_type';
		$sql = 'SELECT * FROM ' . $db_table . $db_where;
		$chacherray = $this->dbcache->checkcache('mailinvite_type_array_' . $lng, false);
		$arrayList = array();
		if (!$chacherray) {
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$array[] = $rsList;
			}
			$chacherray = $this->dbcache->cachesave('mailinvite_type_array_' . $lng, $array);
			$chacherray = $chacherray ? $chacherray : $array;
			unset($array);
		}
		$chacherray = $this->fun->reset_array($chacherray, $atid, 'mlvid');
		$i = count($chacherray);
		$arrayList['num'] = $i;
		$arrayList['list'] = $chacherray;
		return $arrayList;
	}




	function get_mailinvite_view($mlvid, $returnname = null) {
		if (empty($mlvid)) {
			return false;
		}
		$db_table = db_prefix . 'mailinvite_type';
		$db_sql = "SELECT * FROM $db_table  WHERE mlvid = $mlvid";
		$rsPower = $this->db->fetch_first($db_sql);
		if (!empty($returnname)) {
			return $rsPower[$returnname];
		} else {
			return $rsPower;
		}
	}




	function bbsmailsend($tmcode, $dmid, $email = null) {
		if (empty($tmcode) || empty($dmid)) {
			return false;
		}
		if (!$this->CON['is_email'] || !$this->CON['bbs_ismail'] || empty($tmcode) || empty($dmid)) return false;

		$email = empty($email) ? $this->CON['admine_mail'] : $email;

		$mail = $this->get_tempmail_view($tmcode, 3);
		if (!is_array($mail)) return false;
		$read = $this->get_docmessage_veiw($dmid);
		$read['addtime'] = $this->fun->formatdate($rsList['$read'], 3);
		$reBook = $this->get_documentview($read['did']);
		$read['link'] = $this->get_link('doc', $reBook, admin_LNG, 0, 1);
		$read['title'] = $reBook['title'];

		$nowtime = $this->fun->formatdate(time(), 3);
		$sitename = $this->CON['sitename'];
		$domain = $this->CON['domain'];
		$admine_mail = $this->CON['admine_mail'];
		$mailsendcontent = stripslashes(htmlspecialchars_decode($mail['templatecontent']));
		$mailsendtitle = stripslashes(htmlspecialchars_decode($mail['title']));

		require admin_ROOT . adminfile . '/include/inc_replace_mailtemplates.php';
		$replacemailstr = $replacemail[$mail['typeclass']];
		foreach ($replacemailstr as $key => $vlaue) {

			$mailsendcontent = str_replace($vlaue['title'], $vlaue['content'], $mailsendcontent);
			$mailsendtitle = str_replace($vlaue['title'], $vlaue['content'], $mailsendtitle);
		}
		$sendtype = $this->mailsend($mailsendtitle, $mailsendcontent, $email);
		return $sendtype;
	}




	function enquirymailsend($tmcode, $eid, $email) {
		if (empty($tmcode) || empty($eid) || empty($email)) {
			return false;
		}
		if ($this->CON['is_email'] == 0) return false;

		$mail = $this->get_tempmail_view($tmcode, 3);
		$read = $this->get_enquiry($eid);

		$read['province'] = $this->get_cityview($read['province'], 'cityname');
		$read['city'] = $this->get_cityview($read['city'], 'cityname');
		$read['district'] = $this->get_cityview($read['district'], 'cityname');
		$read['addtime'] = $this->fun->formatdate($read['addtime'], 3);

		$member = $this->get_member(null, $read['userid']);

		$nowtime = $this->fun->formatdate(time(), 3);
		$sitename = $this->CON['sitename'];
		$domain = $this->CON['domain'];
		$admine_mail = $this->CON['admine_mail'];

		$mailsendcontent = stripslashes(htmlspecialchars_decode($mail['templatecontent']));
		$mailsendtitle = stripslashes(htmlspecialchars_decode($mail['title']));

		require admin_ROOT . adminfile . '/include/inc_replace_mailtemplates.php';
		$replacemailstr = $replacemail[$mail['typeclass']];
		foreach ($replacemailstr as $key => $vlaue) {

			$mailsendcontent = str_replace($vlaue['title'], $vlaue['content'], $mailsendcontent);
			$mailsendtitle = str_replace($vlaue['title'], $vlaue['content'], $mailsendtitle);
		}
		$sendtype = $this->mailsend($mailsendtitle, $mailsendcontent, $email);
		return $sendtype;
	}




	function ordermailsend($tmcode, $oid, $email) {
		if (empty($tmcode) || empty($oid) || empty($email)) {
			return false;
		}
		if ($this->CON['is_email'] == 0) return false;

		$mail = $this->get_tempmail_view($tmcode, 3);
		$read = $this->get_order($oid);

		$read['province'] = $this->get_cityview($read['province'], 'cityname');
		$read['city'] = $this->get_cityview($read['city'], 'cityname');
		$read['district'] = $this->get_cityview($read['district'], 'cityname');

		$read['shippingname'] = $this->get_shipplug_view($read['osid'], 'title');

		$read['payname'] = $this->get_payplug_view($read['opid'], 'payname');

		$read['addtime'] = $this->fun->formatdate($read['addtime'], 3);
		$read["paytime"] = $this->fun->formatdate($read['paytime'], 3);
		$read["shippingtime"] = $this->fun->formatdate($read['shippingtime'], 3);

		$member = $this->get_member(null, $read['userid']);

		$nowtime = $this->fun->formatdate(time(), 3);
		$sitename = $this->CON['sitename'];
		$domain = $this->CON['domain'];
		$admine_mail = $this->CON['admine_mail'];

		$mailsendcontent = stripslashes(htmlspecialchars_decode($mail['templatecontent']));
		$mailsendtitle = stripslashes(htmlspecialchars_decode($mail['title']));

		require admin_ROOT . adminfile . '/include/inc_replace_mailtemplates.php';
		$replacemailstr = $replacemail[$mail['typeclass']];
		foreach ($replacemailstr as $key => $vlaue) {

			$mailsendcontent = str_replace($vlaue['title'], $vlaue['content'], $mailsendcontent);
			$mailsendtitle = str_replace($vlaue['title'], $vlaue['content'], $mailsendtitle);
		}
		$sendtype = $this->mailsend($mailsendtitle, $mailsendcontent, $email);
		return $sendtype;
	}





	function formmailsend($tmcode, $fvid, $email) {
		if ($this->CON['is_email'] == 0) return false;
		if (empty($fvid) && empty($tmcode) && empty($email)) {
			return false;
		}

		$read = $this->get_formcontent($fvid);

		$mail = $this->get_tempmail_view($tmcode, 3);

		$form = $this->get_form_purview($read['fgid']);
		$read["formgroupname"] = $form['formgroupname'];
		$read['addtime'] = $this->fun->formatdate($read['addtime'], 3);

		$nowtime = $this->fun->formatdate(time(), 3);
		$sitename = $this->CON['sitename'];
		$domain = $this->CON['domain'];
		$admine_mail = $this->CON['admine_mail'];

		$attrread = $this->get_formatt($read['fgid'], false);
		if (is_array($attrread)) {
			foreach ($attrread as $key => $value) {
				if ($value['isline'] == 1) {
					continue;
				}
				$mailcontent.=$value['typename'] . ":" . stripslashes($read[$value['attrname']]) . '<br>';
			}
		}
		$read['mailcontent'] = $mailcontent;
		$read["recontent"] = stripslashes(htmlspecialchars_decode($read["recontent"]));
		$mailsendcontent = stripslashes(htmlspecialchars_decode($mail['templatecontent']));
		$mailsendtitle = stripslashes(htmlspecialchars_decode($mail['title']));

		require admin_ROOT . adminfile . '/include/inc_replace_mailtemplates.php';
		$replacemailstr = $replacemail[$mail['typeclass']];
		foreach ($replacemailstr as $key => $vlaue) {

			$mailsendcontent = str_replace($vlaue['title'], $vlaue['content'], $mailsendcontent);
			$mailsendtitle = str_replace($vlaue['title'], $vlaue['content'], $mailsendtitle);
		}
		$sendtype = $this->mailsend($mailsendtitle, $mailsendcontent, $email);
		return $sendtype;
	}





	function membermailsend($tmcode, $userid, $newpassword = null) {
		if ($this->CON['is_email'] == 0) return false;
		if (empty($tmcode) || empty($userid)) {
			return false;
		}

		$mail = $this->get_tempmail_view($tmcode, 3);

		$member = $this->get_member(null, $userid);
		if (empty($member['email'])) {
			return false;
		}

		$nowtime = $this->fun->formatdate(time(), 3);
		$sitename = $this->CON['sitename'];
		$domain = $this->CON['domain'];
		$admine_mail = $this->CON['admine_mail'];

		$member['addtime'] = $this->fun->formatdate($member['addtime'], 3);
		$member['rankname'] = $this->get_member_purview($member['mcid'], 'rankname');
		$member['newpassword'] = $newpassword;
		$member['checklink'] = $this->get_link('member_check', $member, admin_LNG, 0, 1);

		$mailsendcontent = stripslashes(htmlspecialchars_decode($mail['templatecontent']));
		$mailsendtitle = stripslashes(htmlspecialchars_decode($mail['title']));

		require admin_ROOT . adminfile . '/include/inc_replace_mailtemplates.php';
		$replacemailstr = $replacemail[$mail['typeclass']];
		foreach ($replacemailstr as $key => $vlaue) {

			$mailsendcontent = str_replace($vlaue['title'], $vlaue['content'], $mailsendcontent);
			$mailsendtitle = str_replace($vlaue['title'], $vlaue['content'], $mailsendtitle);
		}
		$email = $member['email'];
		$sendtype = $this->mailsend($mailsendtitle, $mailsendcontent, $email);
		return $sendtype;
	}




	function forumsendmail($tmcode, $bid, $email) {
		if ($this->CON['is_email'] == 0) return false;
		if (empty($tmcode) || empty($bid) || empty($email)) {
			return false;
		}

		$mail = $this->get_tempmail_view($tmcode, 3);
		$read = $this->get_bbs($bid);

		if ($read['userid'] > 0) {
			$member = $this->get_member(null, $read['userid']);
		}

		$nowtime = $this->fun->formatdate(time(), 3);
		$sitename = $this->CON['sitename'];
		$domain = $this->CON['domain'];
		$admine_mail = $this->CON['admine_mail'];
		$read['addtime'] = $this->fun->formatdate($read['addtime'], 3);
		$read['retime'] = $this->fun->formatdate($read['retime'], 3);

		if (defined('admin_rootDIR')) {
			$read['forumlink'] = $this->get_link('forumread', $read, admin_LNG, 0, 1);
		} else {
			$read['forumlink'] = $this->get_link('forumread', $read, $read['lng'], 0, 1);
		}

		require admin_ROOT . adminfile . '/include/inc_replace_mailtemplates.php';
		$mailsendcontent = stripslashes(htmlspecialchars_decode($mail['templatecontent']));
		$mailsendtitle = stripslashes(htmlspecialchars_decode($mail['title']));
		$replacemailstr = $replacemail[$mail['typeclass']];
		foreach ($replacemailstr as $key => $vlaue) {

			$mailsendcontent = str_replace($vlaue['title'], $vlaue['content'], $mailsendcontent);
			$mailsendtitle = str_replace($vlaue['title'], $vlaue['content'], $mailsendtitle);
		}
		$sendtype = $this->mailsend($mailsendtitle, $mailsendcontent, $email);
		return $sendtype;
	}






	function mailsend($subject, $bodycontent, $email, $type = 1) {
		if ($this->CON['is_email'] == 0) return false;
		if (empty($subject) || empty($email) || empty($bodycontent)) {
			return false;
		}
		if (!preg_match("/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i", $email)) return false;

		if ($this->CON['smtp_type'] == 1) {

















			include_once admin_ROOT . 'public/mail/class.phpmailer.php';
			$mail = new PHPMailer();


			$mail->From = $this->CON['mail_send'];

			$mail->FromName = $this->CON['order_companyname'];

			$mail->Username = $this->CON['smtp_username'];

			$mail->Password = $this->CON['smtp_password'];

			$mail->Host = $this->CON['smtp_server'];

			$mail->CharSet = "UTF-8";

			$mail->SMTPAuth = true;

			$mail->Mailer = "mail";

			$mail->Port = $this->CON['smtp_port'];

			$mail->Subject = $subject;

			$mail->MsgHTML($bodycontent);

			$mail->AddAddress($email);
			if (!@$mail->Send()) {
				return false;
			} else {
				return true;
			}
		} elseif ($this->CON['smtp_type'] == 2) {

			include_once admin_ROOT . 'public/mail/class.phpmailer.php';
			$mail = new PHPMailer();


			$mail->From = $this->CON['mail_send'];

			$mail->FromName = $this->CON['order_companyname'];

			$mail->Username = $this->CON['smtp_username'];

			$mail->Password = $this->CON['smtp_password'];

			$mail->Host = $this->CON['smtp_server'];

			$mail->CharSet = "UTF-8";

			$mail->SMTPAuth = true;

			$mail->Mailer = "smtp";

			$mail->Port = $this->CON['smtp_port'];

			$mail->Subject = $subject;

			$mail->MsgHTML($bodycontent);

			$mail->AddAddress($email);
			if (!@$mail->Send()) {
				return false;
			} else {
				return true;
			}
		} elseif ($this->CON['smtp_type'] == 3) {

			include_once admin_ROOT . 'public/mail/class.phpmailer.php';
			$mail = new PHPMailer();


			$mail->From = $this->CON['mail_send'];

			$mail->FromName = $this->CON['order_companyname'];

			$mail->Username = $this->CON['smtp_username'];

			$mail->Password = $this->CON['smtp_password'];

			$mail->Host = $this->CON['smtp_server'];

			$mail->CharSet = "UTF-8";

			$mail->SMTPAuth = true;

			$mail->Mailer = "sendmail";

			$mail->Port = $this->CON['smtp_port'];

			$mail->Subject = $subject;

			$mail->MsgHTML($bodycontent);

			$mail->AddAddress($email);
			if (!@$mail->Send()) {
				return false;
			} else {
				return true;
			}
		}
	}



	function get_imginfo($imgfilepath) {
		$imagetype = @GetImageSize($imgfilepath);
		$imginfo = array();
		if ($imagetype[2] == 1 || $imagetype[2] == 2 || $imagetype[2] == 3) {
			switch ($imagetype[2]) {
				case 1:
					$im = @ImageCreateFromGIF($imgfilepath);
					break;
				case 2:
					$im = @ImageCreateFromJPEG($imgfilepath);
					break;
				case 3:
					$im = @ImageCreateFromPNG($imgfilepath);
					break;
			}

			if (!$im) {
				$imginfo['picerrid'] = 0;
			} else {
				$imginfo['picerrid'] = 1;
			}

			$srcW = $imagetype[0];
			$imginfo['srcW'] = $imagetype[0];
			$imginfo['srcH'] = $imagetype[1];

			if ($imginfo['srcW'] <= 500) {
				$windowsW = 600;
			} else {
				$windowsW = $imginfo['srcW'] + 70;
				if ($windowsW > 850) {
					$windowsW = 850;
				}
			}

			$windowsH = $imginfo['srcH'] + 300;
			if ($windowsH > 400) {
				$windowsH = 400;
			}
			$imginfo['windowsW'] = $windowsW;
			$imginfo['windowsH'] = $windowsH;

			return $imginfo;
		} else {
			return false;
		}
	}



	function getMimeType($file) {
		return @is_dir($file) ? 'dir' : $this->mime($file);
	}



	function mime($file) {

		$file = realpath($file);

		$options = @pathinfo($file);
		return $options;
	}






	function get_link($module = null, $read = array(), $lng_temp = '', $pagekey = 0, $patyclass = 0) {
		$lng_temp = empty($lng_temp) ? $this->CON['is_lancode'] : $lng_temp;

		$lng_dir = $this->get_lng_dirpack($lng_temp);
		if (empty($module)) return false;

		$is_html = $this->CON['is_html'];

		$is_rewrite = $this->CON['is_rewrite'];

		$file_fileex = $this->CON['file_fileex'];

		$file_htmldir = $this->CON['file_htmldir'];

		$entrance_file = $this->CON['entrance_file'];

		$file_sitemapdir = $this->CON['file_sitemapdir'];

		$typeclass = 1;
		switch ($module) {
			case 'home':
				if (!$is_html) {
					$link = 'index.php';
				}
				break;
			case 'lng':
				if ($is_html) {
					if (!empty($read['url'])) {
						$typeclass = 0;
						$link = $read['url'];
					}
				} else {
					if (!empty($read['url'])) {
						$typeclass = 0;
						$link = $read['url'];
					} else {
						$link = 'index.php';
					}
				}
				break;

			case 'messlist':
				if ($is_rewrite) {

					$link = 'messmain_list_' . $read['did'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=messmain&at=list&did=" . $read['did'];
				}
				break;

			case 'messform':
				if ($is_rewrite) {
					$link = 'messmain_save.' . $file_fileex;
				} else {
					$link = "index.php?ac=messmain&at=save";
				}
				break;

			case 'doc':
				if ($read['islink'] == 1) {
					$typeclass = 0;
					$link = $read['link'];
				} else {
					if ($is_html && $read['ishtml']) {

						if ($pagekey > 0) {
							$link = $read['filepath'] . '/' . $read['filename'] . '_' . $pagekey . '.' . $file_fileex;
						} else {
							$link = $read['filepath'] . '/' . $read['filename'] . '.' . $file_fileex;
						}
					} else {
						if ($is_rewrite) {
							if ($pagekey > 0) {
								$link = 'article_read_' . $read['did'] . '_' . $pagekey . '.' . $file_fileex;
							} else {
								$link = 'article_read_' . $read['did'] . '.' . $file_fileex;
							}
						} else {
							if ($pagekey > 0) {
								$link = "index.php?ac=article&at=read&did=" . $read['did'] . '&page=' . $pagekey;
							} else {
								$link = "index.php?ac=article&at=read&did=" . $read['did'];
							}
						}
					}
				}
				break;

			case 'type':
				if ($read['styleid'] == 3) {

					$typeclass = 0;
					$link = $read['typeurl'];
				} else {
					if ($is_html && $read['pageclass']) {

						$link = $read['dirpath'] . '/';
					} else {
						if ($is_rewrite) {

							$link = 'article_list_' . $read['tid'] . '.' . $file_fileex;
						} else {
							$link = "index.php?ac=article&at=list&tid=" . $read['tid'];
						}
					}
				}
				break;

			case 'typerss':
				if ($read['styleid'] == 3) {
					$link = null;
				} else {
					$link = $file_sitemapdir . 'rss_' . $read['dirname'] . '.xml';
				}
				break;

			case 'subtype':
				if ($is_html) {

					$link = $read['dirpath'] . '/';
				} else {
					if ($is_rewrite) {

						$link = 'special_list_' . $read['sid'] . '.' . $file_fileex;
					} else {
						$link = "index.php?ac=special&at=list&sid=" . $read['sid'];
					}
				}
				break;

			case 'form':
				if ($is_rewrite) {
					$link = 'form_list_' . $read['fgid'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=form&at=list&fgid=" . $read['fgid'];
				}
				break;

			case 'acform':
				$link = "index.php?ac=form&at=save";
				break;

			case 'seccode':
				$typeclass = 0;
				$link = admin_URL . "public/seccode.php";
				break;

			case 'memberlogin':
				if ($is_rewrite) {
					$link = 'member_login.' . $file_fileex;
				} else {
					$link = "index.php?ac=member&at=login";
				}
				break;

			case 'member_check':
				$username = $this->fun->eccode($read['username'], 'ENCODE', db_pscode);
				$password = $this->fun->eccode($read['password'], 'ENCODE', db_pscode);
				$link = "index.php?ac=member&at=emailmarketing&key=" . $username . '&code=' . $password;
				break;

			case 'member_mailsend':
				$username = $this->fun->eccode($read['username'], 'ENCODE', db_pscode);
				$password = $this->fun->eccode($read['password'], 'ENCODE', db_pscode);
				$link = "index.php?ac=member&at=mailsend&key=" . $username . '&code=' . $password;
				break;

			case 'member_ucenter':
				$username = $this->fun->eccode($read['username'], 'ENCODE', db_pscode);
				$password = $this->fun->eccode($read['password'], 'ENCODE', db_pscode);
				$link = "index.php?ac=member&at=uccheckuser&key=" . $username . '&code=' . $password;
				break;

			case 'order':
				if ($is_rewrite) {
					$link = 'order_list.' . $file_fileex;
				} else {
					$link = "index.php?ac=order&at=list";
				}
				break;

			case 'orderread':
				if ($is_rewrite) {
					$link = 'ordermain_read_' . $read['oid'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=ordermain&at=read&oid=" . $read['oid'];
				}
				break;

			case 'orderdel':
				if ($is_rewrite) {
					$link = 'ordermain_del_' . $read['oid'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=ordermain&at=del&oid=" . $read['oid'];
				}
				break;

			case 'buylink':
				if ($is_rewrite) {
					$link = 'order_buy_' . $read['did'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=order&at=buy&did=" . $read['did'];
				}
				break;

			case 'buydel':
				if ($is_rewrite) {
					$link = 'order_delcart_' . $read['did'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=order&at=delcart&did=" . $read['did'];
				}
				break;

			case 'enqlink':
				if ($is_rewrite) {
					$link = 'enquiry_into_' . $read['did'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=enquiry&at=into&did=" . $read['did'];
				}
				break;

			case 'enquiry':
				if ($is_rewrite) {
					$link = 'enquiry_list.' . $file_fileex;
				} else {
					$link = "index.php?ac=enquiry&at=list";
				}
				break;

			case 'enqdel':
				if ($is_rewrite) {
					$link = 'enquiry_delenq_' . $read['did'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=enquiry&at=delenq&did=" . $read['did'];
				}
				break;

			case 'enquiryread':
				if ($is_rewrite) {
					$link = 'enquirymain_read_' . $read['eid'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=enquirymain&at=read&eid=" . $read['eid'];
				}
				break;

			case 'enquirydel':
				if ($is_rewrite) {
					$link = 'enquirymain_del_' . $read['eid'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=enquirymain&at=del&eid=" . $read['eid'];
				}
				break;

			case 'forum':
				if ($is_rewrite) {
					$link = 'forum_list_' . $read['btid'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=forum&at=list&btid=" . $read['btid'];
				}
				break;

			case 'forumadd':
				if ($is_rewrite) {
					$link = 'forum_add_' . $read['btid'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=forum&at=add&btid=" . $read['btid'];
				}
				break;

			case 'forumread':
				if ($is_rewrite) {
					$link = 'forum_read_' . $read['bid'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=forum&at=read&bid=" . $read['bid'];
				}
				break;

			case 'forumedit':
				if ($is_rewrite) {
					$link = 'forummain_edit_' . $read['bid'] . '.' . $file_fileex;
				} else {
					$link = "index.php?ac=forummain&at=edit&bid=" . $read['bid'];
				}
				break;

			case 'paybackurl':
				$link = "index.php?ac=respond&at=payok&codesn=" . $read['codesn'] . "&code=" . $read['code'] . "&ordersn=" . $read['ordersn'] . "&oid=" . $read['oid'];
				break;

			case 'search':
				if ($is_rewrite) {
					$link = 'search_list.' . $file_fileex;
				} else {
					$link = "index.php?ac=search&at=list";
				}
				break;

			case 'bbssearch':
				if ($is_rewrite) {
					$link = 'bbssearch_list.' . $file_fileex;
				} else {
					$link = "index.php?ac=bbssearch&at=list";
				}
				break;
			case 'taglink':
				$link = "index.php?ac=search&at=taglist&tagkey=" . urlencode($read['key']);
				break;

			case 'invite':
				if ($is_rewrite) {
					$link = 'public_invite.' . $file_fileex;
				} else {
					$link = "index.php?ac=public&at=invite";
				}
				break;
		}

		$lngurl = $this->get_lan_view($read['lng'], 'url');
		if ($this->CON['is_alonelng'] && !$is_html) {
			$pathdir = null;
		} elseif ($this->CON['is_alonelng'] && $is_html) {

			$pathdir = ($this->CON['home_lng'] != $lng_temp) ? $file_htmldir . $lng_dir . '/' : $file_htmldir;
		} elseif (!$this->CON['is_alonelng'] && $is_html) {
			$pathdir = $file_htmldir . $lng_dir . '/';
		} elseif (!$this->CON['is_alonelng'] && !$is_html) {
			$pathdir = ($this->CON['home_lng'] != $lng_temp) ? $file_htmldir . $lng_dir . '/' : null;
		}
		$http_pathtype = $patyclass ? 1 : $this->CON['http_pathtype'];

		if ($typeclass) {

			if (defined('admin_rootDIR')) {

				$link = ($http_pathtype && $typeclass) ? (!empty($lngurl) ? $lngurl . '/' . $pathdir . $link : admin_URL . $pathdir . $link) : admin_rootDIR . $pathdir . $link;
			} else {

				$link = ($http_pathtype && $typeclass) ? (!empty($lngurl) ? $lngurl . '/' . $pathdir . $link : admin_URL . $pathdir . $link) : '/' . $pathdir . $link;
			}
		}
		return $link;
	}






	function get_waplink($module = null, $read = array(), $lng_temp = '', $pagekey = 0, $patyclass = 0) {
		$lng_temp = empty($lng_temp) ? $this->CON['is_lancode'] : $lng_temp;

		$lng_dir = $this->get_lng_dirpack($lng_temp);
		if (empty($module)) return false;

		$typeclass = 1;
		switch ($module) {
			case 'home':
				$link = 'index.php?lng=';
				break;
			case 'lng':
				if (!empty($read['url'])) {
					$typeclass = 0;
					$link = $read['url'];
				} else {
					$link = 'index.php?lng=' . $read['lng'];
				}
				break;

			case 'messlist':
				$link = "index.php?ac=messmain&at=list&did=" . $read['did'];
				break;

			case 'messform':
				$link = "index.php?ac=messmain&at=save";
				break;

			case 'doc':
				if ($read['islink'] == 1) {
					$typeclass = 0;
					$link = $read['link'];
				} else {
					if ($pagekey > 0) {
						$link = "index.php?ac=article&at=read&did=" . $read['did'] . '&page=' . $pagekey;
					} else {
						$link = "index.php?ac=article&at=read&did=" . $read['did'];
					}
				}
				break;

			case 'type':
				if ($read['styleid'] == 3) {
					$typeclass = 0;
					$link = $read['typeurl'];
				} else {
					$link = "index.php?ac=article&at=list&tid=" . $read['tid'];
				}
				break;

			case 'subtype':
				$link = "index.php?ac=special&at=list&sid=" . $read['sid'];
				break;

			case 'form':
				$link = "index.php?ac=form&at=list&fgid=" . $read['fgid'];
				break;

			case 'acform':
				$link = "index.php?ac=form&at=save";
				break;

			case 'seccode':
				$link = "public/seccode.php";
				break;

			case 'memberlogin':
				$link = "index.php?ac=member&at=login";
				break;

			case 'member_check':
				$username = $this->fun->eccode($read['username'], 'ENCODE', db_pscode);
				$password = $this->fun->eccode($read['password'], 'ENCODE', db_pscode);
				$link = "index.php?ac=member&at=emailmarketing&key=" . $username . '&code=' . $password;
				break;

			case 'member_mailsend':
				$username = $this->fun->eccode($read['username'], 'ENCODE', db_pscode);
				$password = $this->fun->eccode($read['password'], 'ENCODE', db_pscode);
				$link = "index.php?ac=member&at=mailsend&key=" . $username . '&code=' . $password;
				break;

			case 'member_ucenter':
				$username = $this->fun->eccode($read['username'], 'ENCODE', db_pscode);
				$password = $this->fun->eccode($read['password'], 'ENCODE', db_pscode);
				$link = "index.php?ac=member&at=uccheckuser&key=" . $username . '&code=' . $password;
				break;

			case 'orderread':
				$link = "index.php?ac=ordermain&at=read&oid=" . $read['oid'];
				break;

			case 'orderdel':
				$link = "index.php?ac=ordermain&at=del&oid=" . $read['oid'];
				break;

			case 'enquiryread':
				$link = "index.php?ac=enquirymain&at=read&eid=" . $read['eid'];
				break;

			case 'enquirydel':
				$link = "index.php?ac=enquirymain&at=del&eid=" . $read['eid'];
				break;

			case 'forum':
				$link = "index.php?ac=forum&at=list&btid=" . $read['btid'];
				break;

			case 'forumadd':
				$link = "index.php?ac=forum&at=add&btid=" . $read['btid'];
				break;

			case 'forumread':
				$link = "index.php?ac=forum&at=read&bid=" . $read['bid'];
				break;

			case 'forumedit':
				$link = "index.php?ac=forummain&at=edit&bid=" . $read['bid'];
				break;

			case 'search':
				$link = "index.php?ac=search&at=list";
				break;
			case 'taglink':
				$link = "index.php?ac=search&at=taglist&tagkey=" . urlencode($read['key']);
				break;

			case 'invite':
				$link = "index.php?ac=public&at=invite";
				break;
		}

		$lngurl = $this->get_lan_view($read['lng'], 'url');
		$pathclass = ($this->CON['home_lng'] != $lng_temp) ? '&lng=' . $lng_temp : null;
		$http_pathtype = $this->CON['http_pathtype'];

		if ($typeclass) {

			$link = admin_rootDIR . 'wap/' . $link . $pathclass;
		}
		return $link;
	}

	function memberlink($read = array(), $lng_temp = '') {
		$lng_temp = empty($lng_temp) ? $this->CON['is_lancode'] : $lng_temp;

		$lng_dir = $this->get_lng_dirpack($lng_temp);

		$is_html = $this->CON['is_html'];

		$is_rewrite = $this->CON['is_rewrite'];

		$file_fileex = $this->CON['file_fileex'];

		$file_htmldir = $this->CON['file_htmldir'];

		$entrance_file = $this->CON['entrance_file'];

		if ($is_rewrite) {
			$link['login'] = 'member_login.' . $file_fileex;
			$link['logindb'] = 'member_logindb.' . $file_fileex;
			$link['reg'] = 'member_reg.' . $file_fileex;
			$link['regsave'] = 'member_regsave.' . $file_fileex;
			$link['lostpasswd'] = 'member_lostpasswd.' . $file_fileex;
			$link['lostpasswdsave'] = 'member_lostpasswdsave.' . $file_fileex;
			$link['quit'] = 'member_quit.' . $file_fileex;
			$link['checkusername'] = 'public_checkusername.' . $file_fileex;
			$link['center'] = 'membermain_center.' . $file_fileex;
			$link['memedit_info'] = 'membermain_editinfo.' . $file_fileex;
			$link['memedit_password'] = 'membermain_editpassword.' . $file_fileex;
			$link['memedit_email'] = 'membermain_editemail.' . $file_fileex;

			$link['membersave'] = 'membermain_save.' . $file_fileex;

			$link['orderlist'] = 'ordermain_list_1.' . $file_fileex;

			$link['buylist'] = 'order_list.' . $file_fileex;

			$link['clearcart'] = 'order_clearcart.' . $file_fileex;

			$link['orderupdae'] = 'order_orderupdae.' . $file_fileex;

			$link['orderpay'] = 'order_orderpay.' . $file_fileex;

			$link['ordersave'] = 'order_ordersave.' . $file_fileex;

			$link['ordereditsave'] = 'ordermain_ordereditsave.' . $file_fileex;

			$link['forumlist'] = 'forummain_list_1.' . $file_fileex;

			$link['forumeditsave'] = 'forummain_save.' . $file_fileex;

			$link['forumsave'] = 'forum_save.' . $file_fileex;

			$link['cleargoods'] = 'enquiry_cleargoods.' . $file_fileex;

			$link['enquirysave'] = 'enquiry_enquirysave.' . $file_fileex;

			$link['enquirylist'] = 'enquirymain_list_1.' . $file_fileex;

			$link['enquiryeditsave'] = 'enquirymain_enquiryeditsave.' . $file_fileex;
		} else {
			$link['login'] = "index.php?ac=member&at=login";
			$link['logindb'] = "index.php?ac=member&at=logindb";
			$link['reg'] = "index.php?ac=member&at=reg";
			$link['regsave'] = "index.php?ac=member&at=regsave";
			$link['lostpasswd'] = "index.php?ac=member&at=lostpasswd";
			$link['lostpasswdsave'] = "index.php?ac=member&at=lostpasswdsave";
			$link['quit'] = "index.php?ac=member&at=quit";
			$link['checkusername'] = "index.php?ac=public&at=checkusername";
			$link['center'] = "index.php?ac=membermain&at=center";
			$link['memedit_info'] = "index.php?ac=membermain&at=editinfo";
			$link['memedit_password'] = "index.php?ac=membermain&at=editpassword";
			$link['memedit_email'] = "index.php?ac=membermain&at=editemail";
			$link['membersave'] = "index.php?ac=membermain&at=save";
			$link['orderlist'] = "index.php?ac=ordermain&at=list&al=1";
			$link['buylist'] = "index.php?ac=order&at=list";
			$link['clearcart'] = "index.php?ac=order&at=clearcart";
			$link['orderupdae'] = "index.php?ac=order&at=orderupdae";
			$link['orderpay'] = "index.php?ac=order&at=orderpay";
			$link['ordersave'] = "index.php?ac=order&at=ordersave";
			$link['ordereditsave'] = "index.php?ac=ordermain&at=ordereditsave";
			$link['forumlist'] = "index.php?ac=forummain&at=list";
			$link['forumeditsave'] = "index.php?ac=forummain&at=save";
			$link['forumsave'] = "index.php?ac=forum&at=save";
			$link['cleargoods'] = "index.php?ac=enquiry&at=cleargoods";
			$link['enquirysave'] = "index.php?ac=enquiry&at=enquirysave";
			$link['enquirylist'] = "index.php?ac=enquirymain&at=list&al=1";
			$link['enquiryeditsave'] = "index.php?ac=enquirymain&at=enquiryeditsave";
		}

		$lngurl = $this->get_lan_view($read['lng'], 'url');
		if ($this->CON['is_alonelng'] && !$is_html) {
			$pathdir = null;
		} else {

			$pathdir = ($this->CON['home_lng'] != $lng_temp) ? $file_htmldir . $lng_dir . '/' : null;
		}

		if (defined('admin_rootDIR')) {
			foreach ($link as $key => $value) {
				$link[$key] = ($this->CON['http_pathtype']) ? (!empty($lngurl) ? $lngurl . '/' . $pathdir . $value : admin_URL . $pathdir . $value) : admin_rootDIR . $pathdir . $value;
			}
		} else {
			foreach ($link as $key => $value) {
				$link[$key] = ($this->CON['http_pathtype']) ? (!empty($lngurl) ? $lngurl . '/' . $pathdir . $value : admin_URL . $pathdir . $value) : $pathdir . $value;
			}
		}
		return $link;
	}

}

?>