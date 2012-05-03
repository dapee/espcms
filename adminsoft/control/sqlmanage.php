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

	function onsqllist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');
		$loguser = $this->fun->accept('loguser', 'R');

		$counttype = $this->fun->accept('countnum', 'R');

		$page_id = $this->fun->accept('page_id', 'R');
		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}

		$spnum = 0;

		$dbnum = 0;
		$rs = $this->db->query("SHOW TABLE STATUS LIKE '" . $this->db->like_quote(db_prefix) . "%'");
		while ($dbList = $this->db->fetch_assoc($rs)) {

			$dbres = $this->db->getRow('CHECK TABLE ' . $dbList['Name']);

			$spnum+=$dbList['Data_free'];
			$list[] = array(

			    'table' => $dbList['Name'],

			    'type' => $dbList['Engine'],

			    'dbnum' => $dbList['Rows'],

			    'dbsize' => $this->fun->format_size($dbList['Data_length']),

			    'dbchip' => $this->fun->format_size($dbList['Data_free']),

			    'status' => $dbres['Msg_text'],

			    'charset' => $dbList['Collation']
			);
			$dbnum++;
		}
		unset($rs);
		if (!empty($counttype)) {
			exit("$dbnum");
		}

		$outarray = array();

		$endpage = $MinPageid + $MaxPerPage;
		foreach ($list as $key => $value) {

			if (( $key >= $MinPageid ) && ($endpage > $key)) {
				$outarray[] = $value;
			}
			if ($endpage < $key) break;
		}
		unset($list);

		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $outarray);
		$this->ectemplates->display('admin/admin_sql_list');
	}

	function onoptimize() {
		$dbtable = $this->fun->accept('dbtable', 'R');
		if (empty($dbtable)) {
			$rs = $this->db->query("SHOW TABLES LIKE '" . $this->db->like_quote(db_prefix) . "%'");
			while ($dbList = $this->db->fetch_array($rs)) {
				$tables[] = $dbList[0];
				$row = $this->db->getRow('OPTIMIZE TABLE ' . $dbList[0]);
				if ($row) {

					if ($row['Msg_type'] == 'error' && strpos($row['Msg_text'], 'repair') !== false) {
						$this->db->query('REPAIR TABLE ' . $dbList[0]);
					}
				}
			}
			$this->writelog($this->lng['sqllist_optimize_be_log'], $this->lng['log_extra_ok']);
		} else {
			$row = $this->db->getRow('OPTIMIZE TABLE ' . $dbtable);
			if ($row) {

				if ($row['Msg_type'] == 'error' && strpos($row['Msg_text'], 'repair') !== false) {
					$this->db->query('REPAIR TABLE ' . $dbtable);
				}
			}
			$this->writelog($this->lng['sqllist_optimize_log'], $this->lng['log_extra_ok'] . ' table=' . $dbtable);
		}
		exit('true');
	}

	function onexport() {
		parent::start_template();

		$rs = $this->db->query("SHOW TABLE STATUS LIKE '" . $this->db->like_quote(db_prefix) . "%'");
		while ($dbList = $this->db->fetch_assoc($rs)) {

			$dbres = $this->db->getRow('CHECK TABLE ' . $dbList['Name']);

			$spnum+=$dbList['Data_free'];
			$list[] = array(

			    'table' => $dbList['Name'],

			    'type' => $dbList['Engine'],

			    'dbnum' => $dbList['Rows'],

			    'dbsize' => $this->fun->format_size($dbList['Data_length']),

			    'dbchip' => $this->fun->format_size($dbList['Data_free']),

			    'status' => $dbres['Msg_text'],

			    'charset' => $dbList['Collation']
			);
			$dbnum++;
		}
		$upload_max_filesize = intval(@ini_get('upload_max_filesize'));
		$this->ectemplates->assign('maxfilesize', $upload_max_filesize * 1024);
		$this->ectemplates->assign('array', $list);
		$this->ectemplates->display('admin/admin_sql_export');
	}

	function onbakfilelist() {
		parent::start_template();
		$path = admin_ROOT . $this->CON['file_sqlbakdir'];
		$listtype = $this->fun->accept('listtype', 'G');
		$listtype = empty($listtype) ? 'list' : 'del';
		$folder = @opendir($path);
		while ($file = @readdir($folder)) {
			if (strpos($file, '.sql') !== false) {
				$sqlbakfile[] = $file;
			}
		}
		if (is_array($sqlbakfile)) {
			natsort($sqlbakfile);
			$match = array();
			foreach ($sqlbakfile AS $key => $file) {

				if (preg_match('/_([0-9])+\.sql$/', $file, $match)) {
					if ($match[1] == 1) {
						$mark = 1;
					} else {
						$mark = 2;
					}
				} else {
					$mark = 0;
				}

				$filesize = filesize($path . $file);

				$info = $this->get_sqlhead($path . $file);
				if ($key == 0) $info['checked'] = 'checked ';

				$newfile = str_replace('_' . $match[1] . '.sql', '', $file);
				$list[] = array('filename' => $file, 'shortfile' => $newfile, 'checked' => $info['checked'], 'addtime' => $info['date'], 'vol' => $info['vol'], 'filesize' => $this->fun->num_bitunit($filesize), 'mark' => $mark);
			}
		}
		$this->ectemplates->assign('array', $list);
		if ($listtype == 'list') {
			$this->ectemplates->display('admin/admin_sql_filelist');
		} else {
			$this->ectemplates->display('admin/admin_sql_dellist');
		}
	}

	function onsqlbak() {
		$path = admin_ROOT . $this->CON['file_sqlbakdir'];
		if (!$this->fun->filemode($path, 'w')) {
			exit('false');
		}

		@set_time_limit(300);

		$sql_runlogfile = $path . '/run.log';

		$sqlfilename = $this->fun->accept('sqlfilename', 'R');
		$sqlfilename = empty($sqlfilename) ? $this->fun->get_random() : $sqlfilename;
		$tablename = $this->fun->accept('tablename', 'R');
		$baktype = $this->fun->accept('baktype', 'R');

		$upload_max_filesize = intval(@ini_get('upload_max_filesize'));
		$savasize = $this->fun->accept('savasize', 'R');
		$savasize = empty($savasize) ? $upload_max_filesize * 1000 : $savasize;

		$volRun = $this->fun->accept('vol', 'R');
		$vol = empty($volRun) ? 1 : intval($volRun);

		if ($upload_max_filesize > 0 && $savasize > ($upload_max_filesize * 1024)) $savasize = $upload_max_filesize * 1024;

		if ($savasize > 0) $this->outsize = $savasize * 1024;
		$tables = array();
		if (empty($volRun)) {
			$str = '';
			if ($baktype) {
				$rs = $this->db->query("SHOW TABLES LIKE '" . $this->db->like_quote(db_prefix) . "%'");
				while ($dbList = $this->db->fetch_array($rs)) {
					$tables[$dbList[0]] = -1;
				}
				foreach ($tables as $key => $val) {
					$str.= $key . ':' . $val . ";\r\n";
				}
			} else {
				foreach ($tablename as $key => $val) {
					$str.= $val . ":-1;\r\n";
				}
			}

			if (!$this->fun->filewrite($sql_runlogfile, $str)) {
				exit('false');
			}
		}
		$tables = $this->outsqllink($sql_runlogfile, $vol);
		if ($tables === false) exit('false');
		if (empty($tables)) {

			if ($vol > 1) {
				$this->fun->filewrite($path . '/' . $sqlfilename . '_' . $vol . '.sql', $this->makesqlText);
			} else {
				$this->fun->filewrite($path . '/' . $sqlfilename . '_' . $vol . '.sql', $this->makesqlText);
			}
			@unlink($sql_runlogfile);
			$this->writelog($this->lng['sqllist_export_log'], $this->lng['log_extra_ok'] . ' sqlfilename=' . $sqlfilename . ' vol=' . $vol);
			exit('true');
		} else {

			$this->fun->filewrite($path . '/' . $sqlfilename . '_' . $vol . '.sql', $this->makesqlText);
			$lnk = 'index.php?archive=sqlmanage&action=sqlbak&sqlfilename=' . $sqlfilename . '&savasize=' . $savasize . '&vol=' . ($vol + 1);
			$this->writelog($this->lng['sqllist_export_log'], $this->lng['log_extra_ok'] . ' sqlfilename=' . $sqlfilename . ' vol=' . $vol);
			exit($lnk);
		}
	}

	function onsqlimport() {
		$path = admin_ROOT . $this->CON['file_sqlbakdir'];
		$filename = $this->fun->accept('filename', 'P');

		$folder = @opendir($path);
		while ($file = @readdir($folder)) {
			if (strpos($file, $filename) !== false) {

				$sqlfile[] = $file;
			}
		}
		natsort($sqlfile);
		foreach ($sqlfile as $value) {
			$runid = $this->sqlrun($path . $value);
			if (!$runid) exit('false');
		}
		$this->writelog($this->lng['sqllist_import_log'], $this->lng['log_extra_ok'] . ' sqlfilename=' . $filename);
		exit('true');
	}

	function onsqldel() {
		$path = admin_ROOT . $this->CON['file_sqlbakdir'];
		if (empty($path)) {
			exit('false');
		}
		$filename = $this->fun->accept('filename', 'P');
		if (empty($filename)) {
			exit('false');
		}

		$folder = @opendir($path);
		while ($file = @readdir($folder)) {
			if (strpos($file, $filename) !== false) {

				$sqlfile[] = $file;
			}
		}
		natsort($sqlfile);
		foreach ($sqlfile as $value) {
			$filepath = $path . $value;
			$delid = $this->fun->delFile($filepath);
		}
		$this->writelog($this->lng['sqllist_del_log'], $this->lng['log_extra_ok'] . ' sqlfilename=' . $delfilename);
		exit('true');
	}

	function sqlrun($filename) {
		$sqldump = array_filter(file($filename), 'remove_comment');
		$sqldump = str_replace("\r", '', implode('', $sqldump));
		$sqlquery = $this->splitsql($sqldump);
		unset($sqldump);
		foreach ($sqlquery as $sql) {
			$sql = $this->syntablestruct(trim($sql), $this->db->version() > '4.1', db_charset);
			if ($sql != '') {
				$this->db->query($sql, 'SILENT');
				if (($sqlerror = $this->db->error()) && $this->db->errno() != 1062) {
					return false;
				}
			}
		}
		return true;
	}

	function splitsql($sql) {
		$sql = str_replace("\r", "\n", $sql);
		$ret = array();
		$num = 0;
		$queriesarray = explode(";\n", trim($sql));
		unset($sql);
		foreach ($queriesarray as $query) {
			$queries = explode("\n", trim($query));
			foreach ($queries as $query) {
				$ret[$num].=$query[0] == "--" ? NULL : $query;
			}
			$num++;
		}
		return ($ret);
	}

	function syntablestruct($sql, $version, $dbcharset) {
		if (strpos(trim(substr($sql, 0, 18)), 'CREATE TABLE') === FALSE) {
			return $sql;
		}
		$sqlversion = strpos($sql, 'ENGINE=') === FALSE ? FALSE : TRUE;
		if ($sqlversion === $version) {
			return $sqlversion && $dbcharset ? preg_replace(array('/ character set \w+/i', '/ collate \w+/i', "/DEFAULT CHARSET=\w+/is"), array('', '', "DEFAULT CHARSET=$dbcharset"), $sql) : $sql;
		}
		if ($version) {
			return preg_replace(array('/TYPE=HEAP/i', '/TYPE=(\w+)/is'), array("ENGINE=MEMORY DEFAULT CHARSET=$dbcharset", "ENGINE=\\1 DEFAULT CHARSET=$dbcharset"), $sql);
		} else {
			return preg_replace(array('/character set \w+/i', '/collate \w+/i', '/ENGINE=MEMORY/i', '/\s*DEFAULT CHARSET=\w+/is', '/\s*COLLATE=\w+/is', '/ENGINE=(\w+)(.*)/is'), array('', '', 'ENGINE=HEAP', '', '', 'TYPE=\\1\\2'), $sql);
		}
	}

	function outsqllink($sql_runlogfile, $vol) {

		$tables = $this->fun->fileArrayet($sql_runlogfile);
		if ($tables === false) {
			return false;
		}
		if (empty($tables)) {
			return $tables;
		}

		$this->makesqlText = $this->make_sqlhead($vol);
		foreach ($tables as $table => $pos) {

			if ($pos == -1) {

				$table_df = $this->get_createsql($table, true);
				if (strlen($this->makesqlText) + strlen($table_df) > $this->outsize - 32) {
					if ($this->sql_num == 0) {

						$this->makesqlText .= $table_df;
						$this->sql_num +=2;
						$tables[$table] = 0;
					}

					break;
				} else {
					$this->makesqlText .= $table_df;
					$this->sql_num +=2;
					$pos = 0;
				}
			}

			$post_pos = $this->get_insertsql($table, $pos);

			if ($post_pos == -1) {

				unset($tables[$table]);
			} else {

				$tables[$table] = $post_pos;
				break;
			}
		}
		$this->makesqlText.='-- END EasySitePM SQL Dump Program ';
		if (is_array($tables)) {
			$str = '';
			foreach ($tables as $key => $val) {
				$str .= $key . ':' . $val . ";\r\n";
			}
			$this->fun->filewrite($sql_runlogfile, $str);
		}
		return $tables;
	}

	function make_sqlhead($vol) {
		$head = "-- ESPCMS SQL Dump\r\n" .
			"-- version 5.0.0.0\r\n" .
			"-- \r\n" .
			"-- HOST:" . admin_ClassURL . "\r\n" .
			"-- DATE:" . $this->fun->formatdate(time(), 3) . "\r\n" .
			"-- SQLVER:" . $this->db->version() . "\r\n" .
			"-- PHPVER:" . PHP_VERSION . "\r\n" .
			"-- Vol:" . $vol . "\r\n";
		return $head;
	}

	function get_sqlhead($path) {
		/* 获取sql文件头部信息 */
		$sql_info = array('date' => '', 'sqlver' => '', 'phpver' => 0, 'vol' => 0);
		$fp = fopen($path, 'rb');
		$str = fread($fp, 200);
		fclose($fp);
		$arr = explode("\n", $str);
		foreach ($arr AS $val) {
			$pos = strpos($val, ':');
			if ($pos > 0) {
				$type = trim(substr($val, 0, $pos), "-\n\r\t ");
				$value = trim(substr($val, $pos + 1), "/\n\r\t ");
				if ($type == 'DATE') {
					$sql_info['date'] = $value;
				} elseif ($type == 'SQLVER') {
					$sql_info['sqlver'] = $value;
				} elseif ($type == 'PHPVER') {
					$sql_info['phpver'] = $value;
				} elseif ($type == 'Vol') {
					$sql_info['vol'] = $value;
				}
			}
		}
		return $sql_info;
	}

	function get_createsql($table, $add_drop = false) {
		if ($add_drop) {

			$table_df = "DROP TABLE IF EXISTS `$table`;\r\n";
		} else {
			$table_df = '';
		}

		$tmp_arr = $this->db->getRow("SHOW CREATE TABLE `$table`");
		$tmp_sql = $tmp_arr['Create Table'];

		$tmp_sql = substr($tmp_sql, 0, strrpos($tmp_sql, ")") + 1); //去除行尾定义。
		if ($this->db->version() >= '4.1') {
			$table_df.=$tmp_sql . " ENGINE=MyISAM DEFAULT CHARSET=" . str_replace('-', '', db_charset) . ";\r\n";
		} else {
			$table_df.=$tmp_sql . " TYPE=MyISAM;\r\n";
		}
		return $table_df;
	}

	function get_insertsql($table, $pos) {
		$post_pos = $pos;
		$this->offset = 300;

		$total = $this->db->getOne("SELECT COUNT(*) FROM $table");
		if ($total == 0 || $pos >= $total) {

			return -1;
		}

		$cycle_time = ceil(($total - $pos) / $this->offset);

		for ($i = 0; $i < $cycle_time; $i++) {

			$array = array();
			$data = $this->db->getAll("SELECT * FROM $table LIMIT " . ($this->offset * $i + $pos) . ', ' . $this->offset);
			$data_count = count($data);

			$fields = array_keys($data[0]);
			$start_sql = "INSERT INTO `$table` ( `" . implode("`, `", $fields) . "` ) VALUES ";

			for ($j = 0; $j < $data_count; $j++) {

				$record = array_map("dump_escape_string", $data[$j]);

				$record = array_map("dump_null_string", $record);
				$tmp_dump_sql = $start_sql . " ('" . implode("', '", $record) . "');\r\n";

				$tmp_str_pos = strpos($tmp_dump_sql, 'NULL');
				$tmp_dump_sql = empty($tmp_str_pos) ? $tmp_dump_sql : substr($tmp_dump_sql, 0, $tmp_str_pos - 1) . 'NULL' . substr($tmp_dump_sql, $tmp_str_pos + 5);
				if (strlen($this->makesqlText) + strlen($tmp_dump_sql) > $this->outsize - 32) {
					if ($this->sql_num == 0) {

						$this->makesqlText .= $tmp_dump_sql;
						$this->sql_num++;
						$post_pos++;
						if ($post_pos == $total) {

							return -1;
						}
					}
					return $post_pos;
				} else {
					$this->makesqlText.= $tmp_dump_sql;

					$this->sql_num++;
					$post_pos++;
				}
			}
		}

		return -1;
	}

}

function dump_escape_string($str) {
	return mysql_real_escape_string($str);
}

function dump_null_string($str) {
	if (!isset($str) || is_null($str)) {
		$str = 'NULL';
	}
	return $str;
}

function remove_comment($var) {
	return (substr($var, 0, 2) != '--');
}
?>