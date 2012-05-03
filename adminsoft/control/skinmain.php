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

	function onskinlist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$wheretext = null;
		$lockin = $this->fun->accept('lockin', 'R');
		if (!empty($lockin)) {
			if ($lockin == 2) $lockin = 0;
			$wheretext.=' AND lockin=' . $lockin;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'skid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_where = " WHERE skid>0" . $wheretext;
		$db_table = db_prefix . 'skin';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT skid,name,code,lockin,isclass,addtime FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('template/skin_list');
	}

	function onskinadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('lng', $lng['list']);
		$this->ectemplates->display('template/skin_add');
	}

	function onsave() {
		$inputclass = $this->fun->accept('inputclass', 'P');
		$name = $this->fun->accept('name', 'P');
		$code = $this->fun->accept('code', 'P');
		if (empty($code) || empty($name)) {
			exit('false');
		}
		$db_table = db_prefix . 'skin';
		$date = time();
		if ($inputclass == 'add') {
			$db_field = 'name,code,lockin,isclass,addtime';
			$db_values = "'$name','$code',0,0,$date";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['skinmain_add_log'], $this->lng['log_extra_ok'] . ' name=' . $name);
			exit('true');
		}
	}

	function ondelskin() {
		$db_table = db_prefix . 'skin';
		$skid = $this->fun->accept('skid', 'R');
		if (empty($skid)) exit('false');
		$isclass = $this->fun->accept('isclass', 'R');
		if ($isclass == 1) exit('false');
		$db_where = "skid=$skid and lockin=0 and isclass=0";
		$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->writelog($this->lng['skinmain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $skid);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'skin';
		$db_table2 = db_prefix . 'config';
		$skid = $this->fun->accept('skid', 'R');
		if (empty($skid)) exit('false');
		$code = $this->fun->accept('code', 'R');
		$isclass = $this->fun->accept('isclass', 'R');
		if ($isclass == 1) {

			if (empty($code)) exit('false');
			$dir = admin_ROOT . 'templates/' . $code;
			if (!is_dir($dir)) exit('false');
		}

		$db_set = "isclass=0";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set);

		$db_set = "isclass=$isclass";
		$db_where = "skid= $skid";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

		$db_set = "value='$code'";
		$db_where = "valname='default_templates'";
		$this->db->query('UPDATE ' . $db_table2 . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['skinmain_class_log'], $this->lng['log_extra_ok'] . ' id=' . $skid);
		$this->systemfile(true);
		exit('true');
	}

	function oncheckcode() {
		$attlist = array('default', 'bbs', 'admin', 'user', 'aaaa', 'bbb');
		$code = $this->fun->accept('code', 'R');
		$codenew = strtolower($code);

		if (in_array($codenew, $attlist)) {
			exit('false');
		}
		$db_table = db_prefix . 'skin';
		$db_where = " WHERE code='$code'";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			$exportAjax = 'false';
		} else {
			$exportAjax = 'true';
		}
		exit($exportAjax);
	}

}

?>