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

	function onrecomlist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_table = db_prefix . 'document_label';

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$mid = $this->fun->accept('mid', 'R');
		if (!empty($mid)) {
			$db_where.= ' AND mid=' . $mid;
		}

		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'dlid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;

		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$modelname = $this->get_modelview($rsList['mid'], 'modelname');
			$rsList['modelname'] = $modelname;
			$array[] = $rsList;
		}
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('article/recommand_list');
	}

	function onrecomadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$lng = $this->sitelng;
		$mid = $this->fun->accept('mid', 'G');
		$mid = empty($mid) ? 0 : $mid;

		$modelarray = $this->get_model($mid, $lng, 0, 2,0);
		$this->ectemplates->assign('modelarray', $modelarray['list']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('upid', $upid);
		$this->ectemplates->display('article/recommand_add');
	}

	function onrecomedit() {
		parent::start_template();
		$db_table = db_prefix . 'document_label';
		$type = $this->fun->accept('type', 'G');
		$dlid = intval($this->fun->accept('dlid', 'G'));
		$db_where = 'dlid=' . $dlid;
		$recomread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('recomread', $recomread);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->display('article/recommand_edit');
	}

	function onrecomsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$mid = $this->fun->accept('mid', 'P');
		$mid = empty($mid) ? 0 : $mid;
		$lng = $this->fun->accept('lng', 'P');
		$lng = empty($lng) ? $this->sitelng : $lng;
		$labelname = $this->fun->accept('labelname', 'P');
		$db_table = db_prefix . 'document_label';
		$date = time();
		if ($inputclass == 'add') {
			$db_field = 'lng,mid,labelname';
			$db_values = "'$lng',$mid,'$labelname'";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['recommanage_add_log'], $this->lng['log_extra_ok'] . ' labelname=' . $labelname);
			$this->dbcache->clearcache('doclabel_array_' . $mid, true);
			$this->dbcache->clearcache('doclabel_array_0', true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$dlid = $this->fun->accept('dlid', 'P');
			$db_where = 'dlid=' . $dlid;
			$db_set = "labelname='$labelname'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['recommanage_edit_log'], $this->lng['log_extra_ok'] . ' labelname=' . $labelname . ' dlid=' . $dlid);
			$this->dbcache->clearcache('doclabel_array_' . $mid, true);
			$this->dbcache->clearcache('doclabel_array_0', true);
			exit('true');
		}
	}

	function ondelrecomm() {
		$db_table = db_prefix . 'document_label';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "dlid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['recommanage_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('doclabel_array', true);
		exit('true');
	}

}

?>