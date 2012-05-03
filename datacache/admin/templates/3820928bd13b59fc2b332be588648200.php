<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
<div class="infolist" onselectstart="return false;" title="<?php echo $this->_tpl_vars['array'][$list]['modelname'] ?>" <?php if($this->powercheck('article','modeledit')==true ){ ?>ondblClick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['modelname'],'hc') ?><?php echo $this->_tpl_vars['ST']['modelmanage_edit_title'] ?>','index.php?archive=modelmanage&action=modeledit&id=<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>&type=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'midedit<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>',self.frameElement.getAttribute('name'));"<?php } ?>>
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
		<tr>
			<td width="10%"><input type="checkbox" name="selectinfoid" value="<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>"></td>
			<td width="10%"><?php echo $this->_tpl_vars['array'][$list]['mid'] ?></td>
			<td width="50%"><?php echo $this->_tpl_vars['array'][$list]['modelname'] ?></td>
			<td width="10%" id="infotype">
				<table>
					<tr>
						<td><?php if($this->_tpl_vars['array'][$list]['lockin']==1){ ?><span class="system_ok" title="<?php echo $this->_tpl_vars['ST']['modelmanage_lockin_ok'] ?>"></span><?php }else{ ?><span class="system_no" title="<?php echo $this->_tpl_vars['ST']['modelmanage_lockin_no'] ?>"></span><?php } ?></td>
						<td><?php if($this->_tpl_vars['array'][$list]['isclass']==1){ ?><span class="audit_ok" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>"></span><?php }else{ ?><span class="audit_no" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>"></span><?php } ?></td>
					</tr>
				</table>
			</td>
			<td width="20%" id="infotype">
				<table border="0" style="border-collapse:collapse" bordercolor="#FFFFFF">
					<tr>
						<td><a class="setedit2" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['modelname'],'hc') ?><?php echo $this->_tpl_vars['ST']['modelmanage_text_attlist_title'] ?>','index.php?archive=management&action=list&listfunction=modelattlist&mid=<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,'attlist<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>',self.frameElement.getAttribute('name'));" id="attlist<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['ST']['modelmanage_text_attlist_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['viewmodeatt_botton'] ?></a></td>
						<?php if($this->powercheck('article','modeledit')==true ){ ?>
						<td class="padding-left3"><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['modelname'],'hc') ?><?php echo $this->_tpl_vars['ST']['modelmanage_edit_title'] ?>','index.php?archive=modelmanage&action=modeledit&id=<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>&type=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'midedit<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>',self.frameElement.getAttribute('name'));" id="midedit<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>"href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['modelname'] ?><?php echo $this->_tpl_vars['ST']['modelmanage_edit_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setedit_botton'] ?></a></td>
						<?php } ?>
						<?php if($this->powercheck('article','delmodel')==true ){ ?>
						<?php if($this->_tpl_vars['array'][$list]['lockin']!=1){ ?>
						<td class="padding-left3"><a class="setedit" onclick="javascript:submiturl('index.php?archive=modelmanage&action=delmodel&id=<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','selectform','selectall','check_all');" href="#body" title="<?php echo $this->_tpl_vars['ST']['setdel_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setdel_botton'] ?></a></td>
						<?php } ?>
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