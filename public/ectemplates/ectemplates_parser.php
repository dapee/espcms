<?php
class EctemplatesParser {

	private $template;
	private $gethash = '214adb21252b0af7b03s214s9';
	private $gethashtable = '60af7b03s21fs';
	private $findhash = 'bbb4912cd04e6fd3';
	private $_listechash = '6623ef97c6f6ccf2fb032e800d2edda9';

	public function compile($file_name, $tpl_dir, $tpl_c_dir, $cache_dir, $templatesDIR, $cache_time, $caching, $left_delimiter, $right_delimiter, $echash) {
		$this->tpl_file_name = $file_name;
		$this->tpl_dir = $tpl_dir;
		$this->tpl_c_dir = $tpl_c_dir;
		$this->cache_dir = $cache_dir;
		$this->templatesDIR = $templatesDIR;
		$this->cache_time = $cache_time;

		$this->echash = $echash;

		$this->includeechash = "826870a379354a6b252b0af7b0331b7f";

		$this->linkechash = "885BA145EFC8431D34F5CC06D142F143";
		$this->caching = $caching;

		$this->left_delimiter = preg_quote($left_delimiter);

		$this->right_delimiter = preg_quote($right_delimiter);

		$this->set_file($file_name);

		$this->_parse_common();

		$this->_parse_var();

		$this->_parse_dblist();

		$this->_parse_for();

		$this->_parse_if();

		$this->_parse_fun();

		$this->_parse_link();

		$this->_parse_include();

		$this->_parse_find();

		$this->_parse_beark();

		$this->_parse_class();

		$this->_parse_get();

		$this->_parse_list();

		$this->_parse_echo();

		$tpl_c_file = $this->tpl_c_dir . md5($file_name) . '.php';

		$fp = fopen($tpl_c_file, 'w');
		fwrite($fp, $this->template);
		fclose($fp);
	}

	private function set_file($file) {
		$errfile = $file;
		$file = $this->tpl_dir . $file;
		if (!file_exists($file)) {
			exit('错误：(' . $errfile . ')模板文件不存在');
		}
		$fp = fopen($file, 'r');
		if (!$fp) exit('错误：(' . $errfile . ')不能打开文件');
		if (filesize($file)) {

			$this->template = fread($fp, filesize($file));
		} else {
			exit('错误：(' . $errfile . ')模板文件大小为零');
		}
		fclose($fp);
		return true;
	}

	private function _parse_common() {
		if (preg_match('/' . $this->left_delimiter . '\s*#\s*' . $this->right_delimiter . '/', $this->template)) {
			$patten = '/' . $this->left_delimiter . '\s*#\s*' . $this->right_delimiter . '\s*([^' . $this->left_delimiter . ']*)\s*' . $this->left_delimiter . '\s*#\s*' . $this->right_delimiter . '/';
			$this->template = preg_replace($patten, '<?php /* $1 */ ?>', $this->template);
		}
		return true;
	}

	private function _parse_var() {
		if (preg_match('/' . $this->left_delimiter . '\s*\\$[a-zA-Z0-9_]{1,}|$[a-zA-Z0-9_]{1,}\s*\|\s*([a-zA-Z_]+)\[([^]]+)\]\s*' . $this->right_delimiter . '/', $this->template)) {

			$patten = '/\$([A-Za-z]+[\w]+)/';
			$this->template = preg_replace($patten, "\$this->_tpl_vars['$1']", $this->template);

			$patten = '/(\$this->_tpl_vars\[\'[\w]+\'\])\.([\w]+)/';
			$this->template = preg_replace($patten, "\$1['$2']", $this->template);
		}
	}

	private function _parse_dblist() {
		if (preg_match('/' . $this->left_delimiter . '\s*dblist\s*from=[0-9a-zA-Z_=\s]+\s*' . $this->right_delimiter . '/', $this->template)) {
			if (preg_match('/' . $this->left_delimiter . '\s*\/dblist\s*' . $this->right_delimiter . '/', $this->template)) {
				preg_match_all('/' . $this->left_delimiter . '\s*dblist\s*(from=[0-9a-zA-Z_=\s]+)\s*' . $this->right_delimiter . '/', $this->template, $dblistarray);
				for ($i = 0; $i < count($dblistarray[0]); $i++) {
					$tag_args = $dblistarray[0][$i];
					$attrs = $this->_parse_array_tag($tag_args);
					if (empty($attrs['forkey'])) trigger_error('错误：DBLIST语句未设置forkey参数', E_USER_ERROR);
					if (empty($attrs['from'])) trigger_error('错误：DBLIST语句未设置FROM参数', E_USER_ERROR);
					if (!empty($attrs['typeid'])) $where.=' and typeid=' . $attrs['typeid'];
					$orderbyid = ($attrs['label'] == 'hot') ? ' order by pid,hit desc' : ' order by pid,id desc';
					if ($attrs['label'] == 'font') $where.=' and commend=1';
					if ($attrs['label'] == 'pic') $where.=' and homepic=1';
					$limit = !empty($attrs['max']) ? ' limit 0,' . $attrs['max'] : ' limit 0,10';
					$filehowid = ($attrs['max'] > 10) ? $attrs['max'] : 10;
					$filetypeid = (!empty($attrs['typeid'])) ? $attrs['typeid'] : 'all';
					$filelabelid = (!empty($attrs['label'])) ? $attrs['label'] : 'all';
					$dbcachefilename = $attrs['from'] . '_templates_' . $filetypeid . '_' . $filelabelid . '_' . $filehowid;
					$output.="<?php\n \$infodb_array=array();\n";
					$output.="\$infodbcache=array();\n";
					$output.="\$sql=\"select * from xy_" . $attrs['from'] . "_infolist where classid=1" . $where . $orderbyid . $limit . "\";\n";
					$output.="\$infodbcache=\$dbcache->checkcache('" . $dbcachefilename . "');\n";
					$output.="if (!\$infodbcache) {\n";
					$output.="  \$rs = mysql_query(\$sql);\n";
					$output.="  while (\$rsList=mysql_fetch_assoc(\$rs)){\n";
					$output.="      \$infodb_array[]=\$rsList;\n";
					$output.="  }\n";
					$output.="  \$infodbcache=\$dbcache->cachesave('" . $dbcachefilename . "',\$infodb_array);\n";
					$output.="}\n";
					$output.="\$this->_tpl_vars['" . $attrs['forkey'] . "']=\$infodbcache;\n";
					$output.="?>\n";
					$patten_dblist = '/' . $this->left_delimiter . '\s*dblist\s*' . $dblistarray[1][$i] . '\s*' . $this->right_delimiter . '/';
					$end_dblist = '/' . $this->left_delimiter . '\s*\/dblist\s*' . $this->right_delimiter . '/';
					$this->template = preg_replace($patten_dblist, $output, $this->template);
					$this->template = preg_replace($end_dblist, '', $this->template);
					unset($output, $where, $orderbyid, $limit);
				}
			}else {
				trigger_error('错误：语法错误,没有封闭DBLIST条件语句', E_USER_ERROR);
			}
		}
		return true;
	}

	private function _parse_get() {
		if (preg_match('/' . $this->left_delimiter . '\s*get\s*name\s*=\s*[0-9a-zA-Z_]+/', $this->template)) {
			preg_match_all('/' . $this->left_delimiter . '\s*get[^\f]*?\/get' . $this->right_delimiter . '/', $this->template, $getarray);
			foreach ($getarray[0] as $key => $variable) {
				$bearkarray = array();
				preg_match_all('/' . $this->left_delimiter . '\s*get\s*name\s*=\s*([0-9a-zA-Z_]+)\s*(class=\s*([^%]+)|)*\s*' . $this->right_delimiter . '/', $variable, $bearkarray);
				$newbearkText = $this->_parse_array__get($bearkarray, $this->left_delimiter, $this->right_delimiter);

				$getout = str_replace($bearkarray[0][0], $newbearkText, $variable);

				$value_strget = '/' . $this->left_delimiter . '\s*get\s*name\s*=\s*([0-9a-zA-Z_]+)\s*(class=\s*([^%]+)|)' . $this->right_delimiter . '/';
				$value_endget = '/' . $this->left_delimiter . '\s*\/get\s*' . $this->right_delimiter . '/';
				$getout = preg_replace($value_strget, $this->gethash . '$1|$3|' . $this->gethashtable, $getout);
				$getout = preg_replace($value_endget, $this->gethash, $getout);

				$rec_book = '/' . preg_quote($bearkarray[0][0]) . '[^\f]*?' . $this->left_delimiter . '\s*\/get\s*' . $this->right_delimiter . '/';
				$this->template = preg_replace($rec_book, $getout, $this->template);
			}
		}
	}

	private function _parse_list() {
		if (strrchr($this->tpl_file_name, '.') == '.lbi') {
			$this->template = preg_replace('/<meta\shttp-equiv=["|\']Content-Type["|\']\scontent=["|\']text\/html;\scharset=(?:.*?)["|\']>\r?\n?/i', '', $this->template);
		}
		if (preg_match('/' . $this->left_delimiter . '\s*list\s*name\s*=\s*[0-9a-zA-Z_]+/', $this->template)) {
			preg_match_all('/' . $this->left_delimiter . '\s*list\s*name\s*=\s*([0-9a-zA-Z_]+)\s*(file=\s*([0-9a-zA-Z_,]+)|)\s*(class=\s*([^%]+)|)' . $this->right_delimiter . '/', $this->template, $bearkarray);
			foreach ($bearkarray[0] as $key => $variable) {
				if (!empty($bearkarray[5][$key])) {
					$textarray = array($bearkarray[0][$key], $bearkarray[1][$key], $bearkarray[2][$key], $bearkarray[3][$key], $bearkarray[4][$key], $bearkarray[5][$key]);
					$newbearkText = $this->_parse_array__list($textarray, $this->left_delimiter, $this->right_delimiter);
					$this->template = str_replace($variable, $newbearkText, $this->template);
				}
			}
			$value_beark = '/' . $this->left_delimiter . '\s*list\s*name\s*=\s*([0-9a-zA-Z_]+)\s*(file=\s*([0-9a-zA-Z_,]+)|)\s*(class=\s*([^%]+)|)' . $this->right_delimiter . '/';
			$this->template = preg_replace($value_beark, $this->_listechash . '$1|$5|$3|' . $this->_listechash, $this->template);
		}
	}

	private function _parse_for() {
		if (preg_match('/' . $this->left_delimiter . '\s*forlist[^\n]+' . $this->right_delimiter . '/', $this->template)) {
			if (preg_match('/' . $this->left_delimiter . '\s*\/forlist\s*' . $this->right_delimiter . '/', $this->template)) {


				preg_match_all('/\$this->_tpl_vars\[[\w\']+\]\[[\w]+\]\.[\w\[\]\.\\(\)\']+/', $this->template, $valueAt);
				foreach ($valueAt[0] as $key => $variable) {
					$arraylistNew = $this->_parse_value_preg($variable);
					$this->template = preg_replace('/' . preg_quote($variable) . '/', $arraylistNew, $this->template, 1);
				}

				preg_match_all('/' . $this->left_delimiter . '\s*forlist\s*([$\w-\>\=.\s\[\]\']+)\s*' . $this->right_delimiter . '/', $this->template, $forlistarray);
				for ($i = 0; $i < count($forlistarray[0]); $i++) {
					$tag_args = $forlistarray[0][$i];
					$attrs = $this->_parse_array_tag($tag_args);
					if (empty($attrs['key'])) trigger_error('错误：FORLIST语句未设置key参数', E_USER_ERROR);
					if (empty($attrs['from'])) trigger_error('错误：FORLIST语句未设置FROM参数', E_USER_ERROR);

					$value_forlist = '/key=>([\w]*)/';
					$this->template = preg_replace($value_forlist, "$$1+1", $this->template);

					$value_forlist = '/list=>([\w]*)/';
					$this->template = preg_replace($value_forlist, "$$1", $this->template);

					$value_forlist = '/' . $this->left_delimiter . '\s*div=>([\w]+)=([\w]+)\s*' . $this->right_delimiter . '/';
					if (preg_match($value_forlist, $this->template)) {
						if (preg_match('/' . $this->left_delimiter . '\s*\/div=>([\w]+)\s*' . $this->right_delimiter . '/', $this->template)) {
							$this->template = preg_replace($value_forlist, "<?php if(\$divid_$1==$2){ ?>", $this->template);
							$value_forlist = '/' . $this->left_delimiter . '\s*\/div=>([\w]+)\s*' . $this->right_delimiter . '/';
							$this->template = preg_replace($value_forlist, "<?php \$divid_$1=0;}\$divid_$1++;?>", $this->template);
						} else {
							trigger_error('错误：div语句没有封闭', E_USER_ERROR);
						}
					}

					$value_forlist = '/(\$this->_tpl_vars[^=]+)=>([\w]+)/';
					$this->template = preg_replace($value_forlist, "$1[$$2]", $this->template);

					$forlist_max = !empty($attrs['max']) ? $attrs['max'] : "count(" . $attrs['from'] . ")";
					$patten_forlist = $attrs['from'];
					$patten_forlist = '/' . $this->left_delimiter . '\s*forlist\s*' . preg_quote($forlistarray[1][$i]) . '\s*' . $this->right_delimiter . '/';
					$this->template = preg_replace($patten_forlist, "<?php if (count(" . $attrs['from'] . ")>0){\$divid_" . $attrs['key'] . "=1;for(\$" . $attrs['key'] . "=0;\$" . $attrs['key'] . "<" . $forlist_max . "; \$" . $attrs['key'] . "++){?>", $this->template);
				}

				$end_forlist = '/' . $this->left_delimiter . '\s*\/forlist\s*' . $this->right_delimiter . '/';
				$this->template = preg_replace($end_forlist, '<?php }} ?>', $this->template);
			} else {
				trigger_error('错误：语法错误,没有封闭FORLIST条件语句', E_USER_ERROR);
			}
		}
	}

	private function _parse_include() {
		if (preg_match("/" . $this->left_delimiter . "\s*include file=[\'|\"]([^%]+)[\'|\"]\s*" . $this->right_delimiter . "/", $this->template, $file)) {
			if (trim($file[1]) == '') exit('错误：包含文件不能为空');
			$include_patten = '/' . $this->left_delimiter . '\s*include file=[\'|\"]([^%]+)[\'|\"]\s*' . $this->right_delimiter . '/';
			$this->template = preg_replace($include_patten, $this->includeechash . '$1|' . $this->includeechash, $this->template);
		}
		return true;
	}

	private function _parse_link() {
		if (preg_match("/" . $this->left_delimiter . "\s*link\s*file=[\'|\"]([^%]+)[\'|\"]\s*" . $this->right_delimiter . "/", $this->template, $file)) {
			if (trim($file[1]) == '') exit('错误：包含文件不能为空');
			$include_patten = '/' . $this->left_delimiter . '\s*link\s*file=[\'|\"]([^%]+)[\'|\"]\s*' . $this->right_delimiter . '/';
			$this->template = preg_replace($include_patten, $this->linkechash . $this->templatesDIR . '$1|' . $this->linkechash, $this->template);
		}
		return true;
	}

	private function _parse_find() {
		if (preg_match('/' . $this->left_delimiter . '\s*find:[0-9a-zA-Z_]+\s*class=[0-9a-zA-Z_]+\s*out=[0-9a-zA-Z_]+/', $this->template)) {
			$value_beark = '/' . $this->left_delimiter . '\s*find:([0-9a-zA-Z_]+)\s*class=([0-9a-zA-Z_,]+)\s*out=([^%]+)\s*' . $this->right_delimiter . '/';
			$this->template = preg_replace($value_beark, $this->findhash . '$1|$2|$3' . $this->findhash, $this->template);
		}
	}

	private function _parse_beark() {
		if (strrchr($this->tpl_file_name, '.') == '.lbi') {
			$this->template = preg_replace('/<meta\shttp-equiv=["|\']Content-Type["|\']\scontent=["|\']text\/html;\scharset=(?:.*?)["|\']>\r?\n?/i', '', $this->template);
		}
		if (preg_match('/' . $this->left_delimiter . '\s*beark\s*name\s*=\s*[0-9a-zA-Z_]+/', $this->template)) {
			preg_match_all('/' . $this->left_delimiter . '\s*beark\s*name\s*=\s*([0-9a-zA-Z_]+)\s*(filename=\s*([0-9a-zA-Z_,]+)|)\s*(class=\s*([^%]+)|)' . $this->right_delimiter . '/', $this->template, $bearkarray);
			foreach ($bearkarray[0] as $key => $variable) {
				if (!empty($bearkarray[5][$key])) {
					$textarray = array($bearkarray[0][$key], $bearkarray[1][$key], $bearkarray[2][$key], $bearkarray[3][$key], $bearkarray[4][$key], $bearkarray[5][$key]);
					$newbearkText = $this->_parse_array__beark($textarray, $this->left_delimiter, $this->right_delimiter);
					$this->template = str_replace($variable, $newbearkText, $this->template);
				}
			}
			$value_beark = '/' . $this->left_delimiter . '\s*beark\s*name\s*=\s*([0-9a-zA-Z_]+)\s*(filename=\s*([0-9a-zA-Z_,]+)|)\s*(class=\s*([^%]+)|)' . $this->right_delimiter . '/';
			$this->template = preg_replace($value_beark, $this->echash . '$1|$5|$3|' . $this->echash, $this->template);
		}
	}

	private function _parse_class() {
		if (preg_match('/' . $this->left_delimiter . '\s*class\s*=>\s*[^%]+\s*' . $this->right_delimiter . '/', $this->template)) {
			$fun_patten = '/class\s*=>\s*([^\)]+\))/';
			$this->template = preg_replace($fun_patten, "\$this->$1", $this->template);
		}
		return true;
	}

	private function _parse_if() {
		if (preg_match('/' . $this->left_delimiter . '\s*if\s*[^%]+\s*' . $this->right_delimiter . '/', $this->template)) {
			if (preg_match('/' . $this->left_delimiter . '\s*\/if\s*' . $this->right_delimiter . '/', $this->template)) {
				$if_patten = '/' . $this->left_delimiter . '\s*if\s*([^%]+)\s*' . $this->right_delimiter . '/';
				$elseif_patten = '/' . $this->left_delimiter . '\s*elseif\s*([^%]+)\s*' . $this->right_delimiter . '/';
				preg_match_all($if_patten, $this->template, $forlistarray);
				$else_patten = '/' . $this->left_delimiter . '\s*else\s*' . $this->right_delimiter . '/';
				$ef_patten = '/' . $this->left_delimiter . '\s*\/if\s*' . $this->right_delimiter . '/';
				$this->template = preg_replace($if_patten, "<?php if($1){ ?>", $this->template);
				$this->template = preg_replace($elseif_patten, "<?php } elseif($1){ ?>", $this->template);
				$this->template = preg_replace($else_patten, '<?php }else{ ?>', $this->template);
				$this->template = preg_replace($ef_patten, '<?php } ?>', $this->template);
			} else {
				exit('错误：语法错误,没有封闭IF条件语句');
			}
		}
		return true;
	}

	private function _parse_fun() {
		if (preg_match('/\$this->_tpl_vars[\'\w\$\[\]]*\|[^%]*/', $this->template)) {
			$fun_patten = '/(\$this->_tpl_vars[\'\w\$\[\]]*)\|([\w]*)\(([^\)]*)\)/';
			$this->template = preg_replace($fun_patten, "\$this->$2($1,$3)", $this->template);
		}
		if (preg_match('/\$this->_tpl_vars[\'\w\$\[\]]*\|[^%]*/', $this->template)) {
			$fun_patten = '/(\$this->_tpl_vars[\'\w\$\[\]]*)\|([\w]*)/';
			$this->template = preg_replace($fun_patten, "$2($1)", $this->template);
		}
		if (preg_match('/("|\')\s*[^"\']+\s*("|\')\|[^%]*/', $this->template)) {
			$fun_patten = '/(["|\']\s*[^"\']+\s*["|\'])\|([\w]*)\(([^\)]*)\)/';
			$this->template = preg_replace($fun_patten, "\$this->$2($1,$3)", $this->template);
		}

		if (preg_match('/(@this->[a-zA-z0-9]+)(\([^\)]*\))/', $this->template)) {
			$fun_patten = '/@(this->[a-zA-z0-9]+)(\([^\)]*\))/';
			$this->template = preg_replace($fun_patten, "$$1$2", $this->template);
		}
	}

	private function _parse_echo() {
		if (preg_match('/' . $this->left_delimiter . '\s*([^%]+)\s*' . $this->right_delimiter . '/', $this->template)) {
			$echo_patten = '/' . $this->left_delimiter . '\s*([^%]+)\s*' . $this->right_delimiter . '/';
			$this->template = preg_replace($echo_patten, "<?php echo $1 ?>", $this->template);
		}
	}

	private function _parse_array__list($bearkarray, $left_delimiter, $right_delimiter) {
		$classvar = explode(',', $bearkarray[5]);
		$newarray = array();
		foreach ($classvar as $key => $variable) {
			if (strstr($variable, '$this->_tpl_vars')) {
				$echo_patten = '/(\$this->[^\,]+])/';
				$newarray[$key] = preg_replace($echo_patten, "<?php echo $1 ?>", $variable);
			} else {
				$newarray[$key] = $variable;
			}
		}
		$bearkarray[5] = implode(',', $newarray);
		$left_delimiter = str_replace("\\", "", $left_delimiter);
		$right_delimiter = str_replace("\\", "", $right_delimiter);
		if ($bearkarray[5]) {
			$newText = $left_delimiter . "list name=" . $bearkarray[1] . " " . $bearkarray[2] . " class=" . $bearkarray[5] . $right_delimiter;
		} else {
			$newText = $left_delimiter . "list name=" . $bearkarray[1] . " " . $bearkarray[2] . $right_delimiter;
		}
		return $newText;
	}

	private function _parse_array__beark($bearkarray, $left_delimiter, $right_delimiter) {
		$classvar = explode(',', $bearkarray[5]);
		$newarray = array();
		foreach ($classvar as $key => $variable) {
			if (strstr($variable, '$this->_tpl_vars')) {
				$newarray[$key] = "<?php echo " . $variable . " ?>";
			} else {
				$newarray[$key] = $variable;
			}
		}
		$bearkarray[5] = implode(',', $newarray);
		$left_delimiter = str_replace("\\", "", $left_delimiter);
		$right_delimiter = str_replace("\\", "", $right_delimiter);
		$newText = $left_delimiter . "beark name=" . $bearkarray[1] . " " . $bearkarray[2] . " class=" . $bearkarray[5] . $right_delimiter;
		return $newText;
	}

	private function _parse_array__get($bearkarray, $left_delimiter, $right_delimiter) {
		$classvar = explode(',', $bearkarray[3][0]);
		$newarray = array();
		foreach ($classvar as $key => $variable) {
			if (strstr($variable, '$this->_tpl_vars')) {
				$echo_patten = '/(\$this->[^\,]+])/';
				$newarray[$key] = preg_replace($echo_patten, "<?php echo $1 ?>", $variable);
			} else {
				$newarray[$key] = $variable;
			}
		}
		$bearkarray[3][0] = implode(',', $newarray);
		$left_delimiter = str_replace("\\", "", $left_delimiter);
		$right_delimiter = str_replace("\\", "", $right_delimiter);
		if ($bearkarray[3][0]) {
			$newText = $left_delimiter . "get name=" . $bearkarray[1][0] . " class=" . $bearkarray[3][0] . $right_delimiter;
		} else {
			$newText = $left_delimiter . "get name=" . $bearkarray[1][0] . $right_delimiter;
		}
		return $newText;
	}

	private function _parse_array_tag($arraylist) {
		preg_match_all('/\s*([\w]+)\s*=\s*([$\w->\[\]\'\"]+)\s*/', $arraylist, $arg_list);
		for ($i = 0; $i < count($arg_list[1]); $i++) {
			$attrs[$arg_list[1][$i]] = $arg_list[2][$i];
		}
		return $attrs;
	}

	private function _parse_value_preg($value) {


		$arraylist = preg_split("/(\])\./", $value);


		$arraycount = count($arraylist);
		foreach ($arraylist as $key => $variable) {
			if (($key + 1) != $arraycount) {
				if ($key == 0) {
					$variableFind = str_replace('[', '', strrchr($variable, '['));
					$variableText = str_replace('[' . $variableFind, '', $variable);
					$arraylistNew = $variableText . "[$$variableFind]";
				} else {
					$variableFind = str_replace('[', '', strrchr($variable, '['));
					$variableText = str_replace('[' . $variableFind, '', $variable);
					$arraylistNew.="['$variableText'][$$variableFind]";
				}
			} else {

				$variableFun = strrchr($variable, '|');
				$variableText = str_replace($variableFun, '', $variable);
				$arraylistNew.="['$variableText']$variableFun";
			}
		}
		return $arraylistNew;
	}

}

?>