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

	function onseolinklist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');
		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}

		$listtype = $this->fun->accept('listtype', 'R');

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$islink = $this->fun->accept('islink', 'R');
		if (!empty($islink)) {
			if ($islink == 2) $islink = 0;
			$db_where.=' AND islink=' . $islink;
		}
		$isreplace = $this->fun->accept('isreplace', 'R');
		if (!empty($isreplace)) {
			if ($isreplace == 2) $isreplace = 0;
			$db_where.=' AND isreplace=' . $isreplace;
		}
		$istop = $this->fun->accept('istop', 'R');
		if (!empty($istop)) {
			if ($istop == 2) $istop = 0;
			$db_where.=' AND istop=' . $istop;
		}
		$mid = intval($this->fun->accept('mid', 'R'));
		if (!empty($mid)) {
			$db_where.=' AND mid=' . $mid;
		}
		$tid = intval($this->fun->accept('tid', 'R'));
		if (!empty($tid)) {
			$db_where.=' AND ' . $this->get_typeid($tid, 'tid', 0, $mid, 0, $lng);
		}
		$serchekey = $this->fun->accept('serchekey', 'R');
		if (!empty($serchekey)) {
			$db_where.=" AND keywordname like '%$serchekey%'";
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'kid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;

		$db_table = db_prefix . 'keylink';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$templatesfile = ($listtype == 'tab') ? 'seomanage/keylink_window_list' : 'seomanage/keylink_list';
		$this->ectemplates->display($templatesfile);
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
		$inputtext = empty($inputtext) ? 'keywords' : $inputtext;
		$this->ectemplates->assign('inputtext', $inputtext);

		$modelarray = $this->get_model($mid, $lng, 1);
		$this->ectemplates->assign('modelarray', $modelarray['list']);

		$typelist = $this->get_typeselect($mid, 0, $tid, $lng, 0, 1, true, false);
		$this->ectemplates->assign('typelist', $typelist);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('tid', $tid);

		$listfunction = $this->fun->accept('listfunction', 'R');
		$inputtext = empty($inputtext) ? 'keywords' : $inputtext;
		$this->ectemplates->assign('listfunction', $listfunction);
		$this->ectemplates->display('seomanage/keylink_window');
	}

	function onkeylinkadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$mid = intval($this->fun->accept('mid', 'R'));
		$mid = empty($mid) ? 0 : $mid;

		$tid = intval($this->fun->accept('tid', 'R'));
		$tid = empty($tid) ? 0 : $tid;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$typelist = $this->get_typeselect($mid, 0, $tid, $lng, 0, 1, true, false);
		$this->ectemplates->assign('typelist', $typelist);

		$model = $this->get_modelview($mid, 'modelname');
		$this->ectemplates->assign('model', $model);

		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('tid', $tid);
		$this->ectemplates->assign('domain', $this->CON['domain']);
		$this->ectemplates->display('seomanage/keylink_add');
	}

	function onkeylinkedit() {
		parent::start_template();
		$db_table = db_prefix . 'keylink';
		$id = $this->fun->accept('id', 'G');
		$db_where = 'kid=' . $id;
		$keyread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$typelist = $this->get_typeselect($keyread['mid'], 0, $keyread['tid'], $keyread['lng'], 0, 1, true, false);
		$this->ectemplates->assign('typelist', $typelist);

		$model = $this->get_modelview($keyread['mid'], 'modelname');
		$this->ectemplates->assign('model', $model);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('keyread', $keyread);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->display('seomanage/keylink_edit');
	}

	function onkeylinksave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$keywordname = $this->fun->accept('keywordname', 'P');
		$islink = $this->fun->accept('islink', 'P');
		$islink = empty($islink) ? 0 : $islink;
		$linkurl = $this->fun->accept('linkurl', 'P');
		$linkurl = empty($linkurl) ? '' : $linkurl;
		$istop = $this->fun->accept('istop', 'P');
		$istop = empty($istop) ? 0 : $istop;
		$isreplace = $this->fun->accept('isreplace', 'P');
		$isreplace = empty($isreplace) ? 0 : $isreplace;
		$mid = intval($this->fun->accept('mid', 'P'));
		$tid = intval($this->fun->accept('tid', 'P'));
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$db_table = db_prefix . 'keylink';
		if ($inputclass == 'add') {
			$db_field = 'lng,pid,mid,tid,hit,keywordname,linkurl,islink,istop,isclass,isreplace';
			$db_values = "'$lng',50,$mid,$tid,0,'$keywordname','$linkurl',$islink,$istop,1,$isreplace";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['seomanage_add_log'], $this->lng['log_extra_ok'] . ' keywordname=' . $keywordname);
			$this->dbcache->clearcache('keylink_array_' . $lng, true);
			exit('true');
		} else {
			$id = $this->fun->accept('id', 'P');
			$db_where = 'kid=' . $id;
			$db_set = "keywordname='$keywordname',tid=$tid,linkurl='$linkurl',islink=$islink,istop=$istop";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['seomanage_edit_log'], $this->lng['log_extra_ok'] . ' keywordname=' . $keywordname . ' id=' . $id);
			$this->dbcache->clearcache('keylink_array_' . $lng, true);
			exit('true');
		}
	}

	function ondelkey() {
		$db_table = db_prefix . 'keylink';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "kid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['seomanage_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('keylink_array', true);
		exit('true');
	}

	function onkeysort() {
		$db_table = db_prefix . 'keylink';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "kid=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		}
		$this->writelog($this->lng['seomanage_log_sort'], $this->lng['log_extra_ok']);
		$this->dbcache->clearcache('keylink_array', true);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'keylink';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "kid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['seomanage_log_istype'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('keylink_array', true);
		exit('true');
	}

	function onseolinktypelist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');
		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}

		$listtype = $this->fun->accept('listtype', 'R');

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$mid = intval($this->fun->accept('mid', 'R'));
		if (!empty($mid)) {
			$db_where.=' AND mid=' . $mid;
		}

		$tid = intval($this->fun->accept('tid', 'R'));
		if (!empty($tid)) {
			$db_where.=' AND ' . $this->get_typeid($tid, 'tid', 0, $mid, 0, $lng);
		}

		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}

		$serchekey = $this->fun->accept('serchekey', 'R');
		if (!empty($serchekey)) {
			$db_where.=" AND keytypename like '%$serchekey%'";
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'ktid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'keylink_type';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);

		$templatesfile = ($listtype == 'tab') ? 'seomanage/keylinktype_window_list' : 'seomanage/keylinktype_list';
		$this->ectemplates->display($templatesfile);
	}

	function onkeylinktypeadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$mid = intval($this->fun->accept('mid', 'R'));
		$mid = empty($mid) ? 0 : $mid;

		$tid = intval($this->fun->accept('tid', 'R'));
		$tid = empty($tid) ? 0 : $tid;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$model = $this->get_modelview($mid, 'modelname');
		$this->ectemplates->assign('model', $model);

		$typelist = $this->get_typeselect($mid, 0, $tid, $lng, 0, 1, true, false);
		$this->ectemplates->assign('typelist', $typelist);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('tid', $tid);
		$this->ectemplates->assign('domain', $this->CON['domain']);
		$this->ectemplates->display('seomanage/keylinktype_add');
	}

	function onkeylinktypeedit() {
		parent::start_template();
		$db_table = db_prefix . 'keylink_type';
		$id = $this->fun->accept('id', 'G');
		$db_where = 'ktid=' . $id;
		$keyread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$typelist = $this->get_typeselect($keyread['mid'], 0, $keyread['tid'], $keyread['lng'], 0, 1, true, false);
		$this->ectemplates->assign('typelist', $typelist);

		$model = $this->get_modelview($keyread['mid'], 'modelname');
		$this->ectemplates->assign('model', $model);

		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('keyread', $keyread);
		$this->ectemplates->display('seomanage/keylinktype_edit');
	}

	function onkeylinktypesave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$keytypename = $this->fun->accept('keytypename', 'P');
		$keyworklist = $this->fun->accept('keyworklist', 'P');
		$description = $this->fun->accept('description', 'P');
		$mid = $this->fun->accept('mid', 'P');
		$tid = $this->fun->accept('tid', 'P');
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$db_table = db_prefix . 'keylink_type';
		if ($inputclass == 'add') {
			$db_field = 'lng,mid,tid,keytypename,keyworklist,description,isclass';
			$db_values = "'$lng',$mid,$tid,'$keytypename','$keyworklist','$description',1";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['seomanage_type_add_log'], $this->lng['log_extra_ok'] . ' keytypename=' . $keytypename);
			$this->dbcache->clearcache('keylinktype_array_' . $lng, true);
			exit('true');
		} else {
			$id = $this->fun->accept('id', 'P');
			$db_where = 'ktid=' . $id;
			$db_set = "tid=$tid,keytypename='$keytypename',keyworklist='$keyworklist',description='$description'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['seomanage_type_edit_log'], $this->lng['log_extra_ok'] . ' keytypename=' . $keytypename . ' id=' . $id);
			$this->dbcache->clearcache('keylinktype_array_' . $lng, true);
			$this->dbcache->clearcache('keylinktype_view_' . $id, true);
			exit('true');
		}
	}

	function ondelkeytype() {
		$db_table = db_prefix . 'keylink_type';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "ktid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['seomanage_type_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('keylinktype_array', true);
		exit('true');
	}

}

?>