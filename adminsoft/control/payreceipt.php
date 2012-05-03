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

	function onpayreceiptlist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$db_where = " WHERE oprid>0";
		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$oid = $this->fun->accept('oid', 'R');
		if (!empty($oid)) {
			$db_where.=' AND oid=' . $oid;
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'oprid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;

		$db_table = db_prefix . 'order_payreceipt';
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
		$this->ectemplates->display('order/order_payreceiptlist');
	}

	function onpayreceiptadd() {
		parent::start_template();
		$oid = $this->fun->accept('oid', 'G');
		$type = $this->fun->accept('type', 'G');
		$read = $this->get_order($oid);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('type', $type);
		if ($type == 1) {
			$this->ectemplates->display('order/order_payreceiptadd');
		} else if ($type == 2) {
			$this->ectemplates->display('order/order_payreceiptadd_re');
		}
	}

	function onpayreceiptedit() {
		parent::start_template();
		$oprid = $this->fun->accept('oprid', 'G');
		$db_table = db_prefix . 'order_payreceipt';
		$db_where = 'oprid=' . $oprid;
		$read = $this->db->fetch_first('SELECT * FROM ' . $db_table . ' WHERE ' . $db_where);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->display('order/order_payreceiptedit');
	}

	function onsave() {
		parent::start_template();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$bankname = $this->fun->accept('bankname', 'P');
		$bankaccount = $this->fun->accept('bankaccount', 'P');
		$content = $this->fun->accept('content', 'P');
		$paysn = $this->fun->accept('paysn', 'P');
		$db_table = db_prefix . 'order_payreceipt';
		$db_table2 = db_prefix . 'order';
		$date = time();
		if ($inputclass == 'edit') {
			$oprid = $this->fun->accept('oprid', 'P');
			$db_where = 'oprid=' . $oprid;
			$db_set = "bankname='$bankname',bankaccount='$bankaccount',content='$content'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['payreceiptlist_edit_log'], $this->lng['log_extra_ok'] . ' SN=' . $paysn);
			exit('true');
		} elseif ($inputclass == 'add') {
			$oid = $this->fun->accept('oid', 'P');
			$opid = $this->fun->accept('opid', 'P');
			$ordersn = $this->fun->accept('ordersn', 'P');
			$userid = $this->fun->accept('userid', 'P');
			$orderamount = $this->fun->accept('orderamount', 'P');
			$isclass = $this->fun->accept('isclass', 'P');
			$username = $this->esp_username;
			
			$db_field = 'oid,opid,paysn,ordersn,orderamount,bankaccount,bankname,username,content,userid,isclass,paytime,addtime';
			$db_values = "$oid,$opid,'$paysn','$ordersn',$orderamount,'$bankaccount','$bankname','$username','$content',$userid,$isclass,$date,$date";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');

			$db_where = 'oid=' . $oid;
			if ($isclass==1) {

				$db_set = "paysn='$paysn',paytime=$date,ordertype=2";
			}elseif($isclass==2){

				$db_set = "ordertype=7";
			}
			$this->db->query('UPDATE ' . $db_table2 . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['payreceiptlist_add_log'], $this->lng['log_extra_ok'] . ' paysn=' . $paysn);
			exit('true');
		}
	}

	function onpayreceiptdel() {
		$db_table = db_prefix . 'order_payreceipt';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "oprid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['payreceiptlist_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		exit('true');
	}

}
?>