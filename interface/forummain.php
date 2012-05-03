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
		$this->mlink = $this->memberlink(array(), admin_LNG);
	}

	function in_list() {
		parent::start_pagetemplate();
		parent::member_purview(0, $this->mlink['orderlist']);
		include_once admin_ROOT . 'public/class_pagebotton.php';
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;

		$page = $this->fun->accept('page', 'G');
		$page = isset($page) ? intval($page) : 1;

		$pagesylte = 1;

		$pagemax = intval($this->CON['bbs_max_list']);
		$userid = $this->ec_member_username_id;
		if (empty($userid)) {
			$this->callmessage($this->lng['db_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
		}

		$db_table = db_prefix . 'bbs';
		$db_where = " WHERE userid=$userid";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			$numpage = ceil($countnum / $pagemax);
		} else {
			$numpage = 1;
		}
		$sql = "SELECT * FROM $db_table $db_where LIMIT 0,$pagemax";
		$this->htmlpage = new PageBotton($sql, $pagemax, $page, $countnum, $numpage, $pagesylte, $this->CON['file_fileex'], 5, $this->lng['pagebotton'], $this->lng['gopageurl'], $this->CON['is_rewrite']);
		$sql = $this->htmlpage->PageSQL('bid', 'down');
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rsList['edit'] = $this->get_link('forumedit', $rsList, admin_LNG);
			$rsList['link'] = $this->get_link('forumread', $rsList, admin_LNG);
			$array[] = $rsList;
		}

		$templatesDIR = $this->get_templatesdir('member');

		$templatefilename = $lng . '/' . $templatesDIR . '/member_center';
		$this->pagetemplate->assign('out', 'forumlist');
		$this->pagetemplate->assign('mlink', $this->mlink);
		$this->pagetemplate->assign('pagetext', $this->htmlpage->PageStat($this->lng['pagetext']));
		$this->pagetemplate->assign('pagebotton', $this->htmlpage->PageList());
		$this->pagetemplate->assign('pagenu', $this->htmlpage->Bottonstyle(false));
		$this->pagetemplate->assign('pagese', $this->htmlpage->pageSelect());
		$this->pagetemplate->assign('pagevt', $this->htmlpage->Prevbotton());
		$this->pagetemplate->assign('array', $array);
		$this->pagetemplate->assign('path', 'member');
		unset($array, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'member_forumlist', false, '', admin_LNG);
	}

	function in_edit() {
		parent::start_pagetemplate();
		parent::member_purview(0, $this->mlink['orderlist']);
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$bid = $this->fun->accept('bid', 'G');
		if (empty($bid)) {
			$this->callmessage($this->lng['db_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
		}
		$bid = isset($bid) ? intval($bid) : 0;
		$rsList = $this->get_bbs($bid);
		if (!$rsList) exit("Information parameter error!");
		$this->pagetemplate->assign('read', $rsList);
		$this->pagetemplate->assign('mlink', $this->mlink);

		$templatesDIR = $this->get_templatesdir('member');

		$templatefilename = $lng . '/' . $templatesDIR . '/member_center';
		$this->pagetemplate->assign('out', 'forumedit');
		$this->pagetemplate->assign('path', 'member');
		unset($rsList, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'member_forumedit', false, '', admin_LNG);
	}

	function in_save() {
		parent::start_pagetemplate();
		parent::member_purview(0, $this->mlink['orderlist']);
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$linkURL = $_SERVER['HTTP_REFERER'];
		$bid = intval($this->fun->accept('bid', 'P'));
		if (empty($bid)) {
			$this->callmessage($this->lng['db_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
		}
		$db_table = db_prefix . "bbs";
		$title = trim($this->fun->accept('title', 'P', true, true));
		$username = $this->fun->accept('username', 'P');
		$email = trim($this->fun->accept('email', 'P'));
		$content = $this->fun->accept('content', 'P');
		$content = empty($content) ? '' : $this->fun->Text2Html($content, false);
		$userid = intval($this->fun->accept('userid', 'P'));
		if (empty($title)) {
			$this->callmessage($this->lng['forum_title_err'], $linkURL, $this->lng['gobackbotton']);
		}
		if (empty($content) || empty($username)) {
			$this->callmessage($this->lng['forum_input_err'], $linkURL, $this->lng['gobackbotton']);
		}
		if (!preg_match("/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i", $email)) {
			$this->callmessage($this->lng['email_err'], $linkURL, $this->lng['gobackbotton']);
		}
		$qq = $this->fun->accept('qq', 'P');
		$msn = $this->fun->accept('msn', 'P');
		$address = $this->fun->accept('address', 'P');
		$tel = $this->fun->accept('tel', 'P');
		$mobile = $this->fun->accept('mobile', 'P');

		$ipadd = $this->fun->ip($_SERVER['REMOTE_ADDR']);
		$addtime = time();

		if (!empty($this->CON['bbs_filter'])) {
			if ($this->fun->screening_key($content, $this->CON['bbs_filter']) || $this->fun->screening_key($title, $this->CON['bbs_filter'])) {
				$this->callmessage($this->lng['forum_input_filter'], $linkURL, $this->lng['gobackbotton']);
			}
		}
		$db_where = 'bid=' . $bid;
		$db_set = "title='$title',content='$content',username='$username',email='$email',qq='$qq',msn='$msn',address='$address',tel='$tel',mobile='$mobile'";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->callmessage($this->lng['forummain_edit_ok'], $this->mlink['forumlist'], $this->lng['gobackurlbotton']);
	}

}

?>