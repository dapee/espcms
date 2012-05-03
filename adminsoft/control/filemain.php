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

	function onfileadminlist() {
		parent::start_template();
		include_once admin_ROOT . adminfile . '/include/command_list.php';

		$countnum = intval($this->fun->accept('countnum', 'R'));
		if (!empty($countnum)) {
			exit('10000');
		}

		$dirlist = $this->fun->accept('dirlist', 'R');

		$fileDir = $this->fun->accept('filedir', 'R');
		$fileDir = empty($fileDir) ? '' : $fileDir . '/';

		$upfile_dir = admin_ROOT . $this->CON['upfile_dir'];

		if (!empty($dirlist)) {
			$upfile_dir = $upfile_dir . $dirlist;
		}

		if (!$this->fun->filemode($upfile_dir)) {
			exit($this->lng['filemanage_mode_err']);
		}
		$loadurlDIR = $CONLIST['fileadminlist']['loadurl'] . '&filedir=' . $fileDir;

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

		$files = @glob($upfile_dir . "{*.*}", GLOB_BRACE);

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
					$filearray_temp['fid'] = md5($upfile_dir . $dir['basename']);
					$filearray_temp['loadurl'] = $loadurl;

					$filearray_temp['filename'] = $dir['basename'];
					$filearray_temp['basename'] = $dir['basename'];

					$filearray_temp['path'] = $dir['dirname'];

					$filearray_temp['type'] = 'dir';

					$filearray_temp['bottype'] = 'dir';
				} else {



					$filearray_temp['fid'] = md5($upfile_dir . $mime['basename']);
					$filearray_temp['filename'] = $mime['filename'];
					$filearray_temp['basename'] = $mime['basename'];

					$filearray_temp['path'] = $mime['dirname'];
					$filearray_temp['url'] = admin_URL . $this->CON['upfile_dir'] . $dirlist . $mime['basename'];

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
		$this->ectemplates->assign('url', admin_URL . $this->CON['upfile_dir'] . $dirlist);
		$this->ectemplates->assign('loadurl', $loadurlDIR);
		$this->ectemplates->display('file/file_list');
	}

	function onrenamedir() {
		parent::start_template();

		$dir = $this->fun->accept('dir', 'R');

		$filename = $this->fun->accept('filename', 'R');

		$type = $this->fun->accept('type', 'R');
		$this->ectemplates->assign("dir", $dir);
		$this->ectemplates->assign("filename", $filename);
		$this->ectemplates->assign("type", $type);
		$this->ectemplates->display("file/file_rename");
	}

	function onrenamesave() {

		$dirlist = $this->fun->accept('dir', 'P');
		$filename = $this->fun->accept('filename', 'P');
		$type = $this->fun->accept('type', 'P');

		$upfile_dir = admin_ROOT . $this->CON['upfile_dir'];

		if (!empty($dirlist)) {
			$upfile_dir = $upfile_dir . $dirlist;
		}

		$newfilename = $this->fun->accept('newfilename', 'P');
		$oldfile = @realpath($upfile_dir . $filename);
		$newfile = $type == 'dir' ? $upfile_dir . $newfilename : $upfile_dir . $newfilename . '.' . $type;

		if (stristr($filename, ".php")) {
			exit('false');
		}
		if (!@rename($oldfile, $newfile)) {
			exit('false');
		} else {
			exit('true');
		}
	}

	function onmkdir() {
		parent::start_template();
		$path = $this->fun->accept('path', 'R');
		$pathname = '/' . $path;
		$this->ectemplates->assign("path", $path);
		$this->ectemplates->assign("pathname", $pathname);
		$this->ectemplates->display("file/file_mkdir");
	}

	function onmadirsave() {

		$dirname = $this->fun->accept('dirname', 'P');

		$dirlist = $this->fun->accept('path', 'P');

		$filedir = admin_ROOT . $this->CON['upfile_dir'];

		if (!empty($dirlist)) {
			$filedir = $filedir . $dirlist;
		}

		if (!$this->fun->filemode($filedir)) {
			exit($filedir);
		}
		$file = $filedir . $dirname;
		if (is_dir($file)) {
			exit('false');
		} else {
			@mkdir($file, 0777);
			exit('true');
		}
	}

	function ondelfile() {
		parent::start_template();

		$dirlist = $this->fun->accept('path', 'P');

		$filedir = admin_ROOT . $this->CON['upfile_dir'];

		if (!empty($dirlist)) {
			$filedir = $filedir . $dirlist;
		}

		if (!$this->fun->filemode($filedir)) {
			exit('false');
		}


		$files = @glob($filedir . '*', GLOB_MARK);
		$filenum = count($files);

		$filelist = array();
		foreach ($files as $key => $file) {

			$keyname = pathinfo($file, PATHINFO_BASENAME);

			$filelist[$keyname] = $file;
		}
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = explode(',', $selectinfoid);

		array_pop($selectinfoid);
		foreach ($selectinfoid as $key => $value) {
			$filename = $filelist[$value];
			$this->fun->delfile($filename);
		}
		exit('true');
	}

	function onimagecrop() {
		parent::start_template();

		$dirlist = $this->fun->accept('dir', 'R');

		$upfile_dir = admin_ROOT . $this->CON['upfile_dir'];

		if (!empty($dirlist)) {
			$upfile_dir = $upfile_dir . $dirlist;
		}
		$imgname = $this->fun->accept('filename', 'R');

		$type = $this->fun->accept('type', 'R');

		$imgpath = @realpath($upfile_dir . $imgname);
		if (!$imgpath) {
			$this->calldialogmessage($this->lng['filemanage_file_picerrupload'], $this->lng['botton_close']);
		}





		$mime = $this->getMimeType($imgpath);

		$imagesize = @getimagesize($imgpath);
		if (!$imagesize) {
			$this->calldialogmessage($this->lng['filemanage_file_picerrupload'], $this->lng['botton_close']);
		}
		switch ($imagesize[2]) {
			case 1:
				$im = @ImageCreateFromGIF($imgpath);
				$mime['extension'] = 'gif';
				break;
			case 2:
				$im = @ImageCreateFromJPEG($imgpath);
				$mime['extension'] = 'jpg';
				break;
			case 3:
				$im = @ImageCreateFromPNG($imgpath);
				$mime['extension'] = 'png';
				break;
		}
		if (!$im) {
			$this->calldialogmessage($this->lng['filemanage_file_picerrupload'], $this->lng['botton_close']);
		}

		$srcW = $imagesize[0];

		$srcH = $imagesize[1];

		$newfilename = $mime['filename'] . '_imagecrop' . '.' . $mime['extension'];
		$this->ectemplates->assign('url', admin_URL . $this->CON['upfile_dir'] . $dirlist);
		$this->ectemplates->assign("path", $this->CON['upfile_dir'] . $dirlist);
		$this->ectemplates->assign("imgname", $imgname);
		$this->ectemplates->assign("imgpath", $imgpath);
		$this->ectemplates->assign("newfilename", $newfilename);
		$this->ectemplates->assign("srcW", $srcW);
		$this->ectemplates->assign("srcH", $srcH);
		$this->ectemplates->display("file/file_imagecrop");
	}

	function onimgagecut() {
		parent::start_template();
		$path = $this->fun->accept('path', 'P');
		$imgname = $this->fun->accept('imgname', 'P');
		$selecton = $this->fun->accept('selecton', 'P');
		$newimagename = $this->fun->accept('newimagename', 'P');

		$w = $this->fun->accept('w', 'P');

		$h = $this->fun->accept('h', 'P');

		$x = $this->fun->accept('x', 'P');

		$y = $this->fun->accept('y', 'P');
		$imgpath = @realpath(admin_ROOT . $path . $imgname);
		if (!$imgpath) {
			exit('false');
		}
		if ($selecton == 0) {
			$newfiletype = admin_ROOT . $path . $newimagename;
		} else {
			$newfiletype = $imgpath;
		}
		$imagetype = @getimagesize($imgpath);
		if (!$imagetype) {
			exit('false');
		}
		switch ($imagetype[2]) {
			case 1:
				$image = @ImageCreateFromGIF($imgpath);
				break;
			case 2:
				$image = @ImageCreateFromJPEG($imgpath);
				break;
			case 3:
				$image = @ImageCreateFromPNG($imgpath);
				break;
		}

		$image_p = ImageCreateTrueColor($w, $h);

		imagecopyresampled($image_p, $image, 0, 0, $x, $y, $w, $h, $w, $h);
		switch ($imagetype[2]) {
			case 1:

				@imagegif($image_p, $newfiletype);
				break;
			case 2:

				@imagejpeg($image_p, $newfiletype);
				break;
			case 3:

				@imagepng($image_p, $newfiletype);
				break;
		}
		@ImageDestroy($image);
		exit('true');
	}

	function onzoomimage() {
		parent::start_template();
		$path = $this->fun->accept('path', 'R');
		$imgname = $this->fun->accept('imgname', 'R');
		$dstW = $this->fun->accept('dstW', 'R');
		$dstH = $this->fun->accept('dstH', 'R');

		$imgpath = @realpath(admin_ROOT . $path . $imgname);
		if (!$imgpath) {
			exit('false');
		}

		if (!is_writable($imgpath)) {
			exit('false');
		}





		$mime = $this->getMimeType($imgpath);

		$imagesize = @getimagesize($imgpath);
		if (!$imagesize) {
			exit('false');
		}
		switch ($imagesize[2]) {
			case 1:
				$im = @ImageCreateFromGIF($imgpath);
				$mime['extension'] = 'gif';
				break;
			case 2:
				$im = @ImageCreateFromJPEG($imgpath);
				$mime['extension'] = 'jpg';
				break;
			case 3:
				$im = @ImageCreateFromPNG($imgpath);
				$mime['extension'] = 'png';
				break;
		}
		if (!$im) {
			exit('false');
		}

		$srcW = $imagesize[0];

		$srcH = $imagesize[1];

		$dstWH = $dstW / $dstH;

		$srcWH = $srcW / $srcH;

		if ($dstWH <= $srcWH) {
			$ftoW = $dstW;
			$ftoH = $ftoW * ($srcH / $srcW);
		} else {
			$ftoH = $dstH;
			$ftoW = $ftoH * ($srcW / $srcH);
		}

		$url = admin_URL . $path;
		$newimgpath = $url . $imgname;

		$img_quality = intval($this->CON['img_quality']);

		if ($srcW > $dstW || $srcH > $dstH) {

			if (function_exists('imagecreatetruecolor')) {

				$ni = ImageCreateTrueColor($ftoW, $ftoH);

				ImageCopyResampled($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
			} else {
				$ni = ImageCreate($ftoW, $ftoH);

				ImageCopyResized($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
			}
			switch ($mime['extension']) {
				case 'gif':

					@imagegif($ni, $imgpath);
					break;
				case 'jpg':

					@imagejpeg($ni, $imgpath, $img_quality);
					break;
				case 'png':

					@imagepng($ni, $imgpath);
					break;
			}

			$upresultid = '<span id="imagelist"><img id="cropbox" width="' . $ftoW . '" height="' . $ftoH . '" src="' . $newimgpath . '"></span>';
			ImageDestroy($ni);
		} else {

			$upresultid = '<span id="imagelist"><img id="cropbox" width="' . $dstW . '" height="' . $ftoH . '" src="' . $newimgpath . '"></span>';

			ImageDestroy($im);
		}
		exit($upresultid);
	}

}

?>
