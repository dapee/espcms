<?php

/*
  PHP version 5
  Copyright (c) 2002-2010 ECISP.CN
  声明：这不是一个免费的软件，请在许可范围内使用
  作者：Bili E-mail:huangqyun@163.com  QQ:6326420

  http://www.ecisp.cn	http://www.easysitepm.com
 */

class PageBotton {

	private $MaxPerPage;
	public $MaxHit = 5;
	public $pagebotton = '首页/上一页/下一页/尾页';
	public $gopageurl = '跳转至$1页';

	public function PageBotton($sql, $MaxPerPage, $index, $total, $Pageid, $Pagestyle=1, $file_fileex='html', $MaxHit=5, $pagebotton=null, $gopageurl=null, $is_write=0) {
		if (trim($sql) != '') {

			list($sql, $limit) = explode('LIMIT', $sql);
			list($counsql, $fromsql) = explode('FROM', $sql);

			$this->NowPage = $index;

			$this->total = $total;

			$this->Pageid = $Pageid;

			$this->Pagestyle = $Pagestyle;

			$this->file_fileex = $file_fileex;
		}

		$str_pagetitle = empty($pagebotton) ? $this->pagebotton : $pagebotton;

		$this->MaxHit = $MaxHit;
		$this->PageListTitle = explode('/', $str_pagetitle);
		$this->gopageurl = $gopageurl;

		$this->firstPage = 1;

		$this->homePage = $this->NowPage - 1;
		$this->homePage = empty($this->homePage) ? 1 : $this->homePage;

		$this->nextPage = $this->NowPage + 1;

		$this->is_write = $is_write;
		$request_url = $this->request_url();
		if (!$this->is_write) {

			if (!isset($request_url)) {

				$pagerequest_url = $_SERVER[SCRIPT_NAME] . '?' . $_SERVER[QUERY_STRING];
			} else {
				$pagerequest_url = $request_url;
			}

			if ($_SERVER['SERVER_PORT'] == 80) {
				$this->pageUrl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER[SCRIPT_NAME];
			} else {
				$this->pageUrl = 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER[SCRIPT_NAME];
			}

			$this->Url = str_replace('?', '', strstr(preg_replace('/\^?page=\w*/', '', $pagerequest_url), '?'));
			if (substr($this->Url, 0, 1) == '&') {
				$this->Url = substr($this->Url, 1, strlen($this->Url));
			}
			$this->Urlid = !empty($this->Url) ? '&' : '';
		} else {

			if (!isset($request_url)) {

				$pagerequest_url = $_SERVER[SCRIPT_NAME] . '?' . $_SERVER[QUERY_STRING];
			} else {
				$pagerequest_url = $request_url;
			}

			if ($_SERVER['SERVER_PORT'] == 80) {
				$this->pageUrl = 'http://' . $_SERVER['SERVER_NAME'];
			} else {
				$this->pageUrl = 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
			}



			$this->Url = str_replace('.' . $this->file_fileex, '', $pagerequest_url);
		}

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
			if ($this->is_write) {
				$filename_first = $this->get_link($this->firstPage);
				$filename_home = $this->get_link($this->homePage);
			} else {
				$filename_first = $this->pageUrl . '?page=' . $this->firstPage . '&' . $this->Url;
				$filename_home = $this->pageUrl . '?page=' . $this->homePage . '&' . $this->Url;
			}
			$this->pageBotton1 = '<a class="p1" title="' . $this->PageListTitle[0] . '" href="' . $filename_first . '">' . $this->PageListTitle[0] . '</a>';
			$this->pageBotton1 .= '<a class="p1" title="' . $this->PageListTitle[1] . '" href="' . $filename_home . '">' . $this->PageListTitle[1] . '</a>';
		} else {
			$this->pageBotton1 = '<span class="current disabled">' . $this->PageListTitle[0] . '</span> <span class="current disabled">' . $this->PageListTitle[1] . '</span> ';
		}
		if ($this->NowPage < $this->Pageid) {
			if ($this->is_write) {
				$filename_nextPage = $this->get_link($this->nextPage);
				$filename_Pageid = $this->get_link($this->Pageid);
			} else {
				$filename_nextPage = $this->pageUrl . '?page=' . $this->nextPage . '&' . $this->Url;
				$filename_Pageid = $this->pageUrl . '?page=' . $this->Pageid . '&' . $this->Url;
			}
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
			if ($this->is_write) {
				$filename_first = $this->get_link($this->firstPage);
				$filename_home = $this->get_link($this->homePage);
			} else {
				$filename_first = $this->pageUrl . '?page=' . $this->firstPage . '&' . $this->Url;
				$filename_home = $this->pageUrl . '?page=' . $this->homePage . '&' . $this->Url;
			}
			$prevarray['t'] = '<a class="p1" title="' . $this->PageListTitle[0] . '" href="' . $filename_first . '">' . $this->PageListTitle[0] . '</a>';
			$prevarray['p'] = '<a class="p1" title="' . $this->PageListTitle[1] . '" href="' . $filename_home . '">' . $this->PageListTitle[1] . '</a>';
		} else {
			$prevarray['t'] = '<span class="current disabled">' . $this->PageListTitle[0] . '</span>';
			$prevarray['p'] = '<span class="current disabled">' . $this->PageListTitle[1] . '</span>';
		}
		if ($this->NowPage < $this->Pageid) {
			if ($this->is_write) {
				$filename_nextPage = $this->get_link($this->nextPage);
				$filename_Pageid = $this->get_link($this->Pageid);
			} else {
				$filename_nextPage = $this->pageUrl . '?page=' . $this->nextPage . '&' . $this->Url;
				$filename_Pageid = $this->pageUrl . '?page=' . $this->Pageid . '&' . $this->Url;
			}
			$prevarray['n'] = '<a class="p1" title="' . $this->PageListTitle[2] . '" href="' . $filename_nextPage . '">' . $this->PageListTitle[2] . '</a>';
			$prevarray['e'] .= '<a class="p1" title="' . $this->PageListTitle[3] . '" href="' . $filename_Pageid . '">' . $this->PageListTitle[3] . '</a>';
		} else {
			$prevarray['n'] = '<span class="current disabled">' . $this->PageListTitle[2] . '</span>';
			$prevarray['e'] = '<span class="current disabled">' . $this->PageListTitle[3] . '</span>';
		}
		return $prevarray;
	}

	public function Bottonstyle($pagebottonclass=true) {

		$for_end = ($this->Pageid > ($this->NowPage + $this->MaxHit)) ? ($this->NowPage + $this->MaxHit) : $this->Pageid;

		$for_begin = (($this->NowPage - $this->MaxHit) > 1) ? ($this->NowPage - $this->MaxHit) : 1;
		for ($i = $for_begin; $i <= $for_end; $i++) {
			if ($i == $this->NowPage) {
				$PageNumString.="<span class=\"current disabled\">$i</span> ";
			} else {
				if ($this->is_write) {
					$filename = $this->get_link($i);
				} else {
					$filename = $this->pageUrl . '?page=' . $i . '&' . $this->Url;
				}
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

	public function pageSelect() {
		if ($this->is_write) {
			$filename = $this->get_link('\'+parseInt(this.value)+\'');
		} else {
			$filename = $this->pageUrl . '?page=\'+parseInt(this.value)+\'&' . $this->Url;
		}
		$pageselect = '<select name="selectpageid" id="selectpageid" onchange="javascript:location.href=\'' . $filename . '\'">';
		for ($index = 1; $index <= $this->Pageid; $index++) {
			$selected = ($this->NowPage == $index) ? 'selected ' : '';
			$pageselect .= '<option ' . $selected . 'value="' . $index . '">' . $index . '</option>';
		}
		$pageselect.= '</select>';

		$pageselectBotton = str_replace("$1", $pageselect, $this->gopageurl);
		return $pageselectBotton;
	}

	function get_link($pageid=1) {
		$pagearray = explode('_', $this->Url);
		if (count($pagearray) >= 4) {
			$pagearray[3] = $pageid;
		} else {
			$pagearray[3] = $pageid;
		}
		$link = implode('_', $pagearray);

		$link = $this->pageUrl . $link . '.' . $this->file_fileex;
		return $link;
	}

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

}

?>