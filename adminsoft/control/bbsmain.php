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

	function onbbsmainlist() {
		parent::start_template();

		$MinPageid = $this->fun->accept('MinPageid', 'R');

		$page_id = $this->fun->accept('page_id', 'R');

		$countnum = $this->fun->accept('countnum', 'R');

		$MaxPerPage = $this->fun->accept('MaxPerPage', 'R');
		if (empty($MaxPerPage)) {
			$MaxPerPage = $this->CON['max_list'];
		}
		$btid = $this->fun->accept('btid', 'R');
		$db_where = ' WHERE btid=' . $btid;
		$bbstype = $this->get_bbstype_view($btid);
		$upbid = $this->fun->accept('upbid', 'R');
		if (!empty($upbid)) {
			$db_where.=' AND upbid=' . $upbid;
		} else {
			$db_where.=' AND upbid=0';
		}
		$noreply = $this->fun->accept('noreply', 'R');
		if (!empty($noreply) && empty($upbid)) {
			if ($noreply == 2) {
				$db_where.=' AND replynum=0';
			} else {
				$db_where.=' AND replynum>0';
			}
		}
		$istop = $this->fun->accept('istop', 'R');
		if (!empty($istop)) {
			if ($istop == 2) $istop = 0;
			$db_where.=' AND istop=' . $istop;
		}
		$isclass = $this->fun->accept('isclass', 'R');
		if (!empty($isclass)) {
			if ($isclass == 2) $isclass = 0;
			$db_where.=' AND isclass=' . $isclass;
		}
		$serchekey = $this->fun->accept('serchekey', 'R');
		if (!empty($serchekey)) {
			$db_where.=" AND title like '%$serchekey%'";
		}

		$limitkey = $this->fun->accept('limitkey', 'R');
		$limitkey = empty($limitkey) ? 'bid' : $limitkey;

		$limitclass = $this->fun->accept('limitclass', 'R');
		$limitclass = empty($limitclass) ? 'DESC' : $limitclass;
		$db_table = db_prefix . 'bbs';
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
		$this->ectemplates->assign('linkebid', $linkebid);
		$this->ectemplates->assign('noreply', $noreply);
		$this->ectemplates->assign('istop', $istop);
		$this->ectemplates->assign('isclass', $isclass);
		$this->ectemplates->assign('upbid', $upbid);
		$this->ectemplates->assign('btid', $btid);
		$this->ectemplates->assign('bbstype', $bbstype);
		$this->ectemplates->display('bbs/bbs_list');
	}

	function onsearch() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$lng = $this->fun->accept('lng', 'R');
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$lnglist = $this->get_lng_array($lng);
		$this->ectemplates->assign('lnglist', $lnglist['list']);
		$bbstype = $this->get_bbstype_array(0, $lng);
		$this->ectemplates->assign('bbstype', $bbstype['list']);
		$this->ectemplates->display("bbs/bbs_search");
	}

	function onbbsmainedit() {
		parent::start_template();
		$type = $this->fun->accept('type', 'G');
		$bid = $this->fun->accept('bid', 'G');

		$read = $this->get_bbs($bid);
		if (!empty($read['userid'])) {
			$rsMember = $this->get_member(null, $read['userid']);
		}
		$this->ectemplates->assign('member', $rsMember);
		if (!empty($read['adminid'])) {
			$rsAdmin = $this->get_admin_view(null, $read['adminid']);
		}
		if ($type == 'add') {
			$read['content'] = html_entity_decode($read['content']);
		}
		$this->ectemplates->assign('adminview', $rsAdmin);
		$this->ectemplates->assign('tab', 'true');
		$this->ectemplates->assign('read', $read);
		$this->ectemplates->assign('type', $type);
		if ($type == 'edit') {
			$this->ectemplates->display('bbs/bbs_edit');
		} else {
			$this->ectemplates->display('bbs/bbs_add');
		}
	}

	function onsave() {
		parent::start_template();
		$date = time();
		$inputclass = $this->fun->accept('inputclass', 'P');
		$lng = $this->fun->accept('lng', 'P');
		$bid = $this->fun->accept('bid', 'P');
		$btid = $this->fun->accept('btid', 'P');
		$title = $this->fun->accept('title', 'P');
		$content = $this->fun->accept('content', 'P');
		$username = $this->fun->accept('username', 'P');
		$email = $this->fun->accept('email', 'P');
		$qq = $this->fun->accept('qq', 'P');
		$qq = empty($qq) ? 0 : $qq;
		$msn = $this->fun->accept('msn', 'P');
		$address = $this->fun->accept('address', 'P');
		$tel = $this->fun->accept('tel', 'P');
		$mobile = $this->fun->accept('mobile', 'P');
		$db_table = db_prefix . 'bbs';
		$adminid = $this->ec_member_username_id;
		$adminid = empty($adminid) ? 0 : $adminid;
		$ipadd = $this->fun->ip($_SERVER['REMOTE_ADDR']);
		if ($inputclass == 'edit') {
			if (empty($bid)) exit('false');
			$db_where = 'bid=' . $bid;
			$db_set = "adminid=$adminid,title='$title',content='$content',username='$username',email='$email',qq=$qq,msn='$msn',address='$address',tel='$tel',mobile='$mobile'";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
			$this->writelog($this->lng['forummain_edit_log'], $this->lng['log_extra_ok'] . ' title=' . $title . ' id=' . $bid);
			$this->dbcache->clearcache('bbs_list_array_' . $btid, true);
			exit('true');
		}elseif ($inputclass == 'add') {
			$reemail = $this->fun->accept('reemail', 'P');
			if ($btid) {
				$typeread = $this->get_bbstype_view($btid);
			}
			$db_field = 'btid,upbid,adminid,userid,lng,title,content,username,email,qq,msn,address,tel,mobile,replynum,click,addtime,retime,isclass,istop,ipadd';
			$db_values = "$btid,$bid,$adminid,0,'$lng','$title','$content','','','','','','','',0,0,$date,$date,1,0,'$ipadd'";
			$this->db->query('INSERT INTO ' . $db_table . ' (' . $db_field . ') VALUES (' . $db_values . ')');
			$db_where = 'bid=' . $bid;
			$db_set = "replynum=1,retime=$date";
			$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);

			if ($typeread['ismail'] && $this->CON['is_email']) {

				if (preg_match("/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/i", $reemail)) {
					$this->forumsendmail('forumre', $bid, $reemail);
				}
			}
			$this->writelog($this->lng['forummain_add_log'], $this->lng['log_extra_ok'] . ' title=' . $title . ' id=' . $bid);
			exit('true');
		}
	}

	function onbbsmaindel() {
		$db_table = db_prefix . 'bbs';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		if (empty($selectinfoid)) exit('false');
		$infoarray = explode(',', $selectinfoid);
		$count = count($infoarray) - 1;
		if ($count <= 0) exit('false');
		for ($i = 0; $i < $count; $i++) {
			$db_where = "bid=$infoarray[$i] or upbid=$infoarray[$i]";
			$this->db->query('DELETE FROM ' . $db_table . ' WHERE ' . $db_where);
		}
		$this->writelog($this->lng['forummain_del_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('bbs_list_array', true);
		exit('true');
	}

	function onsetting() {
		$db_table = db_prefix . 'bbs';
		$selectinfoid = $this->fun->accept('selectinfoid', 'P');
		$selectinfoid = $selectinfoid . '0';
		if (empty($selectinfoid)) exit('false');
		$value = $this->fun->accept('value', 'P');
		$dbname = $this->fun->accept('dbname', 'P');
		$db_set = "$dbname=$value";
		$db_where = "bid IN ( $selectinfoid )";
		$this->db->query('UPDATE ' . $db_table . ' SET ' . $db_set . ' WHERE ' . $db_where);
		$this->writelog($this->lng['forummain_class_log'], $this->lng['log_extra_ok'] . ' id=' . $selectinfoid);
		$this->dbcache->clearcache('bbs_list_array', true);
		exit('true');
	}

}

?>