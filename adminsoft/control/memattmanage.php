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

	function onmemberattlist() {
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
		$isvalidate = $this->fun->accept('isvalidate', 'R');
		if (!empty($isvalidate)) {
			if ($isvalidate == 2) $isvalidate = 0;
			$db_where.=' AND isvalidate=' . $isvalidate;
		}
		$isline = $this->fun->accept('isline', 'R');
		if (!empty($isline)) {
			if ($isline == 2) $isline = 0;
			$db_where.=' AND isline=' . $isline;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'maid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'member_attr';
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
		$this->ectemplates->display('member/mematt_list');
	}

	function onmemattadd() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('formtypelist', $FORMTYPE);
		$this->ectemplates->display('member/memattr_add');
	}

	function onmemattedit() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$db_table = db_prefix . 'member_attr';
		$maid = $this->fun->accept('maid', 'G');
		$db_where = 'maid=' . $maid;
		$attrread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('formtypelist', $FORMTYPE);
		$this->ectemplates->assign('modelattrread', $attrread);
		$this->ectemplates->display('member/memattr_edit');
	}

	function onattsave() {
		include admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$typename = $this->fun->accept('typename', 'P');
		$typeremark = $this->fun->accept('typeremark', 'P');
		$attrname = $this->fun->accept('attrname', 'P');
		$inputtype = $this->fun->accept('inputtype', 'P');
		$attrvalue = $this->fun->accept('attrvalue', 'P');
		$attrsize = $this->fun->accept('attrsize', 'P');
		$attrsize = empty($attrsize) ? 20 : $attrsize;
		$attrrow = $this->fun->accept('attrrow', 'P');
		$attrrow = empty($attrrow) ? 5 : $attrrow;
		$isvalidate = $this->fun->accept('isvalidate', 'P');
		$validatetext = $this->fun->accept('validatetext', 'P');
		$isclass = $this->fun->accept('isclass', 'P');

		$key = $this->fun->array_key($FORMTYPE, $inputtype, 'key');
		$attrarray = $FORMTYPE[$key];
		if (!$attrarray) {
			exit('false');
		}
		$attrlenther = $attrarray['varlong'];

		$db_table = db_prefix . 'member_attr';
		$db_table2 = db_prefix . 'member_value';
		if ($inputclass == 'add') {

			if ($attrarray['alter'] != 'TEXT') {

				$alter = $attrarray['alter'] == 'INT' || $attrarray['alter'] == 'FLOAT' ? $attrarray['alter'] . '(' . $attrarray['varlong'] . ') DEFAULT \'0\'' : $attrarray['alter'] . '(' . $attrarray['varlong'] . ')';
			} else {
				$alter = $attrarray['alter'];
			}

			$renameclass = $this->checkname($attrname, $inputtype);
			if (!$renameclass) {
				exit('false');
			}
			$db_where = " WHERE attrname='$attrname'";
			$countnum = $this->db_numrows($db_table, $db_where);
			if (!$countnum) {
				$this->db->query('ALTER TABLE ' . $db_table2 . ' ADD COLUMN ' . $attrname . ' ' . $alter . ' NOT NULL');
			}

			$db_field = 'lng,pid,typename,typeremark,attrname,inputtype,attrvalue,attrsize,attrrow,attrlenther,isclass,validatetext,isvalidate,isline';
			$db_values = "'$lng',50,'$typename','$typeremark','$attrname','$inputtype','$attrvalue',$attrsize,$attrrow,$attrlenther,$isclass,'$validatetext',$isvalidate,0";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');

			$this->writelog($this->lng['memattmanage_add'], $this->lng['log_extra_ok'] . ' typename=' . $typename);
			$this->dbcache->clearcache('memberatt_array', true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$maid = $this->fun->accept('maid', 'P');
			if (empty($maid)) {
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
			$db_where = "maid=" . $maid;
			$db_set = "typename='$typename',typeremark='$typeremark',isclass=$isclass" . $db_set_str;
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['memattmanage_edit'], $this->lng['log_extra_ok'] . ' typename=' . $typename . ' id=' . $maid);
			$this->dbcache->clearcache('memberatt_array', true);
			$this->dbcache->clearcache('memberatt_view_' . $maid, true);
			exit('true');
		}
	}

	function onmemattdel() {
		$db_table = db_prefix . 'member_attr';
		$db_table2 = db_prefix . 'member_value';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "maid=$infoarray[$i]";
			$attview = $this->get_memberattview($infoarray[$i]);

			if ($attview[attrname]) {
				$db_where2 = " WHERE attrname='$attview[attrname]'";
				$countnum = $this->db_numrows($db_table, $db_where2);
				if ($countnum == 1) {
					$this->db->query('ALTER TABLE ' . $db_table2 . ' DROP COLUMN ' . $attview['attrname']);
				}
			}
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
			$this->dbcache->clearcache('memberatt_view_' . $infoarray[$i], true);
		}
		$this->writelog($this->lng['memattmanage_log_del'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('memberatt_array', true);
		exit('true');
	}

	function onsort() {
		$db_table = db_prefix . 'member_attr';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "maid=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		}
		$this->writelog($this->lng['memattmanage_log_sort'], $this->lng['log_extra_ok']);
		$this->dbcache->clearcache('memberatt_array', true);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'member_attr';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "maid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['memattmanage_log_istype'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('memberatt_view', true);
		$this->dbcache->clearcache('memberatt_array', true);
		exit('true');
	}

	function oncheckattrname() {
		$attrname = $this->fun->accept('attrname', 'R');
		$inputtype = $this->fun->accept('inputtype', 'R');
		$renameclass = $this->checkname($attrname, $inputtype);
		if (!$renameclass) {
			exit('false');
		} else {
			exit('true');
		}
	}

	function checkname($attrname, $inputtype) {
		include admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		$attlist = array('userid', 'username', 'password', 'email', 'question', 'answer', 'sex', 'birthday', 'country', 'province', 'city', 'district',
		    'alias', 'address', 'zipcode', 'tel', 'mobile', 'qq', 'msn', 'integral', 'visitcount', 'lastip', 'addtime', 'lasttime', 'mcid', 'isclass');
		$attrnamearray = strtolower($attrname);

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		if (in_array($attrnamearray, $attlist)) {
			return false;
		}

		$key = $this->fun->array_key($FORMTYPE, $inputtype, 'key', 'alter');
		if (empty($key)) {
			return false;
		}

		$db_table = db_prefix . 'member_attr';

		$db_where = " WHERE lng='$lng' and attrname='$attrname'";
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