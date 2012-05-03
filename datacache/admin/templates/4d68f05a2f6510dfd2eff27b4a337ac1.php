<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
<div class="infolist" onselectstart="return false;" title="<?php echo $this->_tpl_vars['array'][$list]['enquirysn'] ?> - <?php echo $this->_tpl_vars['array'][$list]['linkman'] ?>"<?php if($this->powercheck('order','enquiryedit')==true ){ ?> ondblClick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['enquirymain_text_read_botton_title'] ?><?php echo $this->_tpl_vars['array'][$list]['enquirysn'] ?>','index.php?archive=enquirymain&action=enquiryedit&eid=<?php echo $this->_tpl_vars['array'][$list]['eid'] ?>&type=read&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,'enquiryread<?php echo $this->_tpl_vars['array'][$list]['eid'] ?>',self.frameElement.getAttribute('name'));"<?php } ?>>
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
		<tr>
			<td width="5%"><input type="checkbox" name="selectinfoid" value="<?php echo $this->_tpl_vars['array'][$list]['eid'] ?>"></td>
			<td width="10%"><?php echo $this->_tpl_vars['array'][$list]['eid'] ?></td>
			<td width="20%"><?php echo $this->_tpl_vars['array'][$list]['enquirysn'] ?></td>
			<td width="15%"><?php echo $this->_tpl_vars['array'][$list]['linkman'] ?></td>
			<td width="10%"><?php if($this->_tpl_vars['array'][$list]['userid']==0){ ?><?php echo $this->_tpl_vars['ST']['enquirymain_text_userid0'] ?><?php }else{ ?><B><?php echo $this->_tpl_vars['ST']['enquirymain_text_userid1'] ?></B><?php } ?></td>
			<td width="17%"><?php echo $this->timeformat($this->_tpl_vars['array'][$list]['addtime'],3) ?></td>
			<td width="10%">
				<?php if($this->_tpl_vars['array'][$list]['isclass']==0){ ?><B><?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass1'] ?></B><?php } ?>
				<?php if($this->_tpl_vars['array'][$list]['isclass']==1){ ?><span style="color:#4FA621"><b><?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass2'] ?></b></span><?php } ?>
				<?php if($this->_tpl_vars['array'][$list]['isclass']==2){ ?><span style="color:#E5432A"><?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass3'] ?></span><?php } ?>
			</td>
			<td width="13%" id="infotype">
				<table border="0" style="border-collapse:collapse" bordercolor="#FFFFFF">
					<tr>
						<?php if($this->powercheck('order','enquiryedit')==true ){ ?>
						<td><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['enquirymain_text_read_botton_title'] ?><?php echo $this->_tpl_vars['array'][$list]['enquirysn'] ?>','index.php?archive=enquirymain&action=enquiryedit&eid=<?php echo $this->_tpl_vars['array'][$list]['eid'] ?>&type=read&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'enquiryread<?php echo $this->_tpl_vars['array'][$list]['eid'] ?>',self.frameElement.getAttribute('name'));" id="enquiryread<?php echo $this->_tpl_vars['array'][$list]['eid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['enquirysn'] ?><?php echo $this->_tpl_vars['ST']['viewfield_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['viewfield_botton'] ?></a></td>
						<?php } ?>
						<?php if($this->powercheck('order','enquiryedit')==true && $this->_tpl_vars['array'][$list]['isclass']==0){ ?>
						<td class="padding-left3"><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['enquirymain_edit_log'] ?><?php echo $this->_tpl_vars['array'][$list]['enquirysn'] ?>','index.php?archive=enquirymain&action=enquiryedit&eid=<?php echo $this->_tpl_vars['array'][$list]['eid'] ?>&type=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'enquiryedit<?php echo $this->_tpl_vars['array'][$list]['eid'] ?>',self.frameElement.getAttribute('name'));" id="enquiryedit<?php echo $this->_tpl_vars['array'][$list]['eid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['enquirysn'] ?><?php echo $this->_tpl_vars['ST']['enquirymain_edit_log'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setedit_botton'] ?></a></td>
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