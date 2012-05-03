<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */
error_reporting(0);

@set_time_limit(1000);
ini_set("magic_quotes_runtime", 0);
date_default_timezone_set('PRC');
ini_set('memory_limit', '640M');
header('Content-type: text/html; charset=utf-8');
define('adminfile', 'install');
define('admin_ClassURL', 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')));
define('admin_URL', str_replace('/' . adminfile, '/', admin_ClassURL));
define('admin_ROOT', substr(__FILE__, 0, strrpos(__FILE__, adminfile)));
define('admin_DIR', pathinfo(__FILE__, PATHINFO_DIRNAME));

require admin_ROOT . 'install/fun_center.php';
require admin_ROOT . 'install/class_db.php';
require admin_ROOT . 'install/lan_inc.php';
require admin_ROOT . 'install/sys_inc.php';
require admin_ROOT . 'public/ectemplates/ectemplates_class.php';
$ectemplates = new Ectemplates();
$ectemplates->tpl_dir = admin_ROOT . 'install/templates/';
$ectemplates->tpl_c_dir = admin_ROOT . 'install/templates_c/';
$ectemplates->cache_dir = admin_ROOT . 'install/templates_c/';
$ectemplates->dbcache_dir = admin_ROOT . 'install/templates_c/';
$ectemplates->caching = false;
$ectemplates->cache_time = 60 * 60 * 24;
$ectemplates->templatesfileex = '.html';
$ectemplates->left_delimiter = '[%';
$ectemplates->right_delimiter = '%]';
$ectemplates->libdir = 'lib_public.php';
$ectemplates->templatesDIR = '';

$step = intval(accept('step', 'R')) ? intval(accept('step', 'R')) : 0;
$ectemplates->assign('step', $step);
$ectemplates->assign('LAN', $LAN);
if ($step == 3) {
	header("Location:../adminsoft/");
}
if (file_exists($installlock)) {
	message($LAN['install_errno_1000'], $LAN['install_errno_1045'], 0, 1);
}

if ($step == 0) {
	$ectemplates->display('step');
} elseif ($step == 1) {
	$ectemplates->assign('cp_items', syscheck($cp_items));
	$ectemplates->assign('dir_items', dircheck($dir_items));
	$ectemplates->assign('func_items', function_check($func_items));
	$ectemplates->display('step');
} elseif ($step == 2) {
	@include CONFIG;
	$dbclass = intval(accept('dbclass', 'R')) ? intval(accept('dbclass', 'R')) : 0;
	if ($dbclass == 0) {
		$ectemplates->assign('domain', admin_URL);
		$ectemplates->display('step');
	} elseif ($dbclass == 1) {
		$dbhost = accept('dbhost', 'R');
		$dbname = accept('dbname', 'R');
		$dbuser = accept('dbuser', 'R');
		$dbpw = accept('dbpw', 'R');
		$tablepre = accept('tablepre', 'R');
		$username = accept('username', 'R');
		$password = accept('password', 'R');
		$password2 = accept('password2', 'R');
		$demodb = accept('demodb', 'R');
		$setupdbtype = accept('setupdbtype', 'R');
		$sitename = accept('sitename', 'R');
		$domain = accept('domain', 'R');
		$admine_mail = accept('admine_mail', 'R');

		$setupcreatsql = "DROP TABLE IF EXISTS esp_admin_member,esp_admin_powergroup,esp_advert,esp_advert_type,esp_album_file,esp_album_images,esp_bbs,esp_bbs_typelist,esp_calling,esp_city,esp_config,esp_document,esp_document_album,esp_document_attr,esp_document_content,esp_document_label,esp_document_message,esp_enquiry,esp_enquiry_info,esp_filename,esp_form_attr,esp_form_group,esp_form_value,esp_keylink,esp_keylink_type,esp_lng,esp_lngpack,esp_logs,esp_mailinvite_list,esp_mailinvite_type,esp_mailsend,esp_mailsend_log,esp_member,esp_member_attr,esp_member_class,esp_member_value,esp_menubotton,esp_menulink,esp_model,esp_model_att,esp_order,esp_order_info,esp_order_pay,esp_order_payreceipt,esp_order_shipping,esp_order_shipreceipt,esp_skin,esp_subjectlist,esp_templates,esp_typelist";
		$setupcreatsql = str_replace(ORIG_TABLEPRE, $tablepre, $setupcreatsql);

		$postlist = $_POST;
		if (empty($dbname)) {

			message($LAN['dbname_invalid'], $LAN['dbnameempay']);
		} else {
			if (!@mysql_connect($dbhost, $dbuser, $dbpw)) {
				$errno = mysql_errno();
				$error = mysql_error();
				if ($errno == 1045) {

					message($LAN['database_errno_1045'], $error);
				} elseif ($errno == 2003) {

					message($LAN['database_errno_2003'], $error);
				} else {
					message($LAN['database_connect_error'], $error);
				}
			}

			if (mysql_get_server_info() > '4.1') {
				mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET " . DBCHARSET);
			} else {
				mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname`");
			}
			if (mysql_errno()) {

				message($LAN['database_errno_1044'], mysql_error());
			}
			mysql_close();
		}
		if (empty($dbname) || empty($password)) {
			message($LAN['dbname_invalid'], $LAN['dbnameempay']);
		}
		$password = md5($password);
		$nowtime = time();

		config_edit($postlist);
		$db = new dbmysq;
		$db->connect($dbhost, $dbuser, $dbpw, $dbname, DBCHARSET);

		$sql = file_get_contents($sqlfile);

		if ($demodb) {
			$sql.=file_get_contents($sqlfile2);
		}
		$sql = str_replace("\r\n", "\n", $sql);
		$sql = str_replace("\r", "\n", str_replace("`" . ORIG_TABLEPRE, "`" . $tablepre, $sql));
		$ret = array();
		$num = 0;
		foreach (explode(";\n", trim($sql)) as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			foreach ($queries as $query) {
				$ret[$num] .= ( isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0] . $query[1] == '--') ? '' : $query;
			}
			$num++;
		}
		unset($sql);

		show_install();

		if ($setupdbtype) {
			$db->query($setupcreatsql);
		}
		foreach ($ret as $query) {
			$query = trim($query);
			if ($query) {
				if (preg_match('/CREATE\s*TABLE\s*IF\s*NOT\s*EXISTS/', $query)) {
					$name = preg_replace("/CREATE\s*TABLE\s*IF\s*NOT\s*EXISTS\s*`([a-zA-Z0-9_\n]+)`.*/is", "\\1", $query);
					$message = "$name 数据结构安装成功";
				} else {
					$name = preg_replace("/INSERT\s*INTO\s*`([a-zA-Z0-9_\n]+)`.*/is", "\\1", $query);
					$message = "$name 数据结构安装成功";
				}
				echo '<script type="text/javascript">showmessage(\'' . addslashes($message) . ' \');</script>' . "\r\n";
				$db->query($query);
			}
		}
		$db->query("INSERT INTO " . $tablepre . "admin_member(username,password,name,sex,intotime,intime,outtime,ipadd,hit,powergroup,inputclassid,isclass) VALUES ('$username','$password','$username',1,$nowtime,$nowtime,$nowtime,0,0,1,1,1)");
		$db->query("UPDATE " . $tablepre . "config SET value='$domain' WHERE valname='domain'");
		$db->query("UPDATE " . $tablepre . "config SET value='$sitename' WHERE valname='sitename'");
		$db->query("UPDATE " . $tablepre . "config SET value='$admine_mail' WHERE valname='admine_mail'");
		if (!file_exists($installlock)) {
			@touch(admin_ROOT . './datacache/install.lock');
		}
		$setupclass = true;
		if ($setupclass) {
			echo '<script type="text/javascript">document.getElementById("laststep").disabled=false;document.getElementById("laststep").value = \'安装成功\';</script>' . "\r\n";
		}
	}
}
?>