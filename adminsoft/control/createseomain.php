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

	function oncreateseo() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$file_sitemapdir = $this->CON['file_sitemapdir'];
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->assign('htmldir', $file_sitemapdir);
		$this->ectemplates->display('creat/creat_seo');
	}

	function onseosave() {
		$priority = $this->fun->accept('priority', 'R');
		$changefreq = $this->fun->accept('changefreq', 'R');
		$linknum = $this->fun->accept('linknum', 'R');
		$linknum = empty($linknum) ? 50 : $linknum;

		$is_html = $this->CON['is_html'];

		$file_fileex = $this->CON['file_fileex'];

		$file_htmldir = $this->CON['file_htmldir'];

		$file_sitemapdir = $this->CON['file_sitemapdir'];
		$url = admin_URL . $file_htmldir;
		$xmlfile = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$xmlfile.='<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/09/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
		$db_where = ' WHERE isclass=1 AND islink=0 ORDER BY pid,did desc LIMIT 0,' . $linknum;
		$db_table = db_prefix . 'document';
		$sql = 'SELECT * FROM ' . $db_table . $db_where;
		$rs = $this->db->query($sql);
		while ($rsList = $this->db->fetch_assoc($rs)) {
			$link = $this->get_link('doc', $rsList, $rsList['lng'], 0, 1);
			$addtime = $this->fun->formatdate($rsList['uptime'], 2);
			$xmlfile.="\x20\x20\x20\x20<url>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<loc>$link</loc>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<lastmod>$addtime</lastmod>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<changefreq>$changefreq</changefreq>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<priority>$priority</priority>\n";
			$xmlfile.="\x20\x20\x20\x20</url>\n";
		}
		$xmlfile .= '</urlset>';
		$commandfile = admin_ROOT . $file_sitemapdir . '/googlesitemap.xml';

		if ($this->fun->filemode(admin_ROOT . $file_sitemapdir)) {

			if (!is_dir(admin_ROOT . $file_sitemapdir)) {
				if (!@mkdir(admin_ROOT . $file_sitemapdir, 0777, true)) {

					exit($file_sitemapdir . $this->lng['createmain_creat_no_w']);
				}
			}
		} else {
			exit($file_sitemapdir . $this->lng['createmain_creat_no_w']);
		}
		if (!$this->fun->filewrite($commandfile, $xmlfile)) {
			exit($this->lng['createmain_creat_no'] . $file_sitemapdir . '/googlesitemap.xml');
		} else {
			exit('true');
		}
	}

	function oncreaterss() {
		parent::start_template();
		$tab = $this->fun->accept('tab', 'R');
		$tab = empty($tab) ? 'true' : $tab;

		$mid = $this->fun->accept('mid', 'R');
		$mid = empty($mid) ? 0 : $mid;
		$lng = $this->sitelng;
		$lng = empty($lng) ? ($this->CON['is_alonelng'] && !empty($this->CON['home_lng'])) ? $this->CON['home_lng'] : $this->CON['default_lng']  : $lng;

		$lnglist = $this->get_lng_array($lng);
		$this->ectemplates->assign('lnglist', $lnglist['list']);

		$modelarray = $this->get_model(0, $lng, 1, 2);
		$this->ectemplates->assign('modelarray', $modelarray['list']);
		$this->ectemplates->assign('tab', $tab);
		$this->ectemplates->display('creat/creat_rss');
	}

	function onrsssave() {
		$mid = $this->fun->accept('mid', 'R');
		$lng = $this->fun->accept('lng', 'R');
		$tid = $this->fun->accept('tid', 'R');
		$creattype = $this->fun->accept('creattype', 'R');
		$pnumber = $this->fun->accept('pnumber', 'R');
		$pnumber = empty($pnumber) ? 20 : $pnumber;
		$typelist = $this->get_typeid($tid, '', 0, $mid, 0, $lng, 0, 1, 'text');
		$typearray = explode(',', $typelist);

		$domain = $this->CON['domain'];

		$is_html = $this->CON['is_html'];

		$file_fileex = $this->CON['file_fileex'];

		$file_htmldir = $this->CON['file_htmldir'];

		$file_sitemapdir = $this->CON['file_sitemapdir'];

		$lanpackfile = admin_ROOT . 'datacache/' . $lng . '_pack.php';
		if (!is_file($lanpackfile)) {

			$this->creat_lanpack($lng, true);
		}

		if ($this->fun->filemode(admin_ROOT . $file_sitemapdir)) {

			if (!is_dir(admin_ROOT . $file_sitemapdir)) {
				if (!@mkdir(admin_ROOT . $file_sitemapdir, 0777, true)) {

					exit($file_sitemapdir . $this->lng['createmain_creat_no_w']);
				}
			}
		} else {
			exit($file_sitemapdir . $this->lng['createmain_creat_no_w']);
		}

		include_once $lanpackfile;
		$url = admin_URL . $file_htmldir;
		$db_table = db_prefix . 'document';
		foreach ($typearray as $key => $value) {
			$xmlfile = null;

			$typeread = $this->get_type($value);

			$dirname = $typeread['dirname'];

			$filename = $file_sitemapdir . '/rss_' . $dirname . '.xml';
			$commandfile = admin_ROOT . $filename;
			$rssurl = admin_URL . $filename;
			$xmlfile = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			$xmlfile.='<rss version="2.0">' . "\n";
			$xmlfile.="\x20\x20\x20\x20<channel>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<title>$LANPACK[sitename]-$typeread[typename]</title>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<image>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<title>$url</title>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<link>$url</link>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<url>$url</url>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20</image>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<description>$typeread[content]</description>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<link>$domain</link>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<language>utf-8</language>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<docs>$rssurl</docs>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<generator>$domain</generator>\n";
			$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<copyright>$LANPACK[copyright]</copyright>\n";
			$db_where = " WHERE isclass=1 AND islink=0 AND " . $this->get_typeid($value, 'tid', 0, $mid, 0, $lng, 0, 1);
			$sql = 'SELECT * FROM ' . $db_table . $db_where . ' ORDER BY pid,did desc LIMIT 0,' . $pnumber;
			$rs = $this->db->query($sql);
			while ($rsList = $this->db->fetch_assoc($rs)) {
				$link = $this->get_link('doc', $rsList, $rsList['lng'], 0, 1);
				$addtime = $this->fun->formatdate($rsList['uptime'], 3);
				$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20<item>\n";
				$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<title><![CDATA[$rsList[title]]]></title>\n";
				$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<link><![CDATA[$link]]></link>\n";
				$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<description><![CDATA[$rsList[description]]]></description>\n";
				$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<pubDate>$addtime</pubDate>\n";
				$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<source><![CDATA[$rsList[source]]]></source>\n";
				$xmlfile.="\x20\x20\x20\x20\x20\x20\x20\x20</item>\n";
			}
			$xmlfile .= "\x20\x20\x20\x20</channel>\n";
			$xmlfile .= '</rss>';
			$this->fun->filewrite($commandfile, $xmlfile);
		}
		exit('true');
	}

}

?>
