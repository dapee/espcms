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

	function onbbstypelist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_table = db_prefix . 'bbs_typelist';
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$purview = $this->fun->accept('purview', 'R');
		if (!empty($purview)) {
			$db_where.=' AND purview=' . $purview;
		}
		$isclass = intval($this->fun->accept('isclass', 'R'));
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}

		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'btid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;

		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$puvname = $this->get_member_purview($rsList['purview'], 'rankname');
			$rsList['puvname'] = empty($puvname) ? $this->lng['puv_no'] : $puvname;
			$array[] = $rsList;
		}
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('bbs/bbs_type_list');
	}

	function onbbstypeadd() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$memberpuv = $this->get_member_purview_array();
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('timelist', $TIMELIST);
		$this->ectemplates->display('bbs/bbs_type_add');
	}

	function onbbstypeedit() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$db_table = db_prefix . 'bbs_typelist';
		$btid = intval($this->fun->accept('btid', 'G'));
		$db_where = 'btid=' . $btid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$memberpuv = $this->get_member_purview_array($read['purview']);
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('timelist', $TIMELIST);
		$this->ectemplates->display('bbs/bbs_type_edit');
	}

	function onsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$typename = $this->fun->accept('typename', 'P');
		$content = $this->fun->accept('content', 'P');
		$content = empty($content) ? '' : $this->fun->Text2Html($content);
		$purview = $this->fun->accept('purview', 'P');
		$ispage = $this->fun->accept('ispage', 'P');
		$isclass = $this->fun->accept('isclass', 'P');
		$pagemax = $this->fun->accept('pagemax', 'P');
		$listmax = $this->fun->accept('listmax', 'P');
		$isaddclass = $this->fun->accept('isaddclass', 'P');
		$ismail = $this->fun->accept('ismail', 'P');
		$putmail = $this->fun->accept('putmail', 'P');
		$mailcode = $this->fun->accept('mailcode', 'P');
		$ismenu = $this->fun->accept('ismenu', 'P');
		$isseccode = $this->fun->accept('isseccode', 'P');
		$inputtime = $this->fun->accept('inputtime', 'P');
		$iswap = $this->fun->accept('iswap', 'P');

		$db_table = db_prefix . 'bbs_typelist';
		$date = time();
		if ($inputclass == 'add') {
			$db_field = 'pid,lng,typename,content,purview,ispage,isclass,addtime,pagemax,listmax,isaddclass,ismail,putmail,mailcode,ismenu,isseccode,inputtime,iswap';
			$db_values = "50,'$lng','$typename','$content',$purview,$ispage,1,$date,$pagemax,$listmax,$isaddclass,$ismail,'$putmail','$mailcode',$ismenu,$isseccode,$inputtime,$iswap";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['forumtype_add_log'], $this->lng['log_extra_ok'] . ' typename=' . $typename);
			$this->dbcache->clearcache('bbs_typelist_array_' . $lng, true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$btid = $this->fun->accept('btid', 'P');
			$db_where = 'btid=' . $btid;
			$db_set = "typename='$typename',content='$content',purview=$purview,ispage=$ispage,pagemax=$pagemax,listmax=$listmax,isaddclass=$isaddclass,ismail=$ismail,putmail='$putmail',mailcode='$mailcode',ismenu=$ismenu,isseccode=$isseccode,inputtime=$inputtime,iswap=$iswap";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['forumtype_edit_log'], $this->lng['log_extra_ok'] . ' typename=' . $typename . ' id=' . $btid);
			$this->dbcache->clearcache('bbs_typelist_view_' . $btid, true);
			$this->dbcache->clearcache('bbs_typelist_array_' . $lng, true);
			exit('true');
		}
	}

	function onbbstypedel() {
		$db_table = db_prefix . 'bbs_typelist';
		$db_table2 = db_prefix . 'bbs';
		$btid = $this->fun->accept('btid', 'R');
		if (empty($btid)) exit('false');
		$db_where = 'btid=' . $btid;
		$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where);
		$this->dbcache->clearcache('bbs_view', true);
		$this->dbcache->clearcache('bbs_list_array_' . $btid, true);
		$this->dbcache->clearcache('bbs_typelist_view_' . $btid, true);
		$this->dbcache->clearcache('bbs_typelist_array', true);
		$this->writelog($this->lng['forumtype_del_log'], $this->lng['log_extra_ok'] . ' id=' . $btid);
		exit('true');
	}

	function onsort() {
		$db_table = db_prefix . 'bbs_typelist';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "btid=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
				$this->dbcache->clearcache('bbs_typelist_view_' . $value, true);
			}
		}
		$this->writelog($this->lng['forumtype_log_sort'], $this->lng['log_extra_ok']);
		$this->dbcache->clearcache('bbs_typelist_array', true);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'bbs_typelist';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "btid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['forumtype_log_istype'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('bbs_typelist', true);
		exit('true');
	}

}

?>