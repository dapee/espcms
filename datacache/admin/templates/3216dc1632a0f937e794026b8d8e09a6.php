<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
<div class="infolist" onselectstart="return false;" title="<?php echo $this->_tpl_vars['array'][$list]['username'] ?>-<?php echo $this->_tpl_vars['array'][$list]['powername'] ?>" <?php if($this->powercheck('system','groupedit')==true ){ ?><?php if($this->_tpl_vars['array'][$list]['delclass']==0){ ?>ondblClick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['powername'],'hc') ?><?php echo $this->_tpl_vars['ST']['grouplist_edit_title'] ?>','index.php?archive=powergroup&action=groupedit&id=<?php echo $this->_tpl_vars['array'][$list]['id'] ?>&copytype=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,'group<?php echo $this->_tpl_vars['array'][$list]['id'] ?>',self.frameElement.getAttribute('name'));"<?php } ?><?php } ?>>
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
		<tr>
			<td width="10%">
				<?php if($this->_tpl_vars['array'][$list]['delclass']==0){ ?>
				<input type="checkbox" name="selectinfoid" value="<?php echo $this->_tpl_vars['array'][$list]['id'] ?>">
				<?php } ?>
			</td>
			<td width="10%"><?php echo $this->_tpl_vars['array'][$list]['id'] ?></td>
			<td width="60%"><?php echo $this->_tpl_vars['array'][$list]['powername'] ?></td>
			<td width="10%" id="infotype">
				<table>
					<tr>
						<td><?php if($this->_tpl_vars['array'][$list]['delclass']==0){ ?><span class="select_ok" title="<?php echo $this->_tpl_vars['ST']['grouplist_audit_ok'] ?>"></span><?php }else{ ?><span class="select_no" title="<?php echo $this->_tpl_vars['ST']['grouplist_audit_no'] ?>"></span><?php } ?></td>
					</tr>
				</table>
			</td>
			<td width="10%" id="infotype">
				<?php if($this->powercheck('system','groupedit')==true ){ ?>
				<table>
					<tr>
						<td>
						<?php if($this->_tpl_vars['array'][$list]['delclass']==0){ ?>
							<a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['powername'],'hc') ?><?php echo $this->_tpl_vars['ST']['grouplist_edit_title'] ?>','index.php?archive=powergroup&action=groupedit&id=<?php echo $this->_tpl_vars['array'][$list]['id'] ?>&copytype=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'group<?php echo $this->_tpl_vars['array'][$list]['id'] ?>',self.frameElement.getAttribute('name'));" id="group<?php echo $this->_tpl_vars['array'][$list]['id'] ?>" href="#body" title="<?php echo $this->_tpl_vars['ST']['grouplist_edit_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setedit_botton'] ?></a>
						<?php }else{ ?>
						<?php echo $this->_tpl_vars['ST']['grouplist_sys_mess'] ?>
						<?php } ?>
						</td>
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