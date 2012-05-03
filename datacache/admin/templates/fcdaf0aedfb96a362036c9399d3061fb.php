<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
<div class="infolist" onselectstart="return false;" title="<?php echo $this->_tpl_vars['array'][$list]['keywordname'] ?>" <?php if($this->powercheck('marketing','keylinkedit')==true ){ ?>ondblClick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['keywordname'],'hc') ?><?php echo $this->_tpl_vars['ST']['seomanage_edit_title'] ?>','index.php?archive=seomanage&action=keylinkedit&id=<?php echo $this->_tpl_vars['array'][$list]['kid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,'keylink<?php echo $this->_tpl_vars['array'][$list]['kid'] ?>',self.frameElement.getAttribute('name'));"<?php } ?>>
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
		<tr>
			<td width="5%"><input type="checkbox" name="selectinfoid" value="<?php echo $this->_tpl_vars['array'][$list]['kid'] ?>"></td>
			<td width="10%">
				<input type="hidden" name="infoid" id="infoid" value="<?php echo $this->_tpl_vars['array'][$list]['kid'] ?>">
				<input type="text" name="pid" size="3" value="<?php echo $this->_tpl_vars['array'][$list]['pid'] ?>" class="infoInput" >
			</td>
			<td width="10%"><?php echo $this->_tpl_vars['array'][$list]['kid'] ?></td>
			<td width="30%"><?php echo $this->_tpl_vars['array'][$list]['keywordname'] ?></td>
			<td width="15%"><?php echo $this->_tpl_vars['array'][$list]['hit'] ?></td>
			<td width="10%"><?php if($this->_tpl_vars['array'][$list]['islink']==1){ ?><?php echo $this->_tpl_vars['ST']['seomanage_islink_ok'] ?><?php }else{ ?><?php echo $this->_tpl_vars['ST']['seomanage_islink_no'] ?><?php } ?></td>
			<td width="10%"><?php if($this->_tpl_vars['array'][$list]['istop']==1){ ?><?php echo $this->_tpl_vars['ST']['seomanage_audit_ok'] ?><?php }else{ ?><?php echo $this->_tpl_vars['ST']['seomanage_audit_no'] ?><?php } ?></td>
			<td width="10%" id="infotype">
				<?php if($this->powercheck('marketing','keylinkedit')==true ){ ?>
				<table>
					<tr>
						<td><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['keywordname'],'hc') ?><?php echo $this->_tpl_vars['ST']['seomanage_edit_title'] ?>','index.php?archive=seomanage&action=keylinkedit&id=<?php echo $this->_tpl_vars['array'][$list]['kid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'keylink<?php echo $this->_tpl_vars['array'][$list]['kid'] ?>',self.frameElement.getAttribute('name'));" id="keylink<?php echo $this->_tpl_vars['array'][$list]['kid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['ST']['setedit_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setedit_botton'] ?></a></td>
					</tr>
				</table>
				<?php } ?>
			</td>
		</tr>
	</table>
</div>
<?php }} ?>
<?php }else{ ?>
<div class="infolist">
<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
	<tr>
	    <td align="center"><?php echo $this->_tpl_vars['ST']['list_nothing_title'] ?></td>
	</tr>
</table>
</div>
<?php } ?>