<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */
$CONLIST = array(
    'loglist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=loglist',
	'tabloadtitle' => '操作日志',
	'loadurl' => 'index.php?archive=management&action=loglist&logusername=' . $logusername . '&loguser=' . $this->esp_username,
	'pagecoock' => 'adminmanagementloglistpgid'
    ),
    'mangercenter' => array(
	'tabloadurl' => 'index.php?archive=management&action=home',
	'tabloadtitle' => '网站管理平台',
	'loadurl' => '',
	'pagecoock' => ''
    ),
    'mangerlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=mangerlist',
	'tabloadtitle' => '管理员帐户',
	'loadurl' => 'index.php?archive=management&action=mangerlist&isclass=&inputclassid=&powergroup=',
	'pagecoock' => 'adminmanagementmanagementpgid'
    ),
    'grouplist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=grouplist',
	'tabloadtitle' => '权限组管理',
	'loadurl' => 'index.php?archive=powergroup&action=grouplist&delclass=',
	'pagecoock' => 'admin_powergroup_grouplist_pgid'
    ),
    'sqllist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=sqllist',
	'tabloadtitle' => '数据库管理',
	'loadurl' => 'index.php?archive=sqlmanage&action=sqllist&delclass=',
	'pagecoock' => 'admin_sqlmanage_sqllist_pgid'
    ),
    'syssetting' => array(
	'tabloadurl' => 'index.php?archive=management&action=syssetting&listfunction=syssetting&groupid=' . $groupid,
	'tabloadtitle' => '系统设置',
    ),
    'languagelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=languagelist',
	'tabloadtitle' => '语言站群管理',
	'loadurl' => 'index.php?archive=language&action=languagelist&lockin=&isopen=&isuptype=&limitkey=&limitclass=',
	'pagecoock' => 'languagepgid'
    ),
    'lanpacklist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=lanpacklist&lng=',
	'tabloadtitle' => '语言包管理',
	'loadurl' => 'index.php?archive=languagepack&action=lanpacklist&lockin=&lng=&typeid=&limitkey=&limitclass=',
	'pagecoock' => 'lanpacklistpgid'
    ),
    'callinglist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=callinglist',
	'tabloadtitle' => '即时通客服管理',
	'loadurl' => 'index.php?archive=callmain&action=callinglist&isclass=&limitkey=&limitclass=',
	'pagecoock' => 'callinglistpgid'
    ),
    'seolinklist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=seolinklist&mid=' . $mid . '&tid=' . $tid,
	'tabloadtitle' => 'SEO优化词',
	'loadurl' => 'index.php?archive=seomanage&action=seolinklist&mid=' . $mid . '&tid=' . $tid . '&istop=&isclass=&islink=&limitkey=&limitclass=',
	'pagecoock' => 'seolinklistpgid'
    ),
    'seolinktypelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=seolinktypelist&mid=' . $mid . '&tid=' . $tid,
	'tabloadtitle' => '全网优化词分组',
	'loadurl' => 'index.php?archive=seomanage&action=seolinktypelist&mid=' . $mid . '&tid=' . $tid . '&isclass=&limitkey=&limitclass=',
	'pagecoock' => 'seolinktypelistpgid'
    ),
    'modellist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=modellist',
	'tabloadtitle' => '内容模型管理',
	'loadurl' => 'index.php?archive=modelmanage&action=modellist&isclass=&lockin=&isbase=&istsn=&isalbum=&isextid=&issid=&isfgid=&islinkdid=&limitkey=&limitclass=',
	'pagecoock' => 'modellistpgid'
    ),
    'modelattlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=modelattlist&pagetype=admin_tab_list_page',
	'tabloadtitle' => '模型字段列表',
	'loadurl' => 'index.php?archive=modelmanage&action=modelattlist&mid=' . $mid . '&isclass=&isvalidate=&issearch=&limitkey=&limitclass=',
	'pagecoock' => 'modelattlistpgid'
    ),
    'typelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=typelist&mid=' . $mid . '&isclass=1&pagetype=admin_tab_list_page',
	'tabloadtitle' => '分类管理',
	'loadurl' => 'index.php?archive=typemanage&action=typelist&isclass=&purview=&ismenu=&topid=&mid=' . $mid . '&limitkey=&limitclass=',
	'pagecoock' => 'typelistpgid'
    ),
    'articlelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=articlelist&mid=' . $mid . '&tid=' . $tid,
	'tabloadtitle' => '内容列表',
	'loadurl' => 'index.php?archive=article&action=articlelist&sid=' . $sid . '&mid=' . $mid . '&tid=' . $tid . '&isbase=2&aid=&isclass=&islink=&ishtml=&ismess=&isorder=&purview=&limitkey=&limitclass=&dlid=',
	'pagecoock' => 'articlelistpgid'
    ),
    'modelarticlelist' => array(
	'tabloadurl' => 'index.php?archive=article&action=list&listfunction=modelarticlelist&mid=' . $mid . '&tid=',
	'tabloadtitle' => '内容列表',
	'loadurl' => 'index.php?archive=article&action=articlelist&mid=' . $mid . '&aid=&isclass=&islink=&ishtml=&ismess=&isorder=&purview=&limitkey=&limitclass=&dlid=',
	'pagecoock' => 'mdelarticlelistpgid_' . $mid,
    ),
    'subjectlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=subjectlist&mid=' . $mid . '&isclass=1&pagetype=admin_tab_list_page',
	'tabloadtitle' => '专题品牌管理',
	'loadurl' => 'index.php?archive=subjectmanage&action=subjectlist&isclass=&purview=&ismenu=&iswap=&ishtml=&mid=' . $mid . '&limitkey=&limitclass=',
	'pagecoock' => 'subjectlistpgid'
    ),
    'recomlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=recomlist&mid=' . $mid,
	'tabloadtitle' => '推荐位管理',
	'loadurl' => 'index.php?archive=recommanage&action=recomlist&mid=' . $mid . '&limitkey=&limitclass=',
	'pagecoock' => 'recomlistpgid'
    ),
    'acmessagelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=acmessagelist&did=' . $did,
	'tabloadtitle' => '内容跟贴管理',
	'loadurl' => 'index.php?archive=acmessagemain&action=acmessagelist&did=' . $did . '&isclass=&isreply=&limitkey=&limitclass=',
	'pagecoock' => 'acmessagelistpgid'
    ),
    'memberlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=memberlist&mcid=' . $mcid,
	'tabloadtitle' => '会员列表管理',
	'loadurl' => 'index.php?archive=membermain&action=memberlist&mcid=' . $mcid . '&isclass=&country=&province=&city=&district=&limitkey=&limitclass=',
	'pagecoock' => 'memberlistpgid'
    ),
    'memclasslist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=memclasslist',
	'tabloadtitle' => '会员等级管理',
	'loadurl' => 'index.php?archive=memclassmanage&action=memclasslist&isinter=&isclass=&limitkey=&limitclass=',
	'pagecoock' => 'memclasslistpgid'
    ),
    'memberattlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=memberattlist',
	'tabloadtitle' => '自定义会员字段',
	'loadurl' => 'index.php?archive=memattmanage&action=memberattlist&isline=&isvalidate=&isclass=&limitkey=&limitclass=',
	'pagecoock' => 'memberattlistpgid'
    ),
    'enquirylist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=enquirylist',
	'tabloadtitle' => '客户询价列表',
	'loadurl' => 'index.php?archive=enquirymain&action=list&isclass=&country=&province=&city=&district=&limitkey=&limitclass=',
	'pagecoock' => 'enquirylistpgid'
    ),
    'orderlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=orderlist',
	'tabloadtitle' => '订单列表管理',
	'loadurl' => 'index.php?archive=ordermain&action=orderlist&ispaysn=&isshippingsn=&ordertype=&osid=&opid=&country=&province=&city=&district=&limitkey=&limitclass=',
	'pagecoock' => 'orderlistpgid'
    ),
    'shiplist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=shiplist',
	'tabloadtitle' => '发货方式列表',
	'loadurl' => 'index.php?archive=shipplug&action=shiplist&isclass=&iscash=&limitkey=&limitclass=',
	'pagecoock' => 'shiplistpgid'
    ),
    'paylist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=paylist',
	'tabloadtitle' => '支付方式列表',
	'loadurl' => 'index.php?archive=payplug&action=paylist&isclass=&iscash=&limitkey=&limitclass=',
	'pagecoock' => 'paylistpgid'
    ),
    'payreceiptlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=payreceiptlist',
	'tabloadtitle' => '财务单据管理',
	'loadurl' => 'index.php?archive=payreceipt&action=payreceiptlist&isclass=&oid=&limitkey=&limitclass=',
	'pagecoock' => 'payreceiptlistpgid'
    ),
    'shipreceiptlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=shipreceiptlist',
	'tabloadtitle' => '物流单据列表',
	'loadurl' => 'index.php?archive=shipreceipt&action=shipreceiptlist&isclass=&oid=&limitkey=&limitclass=',
	'pagecoock' => 'shipreceiptlistpgid'
    ),
    'formlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=formlist',
	'tabloadtitle' => '表单列表',
	'loadurl' => 'index.php?archive=formmain&action=formlist&isclass=&ismenu=&isseccode=&iscount=&purview=&isinputtime=&ismail=&limitkey=&limitclass=',
	'pagecoock' => 'formlistpgid'
    ),
    'formattlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=formattlist',
	'tabloadtitle' => '表单字段列表',
	'loadurl' => 'index.php?archive=formmain&action=formattlist&fgid=' . $fgid . '&isclass=&isvalidate=&isline=&limitkey=&limitclass=',
	'pagecoock' => 'formattlistpgid'
    ),
    'messlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=messlist',
	'tabloadtitle' => '消息列表',
	'loadurl' => 'index.php?archive=formmessmain&action=messlist&fgid=' . $fgid . '&isclass=&isreply=&limitkey=&limitclass=',
	'pagecoock' => 'messlistpgid'
    ),
    'skinlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=skinlist',
	'tabloadtitle' => '主题列表',
	'loadurl' => 'index.php?archive=skinmain&action=skinlist&lockin=&limitkey=&limitclass=',
	'pagecoock' => 'skinlistpgid'
    ),
    'templatelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=templatelist&lng=&pagetype=admin_tab_list_page',
	'tabloadtitle' => '模版列表',
	'loadurl' => 'index.php?archive=templatemain&action=templatelist&dirlist=',
	'pagecoock' => 'templatelistpgid'
    ),
    'labelcreat' => array(
	'tabloadurl' => 'index.php?archive=templatemain&action=labelcreat&listfunction=labelcreat',
	'tabloadtitle' => '模板标签生成',
    ),
    'emailtemplatelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=emailtemplatelist&lng=',
	'tabloadtitle' => '邮件模板列表',
	'loadurl' => 'index.php?archive=mailtemplatemain&action=emailtemplatelist&lng=&typeclass=&fileclass=&styleclass=&lockin=&limitkey=&limitclass=',
	'pagecoock' => 'emailtemplatelistpgid'
    ),
    'printlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=printlist&lng=',
	'tabloadtitle' => '物流模板列表',
	'loadurl' => 'index.php?archive=printtemplatemain&action=printlist&lng=&typeclass=&fileclass=&styleclass=&lockin=&limitkey=&limitclass=',
	'pagecoock' => 'printlistpgid'
    ),
    'createindex' => array('tabloadurl' => 'index.php?archive=createmain&action=createindex&tab=false', 'tabloadtitle' => '主页HTML生成', 'loadurl' => '', 'pagecoock' => ''),
    'createtype' => array('tabloadurl' => 'index.php?archive=createmain&action=createtype&tab=false', 'tabloadtitle' => '分类HTML生成', 'loadurl' => '', 'pagecoock' => ''),
    'createdoc' => array('tabloadurl' => 'index.php?archive=createmain&action=createdoc&tab=false', 'tabloadtitle' => '内容HTML生成', 'loadurl' => '', 'pagecoock' => ''),
    'createsubject' => array('tabloadurl' => 'index.php?archive=createmain&action=createsubject&tab=false', 'tabloadtitle' => '专题HTML生成', 'loadurl' => '', 'pagecoock' => ''),
    'batcreate' => array('tabloadurl' => 'index.php?archive=createmain&action=batcreate&tab=false', 'tabloadtitle' => '一键更新网站', 'loadurl' => '', 'pagecoock' => ''),
    'seocreate' => array('tabloadurl' => 'index.php?archive=createseomain&action=createseo&tab=false', 'tabloadtitle' => 'Google地图生成', 'loadurl' => '', 'pagecoock' => ''),
    'createrss' => array('tabloadurl' => 'index.php?archive=createseomain&action=createrss&tab=false', 'tabloadtitle' => 'RSS文档生成', 'loadurl' => '', 'pagecoock' => ''),
    'advertlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=advertlist&atid=' . $atid,
	'tabloadtitle' => '广告轮换管理',
	'loadurl' => 'index.php?archive=advertmain&action=advertlist&atid=' . $atid . '&isclass=&istime=&adtype=&limitkey=&limitclass=',
	'pagecoock' => 'advertlistpgid'
    ),
    'adverttypelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=adverttypelist',
	'tabloadtitle' => '广告位管理',
	'loadurl' => 'index.php?archive=adverttypemain&action=adverttypelist&isclass=&iscode=&limitkey=&limitclass=',
	'pagecoock' => 'adverttypelistpgid'
    ),
    'bbstypelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=bbstypelist',
	'tabloadtitle' => '版块列表',
	'loadurl' => 'index.php?archive=bbstypemain&action=bbstypelist&purview=&isclass=&limitkey=&limitclass=',
	'pagecoock' => 'bbstypelistpgid'
    ),
    'bbsmainlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=bbsmainlist&btid=' . $btid,
	'tabloadtitle' => '留言论坛管理',
	'loadurl' => 'index.php?archive=bbsmain&action=bbsmainlist&btid=' . $btid . '&upbid=' . $upbid . '&isclass=&istop=&noreply=&limitkey=&limitclass=',
	'pagecoock' => 'bbsmainlistpgid'
    ),
    'filelist' => array(
	'loadurl' => 'index.php?archive=filemanage&action=upfile',
	'batupwindow' => 'index.php?archive=filemanage&action=batupfile',
	'picview' => 'index.php?archive=filemanage&action=albumlist',
	'fileview' => 'index.php?archive=filemanage&action=filelist',
	'pagecoock' => 'filelistpgid'
    ),
    'fileadminlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=fileadminlist&pagetype=admin_tab_list_page',
	'tabloadtitle' => '文件管理',
	'loadurl' => 'index.php?archive=filemain&action=fileadminlist',
	'pagecoock' => 'fileadminlistpgid'
    ),
    'albumadminlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=albumadminlist',
	'tabloadtitle' => '相册管理',
	'loadurl' => 'index.php?archive=albummain&action=albumadminlist&isclass=&istop=&limitkey=&limitclass=',
	'pagecoock' => 'albumadminlistpgid'
    ),
    'albumfilelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=albumfilelist&amid=' . $amid,
	'tabloadtitle' => '相册文件管理',
	'loadurl' => 'index.php?archive=albummain&action=albumfilelist&amid=' . $amid . '&limitkey=&limitclass=',
	'pagecoock' => 'albumfilelistpgid'
    ),
    'mailinvitelist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=mailinvitelist',
	'tabloadtitle' => '订阅分类列表',
	'loadurl' => 'index.php?archive=mailinvite&action=mailinvitelist&isclass=&limitkey=&limitclass=',
	'pagecoock' => 'mailinvitelistpgid'
    ),
    'mailinvitesendlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=mailinvitesendlist&mlvid=' . $mlvid,
	'tabloadtitle' => '邮件订阅列表',
	'loadurl' => 'index.php?archive=mailinvite&action=mailinvitesendlist&isclass=&mlvid=' . $mlvid . '&limitkey=&limitclass=',
	'pagecoock' => 'mailinvitesendlistpgid'
    ),
    'mailsendlist' => array(
	'tabloadurl' => 'index.php?archive=management&action=list&listfunction=mailsendlist',
	'tabloadtitle' => '邮件群发管理',
	'loadurl' => 'index.php?archive=mailsendmain&action=mailsendlist&isclass=&limitkey=&limitclass=',
	'pagecoock' => 'mailsendlistpgid'
    ),
);
?>
