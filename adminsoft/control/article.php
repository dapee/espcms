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

	function onarticlelist() {
		parent::start_template();

		$MinPageid = intval($this->fun->accept('MinPageid', 'R'));

		$page_id = intval($this->fun->accept('page_id', 'R'));

		$countnum = intval($this->fun->accept('countnum', 'R'));

		$MaxPerPage = intval($this->fun->accept('MaxPerPage', 'R'));
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}

		$ordersearch = $this->fun->accept('ordersearch', 'R');

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$ishtml = intval($this->fun->accept('ishtml', 'R'));
		if (!empty($ishtml)) {
			if ($ishtml == 2) $ishtml = 0;
			$db_where.=' AND ishtml=' . $ishtml;
		}
		$isorder = intval($this->fun->accept('isorder', 'R'));
		if (!empty($isorder)) {
			if ($isorder == 2) $isorder = 0;
			$db_where.=' AND isorder=' . $isorder;
		}
		$islink = intval($this->fun->accept('islink', 'R'));
		if (!empty($islink)) {
			if ($islink == 2) $islink = 0;
			$db_where.=' AND islink=' . $islink;
		}
		$isclass = intval($this->fun->accept('isclass', 'R'));
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$isbase = intval($this->fun->accept('isbase', 'R'));
		if (!empty($isbase)) {
			if ($isbase == 2) $isbase = 0;
			$db_where.=' AND isbase=' . $isbase;
		}
		$mid = intval($this->fun->accept('mid', 'R'));
		if (!empty($mid)) {
			$db_where.=' AND mid=' . $mid;
		}
		$sid = intval($this->fun->accept('sid', 'R'));
		if (!empty($sid)) {
			$db_where.=' AND sid=' . $sid;
		}
		$tid = intval($this->fun->accept('tid', 'R'));
		if (!empty($tid)) {
			$db_where.=' AND ' . $this->get_typeid($tid, 'tid', 0, $mid, 0, $this->sitelng);
		}
		$dlid = $this->fun->accept('dlid', 'R');
		if (!empty($dlid)) {
			$db_where.=" AND FIND_IN_SET('$dlid',recommend)";
		}
		$serchekey = $this->fun->accept('serchekey', 'R');
		if (!empty($serchekey)) {
			$db_where.=" AND title like '%$serchekey%'";
		}


		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'did' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'document';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$modelname = $this->get_modelview($rsList['mid'], 'modelname');
			$typename = $this->get_type($rsList['tid'], 'typename');
			$rsList['modelname'] = $modelname;
			$rsList['typename'] = $typename;
			$rsList['ctitle'] = empty($rsList['color']) ? $rsList['title'] : "<font color='" . $rsList['color'] . "'>" . $rsList['title'] . "</font>";
			$rsList['readlink'] = $this->get_link('doc', $rsList, $rsList['lng']);
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);

		$outtemplatefile = empty($ordersearch) ? 'article/article_list' : 'article/article_window_list';
		$this->ectemplates->display($outtemplatefile);
	}

	function onlinklist() {
		parent::start_template();

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';
		$did = $this->fun->accept('did', 'R');
		if (!empty($did)) {
			$db_where.=" AND did IN ($did)";
		}
		$db_table = db_prefix . 'document';
		$sql = 'SELECT did,lng,title FROM ' . $db_table . $db_where . ' ORDER BY did DESC';
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->display('article/link_list');
	}

	function onajaxarticlelist() {
		parent::start_template();

		$type = $this->fun->accept('type', 'R');
		$type = empty($type) ? 'add' : $type;
		if ($type == 'add') {

			$didlist = $this->fun->accept('didlist', 'R');
			if (!empty($didlist)) {
				$did = substr($didlist, 0, strlen($didlist) - 1);
			}
		} else {
			$did = $this->fun->accept('did', 'R');
			$didlist = $this->fun->accept('didlist', 'R');
			if (!empty($didlist)) {
				$didlistArray = explode(',', $didlist);
				$didArray = explode(',', $did);
				foreach ($didArray as $key => $value) {
					if (in_array($value, $didlistArray)) {
						unset($didArray[$key]);
					}
				}
				if (count($didArray) < 1 || empty($didArray)) exit;
				$did = implode(',', $didArray) . ',';
			}
			$did = substr($did, 0, strlen($did) - 1);
		}
		if (!empty($did)) {
			$db_where = ' WHERE did IN (' . $did . ')';
		} else {
			exit();
		}
		$db_table = db_prefix . 'document';
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY did DESC';
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$typename = $this->get_type($rsList['tid'], 'typename');
			$rsList['readlink'] = admin_URL . $this->CON['file_htmldir'] . $rsList['lng'] . '/' . $rsList['filepath'] . '/' . $rsList['filename'] . '.' . $this->CON['file_fileex'];
			$array[] = $rsList;
		}
		$this->ectemplates->assign('array', $array);
		$templatesfile = ($type == 'edit') ? 'order/order_article_edit_list' : 'order/order_article_add_list';
		$this->ectemplates->display($templatesfile);
	}

	function onsearch() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$mid = intval($this->fun->accept('mid', 'R'));
		$mid = empty($mid) ? 0 : $mid;

		$tid = intval($this->fun->accept('tid', 'R'));
		$tid = empty($tid) ? 0 : $tid;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$modelarray = $this->get_model($mid, $lng, 1, 2);
		$this->ectemplates->assign('modelarray', $modelarray['list']);

		$subjectlistarray = $this->get_subjectlist_array(0, $mid, $lng);
		$this->ectemplates->assign('subjectlistarray', $subjectlistarray['list']);

		$typelist = $this->get_typeselect($mid, 0, $tid, $lng, 0, 1, false, false);
		$this->ectemplates->assign('typelist', $typelist);
		if ($mid) {

			$doclabel = $this->get_doclabel_array(0, $mid);
			$this->ectemplates->assign('doclabel', $doclabel['list']);
		}

		$digheight = $this->fun->accept('digheight', 'R');
		$this->ectemplates->assign('digheight', $digheight);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('tid', $tid);
		$this->ectemplates->display("article/article_search");
	}

	function onlistwindow() {
		parent::start_template();

		$mid = intval($this->fun->accept('mid', 'R'));
		$mid = empty($mid) ? 0 : $mid;

		$tid = intval($this->fun->accept('tid', 'R'));
		$tid = empty($tid) ? 0 : $tid;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$checkfrom = $this->fun->accept('checkfrom', 'R');
		$checkfrom = empty($checkfrom) ? 'edit' : $checkfrom;
		$this->ectemplates->assign('checkfrom', $checkfrom);

		$getbyid = $this->fun->accept('getbyid', 'R');
		$this->ectemplates->assign('getbyid', $getbyid);

		$digheight = $this->fun->accept('digheight', 'R');
		$this->ectemplates->assign('digheight', $digheight);

		$iframeid = $this->fun->accept('iframeid', 'R');
		$this->ectemplates->assign('iframeid', $iframeid);

		$inputtext = $this->fun->accept('inputtext', 'R');
		$inputtext = empty($inputtext) ? 'order' : $inputtext;
		$this->ectemplates->assign('inputtext', $inputtext);

		$modelarray = $checkfrom == 'orderadd' || $checkfrom == 'orderedit' ? $this->get_model($mid, $lng, 1, 0, 0, 1) : $this->get_model($mid, $lng, 1);
		$this->ectemplates->assign('modelarray', $modelarray['list']);

		$subjectlistarray = $checkfrom == 'orderadd' || $checkfrom == 'orderedit' ? array() : $this->get_subjectlist_array(0, $mid, $lng);
		$this->ectemplates->assign('subjectlistarray', $subjectlistarray['list']);

		$typelist = $checkfrom == 'orderadd' || $checkfrom == 'orderedit' ? array() : $this->get_typeselect($mid, 0, $tid, $lng, 0, 1, true, false);
		$this->ectemplates->assign('typelist', $typelist);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('tid', $tid);
		$this->ectemplates->display('article/article_window');
	}

	function ondocadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$mid = intval($this->fun->accept('mid', 'R'));
		$mid = empty($mid) ? 0 : $mid;

		$tid = intval($this->fun->accept('tid', 'R'));
		$tid = empty($tid) ? 0 : $tid;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$typelist = $this->get_typeselect($mid, 0, $tid, $lng, 0, 1, false, false);
		$this->ectemplates->assign('typelist', $typelist);

		$memberpuv = $this->get_member_purview_array();
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);

		$modelview = $this->get_modelview($mid);
		$this->ectemplates->assign('modelview', $modelview);

		$subjectlistarray = $this->get_subjectlist_array(0, $mid, $lng);
		$this->ectemplates->assign('subjectlistarray', $subjectlistarray['list']);

		$formarray = $this->get_form_array(0, $lng);
		$this->ectemplates->assign('formarray', $formarray['list']);

		$doclabel = $this->get_doclabel_array(0, $mid, $lng);
		$this->ectemplates->assign('doclabel', $doclabel['list']);

		$modelatt = $this->get_modelattArray($mid);
		$this->ectemplates->assign('modelatt', $modelatt);

		$input_default = $this->CON;

		$tsn = $this->fun->get_tsn();
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('tsn', $tsn);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('tid', $tid);
		$this->ectemplates->display('article/article_add');
	}

	function ondocedit() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$type = $this->fun->accept('type', 'R');
		$type = empty($type) ? 'edit' : $type;

		$did = intval($this->fun->accept('did', 'R'));
		$mid = intval($this->fun->accept('mid', 'R'));
		$mid = empty($mid) ? 0 : $mid;
		$tid = intval($this->fun->accept('tid', 'R'));
		$tid = empty($tid) ? 0 : $tid;
		if (empty($did)) exit('false');
		$docview = $this->get_document($did);
		if (empty($docview['color'])) {
			$docview['color'] = $this->CON['input_color'];
		}

		$mid = empty($docview['mid']) ? $mid : $docview['mid'];
		$tid = empty($docview['tid']) ? $tid : $docview['tid'];

		$lng = $docview['lng'];

		$typeread = $this->get_type($tid);
		$this->ectemplates->assign('typeread', $typeread);

		$typelist = $this->get_typeselect($mid, 0, $tid, $lng, 0, 1, false, false);
		$this->ectemplates->assign('typelist', $typelist);

		$extid_array = !empty($docview['extid']) ? explode(',', $docview['extid']) : array();
		$this->ectemplates->assign('extid', $extid_array);

		$memberpuv = $this->get_member_purview_array($docview['purview']);
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);

		$modelatt = $this->get_modelattArray($mid, false);

		if (is_array($modelatt)) {
			foreach ($modelatt as $key => $value) {
				if ($value['inputtype'] == 'select' || $value['inputtype'] == 'radio') {
					foreach ($value['attrvalue'] as $key2 => $value2) {
						if (trim($docview[$value['attrname']]) == trim($value2['name'])) {
							$modelatt[$key]['attrvalue'][$key2]['selected'] = 'selected';
						}
					}
				} elseif ($value['inputtype'] == 'checkbox') {
					$expvale = explode(',', $docview[$value['attrname']]);
					foreach ($value['attrvalue'] as $key2 => $value2) {
						if (in_array($value2['name'], $expvale)) {
							$modelatt[$key]['attrvalue'][$key2]['selected'] = 'selected';
						}
					}
				} else {
					$modelatt[$key]['attrvalue'] = $docview[$value['attrname']];
				}
			}
		}
		$this->ectemplates->assign('modelatt', $modelatt);

		$modelview = $this->get_modelview($mid);
		$this->ectemplates->assign('modelview', $modelview);

		$subjectlistarray = $this->get_subjectlist_array($docview['sid'], $mid, $lng);
		$this->ectemplates->assign('subjectlistarray', $subjectlistarray['list']);

		$formarray = $this->get_form_array($docview['fgid'], $lng);
		$this->ectemplates->assign('formarray', $formarray['list']);

		$piclist = $this->get_album_array($did);
		$piclist['num'] = $piclist['num'] + 1;

		$this->ectemplates->assign('picarray', $piclist['list']);
		$this->ectemplates->assign('piccount', $piclist['num']);
		$this->ectemplates->assign('aidlist', $piclist['aidlist']);

		$linkdid = $this->get_document_link($docview['linkdid']);
		$this->ectemplates->assign('linkdid', $linkdid['list']);

		$doclabel = $this->get_doclabel_array($docview['recommend'], $mid, $lng);
		$this->ectemplates->assign('doclabel', $doclabel['list']);

		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('read', $docview);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('tid', $tid);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->display('article/article_edit');
	}

	function ondocsave() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		include_once admin_ROOT . 'public/class_gather.php';
		include_once admin_ROOT . 'public/class_downloadimages.php';

		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$mid = intval($this->fun->accept('mid', 'P'));
		$mid = empty($mid) ? 0 : $mid;
		$tid = intval($this->fun->accept('tid', 'P'));
		$tid = empty($tid) ? 0 : $tid;
		if (empty($tid)) exit($this->lng['article_js_tid_empty']);

		$tsn = $this->fun->accept('tsn', 'P');
		if (empty($tsn)) {
			$tsn = $this->fun->get_tsn();
		}
		$color = $this->fun->accept('color', 'P');
		if ($color == $this->CON['input_color']) {
			$color = '';
		}
		$tags = $this->fun->accept('tags', 'P');
		$keywords = $this->fun->accept('keywords', 'P');
		$description = $this->fun->accept('description', 'P');
		$recommend = $this->fun->accept('recommend', 'P');
		if (!empty($recommend)) {
			$recommend = implode(',', $recommend);
		}
		$extid = $this->fun->accept('extid', 'P');
		$extid = is_array($extid) ? implode(',', $extid) : 0;
		$sid = intval($this->fun->accept('sid', 'P'));
		$sid = empty($sid) ? 0 : $sid;
		$fgid = intval($this->fun->accept('fgid', 'P'));
		$fgid = empty($fgid) ? 0 : $fgid;
		$purview = intval($this->fun->accept('purview', 'P'));
		$purview = empty($purview) ? 0 : $purview;

		$click = intval($this->fun->accept('click', 'P'));
		$click = empty($click) ? 0 : $click;
		$addtime = $this->fun->accept('addtime', 'P');
		$time = time();
		$addtime = empty($addtime) ? $time : strtotime($addtime);
		$islink = $this->fun->accept('islink', 'P');
		$islink = empty($islink) ? 0 : $islink;
		$link = $this->fun->accept('link', 'P');

		$ishtml = intval($this->fun->accept('ishtml', 'P'));
		$ishtml = empty($ishtml) ? 0 : $ishtml;
		$isorder = intval($this->fun->accept('isorder', 'P'));
		$isorder = empty($isorder) ? 0 : $isorder;

		$istemplates = $this->fun->accept('istemplates', 'P');
		$istemplates = empty($istemplates) ? 0 : $istemplates;
		$template = $this->fun->accept('template', 'P');

		$filename = $this->fun->accept('filename', 'P');
		$ismessage = intval($this->fun->accept('ismessage', 'P'));
		$ismessage = empty($ismessage) ? 0 : $ismessage;

		$albumlist = $this->fun->accept('albumlist', 'P');

		$picname = $this->fun->accept('picname', 'P');

		$filedes = $this->fun->accept('filedes', 'P');

		$linkdid = $this->fun->accept('linkdid', 'P');

		$donwloadpic = $this->fun->accept('donwloadpic', 'P');
		$donwloadpic = empty($donwloadpic) ? 0 : $donwloadpic;

		$modelatt = $this->get_modelattArray($mid);

		$modelarray = array();

		$modelsysarray = array();
		foreach ($modelatt as $key => $value) {

			if ($value['inputtype'] == 'htmltext') {

				$value['accept'] = 'html';
			} elseif ($value['inputtype'] == 'checkbox') {

				$value['accept'] = 'checkbox';
			} elseif ($value['inputtype'] == 'string' || $value['inputtype'] == 'img' || $value['inputtype'] == 'addon' || $value['inputtype'] == 'video' || $value['inputtype'] == 'select' || $value['inputtype'] == 'radio' || $value['inputtype'] == 'selectinput') {

				$value['accept'] = 'text';
			} elseif ($value['inputtype'] == 'editor' || $value['inputtype'] == 'text') {

				$value['accept'] = 'editor';
			} elseif ($value['inputtype'] == 'int' || $value['inputtype'] == 'float' || $value['inputtype'] == 'decimal') {

				$value['accept'] = 'int';
			} elseif ($value['inputtype'] == 'datetime') {

				$value['accept'] = 'data';
			}
			if (!$value['lockin'] && !$value['issys']) {
				$modelarray[] = $value;
			} else {
				$modelsysarray[] = $value;
			}
		}

		$sysinstall = null;

		$sysinstalldb = null;

		$conent = null;

		foreach ($modelsysarray as $key => $value) {
			if ($value['attrname'] == 'content') {
				continue;
			}
			if ($inputclass == 'add') {
				$sysinstall.=$value['attrname'] . ',';
				if ($value['accept'] == 'int') {
					$valuestr = $this->fun->accept($value['attrname'], 'P');
					$valuestr = empty($valuestr) ? 0 : $valuestr;
					$sysinstalldb.="$valuestr,";
				} elseif ($value['accept'] == 'html') {
					$valuestr = $this->fun->accept($value['attrname'], 'P');
					$valuestr = empty($valuestr) ? '' : $this->fun->Text2Html($valuestr);
					$sysinstalldb.="'$valuestr',";
				} elseif ($value['accept'] == 'editor' || $value['accept'] == 'text') {
					$valuestr = $this->fun->accept($value['attrname'], 'P');
					$sysinstalldb.="'$valuestr',";
				} elseif ($value['accept'] == 'data') {
					$valuestr = $this->fun->accept($value['attrname'], 'P');
					$valuestr = empty($valuestr) ? 0 : strtotime($valuestr);
					$sysinstalldb.="$valuestr,";
				}
			} else {
				if ($value['accept'] == 'int') {
					$valuestr = $this->fun->accept($value['attrname'], 'P');
					$valuestr = empty($valuestr) ? 0 : $valuestr;
					$sysinstalldb.=$value['attrname'] . "=$valuestr,";
				} elseif ($value['accept'] == 'html') {
					$valuestr = $this->fun->accept($value['attrname'], 'P');
					$valuestr = empty($valuestr) ? '' : $this->fun->Text2Html($valuestr);
					$sysinstalldb.=$value['attrname'] . "='$valuestr',";
				} elseif ($value['accept'] == 'editor' || $value['accept'] == 'text') {
					$valuestr = $this->fun->accept($value['attrname'], 'P');
					$sysinstalldb.=$value['attrname'] . "='$valuestr',";
				} elseif ($value['accept'] == 'data') {
					$valuestr = $this->fun->accept($value['attrname'], 'P');
					$valuestr = empty($valuestr) ? 0 : strtotime($valuestr);
					$sysinstalldb.=$value['attrname'] . "=$valuestr,";
				}
			}
		}


		$userinstall = null;

		$userinstalldb = null;
		foreach ($modelarray as $key => $value) {
			$userinstall.=$value['attrname'] . ',';
			if ($value['accept'] == 'int') {
				$valuestr = $this->fun->accept($value['attrname'], 'P');
				$valuestr = empty($valuestr) ? 0 : $valuestr;
				$userinstalldb.="$valuestr,";
				$userupdatedb.=$value['attrname'] . "=$valuestr,";
			} elseif ($value['accept'] == 'html') {
				$valuestr = $this->fun->accept($value['attrname'], 'P');
				$valuestr = empty($valuestr) ? '' : $this->fun->Text2Html($valuestr);
				$userinstalldb.="'$valuestr',";
				$userupdatedb.=$value['attrname'] . "='$valuestr',";
			} elseif ($value['accept'] == 'editor' || $value['accept'] == 'text') {
				$valuestr = $this->fun->accept($value['attrname'], 'P');
				$userinstalldb.="'$valuestr',";
				$userupdatedb.=$value['attrname'] . "='$valuestr',";
			} elseif ($value['accept'] == 'data') {
				$valuestr = $this->fun->accept($value['attrname'], 'P');
				$valuestr = empty($valuestr) ? 0 : strtotime($valuestr);
				$userinstalldb.="$valuestr,";
				$userupdatedb.=$value['attrname'] . "=$valuestr,";
			} elseif ($value['accept'] == 'checkbox') {
				$valuestr = $this->fun->accept($value['attrname'], 'P');
				$valuestr = is_array($valuestr) ? implode(',', $valuestr) : '';
				$userinstalldb.="'$valuestr',";
				$userupdatedb.=$value['attrname'] . "='$valuestr',";
			}
		}

		$is_keylink = $this->CON['is_keylink'];

		$is_html = $this->CON['is_html'];

		$file_htmldir = $this->CON['file_htmldir'];

		$content = $this->fun->accept('content', 'P');

		if ($donwloadpic && !empty($content)) {

			$gather = new gather();

			$temp_pic_content = $this->fun->stripslashes($content);
			$temp_pic_content = html_entity_decode($temp_pic_content);

			$images = $gather->imageList($temp_pic_content);

			if (is_array($images) && count($images) > 0 && !empty($images[0]) && !$this->fun->gb_check($images[0])) {

				$picsaveDIR = admin_ROOT . $this->CON['upfile_dir'];

				$showpictrue = true;
				foreach ($images as $key => $value) {
					if (empty($value)) {
						continue;
					} else {

						$picpathinfo = parse_url($value);
						$savepathinfo = parse_url(admin_URL);
						if ($picpathinfo['host'] == $savepathinfo['host'] || empty($picpathinfo['host'])) {
							continue;
						}
					}

					$Gimg = new GetImage();

					$Gimg->source = $images[$key];

					$Gimg->save_to = $picsaveDIR;

					$Gimg->smalltype = false;

					$Gfilename = $Gimg->download();

					$temp_pic_content = str_replace($images[$key], admin_URL . $this->CON['upfile_dir'] . $Gfilename['filepath'] . $Gfilename['filename'], $temp_pic_content);
				}
				$content = addslashes($temp_pic_content);
			}
		}

		if (!empty($content)) {

			$input_isdellink = $this->fun->accept('input_isdellink', 'P');

			if ($input_isdellink == 1) {
				$content = $this->fun->linkclear($content);
			}

			if ($is_keylink == 1 && !empty($tags)) {
				$content = $this->rep_keylink($content, $tags, $lng);
			}
		}

		$input_iskey = $this->CON['input_iskey'];

		$input_isdes = $this->CON['input_isdes'];

		$input_isdescription = $this->CON['input_isdescription'];
		$input_isdescription = empty($input_isdescription) ? 200 : ($input_isdescription > 200) ? 200 : $input_isdescription;

		$input_iskeyword = $this->CON['input_iskeyword'];
		$input_iskeyword = empty($input_iskeyword) ? 10 : ($input_iskeyword > 10) ? 10 : $input_iskeyword;

		$typeview = $this->get_type($tid);

		$type_styleid = $typeview['styleid'];

		$read_templates = ($istemplates) ? $template : $typeview['readtemplate'];

		$filenamestyle = $typeview['filenamestyle'];

		$readnamestyle = $typeview['readnamestyle'];

		$dirname = $typeview['dirname'];

		$dirpath = $typeview['dirpath'];

		$aid = $this->esp_adminuserid;

		$isclass = $this->esp_inputclassid;
		$isclass = empty($isclass) ? 0 : $isclass;
		$db_table = db_prefix . 'document';
		$db_table1 = db_prefix . 'document_content';
		$db_table2 = db_prefix . 'document_attr';

		if ($inputclass == 'add') {

			if (empty($description) && $input_isdescription > 0 && $input_isdes == 1 && !empty($content)) {
				$description = $this->fun->get_substr($content, $input_isdescription, true);
				$description = $this->fun->daddslashes($description, 1);
			}

			if (empty($keywords) && $input_iskeyword > 0 && $input_iskey == 1 && !empty($content)) {
				$keywords = $this->get_keyword($content, $input_iskeyword);
				$keywords = $this->fun->daddslashes($keywords, 1);
			}

			$db_field = $sysinstall . 'lng,pid,mid,aid,tid,extid,sid,fgid,linkdid,isclass,islink,ishtml,ismess,isorder,ktid,purview,istemplates
				,isbase,recommend,tsn,color,tags,keywords,description,link,click,addtime,uptime,template,filename';
			$db_values = $sysinstalldb . "'$lng',50,$mid,$aid,$tid,'$extid',$sid,$fgid,'$linkdid',$isclass,$islink,$ishtml,$ismessage,$isorder,0,$purview,$istemplates,
				0,'$recommend','$tsn','$color','$tags','$keywords','$description','$link',$click,$addtime,$time,'$read_templates','$filename'";

			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$insert_id = $this->db->insert_id();

			if (!empty($content)) {
				$db_field = 'did,content';
				$db_values = "$insert_id,'$content'";
				$this->db->query('INSERT INTO ' . $db_table1 . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			}

			if ($userinstall && $userinstalldb) {
				$db_field = $userinstall . 'did';
				$db_values = $userinstalldb . $insert_id;
				$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			}

			if (!empty($albumlist)) {
				$this->install_pic($insert_id, $albumlist, $picname, $filedes, false);
			}

			$htmlid = $this->articlehtml($insert_id);
			$this->writelog($this->lng['article_add_log'], $this->lng['log_extra_ok'] . ' id=' . $insert_id);
			if ($htmlid['c'] == 1) {

				$returmess = $this->lng['article_js_doc_add_html_err2'] . '(' . $htmlid['s'] . ')';
				exit($returmess);
			} elseif ($htmlid['c'] == 2) {

				$returmess = $this->lng['filedircreat_err'] . '(' . $htmlid['s'] . ')';
				exit($returmess);
			} elseif ($htmlid['c'] == 3) {

				$returmess = $this->lng['filedir_err'] . '(' . $htmlid['s'] . ')';
				exit($returmess);
			} elseif ($htmlid['c'] == 4) {

				$returmess = $this->lng['article_js_doc_add_html_err'] . '(' . $htmlid['s'] . ')';
				exit($returmess);
			} elseif ($htmlid['c'] == 0) {
				exit('true');
			}
		} elseif ($inputclass == 'edit') {
			$did = $this->fun->accept('did', 'P');
			$datid = $this->fun->accept('datid', 'P');
			$dcid = $this->fun->accept('dcid', 'P');
			if (empty($did)) {
				exit($this->lng['article_js_doc_add_html_err3']);
			}
			$filepath = $this->fun->accept('filepath', 'P');

			if ($ishtml == 1 && $is_html == 1 && $islink == 0) {

				$readfileArray = array('dirname' => $dirname, 'tid' => $tid, 'did' => $did, 'datetime' => date("YmdHis"), 'data' => date("Ymd"), 'y' => date("Y"), 'm' => date("m"), 'd' => date("d"));

				$filename = empty($filename) ? $this->get_htmlfilename($readnamestyle, $readfileArray) : $filename;
				$filepath = empty($filepath) ? $dirpath : $filepath;
			}

			if (!empty($description) && $input_isdescription > 0) {
				$description = $this->fun->get_substr($description, $input_isdescription, true);
				$description = $this->fun->daddslashes($description, 1);
			}
			$db_where = 'did=' . $did;

			$db_set = $sysinstalldb . "aid=$aid,tid=$tid,extid='$extid',sid=$sid,fgid=$fgid,linkdid='$linkdid',islink=$islink,ishtml=$ishtml,ismess=$ismessage,isorder=$isorder,purview=$purview,istemplates=$istemplates
				,recommend='$recommend',tsn='$tsn',color='$color',tags='$tags',keywords='$keywords',description='$description',link='$link',click=$click,addtime=$addtime,uptime=$time,template='$read_templates',filename='$filename',filepath='$filepath'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

			if (!empty($content)) {

				if ($dcid) {
					$db_where = 'did=' . $did . ' AND dcid=' . $dcid;

					$db_set = "content='$content'";
					$this->db->query('UPDATE ' . $db_table1 . ' SET ' . $db_set . ' WHERE ' . $db_where);
				} else {
					$db_field = 'did,content';
					$db_values = "$did,'$content'";
					$this->db->query('INSERT INTO ' . $db_table1 . ' (' . $db_field . ') VALUES (' . $db_values . ')');
				}
			}

			if ($userinstalldb) {

				if ($datid) {
					$db_where = 'did=' . $did . ' AND datid=' . $datid;
					$db_values = substr($userupdatedb, 0, strlen($userupdatedb) - 1);
					$this->db->query('UPDATE ' . $db_table2 . ' SET ' . $db_values . ' WHERE ' . $db_where);
				} else {
					$db_field = $userinstall . 'did';
					$db_values = $userinstalldb . $did;
					$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field . ') VALUES (' . $db_values . ')');
				}
			}

			$this->install_pic($did, $albumlist, $picname, $filedes);

			$htmlid = $this->articlehtml($did);
			$this->dbcache->clearcache('document_' . $did, true);
			$this->writelog($this->lng['article_edit_log'], $this->lng['log_extra_ok'] . ' id=' . $did);
			if ($htmlid['c'] == 1) {

				$returmess = $this->lng['article_js_doc_add_html_err2'] . '(' . $htmlid['s'] . ')';
				exit($returmess);
			} elseif ($htmlid['c'] == 2) {

				$returmess = $this->lng['filedircreat_err'] . '(' . $htmlid['s'] . ')';
				exit($returmess);
			} elseif ($htmlid['c'] == 3) {

				$returmess = $this->lng['filedir_err'] . '(' . $htmlid['s'] . ')';
				exit($returmess);
			} elseif ($htmlid['c'] == 4) {

				$returmess = $this->lng['article_js_doc_add_html_err'] . '(' . $htmlid['s'] . ')';
				exit($returmess);
			} elseif ($htmlid['c'] == 0) {
				exit('true');
			}
		}
	}

	function onarticledel() {
		$db_table = db_prefix . 'document';
		$db_table2 = db_prefix . 'document_album';
		$db_table3 = db_prefix . 'document_content';
		$db_table4 = db_prefix . 'document_attr';
		$selectinfoid = $this->fun->accept('articleselectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');

		$file_htmldir = $this->CON['file_htmldir'];
		$htmdirpath = admin_ROOT . $file_htmldir;

		if (is_dir($htmdirpath)) {
			if (!$this->fun->filemode($htmdirpath)) {
				exit('false');
			}
		}
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		$lng = $this->sitelng;
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$lngdir = $this->get_lng_dirpack($lng);
		for ($i = 0; $i < $count; $i++) {
			$db_where = "did=$infoarray[$i]";
			$relist = $this->get_documentview($infoarray[$i]);
			if ($relist['ishtml'] == 1) {
				if ($relist['filepage'] > 1) {
					for ($index = 0; $index < $relist['filepage']; $index++) {
						$filename = $index == 0 ? $relist['filename'] : $relist['filename'] . '_' . $index;
						if ($this->CON['is_alonelng']) {
							$filepath = $htmdirpath . $relist['filepath'] . '/' . $filename . '.' . $this->CON['file_fileex'];
						} else {
							$filepath = $htmdirpath . $lngdir . '/' . $relist['filepath'] . '/' . $filename . '.' . $this->CON['file_fileex'];
						}
						$this->fun->delfile($filepath);
					}
				} else {
					if ($this->CON['is_alonelng']) {
						$filepath = $htmdirpath . $relist['filepath'] . '/' . $relist['filename'] . '.' . $this->CON['file_fileex'];
					} else {
						$filepath = $htmdirpath . $lngdir . '/' . $relist['filepath'] . '/' . $relist['filename'] . '.' . $this->CON['file_fileex'];
					}
					$this->fun->delfile($filepath);
				}
			}
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
			$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where);
			$this->db->query('DELETE FROM ' . $db_table3 . ' WHERE ' . $db_where);
			$this->db->query('DELETE FROM ' . $db_table4 . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['article_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onsort() {
		$db_table = db_prefix . 'document';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "did=$value";
				$db_set = "pid=$pidArray[$key]";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		}
		$this->writelog($this->lng['article_sort_log'], $this->lng['log_extra_ok']);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'document';
		$selectinfoid = $this->fun->accept('articleselectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "did IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['article_setting_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function checkdid($did, $dbname) {
		$db_table = db_prefix . $dbname;
		$db_where = " WHERE did='$did'";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			return true;
		} else {
			return false;
		}
	}

	function oncreathtml() {

		$is_html = $this->CON['is_html'];
		if ($is_html == 0) exit('false');
		$selectinfoid = $this->fun->accept('articleselectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$this->articlehtml($infoarray[$i]);
		}
		$this->writelog($this->lng['article_htmlcreat_botton'], $this->lng['log_extra_ok']);
		exit('true');
	}

}

?>