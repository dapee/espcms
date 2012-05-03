<?php
define('code1', '
<table>
[%forlist from=$array key=i%]
<tr>
	<td><span class="names">[%$array[i].addtime|timeformat($timetype)%]</span><a target="_blank" title="[%$array[i].title%]" href="[%$array[i].link%]">[%$array[i].ctitle|cutstr($cutnum)%]</a></td>
</tr>
[%/forlist%]
</table>
');

define('code2', '[%beark name=list filename=$filename class=$lng,$1,$2,$3,$4,$5,$6,$7,$8,$9,$a10%]');

define('code3', '
<table>
[%forlist from=$array key=i%]
	<tr>
		<td><a target="_blank" title="[%$array[i].title%]" href="[%$array[i].link%]"><img src="[%$array[i].pic%]" alt="[%$array[i].title%]" width="150" height="150"/></a></td>
		<td><h3><a target="_blank" title="[%$array[i].title%]" href="[%$array[i].link%]">[%$array[i].ctitle|cutstr($cutnum)%]</a></h3><br><p>[%$array[i].description|cutstr(38,\'…\')%]<a target="_blank" title="[%$array[i].title%]" href="[%$array[i].link%]">【详细】</a></p></td>
	</tr>
[%/forlist%]
</table>
');

if (isset($modulesid) && $modulesid == TRUE) {
	$i = isset($modules) ? count($modules) : 0;
	$modules[$i]['plugname'] = '内容列表形式输出';

	$modules[$i]['code'] = basename(__FILE__, '.php');
	$modules[$i]['desc'] = '用于所有内容的输出（如文章、新闻、产品等），<a class="infolink05" target="_blank" href="http://www.ecisp.cn/chm/k15.html">点击参考标签说明</a>，<a class="infolink05" target="_blank" href="http://www.ecisp.cn/chm/k7.html">点击参数内容字段说明</a>';
	$modules[$i]['lng'] = '1';
	$modules[$i]['mid'] = '1';
	$modules[$i]['sid'] = '1';
	$modules[$i]['tid'] = '1';
	$modules[$i]['dlid'] = '1';

	$modules[$i]['config'] = array(
	    array('botname' => '调用显示方式', 'name' => 'codetype', 'type' => 'select', 'value' => '0', 'str' => '如选择列表，请修改相应的Lib文件夹模板', 'sevalue' => array(0 => '调用模板片段（适用于页面的调用）', 1 => '列表显示片段代码（文字列表）', 2 => '列表显示片段代码（图文混排）')),
	    array('botname' => '自定模板文件名', 'name' => 'filename', 'type' => 'text', 'value' => '', 'str' => '可选项，仅填写lib文件夹中的文件名，如为空默认为：list'),
	    array('botname' => '最大显示数量', 'name' => 'hit', 'type' => 'text', 'value' => '0', 'str' => '可选项，如果值未填或0，则默认为20条！'),
	    array('botname' => '内容排序方式', 'name' => 'order', 'type' => 'select', 'value' => '0', 'str' => '可选项', 'sevalue' => array(0 => '默认（按排序和发布时间）', 1 => '按点击数进行排列')),
	    array('botname' => '标题字符数', 'name' => 'm7', 'type' => 'text', 'value' => '0', 'str' => '可选项，如果为0或空，则表示显示全部标题字符！需相关函数支持，<a class="infolink05" target="_blank" href="http://www.ecisp.cn/chm/k10.html">点击参考</a>'),
	    array('botname' => '显示日期格式', 'name' => 'm8', 'type' => 'select', 'value' => '0', 'str' => '需相关函数支持，<a class="infolink05" target="_blank" href="http://www.ecisp.cn/chm/k11.html">点击参考</a>',
		'sevalue' => array(
		    0 => '默认显示方式（显示年月日小时分秒 2012-01-01 13:21:01）',
		    1 => '显示小时分秒：13:21:01 ',
		    2 => '显示年月日：2012-01-01 ',
		    3 => '显示年月日小时分秒：2012-01-01 13:21:01 ',
		    4 => '显示年月日小时分：2012-01-01 13:21',
		    5 => '显示月日小时分:01-01 13:21 ',
		    6 => '显示月日：01-01 ',
		    7 => '显示单数年月日：2012-1-1 ',
		    8 => '显示单数年月日小时分秒：2012-1-1 13:21:1 ',
		    9 => '显示单数年月日小时分:2012-1-1 13:01 ',
	    )),
	    array('botname' => '是否转递当前内容ID', 'name' => 'nowdid', 'type' => 'select', 'value' => '0', 'str' => '用于判断是否显示当前内容', 'sevalue' => array(0 => '否', 1 => '是')),
	    array('botname' => '是否匹配相关内容', 'name' => 'linkdid', 'type' => 'select', 'value' => '0', 'str' => '用于内容阅读时显示相关内容列表', 'sevalue' => array(0 => '否', 1 => '是')),
	);
	return;
}

class infolist {










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
			if (!empty($sid)) {
				$str = str_replace('$4', $sid, $str);
			} else {
				$str = str_replace('$4', 0, $str);
			}
			if ($newArray[7]['linkdid']) {
				$str = str_replace('$5', '$read.linkdid', $str);
			} else {
				$str = str_replace('$5', 0, $str);
			}
			if ($newArray[2]['hit']) {
				$str = str_replace('$6', $newArray[2]['hit'], $str);
			} else {
				$str = str_replace('$6', 0, $str);
			}

			if ($newArray[3]['order']) {
				$str = str_replace('$7', 'h', $str);
			} else {
				$str = str_replace('$7', 0, $str);
			}

			if ($newArray[4]['m7']) {
				$str = str_replace('$8', $newArray[4]['m7'], $str);
			} else {
				$str = str_replace('$8', 0, $str);
			}
			if ($newArray[5]['m8']) {
				$str = str_replace('$9', $newArray[5]['m8'], $str);
			} else if (empty($newArray[6]['nowdid']) && empty($newArray[5]['m8'])) {
				$str = str_replace(',$9,$a10', '', $str);
			} else {
				$str = str_replace('$9', 0, $str);
			}
			if ($newArray[6]['nowdid']) {
				$str = str_replace('$a10', '$read.did', $str);
			} else {
				$str = str_replace(',$a10', '', $str);
			}
		} else if ($newArray[0]['codetype'] == 1) {
			$str = code1;
		} else if ($newArray[0]['codetype'] == 2) {
			$str = code3;
		}
		return $str;
	}

}
?>