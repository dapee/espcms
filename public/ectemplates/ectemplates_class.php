<?php
class Ectemplates {

	private $_parser;
	private $_echash = '826dfebd693cd4d9f372d59e23d5a077';
	private $_listechash = '6623ef97c6f6ccf2fb032e800d2edda9';
	private $_includeechash = '826870a379354a6b252b0af7b0331b7f';
	private $_linkechash = '885BA145EFC8431D34F5CC06D142F143';
	private $gethash = '214adb21252b0af7b03s214s9';
	private $gethashtable = '60af7b03s21fs';
	private $findhash = 'bbb4912cd04e6fd3';
	public $lng = null;

	public function Ectemplates($tpl_dir = './templates/', $tpl_c_dir = './templates_c/', $cache_dir = './cache/', $cache_pic = './pic/', $templatesDIR = '', $cache_time = 86400, $caching = true, $left_delimiter = '{', $right_delimiter = '}', $templatesfileex = '.htm', $powerlist = array(), $codesoftsn = null, $codesoftdate = null, $codesoftdb = null) {
		$this->tpl_dir = $tpl_dir;
		$this->tpl_c_dir = $tpl_c_dir;
		$this->cache_dir = $cache_dir;
		$this->cache_time = $cache_time;
		$this->caching = $caching;
		$this->left_delimiter = $left_delimiter;
		$this->right_delimiter = $right_delimiter;
		$this->templatesfileex = $templatesfileex;
		$this->templatesDIR = $templatesDIR;
		$this->cache_pic = $cache_pic;
		$this->esp_powerlist = $powerlist;
		$this->codesoftsn = $codesoftsn;
		$this->codesoftdate = $codesoftdate;
		$this->codesoftdb = $codesoftdb;
	}

	public function assign($var, $value) {

		if (isset($var) && trim($var) != '') {

			$this->_tpl_vars[$var] = $value;
			return true;
		} else {
			exit('Error[1]：Please set the variable name');
		}
	}

	public function assign_class($classname, $value) {
		if (isset($classname) && trim($classname) != '') {

			$this->$classname = new $value();
			return true;
		} else {
			exit('Error[1]：Please set the variable name');
		}
	}

	public function display($tpl_file, $cache_fileID = null, $html = false, $htmFile = null, $lng = 'cn') {
		$this->lng = $lng;

		$tpl_file = $this->templatesDIR . $tpl_file . $this->templatesfileex;

		if (!is_dir($this->tpl_dir) || !is_dir($this->tpl_c_dir)) exit('Error[2]：Please set up correctly TemplateDIR and CacheDIR');

		$template_file = $this->tpl_dir . $tpl_file;

		if (!file_exists($template_file)) {
			exit('Error[3]：Template file does not exist,Path:' . $tpl_file);
		}

		if ($this->caching) {

			if (!is_dir($this->cache_dir)) exit('Error[4]：Please correct cacheDIR settings');
		}else {
			
		}



		$out = $this->fetch($tpl_file, $cache_fileID);

		if (strpos($out, $this->_linkechash)) {

			$includefile = explode($this->_linkechash, $out);
			foreach ($includefile as $key => $val) {
				if (($key % 2) == 1) {
					$val = str_replace('|', '', $val);
					$includefile[$key] = $this->fetch($val);
				}
			}
			$out = implode('', $includefile);
		}

		if (strpos($out, $this->_includeechash)) {

			$includefile = explode($this->_includeechash, $out);
			foreach ($includefile as $key => $val) {
				if (($key % 2) == 1) {
					$val = str_replace('|', '', $val);
					$includefile[$key] = $this->fetch($val);
				}
			}
			$out = implode('', $includefile);
		}





		if (strpos($out, $this->gethash)) {
			$getout = explode($this->gethash, $out);
			foreach ($getout as $key => $val) {
				if (($key % 2) == 1) {
					$getvalue = explode($this->gethashtable, $val);
					list($getval, $tempbreak) = $getvalue;
					$getout[$key] = $this->insert_get_mod($getval, $tempbreak);
				}
			}
			$out = implode('', $getout);
		}

		if (strpos($out, $this->_echash)) {

			$k = explode($this->_echash, $out);
			foreach ($k as $key => $val) {
				if (($key % 2) == 1) {

					$k[$key] = $this->insert_mod($val);
				}
			}
			$out = implode('', $k);

			$out = $this->format_js($out);
		}

		if (strpos($out, $this->_listechash)) {

			$k = explode($this->_listechash, $out);
			foreach ($k as $key => $val) {
				if (($key % 2) == 1) {

					$k[$key] = $this->insert_mod($val);
				}
			}
			$out = implode('', $k);

			$out = $this->format_js($out);
		}

		if (strpos($out, $this->findhash)) {
			$findout = explode($this->findhash, $out);
			foreach ($findout as $key => $val) {
				if (($key % 2) == 1) {
					$filevalue = explode('|', $val);

					list($findmodel, $findclass, $findfiled) = $filevalue;
					$findout[$key] = $this->insert_find_mod($findmodel, $findclass, $findfiled);
				}
			}
			$out = implode('', $findout);
		}

		if ($this->lng == 'big5') {

			$out = $this->protection($out);
			require_once admin_ROOT . 'public/class.Chinese.php';
			$codechange = new Chinese(admin_ROOT . 'public/config/');
			ob_start();
			eval('?' . '>' . trim($out));
			$name = ob_get_contents();
			ob_end_clean();
			$out = $codechange->g2b($name);


			if ($html) {
				ob_start();
				echo $out;
				$content = ob_get_contents();
				ob_end_clean();
				$this->cachefilewrite($htmFile, $content);
			} else {

				echo $out;
			}
		} else {

			$out = $this->protection($out);

			if ($html) {
				ob_start();
				eval('?' . '>' . trim($out));
				$content = ob_get_contents();
				ob_end_clean();
				$this->cachefilewrite($htmFile, $content);
			} else {

				eval('?' . '>' . trim($out));
			}
		}
	}

	function format_js($str) {
		if (preg_match('/<!--js-->/', $str)) {

			preg_match("@<head>(.*?)</head>@is", $str, $head);
			$str_head = $head[1];

			preg_match_all("@<!--js-->(.*?)<!--end_js-->@is", $str, $js);
			$str_js = $js[1];
			if (!empty($str_js) && is_array($str_js)) {
				$str_jscontent = implode('', $str_js);
			}

			$str = preg_replace("/<!--js-->(.*?)<!--end_js-->/is", '', $str);

			$headstr = $str_head . $str_jscontent;
			$patten = '/<head>(.*?)<\/head>/is';
			$str = preg_replace($patten, '<head>' . $headstr . '</head>', $str);
		}
		return $str;
	}

	function insert_mod($name) {

		require_once admin_ROOT . $this->libdir;
		$this->boot = new lib_public();
		ob_start();
		eval('?' . '>' . trim($name));
		$name = ob_get_contents();
		ob_end_clean();

		list($fun, $para, $filename) = explode('|', $name);
		$fun = 'call_' . $fun;
		$para = explode(',', $para);
		if ($this->libdir == 'interface/lib_public.php') {
			if (empty($filename)) {
				return $this->boot->$fun($this->lng, $para);
			} else {
				return $this->boot->$fun($this->lng, $para, $filename);
			}
		} elseif ($this->libdir == 'interface/3gwap_lib_public.php') {
			if (empty($filename)) {
				return $this->boot->$fun($this->lng, $para);
			} else {
				return $this->boot->$fun($this->lng, $para, $filename);
			}
		} else {
			if (empty($filename)) {
				return $this->boot->$fun($para);
			} else {
				return $this->boot->$fun($para, $filename);
			}
		}
	}

	function insert_get_mod($val, $template) {

		require_once admin_ROOT . $this->libdir;
		$this->getboot = new lib_public();

		ob_start();
		eval('?' . '>' . trim($val));
		$val = ob_get_contents();
		ob_end_clean();
		list($fun, $para) = explode('|', $val);
		$fun = 'call_' . $fun;
		$para = explode(',', $para);
		return $this->getboot->$fun($this->lng, $para, null, $template);
	}

	function insert_find_mod($findmodel, $findclass, $findfiled) {

		require_once admin_ROOT . $this->libdir;
		$this->findboot = new lib_public();
		$fun = 'field_' . $findmodel;
		return $this->findboot->$fun($findclass, $findfiled, $this->lng);
	}

	function fetch($tpl_file, $cache_fileID = null, $outHTML = null) {
		if (!empty($outHTML)) {
			$out = $this->gettemprequire($outHTML);
			return $out;
		}
		require_once 'ectemplates_parser.php';

		if ($this->libfile) {
			$tpl_file = $this->templatesDIR . $tpl_file . '.html';
		}

		$template_file = $this->tpl_dir . $tpl_file;

		$parsed_file = $this->tpl_c_dir . md5($tpl_file) . '.php';

		if ($this->caching) {

			if ($this->tempcheckcache($tpl_file, $cache_fileID)) {

				if (!file_exists($parsed_file) || filemtime($parsed_file) < filemtime($template_file)) {
					$this->_parser = new EctemplatesParser();

					$this->_parser->compile($tpl_file, $this->tpl_dir, $this->tpl_c_dir, $this->cache_dir, $this->templatesDIR, $this->cache_time, $this->caching, $this->left_delimiter, $this->right_delimiter, $this->_echash);
				}

				$this->tempcachesave($tpl_file, $cache_fileID);
				$out = $this->template_out;
			} else {
				$out = $this->template_out;
			}
		} else {

			if (!file_exists($parsed_file) || filemtime($parsed_file) < filemtime($template_file)) {
				$this->_parser = new EctemplatesParser();
				$this->_parser->compile($tpl_file, $this->tpl_dir, $this->tpl_c_dir, $this->cache_dir, $this->templatesDIR, $this->cache_time, $this->caching, $this->left_delimiter, $this->right_delimiter, $this->_echash);
			}

			if ($this->libfile) {

				$out = $this->temprequire($parsed_file);
			} else {
				$out = file_get_contents($parsed_file);
			}
		}

		return $out;
	}

	function gettemprequire($outHTML) {
		ob_start();
		eval('?' . '>' . trim($outHTML));
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	function cachefilewrite($fileName, $content, $type = "wb+") {
		$fd = fopen($fileName, $type);
		if ($fd) {
			fwrite($fd, $content);
			fclose($fd);
			return true;
		} else {
			return false;
		}
	}

	function temprequire($filename) {
		ob_start();
		include $filename;
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	function tempcachesave($cache_file, $cache_ID = null, $renewid = true) {
		if (empty($cache_file)) exit('错误：缓存文件不能为空');
		$cache_ID = !empty($cache_ID) ? $cache_ID . '_' : '';

		$parsed_file = $this->tpl_c_dir . md5($cache_file) . '.php';

		$cache_file = $this->cache_dir . $cache_ID . 'cache_' . md5($cache_file) . '.php';
		if ($renewid || !is_file($cache_file)) {

			include_once 'ectemplates_dbcache.php';
			$dbcache = new Ectemplates_dbcache($this->dbcache_dir, $this->cache_time);
			ob_start();

			require $parsed_file;

			$data = ob_get_contents();

			ob_end_clean();

			$this->cachefilewrite($cache_file, $data);
			$this->template_out = $data;
			return false;
		} else {
			$data = file_get_contents($cache_file);
			$this->template_out = $data;
			return false;
		}
		return true;
	}

	function tempcheckcache($cache_file, $cache_ID = null) {

		if (!$this->caching) return true;

		$nowtime = strtotime(date('Y-m-d H:i:s', time()));

		if (!strpos($cache_file, $this->templatesfileex)) {


			$cache_file = $this->templatesDIR . $cache_file . $this->templatesfileex;
		}

		$cache_ID = !empty($cache_ID) ? $cache_ID . '_' : '';


		$cache_file = $this->cache_dir . $cache_ID . 'cache_' . md5($cache_file) . '.php';

		if (is_file($cache_file)) {


			$filetime = filemtime($cache_file);

			$endtime = $filetime + $this->cache_time;

			$exchchefiletime = $nowtime - $endtime;

			if ($exchchefiletime >= 0) {

				return true;
			} else {

				$data = file_get_contents($cache_file);

				$this->template_out = $data;
				return false;
			}
		} else {
			return true;
		}
	}

	function protection($out) {
		$prostr = "14&]W97)E9\"!B>2!%4U!#35,`";
		$outtitle = convert_uudecode($prostr);

		if (!empty($this->codesoftdb) && admin_FROM) {

			$key_array = explode('/', $this->codesoftdb);

			$httplist_array = explode(',', $key_array[0]);
			$softhttp = parse_url(admin_ClassURL);
			$urlhost = str_replace('www.', '', $softhttp['host']);
			if (!is_array($key_array) && !in_array($urlhost, $httplist_array)) {
				preg_match("@<title>(.*?)</title>@is", $out, $title);
				$str_head = $title[1];
				$patten = "@<title>(.*?)</title>@is";
				$out = preg_replace($patten, '<title>' . $str_head . $outtitle . '</title>', $out);
			}
		} elseif (admin_FROM) {





			preg_match("@<title>(.*?)</title>@is", $out, $title);
			$str_head = $title[1];
			$patten = "@<title>(.*?)</title>@is";
			$out = preg_replace($patten, '<title>' . $str_head . $outtitle . '</title>', $out);
		}
		return $out;
	}

	function clearcache($cache_file = null, $cache_ID = null) {
		if ($cache_file) {

			if (!strpos($cache_file, $this->templatesfileex)) {

				$cache_file = $this->templatesDIR . $cache_file . $this->templatesfileex;
			}

			$cache_ID = !empty($cache_ID) ? $cache_ID . '_' : '';

			$cachefilename = $this->cache_dir . $cache_ID . 'cache_' . md5($cache_file) . '.php';

			if (is_file($cachefilename)) {

				unlink($cachefilename);
				return true;
			} else {
				return false;
			}
		} else {

			$cachefilename = $this->cache_dir;
			if (file_exists($cachefilename)) {

				$dirname = opendir($cachefilename);
				while ($val = readdir($dirname)) {
					if ($val == '.' || $val == '..') continue;
					$value = $cachefilename . $val;
					unlink($value);
				}
				closedir($dirname);
				return true;
			}else {
				return false;
			}
		}
	}

	function clearpic() {

		$cachefilename = $this->cache_pic;
		if (file_exists($cachefilename)) {

			$dirname = opendir($cachefilename);

			while ($val = readdir($dirname)) {
				if ($val == '.' || $val == '..') continue;
				$value = $cachefilename . $val;
				unlink($value);
			}

			closedir($dirname);
			return true;
		}else {
			return false;
		}
	}

	function cuthtml($sourcestr, $cutlength = 20, $lenstr = '', $allow = '') {
		$sourcestr = preg_replace('/\n|\r/i', '', $sourcestr);
		$sourcestr = trim($sourcestr);
		$sourcestr = strip_tags($sourcestr, $allow);
		$returnstr = $this->cutstr($sourcestr, $cutlength, $lenstr);
		return $returnstr;
	}

	function utf8_strlen($string = null) {

		preg_match_all("/./us", $string, $match);

		return count($match[0]);
	}

	function cutstr($sourcestr, $cutlength = 20, $lenstr = '', $x3 = 0) {
		global $CFG; // 全局变量保存 x3 的值
		$returnstr = '';
		$cutlength = $cutlength * 2;


		if (preg_match('/<font\s*color=[^>]+/', $sourcestr)) {
			preg_match_all('/(<font\s*color=[^>]+>)([^<]*)(<\/font>)/', $sourcestr, $fonttext);
			$sourcestr = $fonttext[2][0];
		}
		if ($cutlength <= 0 || $cutlength >= strlen($sourcestr)) {
			return $sourcestr;
		}
		$arr = str_split($sourcestr);
		$len = count($arr);
		$w = 0;
		$cutlength *= 10;

		$x1 = 11;   // ASCII
		$x2 = 16;
		$x3 = $x3 === 0 ? ( $CFG['cf3'] > 0 ? $CFG['cf3'] * 10 : $x3 = 21 ) : $x3 * 10;
		$x4 = $x3;

		for ($i = 0; $i < $len; $i++) {
			if ($w >= $cutlength) {
				$e = $lenstr;
				break;
			}
			$c = ord($arr[$i]);
			if ($c <= 127) {
				$w += $x1;
			} elseif ($c >= 192 && $c <= 223) { // 2字节头
				$w += $x2;
				$i += 1;
			} elseif ($c >= 224 && $c <= 239) { // 3字节头
				$w += $x3;
				$i += 2;
			} elseif ($c >= 240 && $c <= 247) { // 4字节头
				$w += $x4;
				$i += 3;
			}
		}
		$returnstr = implode('', array_slice($arr, 0, $i)) . $e;
		$returnstr = $fonttext[1][0] . $returnstr . $fonttext[3][0];
		return $returnstr;
	}

	function powercheck($funtionname = null, $funtionname_ex = null) {
		if (!in_array('all', $this->esp_powerlist) && (!empty($funtionname) || !empty($funtionname_ex))) {
			if (in_array($funtionname, $this->esp_powerlist)) {
				return false;
			}
			if (in_array($funtionname_ex, $this->esp_powerlist)) {
				return false;
			}
		} else {
			if (!in_array('all', $this->esp_powerlist)) {
				return false;
			}
		}
		return true;
	}

	function timeformat($time, $type = 3, $font = '-', $ddstr = 'Y') {

		$time = empty($time) ? time() : ((strstr($time, ':') || strstr($time, '-')) ? strtotime($time) : $time);
		switch ($type) {
			case 1:
				$format = date('H:i:s', $time);
				break;
			case 2:
				$format = date('Y' . $font . 'm' . $font . 'd', $time);
				break;
			case 3:
				$format = date('Y' . $font . 'm' . $font . 'd H:i:s', $time);
				break;
			case 4:
				$format = date('Y' . $font . 'm' . $font . 'd H:i', $time);
				break;
			case 5:
				$format = date('m' . $font . 'd H:i', $time);
				break;
			case 6:
				$format = date('m' . $font . 'd', $time);
				break;
			case 7:
				$format = date('y' . $font . 'm' . $font . 'd', $time);
				break;
			case 8:
				$format = date('y' . $font . 'm' . $font . 'd H:i:s', $time);
				break;
			case 9:
				$format = date('y' . $font . 'm' . $font . 'd H:i', $time);
				break;
			case 10:
				$format = date($ddstr, $time);
				break;
		}
		return $format;
	}

	function format_size($size, $type = 0) {
		if ($size < 1000) {
			$size_BKM = (string) $size . ' B';
		} elseif ($size < (1000 * 1000)) {
			$size_BKM = number_format((double) ($size / 1000), 1) . ' KB';
		} else {
			$size_BKM = number_format((double) ($size / (1000 * 1000)), 1) . ' MB';
		}
		return $size_BKM;
	}

	function fontformatdate($timestamp, $dateformat = 3) {
		if (empty($timestamp)) {

			$timestamp = time();
		}
		$time = time() - $timestamp;
		if ($time > 24 * 3600) {
			$result = $this->timeformat($timestamp, $dateformat);
		} elseif ($time > 3600) {
			$result = intval($time / 3600) . '小时前';
		} elseif ($time > 60) {
			$result = intval($time / 60) . '分前';
		} elseif ($time > 0) {
			$result = $time . '秒前';
		} else {
			$result = '现在';
		}
		return $result;
	}

	function ip($str, $type = 1) {
		if (empty($str)) {
			return false;
		} else {
			if ($type) {
				$ip = ip2long($str);
			} else {
				$ip = long2ip($str);
			}
		}
		return $ip;
	}

	function imp($str, $type = '/') {
		if (empty($str) || !is_array($str)) {
			return false;
		} else {
			$restr = implode($type, $str);
		}
		return $restr;
	}

	function escape($text, $type = 'url') {
		if (empty($text)) {
			return false;
		}
		if ($type == 'url') {
			$result = urlencode($text);
		}
		return $result;
	}

	function htmlcode($text, $type = 'hc') {
		if (!is_array($text)) {
			$text = $type == 'hc' ? htmlspecialchars($text) : htmlspecialchars_decode($text);
		}
		return $text;
	}

	function addslashes($text, $type = 'hc') {
		if (!is_array($text)) {
			$text = $type == 'hc' ? addslashes($text) : stripslashes($text);
		}
		return $text;
	}

	function treelist($text, $fontline = '─') {
		if (empty($text) || $text == 1) {
			return false;
		}
		$result = null;
		for ($i = 0; $i < $text; $i++) {
			$result.=$fontline;
		}
		return $result;
	}

	function zoom($picfile, $dstW = 200, $dstH = 200, $bgcolor = null) {
		if (empty($picfile)) {
			return false;
		}

		include admin_ROOT . 'datacache/command.php';
		require_once 'ectemplates_image.php';
		$bgcolor = empty($bgcolor) || !preg_match("/^#[a-zA-Z0-9]{3,6}$/i", $bgcolor) ? !preg_match("/^#[a-zA-Z0-9]{3,6}$/i", $CONFIG['img_bgcolor']) ? '#ffffff' : $CONFIG['img_bgcolor']  : $bgcolor;

		$nowpicname = $picfile;
		$picfile = admin_ROOT . $picfile;

		$picfile = $this->picpath($picfile);
		if (!file_exists($picfile) && !is_file($picfile)) {
			return false;
		}

		$mime = $this->getMimeType($picfile);

		$newsfilepathname = $this->cache_pic . $dstW . '_' . $dstH . '_' . md5($nowpicname . $bgcolor) . '.' . $mime;
		if (is_file($newsfilepathname)) {

			$newpicname = $this->picpathformat(basename($newsfilepathname));
			return $newpicname;
		}

		$imagescreat = new ectemplates_image();

		$newpicname = $imagescreat->imagecreat($dstW, $dstH, $bgcolor, $picfile, $newsfilepathname);
		return $this->picpathformat($newpicname);
	}

	function picpath($pic = null) {
		if (!empty($pic)) {
			if (stripos($pic, 'http')) {
				return $pic;
			} else {
				return str_replace('../', admin_ROOT . '/', $pic);
			}
		} else {
			return $pic;
		}
	}

	function getMimeType($file) {
		return is_dir($file) ? $file : $this->mime($file);
	}

	public function mime($file) {

		$file = realpath($file);

		$options = pathinfo($file, PATHINFO_EXTENSION);
		return $options;
	}

	function picpathformat($pic = null) {
		if (!empty($pic)) {
			return admin_URL . str_replace(admin_ROOT, '', $this->cache_pic) . $pic;
		} else {
			return $pic;
		}
	}

	function Html2Text($text, $type = 0) {
		if ($type) {
			$text = stripslashes($text);
		}
		$text = htmlspecialchars_decode($text);
		$text = str_replace("\r\n", "\n", $text);
		$text = str_replace("<br/>\n", "\n", $text);
		$text = str_replace("<br/>", "\n", $text);
		return $text;
	}

}

?>