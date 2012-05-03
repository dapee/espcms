<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class uploadFile extends connector {

	function upfilebase($TypeW, $TypeH, $smallTypeid = 0, $img_iswater = 0, $path = 'upfile/', $filename = null, $filesize = 0, $filetmpname = 0, $fileerror = null, $filetype = null, $type = 'img', $dirdate = true) {
		include admin_ROOT . adminfile . '/include/admin_language_' . db_lan . '.php';
		include admin_ROOT . 'datacache/command.php';

		$this->lng = $ST;

		$this->CON = $CONFIG;
		if ($type == 'img') {

			$inputtype = $this->CON['upfile_pictype'];
		}
		if ($type == 'file') {

			$inputtype = $this->CON['upfile_filetype'];
		}

		if ($type == 'mover' || $type == 'media') {

			$inputtype = $this->CON['uifile_movertype'];
		}

		$inputfilesize = intval($this->CON['upfile_maxsize']);

		$this->img_quality = intval($this->CON['img_quality']);

		if ($filename != '') {
			if ($fileerror > 0) {
				switch ($this->fileerror) {
					case 1:
						$smfilemessage = $this->lng['download_mess_size_err'];
						break;
					case 2:
						$smfilemessage = $this->lng['download_mess_size_err2'];
						break;
					case 3:
						$smfilemessage = $this->lng['download_mess_size_err3'];
						break;
					case 4:
						$smfilemessage = $filename . $this->lng['download_mess_size_err4'];
						break;
				}
				exit($smfilemessage);
			}
		}

		$path = $dirdate ? $path . date("Y") . '/' . date("m") . '/' . date("d") . '/' : $path;

		if (!is_dir($path)) {
			if (!@mkdir($path, 0777, true)) {
				$smfilemessage = $path . $this->lng['filemanage_js_upfile_no'];
				return $smfilemessage;
			}
		}

		if ($filetmpname != '') {

			$filetype = $this->extendname($filename);

			if (empty($filetype)) {
				$filetype = $this->smfiletypeflag($filetmpname, $filetype);
			}

			if (!$this->typecheck($inputtype, $filetype)) {
				exit($this->lng['download_mess_size_err5']);
			}

			$formatfilename = $this->formatname(0);

			$filename = $formatfilename . '.' . $this->extendname($filename);

			$uploadfile = $path . $filename;


			$type = ($filetype == 'jpg' || $filetype == 'gif' || $filetype == 'png') ? 'img' : 'file';

			if ($img_iswater && $type == 'img') {
				$iswater = $this->waterimg($filetmpname, $uploadfile, $img_iswater);
			} else {
				$iswater = @move_uploaded_file($filetmpname, $uploadfile);
			}

			if ($type == 'img') {
				$iswidth = $this->iswidth($uploadfile);
			} else {
				$iswidth = 3;
			}

			if ($smallTypeid == 1 && $type == 'img') {

				$toImagesFile2 = $formatfilename . '_small.' . $this->extendname($filename);

				$toImagesFile = $path . $toImagesFile2;


				$upresultid = $this->upsmallpic($uploadfile, $TypeW, $TypeH, $toImagesFile);
			}

			if ($iswater) {

				$outfile = $filename . '|' . $toImagesFile2 . '|' . $type . '|' . $path . '|' . $iswidth;
				return $outfile;
			} else {
				return false;
			}
		}
	}

	function iswidth($srcFile) {

		$data = @GetImageSize($srcFile, &$info);
		if (!$data) {
			return 3;
		}

		$srcW = $data[0];

		$srcH = $data[1];
		if ($srcW > $srcH) {
			return 1;
		} else {
			return 2;
		}
	}

	function waterimg($srcFile, $toImagesFile, $img_iswater = 2) {
		if (!$img_iswater) return false;
		switch ($img_iswater) {

			case 1:

				$img_wmt_text = $this->CON['img_wmt_text'];

				$img_wmt_size = $this->CON['img_wmt_size'];

				$img_wmt_color = $this->CON['img_wmt_color'];

				$img_pos = $this->CON['img_wmt_pos'];

				$img_transparent = $this->CON['img_wmt_transparent'];

				$img_wmt_font = admin_ROOT . 'public/fonts/en/FetteSteinschrif.ttf';
				break;

			case 2:

				$img_wmi_file = admin_ROOT . 'public/' . $this->CON['img_wmi_file'];

				$img_pos = $this->CON['img_wmi_pos'];

				$img_transparent = $this->CON['img_wmi_transparent'];
				break;
		}

		$data = GetImageSize($srcFile);
		switch ($data[2]) {
			case 1:
				$im = @ImageCreateFromGIF($srcFile);
				break;
			case 2:
				$im = @ImageCreateFromJPEG($srcFile);
				break;
			case 3:
				$im = @ImageCreateFromPNG($srcFile);
				break;
		}
		if (!$im) return false;

		$srcW = $data[0];

		$srcH = $data[1];

		if ($img_iswater == 2 && file_exists($img_wmi_file)) {
			$water_info = getimagesize($img_wmi_file);

			$water_w = $water_info[0];

			$water_h = $water_info[1];

			switch ($water_info[2]) {
				case 1:
					$water_im = @ImageCreateFromGIF($img_wmi_file);
					break;
				case 2:
					$water_im = @ImageCreateFromJPEG($img_wmi_file);
					break;
				case 3:
					$water_im = @ImageCreateFromPNG($img_wmi_file);
					break;
			}
			if (!$water_im) return false;
			$w = $water_w;
			$h = $water_h;
		}

		if ($img_iswater == 1 && !empty($img_wmt_text)) {
			$wttemp = imagettfbbox($img_wmt_size, 0, $img_wmt_font, $img_wmt_text);

			$w = max($wttemp[2], $wttemp[4]) - min($wttemp[0], $wttemp[6]);
			$h = max($wttemp[1], $wttemp[3]) - min($wttemp[5], $wttemp[7]);
			$ax = min($wttemp[0], $wttemp[6]) * -1;
			$ay = min($wttemp[5], $wttemp[7]) * -1;
			unset($wttemp);
		}

		if (($srcW < $w) || ($srcH < $h)) return false;

		switch ($img_pos) {
			case 0:

				$posX = rand(0, ($srcW - $w));
				$posY = rand(0, ($srcH - $h));
				break;
			case 1:

				$posX = 0;
				$posY = 0;
				break;
			case 2:

				$posX = ($srcW - $w) / 2;
				$posY = 0;
				break;
			case 3:

				$posX = $srcW - $w;
				$posY = 0;
				break;
			case 4:

				$posX = 0;
				$posY = ($srcH - $h) / 2;
				break;
			case 5:

				$posX = ($srcW - $w) / 2;
				$posY = ($srcH - $h) / 2;
				break;
			case 6:

				$posX = $srcW - $w;
				$posY = ($srcH - $h) / 2;
				break;
			case 7:

				$posX = 0;
				$posY = $srcH - $h;
				break;
			case 8:

				$posX = ($srcW - $w) / 2;
				$posY = $srcH - $h;
				break;
			case 9:

				$posX = $srcW - $w;
				$posY = $srcH - $h;
				break;
			default :

				$posX = rand(0, ($srcW - $w));
				$posY = rand(0, ($srcH - $h));
				break;
		}

		if ($img_iswater == 2) {
			imagealphablending($im, true);

			imagecopymerge($im, $water_im, $posX, $posY, 0, 0, $water_w, $water_h, $img_transparent);
		}

		if ($img_iswater == 1) {
			if (!empty($img_wmt_color) && (strlen($img_wmt_color) == 7)) {
				$R = hexdec(substr($img_wmt_color, 1, 2));
				$G = hexdec(substr($img_wmt_color, 3, 2));
				$B = hexdec(substr($img_wmt_color, 5));
			} else {
				$R = 235;
				$G = 15;
				$B = 15;
			}

			imagettftext($im, $img_wmt_size, 0, $posX + $ax, $posY + $ay, imagecolorallocate($im, $R, $G, $B), $img_wmt_font, $img_wmt_text);
		}

		switch ($data[2]) {
			case 1:

				imagegif($im, $toImagesFile);
				break;
			case 2:

				imagejpeg($im, $toImagesFile, $this->img_quality);
				break;
			case 3:

				imagepng($im, $toImagesFile);
				break;
		}

		ImageDestroy($im);
		if (isset($water_im)) imagedestroy($water_im);
		return true;
	}

	function upsmallpic($srcFile, $dstW, $dstH, $toImagesFile) {

		$data = GetImageSize($srcFile, &$info);
		switch ($data[2]) {
			case 1:
				$im = @ImageCreateFromGIF($srcFile);
				break;
			case 2:
				$im = @ImageCreateFromJPEG($srcFile);
				break;
			case 3:
				$im = @ImageCreateFromPNG($srcFile);
				break;
		}

		if (!$im) {
			return false;
		}

		$srcW = $data[0];

		$srcH = $data[1];

		$dstWH = $dstW / $dstH;

		$srcWH = $srcW / $srcH;

		if ($dstWH <= $srcWH) {
			$ftoW = $dstW;
			$ftoH = $ftoW * ($srcH / $srcW);
		} else {
			$ftoH = $dstH;
			$ftoW = $ftoH * ($srcW / $srcH);
		}

		if ($srcW > $dstW || $srcH > $dstH) {

			if (function_exists('imagecreatetruecolor')) {
				$ni = ImageCreateTrueColor($ftoW, $ftoH);
				if ($ni) {
					ImageCopyResampled($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
				} else {
					$ni = ImageCreate($ftoW, $ftoH);
					ImageCopyResized($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
				}
			} else {
				$ni = ImageCreate($ftoW, $ftoH);

				ImageCopyResized($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
			}
			switch ($data[2]) {
				case 1:

					imagegif($ni, $toImagesFile);
					break;
				case 2:

					imagejpeg($ni, $toImagesFile, $this->img_quality);
					break;
				case 3:

					imagepng($ni, $toImagesFile);
					break;
			}

			$upresultid = true;
			ImageDestroy($ni);
		} else {

			$upresultid = false;
		}

		ImageDestroy($im);
		return $upresultid;
	}

	function extendname($filename) {
		$retval = '';
		$pt = strrpos($filename, '.');
		if ($pt) {
			$retval = strtolower(substr($filename, $pt + 1, strlen($filename) - $pt));
		}
		return $retval;
	}

	function formatname($setSavename) {
		if ($setSavename == 1) {
			$string = md5(uniqid(rand() . microtime()));
		}
		if ($setSavename == 0) {

			$string = date('YmdHis') . '_' . rand(100, 999);
		}
		return $string;
	}

	function smfiletypeflag($filetmpname, $filetype) {

		$file = fopen($filetmpname, 'rb');

		$bin = fread($file, 2);
		fclose($file);

		$strInfo = @unpack('c2chars', $bin);

		$typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
		switch ($typeCode) {
			case 7790:
				$filetype = 'exe';
				break;
			case 7784:
				$filetype = 'midi';
				break;
			case 8297:
				$filetype = 'rar';
				break;
			case 8075:
				$filetype = 'zip';
				break;
			case 4838:
				$filetype = 'wma';
				break;
			case 7173:
				$filetype = 'gif';
				break;
			case 3780:
				$filetype = 'pdf';
				break;
			case 58116:
				$filetype = 'bat';
				break;
			case 4951:
				$filetype = 'txt';
				break;
			case 7384:
				$filetype = 'chm';
				break;
			case 6787:
				$filetype = 'swf';
				break;
			default:
		}
		switch ($filetype) {
			case 'image/pjpeg':
				$filetype = 'jpg';
				break;
			case 'image/jpeg':
				$filetype = 'jpg';
				break;
			case 'image/x-png':
				$filetype = 'png';
				break;
			case 'image/png':
				$filetype = 'png';
				break;
			case 'image/gif':
				$filetype = 'gif';
				break;
			case 'image/jpg':
				$filetype = 'jpg';
				break;
			case 'audio/mpeg':
				$filetype = 'mp3';
				break;
			case 'application/vnd.ms-powerpoint':
				$filetype = 'ppt';
				break;
			case 'application/vnd.ms-excel':
				$filetype = 'xls';
				break;
			case 'application/msword':
				$filetype = 'doc';
				break;
			case 'application/octet-stream':
				$filetype = 'doc';
				break;
			case 'text/plain':
				$filetype = 'txt';
				break;
			default:
		}
		return $filetype;
	}

	function typecheck($str_type, $uptype) {
		if (empty($str_type)) return false;
		$allow_type = explode('|', $str_type);
		$newallowType = array();
		foreach ($allow_type as $key => $allow_type) {
			$newallowType[$allow_type] = $allow_type;
		}
		if (array_key_exists($uptype, $newallowType)) {
			return true;
		} else {
			return false;
		}
	}

}

?>