<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */
define('CONFIG', admin_ROOT . 'datacache/public.php');
define('CHARSET', 'utf-8');
define('DBCHARSET', 'utf8');
define('ORIG_TABLEPRE', 'esp_');
define('SOFT_NAME', 'espcms_v5');
define('SOFT_VERSION', '5.3.12.03.13 UTF8');
define('SOFT_RELEASE', '53120313');
define('db_prefix', 'espcms_');
define('db_lan', 'cn');
define('db_keycode', '587252ED6125A6A88B37C56F451A21A5');
define('SOFT_TITLE', '易思ESPCMS企业网站管理系统 V5');

$sqlfile = admin_ROOT . './install/dbmysql/db.sql';
$sqlfile2 = admin_ROOT . './install/dbmysql/demodb.sql';
$installlock = admin_ROOT . './datacache/install.lock';

$cp_items = array(
    0 => array('name' => '操作系统', 'list' => 'os', 'c' => 'PHP_OS', 'r' => '不限', 'b' => 'Linux'),
    1 => array('name' => 'PHP', 'list' => 'php', 'c' => 'PHP_VERSION', 'r' => '5.2', 'b' => '5.2'),
    2 => array('name' => '上传配置', 'list' => 'upload', 'r' => '不限', 'b' => '5M'),
    3 => array('name' => 'GD库', 'list' => 'gdversion', 'r' => '2.0', 'b' => '2.0'),
    4 => array('name' => '磁盘空间', 'list' => 'disk', 'r' => '10M', 'b' => '不限'),
);

$dir_items = array(
    0 => array('type' => 'file', 'path' => './datacache'),
    1 => array('type' => 'file', 'path' => './upfile'),
    2 => array('type' => 'file', 'path' => './sitemap'),
    3 => array('type' => 'file', 'path' => './html'),
);

$func_items = array(
    0 => array('name' => 'mysql_connect'),
    1 => array('name' => 'fsockopen'),
    2 => array('name' => 'gethostbyname'),
    3 => array('name' => 'file_get_contents'),
    4 => array('name' => 'xml_parser_create'),
    5 => array('name' => 'imagecopymerge'),
    6 => array('name' => 'ImageCreateFromGIF'),
    7 => array('name' => 'ImageCreateFromJPEG'),
    8 => array('name' => 'ImageCreateFromPNG'),
    9 => array('name' => 'imagejpeg'),
    10 => array('name' => 'imagettfbbox'),
);
$dblist = array(
);
?>
