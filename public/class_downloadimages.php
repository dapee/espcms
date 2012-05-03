<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class GetImage {

	var $source;
	var $save_to;
	var $quality;
	var $smalltype = true;
	var $smallwidth = 200;
	var $smallheight = 200;
	var $dirdate = ture;

	function download($method = 'curl') {
		include admin_ROOT . adminfile . '/include/admin_language_' . db_lan . '.php';
		include admin_ROOT . 'datacache/command.php';

		$this->lng = $ST;

		$this->CON = $CONFIG;

		$info = @GetImageSize($this->source);

		if (!$info) {
			return false;
		}

		$path_temp = date("Y") . '/' . date("m") . '/' . date("d") . '/';
		$path = $this->dirdate ? $this->save_to . $path_temp : $this->save_to;

		if (!is_dir($path)) {
			if (!@mkdir($path, 0777, true)) {
				return false;
			}
		}

		$mime = $info['mime'];
		$type = substr(strrchr($mime, '/'), 1);
		switch ($type) {
			case 'jpeg':
				$image_create_func = 'ImageCreateFromJPEG';
				$image_save_func = 'ImageJPEG';
				$new_image_ext = 'jpg';
				$quality = isSet($this->quality) ? $this->quality : 100;
				break;
			case 'png':
				$image_create_func = 'ImageCreateFromPNG';
				$image_save_func = 'ImagePNG';
				$new_image_ext = 'png';
				$quality = isSet($this->quality) ? $this->quality : 0;
				break;
			case 'bmp':
				$image_create_func = 'ImageCreateFromBMP';
				$image_save_func = 'ImageBMP';
				$new_image_ext = 'bmp';
				break;
			case 'gif':
				$image_create_func = 'ImageCreateFromGIF';
				$image_save_func = 'ImageGIF';
				$new_image_ext = 'gif';
				break;
			case 'vnd.wap.wbmp':
				$image_create_func = 'ImageCreateFromWBMP';
				$image_save_func = 'ImageWBMP';
				$new_image_ext = 'bmp';
				break;
			case 'xbm':
				$image_create_func = 'ImageCreateFromXBM';
				$image_save_func = 'ImageXBM';
				$new_image_ext = 'xbm';
				break;
			default:
				$image_create_func = 'ImageCreateFromJPEG';
				$image_save_func = 'ImageJPEG';
				$new_image_ext = 'jpg';
		}
		if (isset($this->set_extension)) {
			$ext = strrchr($this->source, ".");
			$strlen = strlen($ext);

			$new_name = basename(substr($this->source, 0, -$strlen)) . '.' . $new_image_ext;
		} else {

			$new_name = basename($this->source);
		}
		if (empty($new_name)) return false;

		$filenewname = $this->formatname(0);
		if (!$filenewname) return false;

		$save_to = $path . $filenewname . "." . $new_image_ext;

		$img_info['name'] = basename($this->source);
		$img_info['type'] = $mime;
		$img_info['size'] = 1000;
		$img_info['filename'] = $filenewname . "." . $new_image_ext;
		$img_info['filepath'] = $path_temp;
		$img_info['error'] = 0;
		if ($method == 'curl') {

			$save_image = $this->LoadImageCURL($save_to);
		} elseif ($method == 'gd') {

			$img = $image_create_func($this->source);
			if (isSet($quality)) {
				$save_image = $image_save_func($img, $save_to, $quality);
			} else {
				$save_image = $image_save_func($img, $save_to);
			}
		}

		if ($this->smalltype) {

			$upresultid = $this->upsmallpic($save_to, $this->smallwidth, $this->smallheight, $save_to);
		}
		return $img_info;
	}

	function LoadImageCURL($save_to) {
		$ch = curl_init($this->source);
		$fp = fopen($save_to, "wb");
		$options = array(CURLOPT_FILE => $fp,
		    CURLOPT_HEADER => 0,
		    CURLOPT_FOLLOWLOCATION => 1,
		    CURLOPT_TIMEOUT => 60);
		curl_setopt_array($ch, $options);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}

	function upsmallpic($srcFile, $dstW, $dstH, $toImagesFile) {

		$data = @GetImageSize($srcFile, &$info);
		if (!$data) {
			return false;
		}
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

		$srcW = ImageSX($im);

		$srcH = ImageSY($im);

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
				@$ni = ImageCreateTrueColor($ftoW, $ftoH);

				$bgcolor = ImageColorAllocate($ni, 255, 255, 255);
				imagefilledrectangle($ni, 0, 0, $ftoW, $ftoH, $bgcolor);
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
			if (function_exists('imagejpeg')) {
				ImageJpeg($ni, $toImagesFile, 85);
			} else {
				ImagePNG($ni, $toImagesFile, 85);
			}

			$upresultid = 1;
			ImageDestroy($ni);
		} else {

			$upresultid = 0;
		}

		ImageDestroy($im);
		return $upresultid;
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

}

?>
