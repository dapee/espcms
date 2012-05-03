<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

function daddslashes($string, $force=0, $strip=FALSE) {
	if (!MAGIC_QUOTES_GPC || $force) {
		if (is_array($string)) {
			foreach ($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}

function accept($k, $var='R', $ectype='bu') {
	switch ($var) {
		case 'G':
			$var = &$_GET;
			break;
		case 'P':
			$var = &$_POST;
			break;
		case 'C':
			$var = &$_COOKIE;
			break;
		case 'R':
			$var = &$_REQUEST;
			break;
	}
	$vluer = $var[$k];
	return isset($vluer) ? daddslashes($vluer, 1) : NULL;
}

function message($mess, $btname, $messageid=0, $classbotton=0) {
	require_once admin_ROOT . '/public/ectemplates/ectemplates_class.php';
	$ectemplates = new Ectemplates();
	$ectemplates->tpl_dir = admin_ROOT . '/install/templates/';
	$ectemplates->tpl_c_dir = admin_ROOT . '/install/templates_c/';
	$ectemplates->cache_dir = admin_ROOT . '/install/templates_c/';
	$ectemplates->dbcache_dir = admin_ROOT . '/install/templates_c/';
	$ectemplates->caching = false;
	$ectemplates->cache_time = 60 * 60 * 24;
	$ectemplates->templatesfileex = '.html';
	$ectemplates->left_delimiter = '[%';
	$ectemplates->right_delimiter = '%]';
	$ectemplates->libdir = 'lib_public.php';
	$ectemplates->templatesDIR = '';
	$ectemplates->assign('mess', $mess);
	$ectemplates->assign('btname', $btname);
	$ectemplates->assign('messageid', $messageid);
	$ectemplates->assign('classbotton', $classbotton);
	$ectemplates->display('mess');
	exit;
}

function show_install() {
	require_once admin_ROOT . '/public/ectemplates/ectemplates_class.php';
	$ectemplates = new Ectemplates();
	$ectemplates->tpl_dir = admin_ROOT . '/install/templates/';
	$ectemplates->tpl_c_dir = admin_ROOT . '/install/templates_c/';
	$ectemplates->cache_dir = admin_ROOT . '/install/templates_c/';
	$ectemplates->dbcache_dir = admin_ROOT . '/install/templates_c/';
	$ectemplates->caching = false;
	$ectemplates->cache_time = 60 * 60 * 24;
	$ectemplates->templatesfileex = '.html';
	$ectemplates->left_delimiter = '[%';
	$ectemplates->right_delimiter = '%]';
	$ectemplates->libdir = 'lib_public.php';
	$ectemplates->templatesDIR = '';
	$ectemplates->display('install');
}

function syscheck($items) {
	foreach ($items as $key => $item) {
		if ($item['list'] == 'php') {
			$items[$key]['current'] = PHP_VERSION;
		} elseif ($item['list'] == 'upload') {
			$items[$key]['current'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';
		} elseif ($item['list'] == 'gdversion') {
			$tmp = function_exists('gd_info') ? gd_info() : array();
			$items[$key]['current'] = empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
			unset($tmp);
		} elseif ($item['list'] == 'disk') {
			if (function_exists('disk_free_space')) {
				$items[$key]['current'] = floor(disk_free_space(admin_ROOT) / (1024 * 1024)) . 'M';
			} else {
				$items[$key]['current'] = 'unknow';
			}
		} elseif (isset($item['c'])) {
			$items[$key]['current'] = constant($item['c']);
		}
		$items[$key]['status'] = 1;
		if ($item['r'] != 'notset' && strcmp($items[$key]['current'], $item['r']) < 0) {
			$items[$key]['status'] = 0;
		}
	}
	return $items;
}

function dircheck($diritems) {
	foreach ($diritems as $key => $item) {
		$item_path = $item['path'];
		if ($item['type'] == 'dir') {
			if (!dir_writeable(admin_ROOT . $item_path)) {
				$diritems[$key]['status'] = 0;
				$diritems[$key]['current'] = 0;
			} else {
				$diritems[$key]['status'] = 1;
				$diritems[$key]['current'] = 1;
			}
		} else {
			if (file_exists(admin_ROOT . $item_path)) {
				if (filemode(admin_ROOT . $item_path)) {
					$diritems[$key]['status'] = 1;
				} else {
					$diritems[$key]['status'] = 0;
				}
				$diritems[$key]['current'] = 1;
			} else {
				$diritems[$key]['status'] = 0;
				$diritems[$key]['current'] = 0;
			}
		}
	}
	return $diritems;
}

function filemode($file, $checktype='w') {

	if (!file_exists($file)) {
		return false;
	}
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {

		$testfile = $file . 'writetest.txt';

		if (is_dir($file)) {

			$dir = @opendir($file);

			if ($dir === false) {
				return false;
			}

			if ($checktype == 'r') {
				$mode = (@readdir($dir) != false) ? true : false;
				@closedir($dir);
				return $mode;
			}

			if ($checktype == 'w') {
				$fp = @fopen($testfile, 'wb');
				if ($fp != false) {
					$wp = @fwrite($fp, 'demo');
					$mode = ($wp != false) ? true : false;
					@fclose($fp);
					@unlink($testfile);
					return $mode;
				} else {
					return false;
				}
			}
		} elseif (is_file($file)) {

			if ($checktype == 'r') {
				$fp = @fopen($file, 'rb');
				@fclose($fp);
				$mode = ($fp != false) ? true : false;
				return $mode;
			}

			if ($checktype == 'w') {
				$fp = @fopen($file, 'ab+');
				if ($fp != false) {
					$wp = @fwrite($fp, '');
					$mode = ($wp != false) ? true : false;
					@fclose($fp);
					return $mode;
				} else {
					return false;
				}
			}
		}
	} else {

		if ($checktype == 'r') {
			$fp = @is_readable($file);
			$mode = ($fp) ? true : false;
			return $mode;
		}

		if ($checktype == 'w') {
			$fp = @is_writable($file);
			$mode = ($fp) ? true : false;
			return $mode;
		}
	}
}

function dir_writeable($dir) {
	$writeable = 0;
	if (!is_dir($dir)) {
		@mkdir($dir, 0777);
	}
	if (is_dir($dir)) {
		if ($fp = @fopen("$dir/test.txt", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

function function_check($funcitems) {
	foreach ($funcitems as $key => $item) {
		$funcitemslist[$key]['name'] = $item['name'];
		$funcitemslist[$key]['status'] = function_exists($item['name']);
	}
	return $funcitemslist;
}

function config_edit($postlist) {
	extract($postlist, EXTR_SKIP);
	$pscode = rand('99', '999');
	$db_link = empty($db_link) ? 0 : $db_link;
	$config = "<?php \r\ndefine('db_host', '$dbhost');\r\n";

	$config .= "define('db_user', '$dbuser');\r\n";

	$config .= "define('db_pw', '$dbpw');\r\n";

	$config .= "define('db_name', '$dbname');\r\n";

	$config .= "define('db_charset', '" . DBCHARSET . "');\r\n";

	$config .= "define('db_prefix', '$tablepre');\r\n";
	$config .= "define('db_lan', 'cn');\r\n";

	$config .= "define('db_err', 0);\r\n";

	$config .= "define('db_sql', 0);\r\n";

	$config .= "define('db_link', $db_link);\r\n";

	$config .= "define('headcharset', 'utf-8');\r\n";

	$config .= "define('db_version', '" . SOFT_VERSION . "');\r\n";

	$config .= "define('db_release', '" . SOFT_RELEASE . "');\r\n";

	$config .= "define('db_keycode', '" . db_keycode . "');\r\n";

	$config .= "define('db_pscode', '" . md5(md5($pscode)) . "');\r\n";
	$config .= "define('softtitle', '" . SOFT_TITLE . "');\r\n?>";
	$fp = fopen(CONFIG, 'w');
	fwrite($fp, $config);
	fclose($fp);
}

?>
