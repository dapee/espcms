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

	function onmailsendlist() {
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
		$limitkey = empty($limitkey) ? 'msid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'mailsend';
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
		$this->ectemplates->display('mailinvite/mailsend_send_list');
	}

	function onmailsendadd() {
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
		$this->ectemplates->display('mailinvite/mailsend_send_add');
	}

	function onmailsendedit() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$type = $this->fun->accept('type', 'R');
		$type = empty($type) ? 'edit' : $type;
		$msid = intval($this->fun->accept('msid', 'R'));
		if (empty($msid)) exit('false');
		$db_table = db_prefix . 'mailsend';
		$db_where = 'msid=' . $msid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $read['lng']);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('mailinvite/mailsend_send_edit');
	}

	function oninfosave() {
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$title = $this->fun->accept('title', 'P');
		$content = $this->fun->accept('content', 'P');
		$time = time();
		$db_table = db_prefix . 'mailsend';
		if ($inputclass == 'add') {
			$db_field = 'lng,title,content,sendhow,sendtime,isclass,addtime';
			$db_values = "'$lng','$title','$content',0,0,1,$time";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['mailinvite_send_add_log'], $this->lng['log_extra_ok']);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$msid = $this->fun->accept('msid', 'P');
			if (empty($msid)) exit('false');
			$db_where = 'msid=' . $msid;
			$db_set = "title='$title',content='$content'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['mailinvite_send_edit_log'], $this->lng['log_extra_ok'] . ' id=' . $msid);
			exit('true');
		}
	}

	function onmailsenddel() {
		$db_table = db_prefix . 'mailsend';
		$db_table2 = db_prefix . 'mailsend_log';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "msid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
			$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['mailinvite_send_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'mailsend';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "msid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['mailinvite_send_edit_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onmailgroupsend() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$type = $this->fun->accept('type', 'R');
		$type = empty($type) ? 'edit' : $type;
		$msid = intval($this->fun->accept('msid', 'R'));
		if (empty($msid)) exit('false');
		$db_table = db_prefix . 'mailsend';
		$db_where = 'msid=' . $msid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$typearray = $this->get_mailinvite_type_array(0, $read['lng']);
		$this->ectemplates->assign('typelist', $typearray['list']);

		$input_default = $this->CON;
		$this->ectemplates->assign('defaultinput', $input_default);
		$this->ectemplates->assign('lng', $read['lng']);
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('path', admin_URL);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('mailinvite/mailsend_send');
	}

	function onmailgroupsendsave() {
		$time = time();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$msid = $this->fun->accept('msid', 'P');
		$mlvid = $this->fun->accept('mlvid', 'P');
		$sendmail = $this->fun->accept('sendmail', 'P');

		$db_table = db_prefix . 'mailsend';
		$db_table2 = db_prefix . 'mailinvite_list';
		$db_table3 = db_prefix . 'mailsend_log';

		$db_where = 'msid=' . $msid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$mailsendtitle = stripslashes(htmlspecialchars_decode($read['title']));
		$mailsendcontent = stripslashes(htmlspecialchars_decode($read['content']));
		$sendmaillist = null;
		$sendhow = 0;

		if ($mlvid > 0) {
			$db_where = " WHERE mlvid=$mlvid AND isclass=1";
			$sql = 'SELECT mlvlid,mlvid,name,email FROM ' . $db_table2 . $db_where;
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$email = $rsList['email'];
				$sendtype = $this->mailsend($mailsendtitle, $mailsendcontent, $email);
				if ($sendtype) {
					$sendmaillist.=$email . ';';
					$sendhow++;
				}
			}
		} else {
			if (!empty($sendmail)) exit('false');
			$sendarray = explode(';', $sendmail);
			if (count($sendarray) <= 1) exit('false');
			if (is_array($sendarray)) {
				foreach ($sendarray as $key => $value) {
					if (preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i", $value)) {
						$sendtype = $this->mailsend($mailsendtitle, $mailsendcontent, $value);
						if ($sendtype) {
							$sendmaillist.=$value . ';';
							$sendhow++;
						}
					}
				}
			}
		}

		$sendhow = empty($sendhow) ? 0 : $sendhow;
		if ($sendhow <= 0) {
			exit('false');
		}

		$db_field = 'msid,sendmail,sendtime';
		$db_values = "$msid,'$sendmaillist',$time";
		$this->db->query('INSERT INTO ' . $db_table3 . ' (' . $db_field . ') VALUES (' . $db_values . ')');

		$db_where = 'msid=' . $msid;
		$db_set = "sendhow=sendhow+$sendhow,sendtime=$time";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

		$this->writelog($this->lng['mailinvite_send_js_send_ok'], $this->lng['log_extra_ok'] . ' id=' . $msid);
		exit('true');
	}

}

?>