<?php
define('code1', '
<ul>
	[%forlist from=$array key=i%]
	<li class="bottonli"><a href="[%$array[i].link%]">[%$array[i].title%]</a></li>
	[%/forlist%]
</ul>
');

define('code2', '[%beark name=subtype filename=$filename class=$lng,$1%]');

if (isset($modulesid) && $modulesid == TRUE) {
	$i = isset($modules) ? count($modules) : 0;
	$modules[$i]['plugname'] = '专题(品牌)分类列表输出';

	$modules[$i]['code'] = basename(__FILE__, '.php');
	$modules[$i]['desc'] = '用于专题（品牌）分类列表显示，<a class="infolink05" target="_blank" href="http://www.ecisp.cn/chm/k20.html">点击参考标签说明</a>';
	$modules[$i]['lng'] = '1';
	$modules[$i]['mid'] = '1';
	$modules[$i]['sid'] = '0';
	$modules[$i]['tid'] = '0';
	$modules[$i]['dlid'] = '0';

	$modules[$i]['config'] = array(
	    array('botname' => '调用显示方式', 'name' => 'codetype', 'type' => 'select', 'value' => '0', 'str' => '如选择列表，请修改相应的Lib文件夹模板', 'sevalue' => array(0 => '调用模板片段（适用于页面的调用）', 1 => '专题片段代码')),
	    array('botname' => '自定模板文件名', 'name' => 'filename', 'type' => 'text', 'value' => '', 'str' => '可选项，仅填写lib文件夹中的文件名，如为空默认为：subtype'),
	);
	return;
}

class subtype {










	function get_code($lng, $mid, $tid, $sid, $dlid, $newArray=array(), $otherarray=array()) {
		if ($newArray[0]['codetype'] == 0) {
			$str = code2;
			if (!empty($newArray[1]['filename'])) {
				$str = str_replace(' filename=$filename', ' filename=' . $newArray[1]['filename'], $str);
			} else {
				$str = str_replace(' filename=$filename', '', $str);
			}

			if ($mid) {
				$str = str_replace('$1', $mid, $str);
			} else {
				return false;
			}
		} else if ($newArray[0]['codetype'] == 1) {
			$str = code1;
		}
		return $str;
	}

}
?>