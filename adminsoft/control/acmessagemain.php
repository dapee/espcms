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

	function onacmessagelist() {
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
		$isreply = intval($this->fun->accept('isreply', 'R'));
		if (!empty($isreply)) {
			if ($isreply == 2) $isreply = 0;
			$db_where.=' AND isreply=' . $isreply;
		}
		$did = intval($this->fun->accept('did', 'R'));
		if (!empty($did)) {
			$db_where.=' AND did=' . $did;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'dmid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'document_message';
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
		$this->ectemplates->display('article/article_message_list');
	}

	function onacmessagere() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$type = $this->fun->accept('type', 'R');
		$type = empty($type) ? 'edit' : $type;

		$dmid = intval($this->fun->accept('dmid', 'R'));
		if (empty($dmid)) exit('false');
		$read = $this->get_docmessage_veiw($dmid);

		$reBook = $this->get_documentview($read['did']);
		$this->ectemplates->assign('articelread', $reBook);

		if (!empty($read['userid'])) {
			$rsMember = $this->get_member(null, $read['userid']);
		}
		$this->ectemplates->assign('member', $rsMember);

		if (!empty($read['adminid'])) {
			$rsAdmin = $this->get_admin_view(null, $read['adminid']);
		}
		$this->ectemplates->assign('adminview', $rsAdmin);

		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $read['lng']);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('article/article_message_edit');
	}

	function oninfosave() {

		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$recontent = $this->fun->accept('recontent', 'P');
		$recontent = empty($recontent) ? '' : $this->fun->Text2Html($recontent);
		$time = time();
		$db_table = db_prefix . 'document_message';
		if ($inputclass == 'edit') {
			$dmid = $this->fun->accept('dmid', 'P');
			if (empty($dmid)) exit('false');
			$adminid = $this->ec_member_username_id;
			$adminid = empty($adminid) ? 0 : $adminid;
			$db_where = 'dmid=' . $dmid;
			$db_set = "recontent='$recontent',isreply=1,retime=$time,adminid=$adminid";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['acmessagelmain_edit_log'], $this->lng['log_extra_ok'] . ' id=' . $dmid);
			$this->dbcache->clearcache('docmessage_' . $dmid, true);
			exit('true');
		}
	}

	function onacmessagedel() {
		$db_table = db_prefix . 'document_message';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "dmid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->dbcache->clearcache('docmessage_', true);
		$this->writelog($this->lng['acmessagelmain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'document_message';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "dmid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->dbcache->clearcache('docmessage_', true);
		$this->writelog($this->lng['acmessagelmain_setting_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

}

?>