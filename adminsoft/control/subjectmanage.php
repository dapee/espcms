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

	function onsubjectlist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_table = db_prefix . 'subjectlist';

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$mid = $this->fun->accept('mid', 'R');
		if (!empty($mid)) {
			$db_where.=' AND mid=' . $mid;
		}
		$isclass = intval($this->fun->accept('isclass', 'R'));
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$iswap = intval($this->fun->accept('iswap', 'R'));
		if (!empty($iswap)) {
			if ($iswap == 2) $iswap = 0;
			$db_where.=' AND iswap=' . $iswap;
		}
		$ishtml = intval($this->fun->accept('ishtml', 'R'));
		if (!empty($ishtml)) {
			if ($ishtml == 2) $ishtml = 0;
			$db_where.=' AND ishtml=' . $ishtml;
		}

		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'sid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;

		$sql = 'SELECT sid,pid,mid,lng,subjectname,keywords,description,content,subpic,dirname,purview,isclass,styleid,template,filenamestyle,dirpath,addtime,ishtml,iswap,waptempalte FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$puvname = $this->get_member_purview($rsList['purview'], 'rankname');
			$rsList['glink'] = $this->get_link('subtype', $rsList, $rsList['lng']);
			$rsList['puvname'] = empty($puvname) ? $this->lng['puv_no'] : $puvname;
			$array[] = $rsList;
		}
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('article/subject_list');
	}

	function onsubadd() {
		include_once admin_ROOT . adminfile . '/include/command_templatesdir.php';
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$mid = $this->fun->accept('mid', 'G');
		$mid = empty($mid) ? 0 : $mid;

		$memberpuv = $this->get_member_purview_array();
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);

		$modelarray = $this->get_model($mid, $lng, 0, 2, 1);
		$this->ectemplates->assign('modelarray', $modelarray['list']);

		$this->ectemplates->assign('ext', $this->CON['file_fileex']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('tempname', $TEMPNAMELIST);
		$this->ectemplates->assign('filetemplate', $SUBURLLIST);
		$this->ectemplates->display('article/subject_add');
	}

	function onsubedit() {
		include_once admin_ROOT . adminfile . '/include/command_templatesdir.php';
		parent::start_template();

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_table = db_prefix . 'subjectlist';
		$type = $this->fun->accept('type', 'G');
		$sid = intval($this->fun->accept('sid', 'G'));
		$db_where = 'sid=' . $sid;
		$subread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$memberpuv = $this->get_member_purview_array($subread['purview']);
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);

		$model = $this->get_modelview($subread['mid'], 'modelname');
		$this->ectemplates->assign('model', $model);

		$lngdir = $this->get_lng_dirpack($subread['lng']);

		$this->ectemplates->assign('pathdir', $this->CON['file_htmldir']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('subread', $subread);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('lngdir', $lngdir);
		$this->ectemplates->assign('tempname', $TEMPNAMELIST);
		$this->ectemplates->assign('filetemplate', $SUBURLLIST);

		$this->ectemplates->assign('ext', $this->CON['file_fileex']);
		$this->ectemplates->display('article/subject_edit');
	}

	function onsubsave() {
		include_once admin_ROOT . adminfile . '/include/command_templatesdir.php';
		include_once admin_ROOT . 'public/class_pingying.php';
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$mid = $this->fun->accept('mid', 'P');
		$mid = empty($mid) ? 0 : $mid;
		$pagemax = $this->fun->accept('pagemax', 'P');
		$pagemax = empty($pagemax) ? 0 : $pagemax;

		$subjectname = $this->fun->accept('subjectname', 'P');
		$content = $this->fun->accept('content', 'P');
		$content = empty($content) ? '' : $this->fun->Text2Html($content);
		$keywords = $this->fun->accept('keywords', 'P');
		$description = $this->fun->accept('description', 'P');
		$isdirname = $this->fun->accept('isdirname', 'P');
		$subpic = $this->fun->accept('subpic', 'P');
		$dirname = $this->fun->accept('dirname', 'P');
		$purview = $this->fun->accept('purview', 'P');
		$styleid = $this->fun->accept('styleid', 'P');

		$template = $this->fun->accept('template', 'P');
		$template = empty($template) ? $TEMPNAMELIST['subjectlist'] : $template;

		$indextemplates = $this->fun->accept('indextemplates', 'P');
		$indextemplates = empty($indextemplates) ? $TEMPNAMELIST['subjectindex'] : $indextemplates;


		$ishtml = $this->fun->accept('ishtml', 'P');
		$ishtml = empty($ishtml) ? 0 : $ishtml;

		$iswap = $this->fun->accept('iswap', 'P');
		$iswap = empty($iswap) ? 0 : $iswap;
		$waptempalte = $this->fun->accept('waptempalte', 'P');
		$waptempalte = empty($waptempalte) ? $TEMPNAMELIST['subjectlist'] : $waptempalte;

		$filenamestyle = $this->fun->accept('filenamestyle', 'P');
		$db_table = db_prefix . 'subjectlist';
		$date = time();
		if ($inputclass == 'add') {
			if ($isdirname) {
				$chinesespelit = new chineseSpell();
				$dirname = $chinesespelit->getFullSpell($subjectname);
			} else {
				if (!preg_match("/^[\w-]+$/i", $dirname)) {
					exit('false');
				}
			}

			$db_table2 = db_prefix . 'typelist';
			$db_where = " WHERE dirname='$dirname' AND lng='$lng'";
			$countnum = $this->db_numrows($db_table, $db_where);
			if (!$isdirname) {
				if ($countnum > 0) {
					exit('false');
				} else {
					$countnum = $this->db_numrows($db_table2, $db_where);
					if ($countnum > 0) {
						exit('false');
					}
				}
			} else {
				if ($countnum > 0) {
					$dirname = $dirname . mt_rand(10, 99);
				} else {
					$countnum = $this->db_numrows($db_table2, $db_where);
					if ($countnum > 0) {
						$dirname = $dirname . mt_rand(10, 99);
					}
				}
			}

			$subpath = admin_ROOT . $this->CON['file_htmldir'];
			if (!$this->fun->filemode($subpath)) {
				exit('false');
			}

			if ($this->CON['is_alonelng']) {
				$subdir = $subpath . $dirname;
			} else {

				$lngdir = $this->get_lng_dirpack($lng);
				$subdir = $subpath . $lngdir . '/' . $dirname;
			}
			if (!is_dir($subdir)) {
				if (!@mkdir($subdir, 0777, true)) exit('false');
			}
			$db_field = 'pid,mid,lng,subjectname,keywords,description,content,subpic,dirname,purview,isclass,styleid,indextemplates,template,filenamestyle,dirpath,addtime,ishtml,iswap,waptempalte,pagemax';
			$db_values = "50,$mid,'$lng','$subjectname','$keywords','$description','$content','$subpic','$dirname',$purview,1,$styleid,'$indextemplates','$template','$filenamestyle','$dirname',$date,$ishtml,$iswap,'$waptempalte',$pagemax";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['subjectmanage_add_log'], $this->lng['log_extra_ok'] . ' subjectname=' . $subjectname);
			$this->dbcache->clearcache('subjectlist_array_' . $lng, true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$sid = $this->fun->accept('sid', 'P');
			$db_where = 'sid=' . $sid;
			$db_set = "subjectname='$subjectname',keywords='$keywords',description='$description',content='$content',subpic='$subpic',purview=$purview,styleid=$styleid,indextemplates='$indextemplates',template='$template',filenamestyle='$filenamestyle',ishtml=$ishtml,iswap=$iswap,waptempalte='$waptempalte',pagemax=$pagemax";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['subjectmanage_edit_log'], $this->lng['log_extra_ok'] . ' subjectname=' . $typename . ' sid=' . $sid);
			$this->dbcache->clearcache('subjectlist_view_' . $sid, true);
			$this->dbcache->clearcache('subjectlist_array_' . $lng, true);
			exit('true');
		}
	}

	function onsubdel() {

		$db_table = db_prefix . 'subjectlist';
		$sid = $this->fun->accept('sid', 'R');
		if (empty($sid)) exit('false');

		$subpath = admin_ROOT . $this->CON['file_htmldir'];
		if (!$this->fun->filemode($subpath)) {
			exit('false');
		}
		$db_where = 'sid=' . $sid;
		$subread = $this->get_subjectlist_purview($sid);
		if ($this->CON['is_alonelng']) {
			$dirpath = $subread['dirpath'];
		} else {

			$lngdir = $this->get_lng_dirpack($subread['lng']);
			$dirpath = $lngdir . '/' . $subread['dirpath'];
		}

		if (!empty($dirpath)) {
			$subdir = $subpath . $dirpath;
			if ($this->fun->filemode($subdir)) {

				$this->fun->delfile($subdir);
			}
		}

		$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->writelog($this->lng['subjectmanage_del_log'], $this->lng['log_extra_ok'] . ' sid=' . $sid);
		$this->dbcache->clearcache('subjectlist_view_' . $sid, true);
		$this->dbcache->clearcache('subjectlist_array', true);
		exit('true');
	}

	function onsort() {
		$db_table = db_prefix . 'subjectlist';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "sid=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
				$this->dbcache->clearcache('subjectlist_view_' . $value, true);
			}
		}
		$this->writelog($this->lng['subjectmanage_log_sort'], $this->lng['log_extra_ok']);
		$this->dbcache->clearcache('subjectlist_array', true);
		exit('true');
	}

	function onsubsetting() {
		$db_table = db_prefix . 'subjectlist';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "sid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['subjectmanage_log_istype'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('subjectlist_', true);
		exit('true');
	}

	function oncheckdirname() {
		$dirname = $this->fun->accept('dirname', 'R');

		$lng = $this->sitelng;
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		if (empty($dirname) || empty($lng)) {
			exit('false');
		}
		if (!preg_match("/^[\w-]+$/i", $dirname)) {
			exit('false');
		}
		$db_table = db_prefix . 'subjectlist';
		$db_table2 = db_prefix . 'typelist';
		$db_where = " WHERE dirname='$dirname' AND lng='$lng'";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			$exportAjax = 'false';
		} else {
			$countnum = $this->db_numrows($db_table2, $db_where);
			if ($countnum > 0) {
				$exportAjax = 'false';
			} else {
				$exportAjax = 'true';
			}
		}
		exit($exportAjax);
	}

}

?>