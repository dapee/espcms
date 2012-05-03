<?php if(count($this->_tpl_vars['array']) > 0){ ?>
<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
<div class="infolist" title="<?php echo $this->_tpl_vars['array'][$list]['title'] ?> - <?php echo $this->timeformat($this->_tpl_vars['array'][$list]['addtime'],3) ?>" onselectstart="return false;" <?php if($this->powercheck('article','docedit')==true ){ ?>ondblClick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['title'],'hc') ?>-<?php echo $this->_tpl_vars['ST']['article_edit_title'] ?>','index.php?archive=article&action=docedit&did=<?php echo $this->_tpl_vars['array'][$list]['did'] ?>&type=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'articleeditbotton<?php echo $this->_tpl_vars['array'][$list]['did'] ?>',self.frameElement.getAttribute('name'));"<?php } ?>>
	<table border="0" style="border-collapse:collapse" width="100%" bordercolor="#FFFFFF">
		<tr>
			<td width="4%"><input type="checkbox" name="articleselectinfoid" value="<?php echo $this->_tpl_vars['array'][$list]['did'] ?>"></td>
			<td width="7%"><input type="hidden" name="articleinfoid" id="articleinfoid" value="<?php echo $this->_tpl_vars['array'][$list]['did'] ?>"><input type="text" name="articlepid" size="2" value="<?php echo $this->_tpl_vars['array'][$list]['pid'] ?>" class="infoInput" ></td>
			<td width="7%"><?php echo $this->_tpl_vars['array'][$list]['did'] ?></td>
			<td width="40%" id="left" class="padding-left3">
				<?php if($this->_tpl_vars['array'][$list]['islink']==0){ ?>
				<a target="_blank" class="infolink04" alt="<?php echo $this->_tpl_vars['array'][$list]['title'] ?>" href="<?php echo $this->_tpl_vars['array'][$list]['readlink'] ?>"><?php echo $this->cutstr($this->_tpl_vars['array'][$list]['ctitle'],23) ?></a>
				<?php }else{ ?>
				<?php echo $this->cutstr($this->_tpl_vars['array'][$list]['ctitle'],23) ?>
				<?php } ?>
			</td>
			<td width="10%"><?php echo $this->cutstr($this->_tpl_vars['array'][$list]['typename'],5) ?></td>
			<td width="11%" id="infotype">
				<table>
					<tr>
						<td><?php if($this->_tpl_vars['array'][$list]['pic']!=''){ ?><span class="pic_ok" title="<?php echo $this->_tpl_vars['ST']['article_pic_ok'] ?>"></span><?php }else{ ?><span class="pic_no" title="<?php echo $this->_tpl_vars['ST']['article_pic_no'] ?>"></span><?php } ?></td>
						<td><?php if($this->_tpl_vars['array'][$list]['islink']==1){ ?><span class="iswindow_ok" title="<?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?>"></span><?php }else{ ?><span class="iswindow_no" title="<?php echo $this->_tpl_vars['ST']['article_audit_no'] ?>"></span><?php } ?></td>
						<td><?php if($this->_tpl_vars['array'][$list]['isorder']==1){ ?><span class="order_ok" title="<?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?>"></span><?php }else{ ?><span class="order_no" title="<?php echo $this->_tpl_vars['ST']['article_audit_no'] ?>"></span><?php } ?></td>
						<td><?php if($this->_tpl_vars['array'][$list]['isclass']==1){ ?><span class="audit_ok" title="<?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?>"></span><?php }else{ ?><span class="audit_no" title="<?php echo $this->_tpl_vars['ST']['article_audit_no'] ?>"></span><?php } ?></td>
					</tr>
				</table>
			</td>
			<td width="20%" id="infotype">
				<?php if($this->powercheck('article','docedit')==true ){ ?>
				<table border="0" style="border-collapse:collapse" bordercolor="#FFFFFF">
					<tr>
						<td><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['title'],'hc') ?>-<?php echo $this->_tpl_vars['ST']['article_edit_title'] ?>','index.php?archive=article&action=docedit&did=<?php echo $this->_tpl_vars['array'][$list]['did'] ?>&type=edit&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'articleeditbotton<?php echo $this->_tpl_vars['array'][$list]['did'] ?>',self.frameElement.getAttribute('name'));" id="articleeditbotton<?php echo $this->_tpl_vars['array'][$list]['did'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['title'] ?><?php echo $this->_tpl_vars['ST']['article_edit_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setedit_botton'] ?></a></td>
						<td class="padding-left3"><a class="setedit" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['array'][$list]['title'],'hc') ?>-<?php echo $this->_tpl_vars['ST']['setcopy_botton'] ?>','index.php?archive=article&action=docedit&did=<?php echo $this->_tpl_vars['array'][$list]['did'] ?>&type=add&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'articleeditbotton<?php echo $this->_tpl_vars['array'][$list]['did'] ?>',self.frameElement.getAttribute('name'));" id="articleeditbotton<?php echo $this->_tpl_vars['array'][$list]['did'] ?>" href="#body" title="<?php echo $this->_tpl_vars['array'][$list]['title'] ?><?php echo $this->_tpl_vars['ST']['setcopy_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['setcopy_botton'] ?></a></td>
						<?php if($this->_tpl_vars['array'][$list]['ismess']==1 && $this->powercheck('article','acmessagelist')==true ){ ?>
						<td class="padding-left3"><a class="setedit2" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['botton_view_message'] ?>','index.php?archive=management&action=list&listfunction=acmessagelist&did=<?php echo $this->_tpl_vars['array'][$list]['did'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,'articlemessage<?php echo $this->_tpl_vars['array'][$list]['did'] ?>',self.frameElement.getAttribute('name'));" id="articlemessage<?php echo $this->_tpl_vars['array'][$list]['did'] ?>" href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_view_message'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_view_message'] ?></a></td>
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