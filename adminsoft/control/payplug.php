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

	function onpaylist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_where = " WHERE opid>0";
		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2)
				$isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'opid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;

		$db_table = db_prefix . 'order_pay';
		if (!empty($countnum)) {
			$countnum = $this->db_numrows($db_table, $db_where);
			exit($countnum);
		}
		$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY ' . $limitkey . ' ' . $limitclass . ' LIMIT ' . $MinPageid . ',' . $MaxPerPage;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$array[] = $rsList;
		}
		$this->fun->setcookie($this->fun->noncefile() . 'pgid', $page_id, 600);
		$this->ectemplates->assign('array', $array);
		$this->ectemplates->assign('sql', $sql);
		$this->ectemplates->display('order/order_paylist');
	}

	function onpayplugadd() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'G');
		$tab = empty($tab) ? 'true' : $tab;
		$plugcode = $this->fun->accept('plugcode', 'R');

		$pluglist = $this->fun->readplug(admin_ROOT . 'public/plug/payment');
		$plugcode = empty($plugcode) ? $pluglist[0]['code'] : $plugcode;

		$modulesid = true;
		$modules = array();
		require admin_ROOT . 'public/plug/payment/' . $plugcode . '.php';
		$paylist = $modules[0];
		unset($modulesid);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('pluglist', $pluglist);
		$this->ectemplates->assign('paylist', $paylist);

		$this->ectemplates->assign('paylist_config', $paylist['config']);
		$this->ectemplates->display('order/order_payplugadd');
	}

	function onpayplugedit() {
		parent::start_template();
		$opid = $this->fun->accept('opid', 'G');
		$db_table = db_prefix . 'order_pay';
		$db_where = 'opid=' . $opid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$paylist = unserialize($read['pluglist']);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('paylist_config', $paylist);
		$this->ectemplates->display('order/order_payplugedit');
	}

	function onpaysave() {

		$inputclass = $this->fun->accept('inputclass', 'P');
		$payname = $this->fun->accept('payname', 'P');
		$paycontent = $this->fun->accept('paycontent', 'P');
		$payis = $this->fun->accept('payis', 'P');
		$plugcode = $this->fun->accept('plugcode', 'P');
		$version = $this->fun->accept('version', 'P');
		$inputvalue = $this->fun->accept('inputvalue', 'P');

		$inputname = $this->fun->accept('inputname', 'P');
		$inputtype = $this->fun->accept('inputtype', 'P');
		$inputvalue = $this->fun->accept('inputvalue', 'P');
		$botname = $this->fun->accept('botname', 'P');
		$bakcontent = $this->fun->accept('bakcontent', 'P');
		$sevaluearray = $this->fun->accept('sevalue', 'P');

		$payconfig = array();
		if (is_array($inputvalue) && isset($inputvalue)) {
			for ($i = 0; $i < count($inputvalue); $i++) {
				$inputlist = array('name' => trim($inputname[$i]), 'type' => trim($inputtype[$i]), 'value' => trim($inputvalue[$i]), 'botname' => trim($botname[$i]), 'bakcontent' => trim($bakcontent[$i]));
				if ($_POST['inputtype'][$i] == 'select') {
					$fornlen = strlen($sevaluearray[$i]) - 1;
					$sevalue = explode('|', substr($sevaluearray[$i], 0, $fornlen));
					$sevalue = array(sevalue => $sevalue);
					$payconfig[] = array_merge_recursive($inputlist, $sevalue);
				} else {
					$payconfig[] = $inputlist;
				}
			}
		}
		$payconfig = serialize($payconfig);
		$db_table = db_prefix . 'order_pay';
		$date = time();
		if ($inputclass == 'add') {
			$db_field = 'pid,payname,paycontent,paycode,payis,payplugver,pluglist,isclass,addtime';
			$db_values = "50,'$payname','$paycontent','$plugcode',$payis,'$version','$payconfig',0,$date";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$this->writelog($this->lng['orderpay_add_log'], $this->lng['log_extra_ok'] . ' title=' . $payname);
			$this->dbcache->clearcache('orderpay_array', true);
			exit('true');
		} elseif ($inputclass == 'edit') {
			$opid = $this->fun->accept('opid', 'P');
			$db_where = 'opid=' . $opid;
			$db_set = "payname='$payname',paycontent='$paycontent',payis=$payis,pluglist='$payconfig'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['orderpay_edit_log'], $this->lng['log_extra_ok'] . ' title=' . $payname . ' id=' . $opid);
			$this->dbcache->clearcache('orderpay_view_' . $opid, true);
			$this->dbcache->clearcache('orderpay_array', true);
			exit('true');
		}
	}

	function onattrindex() {

		$plugcode = $this->fun->accept('code', 'G');

		$modulesid = true;
		$modules = array();
		require admin_ROOT . 'public/plug/payment/' . $plugcode . '.php';
		$paylist = $modules[0];
		unset($modulesid);
		$is_cod = empty($paylist['is_cod']) ? $this->lng['close_botton_title'] : $this->lng['open_botton_title'];
		$attrlist.='<input type="hidden" name="plugcode" value="' . $paylist['code'] . '">';
		$attrlist.='<input type="hidden" name="version" value="' . $paylist['version'] . '"/>';
		$attrlist.='<table class="formtable">
			<tr class="trstyle2">
				<td class="trtitle01">' . $this->lng['orderpay_add_payname'] . '</td>
				<td class="trtitle02">
					<input type="text" name="payname" size="30" maxlength="80" value="' . $paylist['plugname'] . '" class="infoInput"/>
					<span class="cautiontitle">' . $this->lng['orderpay_add_payname_mess'] . '</span>
				</td>
			</tr>
			<tr class="trstyle2">
				<td class="trtitle01">' . $this->lng['orderpay_add_paycontent'] . '</td>
				<td class="trtitle02"><textarea name="paycontent" cols="80" rows="5" class="infoInput">' . $paylist['desc'] . '</textarea></td>
			</tr>
			<tr class="trstyle2">
				<td class="trtitle01">' . $this->lng['orderpay_add_iscod'] . '</td>
				<td class="trtitle02">
					<input type="text" name="is_cod" disabled value="' . $is_cod . '" maxlength="20" size="5" class="infoInput">
				</td>
			</tr>
			<tr class="trstyle2">
				<td class="trtitle01">' . $this->lng['orderpay_add_payis'] . '</td>
				<td class="trtitle02"><input type="text" name="payis" size="4" maxlength="6" value="' . $paylist['pay_fee'] . '" class="infoInput"/> % <span class="cautiontitle">' . $this->lng['orderpay_add_payis_mess'] . '</span></td>
			</tr>';
		foreach ($paylist['config'] as $key => $valuer) {
			switch ($valuer['type']) {
				case 'text':
					$attrlist.='
					<tr class="trstyle2">
						<td class="trtitle01">' . $valuer['botname'] . '</td>
						<td class="trtitle02">
							<input type="text" name="inputvalue[]" maxlength="50" size="40" class="infoInput">
							<input type="hidden" name="inputname[]" value="' . $valuer['name'] . '">
							<input type="hidden" name="inputtype[]" value="' . $valuer['type'] . '">
							<input type="hidden" name="botname[]" value="' . $valuer['botname'] . '">
							<input type="hidden" name="sevalue[]" value="">
						</td>
					</tr>';
					break;
				case 'select':
					$attrlist.='<tr class="trstyle2">
						<td class="trtitle01">' . $valuer['botname'] . '</td>
						<td class="trtitle02"><select size=1 name="inputvalue[]">';
					foreach ($valuer['sevalue'] as $key2 => $valuer2) {
						$selected = ($key2 == $paylist['value']) ? 'selected' : '';
						$sevaluer.=$valuer2 . '|';
						$attrlist.='<option ' . $selected . ' value=' . $key2 . '>' . $valuer2 . '</option>';
					}
					$attrlist.='</select>
					<input type="hidden" name="inputname[]" value="' . $valuer['name'] . '">
					<input type="hidden" name="inputtype[]" value="' . $valuer['type'] . '">
					<input type="hidden" name="botname[]" value="' . $valuer['botname'] . '">
					<input type="hidden" name="sevalue[]" value="' . $sevaluer . '">
					</td></tr>';
					break;
			}
			$sevaluer = '';
		}
		$attrlist.='</table>';
		exit($attrlist);
	}

	function onsort() {
		$db_table = db_prefix . 'order_pay';
		$id = $this->fun->accept('infoid', 'P');
		$pid = $this->fun->accept('pid', 'P');
		$idArray = explode(',', $id);
		$pidArray = explode(',', $pid);
		foreach ($idArray as $key => $value) {
			if (!empty($value)) {
				$db_where = "opid=$value";
				$pid = intval($pidArray[$key]);
				$db_set = "pid=$pid";
				$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			}
		}
		$this->writelog($this->lng['orderpay_sort_log'], $this->lng['log_extra_ok']);
		$this->dbcache->clearcache('orderpay_array', true);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'order_pay';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid))
			exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "opid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['orderpay_set_log'], $this->lng['log_extra_ok'] . ' opid=' . $selectinfoid);
		$this->dbcache->clearcache('orderpay_array', true);
		exit('true');
	}

	function onpayplugdel() {
		$db_table = db_prefix . 'order_pay';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid))
			exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0)
			exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "opid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
			$this->dbcache->clearcache('orderpay_view_' . $infoarray[$i], true);
		}
		$this->writelog($this->lng['orderpay_del_log'], $this->lng['log_extra_ok'] . ' opid=' . $selectinfoid);
		$this->dbcache->clearcache('orderpay_array', true);
		exit('true');
	}

}
?>