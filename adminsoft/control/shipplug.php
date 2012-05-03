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

	function onshiplist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_where = " WHERE osid>0";
		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$iscash = $this->fun->accept('iscash', 'R');
		if (!empty($iscash)) {
			if ($iscash == 2) $iscash = 0;
			$db_where.=' AND iscash=' . $iscash;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'osid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;

		$db_table = db_prefix . 'order_shipping';
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
		$this->ectemplates->display('order/order_shiplist');
	}

	function onshipplugadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('order/order_shipplugadd');
	}

	function onshipplugedit() {
		parent::start_template();
		$osid = $this->fun->accept('osid', 'G');
		$db_table = db_prefix . 'order_shipping';
		$db_where = 'osid=' . $osid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->display('order/order_shipplugedit');
	}

	function onshipsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$title = $this->fun->accept('title', 'P');
		$content = $this->fun->accept('content', 'P');
		$price = $this->fun->accept('price', 'P');
		$markup = $this->fun->accept('markup', 'P');
		$iscash = $this->fun->accept('iscash', 'P');
		$isinsure = $this->fun->accept('isinsure', 'P');
		$isinsure = empty($isinsure) ? 0 : $isinsure;
		$insureper = $this->fun->accept('insureper', 'P');
		$insureper = empty($insureper) ? 0 : $insureper;
		$db_table = db_prefix . 'order_shipping';
		$date = time();
		if ($inputclass == 'add') {
			$db_field = 'pid,title,content,price,markup,isclass,iscash,isinsure,insureper,addtime';
			$db_values = "50,'$title','$content',$price,$markup,0,$iscash,$isinsure,$insureper,$date";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['ordershipping_add_log'], $this->lng['log_extra_ok'] . ' title=' . $title);
			$this->dbcache->clearcache('ordership_array', true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$osid = $this->fun->accept('osid', 'P');
			$db_where = 'osid=' . $osid;
			$db_set = "title='$title',content='$content',price=$price,markup=$markup,iscash=$iscash,isinsure=$isinsure,insureper=$insureper";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['ordershipping_edit_log'], $this->lng['log_extra_ok'] . ' title=' . $title . ' id=' . $osid);
			$this->dbcache->clearcache('ordership_view_' . $osid, true);
			$this->dbcache->clearcache('ordership_array', true);
			exit('true');
		}
	}

	function onsort() {
		$db_table = db_prefix . 'order_shipping';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "osid=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		}
		$this->writelog($this->lng['ordershipping_sort_log'], $this->lng['log_extra_ok']);
		$this->dbcache->clearcache('ordership_array', true);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'order_shipping';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "osid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['ordershipping_set_log'], $this->lng['log_extra_ok'] . ' osid=' . $selectinfoid);
		$this->dbcache->clearcache('ordership_array', true);
		exit('true');
	}

	function onshipplugdel() {
		$db_table = db_prefix . 'order_shipping';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "osid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
			$this->dbcache->clearcache('ordership_view_' . $infoarray[$i], true);
		}
		$this->writelog($this->lng['ordershipping_del_log'], $this->lng['log_extra_ok'] . ' osid=' . $selectinfoid);
		$this->dbcache->clearcache('ordership_array', true);
		exit('true');
	}

}
?>