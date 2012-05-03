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

	function ontemplatelist() {
		parent::start_template();
		include_once admin_ROOT . adminfile . '/include/command_list.php';

		$countnum = intval($this->fun->accept('countnum', 'R'));
		if (!empty($countnum)) {
			exit('1000');
		}

		$dirlist = $this->fun->accept('dirlist', 'R');

		$lng = $this->sitelng;
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;

		$templates_fileex = !empty($this->CON['templates_fileex']) ? '*.' . $this->CON['templates_fileex'] : '*.html';

		$skinDir = $this->fun->accept('skindir', 'R');
		$skinDir = empty($skinDir) ? $this->CON['default_templates'] : $skinDir;

		$fileDir = $this->fun->accept('filedir', 'R');
		$fileDir = empty($fileDir) ? '' : $fileDir . '/';

		$upfile_dir = admin_ROOT . 'templates/' . $skinDir . '/';


		if (!empty($dirlist)) {
			$upfile_dir = $upfile_dir . $dirlist;
		}

		if (!$this->fun->filemode($upfile_dir)) {
			exit($this->lng['filemanage_mode_err']);
		}
		$loadurlDIR = $CONLIST['templatelist']['loadurl'] . '&skindir=' . $skinDir . '&filedir=' . $fileDir;

		if (preg_match("/(\/)/i", $dirlist)) {

			$updir = explode('/', $dirlist);
			array_pop($updir);
			array_pop($updir);
			$updirfile = implode('/', $updir);

			$updirtype = 1;

			$uploadurl = empty($updirfile) ? $loadurlDIR . '&dirlist=' : $loadurlDIR . '&dirlist=' . $updirfile . '/';
		} else {

			$updirtype = 2;
		}

		$files = @glob($upfile_dir . "{" . $templates_fileex . "}", GLOB_BRACE);

		$filesDIR = @glob($upfile_dir . '*', GLOB_ONLYDIR);
		$filenum = empty($files) ? 0 : count($files);
		$fileDirnum = empty($filesDIR) ? 0 : count($filesDIR);
		if ($filenum > 0 || $fileDirnum > 0) {
			$filelist = array();
			if ($fileDirnum > 0) {
				$filelist[0] = $filesDIR;
			} else {
				$filelist[0] = array();
			}
			if ($filenum > 1) {

				foreach ($files as $key => $file) {
					$filetime = filectime($file);

					if (isset($filelist[1][$filetime + $key])) {
						$keyset = $filetime + $key + 2;
					} else {
						$keyset = $filetime + $key;
					}
					$filelist[1][$keyset] = $file;
				}

				krsort($filelist[1]);
			} elseif ($filenum == 1) {
				$filelist[1] = $files;
			} else {
				$filelist[1] = array();
			}
			$filelist = array_merge_recursive($filelist[0], $filelist[1]);

			unset($files);
			unset($file);
			$filearray = array();
			$i = 0;
			foreach ($filelist as $key => $file) {
				$filearray_temp = array();
				$mime = $this->getMimeType($file);
				if ($mime == 'dir') {


					$dir = pathinfo($file);

					$loadurl = $loadurlDIR . '&dirlist=' . $dirlist . $dir['basename'] . '/';
					$filearray_temp['loadurl'] = $loadurl;

					$filearray_temp['filename'] = $dir['basename'];

					$filearray_temp['path'] = $dir['dirname'];

					$filearray_temp['type'] = 'dir';

					$filearray_temp['bottype'] = 'dir';
				} else {



					$filearray_temp['fid'] = md5($filepath . $mime['basename']);
					$filearray_temp['filename'] = $mime['filename'];
					$filearray_temp['basename'] = $mime['basename'];

					$filearray_temp['path'] = $mime['dirname'];

					$filearray_temp['type'] = strtolower($mime['extension']);
					$filearray_temp['bottype'] = 'text';
				}
				$filearray_temp['time'] = filectime($file);

				$filearray[] = $filearray_temp;
				$i++;
			}
		}
		unset($filelist);
		unset($filearray_temp);
		$this->ectemplates->assign('dirlist', $dirlist);
		$this->ectemplates->assign('upfile_dir', $upfile_dir);
		$this->ectemplates->assign('uploadurl', $uploadurl);
		$this->ectemplates->assign('updirtype', $updirtype);
		$this->ectemplates->assign('admin_path', admin_PATH);
		$this->ectemplates->assign('array', $filearray);
		$this->ectemplates->assign('templateDIR', $skinDir . '/' . $dirlist);
		$this->ectemplates->assign('loadurl', $loadurlDIR);
		$this->ectemplates->display('template/templates_list');
	}

	function onlistwindow() {
		parent::start_template();
		include_once admin_ROOT . adminfile . '/include/command_list.php';

		$dirlist = $this->fun->accept('dirlist', 'R');

		$lng = $this->sitelng;
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;

		$digheight = $this->fun->accept('digheight', 'R');

		$typeclass = $this->fun->accept('typeclass', 'R');
		$fileclass = $this->fun->accept('fileclass', 'R');

		$iframename = $this->fun->accept('iframename', 'R');

		$inputtext = $this->fun->accept('inputtext', 'R');
		$inputtext = empty($inputtext) ? 'template' : $inputtext;

		$templates_fileex = !empty($this->CON['templates_fileex']) ? '*.' . $this->CON['templates_fileex'] : '*.html';

		$skinDir = $this->fun->accept('skindir', 'R');
		$skinDir = empty($skinDir) ? $this->CON['default_templates'] : $skinDir;

		$fileDir = $this->fun->accept('filedir', 'R');
		$fileDir = empty($fileDir) ? '' : $fileDir . '/';

		$upfile_dir = admin_ROOT . 'templates/' . $skinDir . '/' . $lng . '/' . $fileDir;

		if (!empty($dirlist)) {
			$upfile_dir = $upfile_dir . $dirlist;
		}

		if (!$this->fun->filemode($upfile_dir)) {
			exit($this->lng['filemanage_mode_err']);
		}
		$loadurlDIR = $CONLIST['templateslistwindow']['tabloadurl'] . '&inputtext=' . $inputtext . '&typeclass=' . $typeclass . '&skindir=' . $skinDir . '&filedir=' . $fileDir . '&fileclass=' . $fileclass . '&digheight=' . $digheight . '&iframename=' . $iframename;

		if (preg_match("/(\/)/i", $dirlist)) {

			$updir = explode('/', $dirlist);
			array_pop($updir);
			array_pop($updir);
			$updirfile = implode('/', $updir);

			$updirtype = 1;

			$uploadurl = empty($updirfile) ? $loadurlDIR . '&dirlist=' : $loadurlDIR . '&dirlist=' . $updirfile . '/';
		} else {

			$updirtype = 2;
		}

		$files = @glob($upfile_dir . "{" . $templates_fileex . "}", GLOB_BRACE);

		$filesDIR = @glob($upfile_dir . '*', GLOB_ONLYDIR);
		$filenum = count($files);
		$fileDirnum = count($filesDIR);

		if ($filenum > 0 || $fileDirnum > 0) {
			$filelist = array();
			if ($fileDirnum > 0) {
				$filelist[0] = $filesDIR;
			} else {
				$filelist[0] = array();
			}
			if ($filenum > 1) {

				foreach ($files as $key => $file) {
					$filetime = filectime($file);

					if (isset($filelist[1][$filetime + $key])) {
						$keyset = $filetime + $key + 2;
					} else {
						$keyset = $filetime + $key;
					}
					$filelist[1][$keyset] = $file;
				}

				krsort($filelist[1]);
			} elseif ($filenum == 1) {
				$filelist[1] = $files;
			} else {
				$filelist[1] = array();
			}
			$filelist = array_merge_recursive($filelist[0], $filelist[1]);

			unset($files);
			unset($file);
			$filearray = array();
			$i = 0;
			foreach ($filelist as $key => $file) {
				$filearray_temp = array();
				$mime = $this->getMimeType($file);
				if ($mime == 'dir') {


					$dir = pathinfo($file);

					$loadurl = $loadurlDIR . '&dirlist=' . $dirlist . $dir['basename'] . '/';
					$filearray_temp['loadurl'] = $loadurl;

					$filearray_temp['filename'] = $dir['basename'];

					$filearray_temp['path'] = $dir['dirname'];

					$filearray_temp['type'] = 'dir';

					$filearray_temp['bottype'] = 'dir';
				} else {



					$filearray_temp['fid'] = md5($filepath . $mime['basename']);
					$filearray_temp['filename'] = $mime['filename'];
					$filearray_temp['basename'] = $mime['basename'];

					$filearray_temp['path'] = $mime['dirname'];

					$filearray_temp['type'] = strtolower($mime['extension']);
					$filearray_temp['bottype'] = 'text';
				}
				$filearray_temp['time'] = filectime($file);

				$filearray[] = $filearray_temp;
				$i++;
			}
		}
		unset($filelist);
		unset($filearray_temp);
		$this->ectemplates->assign('iframename', $iframename);
		$this->ectemplates->assign('dirlist', $dirlist);
		$this->ectemplates->assign('inputtext', $inputtext);
		$this->ectemplates->assign('upfile_dir', $upfile_dir);
		$this->ectemplates->assign('uploadurl', $uploadurl);
		$this->ectemplates->assign('updirtype', $updirtype);
		$this->ectemplates->assign('fheight', $digheight);
		$this->ectemplates->assign('admin_path', admin_PATH);
		$this->ectemplates->assign('array', $filearray);
		$this->ectemplates->assign('templateDIR', 'templates/' . $skinDir . '/' . $lng . '/' . $fileDir);
		$this->ectemplates->assign('loadurl', $loadurlDIR);
		$this->ectemplates->display('template/templates_templatemain_listwindow');
	}

	function ontemplateedit() {
		parent::start_template();
		$db_table = db_prefix . 'templates';
		$type = $this->fun->accept('type', 'G');
		$dir = $this->fun->accept('dir', 'G');
		$filename = $this->fun->accept('filename', 'G');
		if (empty($dir) || empty($filename)) {
			exit($this->lng['filemanage_mode_err']);
		}
		$templatefile = admin_ROOT . 'templates/' . $dir . $filename;
		if (@is_file($templatefile)) {
			$templatecotent = @file_get_contents($templatefile);
			$templatecotent = !empty($templatecotent) ? htmlspecialchars($templatecotent) : $templatefile;
		} else {
			exit($this->lng['filemanage_mode_err']);
		}
		$this->ectemplates->assign('content', $templatecotent);
		$this->ectemplates->assign('type', $type);
		$this->ectemplates->assign('dir', $dir);
		$this->ectemplates->assign('filename', $filename);
		$this->ectemplates->assign('tab', 'true');
		$tempfile = $type == 'edit' ? 'template/templates_edit' : 'template/templates_copy';
		$this->ectemplates->display($tempfile);
	}

	function onsave() {
		$inputclass = $this->fun->accept('inputclass', 'P');
		$templatecode = $this->fun->accept('templatecode', 'P');
		$content = $this->fun->accept('content', 'P');
		$dir = $this->fun->accept('dir', 'P');
		$filename = $this->fun->accept('filename', 'P');
		if (empty($dir) || empty($filename) || empty($content)) {
			exit('false');
		}
		$db_table = db_prefix . 'templates';
		$date = time();
		if ($inputclass == 'add') {
			$db_field = 'lng,templatename,templatecode,title,templatecontent,pic,typeclass,styleclass,lockin,addtime';
			$db_values = "'$lng','$templatename','$templatecode','','$templatecontent','$pic','$typeclass',$styleclass,0,$date";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['templatemain_add_log'], $this->lng['log_extra_ok'] . ' templatename=' . $templatename);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$tempdirpath = admin_ROOT . 'templates/' . $dir . $filename;
			if (!$this->fun->filemode($tempdirpath)) {
				exit('false');
			}
			$filecontent = stripslashes(htmlspecialchars_decode($content));
			if (!$this->fun->filewrite($tempdirpath, $filecontent)) {
				exit('false');
			}
			exit('true');
		} elseif ($inputclass == 'copy') {
			$tempdirpath = admin_ROOT . 'templates/' . $dir;
			if (!$this->fun->filemode($tempdirpath)) {
				exit('false');
			}
			$filecontent = stripslashes(htmlspecialchars_decode($content));
			$tempdirpath_n = $tempdirpath . $templatecode . '.' . $this->CON['templates_fileex'];
			if (!$this->fun->filewrite($tempdirpath_n, $filecontent)) {
				exit('false');
			}
			exit('true');
		}
	}

	function ontemplatedel() {
		$dir = $this->fun->accept('dir', 'R');
		$filename = $this->fun->accept('filename', 'R');
		if (empty($dir) || empty($filename)) {
			exit('false');
		}
		$tempdirpath = admin_ROOT . 'templates/' . $dir . $filename;
		if (is_file($tempdirpath)) {
			if (!$this->fun->delfile($tempdirpath)) {
				exit('false');
			}
		} else {
			exit('false');
		}
		$this->writelog($this->lng['templatemain_del_log'], $this->lng['log_extra_ok'] . ' file=' . $dir . $filename);
		exit('true');
	}

	function oncheckcode() {
		$templatecode = $this->fun->accept('templatecode', 'R');
		$dir = $this->fun->accept('dir', 'R');
		$tempdirpath = admin_ROOT . 'templates/' . $dir . $templatecode . '.' . $this->CON['templates_fileex'];
		if (@is_file($tempdirpath)) {
			$exportAjax = 'false';
		} else {
			$exportAjax = 'true';
		}
		exit($exportAjax);
	}

	function onlabelcreat() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$plugcode = $this->fun->accept('plugcode', 'R');

		$lng = $this->sitelng;
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;

		$lable = $this->fun->readplug(admin_ROOT . 'public/lable');

		$plugcode = empty($plugcode) ? $lable[0]['code'] : $plugcode;

		$modulesid = true;
		$modules = array();
		require admin_ROOT . 'public/lable/' . $plugcode . '.php';
		$lablelist = $modules[0];
		unset($modulesid);
		$this->ectemplates->assign('lable', $lable);
		$this->ectemplates->assign('lable_config', $lablelist['config']);
		$this->ectemplates->assign('lablelist', $lablelist);

		$lnglist = $this->get_lng_array($lng);
		$this->ectemplates->assign('lnglist', $lnglist['list']);

		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;
		$modelarray = $this->get_model(0, $lng, 1);
		$this->ectemplates->assign('modelarray', $modelarray['list']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('template/template_label_creat');
	}

	function onlabeldb() {
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$labeltype = $this->fun->accept('labeltype', 'P');
		$mid = $this->fun->accept('mid', 'P');
		$tid = $this->fun->accept('tid', 'P');
		$sid = $this->fun->accept('sid', 'P');
		$dlid = $this->fun->accept('dlid', 'P');
		$blid = $this->fun->accept('blid', 'P');
		$btid = $this->fun->accept('btid', 'P');
		$inputvalue = $this->fun->accept('inputvalue', 'P');
		$inputname = $this->fun->accept('inputname', 'P');
		if (empty($labeltype)) {
			return false;
		}
		$otherarray = array('blid' => $blid, 'btid' => $btid);
		$newArray = array();
		if (is_array($inputname)) {
			foreach ($inputname as $key => $value) {
				$newArray[] = array($value => $inputvalue[$key]);
			}
		}
		include_once admin_ROOT . 'public/lable/' . $labeltype . '.php';
		$plugpay = new $labeltype();
		$lable = $plugpay->get_code($lng, $mid, $tid, $sid, $dlid, $newArray, $otherarray);
		if ($lable) {
			exit($lable);
		} else {
			exit('false');
		}
	}

	function onattrindex() {

		$plugcode = $this->fun->accept('code', 'G');
		$lng = $this->fun->accept('lng', 'G');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$lnglist = $this->get_lng_array($lng);

		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;
		$modelarray = $this->get_model(0, $lng, 1, 2);

		$modulesid = true;
		$modules = array();

		include_once admin_ROOT . 'public/lable/' . $plugcode . '.php';
		$lablelist = $modules[0];
		unset($modulesid);
		$attrlist.='<table class="formtable">
				<tr class="trstyle2">
					<td class="trtitle01">' . $this->lng['templatemain_add_label_str'] . '</td>
					<td class="trtitle02">' . $lablelist['desc'] . '</td>
				</tr>';

		if ($lablelist['lng'] == 1 && is_array($lnglist['list'])) {
			$attrlist.='<tr class="trstyle2"><td class="trtitle01">' . $this->lng['createmain_add_lng'] . '</td>
				<td class="trtitle02"><select size="1" name="lng" id="lng" onchange="javascript:selectlinkagelng(\'mid\',\'index.php?archive=connected&action=scmodellist&lng=\'+this.value);searchoption(1000000,\'' . urlencode($this->lng['all_botton']) . '\')">';
			foreach ($lnglist['list'] as $key => $value) {
				$attrlist.='<option ' . $value['selected'] . ' value="' . $value['lng'] . '">' . $value['lngtitle'] . '</option>';
			}
			$attrlist.='</select></td></tr>';
		}

		if ($lablelist['mid'] == 1 && is_array($modelarray['list'])) {
			$attrlist.='<tr class="trstyle2"><td class="trtitle01">' . $this->lng['createmain_add_mid'] . '</td>
				<td class="trtitle02"><select size="1" name="mid" id="mid" onchange="javascript:searchoption(this.value,\'' . urlencode($this->lng['all_botton']) . '\')"><option value="0">' . $this->lng['recommanage_type_add_mid_option'] . '</option>';
			foreach ($modelarray['list'] as $key => $value) {
				$attrlist.='<option ' . $value['selected'] . ' value="' . $value['mid'] . '">' . $value['modelname'] . '</option>';
			}
			$attrlist.='</select></td></tr>';
		}

		if ($lablelist['tid'] == 1) {
			$attrlist.='<tr class="trstyle2"><td class="trtitle01">' . $this->lng['article_doc_add_tid'] . '</td>
				<td class="trtitle02"><select size="1" name="tid" id="tid"><option value="0">' . $this->lng['all_botton'] . '</option>';
			$attrlist.='</select></td></tr>';
		}

		if ($lablelist['sid'] == 1) {
			$attrlist.='<tr class="trstyle2"><td class="trtitle01">' . $this->lng['article_doc_add_sid'] . '</td>
				<td class="trtitle02"><select size="1" name="sid" id="sid"><option value="0">' . $this->lng['all_botton'] . '</option>';
			$attrlist.='</select></td></tr>';
		}

		if ($lablelist['dlid'] == 1) {
			$attrlist.='<tr class="trstyle2"><td class="trtitle01">' . $this->lng['viewtype_botton'] . '</td>
				<td class="trtitle02"><span id="dlidlist"><input type="radio" value="0" checked="checked" name="dlid"/> ' . $this->lng['all_botton'] . '</span></td></tr>';
		}

		foreach ($lablelist['config'] as $key => $valuer) {
			if ($valuer['str']) {
				$str = '<span class="cautiontitle">' . $valuer['str'] . '</span>';
			} else {
				$str = null;
			}
			switch ($valuer['type']) {
				case 'text':
					$attrlist.='
					<tr class="trstyle2">
						<td class="trtitle01">' . $valuer['botname'] . '</td>
						<td class="trtitle02">
							<input type="text" name="inputvalue[]" maxlength="200" size="20" value="' . $valuer['value'] . '" class="infoInput">
							<input type="hidden" name="inputname[]" value="' . $valuer['name'] . '">
							' . $str . '
						</td>
					</tr>';
					break;
				case 'select':
					$attrlist.='<tr class="trstyle2">
						<td class="trtitle01">' . $valuer['botname'] . '</td>
						<td class="trtitle02"><select size=1 name="inputvalue[]">';
					foreach ($valuer['sevalue'] as $key2 => $valuer2) {
						$selected = ($key2 == $paylist['value']) ? 'selected' : '';
						$sevaluer.=$valuer2 . '|';
						$attrlist.='<option ' . $selected . ' value=' . $key2 . '>' . $valuer2 . '</option>';
					}
					$attrlist.='</select>
					<input type="hidden" name="inputname[]" value="' . $valuer['name'] . '">
					' . $str . '
					</td></tr>';
					break;
			}
			$sevaluer = '';
		}
		$attrlist.='</table>';
		exit($attrlist);
	}

}

?>