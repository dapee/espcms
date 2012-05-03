<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用

  作者：Bili E-mail:huangqyun@163.com  QQ:6326420
  http://www.ecisp.cn	http://www.easysitepm.com
 */

class lib_public extends connector {

	function lib_public() {
		$this->softbase(true);
		parent::start_template();
		$this->ectemplates->caching = false;
		$this->ectemplates->libfile = true;
	}

	public function call_menu($para, $filename='menu') {

		$topmlid = empty($para[0]) ? 1 : $para[0];
		$archive = $this->fun->accept('archive', 'G');
		$action = $this->fun->accept('action', 'G');
		$loadfun = $this->fun->accept('loadfun', 'G');
		$menuid = $this->fun->accept('menuid', 'G');
		$db_table = db_prefix . 'menulink';
		$sql = "SELECT mlid,pid,topmlid,menuname,linkurl,isshow,loadfun FROM $db_table WHERE topmlid=0 ORDER BY pid,mlid ASC";
		$menu = $this->dbcache->checkcache('menu_' . $this->esp_username, false);
		if (!$menu) {
			$rs = $this->db->query($sql);

			while ($rsList = $this->db->fetch_assoc($rs)) {
				if (!in_array($rsList['loadfun'], $this->esp_powerlist)) {

					$topmlid = $rsList['mlid'];
					$sqlnext = "SELECT mlid,pid,topmlid,menuname,linkurl,isshow,loadfun FROM $db_table WHERE topmlid=$topmlid and isshow=1 ORDER BY pid,mlid ASC";
					$rsNext = $this->db->query($sqlnext);
					while ($rsNList = $this->db->fetch_assoc($rsNext)) {
						if (!in_array($rsNList['loadfun'], $this->esp_powerlist)) {
							$rsNList['linkurl'] = $rsNList['linkurl'] . '&menuname_title=' . urlencode($rsNList['menuname']);
							$rsList['menulink'][] = $rsNList;
						}
					}
					$menulinkarray[] = $rsList;
				}
			}
			$menu = $this->dbcache->cachesave('menu_' . $this->esp_username, $menulinkarray);
			$menu = $menu ? $menu : $menulinkarray;
			unset($menulinkarray);
		}

		$nowurl = $this->fun->request_url();

		$nowurl = preg_replace('/&sitesoftlng=[\w]+/i', '', $nowurl);
		$nowurl = preg_replace('/&tid=[0-9]+/i', '', $nowurl);
		$nowurl = preg_replace('/&mid=[0-9]+/i', '', $nowurl);
		$db_table = db_prefix . 'lng';
		$sql = "SELECT id,pid,lng,lngtitle,url,lockin,isopen,isuptype,sitename,keyword,description,copyright FROM $db_table WHERE isuptype=0 ORDER BY id ASC";
		$lanar = $this->dbcache->checkcache('lngarray', false);
		if (!$lanar) {
			$rs = $this->db->query($sql);

			while ($rsList = $this->db->fetch_assoc($rs)) {
				$rsList['url'] = $nowurl . '&sitesoftlng=' . $rsList['lng'];
				$lanarray[] = $rsList;
			}
			$lanar = $this->dbcache->cachesave('lngarray', $lanarray);
			$lanar = $lanar ? $lanar : $lanarray;
			unset($lanarray);
		}

		$this->ectemplates->assign('powerlist', $this->esp_powerlist);
		$this->ectemplates->assign('archive', $archive);
		$this->ectemplates->assign('action', $action);
		$this->ectemplates->assign('loadfun', $loadfun);
		$this->ectemplates->assign('menulinkarray', $menu);
		$this->ectemplates->assign('menuid', $menuid);
		$this->ectemplates->assign('lanarray', $lanar);
		$this->ectemplates->assign('lng', $this->sitelng);
		$output = $this->ectemplates->fetch($filename);
		return $output;
	}

	public function call_tabmenubotton($para, $filename='tabmenubotton') {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';

		$menutype = empty($para[0]) ? 'loglist' : $para[0];


		$mid = empty($para[2]) ? 0 : $para[2];

		$isclass = empty($para[3]) ? 0 : $para[3];

		$tabcount = empty($para[4]) ? 0 : $para[4];
		$tabexp = explode('-', $tabcount);
		$tabarray['mid'] = $tabexp[0];
		$tabarray['tid'] = $tabexp[1];
		$tabarray['fgid'] = $tabexp[2];
		$tabarray['atid'] = $tabexp[3];

		$archive = $this->fun->accept('archive', 'G');
		$action = $this->fun->accept('action', 'G');
		$this->ectemplates->assign('conlist', $this->CON[$menutype]);
		$this->ectemplates->assign('powerlist', $this->esp_powerlist);
		$powerarray = $this->get_power_array();
		$this->ectemplates->assign('powerarray', $powerarray['list']);
		$this->ectemplates->assign('powernum', $powerarray['num']);

		$memberpuv = $this->get_member_purview_array();
		$this->ectemplates->assign('memberpuvlist', $memberpuv['list']);
		$this->ectemplates->assign('pubnum', $memberpuv['num']);

		$dclabel = $this->get_doclabel_array(0, $mid, $this->sitelng);
		$this->ectemplates->assign('dclabellist', $dclabel['list']);
		$this->ectemplates->assign('dclabelnum', $dclabel['num']);

		$this->ectemplates->assign('lantype', $LANPACKTYPE);
		$this->ectemplates->assign('mid', $mid);
		$this->ectemplates->assign('tid', $tabarray['tid']);
		$this->ectemplates->assign('fgid', $tabarray['fgid']);
		$this->ectemplates->assign('isclass', $isclass);
		$this->ectemplates->assign('action', $action);
		$this->ectemplates->assign('menutype', $menutype);
		$this->ectemplates->assign('tabarray', $tabarray);
		$output = $this->ectemplates->fetch($filename);
		return $output;
	}

	public function call_tablabel($para, $filename='tablabel') {

		$menutype = empty($para[0]) ? 'loglist' : $para[0];
		$archive = $this->fun->accept('archive', 'G');
		$action = $this->fun->accept('action', 'G');
		$this->ectemplates->assign('powerlist', $this->esp_powerlist);
		$this->ectemplates->assign('archive', $archive);
		$this->ectemplates->assign('action', $action);
		$this->ectemplates->assign('menutype', $menutype);
		$output = $this->ectemplates->fetch($filename);
		return $output;
	}




	public function call_tabbotton($para, $filename='tabbotton') {
		$this->ectemplates->assign('powerlist', $this->esp_powerlist);

		$loadfun = $para[0];
		if (!$loadfun) {
			return false;
		}
		$nowurl = $this->fun->request_url();

		$tabcount = empty($para[1]) ? 0 : $para[1];
		$tabexp = explode('-', $tabcount);

		if ($loadfun == 'articlelist') {

			$tabarray['mid'] = $tabexp[0];
			$tabarray['tid'] = $tabexp[1];
			$nowurl = preg_replace('/&tid=[0-9]+/i', '', $nowurl);
			$nowurl = preg_replace('/&mid=[0-9]+/i', '', $nowurl);

			$typelist = $this->get_typeselect(0, 0, $tabarray['tid'], $this->sitelng, 0, 1, true, false);
			if (is_array($typelist)) {
				foreach ($typelist as $key => $value) {
					$typelist[$key]['url'] = $nowurl . '&tid=' . $value['tid'] . '&mid=' . $value['mid'];
				}
			}
			$this->ectemplates->assign('typelist', $typelist);

			$modelarray = $this->get_model($tabarray['mid'], $this->sitelng, 0, 2, 0);
			if (is_array($modelarray['list'])) {
				foreach ($modelarray['list'] as $key => $value) {
					$modelarray['list'][$key]['url'] = $nowurl . '&mid=' . $value['mid'];
				}
			}
			$this->ectemplates->assign('modelarray', $modelarray['list']);
		} elseif ($loadfun == 'seolinklist' || $loadfun == 'seolinktypelist') {


			$tabarray['tid'] = $tabexp[1];
			$tabarray['mid'] = $tabexp[0];
			$nowurl = preg_replace('/&tid=[0-9]+/i', '', $nowurl);
			$nowurl = preg_replace('/&mid=[0-9]+/i', '', $nowurl);

			$typelist = $this->get_typeselect(0, 0, $tabarray['tid'], $this->sitelng, 0, 1, true, false);
			if (is_array($typelist)) {
				foreach ($typelist as $key => $value) {
					$typelist[$key]['url'] = $nowurl . '&tid=' . $value['tid'] . '&mid=' . $value['mid'];
				}
			}
			$this->ectemplates->assign('typelist', $typelist);

			$modelarray = $this->get_model($tabarray['mid'], $this->sitelng);
			if (is_array($modelarray['list'])) {
				foreach ($modelarray['list'] as $key => $value) {
					$modelarray['list'][$key]['url'] = $nowurl . '&mid=' . $value['mid'];
				}
			}
			$this->ectemplates->assign('modelarray', $modelarray['list']);
		} elseif ($loadfun == 'typelist') {
			$tabarray['mid'] = $tabexp[0];
			$nowurl = preg_replace('/&mid=[0-9]+/i', '', $nowurl);

			$modelarray = $this->get_model($tabarray['mid'], $this->sitelng);
			if (is_array($modelarray['list'])) {
				foreach ($modelarray['list'] as $key => $value) {
					$modelarray['list'][$key]['url'] = $nowurl . '&mid=' . $value['mid'];
				}
			}
			$this->ectemplates->assign('modelarray', $modelarray['list']);
		} elseif ($loadfun == 'subjectlist' || $loadfun == 'recomlist') {

			$tabarray['mid'] = $tabexp[0];
			$nowurl = preg_replace('/&mid=[0-9]+/i', '', $nowurl);

			$modelarray = $this->get_model($tabarray['mid'], $this->sitelng, 0, 2, 0);
			if (is_array($modelarray['list'])) {
				foreach ($modelarray['list'] as $key => $value) {
					$modelarray['list'][$key]['url'] = $nowurl . '&mid=' . $value['mid'];
				}
			}
			$this->ectemplates->assign('modelarray', $modelarray['list']);
		} elseif ($loadfun == 'memberlist') {

			$tabarray['mcid'] = $tabexp[2];
			$nowurl = preg_replace('/&mcid=[0-9]+/i', '', $nowurl);

			$memberclassarray = $this->get_member_purview_array($tabarray['mcid']);
			if (is_array($memberclassarray['list'])) {
				foreach ($memberclassarray['list'] as $key => $value) {
					$memberclassarray['list'][$key]['url'] = $nowurl . '&mcid=' . $value['mcid'];
				}
			}
			$this->ectemplates->assign('memberclass', $memberclassarray['list']);
		} elseif ($loadfun == 'advertlist') {

			$tabarray['atid'] = $tabexp[3];
			$nowurl = preg_replace('/&atid=[0-9]+/i', '', $nowurl);

			$advert_typearray = $this->get_advert_type_array($tabarray['atid'], $this->sitelng);
			if (is_array($advert_typearray['list'])) {
				foreach ($advert_typearray['list'] as $key => $value) {
					$advert_typearray['list'][$key]['url'] = $nowurl . '&atid=' . $value['atid'];
				}
			}
			$this->ectemplates->assign('adtype', $advert_typearray['list']);
		}
		$this->ectemplates->assign('menutype', $menutype);
		$this->ectemplates->assign('loadfun', $loadfun);
		$output = $this->ectemplates->fetch($filename);
		return $output;
	}

}

?>
