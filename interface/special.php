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
		include_once admin_ROOT . 'public/class_pagebotton.php';
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;

		$page = $this->fun->accept('page', 'G');
		$page = isset($page) ? intval($page) : 1;

		$sid = intval($this->fun->accept('sid', 'G'));
		$subread = $this->get_subjectlist_purview($sid);
		if (!$subread['isclass']) {
			exit("Information parameter error!");
		} elseif ($subread['purview'] > 0) {
			parent::member_purview($subread['purview'], null, true);
		}

		if (!empty($subread['keywords'])) {
			$this->lng['keyword'] = $subread['keywords'];
		}
		if (!empty($subread['description'])) {
			$this->lng['description'] = $subread['description'];
		}
		$this->pagetemplate->assign('lngpack', $this->lng);

		$mid = $subread['mid'];
		$modelview = $this->get_modelview($mid);

		$modelname = $modelview['modelname'];

		$pagemax = $modelview['pagemax'];
		$pagemax = empty($subread['pagemax']) ? empty($pagemax) ? 20 : $pagemax  : $subread['pagemax'];

		$pagesylte = $modelview['pagesylte'];

		$styleid = $subread['styleid'];
		$subread['link'] = $this->get_link('subtype', $subread, admin_LNG);
		$this->pagetemplate->assign('sub', $subread);

		$templatesDIR = $this->get_templatesdir('article');

		$list_templatefilename = $lng . '/' . $templatesDIR . '/' . $subread['template'];
		$index_templatefilename = $lng . '/' . $templatesDIR . '/' . $subread['indextemplates'];
		if ($styleid == 1) {
			unset($subread, $modelview, $LANPACK, $this->lng);
			$this->pagetemplate->display($index_templatefilename, $dirname . '_index', false, $filename, admin_LNG);
		} elseif ($styleid == 2) {
			$db_table = db_prefix . 'document';
			$db_where = ' WHERE isclass=1 AND mid=' . $mid . ' AND sid=' . $sid;
			$countnum = $this->db_numrows($db_table, $db_where);
			if ($countnum > 0) {

				$numpage = ceil($countnum / $pagemax);
			} else {
				$numpage = 1;
			}
			$db_table = db_prefix . 'document';
			$sql = "SELECT * FROM $db_table $db_where LIMIT 0,$pagemax";
			$this->htmlpage = new PageBotton($sql, $pagemax, $page, $countnum, $numpage, $pagesylte, $this->CON['file_fileex'], 5, $this->lng['pagebotton'], $this->lng['gopageurl'], $this->CON['is_rewrite']);
			$sql = $this->htmlpage->PageSQL('pid,did', 'down');
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$attarray = array();
				$attarray = $this->get_document_attr($rsList['did']);
				$typeread = $this->get_type($rsList['tid']);
				$rsList['typename'] = $typeread['typename'];
				$rsList['typelink'] = $this->get_link('type', $typeread, admin_LNG);
				$rsList['link'] = $this->get_link('doc', $rsList, admin_LNG);
				$rsList['buylink'] = $this->get_link('buylink', $rsList, admin_LNG);
				$rsList['enqlink'] = $this->get_link('enqlink', $rsList, admin_LNG);
				$rsList['ctitle'] = empty($rsList['color']) ? $rsList['title'] : "<font color='" . $rsList['color'] . "'>" . $rsList['title'] . "</font>";
				$array[] = is_array($attarray) ? array_merge($attarray, $rsList) : $rsList;
			}
			$this->pagetemplate->assign('pagetext', $this->htmlpage->PageStat($this->lng['pagetext']));
			$this->pagetemplate->assign('pagebotton', $this->htmlpage->PageList());
			$this->pagetemplate->assign('pagenu', $this->htmlpage->Bottonstyle(false));
			$this->pagetemplate->assign('pagese', $this->htmlpage->pageSelect());
			$this->pagetemplate->assign('pagevt', $this->htmlpage->Prevbotton());

			$this->pagetemplate->assign('array', $array);
			$this->pagetemplate->assign('path', 'special');
			unset($array, $typeread, $modelview, $LANPACK, $this->lng);
			$this->pagetemplate->display($list_templatefilename, $dirname . '_list', false, $filename, admin_LNG);
		}
	}

}

?>