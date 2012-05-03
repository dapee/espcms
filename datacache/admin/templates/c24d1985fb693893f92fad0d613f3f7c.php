<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
<div class="infolist" title="<?php echo $this->_tpl_vars['array'][$list]['username'] ?>">
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
		<tr>
			<td width="10%"><?php echo $this->_tpl_vars['array'][$list]['id'] ?></td>
			<td width="20%"><?php echo $this->_tpl_vars['array'][$list]['username'] ?></td>
			<td width="10%" class="colorgorning2"><?php echo $this->timeformat($this->_tpl_vars['array'][$list]['addtime'],3) ?></td>
			<td width="10%" class="colorgorning2"><?php echo $this->ip($this->_tpl_vars['array'][$list]['onlineip'],0) ?></td>
			<td width="10%"><?php echo $this->_tpl_vars['array'][$list]['actions'] ?></td>
			<td width="40%" id="left" class="padding-left5"><?php echo $this->cutstr($this->_tpl_vars['array'][$list]['remarks'],30,'') ?></td>
		</tr>
	</table>
</div>
<?php }} ?>
<?php }else{ ?>
<div class="infolist">
<table>
	<tr>
	    <td align="center"><?php echo $this->_tpl_vars['ST']['list_nothing_title'] ?></td>
	</tr>
</table>
</div>
<?php } ?>