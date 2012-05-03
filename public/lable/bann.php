<?php
define('code1', '
[%if $filetype == 1 %]
[%if $countnum <= 1 %]
	[%forlist from=$array key=i%]
	<a alt="[%$array[i].title%]" target="_blank" href="[%$array[i].link%]"><img title="[%$array[i].title%]" border="0" src="[%$url%][%$array[i].pic%]"></a>
	[%/forlist%]
[%else%]
	<script type="text/javascript">
	AC_FL_RunContent( \'codebase\',\'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\',\'width\',\'[%$type.width%]\',\'height\',\'[%$type.height%]\',\'movie\',\'[%$url%]public/bcastr\',\'quality\',\'high\',\'wmode\',\'transparent\',\'flashvars\',\'bcastr_file=[%forlist from=$array key=i%][%$url%][%$array[i].pic%][%if key=>i < $array[i].num%]|[%/if%][%/forlist%]&bcastr_link=[%forlist from=$array key=i%][%$array[i].link%][%if key=>i < $array[i].num%]|[%/if%][% /forlist %]&bcastr_config=0x008000:fontcolor|4:fontform|0x008000:fontbgcolor|0:fonttouming|0xffffff:anjiancolor|0x008000:bottoncolor|0x000033:nowbottoncolor|5:palytime|3:picclass|1:botton|_blank:winodws\' );
	</script>
[%/if%]
[%/if%]

[%if $filetype == 2 %]
[%forlist from=$array key=i%]
<object classid="clsid:D27CDB6E-AE6D-11CF-96B8-444553540000" id="obj1" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" border="0" width="[%$array[i].width%]" height="[%$array[i].height%]">
    <param name="movie" value="[%$array[i].pic%]">
    <param name="quality" value="High">
    <param name="menu" value="false">
    <param name="wmode" value="transparent">
    <embed wmode="Opaque" src="[%$array[i].pic%]" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="obj1" width="[%$array[i].width%]" height="[%$array[i].height%]" quality="High" menu="false"></object>
[%/forlist%]
[%/if%]

[%if $filetype == 3 %]
<ul>
	[%forlist from=$array key=i%]
	<li><a title="[%$array[i].title%]" target="_blank" href="[%$array[i].link%]">[%$array[i].ctitle%]</a></li>
	[%/forlist%]
</ul>
[%/if%]

[%if $filetype == 4 %]
<ul>
	[%forlist from=$array key=i%]
	<a title="[%$array[i].title%]" target="_blank" href="[%$array[i].link%]"><img title="[%$array[i].title%]" border="0" src="[%$url%][%$array[i].pic%]"></a>
	[%/forlist%]
</ul>
[%/if%]
');

define('code2', '[%beark name=bann filename=$filename class=$lng,$1,$2,$3,$4,$5%]');

if (isset($modulesid) && $modulesid == TRUE) {
	$i = isset($modules) ? count($modules) : 0;
	$modules[$i]['plugname'] = '广告形式内容输出';

	$modules[$i]['code'] = basename(__FILE__, '.php');
	$modules[$i]['desc'] = '用于flash幻灯片、友情链接、文字链等广告形式的内容输出，<a class="infolink05" target="_blank" href="http://www.ecisp.cn/chm/k16.html">点击参考标签说明</a>，<a class="infolink05" target="_blank" href="http://www.ecisp.cn/chm/k7.html">点击参数内容字段说明</a>';
	$modules[$i]['lng'] = '1';
	$modules[$i]['mid'] = '1';
	$modules[$i]['sid'] = '0';
	$modules[$i]['tid'] = '1';
	$modules[$i]['dlid'] = '1';

	$modules[$i]['config'] = array(
	    array('botname' => '标签类型', 'name' => 'codetype', 'type' => 'select', 'value' => '0', 'str' => '如选择列表，请修改相应的Lib文件夹模板',
		'sevalue' => array(0 => '调用模板片段（适用于页面的调用）', 1 => '广告内容显示片段代码')),
	    array('botname' => '自定模板文件名', 'name' => 'filename', 'type' => 'text', 'value' => '', 'str' => '可选项，仅填写lib文件夹中的文件名，如为空默认为：bann'),
	    array('botname' => '广告显示类型', 'name' => 'banntype', 'type' => 'select', 'value' => '0', 'str' => '',
		'sevalue' => array(0 => '幻灯图片', 1 => 'Flash广告', 2 => '纯文字，常用于友情链接', 3 => '纯图片')),
	    array('botname' => '最大显示数量', 'name' => 'hit', 'type' => 'text', 'value' => '0', 'str' => '可选项，如果值未填或0，则默认为20条！'),
	);
	return;
}

class bann {










	function get_code($lng, $mid, $tid, $sid, $dlid, $newArray=array(), $otherarray=array()) {
		if ($newArray[0]['codetype'] == 0) {
			if (empty($lng) || empty($mid)) {
				return false;
			}
			$str = code2;

			if (!empty($newArray[1]['filename'])) {
				$str = str_replace(' filename=$filename', ' filename=' . $newArray[1]['filename'], $str);
			} else {
				$str = str_replace(' filename=$filename', '', $str);
			}
			if (!empty($mid)) {
				$str = str_replace('$1', $mid, $str);
			}
			if (!empty($dlid)) {
				$str = str_replace('$2', $dlid, $str);
			} else {
				$str = str_replace('$2', 0, $str);
			}
			if (!empty($tid)) {
				$str = str_replace('$3', $tid, $str);
			} else {
				$str = str_replace('$3', 0, $str);
			}
			$banntype = $newArray[2]['banntype'] + 1;
			$str = str_replace('$4', $banntype, $str);
			if ($newArray[3]['hit'] > 0) {
				$str = str_replace('$5', $newArray[3]['hit'], $str);
			} else {
				$str = str_replace(',$5', '', $str);
			}
		} else if ($newArray[0]['codetype'] == 1) {
			$str = code1;
		}
		return $str;
	}

}
?>