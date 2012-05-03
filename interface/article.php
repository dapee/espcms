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

		$tid = intval($this->fun->accept('tid', 'G'));
		if (empty($tid)) exit('false');

		$typeread = $this->get_type($tid);
		if (!$typeread['isclass']) {
			exit("Information parameter error!");
		} elseif ($typeread['purview'] > 0) {
			parent::member_purview($typeread['purview'], null, true);
		}

		$current = !$typeread['upid'] ? $typeread['tid'] : $typeread['topid'];
		$this->pagetemplate->assign('path', 'article');
		$this->pagetemplate->assign('current', $current);

		$mid = $typeread['mid'];
		$modelview = $this->get_modelview($mid);

		$modelname = $modelview['modelname'];

		$pagemax = $modelview['pagemax'];
		$pagemax = empty($typeread['pagemax']) ? empty($pagemax) ? 20 : $pagemax  : $typeread['pagemax'];

		$pagesylte = $modelview['pagesylte'];

		$template_list = $typeread['template'];
		$template_index = $typeread['indextemplates'];

		$readtemplate = $typeread['readtemplate'];

		$styleid = $typeread['styleid'];
		$typeread['rsslink'] = $this->get_link('typerss', $typeread, admin_LNG);
		$typeread['typelink'] = $this->get_link('type', $typeread, admin_LNG);
		$this->pagetemplate->assign('type', $typeread);

		if ($styleid != 4) {
			if (!empty($typeread['keywords'])) {
				$this->lng['keyword'] = $typeread['keywords'];
			}
			if (!empty($typeread['description'])) {
				$this->lng['description'] = $typeread['description'];
			}
			$this->pagetemplate->assign('lngpack', $this->lng);
		}

		$templatesDIR = $this->get_templatesdir('article');

		$indextemplatefilename = $lng . '/' . $templatesDIR . '/' . $template_index;

		$listtemplatefilename = $lng . '/' . $templatesDIR . '/' . $template_list;

		$readtemplatefilename = $lng . '/' . $templatesDIR . '/' . $readtemplate;
		if ($styleid == 1) {
			unset($typeread, $modelview, $LANPACK, $this->lng);
			$this->pagetemplate->display($indextemplatefilename, $dirname . '_index', false, $filename, admin_LNG);
		} elseif ($styleid == 2) {
			$db_table = db_prefix . 'document';
			if ($typeread['ispart']) {
				$db_where = ' WHERE isclass=1 AND mid=' . $mid . ' AND ' . $this->get_typeid($tid, 'tid', 0, $mid, 0, $lng) . " OR FIND_IN_SET('$tid',extid)";
			} else {
				$db_where = ' WHERE isclass=1 AND mid=' . $mid . ' AND tid=' . $tid . " OR FIND_IN_SET('$tid',extid)";
			}
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
			unset($array, $typeread, $modelview, $LANPACK, $this->lng);
			$this->pagetemplate->display($listtemplatefilename, $dirname . '_list', false, $filename, admin_LNG);
		} elseif ($styleid == 3) {
			$typeurl = $typeread['typeurl'];
			header("location:$typeurl");
			exit();
		} elseif ($styleid == 4) {
			if ($typeread['linkid']) {
				$readinfo = $this->get_document($typeread['linkid']);
				if ($readinfo['did']) {
					$db_table = db_prefix . 'document';

					$db_where = "isclass=1 AND did=" . $readinfo['did'];
					$db_set = "click=click+1";
					$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
				}

				if (!empty($readinfo['tags'])) {
					$tagArray = explode(',', $readinfo['tags']);
					$tagArray = array_unique($tagArray);
					$newTagArray = array();
					foreach ($tagArray as $key => $value) {
						$newTagArray[$key]['title'] = $value;
						$view = $this->get_tag_view(null, $value, null, true);
						$newTagArray[$key]['link'] = $view['islink'] == 1 ? $view['linkurl'] : $this->get_link('taglink', array('key' => $value), admin_LNG);
					}
				}

				$readinfo['content'] = html_entity_decode($readinfo['content']);
				$exCotnet = explode('<!-- pagebreak -->', $readinfo['content']);
				$filepage = count($exCotnet);

				$pageArray = array();
				if ($filepage > 1) {

					$nkey = $page + 1;

					$pkey = $page > 1 ? $page - 1 : 1;

					$readinfo['nlink'] = $nkey <= $filepage ? $this->get_link('doc', $readinfo, admin_LNG, $nkey) : null;

					$readinfo['plink'] = $page > 1 ? $this->get_link('doc', $readinfo, admin_LNG, $pkey) : null;

					for ($index = 0; $index < $filepage; $index++) {
						$num = $index + 1;
						$pageArray[$index]['num'] = $num;
						$pageArray[$index]['n'] = $num == $page ? 1 : 0;
						$pageArray[$index]['link'] = $this->get_link('doc', $readinfo, admin_LNG, $num);
					}
					$outkey = $page - 1;
					$readinfo['content'] = $exCotnet[$outkey];
				}
				$this->pagetemplate->assign('page', $pageArray);

				if (!empty($readinfo['keywords'])) {
					$this->lng['keyword'] = $readinfo['keywords'];
				}
				if (!empty($readinfo['description'])) {
					$this->lng['description'] = $readinfo['description'];
				}
				$this->pagetemplate->assign('lngpack', $this->lng);
				$this->pagetemplate->assign('tag', $newTagArray);
				$readinfo['buylink'] = $this->get_link('buylink', $readinfo, admin_LNG);
				$readinfo['enqlink'] = $this->get_link('enqlink', $readinfo, admin_LNG);

				if (!empty($readinfo['linkdid'])) {
					$readinfo['linkdid'] = str_replace(',', '/', $readinfo['linkdid']);
				}

				$albumarray = $this->get_album_array($readinfo['did']);

				$this->pagetemplate->assign('read', $readinfo);
				$this->pagetemplate->assign('photo', $albumarray['list']);
			}
			unset($readinfo, $typeread, $modelview, $LANPACK, $this->lng);
			$this->pagetemplate->display($readtemplatefilename, $dirname . '_list', false, $filename, admin_LNG);
		}
	}

	function in_read() {
		$this->start_pagetemplate();
		$lng = (admin_LNG == 'big5') ? $this->CON['is_lancode'] : admin_LNG;
		$did = intval($this->fun->accept('did', 'G'));
		if (empty($did)) {
			$this->callmessage($this->lng['db_err'], $_SERVER['HTTP_REFERER'], $this->lng['gobackurlbotton']);
		}

		$page = intval($this->fun->accept('page', 'G'));
		$page = empty($page) ? 1 : $page;
		$db_table = db_prefix . 'document';

		$readinfo = $this->get_document($did);
		if (!$readinfo['isclass']) {
			exit("Information parameter error!");
		}

		$db_where = "isclass=1 AND did=$did";
		$db_set = "click=click+1";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

		if ($readinfo['islink']) {
			$urladd = $readinfo['link'];
			header("location:$urladd");
			exit();
		}

		if (!empty($readinfo['tags'])) {
			$tagArray = explode(',', $readinfo['tags']);
			$tagArray = array_unique($tagArray);
			$newTagArray = array();
			foreach ($tagArray as $key => $value) {
				$newTagArray[$key]['title'] = $value;
				$view = $this->get_tag_view(null, $value, null, true);
				$newTagArray[$key]['link'] = $view['islink'] == 1 ? $view['linkurl'] : $this->get_link('taglink', array('key' => $value), admin_LNG);
			}
		}

		$readinfo['content'] = html_entity_decode($readinfo['content']);
		$exCotnet = explode('<!-- pagebreak -->', $readinfo['content']);
		$filepage = count($exCotnet);

		$pageArray = array();
		if ($filepage > 1) {

			$nkey = $page + 1;

			$pkey = $page > 1 ? $page - 1 : 1;

			$readinfo['nlink'] = $nkey <= $filepage ? $this->get_link('doc', $readinfo, admin_LNG, $nkey) : null;

			$readinfo['plink'] = $page > 1 ? $this->get_link('doc', $readinfo, admin_LNG, $pkey) : null;

			for ($index = 0; $index < $filepage; $index++) {
				$num = $index + 1;
				$pageArray[$index]['num'] = $num;
				$pageArray[$index]['n'] = $num == $page ? 1 : 0;
				$pageArray[$index]['link'] = $this->get_link('doc', $readinfo, admin_LNG, $num);
			}
			$outkey = $page - 1;
			$readinfo['content'] = $exCotnet[$outkey];
		}
		$this->pagetemplate->assign('page', $pageArray);

		if (!empty($readinfo['keywords'])) {
			$this->lng['keyword'] = $readinfo['keywords'];
		}
		if (!empty($readinfo['description'])) {
			$this->lng['description'] = $readinfo['description'];
		}
		$this->pagetemplate->assign('lngpack', $this->lng);
		$readinfo['buylink'] = $this->get_link('buylink', $readinfo, admin_LNG);
		$readinfo['enqlink'] = $this->get_link('enqlink', $readinfo, admin_LNG);
		$typeview = $this->get_type($readinfo['tid']);
		if (!$typeview['isclass']) {
			exit("Information parameter error!");
		} elseif ($typeview['purview'] > 0) {
			parent::member_purview($typeread['purview'], null, true);
		} elseif ($readinfo['purview'] > 0) {
			parent::member_purview($readinfo['purview'], null, true);
		}
		$typeview['typelink'] = $this->get_link('type', $typeview, admin_LNG);

		$read_templates = ($readinfo['istemplates'] && !empty($readinfo['template'])) ? $readinfo['template'] : $typeview['readtemplate'];
		$dirname = $typeview['dirname'];

		if (!empty($readinfo['linkdid'])) {
			$readinfo['linkdid'] = str_replace(',', '/', $readinfo['linkdid']);
		}

		$albumarray = $this->get_album_array($did);






		$templatesDIR = $this->get_templatesdir('article');

		$templatefilename = $lng . '/' . $templatesDIR . '/' . $read_templates;

		$current = !$typeview['upid'] ? $typeview['tid'] : $typeview['topid'];
		$this->pagetemplate->assign('path', 'article');
		$this->pagetemplate->assign('current', $current);
		$this->pagetemplate->assign('tag', $newTagArray);
		$this->pagetemplate->assign('type', $typeview);
		$this->pagetemplate->assign('read', $readinfo);
		$this->pagetemplate->assign('photo', $albumarray['list']);
		unset($typeview, $readinfo, $albumarray, $LANPACK, $this->lng);
		$this->pagetemplate->display($templatefilename, $dirname . '_read', false, $filename, admin_LNG);
	}

}

?>