<?php

/*
 * PHP version 5
 * Copyright (c) 2002-2010 ECISP.CN
 * 声明：这不是一个免费的软件，请在许可范围内使用
 * 作者：Bili E-mail:huangqyun@163.com  QQ:6326420
 * http://www.ecisp.cn		官方网址
 * http://www.easysitepm.com	系统演示网址
 */
error_reporting(0);

ini_set("magic_quotes_runtime", 0);
ini_set('memory_limit', '640M');
define('adminfile', 'public');
define('admin_ClassURL', 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')));
define('admin_URL', str_replace(adminfile, '', admin_ClassURL) . '/');

define('admin_ROOT', substr(__FILE__, 0, strrpos(__FILE__, adminfile)));

define('admin_FROM', true);

define('admin_AGENT', $_SERVER['HTTP_USER_AGENT']);
require_once admin_ROOT . 'datacache/command.php';
require_once admin_ROOT . 'public/class_function.php';
$fun = new functioninc();
$seccode = rand(100000, 999999);
$secode = $fun->accept('secode', 'R');
if ($secode == 'ecisp_seccode') {
	$secode_name = 'ecisp_seccode';
} else {
	$secode_name = 'ecisp_home_seccode';
}
$fun->setcookie($secode_name, $fun->eccode($seccode . "\t" . time(), 'ENCODE'));
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

$code->adulterate = $CONFIG['scode_adulterate'];

$code->ttf = 0;
$code->angle = 0;

$code->color = 0;
$code->size = 1;

$code->shadow = $CONFIG['scode_shadow'];
$code->animator = 0;

$code->bgcolor = $CONFIG['scode_bgcolor'];

$code->fontcolor = $CONFIG['scode_fontcolor'];

$code->datapath = admin_ROOT . 'datacache/';
$code->includepath = '';
$code->display();
?>
