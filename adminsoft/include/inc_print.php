<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

$printinc = array(
    0 => (array(title => '收件人-姓名', value => '1', content => $read["consignee"], fontsize => '9pt', face => '宋体', fontwidth => '700', fontstyle => 'italic',)),
    1 => (array(title => '收件人-省', value => '2', content => $read["province"], fontsize => '9pt', face => '宋体', fontwidth => '700', fontstyle => '',)),
    2 => (array(title => '收件人-城市', value => '3', content => $read["city"], fontsize => '9pt', face => '宋体', fontwidth => '700', fontstyle => '',)),
    3 => (array(title => '收件人-区', value => '4', content => $read["district"], fontsize => '9pt', face => '宋体', fontwidth => '700', fontstyle => '',)),
    4 => (array(title => '收件人-地址', value => '5', content => $read["address"], fontsize => '9pt', face => '宋体', fontwidth => '700', fontstyle => '',)),
    5 => (array(title => '收件人-邮编', value => '6', content => $read["zipcode"], fontsize => '9pt', face => '宋体', fontwidth => '700', fontstyle => '',)),
    6 => (array(title => '收件人-电话', value => '7', content => $read["tel"], fontsize => '9pt', face => '宋体', fontwidth => '700', fontstyle => '',)),
    7 => (array(title => '收件人-手机', value => '8', content => $read["mobile"], fontsize => '9pt', face => '宋体', fontwidth => '700', fontstyle => '',)),
    8 => (array(title => '发件人-姓名', value => '9', content => $sread['order_contact'], fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    9 => (array(title => '发件人-省', value => '10', content => $sread['order_province'], fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    10 => (array(title => '发件人-城市', value => '11', content => $sread['order_city'], fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    11 => (array(title => '发件人-地址', value => '12', content => $sread['order_add'], fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    12 => (array(title => '发件人-邮编', value => '13', content => $sread['order_post'], fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    13 => (array(title => '发件人-电话', value => '14', content => $sread['order_tel'], fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    14 => (array(title => '发件人-手机', value => '15', content => $sread['order_moblie'], fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    15 => (array(title => '内件品名', value => '16', content => $title, fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    16 => (array(title => '公司名称', value => '17', content => $sread['order_companyname'], fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    17 => (array(title => '备注信息', value => '18', content => $othercontent, fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    18 => (array(title => '年', value => '19', content => date('Y', time()), fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    19 => (array(title => '月', value => '20', content => date('m', time()), fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    20 => (array(title => '日', value => '21', content => date('d', time()), fontsize => '9pt', face => '宋体', fontwidth => '', fontstyle => '',)),
    21 => (array(title => '√', value => '22', content => '√', fontsize => '9pt', face => '宋体', fontwidth => '700', fontstyle => 'italic',))
);
?>