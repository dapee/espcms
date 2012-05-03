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

	function onlngarray() {

		$lng = $this->fun->accept('lng', 'R');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$formatname = $this->fun->accept('formatname', 'R');
		$formatname = empty($formatname) ? 'selectform' : $formatname;
		$selectname = $this->fun->accept('selectname', 'R');
		$selectname = empty($selectname) ? 'selectall' : $selectname;
		$checkname = $this->fun->accept('checkname', 'R');
		$checkname = empty($checkname) ? 'check_all' : $checkname;

		$botid = $this->fun->accept('botid', 'R');
		$botid = empty($botid) ? 'mid' : $botid;

		$modelarray = $this->get_model(0, $lng, 1);
		$str = '<li><a id="' . $botid . '0" class="menunoclick" hidefocus="true" href="#body" onclick="javascript:dbfilter(\'' . $botid . '\',\'mid\',0,0,' . $modelarray['num'] . ',\'' . $formatname . '\',\'' . $selectname . '\',\'' . $checkname . '\')" title="' . $this->lng['all_botton'] . '">' . $this->lng['all_botton'] . '</a></li>';
		if (count($modelarray['list']) > 0) {
			foreach ($modelarray['list'] as $key => $value) {
				$str.='<li><a id="' . $botid . ($key + 1) . '" class="menuclick" hidefocus="true" href="#body" onclick="javascript:dbfilter(\'' . $botid . '\',\'mid\',\'' . $value['mid'] . '\',' . ($key + 1) . ',' . $modelarray['num'] . ',\'' . $formatname . '\',\'' . $selectname . '\',\'' . $checkname . '\')" title="' . $value['modelname'] . '">' . $value['modelname'] . '</a></li>';
			}
		}
		exit($str);
	}

	function onalbumarray() {

		$lng = $this->fun->accept('lng', 'R');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;

		$albumarray = $this->get_album_images_array(0, 1, $lng);
		$str = '<select size="1" name="amid" id="amid"  onchange="picload(this.value)">	<option value="0">请选择相册</option>';
		if (count($albumarray['list']) > 0) {
			foreach ($albumarray['list'] as $key => $value) {
				$str.='<option value="' . $value['amid'] . '">' . $value['title'] . '</option>';
			}
		}
		$str.='</select>';
		exit($str);
	}

	function onlngarraylabel() {

		$lng = $this->fun->accept('lng', 'R');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$formatname = $this->fun->accept('formatname', 'R');
		$formatname = empty($formatname) ? 'selectform' : $formatname;
		$selectname = $this->fun->accept('selectname', 'R');
		$selectname = empty($selectname) ? 'selectall' : $selectname;
		$checkname = $this->fun->accept('checkname', 'R');
		$checkname = empty($checkname) ? 'check_all' : $checkname;

		$botid = $this->fun->accept('botid', 'R');
		$botid = empty($botid) ? 'mid' : $botid;

		$modelarray = $this->get_model(0, $lng, 1);
		$str = '<li><a id="' . $botid . '0" class="menunoclick" hidefocus="true" href="#body" onclick="javascript:dbfilter(\'' . $botid . '\',\'mid\',0,0,' . $modelarray['num'] . ',\'' . $formatname . '\',\'' . $selectname . '\',\'' . $checkname . '\',true,\'articlelabel\',
			\'index.php?archive=connected&action=dclabel&mid=0&formatname=' . $formatname . '&selectname=' . $selectname . '&checkname=' . $checkname . '&botid=articlelabel\')" title="' . $this->lng['all_botton'] . '">' . $this->lng['all_botton'] . '</a></li>';
		if (count($modelarray['list']) > 0) {
			foreach ($modelarray['list'] as $key => $value) {
				$str.='<li><a id="' . $botid . ($key + 1) . '" class="menuclick" hidefocus="true" href="#body" onclick="javascript:dbfilter(\'' . $botid . '\',\'mid\',' . $value['mid'] . ',' . ($key + 1) . ',' . $modelarray['num'] . ',\'' . $formatname . '\',\'' . $selectname . '\',\'' . $checkname . '\',true,
					\'articlelabel\',\'index.php?archive=connected&action=dclabel&mid=' . $value['mid'] . '&formatname=' . $formatname . '&selectname=' . $selectname . '&checkname=' . $checkname . '&botid=articlelabel\')" title="' . $value['modelname'] . '">' . $value['modelname'] . '</a></li>';
			}
		}
		exit($str);
	}

	function onbbslabel() {

		$lng = $this->fun->accept('lng', 'R');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$formatname = $this->fun->accept('formatname', 'R');
		$formatname = empty($formatname) ? 'selectform' : $formatname;
		$selectname = $this->fun->accept('selectname', 'R');
		$selectname = empty($selectname) ? 'selectall' : $selectname;
		$checkname = $this->fun->accept('checkname', 'R');
		$checkname = empty($checkname) ? 'check_all' : $checkname;

		$botid = $this->fun->accept('botid', 'R');
		$botid = empty($botid) ? 'bbslabelblid' : $botid;

		$bbslabelarray = $this->get_bbslabel_array(0, $lng);
		$str = '<li><a id="' . $botid . '0" class="menunoclick" hidefocus="true" href="#body" onclick="javascript:dbfilter(\'' . $botid . '\',\'blid\',0,0,' . $bbslabelarray['num'] . ',\'' . $formatname . '\',\'' . $selectname . '\',\'' . $checkname . '\')" title="' . $this->lng['all_botton'] . '">' . $this->lng['all_botton'] . '</a></li>';
		if (count($bbslabelarray['list']) > 0) {
			foreach ($bbslabelarray['list'] as $key => $value) {
				$str.='<li><a id="' . $botid . ($key + 1) . '" class="menuclick" hidefocus="true" href="#body" onclick="javascript:dbfilter(\'' . $botid . '\',\'blid\',' . $value['blid'] . ',' . ($key + 1) . ',' . $bbslabelarray['num'] . ',\'' . $formatname . '\',\'' . $selectname . '\',\'' . $checkname . '\')" title="' . $value['labelname'] . '">' . $value['labelname'] . '</a></li>';
			}
		}
		exit($str);
	}

	function onscmodellist() {
		$creattype = $this->fun->accept('creattype', 'R');
		$lng = $this->fun->accept('lng', 'R');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$isbase = $this->fun->accept('isbase', 'R');
		$isbase = empty($isbase) ? 0 : $isbase;
		$issid = $this->fun->accept('issid', 'R');
		$issid = empty($issid) ? 0 : $issid;
		$modelarray = $this->get_model(0, $lng, 1, $isbase, $issid);

		$optiontitle = ($creattype == 'type') ? $this->lng['createmain_add_mid_option'] : $this->lng['typemanage_type_add_mid_option'];
		$str.='<option value="0">' . $optiontitle . '</option>';
		if (count($modelarray['list']) > 0) {
			foreach ($modelarray['list'] as $key => $value) {
				$str.='<option value="' . $value['mid'] . '">' . $value['modelname'] . '</option>';
			}
		}
		exit($str);
	}

	function onbbstypelist() {
		$lng = $this->fun->accept('lng', 'R');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$array = $this->get_bbstype_array(0, $lng, 1);
		$str.='<option value="0">' . $this->lng['forummain_add_type_option'] . '</option>';
		if (count($array['list']) > 0) {
			foreach ($array['list'] as $key => $value) {
				$str.='<option value="' . $value['btid'] . '">' . $value['typename'] . '</option>';
			}
		}
		exit($str);
	}

	function onsctypelist() {
		$lng = $this->fun->accept('lng', 'R');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$upid = $this->fun->accept('upid', 'R');
		$upid = empty($upid) ? 0 : $upid;
		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;
		$optiontitle = $this->fun->accept('optiontitle', 'R');
		$optiontitle = empty($optiontitle) ? $this->lng['typemanage_type_add_upid_option'] : $optiontitle;
		$isbase = $this->fun->accept('isbase', 'R');
		$isbase = empty($isbase) ? 0 : $isbase;
		$islinkd = $this->fun->accept('islinkd', 'R');
		$islinkd = empty($islinkd) ? 0 : $islinkd;
		if ($isbase || $islinkd) {
			$isbasetrue = $isbase ? false : true;
			$islinkdtrue = $islinkd ? false : true;
			$typelist = $this->get_typeselect($mid, 0, $upid, $lng, 0, 1, $isbasetrue, $islinkdtrue);
		} else {
			$typelist = $this->get_typeselect($mid, 0, $upid, $lng, 0, 1);
		}
		$str.='<option value="0">' . $optiontitle . '</option>';
		if (count($typelist) > 0) {
			foreach ($typelist as $key => $value) {
				$str.='<option value="' . $value['tid'] . '">' . $this->fun->treelist($value['level'], '&nbsp;&nbsp;&nbsp;') . '├─ ' . $value['typename'] . '</option>';
			}
		}
		exit($str);
	}

	function onscsublist() {
		$lng = $this->fun->accept('lng', 'R');
		$lng = empty($lng) ? $this->CON['default_lng'] : $lng;
		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;
		$optiontitle = $this->fun->accept('optiontitle', 'R');
		$optiontitle = empty($optiontitle) ? $this->lng['typemanage_type_add_upid_option'] : $optiontitle;
		$sublist = $this->get_subjectlist_array(0, $mid, $lng, 1);
		$str.='<option value="0">' . $optiontitle . '</option>';
		if (count($sublist['list']) > 0) {
			foreach ($sublist['list'] as $key => $value) {
				$str.='<option value="' . $value['sid'] . '">' . $value['subjectname'] . '</option>';
			}
		}
		exit($str);
	}

	function ondoclabellist() {
		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;
		$optiontitle = $this->lng['all_botton'];
		$list = $this->get_doclabel_array(0, $mid);
		$str.='<input type="radio" value="0" checked="checked" name="dlid"/> ' . $optiontitle . '&nbsp;';
		if (count($list['list']) > 0) {
			$i = 1;
			foreach ($list['list'] as $key => $value) {
				$str.='<input type="radio" value="' . $value['dlid'] . '" name="dlid"/> ' . $value['labelname'] . '&nbsp;';
				if ($i == 4) {
					$str.='<br>';
					$i = 0;
				}
				$i++;
			}
		}
		exit($str);
	}

	function ondclabel() {

		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;
		$formatname = $this->fun->accept('formatname', 'R');
		$formatname = empty($formatname) ? 'selectform' : $formatname;
		$selectname = $this->fun->accept('selectname', 'R');
		$selectname = empty($selectname) ? 'selectall' : $selectname;
		$checkname = $this->fun->accept('checkname', 'R');
		$checkname = empty($checkname) ? 'check_all' : $checkname;

		$botid = $this->fun->accept('botid', 'R');
		$botid = empty($botid) ? 'articlelabel' : $botid;

		$dclabel = $this->get_doclabel_array(0, $mid);
		$str = '<li><a id="' . $botid . '0" class="menunoclick" hidefocus="true" href="#body" onclick="javascript:dbfilter(\'' . $botid . '\',\'dlid\',0,0,' . $dclabel['num'] . ',\'' . $formatname . '\',\'' . $selectname . '\',\'' . $checkname . '\')" title="' . $this->lng['all_botton'] . '">' . $this->lng['all_botton'] . '</a></li>';
		if (count($dclabel['list']) > 0) {
			foreach ($dclabel['list'] as $key => $value) {
				$str.='<li><a id="' . $botid . ($key + 1) . '" class="menuclick" hidefocus="true" href="#body" onclick="javascript:dbfilter(\'' . $botid . '\',\'dlid\',\'' . $value['dlid'] . '\',' . ($key + 1) . ',' . $dclabel['num'] . ',\'' . $formatname . '\',\'' . $selectname . '\',\'' . $checkname . '\')" title="' . $value['labelname'] . '">' . $value['labelname'] . '</a></li>';
			}
		}
		exit($str);
	}

	function onattrindex() {

		$plugcode = $this->accept('code', 'G');

		include_once admin_ROOT . 'public/plug/payment/' . $plugcode . '.php';
		$plugpay = new pluginfo();
		$paylist = $plugpay->addplug();
		$is_cod = empty($paylist['is_cod']) ? '否' : '是';
		$is_online = empty($paylist['is_online']) ? '否' : '是';
		$attrlist.='<input type="hidden" name="plugcode" value="' . $paylist['code'] . '">';
		$attrlist.='<div class="attrlist">
			<div class="attrlist01">物流插件名称：</div>
			<div class="attrlist02"><input type="text" name="plugname" value="' . $paylist['plugname'] . '" maxlength="20" size="30" class="smallInput"></div>
		</div>
		<div class="attrlist">
			<div class="attrlist01">插件介绍：</div>
			<div class="attrlist02"><textarea name="desc" cols="60" rows="4" class="smallInput">' . $paylist['desc'] . '</textarea></div>
		</div>
		<div class="attrlist">
			<div class="attrlist01">是否支持货到付款：</div>
			<div class="attrlist02"><input type="text" name="is_cod" disabled value="' . $is_cod . '" maxlength="20" size="5" class="smallInput"></div>
		</div>
		<div class="attrlist">
			<div class="attrlist01">是否支持在线物流：</div>
			<div class="attrlist02"><input type="text" name="is_online" disabled value="' . $is_online . '" maxlength="20" size="5" class="smallInput"></div>
		</div>
		<div class="attrlist">
			<div class="attrlist01">物流费率：</div>
			<div class="attrlist02"><input type="text" name="pay_fee" value="' . $paylist['pay_fee'] . '" maxlength="20" size="5" class="smallInput"></div>
		</div>';
		foreach ($paylist['config'] as $key => $valuer) {
			switch ($valuer['type']) {
				case 'text':
					$attrlist.='<div class=attrlist><div class=attrlist01>' . $valuer['botname'] . '：</div><div class=attrlist02>
					<input type=text name="inputvalue[]" maxlength=50 size=40 class=smallInput>
					<input type="hidden" name="inputname[]" value="' . $valuer['name'] . '">
					<input type="hidden" name="inputtype[]" value="' . $valuer['type'] . '">
					<input type="hidden" name="botname[]" value="' . $valuer['botname'] . '">
					<input type="hidden" name="sevalue[]" value="">
					</div></div>';
					break;
				case 'select':
					$attrlist.='<div class=attrlist><div class=attrlist01>' . $valuer['botname'] . '：</div><div class=attrlist02><select size=1 name="inputvalue[]">';
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
					</div></div>';
					break;
			}
			$sevaluer = '';
		}
		exit($attrlist);
	}

	function oncallstyle() {
		include_once admin_ROOT . adminfile . '/include/inc_formtypelist.php';
		$type = $this->fun->accept('type', 'R');
		$type = empty($type) ? 1 : $type;
		$typeclass = array();
		$botton = 0;
		foreach ($CALLTYPE as $key => $value) {
			if ($type == $value['key']) {
				$typeclass = $value['style'];
				$botton = 1;
				break;
			}
		}
		$str.='<option value="0">' . $this->lng['callmain_add_style_option'] . '</option>';
		if (count($typeclass) > 0) {
			foreach ($typeclass as $key => $value) {
				$str.='<option value="' . $value['key'] . '">' . $value['name'] . '</option>';
			}
		}
		exit($str);
	}

	function onsoftkey() {

		if ($this->CON['checkclass'] == 'true') {
			$str = '%E5%BD%93%E5%89%8D%E7%B3%BB%E7%BB%9F%E6%8E%88%E6%9D%83%E7%B1%BB%E5%9E%8B%EF%BC%9A%3Cb%3E%E6%8E%88%E6%9D%83%E7%89%88%3C%2Fb%3E%26nbsp%3B+%26nbsp%3B+%26nbsp%3B%26nbsp%3B+%26nbsp%3B+%26nbsp%3B%E6%8E%88%E6%9D%83%E5%8F%B7%EF%BC%9A';
			$outstr.=urldecode($str);
			$outstr.='<b>' . $this->CON['codesoftkey'] . '</b>';
			exit($outstr);
		} else {
			exit('false');
		}
	}

	function onwindowclass() {
		parent::start_template();
		$getnetval = convert_uudecode($this->CON['getnetval']);
		$xmlfile = $getnetval . 'index.php?ac=siteauthentication&at=bannlist&isbann=1&siteurl=' . urlencode(admin_ClassURL) . '&vol=' . db_release . '&checkclass=' . $this->CON['checkclass'] . '&db_keycode=' . db_keycode;

		$inforss = @simplexml_load_file($xmlfile, 'SimpleXMLElement', LIBXML_NOCDATA);
		$this->fun->objectToArray($inforss);

		$addtime = time();
		$inputseesion = $this->fun->accept('windowsclassbannlist_' . $inforss['banid'], 'C');
		if (is_array($inforss) && $inforss['title'] && empty($inputseesion)) {
			$usersessionid = 'windowsclassbannlist_' . $inforss['banid'];
			$this->fun->setcookie($usersessionid, $addtime, 86400);
			exit('true');
		} else {
			exit('false');
		}
	}

	function onbannwindow() {
		parent::start_template();
		$getnetval = convert_uudecode($this->CON['getnetval']);
		$xmlfile = $getnetval . 'index.php?ac=siteauthentication&at=bannlist&isbann=1&siteurl=' . urlencode(admin_ClassURL) . '&vol=' . db_release . '&checkclass=' . $this->CON['checkclass'] . '&db_keycode=' . db_keycode;

		$inforss = @simplexml_load_file($xmlfile, 'SimpleXMLElement', LIBXML_NOCDATA);
		$this->fun->objectToArray($inforss);

		if (is_array($inforss) && $inforss['title']) {
			if (!$inforss['islink'] && empty($inforss['url'])) {
				$outstr = '<img src="' . $inforss['pic'] . '">';
			} else {
				$outstr = '<a target="_blank" class="tabclicklink" href="' . $inforss['url'] . '"><img src="' . $inforss['pic'] . '"></a>';
			}
		}
		exit($outstr);
	}

	function onsoftupdate() {
		parent::start_template();
		$getnetval = convert_uudecode($this->CON['getnetval']);
		$xmlfile = $getnetval . 'index.php?ac=siteauthentication&at=bannlist&isbann=2&siteurl=' . urlencode(admin_ClassURL) . '&vol=' . db_release . '&checkclass=' . $this->CON['checkclass'] . '&db_keycode=' . db_keycode;

		$inforss = @simplexml_load_file($xmlfile, 'SimpleXMLElement', LIBXML_NOCDATA);
		$this->fun->objectToArray($inforss);

		if (is_array($inforss) && $inforss['title']) {
			if (!$inforss['islink'] && empty($inforss['url'])) {
				$outstr = '<div class="suggestion">
				<span class="sugicon"><span class="strong colorgorning2">' . urldecode('ESPCMS%E6%B8%A9%E9%A6%A8%E6%8F%90%E9%86%92%EF%BC%9A') . '</span>
				<span class="colorgorningage">' . $inforss['title'] . '</span></span></div>';
			} else {
				$outstr = '<div class="suggestion">
				<span class="sugicon"><span class="strong colorgorning2">' . urldecode('ESPCMS%E6%B8%A9%E9%A6%A8%E6%8F%90%E9%86%92%EF%BC%9A') . '</span>
				<span class="colorgorningage"><a target="_blank" class="tabclicklink" href="' . $inforss['url'] . '">' . $inforss['title'] . '</a></span></span></div>';
			}
		}
		exit($outstr);
	}

	function onauthentication() {
		parent::start_template();
		$ipadd = $this->fun->ip($_SERVER['REMOTE_ADDR']);
		$getnetval = convert_uudecode($this->CON['getnetval']);
		$xmlfile = $getnetval . 'index.php?ac=siteauthentication&at=join&siteurl=' . urlencode(admin_ClassURL) . '&sitename=' . urlencode($this->CON['sitename']) . '&iplong=' . $ipadd . '&vol=' . db_release . '&email=' . urlencode($this->CON['admine_mail']) . '&dbcode=' . db_pscode;

		$inforss = @simplexml_load_file($xmlfile, 'SimpleXMLElement', LIBXML_NOCDATA);
		$this->fun->objectToArray($inforss);
	}

}

?>
