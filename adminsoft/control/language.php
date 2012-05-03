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

	function onlanguagelist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');
		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$wheretext = null;
		$isopen = $this->fun->accept('isopen', 'R');
		if (!empty($isopen)) {
			if ($isopen == 2) $isopen = 0;
			$wheretext.=' AND isopen=' . $isopen;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'id' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_where = " WHERE id>0" . $wheretext;
		$db_table = db_prefix . 'lng';
		if (!empty($countnum)) {

			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT id,pid,lng,lngtitle,lockin,isopen,isuptype,sitename,keyword,description,copyright FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}

		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('admin/admin_lng_list');
	}

	function onlngadd() {
		parent::start_template();

		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$file_htmldir = admin_ROOT . $this->CON['file_htmldir'];
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('htmldir', $file_htmldir);
		$this->ectemplates->display('admin/admin_lng_add');
	}

	function onlngedit() {
		parent::start_template();
		$db_table = db_prefix . 'lng';
		$id = $this->fun->accept('id', 'G');
		$db_where = 'id=' . $id;
		$lngread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('lngread', $lngread);
		$this->ectemplates->display('admin/admin_lng_edit');
	}

	function onlngpackcopy() {
		parent::start_template();
		$db_table = db_prefix . 'lng';
		$id = $this->fun->accept('id', 'G');
		$db_where = 'id=' . $id;
		$lngread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$lng = $this->fun->accept('lng', 'G');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$lnglist = $this->get_lng_array($lng);
		$this->ectemplates->assign('lnglist', $lnglist['list']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('lngread', $lngread);
		$this->ectemplates->display('admin/admin_lng_packcopy');
	}

	function onlngsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lngtitle = $this->fun->accept('lngtitle', 'P');
		$url = $this->fun->accept('url', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$sitename = $this->fun->accept('sitename', 'P');
		$keyword = $this->fun->accept('keyword', 'P');
		$description = $this->fun->accept('description', 'P');
		$copyright = $this->fun->accept('copyright', 'P');
		$ispack = $this->fun->accept('ispack', 'P');
		$ispack = empty($ispack) ? 0 : $ispack;
		$packname = $this->fun->accept('packname', 'P');
		$iswap = $this->fun->accept('iswap', 'P');
		$iswap = empty($iswap) ? 0 : $iswap;

		$file_htmldir = admin_ROOT . $this->CON['file_htmldir'];
		if (!$this->fun->filemode($file_htmldir)) {
			exit('false');
		}
		$db_table = db_prefix . 'lng';
		$db_table2 = db_prefix . 'templates';
		if ($inputclass == 'add') {
			if ($ispack) {
				$dir = $file_htmldir . $packname;
			} else {
				$dir = $file_htmldir . $lng;
			}
			if (@is_dir($dir)) exit('false');
			if (!@mkdir($dir)) exit('false');
			$db_field = 'pid,lng,lngtitle,url,lockin,isopen,isuptype,sitename,keyword,description,copyright,ispack,packname,iswap';
			$db_values = "50,'$lng','$lngtitle','$url',0,0,0,'$sitename','$keyword','$description','$copyright',$ispack,'$packname',$iswap";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');

			$this->writelog($this->lng['language_add_log'], $this->lng['log_extra_ok'] . ' lngtitle=' . $lngtitle);
			$this->dbcache->clearcache('lng_array', true);

			if (!$this->lanpackcopy('cn', $lng)) {
				exit('false');
			}

			if (!$this->templatescopy('cn', $lng)) {
				exit('false');
			}

			$dirhtmlDir = $ispack ? $this->CON['file_htmldir'] . $packname . '/' : $this->CON['file_htmldir'] . $lng . '/';
			include admin_ROOT . adminfile . '/include/inc_default.php';
			$templatecotent = $default_str;
			$commandfile = $dir . '/index.php';
			if (!$this->fun->filewrite($commandfile, $templatecotent)) {
				exit('false');
			}
			exit('true');
		} else {
			$id = $this->fun->accept('id', 'P');
			$ispackedit = $this->fun->accept('ispackedit', 'P');
			$ispackedit = empty($ispackedit) ? $ispack : $ispackedit;
			$packnameedit = $this->fun->accept('packnameedit', 'P');
			$packnameedit = empty($packnameedit) ? $packname : $packnameedit;

			if ($ispackedit) {
				$dir = $file_htmldir . $packnameedit;
			} else {
				$dir = $file_htmldir . $lng;
			}
			if (!is_dir($dir)) {
				if (!@mkdir($dir)) exit('fasle');
			}

			$db_where = 'id=' . $id;
			$db_set = "lngtitle='$lngtitle',url='$url',sitename='$sitename',keyword='$keyword',description='$description',copyright='$copyright',iswap=$iswap,ispack=$ispackedit,packname='$packnameedit'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->dbcache->clearcache('lng_array', true);
			$this->dbcache->clearcache('lng_view_' . $lng, true);

			$dirhtmlDir = $ispackedit ? $this->CON['file_htmldir'] . $packnameedit . '/' : $this->CON['file_htmldir'] . $lng . '/';
			include admin_ROOT . adminfile . '/include/inc_default.php';
			$templatecotent = $default_str;
			$commandfile = $dir . '/index.php';
			if (!is_file($commandfile)) {
				if (!$this->fun->filewrite($commandfile, $templatecotent)) exit('fasle');
			}
			$this->writelog($this->lng['language_edit_log'], $this->lng['log_extra_ok'] . ' lantitle=' . $lngtitle . ' id=' . $id);
			exit('true');
		}
	}

	function onlngcreat() {
		$lng = $this->fun->accept('lng', 'G');
		if (empty($lng)) {
			exit('flase');
		}
		$id = $this->fun->accept('id', 'G');
		$out = $this->creatlanfile($lng, $id);
		if ($out) {
			exit('true');
		} else {
			exit('false');
		}
	}

	function creatlanfile($lng, $id=0) {
		$file_htmldir = admin_ROOT . $this->CON['file_htmldir'];
		if (!$this->fun->filemode($file_htmldir)) {
			return false;
		}
		$dirview = $this->get_lan_view($lng);
		if (!$this->CON['is_alonelng']) {
			if ($dirview['ispack']) {
				$dir = $file_htmldir . $dirview['packname'];
				$dirhtmlDir = $this->CON['file_htmldir'] . $dirview['packname'] . '/';
			} else {
				$dir = $file_htmldir . $lng;
				$dirhtmlDir = $this->CON['file_htmldir'] . $lng . '/';
			}
		} else {
			$dir = $file_htmldir;
			$dirhtmlDir = $this->CON['file_htmldir'];
		}
		if (!is_dir($dir)) {
			if (!@mkdir($dir)) return false;
		}
		include admin_ROOT . adminfile . '/include/inc_default.php';
		$templatecotent = $default_str;
		$commandfile = $dir . '/index.php';
		if (!$this->fun->filewrite($commandfile, $templatecotent)) return false;
		$this->writelog($this->lng['language_creat_index'], $this->lng['log_extra_ok'] . ' lng=' . $lng . ' id=' . $id);
		return true;
	}

	function onpackcopy() {
		parent::start_template();
		$id = $this->fun->accept('id', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$tolng = $this->fun->accept('tolng', 'P');
		if (empty($tolng)) {
			exit('false');
		}
		$out = $this->lanpackcopy($lng, $tolng);
		if ($out) {
			$this->writelog($this->lng['language_copy_log'], $this->lng['log_extra_ok'] . $lng . ' TO ' . $tolng);
			$this->creat_lanpack($tolng, true);
			exit('true');
		} else {
			exit('false');
		}
	}

	function templatescopy($lng, $tolng) {
		$db_table = db_prefix . 'templates';
		if (empty($tolng) || empty($lng)) {
			return false;
		}
		$date = time();
		$db_field = 'lng,templatename,templatecode,title,templatecontent,pic,typeclass,styleclass,lockin,addtime';
		$db_where = " WHERE lng='$lng' AND styleclass=3 ORDER BY tmid";
		$sql = 'SELECT * FROM ' . $db_table . $db_where;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$templatecode = $rsList['templatecode'];
			$db_where2 = " WHERE lng='$tolng' and templatecode='$templatecode'";
			$countnum = $this->db_numrows($db_table, $db_where2);
			if ($countnum <= 0) {
				$db_values = "'$tolng','$rsList[templatename]','$rsList[templatecode]','$rsList[title]','$rsList[templatecontent]','$rsList[pic]','$rsList[typeclass]',3,$rsList[lockin],$date";
				$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			}
		}
		return true;
	}

	function lanpackcopy($lng, $tolng) {
		$db_table = db_prefix . 'lngpack';
		if (empty($tolng) || empty($lng)) {
			return false;
		}
		$db_field = 'pid,lng,title,keycode,langstr,lockin,typeid';
		$db_where = " WHERE lng='$lng' ORDER BY lpid";
		$sql = 'SELECT * FROM ' . $db_table . $db_where;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$keycode = $rsList['keycode'];
			$db_where2 = " WHERE lng='$tolng' and keycode='$keycode'";
			$countnum = $this->db_numrows($db_table, $db_where2);
			if ($countnum <= 0) {
				$db_values = "$rsList[pid],'$tolng','$rsList[title]','$rsList[keycode]','$rsList[langstr]',$rsList[lockin],$rsList[typeid]";
				$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			}
		}
		return true;
	}

	function ondellng() {
		$db_table = db_prefix . 'lng';
		$db_table2 = db_prefix . 'lngpack';
		$db_table3 = db_prefix . 'templates';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "id=$infoarray[$i] and lockin=0";
			$lngread = $this->db->fetch_first('SELECT id,lng FROM ' . $db_table . ' WHERE ' . $db_where);
			if (!empty($lngread['lng'])) {
				$db_where2 = "lng='" . $lngread['lng'] . "'";

				$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where2);

				$this->db->query('DELETE FROM ' . $db_table3 . ' WHERE ' . $db_where2);
			}

			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->dbcache->clearcache('lng_array', true);
		$this->dbcache->clearcache('lng_view', true);
		$this->writelog($this->lng['language_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function onlngsort() {
		$db_table = db_prefix . 'lng';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "id=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		}
		$this->dbcache->clearcache('lng_array', true);
		$this->writelog($this->lng['language_log_sort'], $this->lng['log_extra_ok']);
		exit('true');
	}

	function ongetlngdir() {
		$lng = $this->fun->accept('lng', 'R');
		if (empty($lng)) {
			exit();
		}
		$lngdir = $this->get_lng_dirpack($lng);
		exit($lngdir);
	}

	function onsetting() {
		$db_table = db_prefix . 'lng';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');

		$value = $this->fun->accept('value', 'P');

		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "id IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->dbcache->clearcache('lng_array', true);
		$this->dbcache->clearcache('lng_view', true);
		$this->writelog($this->lng['language_log_isopen'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

	function oncodedb() {
		$file_htmldir = admin_ROOT . $this->CON['file_htmldir'];
		$packname = $this->fun->accept('packname', 'R');
		$db_table = db_prefix . 'lng';
		if (!$packname) {
			$codename = $this->fun->accept('codename', 'R');
			$dir = $file_htmldir . $codename;
			if (is_dir($dir)) {
				exit('false');
			}
			$db_where = " WHERE lng='$codename'";
		} else {
			$dir = $file_htmldir . $packname;
			if (is_dir($dir)) {
				exit('false');
			}
			$db_where = " WHERE lng='$packname' OR packname='$packname'";
		}
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