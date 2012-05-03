<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
<div class="infolist" onselectstart="return false;" title="<?php echo $this->_tpl_vars['array'][$list]['username'] ?>-<?php echo $this->_tpl_vars['array'][$list]['powername'] ?>" <?php if($this->powercheck('system','manageedit')==true ){ ?>ondblClick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['mangerlist_edit_title'] ?>','index.php?archive=management&action=manageedit&id=<?php echo $this->_tpl_vars['array'][$list]['id'] ?>&copytype=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,true);"<?php } ?>>
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
		<tr>
			<td width="4%"><input type="checkbox" name="selectinfoid" value="<?php echo $this->_tpl_vars['array'][$list]['id'] ?>"></td>
			<td width="6%"><?php echo $this->_tpl_vars['array'][$list]['id'] ?></td>
			<td width="15%"><?php echo $this->_tpl_vars['array'][$list]['username'] ?></td>
			<td width="13%"><?php echo $this->_tpl_vars['array'][$list]['name'] ?></td>
			<td width="10%"><?php echo $this->_tpl_vars['array'][$list]['powername'] ?></td>
			<td width="14%"><?php echo $this->timeformat($this->_tpl_vars['array'][$list]['intotime'],3) ?></td>
			<td width="5%"><?php echo $this->_tpl_vars['array'][$list]['hit'] ?></td>
			<td width="10%"><?php echo $this->ip($this->_tpl_vars['array'][$list]['ipadd'],0) ?></td>
			<td width="7%" id="infotype">
				<table>
					<tr>
						<td><?php if($this->_tpl_vars['array'][$list]['inputclassid']==1){ ?><span class="class_ok" title="<?php echo $this->_tpl_vars['ST']['inputtype_botton'] ?>:<?php echo $this->_tpl_vars['ST']['mangerlist_inputclassid_1'] ?>"></span><?php }else{ ?><span class="class_no" title="<?php echo $this->_tpl_vars['ST']['inputtype_botton'] ?>:<?php echo $this->_tpl_vars['ST']['mangerlist_inputclassid_0'] ?>"></span><?php } ?></td>
						<td><?php if($this->_tpl_vars['array'][$list]['isclass']==1){ ?><span class="audit_ok" title="<?php echo $this->_tpl_vars['ST']['mangerlist_user_type'] ?>：<?php echo $this->_tpl_vars['ST']['mangerlist_audit_ok'] ?>"></span><?php }else{ ?><span class="audit_no" title="<?php echo $this->_tpl_vars['ST']['mangerlist_user_type'] ?>：<?php echo $this->_tpl_vars['ST']['mangerlist_audit_no'] ?>"></span><?php } ?></td>
					</tr>
				</table>
			</td>
			<td width="16%" id="infotype">
				<?php if($this->powercheck('system','manageedit')==true ){ ?>
				<table>
					<tr>
						<td><a class="setedit3" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['username'],'hc') ?><?php echo $this->_tpl_vars['ST']['mangerlist_set_loglist'] ?>','index.php?archive=management&action=list&listfunction=loglist&logusername=<?php echo $this->_tpl_vars['array'][$list]['username'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,'managerloglist<?php echo $this->_tpl_vars['array'][$list]['id'] ?>',self.frameElement.getAttribute('name'));" id="managerloglist<?php echo $this->_tpl_vars['array'][$list]['id'] ?>" href="#body" title="<?php echo $this->_tpl_vars['ST']['mangerlist_set_loglist'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mangerlist_set_loglist'] ?></a></td>
						<td class="padding-left3"><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['mangerlist_edit_title'] ?>','index.php?archive=management&action=manageedit&id=<?php echo $this->_tpl_vars['array'][$list]['id'] ?>&copytype=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,true);" href="#body" title="<?php echo $this->_tpl_vars['ST']['mangerlist_edit_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setedit_botton'] ?></a></td>
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