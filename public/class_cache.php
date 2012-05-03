<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class cacheDB {

	public $cachefile = 'dbcache/';
	public $cachetime = 60;
	public $cachefiletype = 'php';
	public $caching = true;

	function cacheDB($cachefile='dbcache/', $cachetime=60, $cachefiletype='php', $caching=true) {
		$this->cachefile = $cachefile;
		$this->cachetime = $cachetime;
		$this->cachefiletype = $cachefiletype;
		$this->caching = $caching;
	}

	function cachefilewrite($fileName, $content, $type="wb+") {
		$fileName = $this->cachefile . $fileName . '.' . $this->cachefiletype;
		if (!is_dir($this->cachefile)) {
			if (!@mkdir($this->cachefile, 0777, true)) return false;;
		}
		$fd = @fopen($fileName, $type);
		if ($fd) {
			@fwrite($fd, $content);
			@fclose($fd);
			return true;
		} else {
			return false;
		}
	}

	function cachesave($cachefilename, $cachecontent, $renewid=true) {
		if (!$this->caching) return false;
		if (empty($cachefilename)) trigger_error('File name is not defined', E_USER_ERROR);

		if (is_array($cachecontent)) {
			if (count($cachecontent) == 0) return false;

			$content = var_export($cachecontent, TRUE);
		}else {
			if (empty($content)) return false;
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

	function checkcache($cachekey, $checkid=true) {
		if (!$this->caching) return false;
		if (empty($cachekey)) return false;

		$cachefilename = $this->cachefile . $cachekey . '_' . md5($cachekey) . '.' . $this->cachefiletype;
		if (is_file($cachefilename)) {
			if ($checkid) {

				$nowtime = time();

				$filetime = filemtime($cachefilename);

				$endtime = $filetime + $this->cachetime;

				$exchchefiletime = $nowtime - $endtime;
			} else {
				$exchchefiletime = -1;
			}
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

	function clearcache($cachekey=false, $cachekeyseach=false) {
		if (!$this->caching) return false;
		if ($cachekey) {
			if (!$cachekeyseach) {

				$cachefilename = $this->cachefile . $cachekey . '_' . md5($cachekey) . '.' . $this->cachefiletype;
				if (is_file($cachefilename)) {

					@unlink($cachefilename);
					return true;
				} else {
					return false;
				}
			} else {


				$cachefilename = $this->cachefile;
				if (file_exists($cachefilename)) {

					$dirname = @opendir($cachefilename);
					while ($val = @readdir($dirname)) {
						if ($val == '.' || $val == '..') continue;

						if (stripos('@#!@@' . $val, $cachekey) == 5) {
							$value = $cachefilename . $val;

							@unlink($value);
						}
					}
					@closedir($dirname);
					return true;
				} else {
					return false;
				}
			}
		} else {

			$cachefilename = $this->cachefile;
			if (file_exists($cachefilename)) {

				$dirname = @opendir($cachefilename);
				while ($val = @readdir($dirname)) {
					if ($val == '.' || $val == '..') continue;
					$value = $cachefilename . $val;
					@unlink($value);
				}
				@closedir($dirname);
				return true;
			}else {
				return false;
			}
		}
	}

}

?>