<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
<div class="infolist" title="<?php echo $this->_tpl_vars['array'][$list]['templatename'] ?> - <?php echo $this->_tpl_vars['array'][$list]['title'] ?>" <?php if($this->powercheck('templates','mailtemplateedit')==true ){ ?>ondblClick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['mailtemplatemain_edit_title'] ?>','index.php?archive=mailtemplatemain&action=mailtemplateedit&tmid=<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>&type=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,'mailtempedit<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>',self.frameElement.getAttribute('name'));"<?php } ?>>
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
		<tr>
			<td width="7%"><?php echo $this->_tpl_vars['array'][$list]['tmid'] ?></td>
			<td width="5%"><?php echo $this->_tpl_vars['array'][$list]['lng'] ?></td>
			<td width="28%"><?php echo $this->cutstr($this->_tpl_vars['array'][$list]['templatename'],10) ?></td>
			<td width="15%"><?php echo $this->_tpl_vars['array'][$list]['templatecode'] ?></td>
			<td width="17%"><?php echo $this->_tpl_vars['array'][$list]['typeclass'] ?></td>
			<td width="8%" id="infotype">
				<table>
					<tr>
						<td><?php if($this->_tpl_vars['array'][$list]['lockin']==1){ ?><span class="select_ok"></span><?php }else{ ?><span class="select_no"></span><?php } ?></td>
					</tr>
				</table>
			</td>
			<td width="20%" id="infotype">
				<table border="0" style="border-collapse:collapse" bordercolor="#FFFFFF">
					<tr>
						<?php if($this->powercheck('templates','mailtemplateedit')==true ){ ?>
						<td>
							<a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['mailtemplatemain_edit_title'] ?>','index.php?archive=mailtemplatemain&action=mailtemplateedit&tmid=<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>&type=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'mailtempedit<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>',self.frameElement.getAttribute('name'));" id="mailtempedit<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['templatename'] ?><?php echo $this->_tpl_vars['ST']['mailtemplatemain_edit_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setedit_botton'] ?></a>
						</td>
						<td class="padding-left3">
							<a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['mailtemplatemain_copy_title'] ?>','index.php?archive=mailtemplatemain&action=mailtemplateedit&tmid=<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>&type=copy&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'mailcopy<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>',self.frameElement.getAttribute('name'));" id="mailcopy<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['templatename'] ?><?php echo $this->_tpl_vars['ST']['mailtemplatemain_copy_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setcopy_botton'] ?></a>
						</td>
						<?php } ?>
						<?php if($this->powercheck('templates','mailtemplatedel')==true && $this->_tpl_vars['array'][$list]['lockin']==0){ ?>
						<td class="padding-left3"><a class="setedit" onclick="javascript:submiturl('index.php?archive=mailtemplatemain&action=mailtemplatedel&tmid=<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>&lng=<?php echo $this->_tpl_vars['array'][$list]['lng'] ?>&styleclass=<?php echo $this->_tpl_vars['array'][$list]['styleclass'] ?>&typeclass=<?php echo $this->_tpl_vars['array'][$list]['typeclass'] ?>&freshid='+Math.random(),'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['mailtemplatemain_del_log_mess'] ?>','selectform','selectall','check_all');" href="#body" title="<?php echo $this->_tpl_vars['ST']['setdel_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setdel_botton'] ?></a></td>
						<?php } ?>
					</tr>
				</table>
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