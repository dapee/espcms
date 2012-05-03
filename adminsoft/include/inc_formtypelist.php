<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

$FORMTYPE = array(
    0 => array('key' => 'string', 'name' => '单行文本', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'),
    1 => array('key' => 'text', 'name' => '多行文本', 'class' => 'textarea', 'alter' => 'TEXT', 'varlong' => '250'),
    2 => array('key' => 'editor', 'name' => '编辑器', 'class' => 'textarea', 'alter' => 'TEXT', 'varlong' => '250'),
    3 => array('key' => 'htmltext', 'name' => 'HTML文本', 'class' => 'textarea', 'alter' => 'TEXT', 'varlong' => '250'),
    4 => array('key' => 'int', 'name' => ' 整数类型', 'class' => 'text', 'alter' => 'INT', 'varlong' => '11'),
    5 => array('key' => 'float', 'name' => ' 小数类型', 'class' => 'text', 'alter' => 'FLOAT', 'varlong' => '11'),
    6 => array('key' => 'datetime', 'name' => '时间类型', 'class' => 'text', 'alter' => 'INT', 'varlong' => '11'),
    7 => array('key' => 'img', 'name' => '图片附件', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'),
    8 => array('key' => 'addon', 'name' => '文件附件', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'),
    9 => array('key' => 'video', 'name' => '视频附件', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'),
    10 => array('key' => 'select', 'name' => '下拉框', 'class' => 'select', 'alter' => 'VARCHAR', 'varlong' => '250'),
    11 => array('key' => 'radio', 'name' => '单选框', 'class' => 'radio', 'alter' => 'VARCHAR', 'varlong' => '250'),
    12 => array('key' => 'checkbox', 'name' => '多选框', 'class' => 'checkbox', 'alter' => 'VARCHAR', 'varlong' => '250'),
    13 => array('key' => 'selectinput', 'name' => '复合选项关联输入框', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'),
    14 => array('key' => 'decimal', 'name' => '价格', 'class' => 'text', 'alter' => 'FLOAT', 'varlong' => '50'),
);

$MAILTEMPLATETYPE = array(
    0 => array('key' => 'mailorder', 'name' => 'mailtemplatemain_text_class1'),
    1 => array('key' => 'mailenquiry', 'name' => 'mailtemplatemain_text_class2'),
    2 => array('key' => 'mailmember', 'name' => 'mailtemplatemain_text_class3'),
    3 => array('key' => 'mailform', 'name' => 'mailtemplatemain_text_class4'),
    4 => array('key' => 'mailbbs', 'name' => 'mailtemplatemain_text_class5'),
    5 => array('key' => 'maildocbbs', 'name' => 'mailtemplatemain_text_class6'),
    6 => array('key' => 'mailother', 'name' => 'mailtemplatemain_text_class7'),
);
$CALLTYPE = array(
    0 => array(
	'key' => '1',
	'name' => 'callmain_text_type1',
	'url' => 'http://wp.qq.com/',
    ),
    1 => array(
	'key' => '2',
	'name' => 'callmain_text_type2',
	'url' => 'http://www.taobao.com/wangwang/tese/index.php',
	'style' => array(
	    0 => array('key' => '1', 'name' => '文字+图标样式'),
	    1 => array('key' => '2', 'name' => '图标样式')
	)
    ),
    2 => array(
	'key' => '5',
	'name' => 'callmain_text_type5',
	'url' => 'http://club.china.alibaba.com/club/block/alitalk/alitalkfire.html',
	'style' => array(
	    0 => array('key' => '102', 'name' => '风格1'),
	    1 => array('key' => '101', 'name' => '风格2'),
	    2 => array('key' => '1', 'name' => '风格3'),
	    3 => array('key' => '2', 'name' => '风格4'),
	)
    ),
    3 => array(
	'key' => '3',
	'name' => 'callmain_text_type3',
	'url' => 'http://skype.tom.com/help/skypebuttons/index.html',
	'style' => array(
	    0 => array('key' => '1', 'name' => '风格1'),
	    1 => array('key' => '2', 'name' => '风格2'),
	    2 => array('key' => '3', 'name' => '风格3'),
	    3 => array('key' => '4', 'name' => '风格4'),
	)
    ),
    4 => array(
	'key' => '4',
	'name' => 'callmain_text_type4',
	'url' => 'http://settings.messenger.live.com/applications/CreateHtml.aspx',
	'style' => array(
	    0 => array('key' => '1', 'name' => '风格1'),
	    1 => array('key' => '2', 'name' => '风格2'),
	    2 => array('key' => '3', 'name' => '风格3'),
	    3 => array('key' => '4', 'name' => '风格4'),
	    4 => array('key' => '4', 'name' => '风格5'),
	)
    ),
);

$LANPACKTYPE = array(
    '0' => array('key' => '1', 'name' => '会员'),
    '1' => array('key' => '2', 'name' => '订单\询价'),
    '2' => array('key' => '3', 'name' => '即时通语'),
    '3' => array('key' => '4', 'name' => '留言\订阅\表单'),
    '4' => array('key' => '5', 'name' => '网站基本语言'),
    '5' => array('key' => '6', 'name' => '公共'),
);

$BANNTYPE = array(
    '0' => array('key' => '1', 'name' => '图片广告'),
    '1' => array('key' => '2', 'name' => '动画广告'),
    '2' => array('key' => '3', 'name' => '文字广告'),
);

$TIMELIST = array(
    '0' => array('key' => '0', 'name' => '无时间限制'),
    '1' => array('key' => '60', 'name' => '1分钟'),
    '2' => array('key' => '120', 'name' => '2分钟'),
    '3' => array('key' => '300', 'name' => '5分钟'),
    '4' => array('key' => '600', 'name' => '10分钟'),
    '5' => array('key' => '1800', 'name' => '30分钟'),
    '6' => array('key' => '3600', 'name' => '1小时'),
    '7' => array('key' => '5400', 'name' => '1小时30分'),
    '8' => array('key' => '21600', 'name' => '半天'),
    '9' => array('key' => '86400', 'name' => '1天'),
);
?>
