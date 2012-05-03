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

	function oncallinglist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');
		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'cid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'calling';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rsList['typename'] = $this->calltype($rsList['type']);
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('callmain/call_list');
	}

	function oncalladd() {
		parent::start_template();
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';

		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$typeclass = array();
		foreach ($CALLTYPE as $key => $value) {
			$typeclass[$key]['style'] = $value['style'];
			$typeclass[$key]['url'] = $value['url'];
			$typeclass[$key]['key'] = $value['key'];
			$typeclass[$key]['name'] = $this->calltype($value['key']);
		}
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('style', $typeclass[0]['style']);
		$this->ectemplates->assign('type', $typeclass);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->display('callmain/call_add');
	}

	function oncalledit() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$db_table = db_prefix . 'calling';
		$cid = $this->fun->accept('cid', 'G');
		$db_where = 'cid=' . $cid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$typeclass = array();
		$stylelist = array();
		foreach ($CALLTYPE as $key => $value) {
			$typeclass[$key]['selected'] = $read['type'] == $value['key'] ? 'selected' : '';
			if ($read['type'] == $value['key']) {
				$stylelist = $value['style'];
			}
			$typeclass[$key]['style'] = $value['style'];
			$typeclass[$key]['url'] = $value['url'];
			$typeclass[$key]['key'] = $value['key'];
			$typeclass[$key]['name'] = $this->calltype($value['key']);
		}
		$this->ectemplates->assign('style', $stylelist);
		$this->ectemplates->assign('type', $typeclass);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->display('callmain/call_edit');
	}

	function onsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$name = $this->fun->accept('name', 'P');
		$type = $this->fun->accept('type', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$style = $this->fun->accept('style', 'P');
		$code = $this->fun->accept('code', 'P');
		$db_table = db_prefix . 'calling';
		$date = time();
		if ($inputclass == 'add') {
			$db_field = 'pid,lng,type,style,name,code,addtime,isclass';
			$db_values = "50,'$lng',$type,$style,'$name','$code',$date,1";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['callmain_add_log'], $this->lng['log_extra_ok'] . ' name=' . $name);
			$this->dbcache->clearcache('calling_array', true);
			exit('true');
		} else {
			$cid = $this->fun->accept('cid', 'P');
			if (empty($cid)) {
				exit('false');
			}
			$db_where = 'cid=' . $cid;
			$db_set = "type=$type,style=$style,name='$name',code='$code'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->dbcache->clearcache('calling_array', true);
			$this->writelog($this->lng['callmain_edit_log'], $this->lng['log_extra_ok'] . ' name=' . $name . ' id=' . $cid);
			exit('true');
		}
	}

	function oncalldel() {
		$db_table = db_prefix . 'calling';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "cid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->dbcache->clearcache('calling_array', true);
		$this->writelog($this->lng['callmain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onsort() {
		$db_table = db_prefix . 'calling';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "cid=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		}
		$this->dbcache->clearcache('calling_array', true);
		$this->writelog($this->lng['callmain_log_sort'], $this->lng['log_extra_ok']);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'calling';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');

		$value = $this->fun->accept('value', 'P');

		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "cid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->dbcache->clearcache('calling_array', true);
		$this->writelog($this->lng['callmain_log_isopen'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function calltype($type) {
		if (empty($type)) return false;
		switch ($type) {
			case 1:
				return $this->lng['callmain_text_type1'];
				break;
			case 2:
				return $this->lng['callmain_text_type2'];
				break;
			case 3:
				return $this->lng['callmain_text_type3'];
				break;
			case 4:
				return $this->lng['callmain_text_type4'];
				break;
			case 5:
				return $this->lng['callmain_text_type5'];
				break;
		}
	}

}

?>