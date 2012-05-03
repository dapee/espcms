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

	function onmodellist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_where = ' WHERE mid>0';
		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$lockin = $this->fun->accept('lockin', 'R');
		if (!empty($lockin)) {
			if ($lockin == 2) $lockin = 0;
			$db_where.=' AND lockin=' . $lockin;
		}
		$isbase = $this->fun->accept('isbase', 'R');
		if (!empty($isbase)) {
			if ($isbase == 2) $isbase = 0;
			$db_where.=' AND isbase=' . $isbase;
		}
		$istsn = $this->fun->accept('istsn', 'R');
		if (!empty($istsn)) {
			if ($istsn == 2) $istsn = 0;
			$db_where.=' AND istsn=' . $istsn;
		}

		$isalbum = $this->fun->accept('isalbum', 'R');
		if (!empty($isalbum)) {
			if ($isalbum == 2) $isalbum = 0;
			$db_where.=' AND isalbum=' . $isalbum;
		}
		$isextid = $this->fun->accept('isextid', 'R');
		if (!empty($isextid)) {
			if ($isextid == 2) $isextid = 0;
			$db_where.=' AND isextid=' . $isextid;
		}
		$issid = $this->fun->accept('issid', 'R');
		if (!empty($issid)) {
			if ($issid == 2) $issid = 0;
			$db_where.=' AND issid=' . $issid;
		}
		$isfgid = $this->fun->accept('isfgid', 'R');
		if (!empty($isfgid)) {
			if ($isfgid == 2) $isfgid = 0;
			$db_where.=' AND isfgid=' . $isfgid;
		}
		$islinkdid = $this->fun->accept('islinkdid', 'R');
		if (!empty($islinkdid)) {
			if ($islinkdid == 2) $islinkdid = 0;
			$db_where.=' AND islinkdid=' . $islinkdid;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'mid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'model';
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
		$this->ectemplates->display('article/model_list');
	}

	function onmodelattlist() {
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
		$issearch = $this->fun->accept('issearch', 'R');
		if (!empty($issearch)) {
			if ($issearch == 2) $issearch = 0;
			$wheretext.=' AND issearch=' . $issearch;
		}

		$mid = $this->fun->accept('mid', 'R');

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'aid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_where = " WHERE mid IN (0,$mid)" . $wheretext;
		$db_table = db_prefix . 'model_att';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows_ds($db_table, $db_where, 'attrname');
			exit($countnum);
		}
		$sql = 'SELECT * FROM (SELECT * FROM ' . $db_table . $db_where . ' ORDER BY aid desc) AS MODELATTR GROUP BY attrname ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->display('article/model_att_list');
	}

	function onmodeladd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$this->ectemplates->assign('lng', $lng['list']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('article/model_add');
	}

	function onmodeledit() {
		parent::start_template();
		$db_table = db_prefix . 'model';
		$type = $this->fun->accept('type', 'G');
		$id = $this->fun->accept('id', 'G');
		$db_where = 'mid=' . $id;
		$modelread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('modelread', $modelread);
		if ($type == 'copy') {
			$this->ectemplates->display('article/model_copy');
		} else {
			$this->ectemplates->assign('type', $type);
			$this->ectemplates->display('article/model_edit');
		}
	}

	function onmodelattradd() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$mid = $this->fun->accept('mid', 'G');
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('formtypelist', $FORMTYPE);
		$this->ectemplates->display('article/model_attr_add');
	}

	function onmodelattredit() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$db_table = db_prefix . 'model_att';
		$aid = $this->fun->accept('aid', 'G');
		$mid = $this->fun->accept('mid', 'G');
		$db_where = 'aid=' . $aid;
		$modelattrread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('formtypelist', $FORMTYPE);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('modelattrread', $modelattrread);
		$this->ectemplates->display('article/model_attr_edit');
	}

	function onmodelsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$lng = empty($lng) ? $this->CON['is_lancode'] : $lng;
		$modelname = $this->fun->accept('modelname', 'P');
		$pagemax = $this->fun->accept('pagemax', 'P');
		$pagesylte = $this->fun->accept('pagesylte', 'P');
		$isbase = $this->fun->accept('isbase', 'P');
		$istsn = $this->fun->accept('istsn', 'P');
		$isalbum = $this->fun->accept('isalbum', 'P');
		$isextid = $this->fun->accept('isextid', 'P');
		$issid = $this->fun->accept('issid', 'P');
		$isfgid = $this->fun->accept('isfgid', 'P');
		$islinkdid = $this->fun->accept('islinkdid', 'P');
		$isorder = $this->fun->accept('isorder', 'P');
		$ismessage = $this->fun->accept('ismessage', 'P');
		$ispurview = $this->fun->accept('ispurview', 'P');

		$db_table = db_prefix . 'model';
		$date = time();
		$isclass = $this->esp_inputclassid;
		$isclass = empty($isclass) ? 0 : $isclass;
		if ($inputclass == 'add') {
			$db_field = 'lng,modelname,pagemax,pagesylte,isclass,lockin,istsn,isbase,addtime,isalbum,isextid,issid,isfgid,islinkdid,isorder,ismessage,ispurview';
			$db_values = "'$lng','$modelname',$pagemax,$pagesylte,$isclass,0,$istsn,$isbase,$date,$isalbum,$isextid,$issid,$isfgid,$islinkdid,$isorder,$ismessage,$ispurview";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['modelmanage_add_log'], $this->lng['log_extra_ok'] . ' modelname=' . $modelname);
			$this->dbcache->clearcache('model_array_' . $lng, true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$id = $this->fun->accept('id', 'P');
			$db_where = 'mid=' . $id;
			$db_set = "modelname='$modelname',pagemax=$pagemax,pagesylte=$pagesylte,isbase=$isbase,istsn=$istsn,isalbum=$isalbum,isextid=$isextid,issid=$issid,isfgid=$isfgid,islinkdid=$islinkdid,
			isorder=$isorder,ismessage=$ismessage,ispurview=$ispurview";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['modelmanage_edit_log'], $this->lng['log_extra_ok'] . ' modelname=' . $modelname . ' id=' . $id);
			$this->dbcache->clearcache('model_view_' . $id, true);
			$this->dbcache->clearcache('model_array_' . $lng, true);
			exit('true');
		} elseif ($inputclass == 'copy') {
			$id = $this->fun->accept('id', 'P');
			if (empty($id)) exit('false');

			$db_field = 'lng,modelname,pagemax,pagesylte,isclass,lockin,istsn,isbase,addtime,isalbum,isextid,issid,isfgid,islinkdid';
			$db_values = "'$lng','$modelname',$pagemax,$pagesylte,$isclass,0,$istsn,$isbase,$date,$isalbum,$isextid,$issid,$isfgid,$islinkdid";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$installid = $this->db->insert_id();
			if (empty($installid)) exit('false');

			$db_where = " WHERE mid=$id";
			$db_table = db_prefix . 'model_att';
			$sql = 'SELECT * FROM ' . $db_table . $db_where;
			$rs = $this->db->query($sql);
			$installstr = "INSERT INTO $db_table (pid,mid,typename,typeremark,attrname,inputtype,attrvalue,attrsize,attrrow,attrlenther,isclass) VALUES";
			$i = 0;
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$i++;
				$installstr.="($rsList[pid],$installid,'$rsList[typename]','$rsList[typeremark]','$rsList[attrname]','$rsList[inputtype]',
				'$rsList[attrvalue]',$rsList[attrsize],$rsList[attrrow],$rsList[attrlenther],$rsList[isclass]),";
			}
			if ($i > 0) {

				$newinstall = substr($installstr, 0, strlen($installstr) - 1);
				$this->db->query($newinstall);
			}
			$this->writelog($this->lng['modelmanage_copy_log'], $this->lng['log_extra_ok'] . ' modelname=' . $modelname . ' id=' . $id);
			$this->dbcache->clearcache('model_array_' . $lng, true);
			exit('true');
		}
	}

	function onmodelattrsave() {
		include admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$mid = $this->fun->accept('mid', 'P');
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
		$issearch = $this->fun->accept('issearch', 'P');
		$isclass = $this->fun->accept('isclass', 'P');
		$smid = $this->fun->accept('smid', 'P');
		$lockin = $this->fun->accept('lockin', 'P');

		$inputclass = $mid == 0 && $lockin == 1 ? 'copy' : $inputclass;

		$key = $this->fun->array_key($FORMTYPE, $inputtype, 'key');
		$attrarray = $FORMTYPE[$key];
		if (!$attrarray) {
			exit('false');
		}
		$attrlenther = $attrarray['varlong'];

		$db_table = db_prefix . 'model_att';
		$db_table2 = db_prefix . 'document_attr';
		if ($inputclass == 'add') {

			if ($attrarray['alter'] != 'TEXT') {

				$alter = $attrarray['alter'] == 'INT' || $attrarray['alter'] == 'FLOAT' ? $attrarray['alter'] . '(' . $attrarray['varlong'] . ') DEFAULT \'0\'' : $attrarray['alter'] . '(' . $attrarray['varlong'] . ')';
			} else {
				$alter = $attrarray['alter'];
			}

			$renameclass = $this->checkname($attrname, $mid, $inputtype);
			if (!$renameclass) {
				exit('false');
			}
			$db_where = " WHERE mid<>$mid and attrname='$attrname'";
			$countnum = $this->db_numrows($db_table, $db_where);
			if (!$countnum) {
				$this->db->query('ALTER TABLE ' . $db_table2 . ' ADD COLUMN ' . $attrname . ' ' . $alter . ' NOT NULL');
			}

			$db_field = 'pid,mid,typename,typeremark,attrname,inputtype,attrvalue,attrsize,attrrow,attrlenther,isclass,validatetext,isvalidate,issearch,lockin,islockin,issys';
			$db_values = "50,$mid,'$typename','$typeremark','$attrname','$inputtype','$attrvalue',$attrsize,$attrrow,$attrlenther,$isclass,'$validatetext',$isvalidate,$issearch,0,1,0";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');

			$this->writelog($this->lng['modelmanage_attr_add_log'], $this->lng['log_extra_ok'] . ' typename=' . $typename);
			$this->dbcache->clearcache('modeatt_array_' . $mid, true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$aid = $this->fun->accept('aid', 'P');
			if (empty($aid)) {
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
			if ($issearch) {
				$db_set_str.= ',issearch=' . $issearch;
			} else {
				$db_set_str.= ',issearch=0';
			}

			$db_where = 'aid=' . $aid;
			$db_set = "typename='$typename',typeremark='$typeremark',isclass=$isclass" . $db_set_str;

			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

			$this->writelog($this->lng['modelmanage_attr_edit_log'], $this->lng['log_extra_ok'] . ' typename=' . $typename . ' att=' . $attrname . ' id=' . $aid);
			$this->dbcache->clearcache('modeatt_array_' . $mid, true);
			$this->dbcache->clearcache('model_atrr_view_' . $aid, true);
			exit('true');
		} elseif ($inputclass == 'copy') {

			$aid = $this->fun->accept('aid', 'P');
			if (empty($aid)) {
				return false;
			}
			$db_field = 'pid,mid,typename,typeremark,attrname,inputtype,attrvalue,attrsize,attrrow,attrlenther,isclass,validatetext,isvalidate,issearch,lockin,islockin,issys';
			$db_values = "50,$smid,'$typename','$typeremark','$attrname','$inputtype','$attrvalue',$attrsize,$attrrow,$attrlenther,$isclass,'$validatetext',$isvalidate,0,1,1,$aid";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');

			$this->writelog($this->lng['modelmanage_attr_add_log'], $this->lng['log_extra_ok'] . ' typename=' . $typename);
			$this->dbcache->clearcache('modeatt_array_' . $mid, true);
			$this->dbcache->clearcache('model_atrr_view_' . $aid, true);
			exit('true');
		}
	}

	function ondelmodel() {
		$db_table = db_prefix . 'model';
		$db_table2 = db_prefix . 'model_att';
		$db_table3 = db_prefix . 'document_attr';
		$id = $this->fun->accept('id', 'R');
		if (empty($id)) exit('false');
		$db_where = "mid=$id";
		$db_where2 = "mid=$id AND issys=0 AND lockin=0";
		$sql = 'SELECT * FROM ' . $db_table2 . ' WHERE ' . $db_where2 . ' ORDER BY aid DESC';
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {

			$db_where3 = " WHERE attrname='$rsList[attrname]'";
			$countnum = $this->db_numrows($db_table2, $db_where3);
			if ($countnum == 1) {
				$this->db->query('ALTER TABLE ' . $db_table3 . ' DROP COLUMN ' . $rsList['attrname']);
			}
		}
		$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where);
		$this->writelog($this->lng['modelmanage_del_log'], $this->lng['log_extra_ok'] . ' id=' . $id);
		$this->dbcache->clearcache('model_array', true);
		$this->dbcache->clearcache('model_view_' . $id, true);
		$this->dbcache->clearcache('modeatt_array_' . $id, true);
		exit('true');
	}

	function ondelattr() {
		$db_table = db_prefix . 'model_att';
		$db_table2 = db_prefix . 'document_attr';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$aidarray = explode(',', $selectinfoid);
		$count = count($aidarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "aid=$aidarray[$i]";
			$attview = $this->get_modelattview($aidarray[$i]);
			if (!$attview['lockin']) {

				$db_where2 = " WHERE attrname='$attview[attrname]'";
				$countnum = $this->db_numrows($db_table, $db_where2);
				if ($countnum == 1) {
					$this->db->query('ALTER TABLE ' . $db_table2 . ' DROP COLUMN ' . $attview['attrname']);
				}
			}

			if ($attview['islockin']) {
				$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
				$this->dbcache->clearcache('model_atrr_view_' . $aidarray[$i], true);
			}
		}
		$this->writelog($this->lng['modelmanage_attr_log_del'], $this->lng['log_extra_ok'] . ' id=' . $infoid);
		$this->dbcache->clearcache('modeatt_array', true);
		exit('true');
	}

	function onattrsort() {
		$db_table = db_prefix . 'model_att';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$mid = $this->fun->accept('mid', 'R');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			$pid = intval($pidArray[$key]);
			if (!$pid) {
				continue;
			}
			if (!empty($value)) {
				$attview = $this->get_modelattview($value);
				if ($attview['lockin'] == 1 && $attview['islockin'] == 0 && $attview['issys'] == 0) {
					$db_field = 'pid,mid,typename,typeremark,attrname,inputtype,attrvalue,attrsize,attrrow,attrlenther,isclass,validatetext,isvalidate,issearch,lockin,islockin,issys';
					$db_values = "$pid,$mid,'$attview[typename]','$attview[typeremark]','$attview[attrname]','$attview[inputtype]','$attview[attrvalue]',$attview[attrsize],$attview[attrrow],$attview[attrlenther],$attview[isclass],'',0,0,1,1,$attview[aid]";
					$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
				} else {
					$db_where = "aid=$value";
					$db_set = "pid=$pid";
					$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
				}
			}
		}
		$this->writelog($this->lng['modelmanage_attr_log_sort'], $this->lng['log_extra_ok']);
		$this->dbcache->clearcache('modeatt_array', true);
		$this->dbcache->clearcache('model_atrr', true);
		exit('true');
	}

	function onmodelsetting() {
		$db_table = db_prefix . 'model';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "mid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['modelmanage_log_istype'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('model_', true);
		exit('true');
	}

	function oncheckattrname() {
		$attrname = $this->fun->accept('attrname', 'R');
		$mid = $this->fun->accept('mid', 'R');
		$inputtype = $this->fun->accept('inputtype', 'R');
		$renameclass = $this->checkname($attrname, $mid, $inputtype);
		if (!$renameclass) {
			exit('false');
		} else {
			exit('true');
		}
	}

	function checkname($attrname, $mid, $inputtype) {
		include admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		$attlist = array('datid', 'did', 'lng', 'pid', 'mid', 'aid', 'tid', 'sid', 'fgid', 'isclass', 'islink', 'ishtml', 'ismess', 'isorder',
		    'purview', 'istemplates', 'recommend', 'tsn', 'title', 'longtitle', 'color', 'author', 'source', 'pic', 'tags', 'keywords',
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

		$db_table = db_prefix . 'model_att';

		$db_where = " WHERE mid IN (0,$mid) and attrname='$attrname'";
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

}

?>