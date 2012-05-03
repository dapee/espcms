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

	function onformlist() {
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
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$ismenu = $this->fun->accept('ismenu', 'R');
		if (!empty($ismenu)) {
			if ($ismenu == 2) $ismenu = 0;
			$db_where.=' AND ismenu=' . $ismenu;
		}
		$isseccode = $this->fun->accept('isseccode', 'R');
		if (!empty($isseccode)) {
			if ($isseccode == 2) $isseccode = 0;
			$db_where.=' AND isseccode=' . $isseccode;
		}
		$isinputtime = $this->fun->accept('isinputtime', 'R');
		if (!empty($isinputtime)) {
			if ($isinputtime == 2) $isinputtime = 0;
			$db_where.=' AND isinputtime=' . $isinputtime;
		}
		$ismail = $this->fun->accept('ismail', 'R');
		if (!empty($ismail)) {
			if ($ismail == 2) $ismail = 0;
			$db_where.=' AND ismail=' . $ismail;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'fgid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'form_group';
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
		$this->ectemplates->display('form/form_list');
	}

	function onformattlist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$wheretext = null;
		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$wheretext.=' AND isclass=' . $isclass;
		}
		$isvalidate = $this->fun->accept('isvalidate', 'R');
		if (!empty($isvalidate)) {
			if ($isvalidate == 2) $isvalidate = 0;
			$wheretext.=' AND isvalidate=' . $isvalidate;
		}
		$isline = $this->fun->accept('isline', 'R');
		if (!empty($isline)) {
			if ($isline == 2) $isline = 0;
			$wheretext.=' AND isline=' . $isline;
		}
		$fgid = $this->fun->accept('fgid', 'R');

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'faid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_where = " WHERE fgid=$fgid" . $wheretext;
		$db_table = db_prefix . 'form_attr';
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
		$this->ectemplates->display('form/form_att_list');
	}

	function onformadd() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$memberpuv = $this->get_member_purview_array();
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);
		$this->ectemplates->assign('timelist', $TIMELIST);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->display('form/form_add');
	}

	function onformedit() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$db_table = db_prefix . 'form_group';
		$type = $this->fun->accept('type', 'G');
		$id = $this->fun->accept('id', 'G');
		$db_where = 'fgid=' . $id;
		$formread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$memberpuv = $this->get_member_purview_array($formread['purview']);
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('timelist', $TIMELIST);
		$this->ectemplates->assign('formread', $formread);
		if ($type == 'copy') {
			$lng = $this->get_lng_array($formread['lng']);
			$this->ectemplates->assign('lng', $lng['list']);
			$this->ectemplates->display('form/form_copy');
		} else {
			$this->ectemplates->assign('type', $type);
			$this->ectemplates->display('form/form_edit');
		}
	}

	function onformattradd() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$fgid = $this->fun->accept('fgid', 'G');
		$this->ectemplates->assign('fgid', $fgid);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('formtypelist', $FORMTYPE);
		$this->ectemplates->display('form/form_att_add');
	}

	function onformattredit() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$db_table = db_prefix . 'form_attr';
		$faid = $this->fun->accept('faid', 'G');
		$db_where = 'faid=' . $faid;
		$formattrread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('formtypelist', $FORMTYPE);
		$this->ectemplates->assign('attrread', $formattrread);
		$this->ectemplates->display('form/form_att_edit');
	}

	function onformsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$formgroupname = $this->fun->accept('formgroupname', 'P');
		$formcode = $this->fun->accept('formcode', 'P');
		$purview = $this->fun->accept('purview', 'P');
		$content = $this->fun->accept('content', 'P');
		$template = $this->fun->accept('template', 'P');
		$emailatt = $this->fun->accept('emailatt', 'P');
		$ismail = $this->fun->accept('ismail', 'P');
		$successtext = $this->fun->accept('successtext', 'P');
		$ismenu = $this->fun->accept('ismenu', 'P');
		$isseccode = $this->fun->accept('isseccode', 'P');
		$putmail = $this->fun->accept('putmail', 'P');
		$inputtime = $this->fun->accept('inputtime', 'P');
		$mailcode = $this->fun->accept('mailcode', 'P');
		$db_table = db_prefix . 'form_group';
		$date = time();
		if ($inputclass == 'add') {
			$isclass = $this->esp_inputclassid;
			$isclass = empty($isclass) ? 0 : $isclass;
			$db_field = 'pid,lng,formgroupname,formcode,content,successtext,template,emailatt,addtime,isclass,ismenu,isseccode,ismail,mailcode,inputtime,purview,putmail';
			$db_values = "50,'$lng','$formgroupname','$formcode','$content','$successtext','$template','$emailatt',$date,$isclass,$ismenu,$isseccode,$ismail,'$mailcode',$inputtime,$purview,'$putmail'";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['formmain_add_log'], $this->lng['log_extra_ok'] . ' formgroupname=' . $formgroupname);
			$this->dbcache->clearcache('formgroup_array_' . $lng, true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$fgid = $this->fun->accept('fgid', 'P');
			if (empty($fgid)) exit('false');
			$db_where = 'fgid=' . $fgid;
			$db_set = "formgroupname='$formgroupname',content='$content',successtext='$successtext',template='$template',emailatt='$emailatt',ismenu=$ismenu,isseccode=$isseccode,ismail=$ismail,mailcode='$mailcode',inputtime=$inputtime,putmail='$putmail',purview=$purview";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['formmain_edit_log'], $this->lng['log_extra_ok'] . ' formgroupname=' . $formgroupname . ' id=' . $fgid);
			$this->dbcache->clearcache('formgroup_view_' . $id, true);
			$this->dbcache->clearcache('formgroup_array_' . $lng, true);
			exit('true');
		}
	}

	function onformattrsave() {
		include admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$fgid = $this->fun->accept('fgid', 'P');

		$typename = $this->fun->accept('typename', 'P');
		$attrname = $this->fun->accept('attrname', 'P');
		$typeremark = $this->fun->accept('typeremark', 'P');
		$inputtype = $this->fun->accept('inputtype', 'P');
		$attrvalue = $this->fun->accept('attrvalue', 'P');
		$attrsize = $this->fun->accept('attrsize', 'P');
		$attrsize = empty($attrsize) ? 20 : $attrsize;
		$attrrow = $this->fun->accept('attrrow', 'P');
		$attrrow = empty($attrrow) ? 5 : $attrrow;
		$isvalidate = $this->fun->accept('isvalidate', 'P');
		$validatetext = $this->fun->accept('validatetext', 'P');

		$isclass = $this->fun->accept('isclass', 'P');
		$isclass = empty($isclass) ? 0 : $isclass;
		$isline = $this->fun->accept('isline', 'P');
		$isline = empty($isline) ? 0 : $isline;

		$key = $this->fun->array_key($FORMTYPE, $inputtype, 'key');
		$attrarray = $FORMTYPE[$key];
		if (!$attrarray) {
			exit('false');
		}
		$attrlenther = $attrarray['varlong'];

		$db_table = db_prefix . 'form_attr';
		$db_table2 = db_prefix . 'form_value';
		if ($inputclass == 'add') {

			if ($attrarray['alter'] != 'TEXT') {

				$alter = $attrarray['alter'] == 'INT' || $attrarray['alter'] == 'FLOAT' ? $attrarray['alter'] . '(' . $attrarray['varlong'] . ') DEFAULT \'0\'' : $attrarray['alter'] . '(' . $attrarray['varlong'] . ')';
			} else {
				$alter = $attrarray['alter'];
			}

			$renameclass = $this->checkname($attrname, $fgid, $inputtype);
			if (!$renameclass) {
				exit('false');
			}
			$db_where = " WHERE fgid<>$fgid and attrname='$attrname'";
			$countnum = $this->db_numrows($db_table, $db_where);
			if (!$countnum) {
				$this->db->query('ALTER TABLE ' . $db_table2 . ' ADD COLUMN ' . $attrname . ' ' . $alter . ' NOT NULL');
			}

			$db_field = 'fgid,pid,typename,typeremark,attrname,inputtype,attrvalue,validatetext,attrsize,attrrow,attrlenther,isclass,isvalidate,isline';
			$db_values = "$fgid,50,'$typename','$typeremark','$attrname','$inputtype','$attrvalue','$validatetext',$attrsize,$attrrow,$attrlenther,1,$isvalidate,$isline";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');

			$this->writelog($this->lng['formmain_attr_add_log'], $this->lng['log_extra_ok'] . ' typename=' . $typename);
			$this->dbcache->clearcache('formatt_array_' . $fgid, true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$faid = $this->fun->accept('faid', 'P');
			if (empty($faid)) {
				return false;
			}
			$db_set_str = null;
			if ($attrvalue) {
				$db_set_str.= ",attrvalue='$attrvalue'";
			}
			if ($attrsize) {
				$db_set_str.= ',attrsize=' . $attrsize;
			}
			if ($attrrow) {
				$db_set_str.= ',attrrow=' . $attrrow;
			}
			if ($validatetext) {
				$db_set_str.= ",validatetext='$validatetext'";
			}
			if ($isvalidate) {
				$db_set_str.= ',isvalidate=' . $isvalidate;
			} else {
				$db_set_str.= ',isvalidate=0';
			}

			$db_where = 'faid=' . $faid;
			$db_set = "typename='$typename',typeremark='$typeremark',isline=$isline,isclass=$isclass" . $db_set_str;
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

			$this->writelog($this->lng['formmain_attr_edit_log'], $this->lng['log_extra_ok'] . ' typename=' . $typename . ' id=' . $faid);
			$this->dbcache->clearcache('formatt_array_' . $fgid, true);
			exit('true');
		}
	}

	function ondelform() {
		$db_table = db_prefix . 'form_group';
		$db_table2 = db_prefix . 'form_attr';
		$db_table3 = db_prefix . 'form_value';
		$id = $this->fun->accept('id', 'R');
		if (empty($id)) exit('false');

		$db_where = "fgid=$id";
		$sql = 'SELECT attrname FROM ' . $db_table2 . ' WHERE ' . $db_where . ' ORDER BY fgid DESC';
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {

			$db_where2 = " WHERE attrname='$rsList[attrname]'";
			$countnum = $this->db_numrows($db_table2, $db_where2);
			if ($countnum == 1) {
				$this->db->query('ALTER TABLE ' . $db_table3 . ' DROP COLUMN ' . $rsList['attrname']);
			}
		}
		$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where);
		$this->db->query('DELETE FROM ' . $db_table3 . ' WHERE ' . $db_where);
		$this->writelog($this->lng['formmain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $id);
		$this->dbcache->clearcache('formgroup_array', true);
		$this->dbcache->clearcache('formgroup_view_' . $id, true);
		$this->dbcache->clearcache('formatt_array_' . $id, true);
		$this->dbcache->clearcache('formatt_view', true);
		exit('true');
	}

	function ondelformattr() {
		$db_table = db_prefix . 'form_attr';
		$db_table2 = db_prefix . 'form_value';
		$selectinfoid = $this->fun->accept('attrselectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "faid=$infoarray[$i]";
			$attview = $this->get_formattview($infoarray[$i]);

			$db_where2 = " WHERE attrname='$attview[attrname]'";
			$countnum = $this->db_numrows($db_table, $db_where2);
			if ($countnum == 1) {
				$this->db->query('ALTER TABLE ' . $db_table2 . ' DROP COLUMN ' . $attview['attrname']);
			}

			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['formmain_attr_log_del'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('formatt_array', true);
		$this->dbcache->clearcache('formatt_view_', true);
		exit('true');
	}

	function onattrsort() {
		$db_table = db_prefix . 'form_attr';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "faid=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		}
		$this->writelog($this->lng['formmain_attr_log_sort'], $this->lng['log_extra_ok']);
		$this->dbcache->clearcache('formatt_array', true);
		exit('true');
	}

	function onformsetting() {
		$db_table = db_prefix . 'form_group';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "fgid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['formmain_isclass_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('formgroup_', true);
		exit('true');
	}

	function onattrsetting() {
		$db_table = db_prefix . 'form_attr';
		$selectinfoid = $this->fun->accept('attrselectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "faid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['formmain_attr_log_istype'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('formatt_array', true);
		exit('true');
	}

	function oncheckattrname() {
		$attrname = $this->fun->accept('attrname', 'R');
		$fgid = $this->fun->accept('fgid', 'R');
		$inputtype = $this->fun->accept('inputtype', 'R');
		$renameclass = $this->checkname($attrname, $fgid, $inputtype);
		if (!$renameclass) {
			exit('false');
		} else {
			exit('true');
		}
	}

	function checkname($attrname, $fgid, $inputtype) {
		include admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		$attlist = array('did', 'lng', 'pid', 'mid', 'aid', 'tid', 'sid', 'fgid', 'isclass', 'islink', 'ishtml', 'ismess', 'isorder',
		    'attrvalue', 'fvid', 'fgid', 'faid', 'ftid', 'did', 'iscount', 'oid', 'source', 'pic', 'tags', 'keywords',
		    'description', 'link', 'oprice', 'bprice', 'click', 'addtime', 'uptime', 'template', 'filename', 'filepath', 'daid', 'picname'
		    , 'picfile', 'addtime', 'dcid', 'content', 'dlid', 'mid', 'labelname', 'doid', 'startime', 'endtime', 'width', 'height',
		    'istime', 'filetype', 'dvid');
		$attrnamearray = strtolower($attrname);

		if (in_array($attrnamearray, $attlist)) {
			return false;
		}

		$key = $this->fun->array_key($FORMTYPE, $inputtype, 'key', 'alter');
		if (empty($key)) {
			return false;
		}

		$db_table = db_prefix . 'form_attr';

		$db_where = " WHERE attrname='$attrname' and fgid=$fgid";
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			return false;
		} else {

			$db_where = " WHERE attrname='$attrname'";
			$sql = 'SELECT attrname,inputtype FROM ' . $db_table . $db_where;
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$keynow = $this->fun->array_key($FORMTYPE, $rsList['inputtype'], 'key', 'alter');
				if ($keynow != $key) {
					return false;
				}
			}
		}
		return true;
	}

	function oncheckformname() {
		$attlist = array('did', 'lng', 'pid', 'mid', 'aid', 'tid', 'sid', 'fgid', 'isclass', 'islink', 'ishtml', 'ismess', 'isorder',
		    'attrvalue', 'fvid', 'fgid', 'faid', 'ftid', 'did', 'iscount', 'oid', 'source', 'pic', 'tags', 'keywords',
		    'description', 'link', 'oprice', 'bprice', 'click', 'addtime', 'uptime', 'template', 'filename', 'filepath', 'daid', 'picname'
		    , 'picfile', 'addtime', 'dcid', 'content', 'dlid', 'mid', 'labelname', 'doid', 'startime', 'endtime', 'width', 'height',
		    'istime', 'filetype', 'dvid');
		$formcode = $this->fun->accept('formcode', 'R');
		$lng = $this->fun->accept('lng', 'R');
		$attrnamearray = strtolower($formcode);

		if (in_array($attrnamearray, $attlist)) {
			exit('false');
		}
		$db_table = db_prefix . 'form_group';
		$db_where = " WHERE formcode='$formcode' AND lng='$lng'";
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