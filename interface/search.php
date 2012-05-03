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

	function in_list() {
		parent::start_pagetemplate();

		$lng = $this->fun->accept('lng', 'R');
		$lng = ($lng == 'big5') ? $this->CON['is_lancode'] : $lng;
		$mid = intval($this->fun->accept('mid', 'R'));
		$sid = intval($this->fun->accept('sid', 'R'));
		$keyname = $this->fun->accept('keyname', 'R');

		$att = $this->fun->accept('att', 'R');
		$keyname = empty($keyname) ? 'a.title' : !in_array($keyname, array('title', 'description')) ? 'a.title' : $keyname;
		$keyword = $this->fun->accept('keyword', 'R');
		$tid = intval($this->fun->accept('tid', 'R'));

		if ($mid || $tid || $sid) {
			$db_where = ' WHERE a.isclass=1 AND a.islink=0';
		} else {
			$db_where = ' WHERE a.lng=\'' . $lng . '\' AND a.isclass=1 AND a.islink=0';
		}

		$urlstr = "index.php?ac=search&at=result&lng=$lng";
		if (!empty($mid)) {
			$db_where .=" AND a.mid=$mid";
			$urlstr .= "&mid=$mid";
		}
		if (!empty($sid)) {
			$db_where .=" AND a.sid=$sid";
			$urlstr .= "&sid=$sid";
		}
		if (!empty($tid)) {
			$db_where .=" AND " . $this->get_typeid($tid, 'a.tid', 0, $mid, 0, $lng);
			$urlstr .= "&tid=$tid";
		}

		if (is_array($att) && count($att) > 0) {
			foreach ($att as $key => $value) {
				if ($value) {
					$value = $this->fun->codecon($value, 'bg');
					$db_where .= ' AND b.' . $key . '=\'' . $value . '\'';
					$urlstr .= '&attr[' . $key . ']=' . urlencode($value);
				}
			}
		}


		$urlstr .= "&keyword=" . urlencode($keyword);
		if (!empty($keyword) && empty($keyname)) {
			$keyname = 'title';
			$db_where.=" AND a.title like '%$keyword%'";
		} elseif (!empty($keyword) && !empty($keyname)) {
			$urlstr .= "&keyname=" . $keyname;
			$db_where.=" AND $keyname like '%$keyword%'";
		}
		$sql = "SELECT COUNT(*) AS num FROM " . db_prefix . "document AS a LEFT JOIN " . db_prefix . "document_attr AS b ON a.did=b.did " . $db_where;
		$resulted = $this->db->query($sql);
		$resulted = $this->db->fetch_assoc($resulted);
		$countnum = $resulted['num'];
		if ($countnum > 0) {
			$urlstr .= "&countnum=" . $countnum;
			$linkURL = admin_ClassURL . $urlstr;
			header('location:' . $linkURL);
			exit();
		} else {
			$linkURL = $_SERVER['HTTP_REFERER'];
			$this->callmessage($this->lng['search_list_no'], $linkURL, $this->lng['gobackbotton']);
		}
	}

	function in_result() {

		parent::start_pagetemplate();
		include_once admin_ROOT . 'public/class_pagebotton.php';

		$page = $this->fun->accept('page', 'G');
		$page = isset($page) ? intval($page) : 1;

		$lng = $this->fun->accept('lng', 'R');
		$lng = ($lng == 'big5') ? $this->CON['is_lancode'] : $lng;
		$mid = intval($this->fun->accept('mid', 'R'));
		$sid = intval($this->fun->accept('sid', 'R'));
		$keyname = $this->fun->accept('keyname', 'R');
		$keyname = empty($keyname) ? 'a.title' : !in_array($keyname, array('title', 'description')) ? 'a.title' : $keyname;
		$keyword = $this->fun->substr($this->fun->accept('keyword', 'R'), 40);
		$tid = intval($this->fun->accept('tid', 'R'));
		$countnum = intval($this->fun->accept('countnum', 'R'));
		$countnum = empty($countnum) ? 0 : $countnum;
		$urlcode = $_SERVER['QUERY_STRING'];
		parse_str(html_entity_decode($urlcode), $output);

		if ($mid || $tid || $sid) {
			$db_where = ' WHERE a.isclass=1 AND a.islink=0';
		} else {
			$db_where = ' WHERE a.lng=\'' . $lng . '\' AND a.isclass=1 AND a.islink=0';
		}
		if (!empty($mid)) $db_where .=" AND a.mid=$mid";
		if (!empty($sid)) $db_where .=" AND a.sid=$sid";
		if (!empty($tid)) $db_where .=" AND " . $this->get_typeid($tid, 'a.tid', 0, $mid, 0, $lng);

		if (is_array($output['attr']) && count($output['attr']) > 0) {
			foreach ($output['attr'] as $key => $value) {
				if ($value) {
					$db_where .= ' AND b.' . $key . '=\'' . $value . '\'';
				}
			}
		}
		if (!empty($keyword) && empty($keyname)) {
			$keyname = 'title';
			$db_where.=" AND a.title like '%$keyword%'";
		} elseif (!empty($keyword) && !empty($keyname)) {
			$db_where.=" AND $keyname like '%$keyword%'";
		}
		$pagemax = 15;

		$pagesylte = 1;

		if ($countnum > 0) {

			$numpage = ceil($countnum / $pagemax);
		} else {
			$numpage = 1;
		}
		$sql = "SELECT b.*,a.* FROM " . db_prefix . "document AS a LEFT JOIN " . db_prefix . "document_attr AS b ON a.did=b.did " . $db_where . ' LIMIT 0,' . $pagemax;
		$this->htmlpage = new PageBotton($sql, $pagemax, $page, $countnum, $numpage, $pagesylte, $this->CON['file_fileex'], 5, $this->lng['pagebotton'], $this->lng['gopageurl'], 0);
		$sql = $this->htmlpage->PageSQL('a.did', 'down');
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rsList['typename'] = $this->get_type($rsList['tid'], 'typename');
			$rsList['link'] = $this->get_link('doc', $rsList, admin_LNG);
			$rsList['buylink'] = $this->get_link('buylink', $rsList, admin_LNG);
			$rsList['enqlink'] = $this->get_link('enqlink', $rsList, admin_LNG);
			$rsList['ctitle'] = empty($rsList['color']) ? $rsList['title'] : "<font color='" . $rsList['color'] . "'>" . $rsList['title'] . "</font>";
			$array[] = $rsList;
		}
		$this->pagetemplate->assign('pagetext', $this->htmlpage->PageStat($this->lng['pagetext']));
		$this->pagetemplate->assign('pagebotton', $this->htmlpage->PageList());
		$this->pagetemplate->assign('pagenu', $this->htmlpage->Bottonstyle(false));
		$this->pagetemplate->assign('pagese', $this->htmlpage->pageSelect());
		$this->pagetemplate->assign('pagevt', $this->htmlpage->Prevbotton());
		$this->pagetemplate->assign('array', $array);
		$this->pagetemplate->assign('sql', $sql);
		$this->pagetemplate->assign('path', 'search');
		unset($array, $typeread, $modelview, $LANPACK, $this->lng);

		$templatesDIR = $this->get_templatesdir('article');

		$templatefilename = $lng . '/' . $templatesDIR . '/search';
		$this->pagetemplate->display($templatefilename, 'search', false, $filename, admin_LNG);
	}

	function in_taglist() {
		parent::start_pagetemplate();
		include_once admin_ROOT . 'public/class_pagebotton.php';

		$page = $this->fun->accept('page', 'G');
		$page = isset($page) ? intval($page) : 1;
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$tagkey = urldecode($this->fun->accept('tagkey', 'R'));
		$tagkey = $this->fun->inputcodetrim($tagkey);

		$db_where = ' WHERE lng=\'' . $lng . '\' AND isclass=1';
		if (empty($tagkey)) {
			$linkURL = $_SERVER['HTTP_REFERER'];
			$this->callmessage($this->lng['search_err'], $linkURL, $this->lng['gobackbotton']);
		}
		if (!empty($tagkey)) {
			$db_where.=" AND FIND_IN_SET('$tagkey',tags)";
		}
		$pagemax = 20;

		$pagesylte = 1;

		$templatesDIR = $this->get_templatesdir('article');

		$templatefilename = $lng . '/' . $templatesDIR . '/search';

		$db_table = db_prefix . 'document';
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {

			$numpage = ceil($countnum / $pagemax);
		} else {
			$numpage = 1;
		}
		$sql = "SELECT did,lng,pid,mid,aid,tid,sid,fgid,linkdid,isclass,islink,ishtml,ismess,isorder,purview,recommend,tsn,title,longtitle,
			color,author,source,pic,link,oprice,bprice,click,description,keywords,addtime,template,filename,filepath FROM $db_table $db_where LIMIT 0,$pagemax";
		$this->htmlpage = new PageBotton($sql, $pagemax, $page, $countnum, $numpage, $pagesylte, $this->CON['file_fileex'], 5, $this->lng['pagebotton'], $this->lng['gopageurl'], $this->CON['is_rewrite']);
		$sql = $this->htmlpage->PageSQL('pid,did', 'down');
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rsList['typename'] = $this->get_type($rsList['tid'], 'typename');
			$rsList['link'] = $this->get_link('doc', $rsList, admin_LNG);
			$rsList['buylink'] = $this->get_link('buylink', $rsList, admin_LNG);
			$rsList['enqlink'] = $this->get_link('enqlink', $rsList, admin_LNG);
			$rsList['ctitle'] = empty($rsList['color']) ? $rsList['title'] : "<font color='" . $rsList['color'] . "'>" . $rsList['title'] . "</font>";
			$rsList[$keyname] = str_ireplace($keyword, '<font color="#F00000"><u>' . $keyword . '</u></font>', $rsList[$keyname]);
			$array[] = $rsList;
		}
		$this->pagetemplate->assign('pagetext', $this->htmlpage->PageStat($this->lng['pagetext']));
		$this->pagetemplate->assign('pagebotton', $this->htmlpage->PageList());
		$this->pagetemplate->assign('pagenu', $this->htmlpage->Bottonstyle(false));
		$this->pagetemplate->assign('pagese', $this->htmlpage->pageSelect());
		$this->pagetemplate->assign('pagevt', $this->htmlpage->Prevbotton());

		$this->pagetemplate->assign('array', $array);
		$this->pagetemplate->assign('path', 'search');
		unset($array, $typeread, $modelview, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, 'search', false, $filename, admin_LNG);
	}

}

?>