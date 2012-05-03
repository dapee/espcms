<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.cocheckdirnamem
 */

class important extends connector {

	function important() {
		$this->softbase(true);
	}

	function ontypelist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$db_table = db_prefix . 'typelist';

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = ' WHERE c.lng=\'' . $lng . '\'';
		$mid = $this->fun->accept('mid', 'R');
		if (!empty($mid)) {
			$db_where.=' AND c.mid=' . $mid;
		}

		$isclass = intval($this->fun->accept('isclass', 'R'));
		if (!empty($isclass)) {
			if ($isclass == 2) {
				$isclass = 0;
			}
			$db_where.=' AND c.isclass=' . $isclass;
		}

		if (!empty($countnum)) {
			$numsql = 'SELECT COUNT(*) AS num FROM ' . $db_table . ' AS c ' . $db_where;
			$resulted = $this->db->query($numsql);
			$resulted = $this->db->fetch_assoc($resulted);
			exit($resulted['num']);
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'c.pid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'ASC' : $limitclass;

		$sql = 'SELECT c.*,COUNT(a.tid) AS has_c FROM ' . $db_table . ' AS c LEFT JOIN ' . $db_table . ' AS a ON a.upid = c.tid' . $db_where . ' GROUP BY c.tid ORDER BY c.upid,' . $limitkey . ' ' . $limitclass;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {

			$rsList['dir'] = $this->get_lng_dirpack($rsList['lng']);
			$rsList['glink'] = $this->get_link('type', $rsList, $rsList['lng']);
			$rsList['puvname'] = empty($puvname) ? $this->lng['puv_no'] : $puvname;
			switch ($rsList['styleid']) {
				case 1:
					$rsList['stylename'] = '<font color="#489D66">' . $this->lng['typemanage_text_styleid1'] . '<font>';
					break;
				case 2:
					$rsList['stylename'] = $this->lng['typemanage_text_styleid2'];
					break;
				case 3:
					$rsList['stylename'] = '<font color="#FF0F0F">' . $this->lng['typemanage_text_styleid3'] . '<font>';
					break;
				case 4:
					$rsList['stylename'] = '<font color="#2E43E0">' . $this->lng['typemanage_text_styleid4'] . '<font>';
					break;
			}
			$t_array[] = $rsList;
		}

		if (is_array($t_array)) {
			$typelist = $this->get_typelist($t_array, $mid, 0, 0, $lng);
			unset($t_array);
			$newarray = array();
			foreach ($typelist as $key => $value) {
				$newarray[] = $value;
			}
			unset($typelist);
		}
		unset($this->CON, $this->lng);
		$this->ectemplates->assign('array', $newarray);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('article/type_list');
	}

	function ontypeadd() {
		include_once admin_ROOT . adminfile . '/include/command_templatesdir.php';
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;

		$upid = $this->fun->accept('upid', 'G');
		$upid = empty($upid) ? 0 : $upid;

		$topid = $this->fun->accept('topid', 'G');
		$topid = empty($topid) ? $upid : $topid;

		$mid = $this->fun->accept('mid', 'G');
		$mid = empty($mid) ? 0 : $mid;

		$styleid = $this->fun->accept('styleid', 'G');
		$styleid = empty($styleid) ? 0 : $styleid;

		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$memberpuv = $this->get_member_purview_array();
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);

		if (!empty($upid)) {
			$typeread = $this->get_type($upid);
		}

		$isbase = $styleid != 4 ? 2 : 1;
		$mid = !empty($typeread['mid']) ? $typeread['mid'] : $mid;
		$modelarray = $this->get_model($mid, $lng, 0, $isbase);
		$this->ectemplates->assign('modelarray', $modelarray['list']);

		$this->ectemplates->assign('ext', $this->CON['file_fileex']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('tempname', $TEMPNAMELIST);
		$this->ectemplates->assign('filetemplate', $TYPEURLLIST);
		$this->ectemplates->assign('readtemplate', $TYPEURLREAD);

		$this->ectemplates->assign('styleid', $styleid);
		$this->ectemplates->assign('upid', $upid);
		$this->ectemplates->assign('typread', $typeread);
		$this->ectemplates->assign('topid', $topid);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->display('article/type_add');
	}

	function ontypeedit() {
		include_once admin_ROOT . adminfile . '/include/command_templatesdir.php';
		parent::start_template();
		$db_table = db_prefix . 'typelist';
		$type = $this->fun->accept('type', 'G');
		$tid = intval($this->fun->accept('tid', 'G'));
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;
		$db_where = 'tid=' . $tid;
		$typeread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		if ($typeread['upid'] > 0) {

			$typelist = $this->get_typeselect(0, 0, $typeread['upid'], $typeread['lng'], 0, 1);
			$this->ectemplates->assign('typelist', $typelist);
		}
		$styleid = $this->fun->accept('styleid', 'G');
		$styleid = empty($styleid) ? 0 : $styleid;

		$lngdir = $this->get_lng_dirpack($typeread['lng']);
		$this->ectemplates->assign('lngdir', $lngdir);

		$memberpuv = $this->get_member_purview_array($typeread['purview']);
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);

		$model = $this->get_modelview($typeread['mid'], 'modelname');
		$this->ectemplates->assign('model', $model);

		$this->ectemplates->assign('ext', $this->CON['file_fileex']);

		$this->ectemplates->assign('pathdir', $this->CON['file_htmldir']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('typeread', $typeread);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->assign('is_alonelng', $this->CON['is_alonelng']);
		$this->ectemplates->assign('lng', $lng);
		$this->ectemplates->assign('styleid', $styleid);
		$this->ectemplates->assign('tempname', $TEMPNAMELIST);
		$this->ectemplates->assign('filetemplate', $TYPEURLLIST);
		$this->ectemplates->assign('readtemplate', $TYPEURLREAD);
		$this->ectemplates->display('article/type_edit');
	}

	function ontypeshift() {
		parent::start_template();
		$db_table = db_prefix . 'typelist';
		$type = $this->fun->accept('type', 'G');
		$tid = intval($this->fun->accept('tid', 'G'));
		$db_where = 'tid=' . $tid;
		$typeread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$typelist = $this->get_typeselect(0, 0, $typeread['upid'], $typeread['lng'], 0, 1);
		$this->ectemplates->assign('typelist', $typelist);

		$model = $this->get_modelview($typeread['mid'], 'modelname');
		$this->ectemplates->assign('model', $model);

		$lngdir = $this->get_lng_dirpack($typeread['lng']);
		$this->ectemplates->assign('lngdir', $lngdir);
		$this->ectemplates->assign('pathdir', $this->CON['file_htmldir']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('typeread', $typeread);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->display('article/type_shift');
	}

	function onsynchro() {
		parent::start_template();
		$db_table = db_prefix . 'typelist';

		$tid = intval($this->fun->accept('tid', 'G'));
		$db_where = 'tid=' . $tid;
		$typeread = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);

		$lnglist = $this->get_lng_array($typeread['lng']);

		$modelarray = $this->get_model(0, $typeread['lng'], 1, 2);

		$model = $this->get_modelview($typeread['mid']);
		$this->ectemplates->assign('model', $model);
		$this->ectemplates->assign('modelarray', $modelarray['list']);
		$this->ectemplates->assign('lnglist', $lnglist['list']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('typeread', $typeread);
		$this->ectemplates->display('article/type_synchro');
	}

	function onsynchrosave() {

		$tid = intval($this->fun->accept('tid', 'P'));

		$totid = intval($this->fun->accept('totid', 'P'));

		$mid = intval($this->fun->accept('mid', 'P'));
		if (empty($tid) || empty($totid) || empty($mid)) {
			exit('false');
		}

		$typeread = $this->get_type($totid);

		$modelatt = $this->get_modelattArray($mid);

		$modelarray = array();

		$modelsysarray = array();
		foreach ($modelatt as $key => $value) {

			if ($value['inputtype'] == 'htmltext') {

				$value['accept'] = 'html';
			} elseif ($value['inputtype'] == 'checkbox') {

				$value['accept'] = 'checkbox';
			} elseif ($value['inputtype'] == 'string' || $value['inputtype'] == 'img' || $value['inputtype'] == 'addon' || $value['inputtype'] == 'video' || $value['inputtype'] == 'select' || $value['inputtype'] == 'radio' || $value['inputtype'] == 'selectinput') {

				$value['accept'] = 'text';
			} elseif ($value['inputtype'] == 'editor' || $value['inputtype'] == 'text') {

				$value['accept'] = 'editor';
			} elseif ($value['inputtype'] == 'int' || $value['inputtype'] == 'float' || $value['inputtype'] == 'decimal') {

				$value['accept'] = 'int';
			} elseif ($value['inputtype'] == 'datetime') {

				$value['accept'] = 'data';
			}
			if (!$value['lockin'] && !$value['issys']) {
				$modelarray[] = $value;
			} else {
				$modelsysarray[] = $value;
			}
		}

		$sysinstall = null;

		$sysinstalldb = null;

		foreach ($modelsysarray as $key => $value) {
			if ($value['attrname'] == 'content') {
				continue;
			}
			$sysinstall.=$value['attrname'] . ',';
		}

		$userinstall = null;

		$userinstalldb = null;
		foreach ($modelarray as $key => $value) {
			$userinstall.=$value['attrname'] . ',';
		}

		$db_table = db_prefix . 'document';
		$db_table2 = db_prefix . 'document_album';
		$db_table3 = db_prefix . 'document_attr';
		$db_table4 = db_prefix . 'document_content';
		$db_field1 = $sysinstall . 'pid,mid,aid,isclass,islink,ishtml,ismess,isorder,purview,istemplates,isbase,tsn,color,link,addtime,uptime,template,filename,filepage';
		$db_field1_field = ",lng,tid,extid,sid,fgid,linkdid,ktid,recommend,tags,keywords,description,click,filepath";
		$db_field2 = 'did,picname,filedes,picfile,addtime';
		$db_field3 = $userinstall;
		$db_field4 = 'did,content';
		$db_where = " WHERE tid=$tid ORDER BY did";
		$sql = 'SELECT * FROM ' . $db_table . $db_where;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$db_where2 = ' WHERE did=' . $rsList['did'];

			$db_values1 = null;
			$db_field1_install_array = explode(',', $db_field1);
			foreach ($db_field1_install_array as $key => $value) {
				$db_values1.="'" . $rsList[$value] . "',";
			}

			$db_values1.="'$typeread[lng]','$totid','',0,0,'',0,'','','','',0,'$typeread[dirpath]'";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field1 . $db_field1_field . ') VALUES (' . $db_values1 . ')');
			$insert_id = $this->db->insert_id();

			$db_values2 = null;
			$albumsql = 'SELECT * FROM ' . $db_table2 . $db_where2;
			$albumrs = $this->db->query($albumsql);
			while ($rsAlbum = $this->db->fetch_assoc($albumrs)) {
				$db_values2.="($insert_id,'$rsAlbum[picname]','$rsAlbum[filedes]','$rsAlbum[picfile]',$rsAlbum[addtime]),";
			}
			$db_values2 = substr($db_values2, 0, strlen($db_values2) - 1);
			if (!empty($db_values2)) {
				$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field2 . ') VALUES ' . $db_values2 . '');
			}

			$db_values3 = null;
			$rsatt = $this->get_document_attr($rsList['did']);
			if (is_array($rsatt) && count($rsatt) > 0 && !empty($db_field3)) {
				$db_field2_install_array = explode(',', $db_field3);
				foreach ($db_field2_install_array as $key => $value) {
					if (!empty($value)) {
						$db_values3.="'" . $rsatt[$value] . "',";
					}
				}
				$db_values3.="'" . $insert_id . "'";
				if (!empty($db_values3)) {
					$this->db->query('INSERT INTO ' . $db_table3 . ' (' . $db_field3 . 'did) VALUES (' . $db_values3 . ')');
				}
			}

			$rsContent = $this->db->fetch_first('SELECT * FROM ' . $db_table4 . $db_where2);
			$this->db->query('INSERT INTO ' . $db_table4 . ' (' . $db_field4 . ") VALUES ('$insert_id','$rsContent[content]')");
		}
		exit('true');
	}

	function ontypesave() {
		include_once admin_ROOT . adminfile . '/include/command_templatesdir.php';
		include_once admin_ROOT . 'public/class_pingying.php';
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$inputupid = $this->fun->accept('inputupid', 'P');
		$lng = $this->sitelng;
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$mid = $this->fun->accept('mid', 'P');
		$mid = empty($mid) ? 0 : $mid;
		$upid = $this->fun->accept('upid', 'P');
		$upid = empty($upid) ? 0 : $upid;
		$topid = $this->fun->accept('topid', 'P');
		$topid = empty($topid) ? 0 : $topid;
		$typename = $this->fun->accept('typename', 'P');
		$content = $this->fun->accept('content', 'P');
		$content = empty($content) ? '' : $this->fun->Text2Html($content);
		$keywords = $this->fun->accept('keywords', 'P');
		$description = $this->fun->accept('description', 'P');
		$typepic = $this->fun->accept('typepic', 'P');
		$dirname = $this->fun->accept('dirname', 'P');
		$purview = $this->fun->accept('purview', 'P');
		$purview = empty($purview) ? 0 : $purview;
		$ismenu = $this->fun->accept('ismenu', 'P');
		$ismenu = empty($ismenu) ? 0 : $ismenu;
		$isaccessory = $this->fun->accept('isaccessory', 'P');
		$isaccessory = empty($isaccessory) ? 0 : $isaccessory;
		$isdirname = $this->fun->accept('isdirname', 'P');
		$isdirname = empty($isdirname) ? 0 : $isdirname;
		$styleid = $this->fun->accept('styleid', 'P');
		$pageclass = $this->fun->accept('pageclass', 'P');
		$pageclass = empty($pageclass) ? 0 : $pageclass;
		$ispart = $this->fun->accept('ispart', 'P');
		$ispart = empty($ispart) ? 0 : $ispart;

		$template = $this->fun->accept('template', 'P');
		$template = empty($template) ? $TEMPNAMELIST['typelist'] : $template;
		$indextemplates = $this->fun->accept('indextemplates', 'P');
		$indextemplates = empty($indextemplates) ? $TEMPNAMELIST['typeindex'] : $indextemplates;
		$readtemplate = $this->fun->accept('readtemplate', 'P');
		$readtemplate = empty($readtemplate) ? $TEMPNAMELIST['typeread'] : $readtemplate;

		$filenamestyle = $this->fun->accept('filenamestyle', 'P');
		$readnamestyle = $this->fun->accept('readnamestyle', 'P');
		$typeurl = $this->fun->accept('typeurl', 'P');
		$iswap = $this->fun->accept('iswap', 'P');
		$iswap = empty($iswap) ? 0 : $iswap;

		$waptempalte = $this->fun->accept('waptempalte', 'P');
		$waptempalte = empty($waptempalte) ? $TEMPNAMELIST['typelist'] : $waptempalte;
		$wapreadtemplate = $this->fun->accept('wapreadtemplate', 'P');
		$wapreadtemplate = empty($wapreadtemplate) ? $TEMPNAMELIST['typeread'] : $wapreadtemplate;

		$pagemax = $this->fun->accept('pagemax', 'P');
		$pagemax = empty($pagemax) ? 0 : $pagemax;

		$db_table = db_prefix . 'typelist';
		$date = time();
		if ($inputclass == 'add') {
			if ($isdirname) {

				$chinesespelit = new chineseSpell();
				$dirname = $chinesespelit->getFullSpell($typename);
			} else {
				if (!preg_match("/^[\w-]+$/i", $dirname)) {
					exit($this->lng['typemanage_js_dirname_empty']);
				}
			}

			if (!$upid) {
				$db_where = " WHERE upid=0 AND dirname='$dirname' AND lng='$lng'";
			} else {
				$db_where = " WHERE topid=$topid AND dirname='$dirname' AND lng='$lng'";
			}
			$countnum = $this->db_numrows($db_table, $db_where);
			if (!$isdirname) {
				if ($countnum > 0) {
					exit($this->lng['typemanage_js_type_dirname_check_no']);
				}
			} else {
				$dirname = $countnum > 0 ? $dirname . mt_rand(10, 99) : $dirname;
			}

			if (!$upid) {
				$db_where2 = " WHERE dirname='$dirname' AND lng='$lng'";
				$db_table2 = db_prefix . 'subjectlist';
				$countnum = $this->db_numrows($db_table2, $db_where2);
				if (!$isdirname) {
					if ($countnum > 0) {
						exit($this->lng['typemanage_js_type_dirname_check_no']);
					}
				} else {
					$dirname = $countnum > 0 ? $dirname . mt_rand(10, 99) : $dirname;
				}
			}

			$typepath = admin_ROOT . $this->CON['file_htmldir'];
			if (!$this->fun->filemode($typepath) && $styleid < 3) {
				exit($this->lng['filedir_err'] . '(' . $this->CON['file_htmldir'] . ')');
			}
			$lngdir = $this->get_lng_dirpack($lng);

			if ($upid == 0) {
				if ($this->CON['is_alonelng']) {
					$typedir = $typepath . $dirname;
				} else {
					$typedir = $typepath . $lngdir . '/' . $dirname;
				}
				$dirpath = $dirname;
				$topid = 0;
				$exmid = 0;
			} else {

				$topid_read = $this->get_type($topid);

				$exmid = ($topid_read['mid'] != $mid) ? $topid_read['mid'] : 0;

				$topid_temp = $topid_read['dirname'];

				if ($this->CON['is_alonelng']) {
					$typedir = $typepath . $topid_temp . '/' . $dirname;
				} else {
					$typedir = $typepath . $lngdir . '/' . $topid_temp . '/' . $dirname;
				}
				$dirpath = $topid_temp . '/' . $dirname;
			}

			if ($styleid != 3) {
				if (!is_dir($typedir)) {
					if (!@mkdir($typedir, 0777, true)) exit($this->lng['filedircreat_err'] . '(' . $this->CON['file_htmldir'] . ')');
				}
			}

			$db_field = 'pid,mid,topid,upid,exmid,lng,typename,content,keywords,description,typepic,dirname,purview,ismenu,isaccessory,isclass,ispart,styleid,pageclass,
				indextemplates,template,readtemplate,filenamestyle,readnamestyle,typeurl,dirpath,addtime,iswap,waptempalte,wapreadtemplate,pagemax';
			$db_values = "50,$mid,$topid,$upid,$exmid,'$lng','$typename','$content','$keywords','$description','$typepic','$dirname',$purview,$ismenu,$isaccessory,1,$ispart,$styleid,$pageclass,
			'$indextemplates','$template','$readtemplate','$filenamestyle','$readnamestyle','$typeurl','$dirpath',$date,$iswap,'$waptempalte','$wapreadtemplate',$pagemax";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');

			if ($styleid == 4) {
				$insert_id = $this->db->insert_id();
				$db_table2 = db_prefix . 'document';
				if (empty($insert_id)) {
					exit('true');
				}

				$aid = $this->esp_adminuserid;

				$isclass = $this->esp_inputclassid;
				$isclass = empty($isclass) ? 0 : $isclass;

				$db_field = 'lng,pid,mid,aid,tid,extid,sid,fgid,linkdid,isclass,islink,ishtml,ismess,isorder,ktid,purview,istemplates,recommend,tsn,title,longtitle,color,author,source,pic,tags,keywords,description,summary,link,oprice,bprice,click,addtime,uptime,template,filename,isbase';
				$db_values = "'$lng',50,$mid,$aid,$insert_id,'0',0,0,'',$isclass,0,1,0,0,0,0,0,'','','$typename','$typename','','','','','','','','','',0,0,0,$date,$date,'$readtemplate','',1";
				$this->db->query('INSERT INTO ' . $db_table2 . ' (' . $db_field . ') VALUES (' . $db_values . ')');
				$insert_id2 = $this->db->insert_id();

				$db_set = "linkid=$insert_id2";
				$db_where = 'tid=' . $insert_id;
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
			$this->writelog($this->lng['typemanage_add_log'], $this->lng['log_extra_ok'] . ' typename=' . $typename);
			$this->dbcache->clearcache('typelist_array', true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$tid = $this->fun->accept('tid', 'P');
			$topid = $this->fun->accept('topid', 'P');
			$topid = empty($topid) ? 0 : $topid;

			$beedit = $this->fun->accept('beedit', 'P');

			$beistemplatesedit = $this->fun->accept('beistemplatesedit', 'P');

			$editwap = $this->fun->accept('editwap', 'P');

			$db_where = 'tid=' . $tid;

			if ($inputupid > 0 && $upid != $inputupid) {

				$topid_temp = $this->get_type($upid);

				if ($topid_temp['topid'] == 0) {
					$newtopid = $topid_temp['tid'];
				} else {
					$newtopid = $topid_temp['topid'];
				}

				if ($newtopid != $topid) {
					$topid = $newtopid;
					$db_where2 = $this->get_typeid($tid, 'tid', $tid, $mid, 0, $lng);
					if ($db_where2) {
						$db_set = "topid=$topid";
						$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where2);
					}
				}
			}
			$db_set = "topid=$topid,upid=$upid,typename='$typename',content='$content',keywords='$keywords',description='$description',typepic='$typepic',purview=$purview,ismenu=$ismenu,
			isaccessory=$isaccessory,ispart=$ispart,styleid=$styleid,pageclass=$pageclass,template='$template',readtemplate='$readtemplate',filenamestyle='$filenamestyle',
			readnamestyle='$readnamestyle',typeurl='$typeurl',indextemplates='$indextemplates',iswap=$iswap,waptempalte='$waptempalte',wapreadtemplate='$wapreadtemplate',pagemax=$pagemax";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

			if ($beedit || $beistemplatesedit || $editwap) {
				$db_where2 = $this->get_typeid($tid, 'tid', $tid, $mid, 0, $lng);
				if ($db_where2) {
					$db_set = null;
					if ($beistemplatesedit) {
						$db_set.= "indextemplates='$indextemplates',template='$template',readtemplate='$readtemplate',filenamestyle='$filenamestyle',readnamestyle='$readnamestyle',pagemax=$pagemax,";
					}
					if ($beedit) {
						$db_set.= "typepic='$typepic',";
					}
					if ($editwap) {
						$db_set.= "waptempalte='$waptempalte',wapreadtemplate='$wapreadtemplate',";
					}
					$db_set = substr($db_set, 0, -1);
					$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where2);
				}
			}
			$this->writelog($this->lng['typemanage_edit_log'], $this->lng['log_extra_ok'] . ' typename=' . $typename . ' tid=' . $tid);
			$this->dbcache->clearcache('typelist_view_' . $tid, true);
			$this->dbcache->clearcache('typelist_array_' . $lng, true);
			if ($lng == $this->CON['is_lancode']) {
				$this->dbcache->clearcache('typelist_array_big5', true);
			}
			exit('true');
		} elseif ($inputclass == 'shift') {
			$tid = $this->fun->accept('tid', 'P');
			$shifttid = $this->fun->accept('shifttid', 'P');

			if ($shifttid == $tid || $shifttid == 0) exit('false');
			$isshift = $this->fun->accept('isshift', 'P');
			$db_table_dc = db_prefix . 'document';
			if ($isshift) {
				$db_where = $this->get_typeid($tid, 'tid', 0, $mid, 0, $lng);
			} else {
				$db_where = "tid=$tid";
			}
			$db_set = "tid=$shifttid";
			$this->db->query('UPDATE ' . $db_table_dc . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['typemanage_shift_log'], $this->lng['log_extra_ok'] . ' old_tid=' . $tid . ' newtid=' . $isshift);
			exit('true');
		}
	}

	function ondeltype() {
		$lng = $this->sitelng;

		$db_table = db_prefix . 'typelist';

		$db_table2 = db_prefix . 'document';

		$db_table3 = db_prefix . 'document_album';

		$db_table4 = db_prefix . 'document_content';

		$db_table5 = db_prefix . 'document_attr';
		$tid = $this->fun->accept('tid', 'R');
		if (empty($tid)) exit('false');

		$typeread = $this->get_type($tid);
		$mid = $typeread['mid'];
		$db_where = $this->get_typeid($tid, 'tid', 0, $mid, 0, $lng);

		$sql = 'SELECT did FROM ' . $db_table2 . ' WHERE ' . $db_where;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$db_where_dc = 'did=' . $rsList['did'];

			$this->db->query('DELETE FROM ' . $db_table3 . ' WHERE ' . $db_where_dc);

			$this->db->query('DELETE FROM ' . $db_table4 . ' WHERE ' . $db_where_dc);

			$this->db->query('DELETE FROM ' . $db_table5 . ' WHERE ' . $db_where_dc);
		}

		$typepath = admin_ROOT . $this->CON['file_htmldir'];
		if (!$this->fun->filemode($typepath)) {
			exit($this->lng['filedir_err'] . '(' . $this->CON['file_htmldir'] . ')');
		}

		$lngdir = $this->get_lng_dirpack($lng);

		$sql = 'SELECT tid,lng,dirpath FROM ' . $db_table . ' WHERE ' . $db_where;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {

			if (!empty($rsList['dirpath'])) {
				if ($this->CON['is_alonelng']) {
					$typedir = $typepath . $rsList['dirpath'];
				} else {
					$typedir = $typepath . $lngdir . '/' . $rsList['dirpath'];
				}
				if (!$this->fun->filemode($typedir)) {
					continue;
				}

				$this->fun->delfile($typedir);
			}
			$this->dbcache->clearcache('typelist_view_' . $rsList['tid'], true);
		}

		$this->db->query('DELETE FROM ' . $db_table2 . ' WHERE ' . $db_where);

		$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->writelog($this->lng['typemanage_del_log'], $this->lng['log_extra_ok'] . ' tid=' . $tid);
		$this->dbcache->clearcache('typelist_array', true);
		$this->dbcache->clearcache('typelist_view', true);
		exit('true');
	}

	function onsort() {
		$db_table = db_prefix . 'typelist';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "tid=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
				$this->dbcache->clearcache('typelist_view_' . $value, true);
			}
		}
		$this->writelog($this->lng['typemanage_log_sort'], $this->lng['log_extra_ok']);
		$this->dbcache->clearcache('typelist_array', true);
		exit('true');
	}

	function ontypesetting() {
		$db_table = db_prefix . 'typelist';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$selectinfoid = $selectinfoid . '0';
		$typeid = explode(',', $selectinfoid);

		$value = $this->fun->accept('value', 'P');

		$dbname = $this->fun->accept('dbname', 'P');

		$ch = $this->fun->accept('ch', 'R');
		$ch = empty($ch) ? 0 : $ch;
		$db_set = "$dbname=$value";
		if ($ch == 1) {

			$db_where = "tid IN ( $selectinfoid )";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		} else {

			foreach ($typeid as $tid) {
				if ($tid > 0) {

					$topid_temp = $this->get_type($tid);

					if ($topid_temp['upid'] > 0) {
						$upid = $topid_temp['upid'];

						$upid_isclass = $this->get_type($upid, $dbname);

						if ($value != $upid_isclass && $value == 1) exit('false');
					}
					$mid = $topid_temp['mid'];
					$lng = $topid_temp['lng'];
					$db_where = $this->get_typeid($tid, 'tid', 0, $mid, 0, $lng);
					$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
				}
			}
		}
		$this->writelog($this->lng['typemanage_log_istype'], $this->lng['log_extra_ok'] . ' tid=' . $selectinfoid);
		$this->dbcache->clearcache('typelist_', true);
		exit('true');
	}

	function oncheckdirname() {
		$dirname = $this->fun->accept('dirname', 'R');
		$lng = $this->sitelng;
		$topid = $this->fun->accept('topid', 'R');
		$upid = $this->fun->accept('upid', 'R');
		if (empty($dirname) || empty($lng)) {
			exit('false');
		}
		if (!preg_match("/^[\w-]+$/i", $dirname)) {
			exit('false');
		}
		$db_table = db_prefix . 'typelist';
		$db_table2 = db_prefix . 'subjectlist';
		if (!$upid) {
			$db_where = " WHERE upid=0 AND dirname='$dirname' AND lng='$lng'";
		} else {
			$db_where = " WHERE topid=$topid AND dirname='$dirname' AND lng='$lng'";
		}
		$countnum = $this->db_numrows($db_table, $db_where);
		if ($countnum > 0) {
			$exportAjax = 'false';
		} else {
			if (!$upid) {
				$db_where2 = " WHERE dirname='$dirname' AND lng='$lng'";
				$countnum = $this->db_numrows($db_table2, $db_where2);
				if ($countnum > 0) {
					$exportAjax = 'false';
				} else {
					$exportAjax = 'true';
				}
			} else {
				$exportAjax = 'true';
			}
		}
		exit($exportAjax);
	}

}

?>