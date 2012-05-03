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

	function onadvertlist() {
		parent::start_template();

		$MinPageid = intval($this->fun->accept('MinPageid', 'R'));

		$page_id = intval($this->fun->accept('page_id', 'R'));

		$countnum = intval($this->fun->accept('countnum', 'R'));

		$MaxPerPage = intval($this->fun->accept('MaxPerPage', 'R'));
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$isclass = intval($this->fun->accept('isclass', 'R'));
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$atid = intval($this->fun->accept('atid', 'R'));
		if (!empty($atid)) {
			$db_where.=' AND atid=' . $atid;
		}
		$adtype = intval($this->fun->accept('adtype', 'R'));
		if (!empty($adtype)) {
			$db_where.=' AND adtype=' . $adtype;
		}
		$istime = intval($this->fun->accept('istime', 'R'));
		if (!empty($istime)) {
			if ($istime == 2) $istime = 0;
			$db_where.=' AND istime=' . $istime;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'adid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'advert';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$typename = $this->get_advert_type_view($rsList['atid'], 'adtypename');
			$rsList['adtypename'] = $typename;
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->display('advert/advert_list');
	}

	function onadvertadd() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$atid = intval($this->fun->accept('atid', 'R'));
		$atid = empty($atid) ? 0 : $atid;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$advert_typearray = $this->get_advert_type_array($atid, $lng);
		$this->ectemplates->assign('typelist', $advert_typearray['list']);

		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('adtype', $BANNTYPE);
		$this->ectemplates->assign('atid', $atid);
		$this->ectemplates->display('advert/advert_add');
	}

	function onadvertedit() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$type = $this->fun->accept('type', 'R');
		$type = empty($type) ? 'edit' : $type;

		$adid = intval($this->fun->accept('adid', 'R'));
		if (empty($adid)) exit('false');
		$read = $this->get_advert($adid);

		$advert_typearray = $this->get_advert_type_array($read['atid'], $read['lng']);
		$this->ectemplates->assign('typelist', $advert_typearray['list']);
		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $read['lng']);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('adtype', $BANNTYPE);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('advert/advert_edit');
	}

	function oninfosave() {

		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$title = $this->fun->accept('title', 'P');
		$filename = $this->fun->accept('filename', 'P');
		$url = $this->fun->accept('url', 'P');
		$atid = intval($this->fun->accept('atid', 'P'));
		$atid = empty($atid) ? 0 : $atid;
		$adtype = intval($this->fun->accept('adtype', 'P'));
		$adtype = empty($adtype) ? 0 : $adtype;
		$addtime = $this->fun->accept('addtime', 'P');
		$time = time();
		$starttime = $this->fun->accept('starttime', 'P');
		$endtime = $this->fun->accept('endtime', 'P');
		$starttime = empty($starttime) ? 0 : strtotime($starttime);
		$endtime = empty($endtime) ? 0 : strtotime($endtime);
		$istime = intval($this->fun->accept('istime', 'P'));
		$istime = empty($istime) ? 0 : $istime;

		$isclass = $this->esp_inputclassid;
		$isclass = empty($isclass) ? 0 : $isclass;

		$db_table = db_prefix . 'advert';
		if ($inputclass == 'add') {
			$db_field = 'pid,atid,lng,title,filename,url,adtype,click,starttime,endtime,addtime,isclass,istime';
			$db_values = "50,$atid,'$lng','$title','$filename','$url',$adtype,0,$starttime,$endtime,$time,$isclass,$istime";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['advertmain_add_log'], $this->lng['log_extra_ok']);
			$this->dbcache->clearcache('advert_array_' . $atid, true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$adid = $this->fun->accept('adid', 'P');
			if (empty($adid)) exit('false');
			$db_where = 'adid=' . $adid;
			$db_set = "atid=$atid,title='$title',filename='$filename',url='$url',adtype=$adtype,starttime=$starttime,endtime=$endtime,istime=$istime";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['advertmain_edit_log'], $this->lng['log_extra_ok'] . ' id=' . $adid);
			$this->dbcache->clearcache('advert_' . $adid, true);
			$this->dbcache->clearcache('advert_array_' . $atid, true);
			exit('true');
		}
	}

	function onadvertdel() {
		$db_table = db_prefix . 'advert';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "adid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->dbcache->clearcache('advert_', true);
		$this->dbcache->clearcache('advert_array_', true);
		$this->writelog($this->lng['advertmain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onsort() {
		$db_table = db_prefix . 'advert';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "adid=$value";
				$db_set = "pid=$pidArray[$key]";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		}
		$this->dbcache->clearcache('advert_array_', true);
		$this->writelog($this->lng['advertmain_sort_log'], $this->lng['log_extra_ok']);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'advert';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "adid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->dbcache->clearcache('advert_array_', true);
		$this->writelog($this->lng['advertmain_setting_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

}

?>