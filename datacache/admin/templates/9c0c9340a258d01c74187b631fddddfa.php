<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
	<div class="infolist" onselectstart="return false;" <?php if($this->_tpl_vars['array'][$list]['styleid']!=3 ){ ?>title="<?php echo $this->_tpl_vars['array'][$list]['typename'] ?> - <?php echo $this->_tpl_vars['array'][$list]['dir'] ?>/<?php echo $this->_tpl_vars['array'][$list]['dirpath'] ?>"<?php } ?>>
		<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF"<?php if($this->powercheck('article','typeedit')==true ){ ?> ondblClick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['typename'],'hc') ?><?php echo $this->_tpl_vars['ST']['typemanage_edit_title'] ?>','index.php?archive=typemanage&action=typeedit&tid=<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>&type=edit&styleid=<?php echo $this->_tpl_vars['array'][$list]['styleid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'typeedit<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>',self.frameElement.getAttribute('name'));"<?php } ?>>
			<tr>
				<td width="3%"><input type="checkbox" name="selectinfoid" value="<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>"></td>
				<td width="6%">
					<input type="hidden" name="infoid" id="infoid" value="<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>">
					<input type="text" name="pid" size="1" value="<?php echo $this->_tpl_vars['array'][$list]['pid'] ?>" class="infoInput" style="width:25px;">
				</td>
				<td width="5%"><?php echo $this->_tpl_vars['array'][$list]['tid'] ?></td>
				<td width="22%" id="left" class="padding-left3">
					<?php echo $this->treelist($this->_tpl_vars['array'][$list]['level'],'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') ?><?php if($this->_tpl_vars['array'][$list]['level']>0){ ?>├─ <?php } ?><a target="_blank" class="<?php if($this->_tpl_vars['array'][$list]['level']==0){ ?>infolink04b<?php }else{ ?>infolink04<?php } ?>" href="<?php echo $this->_tpl_vars['array'][$list]['glink'] ?>"><?php echo $this->_tpl_vars['array'][$list]['typename'] ?></a></td>
				<td width="8%"><?php echo $this->_tpl_vars['array'][$list]['stylename'] ?></td>
				<!--












				/	</table>
				</td>
				-->
				<td width="56%" id="infotype">
					<table border="0" style="border-collapse:collapse" bordercolor="#FFFFFF">
						<tr>
							<?php if($this->_tpl_vars['array'][$list]['styleid']<3){ ?>
							<td><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['typename'],'hc') ?><?php echo $this->_tpl_vars['ST']['typemanage_text_infolist_title'] ?>','index.php?archive=management&action=list&listfunction=articlelist&tid=<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>&mid=<?php echo $this->_tpl_vars['array'][$list]['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,'typelist<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>',self.frameElement.getAttribute('name'));" id="typelist<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['ST']['typemanage_text_infolist_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['viewfield_botton'] ?></a></td>
							<?php } ?>
							<?php if($this->powercheck('article','typeadd')==true ){ ?>
							<td class="padding-left3"><a class="setedit2" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['typename'],'hc') ?><?php echo $this->_tpl_vars['ST']['typemanage_add_title'] ?>','index.php?archive=typemanage&action=typeadd&upid=<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>&lng=<?php echo $this->_tpl_vars['array'][$list]['lng'] ?>&topid=<?php echo $this->_tpl_vars['array'][$list]['topid'] ?>&styleid=1&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'typeadd<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>',self.frameElement.getAttribute('name'));" id="typeadd<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['typename'] ?><?php echo $this->_tpl_vars['ST']['typemanage_add_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['typemanage_add_title'] ?></a></td>
							<td class="padding-left3"><a class="setedit2" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['typename'],'hc') ?><?php echo $this->_tpl_vars['ST']['typemanage_add_title'] ?>','index.php?archive=typemanage&action=typeadd&upid=<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>&lng=<?php echo $this->_tpl_vars['array'][$list]['lng'] ?>&topid=<?php echo $this->_tpl_vars['array'][$list]['topid'] ?>&styleid=4&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'typeadd<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>',self.frameElement.getAttribute('name'));" id="typeadd<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['typename'] ?><?php echo $this->_tpl_vars['ST']['typemanage_add_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['typemanage_add_title2'] ?></a></td>
							<td class="padding-left3"><a class="setedit2" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['typename'],'hc') ?><?php echo $this->_tpl_vars['ST']['typemanage_add_title'] ?>','index.php?archive=typemanage&action=typeadd&upid=<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>&lng=<?php echo $this->_tpl_vars['array'][$list]['lng'] ?>&topid=<?php echo $this->_tpl_vars['array'][$list]['topid'] ?>&styleid=3&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'typeadd<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>',self.frameElement.getAttribute('name'));" id="typeadd<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['typename'] ?><?php echo $this->_tpl_vars['ST']['typemanage_add_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['typemanage_add_title3'] ?></a></td>
							<?php } ?>
							<?php if($this->powercheck('article','typeedit')==true ){ ?>
							<td class="padding-left3"><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['typename'],'hc') ?><?php echo $this->_tpl_vars['ST']['typemanage_edit_title'] ?>','index.php?archive=typemanage&action=typeedit&tid=<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>&type=edit&styleid=<?php echo $this->_tpl_vars['array'][$list]['styleid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'typeedit<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>',self.frameElement.getAttribute('name'));" id="typeedit<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['typename'] ?><?php echo $this->_tpl_vars['ST']['typemanage_edit_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setedit_botton'] ?></a></td>
							<?php } ?>
							<?php if($this->powercheck('article','typeedit')==true && $this->_tpl_vars['array'][$list]['styleid']<3){ ?>
							<td class="padding-left3"><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['typename'],'hc') ?><?php echo $this->_tpl_vars['ST']['typeshift_botton'] ?>','index.php?archive=typemanage&action=typeshift&tid=<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>&styleid=<?php echo $this->_tpl_vars['array'][$list]['styleid'] ?>&type=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false);" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['typename'] ?><?php echo $this->_tpl_vars['ST']['typeshift_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['typeshift_botton'] ?></a></td>
							<?php } ?>
							<?php if($this->powercheck('article','synchro')==true && $this->_tpl_vars['array'][$list]['styleid']<3){ ?>
							<td class="padding-left3"><a class="setedit2" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['botton_synchro'] ?>','index.php?archive=typemanage&action=synchro&tid=<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false);" href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_synchro'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_synchro'] ?></a></td>
							<?php } ?>
							<?php if($this->powercheck('article','deltype')==true ){ ?>
							<td class="padding-left3"><a class="setedit" onclick="javascript:submiturl('index.php?archive=typemanage&action=deltype&tid=<?php echo $this->_tpl_vars['array'][$list]['tid'] ?>&freshid='+Math.random(),'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','selectform','selectall','check_all');" href="#body" title="<?php echo $this->_tpl_vars['ST']['setdel_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setdel_botton'] ?></a></td>
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