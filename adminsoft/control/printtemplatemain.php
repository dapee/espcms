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

	function onprintlist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE styleclass=2 and lng=\'' . $lng . '\'';

		$typeclass = $this->fun->accept('typeclass', 'R');
		if (!empty($typeclass)) {
			$db_where.=" AND typeclass='$typeclass'";
		}
		$lockin = $this->fun->accept('lockin', 'R');
		if (!empty($lockin)) {
			if ($lockin == 2) $lockin = 0;
			$db_where.=' AND lockin=' . $lockin;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'tmid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'templates';
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
		$this->ectemplates->display('template/printtemplate_list');
	}

	function onprintadd() {
		include_once admin_ROOT . adminfile . '/include/inc_replace_mailtemplates.php';
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('template/printtemplate_add');
	}

	function onprintedit() {
		include_once admin_ROOT . adminfile . '/include/inc_print.php';
		parent::start_template();
		$db_table = db_prefix . 'templates';
		$tmid = intval($this->fun->accept('tmid', 'G'));
		$type = $this->fun->accept('type', 'G');
		$db_where = 'tmid=' . $tmid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('typeclass', $typeclass);
		$this->ectemplates->assign('print', $printinc);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('read', $read);
		$tempfile = $type == 'edit' ? 'template/printtemplate_edit' : 'template/printtemplate_copy';
		$this->ectemplates->display($tempfile);
	}

	function onpifrmat() {
		parent::start_template();
		$tmid = $this->fun->accept('tmid', 'R');
		$db_table = db_prefix . 'templates';
		$db_where = 'tmid=' . $tmid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$read['templatecontent'] = stripslashes(htmlspecialchars_decode($read['templatecontent']));
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->display('template/printtemplate_frame');
	}

	function onsave() {
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$templatename = $this->fun->accept('templatename', 'P');
		$title = $this->fun->accept('title', 'P');
		$pic = $this->fun->accept('pic', 'P');
		$typeclass = $this->fun->accept('typeclass', 'P');
		$styleclass = $this->fun->accept('styleclass', 'P');
		$db_table = db_prefix . 'templates';
		$date = time();
		if ($inputclass == 'add') {
			$db_field = 'lng,templatename,templatecode,title,templatecontent,pic,typeclass,styleclass,lockin,addtime';
			$db_values = "'$lng','$templatename','$templatecode','$title','$templatecontent','$pic','$typeclass',$styleclass,0,$date";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['printtemplatemain_add_log'], $this->lng['log_extra_ok'] . ' templatename=' . $templatename);
			$this->dbcache->clearcache('templates_array_' . $lng . '_' . $styleclass, true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$tmid = $this->fun->accept('tmid', 'P');
			$templatecontent = $this->fun->accept('content', 'P');
			if (empty($templatecontent)) {
				exit('false');
			}
			$db_where = 'tmid=' . $tmid;
			$db_set = "templatename='$templatename',title='$title',templatecontent='$templatecontent'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['printtemplatemain_edit_log'], $this->lng['log_extra_ok'] . ' templatename=' . $templatename);
			$this->dbcache->clearcache('templates_view_' . $tmid, true);
			$this->dbcache->clearcache('templates_array_' . $lng . '_' . $styleclass, true);
			exit('true');
		} elseif ($inputclass == 'copy') {
			$templatecontent = $this->fun->accept('content', 'P');
			$db_field = 'lng,templatename,templatecode,title,templatecontent,pic,typeclass,styleclass,lockin,addtime';
			$db_values = "'$lng','$templatename','$templatecode','$title','$templatecontent','$pic','$typeclass',$styleclass,0,$date";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['printtemplatemain_copy_log'], $this->lng['log_extra_ok'] . ' templatename=' . $templatename);
			$this->dbcache->clearcache('templates_array_' . $lng . '_' . $styleclass, true);
			exit('true');
		}
	}

	function onprintdel() {
		$db_table = db_prefix . 'templates';
		$tmid = $this->fun->accept('tmid', 'R');
		if (empty($tmid)) exit('false');
		$db_where = "tmid=$tmid and lockin=0";
		$typeclass = $this->fun->accept('typeclass', 'R');
		$styleclass = $this->fun->accept('styleclass', 'R');
		$lng = $this->fun->accept('lng', 'R');
		if (empty($styleclass) || empty($typeclass) || empty($lng)) {
			exit('false');
		}
		$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->writelog($this->lng['printtemplatemain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $tmid);
		$this->dbcache->clearcache('templates_view_' . $tmid, true);
		$this->dbcache->clearcache('templates_array_' . $lng . '_' . $styleclass, true);
		exit('true');
	}

}

?>