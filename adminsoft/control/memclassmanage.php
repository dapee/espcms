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

	function onmemclasslist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_table = db_prefix . 'member_class';
		$db_where = ' WHERE mcid>0';
		$isinter = $this->fun->accept('isinter', 'R');
		if (!empty($isinter)) {
			if ($isinter == 2) $isinter = 0;
			$db_where.=' AND isinter=' . $isinter;
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
		$limitkey = empty($limitkey) ? 'mcid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;

		$sql = 'SELECT mcid,rankname,isinter,integra,isclass,lockin FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('member/class_list');
	}

	function onclassadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('member/class_add');
	}

	function onclassedit() {
		parent::start_template();
		$db_table = db_prefix . 'member_class';
		$mcid = intval($this->fun->accept('mcid', 'G'));
		$db_where = 'mcid=' . $mcid;
		$classread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('classread', $classread);
		$this->ectemplates->display('member/class_edit');
	}

	function onclasssave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$integra = $this->fun->accept('integra', 'P');
		$integra = empty($integra) ? 0 : $integra;
		$rankname = $this->fun->accept('rankname', 'P');
		$isinter = $this->fun->accept('isinter', 'P');
		$db_table = db_prefix . 'member_class';
		$date = time();
		if ($inputclass == 'add') {
			$db_field = 'rankname,isinter,integra,isclass,lockin';
			$db_values = "'$rankname',$isinter,$integra,0,0";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['memclassmanage_add_log'], $this->lng['log_extra_ok'] . ' rankname=' . $rankname);
			$this->dbcache->clearcache('memberclass_array', true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$mcid = $this->fun->accept('mcid', 'P');
			$db_where = 'mcid=' . $mcid;
			$db_set = "rankname='$rankname',isinter=$isinter,integra=$integra";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['memclassmanage_edit_log'], $this->lng['log_extra_ok'] . ' subjectname=' . $typename . ' sid=' . $sid);
			$this->dbcache->clearcache('memberclass_array', true);
			$this->dbcache->clearcache('memberclass_view_' . $mcid, true);
			exit('true');
		}
	}

	function onmemberclassdel() {
		$db_table = db_prefix . 'member_class';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "mcid=$infoarray[$i] AND lockin=0";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
			$this->dbcache->clearcache('memberclass_view_' . $infoarray[$i], true);
		}
		$this->writelog($this->lng['memclassmanage_del_log'], $this->lng['log_extra_ok'] . ' mcid=' . $selectinfoid);
		$this->dbcache->clearcache('memberclass_array', true);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'member_class';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "mcid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['memclassmanage_set_log'], $this->lng['log_extra_ok'] . ' mcid=' . $selectinfoid);
		$this->dbcache->clearcache('memberclass_array', true);
		exit('true');
	}

}

?>