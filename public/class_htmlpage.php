<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420

  http://www.ecisp.cn	http://www.easysitepm.com
 */

class htmlpage {

	private $MaxPerPage;
	public $MaxHit = 5;
	public $pagebotton = '首页/上一页/下一页/尾页';
	public $gopageurl = '跳转至$1页';

	public function htmlpage($sql, $MaxPerPage, $index, $total, $Pageid, $Pagestyle=1, $entrance_file='index', $extension='html', $MaxHit=5, $pagebotton=null, $gopageurl=nul, $filenametemplates=null) {
		if (trim($sql) != '') {

			list($sql, $limit) = explode('LIMIT', $sql);
			list($counsql, $fromsql) = explode('FROM', $sql);

			$this->NowPage = $index;

			$this->total = $total;

			$this->Pageid = $Pageid;

			$this->extension = '.' . $extension;

			$this->entrance_file = $entrance_file;

			$this->Pagestyle = $Pagestyle;
		}

		$str_pagetitle = empty($pagebotton) ? $this->pagebotton : $pagebotton;

		$this->MaxHit = $MaxHit;
		$this->PageListTitle = explode('/', $str_pagetitle);
		$this->gopageurl = $gopageurl;

		$this->firstPage = 1;

		$this->homePage = $this->NowPage - 1;
		$this->homePage = empty($this->homePage) ? 1 : $this->homePage;

		$this->nextPage = $this->NowPage + 1;

		$this->filenametemplates = $filenametemplates;

		if (isset($limit)) {

			list($limit1, $limit2) = explode(',', $limit);
			if (!empty($limit2)) {
				$this->MaxPerPage = $limit2;
			} elseif (!empty($limit1)) {
				$this->MaxPerPage = $limit1;
			} else {

				$this->MaxPerPage = $this->MaxPerPage;
			}
		}
		$this->sqlList = $sql;
	}

	public function PageSQL($Sortid, $SortMethod='down') {

		if (isset($SortMethod) && $SortMethod == 'up') {
			$SortMethod = '';
		} elseif (isset($SortMethod) && $SortMethod == 'down') {
			$SortMethod = 'DESC';
		}

		if ($this->NowPage <= 0) {
			$this->NowPage = 1;
		} elseif ($this->NowPage > $this->Pageid) {
			$this->NowPage = $this->Pageid;
		} else {
			$this->NowPage = $this->NowPage;
		}
		if ($this->total <= 0) {
			$topPage = 0;
		} else {
			$topPage = $this->MaxPerPage * ($this->NowPage - 1);
		}
		$sql = $this->sqlList . ' ORDER BY ' . $Sortid . ' ' . $SortMethod . ' LIMIT ' . $topPage . ',' . $this->MaxPerPage;
		return $sql;
	}

	public function PageList() {

		if ($this->NowPage > 1) {

			$filename_first = $this->entrance_file . $this->extension;

			$filename_home = $this->homePage == 1 ? $filename_first : str_replace('{pageid}', $this->homePage, $this->filenametemplates) . $this->extension;
			$this->pageBotton1 = '<a class="p1" title="' . $this->PageListTitle[0] . '" href="' . $filename_first . '">' . $this->PageListTitle[0] . '</a>';
			$this->pageBotton1 .= '<a class="p1" title="' . $this->PageListTitle[1] . '" href="' . $filename_home . '">' . $this->PageListTitle[1] . '</a>';
		} else {
			$this->pageBotton1 = '<span class="current disabled">' . $this->PageListTitle[0] . '</span> <span class="current disabled">' . $this->PageListTitle[1] . '</span> ';
		}
		if ($this->NowPage < $this->Pageid) {
			$filename_nextPage = str_replace('{pageid}', $this->nextPage, $this->filenametemplates) . $this->extension;
			$filename_Pageid = str_replace('{pageid}', $this->Pageid, $this->filenametemplates) . $this->extension;
			$this->pageBotton2 = '<a class="p1" title="' . $this->PageListTitle[2] . '" href="' . $filename_nextPage . '">' . $this->PageListTitle[2] . '</a>';
			$this->pageBotton2 .= '<a class="p1" title="' . $this->PageListTitle[3] . '" href="' . $filename_Pageid . '">' . $this->PageListTitle[3] . '</a>';
		} else {
			$this->pageBotton2 = ' <span class="current disabled">' . $this->PageListTitle[2] . '</span> <span class="current disabled">' . $this->PageListTitle[3] . '</span>';
		}
		if ($this->Pagestyle == 1) {

			$pageBotton = $this->Bottonstyle();
		} else {

			$pageBotton = $this->pageBotton1 . $this->pageBotton2 . $this->pageSelect();
		}
		return $pageBotton;
	}

	public function Prevbotton() {

		$prevarray = array();
		if ($this->NowPage > 1) {

			$filename_first = $this->entrance_file . $this->extension;

			$filename_home = $this->homePage == 1 ? $filename_first : str_replace('{pageid}', $this->homePage, $this->filenametemplates) . $this->extension;
			$prevarray['t'] = '<a class="p1" title="' . $this->PageListTitle[0] . '" href="' . $filename_first . '">' . $this->PageListTitle[0] . '</a>';
			$prevarray['p'] = '<a class="p1" title="' . $this->PageListTitle[1] . '" href="' . $filename_home . '">' . $this->PageListTitle[1] . '</a>';
		} else {
			$prevarray['t'] = '<span class="current disabled">' . $this->PageListTitle[0] . '</span>';
			$prevarray['p'] = '<span class="current disabled">' . $this->PageListTitle[1] . '</span>';
		}
		if ($this->NowPage < $this->Pageid) {
			$filename_nextPage = str_replace('{pageid}', $this->nextPage, $this->filenametemplates) . $this->extension;
			$filename_Pageid = str_replace('{pageid}', $this->Pageid, $this->filenametemplates) . $this->extension;
			$prevarray['n'] = '<a class="p1" title="' . $this->PageListTitle[2] . '" href="' . $filename_nextPage . '">' . $this->PageListTitle[2] . '</a>';
			$prevarray['e'] .= '<a class="p1" title="' . $this->PageListTitle[3] . '" href="' . $filename_Pageid . '">' . $this->PageListTitle[3] . '</a>';
		} else {
			$prevarray['n'] = '<span class="current disabled">' . $this->PageListTitle[2] . '</span>';
			$prevarray['e'] = '<span class="current disabled">' . $this->PageListTitle[3] . '</span>';
		}
		return $prevarray;
	}

	public function PageStat($alttitle=null) {
		$str_array = array(
		    1 => array('key' => '$1', 'value' => $this->total),
		    2 => array('key' => '$2', 'value' => $this->NowPage),
		    3 => array('key' => '$3', 'value' => $this->Pageid),
		    4 => array('key' => '$4', 'value' => $this->MaxPerPage)
		);
		foreach ($str_array as $key => $value) {
			$alttitle = str_replace($value['key'], $value['value'], $alttitle);
		}
		return $alttitle;
	}

	public function Bottonstyle($pagebottonclass=true) {

		$for_end = ($this->Pageid > ($this->NowPage + $this->MaxHit)) ? ($this->NowPage + $this->MaxHit) : $this->Pageid;

		$for_begin = (($this->NowPage - $this->MaxHit) > 1) ? ($this->NowPage - $this->MaxHit) : 1;
		for ($i = $for_begin; $i <= $for_end; $i++) {
			if ($i == $this->NowPage) {
				$PageNumString.="<span class=\"current disabled\">$i</span> ";
			} else {

				$filename = $i == 1 ? $this->entrance_file . $this->extension : str_replace('{pageid}', $i, $this->filenametemplates) . $this->extension;
				$PageNumString.="<a title=\"" . $i . "\" href=\"" . $filename . "\">$i</a> ";
			}
		}
		if ($pagebottonclass) {
			$PageNumString2 = $this->pageBotton1 . $PageNumString . $this->pageBotton2;
		} else {
			$PageNumString2 = $PageNumString;
		}
		return $PageNumString2;
	}

	public function pageSelect() {
		$pageselect = '<select name="selectpageid" id="selectpageid" onchange="javascript:location.href=\'\'+this.value+\'\'">';
		for ($index = 1; $index <= $this->Pageid; $index++) {
			$selected = ($this->NowPage == $index) ? 'selected ' : '';
			$filename = $index == 1 ? $this->entrance_file . $this->extension : str_replace('{pageid}', $index, $this->filenametemplates) . $this->extension;
			$pageselect .= '<option ' . $selected . 'value="' . $filename . '">' . $index . '</option>';
		}
		$pageselect.= '</select>';
		$pageselectBotton = str_replace("$1", $pageselect, $this->gopageurl);
		return $pageselectBotton;
	}

}

?>