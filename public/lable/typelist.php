<?php
define('code1', '
<ul>
[%forlist from=$array key=i%]
    <li>
	     [%if $array[i].tid == $nowtid%]
		 [%if $array[i].level>1%]└[%$array[i].level|treelist(\'─\')%][%/if%] <b><a href="[%$array[i].link%]">[%$array[i].typename%]</a></b>
	     [%else%]
		 [%if $array[i].level>1%]└[%$array[i].level|treelist(\'─\')%][%/if%] <a href="[%$array[i].link%]">[%$array[i].typename%]</a>
	     [%/if%]
    </li>
[%/forlist%]
</ul>

');

define('code2', '[%beark name=typelist filename=$filename class=$lng,$1,$type.tid%]');

if (isset($modulesid) && $modulesid == TRUE) {
	$i = isset($modules) ? count($modules) : 0;
	$modules[$i]['plugname'] = '内容分类列表输出';

	$modules[$i]['code'] = basename(__FILE__, '.php');
	$modules[$i]['desc'] = '用于内容分类列表显示（产品、新闻等），<a class="infolink05" target="_blank" href="http://www.ecisp.cn/chm/typelist.html">点击参考标签说明</a>，<a class="infolink05" target="_blank" href="http://www.ecisp.cn/chm/k6.html">点击参数分类字段说明</a>';
	$modules[$i]['lng'] = '1';
	$modules[$i]['mid'] = '1';
	$modules[$i]['sid'] = '0';
	$modules[$i]['tid'] = '1';
	$modules[$i]['dlid'] = '0';

	$modules[$i]['config'] = array(
	    array('botname' => '调用显示方式', 'name' => 'codetype', 'type' => 'select', 'value' => '0', 'str' => '如选择列表，请修改相应的Lib文件夹模板', 'sevalue' => array(0 => '调用模板片段（适用于页面的调用）', 1 => '内容分类片段代码')),
	    array('botname' => '自定模板文件名', 'name' => 'filename', 'type' => 'text', 'value' => '', 'str' => '可选项，仅填写lib文件夹中的文件名，如为空默认为：typelist'),
	    array('botname' => '所属分类关联类型', 'name' => 'type', 'type' => 'select', 'value' => '1', 'str' => '如固定参数，则所属分类选项无效',
		'sevalue' => array(0 => '固定参数（显示指定所属分类的子分类）', 1 => '可变参数（显示当前分类的所有平级分类及子分类）', 2 => '可变参数（显示当前分类的子分类）', 3 => '可变参数（显示当前分类所属顶级分类的子分类）')),
	);
	return;
}

class typelist {










	function get_code($lng, $mid, $tid, $sid, $dlid, $newArray=array(), $otherarray=array()) {
		if ($newArray[0]['codetype'] == 0) {
			$str = code2;
			if (!empty($newArray[1]['filename'])) {
				$str = str_replace(' filename=$filename', ' filename=' . $newArray[1]['filename'], $str);
			} else {
				$str = str_replace(' filename=$filename', '', $str);
			}

			if ($newArray[2]['type'] == 1) {
				$str = str_replace('$1', '$type.upid', $str);
			} elseif ($newArray[2]['type'] == 2) {
				$str = str_replace('$1', '$type.tid', $str);
			} elseif ($newArray[2]['type'] == 0 && !empty($tid)) {
				$str = str_replace('$1', $tid, $str);
			} elseif ($newArray[2]['type'] == 3) {
				$str = str_replace('$1', '$type.topid', $str);
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