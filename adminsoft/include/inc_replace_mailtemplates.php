<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

$replacemail['mailorder'][] = array(name => '收件人', title => '[%consignee%]', content => $read["consignee"]);
$replacemail['mailorder'][] = array(name => '收件E-mail', title => '[%email%]', content => $read["email"]);
$replacemail['mailorder'][] = array(name => '所在省', title => '[%province%]', content => $read['province']);
$replacemail['mailorder'][] = array(name => '所在城市', title => '[%city%]', content => $read['city']);
$replacemail['mailorder'][] = array(name => '所在区域', title => '[%district%]', content => $read['district']);
$replacemail['mailorder'][] = array(name => '收件地址', title => '[%address%]', content => $read["address"]);
$replacemail['mailorder'][] = array(name => '收件邮编', title => '[%zipcode%]', content => $read["zipcode"]);
$replacemail['mailorder'][] = array(name => '收件人手机', title => '[%mobile%]', content => $read["mobile"]);
$replacemail['mailorder'][] = array(name => '收件人电话', title => '[%tel%]', content => $read["tel"]);
$replacemail['mailorder'][] = array(name => '订单编号', title => '[%ordersn%]', content => $read["ordersn"]);
$replacemail['mailorder'][] = array(name => '订单金额', title => '[%orderamount%]', content => $read["orderamount"]);
$replacemail['mailorder'][] = array(name => '订单时间', title => '[%time%]', content => $read["addtime"]);
$replacemail['mailorder'][] = array(name => '订单备注内容', title => '[%content%]', content => $read["content"]);
$replacemail['mailorder'][] = array(name => '付款时间', title => '[%paytime%]', content => $read["paytime"]);
$replacemail['mailorder'][] = array(name => '发货时间', title => '[%shippingtime%]', content => $read["shippingtime"]);
$replacemail['mailorder'][] = array(name => '邮寄费用', title => '[%shippingmoney%]', content => $read["shippingmoney"]);
$replacemail['mailorder'][] = array(name => '支付手续费', title => '[%paymoney%]', content => $read["paymoney"]);
$replacemail['mailorder'][] = array(name => '商品费用', title => '[%productmoney%]', content => $read["productmoney"]);
$replacemail['mailorder'][] = array(name => '折扣', title => '[%discount%]', content => $read["discount"]);
$replacemail['mailorder'][] = array(name => '支付方式名称', title => '[%payname%]', content => $read['payname']);
$replacemail['mailorder'][] = array(name => '发货方式名称', title => '[%shippingname%]', content => $read['shippingname']);
$replacemail['mailorder'][] = array(name => '物流单号', title => '[%shippingsn%]', content => $read["shippingsn"]);
$replacemail['mailorder'][] = array(name => '支付单号', title => '[%paysn%]', content => $read["paysn"]);

$replacemail['mailenquiry'][] = array(name => '询价编号', title => '[%enquirysn%]', content => $read["enquirysn"]);
$replacemail['mailenquiry'][] = array(name => '询价联系人', title => '[%linkman%]', content => $read["linkman"]);
$replacemail['mailenquiry'][] = array(name => 'E-mail', title => '[%email%]', content => $read["email"]);
$replacemail['mailenquiry'][] = array(name => '所在省', title => '[%province%]', content => $read['province']);
$replacemail['mailenquiry'][] = array(name => '所在城市', title => '[%city%]', content => $read['city']);
$replacemail['mailenquiry'][] = array(name => '所在区域', title => '[%district%]', content => $read['district']);
$replacemail['mailenquiry'][] = array(name => '联系人地址', title => '[%address%]', content => $read["address"]);
$replacemail['mailenquiry'][] = array(name => '联系人邮编', title => '[%zipcode%]', content => $read["zipcode"]);
$replacemail['mailenquiry'][] = array(name => '联系人手机', title => '[%mobile%]', content => $read["mobile"]);
$replacemail['mailenquiry'][] = array(name => '联系人电话', title => '[%tel%]', content => $read["tel"]);
$replacemail['mailenquiry'][] = array(name => '询价提交时间', title => '[%entime%]', content => $read["addtime"]);

$replacemail['mailmember'][] = array(name => '会员用户名', title => '[%m_username%]', content => $member["username"]);
$replacemail['mailmember'][] = array(name => '会员E-mail', title => '[%m_email%]', content => $member["email"]);
$replacemail['mailmember'][] = array(name => '密码保护问题', title => '[%question%]', content => $member["question"]);
$replacemail['mailmember'][] = array(name => '密码保护答案', title => '[%answer%]', content => $member["answer"]);
$replacemail['mailmember'][] = array(name => '会员注册时间', title => '[%m_time%]', content => $member["addtime"]);
$replacemail['mailmember'][] = array(name => '激活链接地址', title => '[%checklink%]', content => $member['checklink']);
$replacemail['mailmember'][] = array(name => '会员等级', title => '[%rankname%]', content => $member["rankname"]);
$replacemail['mailmember'][] = array(name => '会员新密码', title => '[%newpassword%]', content => $member['newpassword']);

$replacemail['mailform'][] = array(name => '表单主题', title => '[%formgroupname%]', content => $read["formgroupname"]);
$replacemail['mailform'][] = array(name => '表单内容', title => '[%attrvalue%]', content => $read['mailcontent']);
$replacemail['mailform'][] = array(name => '回复内容', title => '[%recontent%]', content => $read["recontent"]);
$replacemail['mailform'][] = array(name => '表单发布时间', title => '[%f_time%]', content => $read["addtime"]);

$replacemail['mailbbs'][] = array(name => '留言论坛主题', title => '[%b_title%]', content => $read["title"]);
$replacemail['mailbbs'][] = array(name => '留言论坛姓名', title => '[%b_username%]', content => $read["username"]);
$replacemail['mailbbs'][] = array(name => '留言论坛邮箱', title => '[%b_email%]', content => $read["email"]);
$replacemail['mailbbs'][] = array(name => '留言提交时间', title => '[%b_time%]', content => $read["addtime"]);
$replacemail['mailbbs'][] = array(name => '留言回复时间', title => '[%b_retime%]', content => $read["retime"]);
$replacemail['mailbbs'][] = array(name => '留言链接地址', title => '[%forumlink%]', content => $read['forumlink']);

$replacemail['maildocbbs'][] = array(name => '所属内容标题', title => '[%d_title%]', content => $read['title']);
$replacemail['maildocbbs'][] = array(name => '留言发布人', title => '[%d_name%]', content => $read['name']);
$replacemail['maildocbbs'][] = array(name => '留言内容', title => '[%d_content%]', content => $read['content']);
$replacemail['maildocbbs'][] = array(name => '回复内容', title => '[%d_recontent%]', content => $read['recontent']);
$replacemail['maildocbbs'][] = array(name => '内容链接地址', title => '[%d_link%]', content => $read['link']);
$replacemail['maildocbbs'][] = array(name => '留言提交时间', title => '[%d_time%]', content => $read["addtime"]);

$replacemail['mailother'][] = array(name => '当前时间', title => '[%nowtime%]', content => $nowtime);
$replacemail['mailother'][] = array(name => '网站名称', title => '[%sitename%]', content => $sitename);
$replacemail['mailother'][] = array(name => '网站网址', title => '[%domain%]', content => $domain);
$replacemail['mailother'][] = array(name => '管理员邮箱', title => '[%admine_mail%]', content => $admine_mail);
?>