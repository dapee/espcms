<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420

  http://www.ecisp.cn	http://www.easysitepm.com
 */

class seccode {

	var $code;
	var $type = 0;
	var $width = 0;
	var $height = 0;
	var $background = 1;
	var $adulterate = 1;
	var $ttf = 0;
	var $angle = 0;
	var $color = 1;
	var $size = 0;
	var $shadow = 0;
	var $animator = 0;
	var $fontpath = '';
	var $datapath = '';
	var $includepath = '';
	var $bgcolor = '#1C9B1E';
	var $im;

	function seccodeconvert(&$seccode) {
		$s = sprintf('%04s', base_convert($seccode, 10, 20));
		$seccodeunits = 'CEFHKLMNOPQRSTUVWXYZ';
		$seccode = '';
		for ($i = 0; $i < 4; $i++) {
			$unit = ord($s{$i});
			$seccode.= ( $unit >= 0x30 && $unit <= 0x39) ? $seccodeunits[$unit - 0x30] : $seccodeunits[$unit - 0x57];
		}
	}

	function display() {
		$this->type == 2 && !extension_loaded('ming') && $this->type = 0;
		$this->width = $this->width >= 0 && $this->width <= 200 ? $this->width : 150;
		$this->height = $this->height >= 0 && $this->height <= 80 ? $this->height : 60;
		$this->seccodeconvert($this->code);
		$this->image();
	}

	function fileext($filename) {
		return trim(substr(strrchr($filename, '.'), 1, 10));
	}

	function image() {
		$bgcontent = $this->background();
		if ($this->animator == 1 && function_exists('imagegif')) {
			include_once $this->includepath . 'gifmerge.class.php';
			$trueframe = mt_rand(1, 9);
			for ($i = 0; $i <= 9; $i++) {
				$this->im = imagecreatefromstring($bgcontent);
				$x[$i] = $y[$i] = 0;
				$this->adulterate && $this->adulterate();
				if ($i == $trueframe) {
					$this->ttf && function_exists('imagettftext') || $this->type == 1 ? $this->ttffont() : $this->giffont();
					$d[$i] = mt_rand(250, 400);
				} else {
					$this->adulteratefont();
					$d[$i] = mt_rand(5, 15);
				}
				ob_start();
				imagegif($this->im);
				imagedestroy($this->im);
				$frame[$i] = ob_get_contents();
				ob_end_clean();
			}
			$anim = new GifMerge($frame, 255, 255, 255, 0, $d, $x, $y, 'C_MEMORY');
			header('Content-type: image/gif');
			echo $anim->getAnimation();
		} else {
			$this->im = imagecreatefromstring($bgcontent);
			$this->adulterate && $this->adulterate();
			$this->ttf && function_exists('imagettftext') || $this->type == 1 ? $this->ttffont() : $this->giffont();
			if (function_exists('imagepng')) {
				header('Content-type: image/png');
				imagepng($this->im);
			} else {
				header('Content-type: image/jpeg');
				imagejpeg($this->im, '', 100);
			}
			imagedestroy($this->im);
		}
	}

	function background() {
		$this->im = imagecreatetruecolor($this->width, $this->height);
		$backgroundcolor = imagecolorallocate($this->im, 255, 255, 255);
		$backgrounds = $c = array();
		if ($this->background && function_exists('imagecreatefromjpeg') && function_exists('imagecolorat') && function_exists('imagecopymerge') && function_exists('imagesetpixel') && function_exists('imageSX') && function_exists('imageSY')) {
			if ($handle = @opendir($this->datapath . 'background/')) {
				while ($bgfile = @readdir($handle)) {
					if (preg_match('/\.jpg$/i', $bgfile)) {
						$backgrounds[] = $this->datapath . 'background/' . $bgfile;
					}
				}
				@closedir($handle);
			}
			if ($backgrounds) {
				$imwm = imagecreatefromjpeg($backgrounds[array_rand($backgrounds)]);
				$colorindex = imagecolorat($imwm, 0, 0);
				$this->c = imagecolorsforindex($imwm, $colorindex);
				$colorindex = imagecolorat($imwm, 1, 0);
				imagesetpixel($imwm, 0, 0, $colorindex);
				$c[0] = $c['red'];
				$c[1] = $c['green'];
				$c[2] = $c['blue'];
				imagecopymerge($this->im, $imwm, 0, 0, mt_rand(0, 800 - $this->width), mt_rand(0, 80 - $this->height), imageSX($imwm), imageSY($imwm), 100);
				imagedestroy($imwm);
			}
		}
		if (!$this->background || !$backgrounds) {
			for ($i = 0; $i < 3; $i++) {
				$start[$i] = mt_rand(200, 255);
				$end[$i] = mt_rand(100, 250);
				$step[$i] = ($end[$i] - $start[$i]) / $this->width;
				$c[$i] = $start[$i];
			}
			if (empty($this->bgcolor)) $this->bgcolor = "#1C9B1E";
			$bR = hexdec(substr($this->bgcolor, 1, 2));
			$bG = hexdec(substr($this->bgcolor, 3, 2));
			$bB = hexdec(substr($this->bgcolor, 5));
			for ($i = 0; $i < $this->width; $i++) {

				$color = imagecolorallocate($this->im, $bR, $bG, $bB);
				imageline($this->im, $i, 0, $i - $angle, $this->height, $color);
				$c[0]+=$step[0];
				$c[1]+=$step[1];
				$c[2]+=$step[2];
			}
			$c[0]-=20;
			$c[1]-=20;
			$c[2]-=20;
		}
		ob_start();
		if (function_exists('imagepng')) {
			imagepng($this->im);
		} else {
			imagejpeg($this->im, '', 10);
		}
		imagedestroy($this->im);
		$bgcontent = ob_get_contents();
		ob_end_clean();


		if (empty($this->fontcolor)) $this->fontcolor = "#000";
		$bR = hexdec(substr($this->fontcolor, 1, 2));
		$bG = hexdec(substr($this->fontcolor, 3, 2));
		$bB = hexdec(substr($this->fontcolor, 5));
		$this->fontcolor = array($bR, $bG, $bB);
		return $bgcontent;
	}

	function adulterate() {
		$linenums = $this->height / 10;
		for ($i = 0; $i <= $linenums; $i++) {
			$color = $this->color ? imagecolorallocate($this->im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)) : imagecolorallocate($this->im, $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2]);
			$x = mt_rand(0, $this->width);
			$y = mt_rand(0, $this->height);
			if (mt_rand(0, 1)) {
				imagearc($this->im, $x, $y, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, 360), mt_rand(0, 360), $color);
			} else {
				imageline($this->im, $x, $y, $linex + mt_rand(0, $linemaxlong), $liney + mt_rand(0, mt_rand($this->height, $this->width)), $color);
			}
		}
	}

	function adulteratefont() {
		$seccodeunits = 'BCEFGHJKMPQRTVWXY2346789';
		$x = $this->width / 4;
		$y = $this->height / 10;
		$text_color = imagecolorallocate($this->im, $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2]);
		for ($i = 0; $i <= 3; $i++) {
			$adulteratecode = $seccodeunits[mt_rand(0, 23)];
			imagechar($this->im, 5, $x * $i + mt_rand(0, $x - 10), mt_rand($y, $this->height - 10 - $y), $adulteratecode, $text_color);
		}
	}

	function ttffont() {
		$seccode = $this->code;
		$charset = $GLOBALS['charset'];
		$seccoderoot = $this->type ? $this->fontpath . 'ch/' : $this->fontpath . 'en/';
		$dirs = opendir($seccoderoot);
		$seccodettf = array();
		while ($entry = readdir($dirs)) {
			if ($entry != '.' && $entry != '..' && in_array(strtolower($this->fileext($entry)), array('ttf', 'ttc'))) {
				$seccodettf[] = $entry;
			}
		}
		if (empty($seccodettf)) {
			$this->giffont();
			return;
		}
		$seccodelength = 4;
		$widthtotal = 0;
		for ($i = 0; $i < $seccodelength; $i++) {
			$font[$i]['font'] = $seccoderoot . $seccodettf[array_rand($seccodettf)];

			$font[$i]['angle'] = 0;


			$font[$i]['size'] = 13;
			$this->size && $font[$i]['size'] = mt_rand($font[$i]['size'] - $this->width / 60, $font[$i]['size'] + $this->width / 50);
			$box = imagettfbbox($font[$i]['size'], 0, $font[$i]['font'], $seccode[$i]);

			$font[$i]['zheight'] = 15;
			$box = imagettfbbox($font[$i]['size'], $font[$i]['angle'], $font[$i]['font'], $seccode[$i]);

			$font[$i]['height'] = 15;

			$font[$i]['hd'] = 0;

			$font[$i]['width'] = 15;


			$widthtotal+=$font[$i]['width'];
		}
		$x = mt_rand($font[0]['angle'] > 0 ? cos(deg2rad(90 - $font[0]['angle'])) * $font[0]['zheight'] : 1, $this->width - $widthtotal);
		!$this->color && $text_color = imagecolorallocate($this->im, $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2]);
		for ($i = 0; $i < $seccodelength; $i++) {
			if ($this->color) {

				$this->shadow && $text_shadowcolor = imagecolorallocate($this->im, 255 - $this->fontcolor[0], 255 - $this->fontcolor[1], 255 - $this->fontcolor[2]);
				$text_color = imagecolorallocate($this->im, $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2]);
			} elseif ($this->shadow) {
				$text_shadowcolor = imagecolorallocate($this->im, 255 - $this->fontcolor[0], 255 - $this->fontcolor[1], 255 - $this->fontcolor[2]);
			}
			$y = $font[0]['angle'] > 0 ? mt_rand($font[$i]['height'], $this->height) : mt_rand($font[$i]['height'] - $font[$i]['hd'], $this->height - $font[$i]['hd']);
			$this->shadow && imagettftext($this->im, $font[$i]['size'], $font[$i]['angle'], $x + 1, $y + 1, $text_shadowcolor, $font[$i]['font'], $seccode[$i]);
			imagettftext($this->im, $font[$i]['size'], $font[$i]['angle'], $x, $y, $text_color, $font[$i]['font'], $seccode[$i]);
			$x+=$font[$i]['width'];
		}
	}

	function giffont() {
		$seccode = $this->code;
		$seccodedir = array();
		if (function_exists('imagecreatefromgif')) {
			$seccoderoot = $this->datapath;
			$dirs = opendir($seccoderoot);
			while ($dir = readdir($dirs)) {
				if ($dir != '.' && $dir != '..' && file_exists($seccoderoot . $dir . '/seccode.gif')) {
					$seccodedir[] = $dir;
				}
			}
		}
		$widthtotal = 0;
		for ($i = 0; $i <= 3; $i++) {
			$this->imcodefile = $seccodedir ? $seccoderoot . $seccodedir[array_rand($seccodedir)] . '/' . strtolower($seccode[$i]) . '.gif' : '';
			if (!empty($this->imcodefile) && file_exists($this->imcodefile)) {
				$font[$i]['file'] = $this->imcodefile;
				$font[$i]['data'] = getimagesize($this->imcodefile);
				$font[$i]['width'] = $font[$i]['data'][0] + mt_rand(0, 10) - 4;
				$font[$i]['height'] = $font[$i]['data'][1] + mt_rand(0, 10) - 4;
				$font[$i]['width'] += mt_rand(0, $this->width / 5 - $font[$i]['width']);
				$widthtotal += $font[$i]['width'];
			} else {
				$font[$i]['file'] = '';
				$font[$i]['width'] = 8 + mt_rand(0, $this->width / 5 - 5);
				$widthtotal += $font[$i]['width'];
			}
		}
		$x = mt_rand(1, $this->width - $widthtotal);
		for ($i = 0; $i <= 3; $i++) {
			$this->color && $this->fontcolor = array(mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			if ($font[$i]['file']) {
				$this->imcode = imagecreatefromgif($font[$i]['file']);
				if ($this->size) {
					$font[$i]['width'] = mt_rand($font[$i]['width'] - $this->width / 20, $font[$i]['width'] + $this->width / 20);
					$font[$i]['height'] = mt_rand($font[$i]['height'] - $this->width / 20, $font[$i]['height'] + $this->width / 20);
				}
				$y = mt_rand(0, $this->height - $font[$i]['height']);
				if ($this->shadow) {
					$this->imcodeshadow = $this->imcode;
					imagecolorset($this->imcodeshadow, 0, 255 - $this->fontcolor[0], 255 - $this->fontcolor[1], 255 - $this->fontcolor[2]);
					imagecopyresized($this->im, $this->imcodeshadow, $x + 1, $y + 1, 0, 0, $font[$i]['width'], $font[$i]['height'], $font[$i]['data'][0], $font[$i]['data'][1]);
				}
				imagecolorset($this->imcode, 0, $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2]);
				imagecopyresized($this->im, $this->imcode, $x, $y, 0, 0, $font[$i]['width'], $font[$i]['height'], $font[$i]['data'][0], $font[$i]['data'][1]);
			} else {
				$y = mt_rand(0, $this->height - 20);
				if ($this->shadow) {
					$text_shadowcolor = imagecolorallocate($this->im, 255 - $this->fontcolor[0], 255 - $this->fontcolor[1], 255 - $this->fontcolor[2]);
					imagechar($this->im, 5, $x + 1, $y + 1, $seccode[$i], $text_shadowcolor);
				}
				$text_color = imagecolorallocate($this->im, $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2]);
				imagechar($this->im, 5, $x, $y, $seccode[$i], $text_color);
			}
			$x += $font[$i]['width'];
		}
	}

}

?>