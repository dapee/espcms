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

	function onfilewindow() {
		include_once admin_ROOT . adminfile . '/include/command_list.php';
		parent::start_template();
		$listfunction = $this->fun->accept('listfunction', 'G');
		if (empty($listfunction)) {
			exit('err');
		}

		$checkfrom = $this->fun->accept('checkfrom', 'R');
		$checkfrom = empty($checkfrom) ? 'edit' : $checkfrom;

		$getbyid = $this->fun->accept('getbyid', 'R');

		$fileinputid = $this->fun->accept('fileinputid', 'R');

		$iframename = $this->fun->accept('iframename', 'R');

		$iframeid = $this->fun->accept('iframeid', 'R');

		$dirlist = $this->fun->accept('dirlist', 'R');

		$filetype = $this->fun->accept('filetype', 'R');
		$filetype = empty($filetype) ? 'img' : $filetype;

		$digheight = $this->fun->accept('digheight', 'R');

		$maxselect = $this->fun->accept('maxselect', 'R');
		$maxselect = empty($maxselect) ? 1 : $maxselect;

		$this->ectemplates->assign('loadurl', $CONLIST[$listfunction]['loadurl'] . '&dirlist=' . $dirlist . '&checkfrom=' . $checkfrom . '&fileinputid=' . $fileinputid . '&filetype=' . $filetype . '&maxselect=' . $maxselect);
		$this->ectemplates->assign('batupwindow', $CONLIST[$listfunction]['batupwindow'] . '&dirlist=' . $dirlist . '&checkfrom=' . $checkfrom . '&fileinputid=' . $fileinputid . '&filetype=' . $filetype . '&maxselect=' . $maxselect);
		$this->ectemplates->assign('picview', $CONLIST[$listfunction]['picview'] . '&dirlist=' . $dirlist . '&checkfrom=' . $checkfrom . '&fileinputid=' . $fileinputid . '&filetype=' . $filetype . '&maxselect=' . $maxselect);
		$this->ectemplates->assign('fileview', $CONLIST[$listfunction]['fileview'] . '&dirlist=' . $dirlist . '&checkfrom=' . $checkfrom . '&fileinputid=' . $fileinputid . '&filetype=' . $filetype . '&maxselect=' . $maxselect);

		$this->ectemplates->assign('listfunction', $listfunction);
		$this->ectemplates->assign('checkfrom', $checkfrom);
		$this->ectemplates->assign('iframename', $iframename);
		$this->ectemplates->assign('fileinputid', $fileinputid);
		$this->ectemplates->assign('getbyid', $getbyid);
		$this->ectemplates->assign('iframeid', $iframeid);
		$this->ectemplates->assign('digheight', $digheight);
		$this->ectemplates->assign('maxselect', $maxselect);
		$this->ectemplates->assign('filetype', $filetype);
		$this->ectemplates->assign('rootDIR', admin_rootDIR);

		$this->ectemplates->assign('framt', $digheight - 45);
		$this->ectemplates->display('public/public_filemanage_filewindow');
	}

	function onalbumlist() {
		parent::start_template();

		$db_table = db_prefix . 'album_images';

		$lng = $this->sitelng;
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$db_where = ' WHERE lng=\'' . $lng . '\'';

		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY amid DESC';
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}

		$lnglist = $this->get_lng_array($lng);
		$this->ectemplates->assign('lnglist', $lnglist['list']);

		$maxselect = $this->fun->accept('maxselect', 'R');
		$maxselect = empty($maxselect) ? 1 : $maxselect;
		$this->ectemplates->assign('maxselect', $maxselect);

		$fheight = $this->fun->accept('fheight', 'R');
		$this->ectemplates->assign("fheight", $fheight);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('loadurl', 'index.php?archive=filemanage&action=piclist');
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('public/public_filename_albumlist');
	}

	function onpiclist() {
		parent::start_template();
		$amid = $this->fun->accept('amid', 'R');
		if (empty($amid)) {
			exit($this->lng['filemanage_filecheck_select_no']);
		}

		$db_table = db_prefix . 'album_file';
		if (!empty($amid)) {
			$db_where = ' WHERE amid=' . $amid;
		}

		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY afid DESC';
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$rsList['fileallpath'] = $rsList['filepath'] . $rsList['filename'];
			$array[] = $rsList;
		}
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->display('public/public_filename_piclist');
	}

	function onfilelist() {
		parent::start_template();
		include_once admin_ROOT . adminfile . '/include/command_list.php';

		$dirlist = $this->fun->accept('dirlist', 'R');

		$checkfrom = $this->fun->accept('checkfrom', 'R');
		$checkfrom = empty($checkfrom) ? 'edit' : $checkfrom;

		$maxselect = $this->fun->accept('maxselect', 'R');
		$maxselect = empty($maxselect) ? 1 : $maxselect;

		$fileinputid = $this->fun->accept('fileinputid', 'R');

		$filetype = $this->fun->accept('filetype', 'R');
		$filetype = empty($filetype) ? 'img' : $filetype;

		$fheight = $this->fun->accept('fheight', 'R');


		$loadurlDIR = $CONLIST['filelist']['fileview'] . '&checkfrom=' . $checkfrom . '&fileinputid=' . $fileinputid . '&filetype=' . $filetype . '&maxselect=' . $maxselect . '&fheight=' . $fheight;

		$upfile_dir = admin_ROOT . $this->CON['upfile_dir'];

		if (!empty($dirlist)) {
			$upfile_dir = $upfile_dir . $dirlist;
		}

		$filepath = $this->CON['upfile_dir'] . $dirlist;

		if (!$this->fun->filemode($upfile_dir)) {
			exit($this->lng['filemanage_mode_err']);
		}

		if ($filetype == 'img') {

			$inputtype = $this->CON['upfile_pictype'];
		} elseif ($filetype == 'file') {

			$inputtype = $this->CON['upfile_filetype'];
		} elseif ($filetype == 'mover') {

			$inputtype = $this->CON['uifile_movertype'];
		}
		$filetypearray = explode('|', $inputtype);
		if (count($filetypearray) < 1) {
			exit($this->lng['filemanage_mode_err']);
		}
		$inputtype = null;
		foreach ($filetypearray as $key => $value) {
			if ($key == 0) {
				$inputtype.='*.' . $value;
			} else {
				$inputtype.=',*.' . $value;
			}
		}



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

		$files = @glob($upfile_dir . "{" . $inputtype . "}", GLOB_BRACE);

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
					$filearray_temp['size'] = 0;

					$filearray_temp['picerrid'] = 1;

					$filearray_temp['bottype'] = 'dir';
				} else {



					$filearray_temp['fid'] = md5($filepath . $mime['basename']);
					$filearray_temp['filename'] = $mime['basename'];

					$filearray_temp['path'] = $mime['dirname'];

					$filearray_temp['type'] = strtolower($mime['extension']);

					$filearray_temp['size'] = @filesize($file);

					if ($filearray_temp['type'] == 'jpg' || $filearray_temp['type'] == 'gif' || $filearray_temp['type'] == 'jpeg' || $filearray_temp['type'] == 'png') {
						$imginfo = $this->get_imginfo($file);
						if ($imginfo) {
							$filearray_temp['picerrid'] = $imginfo['picerrid'];
							$filearray_temp['srcW'] = $imginfo['srcW'];
							$filearray_temp['srcH'] = $imginfo['srcH'];
							$filearray_temp['windowsW'] = $imginfo['windowsW'];
							$filearray_temp['windowsH'] = $imginfo['windowsH'];
						} else {

							$filearray_temp['type'] == 'unknown';
						}
						$filearray_temp['bottype'] = 'img';
					} else {

						$filearray_temp['picerrid'] = 1;

						$filearray_temp['bottype'] = 'text';
					}
				}

				if ($imginfo['srcW'] > 0) {
					$filearray_temp['iswidth'] = $imginfo['srcW'] > $imginfo['srcH'] ? 1 : 2;
				} else {
					$filearray_temp['iswidth'] = 0;
				}
				$filearray_temp['time'] = filectime($file);

				$filearray[] = $filearray_temp;
				$i++;
			}
		}
		unset($filelist);
		unset($filearray_temp);

		$this->ectemplates->assign('dirlist', $dirlist);
		$this->ectemplates->assign('maxselect', $maxselect);
		$this->ectemplates->assign('checkfrom', $checkfrom);
		$this->ectemplates->assign('fileinputid', $fileinputid);
		$this->ectemplates->assign('upfile_dir', $upfile_dir);
		$this->ectemplates->assign("fheight", $fheight);
		$this->ectemplates->assign('filepath', $filepath);
		$this->ectemplates->assign('uploadurl', $uploadurl);
		$this->ectemplates->assign('updirtype', $updirtype);
		$this->ectemplates->assign('url', admin_URL . $this->CON['upfile_dir'] . $dirlist);
		$this->ectemplates->assign('admin_path', admin_PATH);
		$this->ectemplates->assign('array', $filearray);
		$this->ectemplates->display('public/public_filemanage_filelist');
	}

	function onupfile() {
		parent::start_template();

		$lng = $this->sitelng;
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;

		$path = $this->CON['upfile_dir'];

		$img_iswater = $this->CON['img_iswater'];

		$maxfile = $this->CON['upfile_maxsize'];

		$img_width = $this->CON['img_width'];

		$img_height = $this->CON['img_height'];

		$img_issmallpic = $this->CON['img_issmallpic'];

		$filetype = $this->fun->accept('filetype', 'R');
		$filetype = empty($filetype) ? 'img' : $filetype;

		$upfile_pictype = $filetype == 'img' ? $this->CON['upfile_pictype'] : ($filetype == 'file' ? $this->CON['upfile_filetype'] : $this->CON['uifile_movertype']);

		$upinfo = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '<font color="red">' . $this->lng['management_login_phpinfo07'] . '</font>';

		$fheight = $this->fun->accept('fheight', 'R');
		$this->ectemplates->assign("fheight", $fheight);
		if ($filetype == 'img') {
			$albumarray = $this->get_album_images_array(0, 1, $lng);
			$this->ectemplates->assign("array", $albumarray['list']);
		}
		$this->ectemplates->assign("path", $path);
		$this->ectemplates->assign("maxfile", $maxfile);
		$this->ectemplates->assign("maxfile2", $this->fun->format_size($maxfile));
		$this->ectemplates->assign("maxfile3", $upinfo);
		$this->ectemplates->assign("img_width", $img_width);
		$this->ectemplates->assign("img_height", $img_height);
		$this->ectemplates->assign("img_issmallpic", $img_issmallpic);
		$this->ectemplates->assign("upfile_pictype", str_replace('|', '、', $upfile_pictype));
		$this->ectemplates->assign("filetype", $filetype);
		$this->ectemplates->assign("img_iswater", $img_iswater);
		$this->ectemplates->assign("lng", $lng);
		$this->ectemplates->display("public/public_filemanage_upfile");
	}

	function onbatupfile() {
		parent::start_template();
		$path = $this->fun->accept('path', 'R');

		$maxfile = $this->CON['upfile_maxsize'];

		$img_width = $this->CON['img_width'];

		$img_height = $this->CON['img_height'];

		$img_issmallpic = $this->CON['img_issmallpic'];

		$filetype = $this->fun->accept('filetype', 'R');
		$filetype = empty($filetype) ? 'img' : $filetype;

		$upfile_pictype_flash = $filetype == 'img' ? $this->CON['upfile_pictype'] : ($filetype == 'file' ? $this->CON['upfile_filetype'] : $this->CON['uifile_movertype']);

		if (!empty($upfile_pictype_flash)) {
			$pictypearray = explode('|', $upfile_pictype_flash);
			$piccount = count($pictypearray) - 1;
			foreach ($pictypearray as $key => $value) {
				if ($piccount == $key) {
					$upfile_pictype.='*.' . $value;
				} else {
					$upfile_pictype.='*.' . $value . ';';
				}
			}
		} else {
			$upfile_pictype = '*.jpg;*.gif;*.png';
		}

		$upinfo = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '<font color="red">' . $this->lng['management_login_phpinfo07'] . '</font>';

		$maxselect = $this->fun->accept('maxselect', 'R');
		$maxselect = empty($maxselect) ? 8 : $maxselect;
		$this->ectemplates->assign('maxselect', $maxselect);



		$fheight = $this->fun->accept('fheight', 'R');
		$this->ectemplates->assign("fheight", $fheight);
		$this->ectemplates->assign("ecisp_admininfo", $this->fun->accept('ecisp_admininfo', 'C'));
		$this->ectemplates->assign("esp_powerlist", $this->fun->accept('esp_powerlist', 'C'));
		$this->ectemplates->assign("path", $path);
		$this->ectemplates->assign("maxfile", $maxfile);
		$this->ectemplates->assign("maxfile2", $this->fun->format_size($maxfile));
		$this->ectemplates->assign("img_width", $img_width);
		$this->ectemplates->assign("img_height", $img_height);
		$this->ectemplates->assign("img_issmallpic", $img_issmallpic);
		$this->ectemplates->assign("upfile_pictype", $upfile_pictype);
		$this->ectemplates->assign("upfile_pictype_str", str_replace('|', '、', $upfile_pictype_flash));
		$this->ectemplates->assign("path", $path);
		$this->ectemplates->assign("filetype", $filetype);
		$this->ectemplates->display("public/public_filemanage_batupfile");
	}

	function onbatupfilesave() {
		require_once admin_ROOT . '/public/class_upload.php';
		$temppath = $this->CON['upfile_dir'];
		$path = admin_ROOT . $temppath;

		if (!$this->fun->filemode($path)) {
			exit('false');
		}

		$img_issmallpic = $this->fun->accept('img_issmallpic', 'P');
		$img_issmallpic = empty($img_issmallpic) ? $this->CON['img_issmallpic'] : $img_issmallpic;

		$img_width = $this->fun->accept('img_width', 'P');
		$img_width = empty($img_width) ? $this->CON['img_width'] : $img_width;
		$img_height = $this->fun->accept('img_height', 'P');
		$img_height = empty($img_height) ? $this->CON['img_height'] : $img_height;

		$img_issmallpic = ($img_width < 1 || $img_height < 1 ) ? 0 : $img_issmallpic;

		$img_iswater = $this->fun->accept('img_iswater', 'P');
		$img_iswater = empty($img_iswater) ? $this->CON['img_iswater'] : $img_iswater;

		$type = $this->fun->accept('filetype', 'R');
		$type = empty($type) ? 'img' : $type;

		$filename = $_FILES['Filedata']['name'];

		$filesize = intval($_FILES['Filedata']['size']);

		$filetmpname = $_FILES['Filedata']['tmp_name'];

		$fileerror = $_FILES['Filedata']['error'];

		$filetype = $_FILES['Filedata']['type'];
		if ($filesize <= 0 || $filesize > intval($this->CON['upfile_maxsize'])) {
			exit('false');
		}
		$upfile = new uploadFile();
















		$filename = $upfile->upfilebase($img_width, $img_height, $img_issmallpic, $img_iswater, $path, $filename, $filesize, $filetmpname, $fileerror, NULL, $type);
		if ($filename) {
			$db_table = db_prefix . 'filename';
			$date = time();
			$filename = str_replace(admin_ROOT, '', $filename);

			list($uploadfile, $toImagesFile, $outfiletype, $filepath, $iswidth) = explode('|', $filename);
			if (!empty($uploadfile)) {
				$db_field = 'username,filetitle,filename,filetype,filepath,addtime,iswidth';
				$db_values = "('$this->esp_username','','$uploadfile','$outfiletype','$filepath',$date,$iswidth)";
				if ($toImagesFile) {
					$db_values.= ",('$this->esp_username','','$toImagesFile','$outfiletype','$filepath',$date,$iswidth)";
				}
				$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES ' . $db_values . '');
			}
		}
		if ($uploadfile) {
			exit('true');
		} else {
			exit('false');
		}
	}

	function onupfilesave() {
		require_once admin_ROOT . '/public/class_upload.php';
		$temppath = $this->fun->accept('path', 'P');
		$path = admin_ROOT . $temppath;

		if (!$this->fun->filemode($path)) {
			exit($this->lng['filemanage_js_upfile_no']);
		}

		$amid = $this->fun->accept('amid', 'P');
		$isamid = $this->fun->accept('isamid', 'P');
		$title = $this->fun->accept('title', 'P');
		$lng = $this->fun->accept('lng', 'P');
		if ($isamid) {
			if (empty($title)) {
				exit($this->lng['download_mess_size_err6']);
			}
			$db_table = db_prefix . 'album_images';
			$date = time();
			$db_field = 'pid,lng,title,content,pic,addtime,isclass,istop';
			$db_values = "50,'$lng','$title','$title','',$date,1,0";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$amid = $this->db->insert_id();
		}
		$upfilepath = $this->fun->accept('upfilepath', 'P');

		$img_issmallpic = $this->fun->accept('img_issmallpic', 'P');
		$img_issmallpic = empty($img_issmallpic) ? 0 : $img_issmallpic;

		$img_width = $this->fun->accept('img_width', 'P');
		$img_width = empty($img_width) ? 0 : $img_width;
		$img_height = $this->fun->accept('img_height', 'P');
		$img_height = empty($img_height) ? 0 : $img_height;

		$img_issmallpic = ($img_width < 1 || $img_height < 1 ) ? 0 : $img_issmallpic;

		$img_iswater = $this->fun->accept('img_iswater', 'P');
		$img_iswater = empty($img_iswater) ? 0 : $img_iswater;

		$type = $this->fun->accept('filetype', 'P');
		$type = empty($type) ? 'img' : $type;

		$filename = $_FILES['upfilepath']['name'];

		$filesize = intval($_FILES['upfilepath']['size']);

		$filetmpname = $_FILES['upfilepath']['tmp_name'];

		$fileerror = $_FILES['upfilepath']['error'];

		$filetype = $_FILES['upfilepath']['type'];
		if ($filesize <= 0 || $filesize > intval($this->CON['upfile_maxsize'])) {
			exit($this->lng['download_mess_size_err2']);
		}
		$upfile = new uploadFile();














		$filename = $upfile->upfilebase($img_width, $img_height, $img_issmallpic, $img_iswater, $path, $filename, $filesize, $filetmpname, $fileerror, $filetype, $type);
		if ($filename) {
			$db_table = db_prefix . 'filename';
			$date = time();
			$filename = str_replace(admin_ROOT, '', $filename);

			list($uploadfile, $toImagesFile, $outfiletype, $filepath, $iswidth) = explode('|', $filename);

			if (!empty($uploadfile)) {
				$db_field = 'username,filetitle,filename,filetype,filepath,addtime,iswidth';
				$db_values = "('$this->esp_username','','$uploadfile','$outfiletype','$filepath',$date,$iswidth)";
				if ($toImagesFile) {
					$db_values.= ",('$this->esp_username','','$toImagesFile','$outfiletype','$filepath',$date,$iswidth)";
				}
				$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES ' . $db_values . '');

				if ($amid && $outfiletype == 'img') {
					$insert_id = $this->db->insert_id();
					$db_table = db_prefix . 'album_file';
					$db_field = 'amid,fiid,filetitle,filedes,filename,filepath,iswidth,addtime';
					$db_values = "($amid,$insert_id,'$uploadfile','','$uploadfile','$filepath',$iswidth,$date)";
					$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES ' . $db_values . '');
				}
			}
		}
		if ($uploadfile) {
			exit($filepath . $uploadfile . '|' . $outfiletype . '|' . $iswidth);
		} else {
			exit('false');
		}
	}

}
?>
