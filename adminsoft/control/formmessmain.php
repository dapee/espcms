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

	function onmesslist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$fgid = $this->fun->accept('fgid', 'R');
		$db_where = ' WHERE fgid=' . $fgid;
		$isreply = $this->fun->accept('isreply', 'R');
		if (!empty($isreply)) {
			if ($isreply == 2) $isreply = 0;
			$db_where.=' AND isreply=' . $isreply;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'fvid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'form_value';
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
		$this->ectemplates->assign('limitkey', $limitkey);
		$this->ectemplates->assign('limitclass', $limitclass);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('form/form_mess_list');
	}

	function onread() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;
		$fvid = $this->fun->accept('fvid', 'G');
		$forumread = $this->get_formcontent($fvid);
		$form = $this->get_form_purview($forumread['fgid']);
		$attrread = $this->get_formatt($forumread['fgid'], false);
		if (is_array($attrread)) {
			foreach ($attrread as $key => $value) {
				if ($value['inputtype'] == 'select' || $value['inputtype'] == 'radio') {
					foreach ($value['attrvalue'] as $key2 => $value2) {
						if ($forumread[$value['attrname']] == $value2['name']) {
							$attrread[$key]['attrvalue'][$key2]['selected'] = 'selected';
						}
					}
				} elseif ($value['inputtype'] == 'checkbox') {
					$expvale = explode(',', $forumread[$value['attrname']]);
					foreach ($value['attrvalue'] as $key2 => $value2) {
						if (in_array($value2['name'], $expvale)) {
							$attrread[$key]['attrvalue'][$key2]['selected'] = 'selected';
						}
					}
				} else {
					$attrread[$key]['attrvalue'] = $forumread[$value['attrname']];
				}
			}
		}

		if (!empty($forumread['did'])) {
			$docread = $this->get_documentview($forumread['did']);
			$docread['readlink'] = $this->get_link('doc', $docread, $docread['lng']);
		}

		if (!empty($forumread['userid'])) {
			$memread = $this->get_member(null, $forumread['userid']);
		}
		$sendmail = $form['ismail'] && !empty($form['emailatt']) ? $forumread[$form['emailatt']] : '';
		$this->ectemplates->assign('read', $forumread);
		$this->ectemplates->assign('read', $forumread);
		$this->ectemplates->assign('attlist', $attrread);
		$this->ectemplates->assign('form', $form);
		$this->ectemplates->assign('sendmail', $sendmail);
		$this->ectemplates->assign('memread', $memread);
		$this->ectemplates->assign('docread', $docread);
		$this->ectemplates->assign('is_email', $this->CON['is_email']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->display('form/form_mess_read');
	}

	function onsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$fvid = $this->fun->accept('fvid', 'P');
		if (empty($fvid)) exit('false');
		$email = $this->fun->accept('email', 'P');
		$isreply = $this->fun->accept('isreply', 'P');
		$ismail = $this->fun->accept('ismail', 'P');
		$content = $this->fun->accept('content', 'P');
		$db_table = db_prefix . 'form_value';
		$date = time();
		if ($inputclass == 'edit' && $isreply == 0) {
			$username = $this->esp_username;
			$db_where = 'fvid=' . $fvid;
			$db_set = "retime=$date,username='$username',recontent='$content'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

			if ($this->CON['is_email'] && $isreply == 0 && $ismail) {
				$this->formmailsend('formreremind', $fvid, $email);
			}
			$this->writelog($this->lng['formmessmain_edit_log'], $this->lng['log_extra_ok'] . ' fvid=' . $fvid . ' username=' . $username);
			exit('true');
		}
	}

	function onformmessagedel() {
		$db_table = db_prefix . 'form_value';
		$selectinfoid = $this->fun->accept('messselectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "fvid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['formmessmain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'form_value';
		$selectinfoid = $this->fun->accept('messselectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "fvid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['formmessmain_log_istype'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

}

?>