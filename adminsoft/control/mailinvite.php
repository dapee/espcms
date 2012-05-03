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

	function onmailinvitelist() {
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

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'mlvid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'mailinvite_type';
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
		$this->ectemplates->display('mailinvite/mailinvite_type_list');
	}

	function onmailinviteadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('mailinvite/mailinvite_type_add');
	}

	function onmailinviteedit() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$type = $this->fun->accept('type', 'R');
		$type = empty($type) ? 'edit' : $type;
		$mlvid = intval($this->fun->accept('mlvid', 'R'));
		if (empty($mlvid)) exit('false');
		$db_table = db_prefix . 'mailinvite_type';
		$db_where = 'mlvid=' . $mlvid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $read['lng']);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('mailinvite/mailinvite_type_edit');
	}

	function oninfosave() {
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$title = $this->fun->accept('title', 'P');
		$content = $this->fun->accept('content', 'P');
		$time = time();
		$db_table = db_prefix . 'mailinvite_type';
		if ($inputclass == 'add') {
			$db_field = 'lng,title,content,purview,isclass,addtime';
			$db_values = "'$lng','$title','$content',0,1,$time";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['mailinvite_add_log'], $this->lng['log_extra_ok']);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$mlvid = $this->fun->accept('mlvid', 'P');
			if (empty($mlvid)) exit('false');
			$db_where = 'mlvid=' . $mlvid;
			$db_set = "title='$title',content='$content'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['mailinvite_edit_log'], $this->lng['log_extra_ok'] . ' id=' . $mlvid);
			exit('true');
		}
	}

	function onmailinvitedel() {
		$db_table = db_prefix . 'mailinvite_type';
		$db_table1 = db_prefix . 'mailinvite_list';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "mlvid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
			$this->db->query('DELETE FROM ' . $db_table1 . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['mailinvite_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'mailinvite_type';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "mlvid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['mailinvite_setting_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onmailinvitesendlist() {
		parent::start_template();

		$MinPageid = intval($this->fun->accept('MinPageid', 'R'));

		$page_id = intval($this->fun->accept('page_id', 'R'));

		$countnum = intval($this->fun->accept('countnum', 'R'));

		$MaxPerPage = intval($this->fun->accept('MaxPerPage', 'R'));
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$mlvid = $this->fun->accept('mlvid', 'R');
		if (empty($mlvid)) exit('false');
		$db_where = " WHERE mlvid=$mlvid";

		$isclass = intval($this->fun->accept('isclass', 'R'));
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'mlvlid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'mailinvite_list';
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
		$this->ectemplates->display('mailinvite/mailinvite_mail_list');
	}

	function onmailinvitemailedit() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$type = $this->fun->accept('type', 'R');
		$type = empty($type) ? 'edit' : $type;
		$mlvlid = intval($this->fun->accept('mlvlid', 'R'));
		if (empty($mlvlid)) exit('false');
		$db_table = db_prefix . 'mailinvite_list';
		$db_where = 'mlvlid=' . $mlvlid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $read['lng']);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('mailinvite/mailinvite_mail_edit');
	}

	function onmailinfosave() {
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$email = $this->fun->accept('email', 'P');
		$name = $this->fun->accept('name', 'P');
		$sex = $this->fun->accept('sex', 'P');
		$tel = $this->fun->accept('tel', 'P');
		$address = $this->fun->accept('address', 'P');
		$time = time();
		$db_table = db_prefix . 'mailinvite_list';
		if ($inputclass == 'edit') {
			$mlvlid = $this->fun->accept('mlvlid', 'P');
			if (empty($mlvlid)) exit('false');
			$db_where = 'mlvlid=' . $mlvlid;
			$db_set = "email='$email',name='$name',tel='$tel',address='$address',sex=$sex";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['mailinvite_mail_edit_log'], $this->lng['log_extra_ok'] . ' id=' . $mlvlid);
			exit('true');
		}
	}

	function onmailsetting() {
		$db_table = db_prefix . 'mailinvite_list';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "mlvlid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['mailinvite_mail_edit_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onmailinvitemaildel() {
		$db_table = db_prefix . 'mailinvite_list';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "mlvlid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['mailinvite_mail_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onmailinviteinput() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;
		$mlvid = intval($this->fun->accept('mlvid', 'R'));
		if (empty($mlvid)) exit('false');
		$db_table = db_prefix . 'mailinvite_type';
		$db_where = 'mlvid=' . $mlvid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('mailinvite/mailinvite_mail_batadd');
	}

	function onbatupinfosave() {
		$mlvid = $this->fun->accept('mlvid', 'P');
		if (empty($mlvid)) exit('false');

		$fname = $_FILES['batfile']['tmp_name'];
		if (empty($fname)) {
			exit('false');
		}
		$time = time();
		$db_table = db_prefix . 'mailinvite_list';

		$handle = @fopen($fname, 'r');
		for ($i = 0; $data = $this->fun->fgetcsv_reg($handle); $i++) {
			if ($i > 0) {
				$email = $this->fun->daddslashes($data[0], 1);
				$name = $this->fun->daddslashes($data[1], 1);
				$name = !empty($name) ? $this->fun->codeing($name, 'gu') : '';
				$sex = intval($this->fun->daddslashes($data[2], 1));
				$sex = empty($sex) ? 0 : $sex;
				$tel = $this->fun->daddslashes($data[3], 1);
				$address = $this->fun->daddslashes($data[4], 1);
				$address = !empty($address) ? $this->fun->codeing($address, 'gu') : '';
				$db_field = 'mlvid,userid,name,email,sex,tel,address,isclass,addtime';
				$db_values = "$mlvid,0,'$name','$email',$sex,'$tel','$address',1,$time";
				$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			}
		}
		$this->writelog($this->lng['mailinvite_mail_add_log2'], $this->lng['log_extra_ok']);
		exit('true');
	}

	function onmailinviteout() {
		$mlvid = $this->fun->accept('mlvid', 'R');
		if (empty($mlvid)) exit('false');
		header("Content-type: application/vnd.ms-excel; charset=GB2312");
		header("Content-Disposition: attachment; filename=mailinviteout_$mlvid.xls");
		$data = "email\t name\t sex\t tel\t address\t\n";
		$db_table = db_prefix . 'mailinvite_list';
		$db_where = " WHERE mlvid=$mlvid AND isclass=1";
		$sql = 'SELECT * FROM ' . $db_table . $db_where;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$data .= "$rsList[email]\t$rsList[name]\t$rsList[sex]\t$rsList[tel]\t$rsList[address]\t\n";
		}
		echo $this->fun->codeing($data, 'ug');
		exit;
	}

}

?>