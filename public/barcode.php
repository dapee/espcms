<?php

/*
 * PHP version 5
 * Copyright (c) 2002-2010 ECISP.CN
 * 声明：这不是一个免费的软件，请在许可范围内使用
 * 作者：Bili E-mail:huangqyun@163.com  QQ:6326420
 * http://www.ecisp.cn		官方网址
 * http://www.easysitepm.com	系统演示网址
 * 作用：验证码文件
 */
error_reporting(0);

set_magic_quotes_runtime(0);
ini_set('memory_limit', '640M');
define('adminfile', 'public');
define('admin_ClassURL', 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')));
define('admin_URL', str_replace(adminfile, '', admin_ClassURL) . '/');

define('admin_ROOT', substr(__FILE__, 0, strrpos(__FILE__, adminfile)));

define('admin_FROM', true);

define('admin_AGENT', $_SERVER['HTTP_USER_AGENT']);
require_once admin_ROOT . 'public/class_function.php';
$fun = new functioninc();
require admin_ROOT . 'public/barcode/Color.php';
require admin_ROOT . 'public/barcode/Barcode.php';
require admin_ROOT . 'public/barcode/Drawing.php';
require admin_ROOT . 'public/barcode/Font.php';
require admin_ROOT . 'public/barcode/code128.barcode.php';

$fontname = admin_ROOT . 'public/fonts/en/FetteSteinschrif.ttf';

$text = $fun->accept('text', 'R');
$o = $fun->accept('o', 'R');
$o = empty($o) ? 1 : $o;

$t = $fun->accept('codeheight', 'R');
$t = empty($t) ? 35 : $t;

$r = $fun->accept('codesize', 'R');
$r = empty($r) ? 1 : $r;

$f1 = $fun->accept('f1', 'R');
$f1 = empty($f1) ? $fontname : $f1;

$f2 = $fun->accept('fontsize', 'R');
$f2 = empty($f2) ? 9 : $f2;
$a2 = $fun->accept('a2', 'R');
$a2 = empty($a2) ? 'B' : $a2;

$font = new BCGFont($f1, $f2);
$color_black = new BCGColor(0, 0, 0);
$color_white = new BCGColor(255, 255, 255);
$code_generated = new BCGcode128();
$code_generated->setStart($a2);
$code_generated->setThickness($t);
$code_generated->setScale($r);
$code_generated->setBackgroundColor($color_white);
$code_generated->setForegroundColor($color_black);
$code_generated->setFont($font);
$code_generated->parse($text);
$drawing = new BCGDrawing('', $color_white);
$drawing->setBarcode($code_generated);
$drawing->draw();
$drawing->finish(intval($o));
?>
