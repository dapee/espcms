<?php
class Ectemplates_dbcache {

	public $cachefile = 'cache/';
	public $cachetime = 60;
	public $cachefiletype = 'php';

	function Ectemplates_dbcache($cachefile = 'cache/', $cachetime = 60, $cachefiletype = 'php') {
		$this->cachefile = $cachefile;
		$this->cachetime = $cachetime;
		$this->cachefiletype = $cachefiletype;
	}

	function cachefilewrite($fileName, $content, $type = "wb+") {
		$fileName = $this->cachefile . $fileName . '.' . $this->cachefiletype;
		if (!file_exists($this->cachefile)) {
			mkdir($this->cachefile);
		}
		$fd = fopen($fileName, $type);
		if ($fd) {
			fwrite($fd, $content);
			fclose($fd);
			return true;
		} else {
			return false;
		}
	}

	function cachesave($cachefilename, $cachecontent, $renewid = true) {
		if (empty($cachefilename)) trigger_error('File name is not defined', E_USER_ERROR);

		if (is_array($cachecontent)) {
			if (count($cachecontent) == 0) return array();

			$content = var_export($cachecontent, TRUE);
		}else {
			if (empty($content)) return;
			$content = "'" . $cachecontent . "'";
		}

		$filename = $this->cachefile . $cachefilename . '_' . md5($cachefilename) . '.' . $this->cachefiletype;
		if ($renewid || !is_file($filename)) {

			$sConfig = "<?php\n";
			$sConfig = $sConfig . '/*uptime:' . date('Y-m-d H:i:s', time()) . "*/\n";
			$sConfig = $sConfig . '$' . $cachefilename . '=' . $content . ";\n";
			$sConfig = $sConfig . '?' . '>';

			$cachefilename = $cachefilename . '_' . md5($cachefilename);

			$this->cachefilewrite($cachefilename, $sConfig);
		} else {
			include ($filename);
			$cachecontent = $$cachefilename;
		}
		return $cachecontent;
	}

	function checkcache($cachekey) {

		$cachefilename = $this->cachefile . $cachekey . '_' . md5($cachekey) . '.' . $this->cachefiletype;

		$nowtime = strtotime(date('Y-m-d H:i:s', time()));
		if (is_file($cachefilename)) {

			$filetime = filemtime($cachefilename);

			$endtime = $filetime + $this->cachetime;

			$exchchefiletime = $nowtime - $endtime;
			if ($exchchefiletime >= 0) {
				return false;
			} else {
				include ($cachefilename);
				return $$cachekey;
			}
		} else {
			return false;
		}
	}

	function clearcache($cachekey = false) {
		if ($cachekey) {

			$cachefilename = $this->cachefile . $cachekey . '_' . md5($cachekey) . '.' . $this->cachefiletype;
			if (is_file($cachefilename)) {

				unlink($cachefilename);
				return true;
			} else {
				return false;
			}
		} else {
			$cachefilename = $this->cachefile;
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

}

?>