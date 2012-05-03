<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class mainpage extends connector {

	function mainpage() {
		$this->softbase(false);
	}

	function in_ajaxlist() {
		parent::start_pagetemplate();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$linkURL = $_SERVER['HTTP_REFERER'];

		$did = intval($this->fun->accept('did', 'G'));
		$ismess = intval($this->fun->accept('ismess', 'G'));
		$ismess = empty($ismess) ? 0 : $ismess;
		if (!$did || !$ismess) return false;

		$max = intval($this->fun->accept('max', 'G'));
		$limit = $max ? $max : 5;

		$db_table = db_prefix . 'document_message';
		$db_where = " WHERE isclass=1 AND did=$did";
		$countnum = $this->db_numrows($db_table, $db_where);
		$sql = "SELECT * FROM $db_table $db_where ORDER BY dmid DESC LIMIT 0,$limit";
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$read['did'] = $did;
		$link = $this->get_link('messlist', $read, $lng);
		$messform = $this->get_link('messform', $read, $lng);

		$ec_member_username = $this->member_cookieview('username');
		if ($ec_member_username) {
			$reMem = $this->get_member($ec_member_username);
			$this->pagetemplate->assign('member', $reMem);
		}
		$this->pagetemplate->assign('seccodelink', $this->get_link('seccode'));
		$this->pagetemplate->assign('bbs_isseccode', $this->CON['bbs_isseccode']);
		$this->pagetemplate->assign('link', $link);
		$this->pagetemplate->assign('messform', $messform);
		$this->pagetemplate->assign('array', $array);
		$this->pagetemplate->assign('did', $did);
		$this->pagetemplate->assign('num', $countnum);
		$this->pagetemplate->assign('lng', $lng);
		$this->pagetemplate->assign('lngpack', $LANPACK);

		$templatesDIR = $this->get_templatesdir('forum');
		$templatefilename = $lng . '/' . $templatesDIR . '/message_read_list';
		unset($array, $typeread, $readinfo, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'message_list', false, '', admin_LNG);
	}

	function in_save() {
		parent::start_pagetemplate();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$linkURL = $_SERVER['HTTP_REFERER'];

		if ($this->CON['bbs_isseccode']) {
			$seccode = $this->fun->accept('seccode', 'P');
			include_once admin_ROOT . 'public/class_seccode.php';
			list($new_seccode, $expiration) = explode("\t", $this->fun->eccode($_COOKIE['ecisp_home_seccode'], 'DECODE'));
			$code = new seccode();
			$code->seccodeconvert($new_seccode);
			if ($new_seccode != strtoupper($seccode)) {
				$this->callmessage($this->lng['seescodeerr'], $linkURL, $this->lng['gobackbotton']);
			}
		}
		$db_table = db_prefix . "document_message";

		$did = intval($this->fun->accept('did', 'P'));
		$did = empty($did) ? 0 : $did;

		$userid = intval($this->fun->accept('userid', 'P'));
		$userid = empty($userid) ? 0 : $userid;

		$name = $this->fun->accept('name', 'P');
		$content = $this->fun->accept('content', 'P');
		$content = empty($content) ? '' : $this->fun->Text2Html($content, false);
		if (empty($did)) {
			$this->callmessage($this->lng['db_err'], $linkURL, $this->lng['gobackbotton']);
		}
		if (empty($name) || empty($content)) {
			$this->callmessage($this->lng['forum_input_err'], $linkURL, $this->lng['gobackbotton']);
		}

		$isclass = $this->CON['bbs_isclass'] ? 0 : 1;
		if (!$this->CON['is_anonymous']) {
			parent::member_purview(1);
		}
		$ipadd = $this->fun->ip($_SERVER['REMOTE_ADDR']);
		$addtime = time();

		if (!empty($this->ec_member_username_id)) {

			$rsMember = $this->get_member(null, $this->ec_member_username_id);

			$lockusername = explode(',', $this->CON['bbs_username']);

			if (in_array($this->ec_member_username, $lockusername)) {
				$this->callmessage($this->lng['forum_mem_username'], $_SERVER['HTTP_REFERER'], $this->lng['gobackbotton']);
			}
		}

		if (!empty($this->CON['bbs_filter'])) {
			if ($this->fun->screening_key($content, $this->CON['bbs_filter'])) {
				$this->callmessage($this->lng['forum_input_filter'], $linkURL, $this->lng['gobackbotton']);
			}
		}

		$usersessionid = md5($ipadd + $did . 'input');
		$inputseesion = $this->fun->accept($usersessionid, 'C');

		if (empty($inputseesion) && $this->CON['bbs_inputtime']) {

			$this->fun->setcookie($usersessionid, $addtime, $this->CON['bbs_inputtime']);
		} elseif ($this->CON['bbs_inputtime']) {

			$this->callmessage($this->lng['repeatinput'], $linkURL, $this->lng['gobackurlbotton']);
		}

		$db_field = 'did,userid,adminid,ipadd,lng,name,content,recontent,isreply,isclass,addtime,retime,support,oppose';
		$db_values = "$did,$userid,0,$ipadd,'$lng','$name','$content','',0,$isclass,$addtime,0,0,0";
		$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
		$insert_id = $this->db->insert_id();

		$this->fun->setcookie('ecisp_home_seccode', null);

		if ($this->CON['bbs_ismail']) {
			$this->bbsmailsend('bbsrequest', $insert_id);
		}
		$this->callmessage($this->lng['forum_input_ok'], $linkURL, $this->lng['gobackurlbotton']);
	}

	function in_list() {
		parent::start_pagetemplate();
		include_once admin_ROOT . 'public/class_pagebotton.php';
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;

		$page = $this->fun->accept('page', 'G');
		$page = isset($page) ? intval($page) : 1;
		$pagesylte = 1;

		$pagemax = intval($this->CON['bbs_max_list']);
		$did = intval($this->fun->accept('did', 'G'));
		if (empty($did)) {
			$this->callmessage($this->lng['db_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
		}
		$readinfo = $this->get_documentview($did);
		if (!$readinfo['isclass'] || !$readinfo['ismess']) {
			exit("Information parameter error!");
		} elseif ($readinfo['purview'] > 0) {
			parent::member_purview($readinfo['purview'], null, true);
		}
		$readinfo['link'] = $this->get_link('doc', $readinfo, admin_LNG);
		$this->pagetemplate->assign('read', $readinfo);

		$db_table = db_prefix . 'document_message';
		$db_where = " WHERE isclass=1 AND did=$did";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {

			$numpage = ceil($countnum / $pagemax);
		} else {
			$numpage = 1;
		}
		$sql = "SELECT * FROM $db_table $db_where LIMIT 0,$pagemax";
		$this->htmlpage = new PageBotton($sql, $pagemax, $page, $countnum, $numpage, $pagesylte, $this->CON['file_fileex'], 5, $this->lng['pagebotton'], $this->lng['gopageurl'], $this->CON['is_rewrite']);
		$sql = $this->htmlpage->PageSQL('dmid', 'down');
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$this->pagetemplate->assign('pagetext', $this->htmlpage->PageStat($this->lng['pagetext']));
		$this->pagetemplate->assign('pagebotton', $this->htmlpage->PageList());
		$this->pagetemplate->assign('pagenu', $this->htmlpage->Bottonstyle(false));
		$this->pagetemplate->assign('pagese', $this->htmlpage->pageSelect());
		$this->pagetemplate->assign('pagevt', $this->htmlpage->Prevbotton());
		$typeview = $this->get_type($readinfo['tid']);
		$current = !$typeview['upid'] ? $typeview['tid'] : $typeview['topid'];
		$this->pagetemplate->assign('array', $array);
		$this->pagetemplate->assign('path', 'article');
		$this->pagetemplate->assign('current', $current);
		$this->pagetemplate->assign('did', $did);

		$link = $this->get_link('messlist', $read, $lng);
		$messform = $this->get_link('messform', $read, $lng);

		$ec_member_username = $this->member_cookieview('username');
		if ($ec_member_username) {
			$reMem = $this->get_member($ec_member_username);
			$this->pagetemplate->assign('member', $reMem);
		}
		$this->pagetemplate->assign('seccodelink', $this->get_link('seccode'));
		$this->pagetemplate->assign('bbs_isseccode', $this->CON['bbs_isseccode']);
		$this->pagetemplate->assign('link', $link);
		$this->pagetemplate->assign('messform', $messform);

		$templatesDIR = $this->get_templatesdir('forum');
		$templatefilename = $lng . '/' . $templatesDIR . '/message_list';
		unset($array, $typeread, $readinfo, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'message_list', false, '', admin_LNG);
	}

}

?>