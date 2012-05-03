<?php if($this->_tpl_vars['updirtype']==1){ ?>
<div class="infolist">
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF" onclick="javascript:search('<?php echo $this->_tpl_vars['uploadurl'] ?>');">
			<tr>
				<td width="45%" id="left" class="padding-left3"><img src="templates/images/fileicon/dir.png"> /<?php echo $this->_tpl_vars['dirlist'] ?></td>
				<td width="10%"></td>
				<td width="20%"></td>
				<td width="25%" id="infotype">
					<table border="0" style="border-collapse:collapse" bordercolor="#FFFFFF">
						<tr>
							<td><a class="setedit3" id="center" href="#body" onclick="javascript:search('<?php echo $this->_tpl_vars['uploadurl'] ?>');" title="<?php echo $this->_tpl_vars['ST']['filemanage_view_updir'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['filemanage_view_updir'] ?></a></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
</div>
<?php } ?>
<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
<div class="infolist">
	<?php if($this->_tpl_vars['array'][$list]['bottype']=='dir'){ ?>
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF" title="<?php echo $this->_tpl_vars['ST']['filemanage_view_opendir'] ?>" onclick="javascript:search('<?php echo $this->_tpl_vars['array'][$list]['loadurl'] ?>');">
	<?php }else{ ?>
	<table border="0"  style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
	<?php } ?>
		<tr>
			<td width="45%" id="left" class="padding-left3"><img src="templates/images/fileicon/<?php echo $this->_tpl_vars['array'][$list]['type'] ?>.png"> <?php echo $this->_tpl_vars['array'][$list]['filename'] ?></td>
			<td width="10%"><?php echo $this->_tpl_vars['array'][$list]['type'] ?></td>
			<td width="20%"><?php echo $this->timeformat($this->_tpl_vars['array'][$list]['time'],3) ?></td>
			<td width="25%" id="infotype">
				<?php if($this->_tpl_vars['array'][$list]['bottype']!='dir'){ ?>
				<table border="0" style="border-collapse:collapse" bordercolor="#FFFFFF">
					<tr>
						<?php if($this->powercheck('templates','templateedit')==true ){ ?>
						<td>
							<a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['templatemain_edit_title'] ?>','index.php?archive=templatemain&action=templateedit&dir=<?php echo $this->_tpl_vars['templateDIR'] ?>&filename=<?php echo $this->_tpl_vars['array'][$list]['basename'] ?>&type=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'tempfileedit<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>',self.frameElement.getAttribute('name'));" id="tempfileedit<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['templatename'] ?><?php echo $this->_tpl_vars['ST']['templatemain_edit_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setedit_botton'] ?></a>
						</td>
						<td class="padding-left3">
							<a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['templatemain_copy_title'] ?>','index.php?archive=templatemain&action=templateedit&dir=<?php echo $this->_tpl_vars['templateDIR'] ?>&filename=<?php echo $this->_tpl_vars['array'][$list]['basename'] ?>&type=copy&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'tempfilecopy<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>',self.frameElement.getAttribute('name'));" id="tempfilecopy<?php echo $this->_tpl_vars['array'][$list]['tmid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['templatename'] ?><?php echo $this->_tpl_vars['ST']['templatemain_copy_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setcopy_botton'] ?></a>
						</td>
						<?php } ?>
						<?php if($this->powercheck('templates','templatedel')==true ){ ?>
						<td class="padding-left3"><a class="setedit" onclick="javascript:submiturl('index.php?archive=templatemain&action=templatedel&dir=<?php echo $this->_tpl_vars['templateDIR'] ?>&filename=<?php echo $this->_tpl_vars['array'][$list]['basename'] ?>&freshid='+Math.random(),'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['templatemain_del_log_mess'] ?>','selectform','selectall','check_all');" href="#body" title="<?php echo $this->_tpl_vars['ST']['setdel_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setdel_botton'] ?></a></td>
						<?php } ?>
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