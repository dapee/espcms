<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class important extends connector {

	function important() {
		$this->softbase(true);
	}

	function oncreateindex() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$file_htmldir = $this->CON['file_htmldir'];

		$file_fileex = $this->CON['file_fileex'];

		$entrance_file = $this->CON['entrance_file'];
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$lnglist = $this->get_lng_array($lng, 1);
		$this->ectemplates->assign('lnglist', $lnglist['list']);

		$lngdir = $this->get_lng_dirpack($lng);
		$path = !$this->CON['is_alonelng'] ? $file_htmldir . $lngdir . '/' . $entrance_file . '.' . $file_fileex : $file_htmldir;

		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('is_alonelng', $this->CON['is_alonelng']);
		$this->ectemplates->assign('home_lng', $lng);
		$this->ectemplates->assign('htmldir', $file_htmldir);
		$this->ectemplates->assign('fileex', $file_fileex);
		$this->ectemplates->assign('entrance', $entrance_file);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('path', $path);
		$this->ectemplates->assign('lngdir', $lngdir);
		$this->ectemplates->display('creat/creat_index');
	}

	function onindexsave() {

		$lng = $this->fun->accept('lng', 'P');
		$lng_templates = $lng;
		$lng = ($lng == 'big5') ? $this->CON['is_lancode'] : $lng;
		if (empty($lng)) exit('false');
		include_once admin_ROOT . 'datacache/' . $lng . '_pack.php';
		$this->start_pagetemplate($lng_templates, $LANPACK);

		$file_fileex = $this->CON['file_fileex'];

		$entrance_file = $this->CON['entrance_file'];
		$entrance_file = empty($entrance_file) ? 'index' : $entrance_file;

		$file_htmldir = $this->CON['file_htmldir'];
		$htmdirpath = admin_ROOT . $file_htmldir;

		$templatesDIR = $this->get_templatesdir('index');

		$templatefilename = $lng . '/' . $templatesDIR . 'index';

		$tpl_file = $this->pagetemplate->tpl_dir . $this->pagetemplate->templatesDIR . $templatefilename . $this->pagetemplate->templatesfileex;
		$this->pagetemplate->assign('path', 'index');

		$lanpackDIR = $this->get_lng_dirpack($lng_templates);

		if ($this->CON['is_alonelng']) {
			$dirpath = $htmdirpath;
			$rt_dirpath = $file_htmldir;

			$filename = $dirpath . $entrance_file . '.' . $file_fileex;

			$rt_dirpath_filename = $rt_dirpath . $entrance_file . '.' . $file_fileex;
		} else {

			$dirpath = $htmdirpath . $lanpackDIR;
			$rt_dirpath = $file_htmldir . $lanpackDIR;

			if ($this->fun->filemode($htmdirpath)) {

				if (!is_dir($dirpath)) {
					if (!@mkdir($dirpath, 0777, true)) {

						exit($rt_dirpath . $this->lng['createmain_creat_no_w']);
					}
				}
			} else {

				exit($file_htmldir . $this->lng['createmain_creat_no_w']);
			}

			$filename = $dirpath . '/' . $entrance_file . '.' . $file_fileex;

			$rt_dirpath_filename = $rt_dirpath . '/' . $entrance_file . '.' . $file_fileex;
		}
		$homefilename = admin_ROOT . $entrance_file . '.' . $file_fileex;
		if (file_exists($tpl_file)) {
			$this->pagetemplate->assign('rt_filepath', $rt_dirpath_filename);
			$this->pagetemplate->display($templatefilename, $dirname . '_index', true, $filename, $lng_templates);
			if ($homefilename != $filename && $lng_templates == $this->CON['home_lng']) {
				$this->pagetemplate->display($templatefilename, $dirname . '_index', true, $homefilename, $lng_templates);
			}
			$outkey = 'true';
		} else {
			$outkey = $rt_dirpath_filename . $this->lng['createmain_creat_no_t'];
		}
		unset($typeread);
		unset($modelview);
		unset($LANPACK);
		exit($outkey);
	}

	function oncreatetype() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;

		$lnglist = $this->get_lng_array($lng, 1);
		$this->ectemplates->assign('lnglist', $lnglist['list']);

		$modelarray = $this->get_model(0, $lng, 1);
		$this->ectemplates->assign('modelarray', $modelarray['list']);

		$this->ectemplates->assign('is_alonelng', $this->CON['is_alonelng']);
		$this->ectemplates->assign('home_lng', $lng);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('creat/creat_type');
	}

	function oncreatewindow() {
		parent::start_template();
		$read['lng'] = $this->fun->accept('lng', 'R');
		$read['mid'] = $this->fun->accept('mid', 'R');
		$read['tid'] = $this->fun->accept('tid', 'R');
		$read['creattype'] = $this->fun->accept('creattype', 'R');
		$read['pnumber'] = $this->fun->accept('pnumber', 'R');
		$read['class'] = $this->fun->accept('class', 'R');
		$read['time'] = time();
		$is_html = $this->CON['is_html'];
		$this->ectemplates->assign('is_html', $is_html);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->display('creat/create_type_window');
	}

	function onstatype() {
		$lng = $this->fun->accept('lng', 'R');
		$lng = ($lng == 'big5') ? $this->CON['is_lancode'] : $lng;
		$mid = $this->fun->accept('mid', 'R');
		$tid = $this->fun->accept('tid', 'R');
		$creattype = $this->fun->accept('creattype', 'R');
		$pnumber = $this->fun->accept('pnumber', 'R');
		$class = $this->fun->accept('class', 'R');
		if (empty($lng) || empty($mid)) {
			exit('false');
		}
		$lanpackfile = admin_ROOT . 'datacache/' . $lng . '_pack.php';
		if (!is_file($lanpackfile)) {

			$this->creat_lanpack($lng, true);
		}

		if ($creattype == 1) {
			$typelist = $this->get_typeid($tid, '', 0, $mid, 0, $lng, 0, 1, 'text');
			if (!empty($typelist)) {
				$typearray = explode(',', $typelist);

				$num = count($typearray);
			} else {
				$num = 0;
			}
		} else {
			$typelist = $tid;
			$num = 1;
		}
		$var = '{"num":"' . $num . '","typelist":"' . $typelist . '","mid":"' . $mid . '","lng":"' . $lng . '"}';
		exit($var);
	}

	function oncreattypesave() {
		include_once admin_ROOT . 'public/class_htmlpage.php';

		$lng = $this->fun->accept('lng', 'P');
		$lng_templates = $lng;
		$lng = ($lng == 'big5') ? $this->CON['is_lancode'] : $lng;
		if (empty($lng)) {
			exit('false');
		}
		include admin_ROOT . 'datacache/' . $lng . '_pack.php';
		$this->start_pagetemplate($lng_templates, $LANPACK);

		$lng_dir = $this->get_lng_dirpack($lng_templates);

		$pnumber = $this->fun->accept('pnumber', 'P');

		$tid = intval($this->fun->accept('tid', 'P'));
		if (empty($tid)) exit('false');
		$typeread = $this->get_type($tid);

		$styleid = $typeread['styleid'];
		if ($styleid == 3) exit('false');

		$current = !$typeread['upid'] ? $typeread['tid'] : $typeread['topid'];
		$this->pagetemplate->assign('path', 'article');
		$this->pagetemplate->assign('current', $current);

		$mid = $this->fun->accept('mid', 'P');
		$modelview = $this->get_modelview($mid);
		$modelname = $modelview['modelname'];

		$pagemax = $modelview['pagemax'];
		$pagemax = empty($typeread['pagemax']) ? empty($pagemax) ? 20 : $pagemax  : $typeread['pagemax'];

		$pagesylte = $modelview['pagesylte'];

		$file_fileex = $this->CON['file_fileex'];

		$entrance_file = $this->CON['entrance_file'];
		$entrance_file = empty($entrance_file) ? 'index' : $entrance_file;

		$file_htmldir = $this->CON['file_htmldir'];
		$htmdirpath = admin_ROOT . $file_htmldir;


		$template_list = $typeread['template'];

		$template_index = $typeread['indextemplates'];

		$readtemplate = $typeread['readtemplate'];
		$typeread['rsslink'] = $this->get_link('typerss', $typeread, $lng_templates);
		$typeread['typelink'] = $this->get_link('type', $typeread, $lng_templates);
		$this->pagetemplate->assign('type', $typeread);

		if ($styleid != 4) {
			if (!empty($typeread['keywords'])) {
				$LANPACK['keyword'] = $typeread['keywords'];
			}
			if (!empty($typeread['description'])) {
				$LANPACK['description'] = $typeread['description'];
			}
			$this->pagetemplate->assign('lngpack', $LANPACK);
		}

		$templatesDIR = $this->get_templatesdir('article');

		$indextemplatefilename = $lng . '/' . $templatesDIR . '/' . $template_index;

		$listtemplatefilename = $lng . '/' . $templatesDIR . '/' . $template_list;

		$readtemplatefilename = $lng . '/' . $templatesDIR . '/' . $readtemplate;

		$filenamestyle = $typeread['filenamestyle'];

		$readnamestyle = $typeread['readnamestyle'];

		$dirname = $typeread['dirname'];

		if ($this->CON['is_alonelng']) {
			$dirpath = $typeread['dirpath'];
		} else {
			$dirpath = $lng_dir . '/' . $typeread['dirpath'];
		}

		$tpl_indexfile = $this->pagetemplate->tpl_dir . $this->pagetemplate->templatesDIR . $indextemplatefilename . $this->pagetemplate->templatesfileex;

		$tpl_listfile = $this->pagetemplate->tpl_dir . $this->pagetemplate->templatesDIR . $listtemplatefilename . $this->pagetemplate->templatesfileex;

		$tpl_readfile = $this->pagetemplate->tpl_dir . $this->pagetemplate->templatesDIR . $readtemplatefilename . $this->pagetemplate->templatesfileex;

		$rt_dirpath = $file_htmldir . $dirpath;

		$creatDir = $htmdirpath . $dirpath;

		if ($this->fun->filemode($htmdirpath)) {

			if (!is_dir($creatDir)) {
				if (!@mkdir($creatDir, 0777, true)) {

					exit($typeread['typename'] . $this->lng['createmain_creat_no'] . '(' . $this->lng['createmain_creat_no_c'] . ')' . $rt_dirpath);
				}
			}
		} else {
			exit($typeread['typename'] . $this->lng['createmain_creat_no'] . '(' . $this->lng['createmain_creat_no_w'] . ')' . $file_htmldir);
		}

		if ($styleid == 1) {


			$filename = $creatDir . '/' . $entrance_file . '.' . $file_fileex;

			$rt_dirpath_filename = $rt_dirpath . '/' . $entrance_file . '.' . $file_fileex;

			if (file_exists($tpl_indexfile)) {
				$this->pagetemplate->display($indextemplatefilename, $dirname . '_index', true, $filename, $lng_templates);
				$outkey = '<b><span class="colorthree">' . $typeread['typename'] . "</span></b> " . $this->lng['createmain_creat_yes'] . $rt_dirpath_filename;
			} else {
				$outkey = '<b>' . $typeread['typename'] . "</b> " . $this->lng['createmain_creat_no_t'] . $indextemplatefilename;
			}
			unset($array, $typeread, $modelview, $LANPACK, $this->lng);
			exit($outkey);
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

				if (!empty($pnumber)) {
					$numpage = $numpage > $pnumber ? $pnumber : $numpage;
				}
			} else {
				$numpage = 1;
			}

			if (file_exists($tpl_listfile)) {
				$db_table = db_prefix . 'document';
				for ($index = 1; $index <= $numpage; $index++) {

					$fileArray = array('dirname' => $dirname, 'tid' => $tid, 'pageid' => $index, 'datetime' => date("YmdHis"), 'data' => date("Ymd"), 'y' => date("Y"), 'm' => date("m"), 'd' => date("d"));

					$filename_str = $this->get_htmlfilename($filenamestyle, $fileArray, 'pageid');
					$sql = "SELECT * FROM $db_table $db_where LIMIT 0,$pagemax";
					$array = array();
					$this->htmlpage = new htmlpage($sql, $pagemax, $index, $countnum, $numpage, $pagesylte, $entrance_file, $file_fileex, 5, $LANPACK['pagebotton'], $LANPACK['gopageurl'], $filename_str);
					$sql = $this->htmlpage->PageSQL('pid,did', 'down');
					$rs = $this->db->query($sql);
					while ($rsList = $this->db->fetch_assoc($rs)) {
						$attarray = array();
						$attarray = $this->get_document_attr($rsList['did']);
						$typeread = $this->get_type($rsList['tid']);
						$rsList['typename'] = $typeread['typename'];
						$rsList['typelink'] = $this->get_link('type', $typeread, $lng_templates);
						$rsList['link'] = $this->get_link('doc', $rsList, $lng_templates);
						$rsList['buylink'] = $this->get_link('buylink', $rsList, $lng_templates);
						$rsList['enqlink'] = $this->get_link('enqlink', $rsList, $lng_templates);
						$rsList['ctitle'] = empty($rsList['color']) ? $rsList['title'] : "<font color='" . $rsList['color'] . "'>" . $rsList['title'] . "</font>";
						$array[] = is_array($attarray) ? array_merge($attarray, $rsList) : $rsList;
					}
					$this->pagetemplate->assign('pagetext', $this->htmlpage->PageStat($LANPACK['pagetext']));
					$this->pagetemplate->assign('pagebotton', $this->htmlpage->PageList());
					$this->pagetemplate->assign('pagenu', $this->htmlpage->Bottonstyle(false));
					$this->pagetemplate->assign('pagese', $this->htmlpage->pageSelect());
					$this->pagetemplate->assign('pagevt', $this->htmlpage->Prevbotton());
					$this->pagetemplate->assign('array', $array);

					$filename_out = $index == 1 ? $entrance_file : $this->get_htmlfilename($filenamestyle, $fileArray);
					$filename = $creatDir . '/' . $filename_out . '.' . $file_fileex;
					$this->pagetemplate->display($listtemplatefilename, $dirname . '_list', true, $filename, $lng_templates);
					unset($array);
				}
				$outkey = '<b><span class="colorthree">' . $typeread['typename'] . "</span></b> " . $this->lng['createmain_creat_yes'] . $rt_dirpath;
			} else {
				$outkey = '<b>' . $typeread['typename'] . "</b> " . $this->lng['createmain_creat_no_t'] . $listtemplatefilename;
			}
			unset($array, $typeread, $modelview, $LANPACK, $this->lng);
			exit($outkey);
		} elseif ($styleid == 4) {

			if ($typeread['linkid']) {
				$readinfo = $this->get_document($typeread['linkid']);

				if (!empty($readinfo['tags'])) {
					$tagArray = explode(',', $readinfo['tags']);
					$tagArray = array_unique($tagArray);
					$newTagArray = array();
					foreach ($tagArray as $key => $value) {
						$newTagArray[$key]['title'] = $value;
						$view = $this->get_tag_view(null, $value, null, true);
						$newTagArray[$key]['link'] = $view['islink'] == 1 ? $view['linkurl'] : $this->get_link('taglink', array('key' => $value), $lng_templates);
					}
				}

				if (file_exists($tpl_readfile)) {

					if (!empty($readinfo['keywords'])) {
						$LANPACK['keyword'] = $readinfo['keywords'];
					}
					if (!empty($readinfo['description'])) {
						$LANPACK['description'] = $readinfo['description'];
					}
					$this->pagetemplate->assign('lngpack', $LANPACK);
					$readinfo['buylink'] = $this->get_link('buylink', $readinfo, $lng_templates);
					$readinfo['enqlink'] = $this->get_link('enqlink', $readinfo, $lng_templates);

					if (!empty($readinfo['linkdid'])) {
						$readinfo['linkdid'] = str_replace(',', '/', $readinfo['linkdid']);
					}

					$albumarray = $this->get_album_array($readinfo['did']);
					$this->pagetemplate->assign('photo', $albumarray['list']);
					$this->pagetemplate->assign('tag', $newTagArray);

					$readinfo['content'] = html_entity_decode($readinfo['content']);
					$exCotnet = explode('<!-- pagebreak -->', $readinfo['content']);
					$filepage = count($exCotnet);
					if ($filepage > 1 && is_array($exCotnet)) {
						for ($page = 1; $page <= $filepage; $page++) {

							$pageArray = array();

							$nkey = $page + 1;

							$pkey = $page > 1 ? $page - 1 : 1;

							$readinfo['nlink'] = $nkey <= $filepage ? $this->get_link('doc', $readinfo, $lng_templates, $nkey) : null;

							if ($page == 2) {
								$readinfo['plink'] = $typeread['typelink'];
							} elseif ($page > 2) {
								$readinfo['plink'] = $this->get_link('doc', $readinfo, $lng_templates, $pkey);
							}

							for ($index = 0; $index < $filepage; $index++) {
								$num = $index + 1;
								$pageArray[$index]['num'] = $num;
								$pageArray[$index]['n'] = $num == $page ? 1 : 0;
								$pageArray[$index]['link'] = $index == 0 ? $typeread['typelink'] : $this->get_link('doc', $readinfo, $lng_templates, $num);
							}
							$outkey = $page - 1;
							$readinfo['content'] = $exCotnet[$outkey];
							$this->pagetemplate->assign('page', $pageArray);
							$this->pagetemplate->assign('read', $readinfo);
							if ($page == 1) {

								$filename = $creatDir . '/' . $entrance_file . '.' . $file_fileex;
							} else {

								$filename = $creatDir . '/' . $readinfo['filename'] . '_' . $page . '.' . $file_fileex;
							}
							$this->pagetemplate->assign('read', $readinfo);
							$this->pagetemplate->display($readtemplatefilename, $dirname . '_list', true, $filename, $lng_templates);
						}
					} else {
						$filename = $creatDir . '/' . $entrance_file . '.' . $file_fileex;
						$this->pagetemplate->assign('read', $readinfo);
						$this->pagetemplate->display($readtemplatefilename, $dirname . '_list', true, $filename, $lng_templates);
					}
					$outkey = '<b><span class="colorthree">' . $typeread['typename'] . "</span></b> " . $this->lng['createmain_creat_yes'] . $rt_dirpath;
				} else {
					$outkey = '<b>' . $typeread['typename'] . "</b> " . $this->lng['createmain_creat_no_t'] . $readtemplatefilename;
				}
			}
			unset($array, $typeread, $modelview, $readinfo, $LANPACK, $this->lng);
			exit($outkey);
		}
	}

	function oncreatedoc() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$lnglist = $this->get_lng_array($lng, 1);
		$this->ectemplates->assign('lnglist', $lnglist['list']);

		$modelarray = $this->get_model(0, $lng, 1, 2);
		$this->ectemplates->assign('modelarray', $modelarray['list']);
		$is_html = $this->CON['is_html'];
		$this->ectemplates->assign('is_html', $is_html);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('is_alonelng', $this->CON['is_alonelng']);
		$this->ectemplates->assign('home_lng', $lng);
		$this->ectemplates->display('creat/creat_doc');
	}

	function oncreatedocwindow() {
		parent::start_template();
		$read['lng'] = $this->fun->accept('lng', 'R');
		$read['mid'] = $this->fun->accept('mid', 'R');
		$read['tid'] = $this->fun->accept('tid', 'R');
		$read['startid'] = $this->fun->accept('startid', 'R');
		$read['endid'] = $this->fun->accept('endid', 'R');
		$read['time'] = time();
		$is_html = $this->CON['is_html'];
		$this->ectemplates->assign('is_html', $is_html);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->display('creat/create_doc_window');
	}

	function oncreatdocsave() {
		$lng = $this->fun->accept('lng', 'P');
		$db_where = ' WHERE isclass=1 AND islink=0 AND ishtml=1 AND isbase=0';
		$mid = $this->fun->accept('mid', 'P');
		if (!empty($mid)) {
			$db_where.=' AND mid=' . $mid;
		}
		$tid = $this->fun->accept('tid', 'P');
		if (!empty($tid)) {
			$db_where.=" AND tid=$tid";
		}
		$startid = $this->fun->accept('startid', 'P');
		$endid = $this->fun->accept('endid', 'P');
		if (!empty($startid)) {
			$db_where.=" AND did BETWEEN $startid and $endid";
		}
		$creattype = $this->fun->accept('creattype', 'P');
		$time = $this->fun->accept('dtime', 'P');
		if ($creattype == 1) {
			$time = $this->fun->formatdate($time, 4);
			$db_where.=" AND addtime>=$time";
		}
		$typeread = $this->get_type($tid);

		$lng_dir = $this->get_lng_dirpack($lng_templates);
		if ($this->CON['is_alonelng']) {
			$rt_dirpath_filename = $typeread['dirpath'];
		} else {
			$rt_dirpath_filename = $lng_dir . '/' . $typeread['dirpath'];
		}
		$db_table = db_prefix . 'document';
		$sql = 'SELECT did FROM ' . $db_table . $db_where;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$this->articlehtml($rsList['did'], $lng);
		}
		$outkey = '<b><span class="colorthree">' . $typeread['typename'] . "</span></b> " . $this->lng['createmain_creat_yes'] . $rt_dirpath_filename;
		unset($rsList);
		exit($outkey);
	}

	function onbatcreate() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$file_htmldir = $this->CON['file_htmldir'];
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$time = time();
		$is_html = $this->CON['is_html'];
		$this->ectemplates->assign('is_html', $is_html);

		$lnglist = $this->get_lng_array($lng, 1);
		$this->ectemplates->assign('lnglist', $lnglist['list']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('time', $this->fun->formatdate($time, 2));
		$this->ectemplates->assign('htmldir', $file_htmldir);
		$this->ectemplates->assign('is_alonelng', $this->CON['is_alonelng']);
		$this->ectemplates->assign('home_lng', $lng);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->display('creat/creat_bat');
	}

	function oncreatebatwindow() {
		parent::start_template();
		$read['lng'] = $this->fun->accept('lng', 'R');
		$lng = ($read['lng'] == 'big5') ? $this->CON['is_lancode'] : $read['lng'];
		$read['creattype'] = $this->fun->accept('creattype', 'R');
		$read['time'] = $this->fun->accept('time', 'R');

		$modelarray = $this->get_model(0, $lng, 1);
		$modelist = $modelarray['list'];
		$num = $modelarray['num'];
		$midlist = null;
		if ($num > 0) {
			$numcount = $num - 1;
			foreach ($modelist as $key => $value) {
				if ($key == $numcount) {
					$midlist.=$value['mid'];
				} else {
					$midlist.=$value['mid'] . ',';
				}
			}
		}
		$is_html = $this->CON['is_html'];
		$this->ectemplates->assign('is_html', $is_html);
		$this->ectemplates->assign('modelarray', $modelarray['list']);
		$this->ectemplates->assign('midlist', $midlist);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->display('creat/create_bat_window');
	}

	function oncreatesubject() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$lnglist = $this->get_lng_array($lng, 1);
		$this->ectemplates->assign('lnglist', $lnglist['list']);

		$modelarray = $this->get_model(0, $lng, 1, 2, 1);
		$this->ectemplates->assign('modelarray', $modelarray['list']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('is_alonelng', $this->CON['is_alonelng']);
		$this->ectemplates->assign('home_lng', $lng);
		$this->ectemplates->display('creat/creat_subject');
	}

	function oncreatesubwindow() {
		parent::start_template();
		$read['lng'] = $this->fun->accept('lng', 'R');
		$read['mid'] = $this->fun->accept('mid', 'R');
		$read['sid'] = $this->fun->accept('sid', 'R');
		$read['time'] = time();
		$is_html = $this->CON['is_html'];
		$this->ectemplates->assign('is_html', $is_html);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->display('creat/create_subject_window');
	}

	function onstasub() {
		$lng = $this->fun->accept('lng', 'R');
		$lng = ($lng == 'big5') ? $this->CON['is_lancode'] : $lng;
		$mid = $this->fun->accept('mid', 'R');
		$sid = $this->fun->accept('sid', 'R');
		if (empty($lng) || empty($mid)) {
			exit('false');
		}
		$lanpackfile = admin_ROOT . 'datacache/' . $lng . '_pack.php';
		if (!is_file($lanpackfile)) {

			$this->creat_lanpack($lng, true);
		}

		if ($sid == 0) {
			$subarray = $this->get_subjectlist_array($sid, $mid, $lng);
			$sublist = $subarray['list'];
			$num = $subarray['num'];
			$typelist = null;
			if ($num > 0) {
				$numcount = $num - 1;
				foreach ($sublist as $key => $value) {
					if ($key == $numcount) {
						$typelist.=$value['sid'];
					} else {
						$typelist.=$value['sid'] . ',';
					}
				}
			} else {
				$num = 0;
			}
		} else {
			$typelist = $sid;
			$num = 1;
		}

		$var = '{"num":"' . $num . '","typelist":"' . $typelist . '","mid":"' . $mid . '","lng":"' . $lng . '"}';
		exit($var);
	}

	function oncreatsubjectsave() {
		include_once admin_ROOT . 'public/class_htmlpage.php';

		$lng = $this->fun->accept('lng', 'P');
		$lng_templates = $lng;
		$lng = ($lng == 'big5') ? $this->CON['is_lancode'] : $lng;
		if (empty($lng)) {
			exit('false');
		}
		include admin_ROOT . 'datacache/' . $lng . '_pack.php';
		$this->start_pagetemplate($lng_templates, $LANPACK);

		$lng_dir = $this->get_lng_dirpack($lng_templates);

		$sid = intval($this->fun->accept('sid', 'P'));
		if (empty($sid)) exit('false');

		$subread = $this->get_subjectlist_purview($sid);

		$styleid = $subread['styleid'];

		$mid = $subread['mid'];
		$modelview = $this->get_modelview($mid);
		$modelname = $modelview['modelname'];

		$pagemax = $modelview['pagemax'];
		$pagemax = empty($subread['pagemax']) ? empty($pagemax) ? 20 : $pagemax  : $subread['pagemax'];

		$pagesylte = $modelview['pagesylte'];

		$file_fileex = $this->CON['file_fileex'];

		$entrance_file = $this->CON['entrance_file'];
		$entrance_file = empty($entrance_file) ? 'index' : $entrance_file;

		$file_htmldir = $this->CON['file_htmldir'];
		$htmdirpath = admin_ROOT . $file_htmldir;

		$template_list = $subread['template'];

		$template_index = $subread['indextemplates'];
		$subread['link'] = $this->get_link('subtype', $subread, $lng_templates);
		$this->pagetemplate->assign('sub', $subread);
		$this->pagetemplate->assign('path', 'special');

		if (!empty($subread['keywords'])) {
			$LANPACK['keyword'] = $subread['keywords'];
		}
		if (!empty($subread['description'])) {
			$LANPACK['description'] = $subread['description'];
		}
		$this->pagetemplate->assign('lngpack', $LANPACK);

		$templatesDIR = $this->get_templatesdir('article');

		$indextemplatefilename = $lng . '/' . $templatesDIR . '/' . $template_index;

		$listtemplatefilename = $lng . '/' . $templatesDIR . '/' . $template_list;

		$filenamestyle = $subread['filenamestyle'];

		$dirname = $subread['dirname'];

		if ($this->CON['is_alonelng']) {
			$dirpath = $subread['dirpath'];
		} else {
			$dirpath = $lng_dir . '/' . $subread['dirpath'];
		}

		$tpl_indexfile = $this->pagetemplate->tpl_dir . $this->pagetemplate->templatesDIR . $indextemplatefilename . $this->pagetemplate->templatesfileex;

		$tpl_listfile = $this->pagetemplate->tpl_dir . $this->pagetemplate->templatesDIR . $listtemplatefilename . $this->pagetemplate->templatesfileex;

		$rt_dirpath = $file_htmldir . $dirpath;

		$creatDir = $htmdirpath . $dirpath;

		if ($this->fun->filemode($htmdirpath)) {

			if (!is_dir($creatDir)) {
				if (!@mkdir($creatDir, 0777, true)) {
					exit($subread['subjectname'] . $this->lng['createmain_creat_no'] . '(' . $this->lng['createmain_creat_no_c'] . ')' . $rt_dirpath);
				}
			}
		} else {
			exit($subread['subjectname'] . $this->lng['createmain_creat_no'] . '(' . $this->lng['createmain_creat_no_w'] . ')' . $file_htmldir);
		}

		if ($styleid == 1) {


			$filename = $creatDir . '/' . $entrance_file . '.' . $file_fileex;

			$rt_dirpath_filename = $rt_dirpath . '/' . $entrance_file . '.' . $file_fileex;
			if (file_exists($tpl_indexfile)) {
				$this->pagetemplate->assign('rt_filepath', $rt_dirpath_filename);
				$this->pagetemplate->display($indextemplatefilename, $dirname . '_index', true, $filename, $lng_templates);
				$outkey = '<b><span class="colorthree">' . $subread['subjectname'] . "</span></b> " . $this->lng['createmain_creat_yes'] . $rt_dirpath_filename;
			} else {
				$outkey = '<b>' . $subread['subjectname'] . "</b> " . $this->lng['createmain_creat_no_t'] . $indextemplatefilename;
			}
			unset($subread, $modelview, $LANPACK);
			exit($outkey);
		} elseif ($styleid == 2) {
			$db_table = db_prefix . 'document';
			$db_where = ' WHERE isclass=1 AND mid=' . $mid . ' AND sid=' . $sid;
			$countnum = $this->db_numrows($db_table, $db_where);
			if ($countnum > 0) {

				$numpage = ceil($countnum / $pagemax);
			} else {
				$numpage = 1;
			}

			if (file_exists($tpl_listfile)) {
				$db_table = db_prefix . 'document';
				for ($index = 1; $index <= $numpage; $index++) {

					$fileArray = array('dirname' => $dirname, 'sid' => $sid, 'pageid' => $index, 'datetime' => date("YmdHis"), 'data' => date("Ymd"), 'y' => date("Y"), 'm' => date("m"), 'd' => date("d"));

					$filename_str = $this->get_htmlfilename($filenamestyle, $fileArray, 'pageid');
					$array = array();
					$sql = "SELECT * FROM $db_table $db_where LIMIT 0,$pagemax";
					$this->htmlpage = new htmlpage($sql, $pagemax, $index, $countnum, $numpage, $pagesylte, $entrance_file, $file_fileex, 5, $LANPACK['pagebotton'], $LANPACK['gopageurl'], $filename_str);
					$sql = $this->htmlpage->PageSQL('pid,did', 'down');
					$rs = $this->db->query($sql);
					while ($rsList = $this->db->fetch_assoc($rs)) {
						$attarray = array();
						$attarray = $this->get_document_attr($rsList['did']);
						$typeread = $this->get_type($rsList['tid']);
						$rsList['typename'] = $typeread['typename'];
						$rsList['typelink'] = $this->get_link('type', $typeread, $lng_templates);
						$rsList['link'] = $this->get_link('doc', $rsList, $lng_templates);
						$rsList['buylink'] = $this->get_link('buylink', $rsList, $lng_templates);
						$rsList['enqlink'] = $this->get_link('enqlink', $rsList, $lng_templates);
						$rsList['ctitle'] = empty($rsList['color']) ? $rsList['title'] : "<font color='" . $rsList['color'] . "'>" . $rsList['title'] . "</font>";
						$array[] = is_array($attarray) ? array_merge($attarray, $rsList) : $rsList;
					}
					$this->pagetemplate->assign('pagetext', $this->htmlpage->PageStat($LANPACK['pagetext']));
					$this->pagetemplate->assign('pagebotton', $this->htmlpage->PageList());
					$this->pagetemplate->assign('pagenu', $this->htmlpage->Bottonstyle(false));
					$this->pagetemplate->assign('pagese', $this->htmlpage->pageSelect());
					$this->pagetemplate->assign('pagevt', $this->htmlpage->Prevbotton());
					$this->pagetemplate->assign('array', $array);

					$filename_out = $index == 1 ? $entrance_file : $this->get_htmlfilename($filenamestyle, $fileArray);
					$filename = $creatDir . '/' . $filename_out . '.' . $file_fileex;
					$this->pagetemplate->display($listtemplatefilename, $dirname . '_list', true, $filename, $lng_templates);
					unset($array);
				}
				$outkey = '<b><span class="colorthree">' . $subread['subjectname'] . "</span></b> " . $this->lng['createmain_creat_yes'] . $rt_dirpath;
			} else {
				$outkey = '<b>' . $subread['subjectname'] . "</b> " . $this->lng['createmain_creat_no_t'] . $listtemplatefilename;
			}
			unset($subread, $modelview, $LANPACK);
			exit($outkey);
		}
	}

}

?>
