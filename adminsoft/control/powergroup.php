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

	function ongrouplist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');
		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$wheretext = null;
		$delclass = $this->fun->accept('delclass', 'R');
		if (!empty($delclass)) {
			if ($delclass == 2) $delclass = 0;
			$wheretext.=' AND delclass=' . $delclass;
		}
		$db_where = " WHERE id>0" . $wheretext;
		$db_table = db_prefix . 'admin_powergroup';
		if (!empty($countnum)) {

			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT id,powername,powerlist,delclass FROM ' . $db_table . $db_where . ' ORDER BY id DESC LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}

		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('admin/admin_group_list');
	}

	function ongroupadd() {
		parent::start_template();

		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$powermenulist = $this->get_powermenulist();
		$this->ectemplates->assign('powermenulist', $powermenulist);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('admin/admin_group_add');
	}

	function ongroupedit() {
		parent::start_template();
		$db_table = db_prefix . 'admin_powergroup';
		$id = $this->fun->accept('id', 'G');
		$db_where = 'id=' . $id;
		$rsList = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$powermenulist = $this->get_powermenulist();
		$powerlist = explode('|', $rsList['powerlist']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('groupinfo', $rsList);
		$this->ectemplates->assign('powermenulist', $powermenulist);
		$this->ectemplates->assign('powerlist', $powerlist);
		$this->ectemplates->display('admin/admin_group_edit');
	}

	function onpowerlistsava() {
		$db_table = db_prefix . 'admin_powergroup';
		$inputclass = $this->fun->accept('inputclass', 'P');
		$powername = $this->fun->accept('powername', 'R');
		$powerlist = $this->fun->accept('powerlist', 'P');
		$powertext = implode('|', $powerlist);
		if ($inputclass == 'add') {
			$db_field = 'powername,powerlist,delclass';
			$db_values = "'$powername','$powertext',0";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['grouplist_add_log'], $this->lng['log_extra_ok'] . ' powername=' . $powername);
			$this->dbcache->clearcache('power_', true);
			$this->dbcache->clearcache('menu_', true);
			exit('true');
		}
		if ($inputclass == 'edit') {
			$id = $this->fun->accept('id', 'P');
			$db_where = "id=$id";
			$db_set = "powername='$powername',powerlist='$powertext'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['grouplist_edit_log'], $this->lng['log_extra_ok'] . ' powername=' . $powername);
			$this->dbcache->clearcache('power_', true);
			$this->dbcache->clearcache('menu_', true);
			exit('true');
		}
	}

	function ondelgroup() {
		$db_table = db_prefix . 'admin_powergroup';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "id=$infoarray[$i] and delclass=0";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['grouplist_del_log'], $this->lng['log_extra_ok'] . ' userid=' . $selectinfoid);
		$this->dbcache->clearcache('power_', true);
		$this->dbcache->clearcache('menu_', true);
		exit('true');
	}

}

?>