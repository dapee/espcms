<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class gather {

	function request_url() {
		if (isset($_SERVER['REQUEST_URI'])) {
			$uri = $_SERVER['REQUEST_URI'];
		} else {
			if (isset($_SERVER['argv'])) {
				$uri = $_SERVER['PHP_SELF'] . '?' . $_SERVER['argv'][0];
			} else {
				$uri = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
			}
		}
		return $uri;
	}

	function get_php_url() {
		$request_url = $this->request_url();
		if (!empty($request_url)) {
			$scriptName = $request_url;
			$nowurl = $scriptName;
		} else {
			$scriptName = $_SERVER["PHP_SELF"];
			if (empty($_SERVER["QUERY_STRING"])) $nowurl = $scriptName;
			else $nowurl = $scriptName . "?" . $_SERVER["QUERY_STRING"];
		}
		return $nowurl;
	}

	function CearIfram($text) {
		$text = preg_replace("'<script[^\f]*?(\/script>)'si", "", $text); //去掉script代码
		$text = preg_replace("/<iframe(.*?)<\/iframe>/isU", "", $text);
		$text = preg_replace("/style=\"[^\"']*[\"']/i", "", $text);
		$text = preg_replace("/width=\"[^\"']*[\"']/i", "", $text);
		$text = preg_replace("/height=\"[^\"']*[\"']/i", "", $text);
		return $text;
	}

	function GetAlabNum($fnum) {
		$nums = array("０", "１", "２", "３", "４", "５", "６", "７", "８", "９");
		$fnums = "0123456789";
		for ($i = 0; $i <= 9; $i++)
			$fnum = str_replace($nums[$i], $fnums[$i], $fnum);
		$fnum = ereg_replace("[^0-9\.]|^0{1,}", "", $fnum);
		if ($fnum == "") $fnum = 0;
		return $fnum;
	}

	function replacechar($str, $rechar) {

		$reArray = preg_split("/\n/", $rechar);
		foreach ($reArray as $key => $value) {
			$retext = explode('|', $value);
			$rep_left = $retext[0];
			$rep_right = $retext[1];
			$str = str_replace($rep_left, $rep_right, $str);
		}
		return $str;
	}

	function htmldecode($str) {
		if (empty($str)) return;
		if ($str == "") return $str;
		$str = str_replace("&amp;", "&", $str);
		$str = str_replace("&gt;", ">", $str);
		$str = str_replace("&lt;", "<", $str);
		$str = str_replace("select", "select", $str);
		$str = str_replace("join", "join", $str);
		$str = str_replace("union", "union", $str);
		$str = str_replace("where", "where", $str);
		$str = str_replace("insert", "insert", $str);
		$str = str_replace("delete", "delete", $str);
		$str = str_replace("update", "update", $str);
		$str = str_replace("like", "like", $str);
		$str = str_replace("drop", "drop", $str);
		$str = str_replace("create", "create", $str);
		$str = str_replace("modify", "modify", $str);
		$str = str_replace("rename", "rename", $str);
		$str = str_replace("alter", "alter", $str);
		$str = str_replace("ca&#115;", "cast", $str);
		$str = preg_replace("/<span[^>]+>/i", "<span>", $str);
		$str = preg_replace("/<p[^>]+>/i", "<p>", $str);
		$str = preg_replace("/<font[^>]+>/i", "<font>", $str);
		$str = preg_replace("/width=(\'|\")?[\d%]+(\'|\")?/i", "", $str);
		$str = preg_replace("/height=(\'|\")?[\d%]+(\'|\")?/i", "", $str);
		$str = preg_replace("'<style[^\f]*?(\/style>)'si", "", $str);
		return $str;
	}

	function Text2Html($txt) {
		$txt = str_replace("  ", "　", $txt);
		$txt = str_replace("<", "&lt;", $txt);
		$txt = str_replace(">", "&gt;", $txt);
		$txt = preg_replace("/[\r\n]{1,}/isU", "<br/>\r\n", $txt);
		return $txt;
	}

	function ClearHtml($str) {
		$str = str_replace('<', '&lt;', $str);
		$str = str_replace('>', '&gt;', $str);
		return $str;
	}

	function relative_to_absolute($content, $feed_url) {
		preg_match('/(http|https|ftp):\/\//', $feed_url, $protocol);
		$server_url = preg_replace("/(http|https|ftp|news):\/\//", "", $feed_url);
		$server_url = preg_replace("/\/.*/", "", $server_url);
		if ($server_url == '') {
			return $content;
		}
		if (isset($protocol[0])) {
			$new_content = preg_replace('/href="\//', 'href="' . $protocol[0] . $server_url . '/', $content);
			$new_content = preg_replace('/src="\//', 'src="' . $protocol[0] . $server_url . '/', $new_content);
		} else {
			$new_content = $content;
		}
		return $new_content;
	}

	function get_all_url($code, $gatherclass = true) {
		if ($gatherclass) {
			preg_match_all('/<a[\s\S]*?href=["|\']?([^>"\' ]+)["|\']?\s*[^>]*>([^>]+)<\/a>/i', $code, $arr);
		} else {
			preg_match('/<a[\s\S]*?href=["|\']?([^>"\' ]+)["|\']?\s*[^>]*>([^>]+)<\/a>/i', $code, $arr);
		}
		return array('name' => $arr[2], 'url' => $arr[1]);
	}

	function get_all_url_notitle($code, $gatherclass = true) {
		if ($gatherclass) {
			preg_match_all('/<a[\s\S]*?href=["|\']?([^>"\' ]+)["|\']?\s*[^>]*>(.+?)<\/a>/si', $code, $arr);
		} else {
			preg_match('/<a[\s\S]*?href=["|\']?([^>"\' ]+)["|\']?\s*[^>]*>/i', $code, $arr);
		}
		return array('name' => $arr[2], 'url' => $arr[1]);
	}

	function get_out_texturl($urlarray, $outtext) {
		$newurlarray = array();
		for ($i = 0; $i < count($urlarray['url']); $i++) {
			if (stripos('=>' . $urlarray['url'][$i], $outtext)) {
				$newurlarray[] = array('url' => $urlarray['url'][$i], 'name' => trim($urlarray['name'][$i]));
			};
		}
		return $newurlarray;
	}

	function get_tag_data($str, $start, $end) {
		if ($start == '' || $end == '') {
			return;
		}
		$str = explode($start, $str);
		$str = explode($end, $str[1]);
		return $str[0];
	}

	function get_tr_array($table) {
		$table = preg_replace("'<td[^>]*?>'si", '"', $table);
		$table = str_replace("</td>", '",', $table);
		$table = str_replace("</tr>", "{tr}", $table);

		$table = preg_replace("'<[\/\!]*?[^<>]*?>'si", "", $table);

		$table = preg_replace("'([\r\n])[\s]+'", "", $table);
		$table = str_replace(" ", "", $table);
		$table = str_replace(" ", "", $table);

		$table = explode(",{tr}", $table);
		array_pop($table);
		return $table;
	}

	function get_td_array($table, $urlstr = 1, $picstr = 1, $titlestr = 1, $arraydelid = 1) {
		$table = preg_replace("'<table[^>]*?>'si", "", $table);
		$table = preg_replace("'<tr[^>]*?>'si", "", $table);
		$table = preg_replace("'<td[^>]*?>'si", "", $table);
		$table = str_replace("</tr>", "{tr}", $table);
		$table = str_replace("</td>", "{td}", $table);


		$table = explode('{tr}', $table);
		array_pop($table);
		foreach ($table as $key => $tr) {
			preg_match_all($picstr, $tr, $piclist);
			preg_match_all($urlstr, $tr, $urllist);
			preg_match_all($titlestr, $tr, $titlelist);
			$picname = array(picname => $piclist[0][0]); //图片
			$urlname = array(urlname => $urllist[0][0]); //链接
			$titlename = array(titlename => $titlelist[0][0]); //标题
			$tr = preg_replace("'<[\/\!]*?[^<>]*?>'si", "", $tr); //去掉HTML标记
			$td_array[] = array_merge_recursive($picname, $urlname, $titlename);
		}
		if ($arraydelid == 1) {
			array_pop($td_array); //去掉数组中最后一组数据
		}
		return $td_array;
	}

	function get_table_array($table, $urlstr = 1, $picstr = 1, $titlestr = 1, $arraydelid = 1) {
		$table = preg_replace("'<table[^>]*?>'si", "", $table);
		$table = preg_replace("'<tr[^>]*?>'si", "", $table);
		$table = preg_replace("'<td[^>]*?>'si", "", $table);
		$table = str_replace("</table>", "{table}", $table);
		$table = explode('{table}', $table);
		array_pop($table);
		foreach ($table as $key => $tr) {
			$tablearrlist = get_td_array($tr, $urlstr, $picstr, $titlestr, $arraydelid);
			$newstypeid = array(typeid => $key);
			$table_array[] = array_merge_recursive($tablearrlist, $newstypeid);
		}
		return $table_array;
	}

	function split_en_str($str, $distinct = true) {
		preg_match_all('/([a-zA-Z]+)/', $str, $match);
		if ($distinct == true) {
			$match[1] = array_unique($match[1]);
		}
		sort($match[1]);
		return $match[1];
	}

	function replaceContent($content, $urlname) {
		$srcname = 'src=\'' . $urlname;
		$srcname2 = 'background="' . $urlname;
		$srcname3 = 'src="' . $urlname;
		$contentall = str_replace('src=\'', $srcname, $content);
		$contentall = str_replace('background="', $srcname2, $contentall);
		$contentall = str_replace('src="', $srcname3, $contentall);
		return $contentall;
	}

	function get_domain($url) {
		$pattern = "/[\w-]+\.(com|net|org|gov|cc|biz|info|cn)(\.(cn|hk))*/";
		preg_match($pattern, $url, $matches);
		if (count($matches) > 0) {
			return $matches[0];
		} else {
			$rs = parse_url($url);
			$main_url = $rs["host"];
			if (!strcmp(long2ip(sprintf("%u", ip2long($main_url))), $main_url)) {
				return $main_url;
			} else {
				$arr = explode(".", $main_url);
				$count = count($arr);
				$endArr = array("com", "net", "org", "3322"); //com.cn  net.cn 等情况
				if (in_array($arr[$count - 2], $endArr)) {
					$domain = $arr[$count - 3] . "." . $arr[$count - 2] . "." . $arr[$count - 1];
				} else {
					$domain = $arr[$count - 2] . "." . $arr[$count - 1];
				}
				return $domain;
			}
		}
	}

	function get_httpdomain($url) {
		$pattern = "/[\w-.]+\.(com|net|org|gov|cc|biz|info|cn)(\.(cn|hk))*/";
		preg_match($pattern, $url, $matches);
		if (count($matches) > 0) {
			return $matches[0];
		} else {
			$rs = parse_url($url);
			$main_url = $rs["host"];
			if (!strcmp(long2ip(sprintf("%u", ip2long($main_url))), $main_url)) {
				return $main_url;
			} else {
				$arr = explode(".", $main_url);
				$count = count($arr);
				$endArr = array("com", "net", "org", "3322"); //com.cn  net.cn 等情况
				if (in_array($arr[$count - 2], $endArr)) {
					$domain = $arr[$count - 3] . "." . $arr[$count - 2] . "." . $arr[$count - 1];
				} else {
					$domain = $arr[$count - 2] . "." . $arr[$count - 1];
				}
				return $domain;
			}
		}
	}

	function cevin_http_open($url) {
		$opts = array('http' => array('method' => "GET", 'timeout' => 60,));
		$context = stream_context_create($opts);
		$file = file_get_contents($url, false, $context);
		if ($file) {
			return $file;
		} else {
			return false;
		}
	}

	function openfile($url, $conf = array()) {
		if (!function_exists('curl_init') or !is_array($conf)) return FALSE;
		$post = '';
		$purl = parse_url($url);
		$arr = array('post' => FALSE, 'return' => TRUE, 'cookie' => 'cookie.txt',);  //定义POST－COOKIE文件
		$arr = array_merge($arr, $conf);
		$ch = curl_init();
		if ($purl['scheme'] == 'https') {
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		}
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);



		curl_setopt($ch, CURLOPT_URL, $url);


		/*

		  curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);

		  curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);

		  curl_setopt($ch, CURLOPT_PROXY, "122.224.72.11");

		  curl_setopt($ch, CURLOPT_PROXYPORT, 2009);

		  curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
		  curl_setopt($ch, CURLOPT_URL, $url);
		 */
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, $arr['return']);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $arr['cookie']);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $arr['cookie']);
		if ($arr['post'] != FALSE) {
			curl_setopt($ch, CURL_POST, TRUE);
			if (is_array($arr['post'])) {
				$post = http_build_query($arr['post']);
			} else {
				$post = $arr['post'];
			}
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		$result = curl_exec($ch);


		curl_close($ch);
		return $result;
	}

	function get_page_content($url) {
		$url = eregi_replace('^http://', '', $url);
		$temp = explode('/', $url);
		$host = array_shift($temp);
		$path = '/' . implode('/', $temp);
		$temp = explode(':', $host);
		$host = $temp[0];
		$port = isset($temp[1]) ? $temp[1] : 80;
		$fp = @fsockopen($host, $port, &$errno, &$errstr, 30);
		if ($fp) {
			@fputs($fp, "GET $path HTTP/1.1\r\nHost: $host\r\nAccept: */*\r\nReferer:$url\r\nUser-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)\r\nConnection: Close\r\n\r\n");
		}
		$Content = '';
		while ($str = @fread($fp, 4096)) {
			$Content .= $str;
		}
		@fclose($fp);

		if (preg_match("/^HTTP\/\d.\d 301 Moved Permanently/is", $Content)) {
			if (preg_match("/Location:(.*?)\r\n/is", $Content, $murl)) {
				return get_page_content($murl[1]);
			}
		}

		if (preg_match("/^HTTP\/\d.\d 200 OK/is", $Content)) {
			preg_match("/Content-Type:(.*?)\r\n/is", $Content, $murl);
			$contentType = trim($murl[1]);
			$Content = explode("\r\n\r\n", $Content, 2);
			$Content = $Content[1];
		}
		return $Content;
	}

	function filedbwrite($filename, $conentlist) {
		$textfilename = $filename;  //指定数据写入的文件名
		$fp = fopen($textfilename, 'w+'); //打开文件
		fwrite($fp, $conentlist);  //读取文件内容
		fclose($fp);
	}

	function dbinspection($urlfilename, $jsclass = true) {
		$conentlist = $this->openfile($urlfilename);  //打开目标网址
		if (!$conentlist) {
			return false;
		}
		if ($jsclass) {
			$conentlist = preg_replace("'<script[^\f]*?(\/script>)'si", "", $conentlist); //去掉script代码
		}
		return $conentlist;
	}

	function getContent($sourceStr, $startStr, $endStart, $echoid = true) {
		if (!$echoid) {
			$s = preg_quote($startStr);
			$e = preg_quote($endStart);
		} else {
			$s = $startStr;
			$e = $endStart;
		}




		$s = str_replace(" ", "[\s]", $s);
		$e = str_replace(" ", "[\s]", $e);
		$s = str_replace("\r\n", "[\s]", $s);
		$e = str_replace("\r\n", "[\s]", $e);





		preg_match("@" . $s . "(.*?)" . $e . "@is", $sourceStr, $tpl);
		$content = $tpl[1];

		return $content;
	}

	function getContentall($sourceStr, $startStr, $endStart, $echoid = true) {
		if (!$echoid) {
			$s = preg_quote($startStr);
			$e = preg_quote($endStart);
		} else {
			$s = $startStr;
			$e = $endStart;
		}
		$s = str_replace(" ", "[\s]", $s);
		$e = str_replace(" ", "[\s]", $e);
		$s = str_replace("\r\n", "[\s]", $s);
		$e = str_replace("\r\n", "[\s]", $e);




		preg_match_all("@" . $s . "(.*?)" . $e . "@is", $sourceStr, $tpl);
		$content = $tpl[1];
		return $content;
	}

	function imageList($message) {
		$reg = "/<img[^>]*\s+src\s*=\s*(\'|\")*\s*([^\'\"\s]*)\s*(\'|\")*[^>]*>/is";
		preg_match_all($reg, $message, $img_array, PREG_PATTERN_ORDER);
		$img_array = array_unique($img_array[2]);
		return $img_array;
	}

	function pathurl($urlfilename, $bookurl) {

		if (strcasecmp(substr($bookurl, 0, 4), 'http') == 0) {
			return $bookurl;
		}
		$urlfilename = parse_url($urlfilename); //提取URL中的PATH;
		$urlfilename['path'] = preg_replace("/(\w)+\.(\w)+/is", "", $urlfilename['path']); //去掉后面的文件名
		$netpathArray = $this->urlnewarray($urlfilename['path']);
		$nowbookurl = explode('../', $bookurl);
		foreach ($nowbookurl as $key => $variable) {
			if (!empty($variable)) $betbookarray = $variable;  //提取URL文件路径地址
		}
		if (count($nowbookurl) > 1) {
			$k = 0; //计算上一层目录的个数
			foreach ($nowbookurl as $key => $variable) {
				if (empty($variable)) $k++;
			}
			$forsum = count($netpathArray) - $k;
			for ($i = 0; $i < $forsum; $i++) {
				$newurl.=$netpathArray[$i] . '/';
			}
			$nowbookurl = 'http://' . $urlfilename['host'] . '/' . $newurl . $betbookarray; //补全网址
		} else {

			if (substr($bookurl, 0, 1) == '/') {
				$nowbookurl = 'http://' . $urlfilename['host'] . $bookurl;
			} else {
				$bookurl = str_replace('./', '/', $bookurl);
				$nowbookurl = 'http://' . $urlfilename['host'] . $urlfilename['path'] . $bookurl;
			}
		}
		return $nowbookurl;
	}

	function urlnewarray($urlfilename) {
		$neturl = explode('/', $urlfilename);
		foreach ($neturl as $key => $variable) {
			if (!empty($variable)) $newarray[] = $variable;
		}
		return $newarray;
	}

}

?>
