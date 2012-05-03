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

	function onlanpacklist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');
		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$wheretext = null;
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';
		$typeid = $this->fun->accept('typeid', 'R');
		if (!empty($typeid)) {
			$db_where.=' AND typeid=' . $typeid;
		}
		$lockin = $this->fun->accept('lockin', 'R');
		if (!empty($lockin)) {
			if ($lockin == 2) $lockin = 0;
			$db_where.=' AND lockin=' . $lockin;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'lpid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'ASC' : $limitclass;
		$db_table = db_prefix . 'lngpack';
		if (!empty($countnum)) {

			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT lpid,pid,lng,title,keycode,langstr,lockin,typeid FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rsList['langstr'] = strip_tags($rsList['langstr']);
			$array[] = $rsList;
		}

		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('admin/admin_lngpack_list');
	}

	function onlanpackadd() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('lantype', $LANPACKTYPE);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('admin/admin_lngpack_add');
	}

	function onlanpackedit() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$db_table = db_prefix . 'lngpack';
		$lpid = $this->fun->accept('lpid', 'G');
		$db_where = 'lpid=' . $lpid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('lantype', $LANPACKTYPE);
		$this->ectemplates->display('admin/admin_lngpack_edit');
	}

	function onsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$keycode = $this->fun->accept('keycode', 'P');
		$title = $this->fun->accept('title', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$langstr = $this->fun->accept('langstr', 'P');
		$typeid = $this->fun->accept('typeid', 'P');
		$db_table = db_prefix . 'lngpack';
		if ($inputclass == 'add') {
			$db_field = 'pid,lng,title,keycode,langstr,lockin,typeid';
			$db_values = "50,'$lng','$title','$keycode','$langstr',0,$typeid";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['languagepack_add_log'], $this->lng['log_extra_ok'] . ' title=' . $title);
			$this->creat_lanpack($lng, true);
			exit('true');
		} else {
			$lpid = $this->fun->accept('lpid', 'P');
			$db_where = 'lpid=' . $lpid;
			$db_set = "title='$title',langstr='$langstr',typeid=$typeid";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->creat_lanpack($lng, true);
			$this->writelog($this->lng['languagepack_edit_log'], $this->lng['log_extra_ok'] . ' title=' . $title . ' id=' . $lpid);
			exit('true');
		}
	}

	function onlanpackdel() {
		$db_table = db_prefix . 'lngpack';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "lpid=$infoarray[$i] and lockin=0";
			if ($i == 0) {
				$read = $this->db->fetch_first('SELECT lng FROM ' . $db_table . ' WHERE ' . $db_where);
				$lng = $read['lng'];
				if (empty($lng)) {
					exit('false');
				}
			}
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->creat_lanpack($lng, true);
		$this->writelog($this->lng['languagepack_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function oncodedb() {
		$codename = $this->fun->accept('codename', 'R');
		$lng = $this->fun->accept('lng', 'R');
		$db_table = db_prefix . 'lngpack';
		$db_where = " WHERE lng='$lng' and keycode='$codename'";
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