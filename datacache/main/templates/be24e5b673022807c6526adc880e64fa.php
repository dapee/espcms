<div class="fup1 margintop5"><span class="spantitle">产品搜索</span></div>
<div class="fcontent1">
	214adb21252b0af7b03s214s9search|mid:3,tid:5,att:1|60af7b03s21fs
	<form name="infosearch" method="post" action="<?php echo $this->_tpl_vars['link'] ?>">
	<input type="hidden" name="lng" value="<?php echo $this->_tpl_vars['lng'] ?>">
	<input type="hidden" name="mid" value="<?php echo $this->_tpl_vars['mid'] ?>">
	<table  class="formlist2">
		<tr>
			<td class="right">搜索关键字</td>
			<td><input id="keyword" name="keyword" type="text" class="infoInput" size="20"/></td>
		</tr>
		<?php if (count($this->_tpl_vars['searchatt'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['searchatt']); $list++){?>
			<tr>
				<td class="right"><?php echo $this->_tpl_vars['searchatt'][$list]['typename'] ?></td>
				<td>
					<?php if(($this->_tpl_vars['searchatt'][$list]['inputtype']=='select')){ ?>
					<select size="1" name="att[<?php echo $this->_tpl_vars['searchatt'][$list]['attrname'] ?>]" id="<?php echo $this->_tpl_vars['searchatt'][$list]['attrname'] ?>">
						<option value=""><?php echo $this->_tpl_vars['ST']['botton_select_name'] ?><?php echo $this->_tpl_vars['searchatt'][$list]['typename'] ?></option>
						<?php if (count($this->_tpl_vars['searchatt'][$list]['attrvalue'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['searchatt'][$list]['attrvalue']); $ii++){?>
						<option <?php echo $this->_tpl_vars['searchatt'][$list]['attrvalue'][$ii]['selected'] ?> value="<?php echo $this->_tpl_vars['searchatt'][$list]['attrvalue'][$ii]['name'] ?>"><?php echo $this->_tpl_vars['searchatt'][$list]['attrvalue'][$ii]['name'] ?></option>
						<?php }} ?>
					</select>
					<?php } elseif(($this->_tpl_vars['searchatt'][$list]['inputtype']=='radio')){ ?>
						<?php if (count($this->_tpl_vars['searchatt'][$list]['attrvalue'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['searchatt'][$list]['attrvalue']); $ii++){?>
						<input type="radio" value="att[<?php echo $this->_tpl_vars['searchatt'][$list]['attrvalue'][$ii]['name'] ?>]" name="<?php echo $this->_tpl_vars['searchatt'][$list]['attrname'] ?>" <?php if($this->_tpl_vars['searchatt'][$list]['attrvalue'][$ii]['selected']=='selected'){ ?>checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['searchatt'][$list]['attrvalue'][$ii]['name'] ?>&nbsp;
						<?php }} ?>
					<?php } elseif(($this->_tpl_vars['searchatt'][$list]['inputtype']=='checkbox')){ ?>
						<?php if (count($this->_tpl_vars['searchatt'][$list]['attrvalue'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['searchatt'][$list]['attrvalue']); $ii++){?>
						<input type="checkbox" value="att[<?php echo $this->_tpl_vars['searchatt'][$list]['attrvalue'][$ii]['name'] ?>]" name="<?php echo $this->_tpl_vars['searchatt'][$list]['attrname'] ?>[]"/> <?php echo $this->_tpl_vars['searchatt'][$list]['attrvalue'][$ii]['name'] ?>&nbsp;
						<?php }} ?>
					<?php }else{ ?>
						<input type="text" name="att[<?php echo $this->_tpl_vars['searchatt'][$list]['attrname'] ?>]" size="20" id="<?php echo $this->_tpl_vars['searchatt'][$list]['attrname'] ?>" value="<?php echo $this->_tpl_vars['searchatt'][$list]['attrvalue'] ?>" maxlength="<?php echo $this->_tpl_vars['searchatt'][$list]['attrlenther'] ?>" class="infoInput"/>
					<?php } ?>
				</td>
			</tr>
		<?php }} ?>
		<?php if(count($this->_tpl_vars['array'])){ ?>
		<tr>
			<td class="right">分类</td>
			<td>
				<select size="1" name="tid" class="select" id="tid">
					<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
					<option value="<?php echo $this->_tpl_vars['array'][$i]['tid'] ?>" title="<?php echo $this->_tpl_vars['array'][$i]['typename'] ?>"><?php if($this->_tpl_vars['array'][$i]['level']>1){ ?>├<?php } ?><?php echo $this->treelist($this->_tpl_vars['array'][$i]['level'],'─') ?> <?php echo $this->cutstr($this->_tpl_vars['array'][$i]['typename'],6) ?></option>
					<?php }} ?>
				</select>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td></td>
			<td><input name="submitsearch" type="submit" class="buttonface" value="开始搜索" /></td>
		</tr>
	</table>
	</form>
	214adb21252b0af7b03s214s9
</div>
<div class="fdown1"></div>

<div class="fup margintop5"><span class="spantitle">新闻推荐</span><span class="spanmone"><a class="morn" href="bbb4912cd04e6fd3type|4|linkbbb4912cd04e6fd3">更多新闻</a></span></div>
<div class="fcontent">
	<ul class="textlist">
	214adb21252b0af7b03s214s9list|mid:1,max:7|60af7b03s21fs
		<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
		<li><a class="infolist" title="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['title'] ?></a></li>
		<?php }} ?>
	214adb21252b0af7b03s214s9
	</ul>
</div>
<div class="fdown"></div>


<div class="fup margintop5"><span class="spantitle">TAG</span></div>
<div class="fcontent lineheight200">
	214adb21252b0af7b03s214s9tags|mid:1,max:10|60af7b03s21fs
		<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
		<a class="tag<?php echo $i+1 ?>"  title="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['title'] ?></a>
		<?php }} ?>
	214adb21252b0af7b03s214s9
</div>
<div class="fdown"></div>

<div class="fup2 margintop5"><span class="spantitle">订阅邮件</span></div>
<div class="fcontent1">
214adb21252b0af7b03s214s9invite|mlvid:1|60af7b03s21fs
<form name="inviteform" method="post" action="<?php echo $this->_tpl_vars['link'] ?>">
<input type="hidden" name="mlvid" value="<?php echo $this->_tpl_vars['read']['mlvid'] ?>">
<input type="hidden" name="lng" value="<?php echo $this->_tpl_vars['read']['lng'] ?>">
<table  class="formlist2">
	<tr>
		<td><input id="email" name="email" type="text" class="infoInput" size="20"/></td>
		<td><input name="submitsearch" type="submit" class="buttonface1" value="确认订阅" /></td>
	</tr>
</table>
</form>
214adb21252b0af7b03s214s9
</div>
<div class="fdown1"></div>