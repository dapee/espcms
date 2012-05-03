<?php if($this->_tpl_vars['menutype'] == 'loglist' || $this->_tpl_vars['menutype'] == 'templatelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php if($this->_tpl_vars['menutype'] == 'mangerlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('system','manageradd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_manageradd'],'hc') ?>','index.php?archive=management&action=manageradd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_group'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_manageradd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['mangerlist_user_type'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isclass0" href="#body" onclick="javascript:dbfilter('isclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isclass1" href="#body" onclick="javascript:dbfilter('isclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mangerlist_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mangerlist_audit_ok'] ?></a></li>
					<li><a class="menuclick" id="isclass2" href="#body" onclick="javascript:dbfilter('isclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mangerlist_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mangerlist_audit_no'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['inputtype_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="inputclassid0" href="#body" onclick="javascript:dbfilter('inputclassid','inputclassid',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="inputclassid1" href="#body" onclick="javascript:dbfilter('inputclassid','inputclassid',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['input1_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['input1_botton'] ?></a></li>
					<li><a class="menuclick" id="inputclassid2" href="#body" onclick="javascript:dbfilter('inputclassid','inputclassid',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['input0_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['input0_botton'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['grouptype_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="powergroup0" href="#body" onclick="javascript:dbfilter('powergroup','powergroup',0,0,<?php echo $this->_tpl_vars['powernum'] ?>,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<?php if (count($this->_tpl_vars['powerarray'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['powerarray']); $i++){?>
					<li><a class="menuclick" id="powergroup<?php echo $i+1 ?>" href="#body" onclick="javascript:dbfilter('powergroup','powergroup',<?php echo $this->_tpl_vars['powerarray'][$i]['id'] ?>,<?php echo $i+1 ?>,<?php echo $this->_tpl_vars['powernum'] ?>,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['powerarray'][$i]['powername'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['powerarray'][$i]['powername'] ?></a></li>
					<?php }} ?>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('system','delmanage')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=management&action=delmanage','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('system','manageedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['mangerlist_user_type_set'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=management&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['mangerlist_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mangerlist_audit_ok'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=management&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['mangerlist_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mangerlist_audit_no'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['input_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=management&action=setting','selectinfoid',true,'inputclassid',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['input1_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['input1_botton'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=management&action=setting','selectinfoid',true,'inputclassid',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['input0_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['input0_botton'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['group_set_botton'] ?></span>
				<ul>
					<?php if (count($this->_tpl_vars['powerarray'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['powerarray']); $i++){?>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=management&action=setting','selectinfoid',true,'powergroup',<?php echo $this->_tpl_vars['powerarray'][$i]['id'] ?>,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['powerarray'][$i]['powername'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['powerarray'][$i]['powername'] ?></a></li>
					<?php }} ?>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>
<?php /* 权限组列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'grouplist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('system','groupadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_group'],'hc') ?>','index.php?archive=powergroup&action=groupadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_group'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_group'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['group_properties_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="delclass0" href="#body" onclick="javascript:dbfilter('delclass','delclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="delclass1" href="#body" onclick="javascript:dbfilter('delclass','delclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['group_sys_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['group_sys_botton'] ?></a></li>
					<li><a class="menuclick" id="delclass2" href="#body" onclick="javascript:dbfilter('delclass','delclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['group_custom_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['group_custom_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('system','delgroup')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=powergroup&action=delgroup','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>
<?php /* 数据库 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'sqllist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('system','export')==true ){ ?>
	<li class="menumain"><a id="dbbak" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['sql_bak_botton_title'] ?>','index.php?archive=sqlmanage&action=export&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,true);" href="#body" title="<?php echo $this->_tpl_vars['ST']['sql_bak_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['sql_bak_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('system','bakfilelist')==true ){ ?>
	<li class="menumain"><a id="restore" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['sql_restore_botton_title'] ?>','index.php?archive=sqlmanage&action=bakfilelist&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,true);" href="#body" title="<?php echo $this->_tpl_vars['ST']['sql_restore_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['sql_restore_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('system','sqldel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:parent.onbotton('<?php echo $this->_tpl_vars['ST']['sql_del_botton_title'] ?>','index.php?archive=sqlmanage&action=bakfilelist&listtype=del&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,true);" href="#body" title="<?php echo $this->_tpl_vars['ST']['sql_del_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('system','optimize')==true ){ ?>
	<li class="menumain"><a id="optimize" onclick="javascript:submiturl('index.php?archive=sqlmanage&action=optimize','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>',false,'','selectform','selectall','check_all')" href="#body" title="<?php echo $this->_tpl_vars['ST']['sql_optimize_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['sql_optimize_botton_title'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>
<?php /* 语言列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'languagelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('system','lngadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_lngadd'],'hc') ?>','index.php?archive=language&action=lngadd&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_lngadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_lngadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isopen0" href="#body" onclick="javascript:dbfilter('isopen','isopen',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isopen1" href="#body" onclick="javascript:dbfilter('isopen','isopen',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['language_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['language_audit_ok'] ?></a></li>
					<li><a class="menuclick" id="isopen2" href="#body" onclick="javascript:dbfilter('isopen','isopen',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['language_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['language_audit_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('system','dellng')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=language&action=dellng','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('system','lngedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=language&action=lngsort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('system','lngedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=language&action=setting','selectinfoid',true,'isopen',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['language_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['language_audit_ok'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=language&action=setting','selectinfoid',true,'isopen',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['language_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['language_audit_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>


<?php /* 语言包管理 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'lanpacklist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('system','lanpackadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_lanpackadd'],'hc') ?>','index.php?archive=languagepack&action=lanpackadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_lanpackadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_lanpackadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['languagepack_add_typeid'] ?></span>
				<ul id="modeltablist">
					<li><a class="menunoclick" id="typeid0" href="#body" onclick="javascript:dbfilter('typeid','typeid',0,0,7,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<?php if (count($this->_tpl_vars['lantype'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['lantype']); $ii++){?>
					<li><a class="menuclick" id="typeid<?php echo $ii+1 ?>" href="#body" onclick="javascript:dbfilter('typeid','typeid','<?php echo $this->_tpl_vars['lantype'][$ii]['key'] ?>',<?php echo $ii+1 ?>,7,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['lantype'][$ii]['name'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['lantype'][$ii]['name'] ?></a></li>
					<?php }} ?>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['languagepack_lockin_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="lockin0" href="#body" onclick="javascript:dbfilter('lockin','lockin',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="lockin1" href="#body" onclick="javascript:dbfilter('lockin','lockin',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['languagepack_lockin_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['languagepack_lockin_botton1'] ?></a></li>
					<li><a class="menuclick" id="lockin2" href="#body" onclick="javascript:dbfilter('lockin','lockin',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['languagepack_lockin_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['languagepack_lockin_botton2'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('system','lanpackdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=languagepack&action=lanpackdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php /* 在线客服 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'callinglist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('communicate','calladd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_calladd'],'hc') ?>','index.php?archive=callmain&action=calladd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_calladd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_calladd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isclass0" href="#body" onclick="javascript:dbfilter('isclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isclass1" href="#body" onclick="javascript:dbfilter('isclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['callmain_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['callmain_audit_ok'] ?></a></li>
					<li><a class="menuclick" id="isclass2" href="#body" onclick="javascript:dbfilter('isclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['callmain_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['callmain_audit_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('communicate','calldel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=callmain&action=calldel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('communicate','calledit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=callmain&action=sort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','calledit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=callmain&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['callmain_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['callmain_audit_ok'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=callmain&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['callmain_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['callmain_audit_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 内链接列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'seolinklist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('marketing','keylinkadd')==true ){ ?>
	<?php if($this->_tpl_vars['tabarray']['mid']!=''){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_seolink'],'hc') ?>','index.php?archive=seomanage&action=keylinkadd&tid=<?php echo $this->_tpl_vars['tabarray']['tid'] ?>&mid=<?php echo $this->_tpl_vars['tabarray']['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_seolink'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_seolink'] ?></a></li>
	<?php }else{ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:alert('<?php echo $this->_tpl_vars['ST']['article_js_doc_add_midtidnoselect'] ?>');return false;"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_seolink'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_seolink'] ?></a></li>
	<?php } ?>
	<?php } ?>

	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['seomanage_text_islink'] ?></span>
				<ul>
					<li><a class="menunoclick" id="islink0" href="#body" onclick="javascript:dbfilter('islink','islink',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="islink1" href="#body" onclick="javascript:dbfilter('islink','islink',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['seomanage_islink_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_islink_ok'] ?></a></li>
					<li><a class="menuclick" id="islink2" href="#body" onclick="javascript:dbfilter('islink','islink',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['seomanage_islink_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_islink_no'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['seomanage_text_class'] ?></span>
				<ul>
					<li><a class="menunoclick" id="istop0" href="#body" onclick="javascript:dbfilter('istop','istop',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="istop1" href="#body" onclick="javascript:dbfilter('istop','istop',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['seomanage_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_audit_ok'] ?></a></li>
					<li><a class="menuclick" id="istop2" href="#body" onclick="javascript:dbfilter('istop','istop',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['seomanage_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_audit_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('marketing','delkey')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=seomanage&action=delkey','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('marketing','keylinkedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=seomanage&action=keysort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('marketing','keylinkedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['seomanage_text_islink'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=seomanage&action=setting','selectinfoid',true,'islink',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['seomanage_islink_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_islink_ok'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=seomanage&action=setting','selectinfoid',true,'islink',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['seomanage_islink_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_islink_no'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['seomanage_text_class'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=seomanage&action=setting','selectinfoid',true,'istop',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['seomanage_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_audit_ok'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=seomanage&action=setting','selectinfoid',true,'istop',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['seomanage_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_audit_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 内链接分组列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'seolinktypelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('marketing','keylinktypeadd')==true ){ ?>
	<?php if($this->_tpl_vars['tabarray']['mid']!=''){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_seotypelink'],'hc') ?>','index.php?archive=seomanage&action=keylinktypeadd&tid=<?php echo $this->_tpl_vars['tabarray']['tid'] ?>&mid=<?php echo $this->_tpl_vars['tabarray']['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_seotypelink'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_seotypelink'] ?></a></li>
	<?php }else{ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:alert('<?php echo $this->_tpl_vars['ST']['article_js_doc_add_midtidnoselect'] ?>');return false;"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_seotypelink'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_seotypelink'] ?></a></li>
	<?php } ?>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<?php if($this->powercheck('marketing','delkeytype')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=seomanage&action=delkeytype','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php /* 模型类别列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'modellist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('article','modeladd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['modelmanage_add_title'],'hc') ?>','index.php?archive=modelmanage&action=modeladd&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['modelmanage_add_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['modelmanage_add_title'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isclass0" href="#body" onclick="javascript:dbfilter('isclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isclass1" href="#body" onclick="javascript:dbfilter('isclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="isclass2" href="#body" onclick="javascript:dbfilter('isclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_islockin_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="lockin0" href="#body" onclick="javascript:dbfilter('lockin','lockin',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="lockin1" href="#body" onclick="javascript:dbfilter('lockin','lockin',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['modelmanage_islockin_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['modelmanage_islockin_botton1'] ?></a></li>
					<li><a class="menuclick" id="lockin2" href="#body" onclick="javascript:dbfilter('lockin','lockin',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['modelmanage_islockin_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['modelmanage_islockin_botton2'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_isbase_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isbase0" href="#body" onclick="javascript:dbfilter('isbase','isbase',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isbase1" href="#body" onclick="javascript:dbfilter('isbase','isbase',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="isbase2" href="#body" onclick="javascript:dbfilter('isbase','isbase',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_istsn_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="istsn0" href="#body" onclick="javascript:dbfilter('istsn','istsn',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="istsn1" href="#body" onclick="javascript:dbfilter('istsn','istsn',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="istsn2" href="#body" onclick="javascript:dbfilter('istsn','istsn',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>

			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_isalbum_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isalbum0" href="#body" onclick="javascript:dbfilter('isalbum','isalbum',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isalbum1" href="#body" onclick="javascript:dbfilter('isalbum','isalbum',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="isalbum2" href="#body" onclick="javascript:dbfilter('isalbum','isalbum',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>


			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_isextid_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isextid0" href="#body" onclick="javascript:dbfilter('isextid','isextid',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isextid1" href="#body" onclick="javascript:dbfilter('isextid','isextid',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="isextid2" href="#body" onclick="javascript:dbfilter('isextid','isextid',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_issid_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="issid0" href="#body" onclick="javascript:dbfilter('issid','issid',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="issid1" href="#body" onclick="javascript:dbfilter('issid','issid',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="issid2" href="#body" onclick="javascript:dbfilter('issid','issid',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_isfgid_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isfgid0" href="#body" onclick="javascript:dbfilter('isfgid','isfgid',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isfgid1" href="#body" onclick="javascript:dbfilter('isfgid','isfgid',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="isfgid2" href="#body" onclick="javascript:dbfilter('isfgid','isfgid',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_islinkdid_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="islinkdid0" href="#body" onclick="javascript:dbfilter('islinkdid','islinkdid',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="islinkdid1" href="#body" onclick="javascript:dbfilter('islinkdid','islinkdid',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="islinkdid2" href="#body" onclick="javascript:dbfilter('islinkdid','islinkdid',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('article','modeledit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=modelmanage&action=modelsetting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=modelmanage&action=modelsetting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 模型字段列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'modelattlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('article','modelattradd')==true ){ ?>
	<li class="menumain"><a class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['modelmanage_attr_add'],'hc') ?>','index.php?archive=modelmanage&action=modelattradd&mid=<?php echo $this->_tpl_vars['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addattr<?php echo $this->_tpl_vars['mid'] ?>',self.frameElement.getAttribute('name'));" id="addattr<?php echo $this->_tpl_vars['mid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['ST']['modelmanage_attr_add'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['modelmanage_attr_add'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="attrisclass0" href="#body" onclick="javascript:dbfilter('attrisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="attrisclass1" href="#body" onclick="javascript:dbfilter('attrisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="attrisclass2" href="#body" onclick="javascript:dbfilter('attrisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_attr_isvalidate_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isvalidate0" href="#body" onclick="javascript:dbfilter('isvalidate','isvalidate',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isvalidate1" href="#body" onclick="javascript:dbfilter('isvalidate','isvalidate',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="isvalidate2" href="#body" onclick="javascript:dbfilter('isvalidate','isvalidate',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_attr_issearch_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="issearch0" href="#body" onclick="javascript:dbfilter('issearch','issearch',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="issearch1" href="#body" onclick="javascript:dbfilter('issearch','issearch',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="issearch2" href="#body" onclick="javascript:dbfilter('issearch','issearch',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('article','delattr')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=modelmanage&action=delattr','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('article','modelattredit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=modelmanage&action=attrsort&mid=<?php echo $this->_tpl_vars['mid'] ?>','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php /* 分类列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'typelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('article','typeadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_type'],'hc') ?>','index.php?archive=typemanage&action=typeadd&mid=<?php echo $this->_tpl_vars['tabarray']['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_type'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_type'] ?></a></li>
	<li class="menumain"><a id="addinfo2" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_type_base'],'hc') ?>','index.php?archive=typemanage&action=typeadd&styleid=4&mid=<?php echo $this->_tpl_vars['tabarray']['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo2',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_type_base'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_type_base'] ?></a></li>
	<li class="menumain"><a id="addinfo3" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_type_link'],'hc') ?>','index.php?archive=typemanage&action=typeadd&styleid=3&mid=<?php echo $this->_tpl_vars['tabarray']['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo3',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_type_link'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_type_link'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<?php if($this->powercheck('article','typeedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=typemanage&action=sort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('article','typeedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['inputtype_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=typemanage&action=typesetting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['infooktype_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infooktype_botton'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=typemanage&action=typesetting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['lockoktype_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockoktype_botton'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['typemanage_ismenu_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=typemanage&action=typesetting&ch=1','selectinfoid',true,'ismenu',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=typemanage&action=typesetting&ch=1','selectinfoid',true,'ismenu',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['typemanage_type_add_isaccessory_set'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=typemanage&action=typesetting&ch=1','selectinfoid',true,'isaccessory',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['infook_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infook_botton'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=typemanage&action=typesetting&ch=1','selectinfoid',true,'isaccessory',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['lockok_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockok_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 图片管理 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'filelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="fileselectall" class="selectall" href="javascript:select_change(true,'filemodelattselectform','fileselectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<?php if($this->powercheck(0,120)==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:delfile('index.php?archive=filemanage&action=delfile','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','filemodelattselectform','fileselectall','check_all','filepath');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('filemodelattselectform','fileselectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck(0,122)==true ){ ?>
	<li class="menumain"><a class="creatfile" id="creatfile" href="#body" onclick="javascript:windowsdig('<?php echo $this->_tpl_vars['ST']['creatfile_botton'] ?>','iframe:index.php?archive=filemanage&action=mkdir&path='+document.getElementById('filepath').value+'&freshid='+Math.random(),'480px','200px','iframe');" title="<?php echo $this->_tpl_vars['ST']['creatfile_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['creatfile_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck(0,121)==true ){ ?>
	<li class="menumain"><a class="upload" id="uploadfile" href="#body" onclick="javascript:windowsdig('<?php echo $this->_tpl_vars['ST']['fileupload_botton'] ?>','iframe:index.php?archive=filemanage&action=upfile&path='+document.getElementById('filepath').value+'&freshid='+Math.random(),'600px','200px','iframe');" title="<?php echo $this->_tpl_vars['ST']['fileupload_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['fileupload_botton'] ?></a></li>
	<li class="menumain"><a class="upload" id="uploadfile" href="#body" onclick="javascript:windowsdig('<?php echo $this->_tpl_vars['ST']['filebatupload_botton'] ?>','iframe:index.php?archive=filemanage&action=batupfile&path='+document.getElementById('filepath').value+'&freshid='+Math.random(),'600px','400px','iframe');" title="<?php echo $this->_tpl_vars['ST']['filebatupload_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['filebatupload_botton'] ?></a></li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 内容列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'articlelist' || $this->_tpl_vars['menutype'] == 'modelarticlelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('article','docadd')==true ){ ?>
	<?php if($this->_tpl_vars['tabarray']['mid']!=''){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_article'],'hc') ?>','index.php?archive=article&action=docadd&tid=<?php echo $this->_tpl_vars['tabarray']['tid'] ?>&mid=<?php echo $this->_tpl_vars['tabarray']['mid'] ?>&type=add&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_article'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_article'] ?></a></li>
	<?php }else{ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:alert('<?php echo $this->_tpl_vars['ST']['article_js_doc_add_midtidnoselect'] ?>');return false;"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_article'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_article'] ?></a></li>
	<?php } ?>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['viewtype_botton'] ?></span>
				<ul id="articlelabel">
					<li><a class="menunoclick" id="articlelabel0" href="#body" onclick="javascript:dbfilter('articlelabel','dlid',0,0,<?php echo $this->_tpl_vars['dclabelnum'] ?>,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<?php if (count($this->_tpl_vars['dclabellist'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['dclabellist']); $ii++){?>
					<li><a class="menuclick" id="articlelabel<?php echo $ii+1 ?>" href="#body" onclick="javascript:dbfilter('articlelabel','dlid','<?php echo $this->_tpl_vars['dclabellist'][$ii]['dlid'] ?>',<?php echo $ii+1 ?>,<?php echo $this->_tpl_vars['dclabelnum'] ?>,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['dclabellist'][$ii]['labelname'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['dclabellist'][$ii]['labelname'] ?></a></li>
					<?php }} ?>
				</ul>
			</li>

			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['article_ishtml_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="articleishtml0" href="#body" onclick="javascript:dbfilter('articleishtml','ishtml',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="articleishtml1" href="#body" onclick="javascript:dbfilter('articleishtml','ishtml',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_ishtml_botton_2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_ishtml_botton_2'] ?></a></li>
					<li><a class="menuclick" id="articleishtml2" href="#body" onclick="javascript:dbfilter('articleishtml','ishtml',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_ishtml_botton_1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_ishtml_botton_1'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['article_isorder_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="articleisorder0" href="#body" onclick="javascript:dbfilter('articleisorder','isorder',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="articleisorder1" href="#body" onclick="javascript:dbfilter('articleisorder','isorder',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="articleisorder2" href="#body" onclick="javascript:dbfilter('articleisorder','isorder',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['article_islink_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="articleislink0" href="#body" onclick="javascript:dbfilter('articleislink','islink',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="articleislink1" href="#body" onclick="javascript:dbfilter('articleislink','islink',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="articleislink2" href="#body" onclick="javascript:dbfilter('articleislink','islink',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="articleisclass0" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="articleisclass1" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?></a></li>
					<li><a class="menuclick" id="articleisclass2" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_audit_no'] ?></a></li>
				</ul>
			</li>
			<li><a class="menuclick" id="articleisorder0" href="#body" onclick="javascript:refreshurl('selectform')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['getalllist_botton'] ?></a></li>
		</ul>
	</li>
	<li class="menumain"><a id="search" href="#body" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['article_search_botton'] ?>','iframe:index.php?archive=article&action=search&mid=<?php echo $this->_tpl_vars['mid'] ?>&tid=<?php echo $this->_tpl_vars['tid'] ?>&iframename='+self.frameElement.getAttribute('name'),'600px','450px','iframe',true);" title="<?php echo $this->_tpl_vars['ST']['article_search_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['search_botton'] ?></a></li>
	<?php if($this->powercheck('article','articledel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=article&action=articledel','articleselectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('article','docedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=article&action=sort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all','articleinfoid','articlepid');" href="#body" title="<?php echo $this->_tpl_vars['ST']['article_log_sort'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('article','docedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=article&action=setting','articleselectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=article&action=setting','articleselectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['article_isorder_botton_setting'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=article&action=setting','articleselectinfoid',true,'isorder',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=article&action=setting','articleselectinfoid',true,'isorder',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['article_ishtml_botton_setting'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=article&action=setting','articleselectinfoid',true,'ishtml',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['article_ishtml_botton_2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_ishtml_botton_2'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=article&action=setting','articleselectinfoid',true,'ishtml',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['article_ishtml_botton_1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_ishtml_botton_1'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li class="menumain">
		<a id="htmlcreate" onclick="javascript:callrun('index.php?archive=article&action=creathtml','articleselectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['creathtml_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['htmlcreat_botton'] ?></a>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 专题列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'subjectlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('article','subadd')==true ){ ?>
	<li class="menumain"><a class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['subjectmanage_type_add'],'hc') ?>','index.php?archive=subjectmanage&action=subadd&tab=false&mid=<?php echo $this->_tpl_vars['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));" id="addinfo" href="#body" title="<?php echo $this->_tpl_vars['ST']['subjectmanage_type_add'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['subjectmanage_type_add'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['iswap_title'] ?></span>
				<ul>
					<li><a class="menunoclick" id="subiswap0" href="#body" onclick="javascript:dbfilter('subiswap','iswap',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="subiswap1" href="#body" onclick="javascript:dbfilter('subiswap','iswap',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="subiswap2" href="#body" onclick="javascript:dbfilter('subiswap','iswap',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['article_ishtml_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="subishtml0" href="#body" onclick="javascript:dbfilter('subishtml','ishtml',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="subishtml1" href="#body" onclick="javascript:dbfilter('subishtml','ishtml',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_ishtml_botton_2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_ishtml_botton_2'] ?></a></li>
					<li><a class="menuclick" id="subishtml2" href="#body" onclick="javascript:dbfilter('subishtml','ishtml',2,2,3,'selectform','selectall','check_all')" title="[%$this->_tpl_vars['ST']['article_ishtml_botton_1']]" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_ishtml_botton_1'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['input_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="subisclass0" href="#body" onclick="javascript:dbfilter('subisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="subisclass1" href="#body" onclick="javascript:dbfilter('subisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['infooktype_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infooktype_botton'] ?></a></li>
					<li><a class="menuclick" id="subisclass2" href="#body" onclick="javascript:dbfilter('subisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['lockoktype_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockoktype_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('article','subedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=subjectmanage&action=sort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('article','subedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['inputtype_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=subjectmanage&action=subsetting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['infooktype_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infooktype_botton'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=subjectmanage&action=subsetting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['lockoktype_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockoktype_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 显示属性列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'recomlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('article','recomadd')==true ){ ?>
	<li class="menumain"><a class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['recommanage_type_add'],'hc') ?>','index.php?archive=recommanage&action=recomadd&tab=true&mid=<?php echo $this->_tpl_vars['mid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));" id="addinfo" href="#body" title="<?php echo $this->_tpl_vars['ST']['recommanage_type_add'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['recommanage_type_add'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<?php if($this->powercheck('article','delrecomm')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=recommanage&action=delrecomm','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php /* 会员等级列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'memclasslist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('member','classadd')==true ){ ?>
	<li class="menumain"><a class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_memclassadd'],'hc') ?>','index.php?archive=memclassmanage&action=classadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));" id="addinfo" href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_memclassadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_memclassadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['memclassmanage_view_botton_isinter'] ?></span>
				<ul>
					<li><a class="menunoclick" id="memclassisinter0" href="#body" onclick="javascript:dbfilter('memclassisinter','isinter',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="memclassisinter1" href="#body" onclick="javascript:dbfilter('memclassisinter','isinter',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="memclassisinter2" href="#body" onclick="javascript:dbfilter('memclassisinter','isinter',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="memclassisclass0" href="#body" onclick="javascript:dbfilter('memclassisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="memclassisclass1" href="#body" onclick="javascript:dbfilter('memclassisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="memclassisclass2" href="#body" onclick="javascript:dbfilter('memclassisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('member','memberclassdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=memclassmanage&action=memberclassdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('member','classedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=memclassmanage&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=memclassmanage&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['memclassmanage_view_bottonset_isinter'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=memclassmanage&action=setting','selectinfoid',true,'isinter',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=memclassmanage&action=setting','selectinfoid',true,'isinter',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 会员字段列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'memberattlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('member','memattadd')==true ){ ?>
	<li class="menumain"><a class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_memattadd'],'hc') ?>','index.php?archive=memattmanage&action=memattadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));" id="addinfo" href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_memattadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_memattadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['memattmanage_view_botton_isvalidate'] ?></span>
				<ul>
					<li><a class="menunoclick" id="memattisvalidate0" href="#body" onclick="javascript:dbfilter('memattisvalidate','isvalidate',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="memattisvalidate1" href="#body" onclick="javascript:dbfilter('memattisvalidate','isvalidate',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="memattisvalidate2" href="#body" onclick="javascript:dbfilter('memattisvalidate','isvalidate',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="memattisclass0" href="#body" onclick="javascript:dbfilter('memattisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="memattisclass1" href="#body" onclick="javascript:dbfilter('memattisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="memattisclass2" href="#body" onclick="javascript:dbfilter('memattisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('member','memattdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=memattmanage&action=memattdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('member','memattedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=memattmanage&action=sort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('member','memattedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=memattmanage&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=memattmanage&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 会员列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'memberlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('member','memberadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_memberadd'],'hc') ?>','index.php?archive=membermain&action=memberadd&mlid=<?php echo $this->_tpl_vars['tabarray']['mlid'] ?>&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_memberadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_memberadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['membertype_botton'] ?></span>
				<ul id="modeltablist">
					<li><a class="menunoclick" id="mcid0" href="#body" onclick="javascript:dbfilter('mcid','mcid',0,0,<?php echo $this->_tpl_vars['pubnum'] ?>,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<?php if (count($this->_tpl_vars['memberpuvlist'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['memberpuvlist']); $ii++){?>
					<li><a class="menuclick" id="mcid<?php echo $ii+1 ?>" href="#body" onclick="javascript:dbfilter('mcid','mcid','<?php echo $this->_tpl_vars['memberpuvlist'][$ii]['mcid'] ?>',<?php echo $ii+1 ?>,<?php echo $this->_tpl_vars['pubnum'] ?>,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['memberpuvlist'][$ii]['rankname'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['memberpuvlist'][$ii]['rankname'] ?></a></li>
					<?php }} ?>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['membermain_text_typeclass'] ?></span>
				<ul>
					<li><a class="menunoclick" id="memisclass0" href="#body" onclick="javascript:dbfilter('memisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="memisclass1" href="#body" onclick="javascript:dbfilter('memisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['membermain_text_class1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['membermain_text_class1'] ?></a></li>
					<li><a class="menuclick" id="memisclass2" href="#body" onclick="javascript:dbfilter('memisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['membermain_text_class2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['membermain_text_class2'] ?></a></li>
				</ul>
			</li>
			<li><a class="menuclick" id="articleisorder0" href="#body" onclick="javascript:refreshurl('selectform')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['getalllist_botton'] ?></a></li>
		</ul>
	</li>
	<li class="menumain"><a id="search" href="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['membermain_search_botton'] ?>','iframe:index.php?archive=membermain&action=search&iframename='+self.frameElement.getAttribute('name'),'580px','300px','iframe',true);" title="<?php echo $this->_tpl_vars['ST']['membermain_search_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['search_botton'] ?></a></li>
	<?php if($this->powercheck('member','memberdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=membermain&action=memberdel','memberselectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('member','memberedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['membermain_text_set_typeclass'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=membermain&action=setting','memberselectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['membermain_text_class1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['membermain_text_class1'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=membermain&action=setting','memberselectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['membermain_text_class2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['membermain_text_class2'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['membertypeset_botton'] ?></span>
				<ul>
					<?php if (count($this->_tpl_vars['memberpuvlist'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['memberpuvlist']); $ii++){?>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=membermain&action=setting','memberselectinfoid',true,'mcid',<?php echo $this->_tpl_vars['memberpuvlist'][$ii]['mcid'] ?>,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['memberpuvlist'][$ii]['rankname'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['memberpuvlist'][$ii]['rankname'] ?></a></li>
					<?php }} ?>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 发货方式列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'shiplist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('order','shipplugadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_shipplugadd'],'hc') ?>','index.php?archive=shipplug&action=shipplugadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_shipplugadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_shipplugadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['ordershipping_view_botton_iscash'] ?></span>
				<ul>
					<li><a class="menunoclick" id="iscash0" href="#body" onclick="javascript:dbfilter('iscash','iscash',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="iscash1" href="#body" onclick="javascript:dbfilter('iscash','iscash',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="iscash2" href="#body" onclick="javascript:dbfilter('iscash','iscash',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="shipisclass0" href="#body" onclick="javascript:dbfilter('shipisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="shipisclass1" href="#body" onclick="javascript:dbfilter('shipisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="shipisclass2" href="#body" onclick="javascript:dbfilter('shipisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('order','shipplugedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=shipplug&action=sort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('order','shipplugdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=shipplug&action=shipplugdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('order','shipplugedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=shipplug&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=shipplug&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 支付方式列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'paylist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('order','payplugadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_payplugadd'],'hc') ?>','index.php?archive=payplug&action=payplugadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_payplugadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_payplugadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="payisclass0" href="#body" onclick="javascript:dbfilter('payisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="payisclass1" href="#body" onclick="javascript:dbfilter('payisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="payisclass2" href="#body" onclick="javascript:dbfilter('payisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('order','payplugedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=payplug&action=sort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('order','payplugdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=payplug&action=payplugdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('order','payplugedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=payplug&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=payplug&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 财务单据管理 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'payreceiptlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['payreceiptlist_class_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="payisclass0" href="#body" onclick="javascript:dbfilter('payisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="payisclass1" href="#body" onclick="javascript:dbfilter('payisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['payreceiptlist_text_class1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['payreceiptlist_text_class1'] ?></a></li>
					<li><a class="menuclick" id="payisclass2" href="#body" onclick="javascript:dbfilter('payisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['payreceiptlist_text_class2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['payreceiptlist_text_class2'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('order','payreceiptdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=payreceipt&action=payreceiptdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php /* 发货单据管理 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'shipreceiptlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_class_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="payisclass0" href="#body" onclick="javascript:dbfilter('payisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="payisclass1" href="#body" onclick="javascript:dbfilter('payisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_class1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_class1'] ?></a></li>
					<li><a class="menuclick" id="payisclass2" href="#body" onclick="javascript:dbfilter('payisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_class2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_class2'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('order','shipreceiptdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=shipreceipt&action=shipreceiptdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php /* 订单列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'orderlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('order','orderadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_orderadd'],'hc') ?>','index.php?archive=ordermain&action=orderadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_orderadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_orderadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype'] ?></span>
				<ul>
					<li><a class="menunoclick" id="ordertype0" href="#body" onclick="javascript:dbfilter('ordertype','ordertype',0,0,7,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="ordertype1" href="#body" onclick="javascript:dbfilter('ordertype','ordertype',1,1,7,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype1'] ?></a></li>
					<li><a class="menuclick" id="ordertype2" href="#body" onclick="javascript:dbfilter('ordertype','ordertype',2,2,7,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype2'] ?></a></li>
					<li><a class="menuclick" id="ordertype3" href="#body" onclick="javascript:dbfilter('ordertype','ordertype',3,3,7,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype3'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype3'] ?></a></li>
					<li><a class="menuclick" id="ordertype4" href="#body" onclick="javascript:dbfilter('ordertype','ordertype',4,4,7,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype4'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype4'] ?></a></li>
					<li><a class="menuclick" id="ordertype5" href="#body" onclick="javascript:dbfilter('ordertype','ordertype',5,5,7,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype5'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype5'] ?></a></li>
					<li><a class="menuclick" id="ordertype6" href="#body" onclick="javascript:dbfilter('ordertype','ordertype',6,6,7,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype6'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype6'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['ordermain_text_paysn'] ?></span>
				<ul>
					<li><a class="menunoclick" id="ispaysn0" href="#body" onclick="javascript:dbfilter('ispaysn','ispaysn',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="ispaysn1" href="#body" onclick="javascript:dbfilter('ispaysn','ispaysn',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_paysn1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_paysn1'] ?></a></li>
					<li><a class="menuclick" id="ispaysn2" href="#body" onclick="javascript:dbfilter('ispaysn','ispaysn',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_paysn2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_paysn2'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['ordermain_text_shippingsn'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isshippingsn0" href="#body" onclick="javascript:dbfilter('isshippingsn','isshippingsn',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isshippingsn1" href="#body" onclick="javascript:dbfilter('isshippingsn','isshippingsn',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_shippingsn1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_shippingsn1'] ?></a></li>
					<li><a class="menuclick" id="isshippingsn2" href="#body" onclick="javascript:dbfilter('isshippingsn','isshippingsn',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['ordermain_text_shippingsn2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_shippingsn2'] ?></a></li>
				</ul>
			</li>
			<li><a class="menuclick" id="searchall" href="#body" onclick="javascript:refreshurl('selectform')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['getalllist_botton'] ?></a></li>
		</ul>
	</li>
	<li class="menumain"><a id="search" href="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['ordermain_search_botton'] ?>','iframe:index.php?archive=ordermain&action=search&iframename='+self.frameElement.getAttribute('name'),'600px','450px','iframe',true);" title="<?php echo $this->_tpl_vars['ST']['ordermain_search_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['search_botton'] ?></a></li>
	<?php if($this->powercheck('order','orderdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=ordermain&action=orderdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>



<?php /* 询盘列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'enquirylist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isclass0" href="#body" onclick="javascript:dbfilter('isclass','isclass',0,0,4,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isclass1" href="#body" onclick="javascript:dbfilter('isclass','isclass',1,1,4,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass1'] ?></a></li>
					<li><a class="menuclick" id="isclass2" href="#body" onclick="javascript:dbfilter('isclass','isclass',2,2,4,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass2'] ?></a></li>
					<li><a class="menuclick" id="isclass3" href="#body" onclick="javascript:dbfilter('isclass','isclass',3,3,4,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass3'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass3'] ?></a></li>
				</ul>
			</li>
			<li><a class="menuclick" id="searchall" href="#body" onclick="javascript:refreshurl('selectform')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['getalllist_botton'] ?></a></li>
		</ul>
	</li>
	<li class="menumain"><a id="search" href="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['enquirymain_search_botton'] ?>','iframe:index.php?archive=enquirymain&action=search&iframename='+self.frameElement.getAttribute('name'),'600px','300px','iframe',true);" title="<?php echo $this->_tpl_vars['ST']['enquirymain_search_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['search_botton'] ?></a></li>
	<?php if($this->powercheck('order','enquirydel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=enquirymain&action=enquirydel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>


<?php /* 表单列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'formlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('communicate','formadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_formadd'],'hc') ?>','index.php?archive=formmain&action=formadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_formadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_formadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isclass0" href="#body" onclick="javascript:dbfilter('isclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isclass1" href="#body" onclick="javascript:dbfilter('isclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="isclass2" href="#body" onclick="javascript:dbfilter('isclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['formmain_isseccode_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isseccode0" href="#body" onclick="javascript:dbfilter('isseccode','isseccode',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isseccode1" href="#body" onclick="javascript:dbfilter('isseccode','isseccode',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['formmain_isseccode_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmain_isseccode_ok'] ?></a></li>
					<li><a class="menuclick" id="isseccode2" href="#body" onclick="javascript:dbfilter('isseccode','isseccode',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['formmain_isseccode_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmain_isseccode_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','formedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=formmain&action=formsetting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=formmain&action=formsetting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 表单字段列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'formattlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('communicate','formattradd')==true ){ ?>
	<li class="menumain"><a class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['formmain_attr_add'],'hc') ?>','index.php?archive=formmain&action=formattradd&fgid=<?php echo $this->_tpl_vars['fgid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addattr<?php echo $this->_tpl_vars['fgid'] ?>',self.frameElement.getAttribute('name'));" id="addattr<?php echo $this->_tpl_vars['fgid'] ?>" href="#body" title="<?php echo $this->_tpl_vars['ST']['formmain_attr_add'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmain_attr_add'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a class="selectall" id="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="attrisclass0" href="#body" onclick="javascript:dbfilter('attrisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="attrisclass1" href="#body" onclick="javascript:dbfilter('attrisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="attrisclass2" href="#body" onclick="javascript:dbfilter('attrisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['modelmanage_attr_add_isvalidate'] ?></span>
				<ul>
					<li><a class="menunoclick" id="attisvalidate0" href="#body" onclick="javascript:dbfilter('attisvalidate','isvalidate',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="attisvalidate1" href="#body" onclick="javascript:dbfilter('attisvalidate','isvalidate',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="attisvalidate2" href="#body" onclick="javascript:dbfilter('attisvalidate','isvalidate',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['formmain_attr_add_isline'] ?></span>
				<ul>
					<li><a class="menunoclick" id="memattisline0" href="#body" onclick="javascript:dbfilter('memattisline','isline',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="memattisline1" href="#body" onclick="javascript:dbfilter('memattisline','isline',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['is_yes'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['is_yes'] ?></a></li>
					<li><a class="menuclick" id="memattisline2" href="#body" onclick="javascript:dbfilter('memattisline','isline',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['is_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['is_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('communicate','delformattr')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=formmain&action=delformattr','attrselectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('communicate','formattredit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=formmain&action=attrsort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','formattredit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['user_type_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=formmain&action=attrsetting','attrselectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=formmain&action=attrsetting','attrselectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>


<?php /* 表单留言列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'messlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="isreply0" href="#body" onclick="javascript:dbfilter('isreply','isreply',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="isreply1" href="#body" onclick="javascript:dbfilter('isreply','isreply',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?></a></li>
					<li><a class="menuclick" id="isreply2" href="#body" onclick="javascript:dbfilter('isreply','isreply',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?></a></li>
				</ul>
			</li>
			<li><a class="menuclick" id="articleisorder0" href="#body" onclick="javascript:refreshurl('index.php?archive=formmessmain&action=messlist&&fgid=&isclass=&isreply=&limitkey=&limitclass=','selectform')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['getalllist_botton'] ?></a></li>
		</ul>
	</li>
	<?php if($this->powercheck('communicate','formmessagedel')==true){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=formmessmain&action=formmessagedel','messselectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=formmessmain&action=setting','messselectinfoid',true,'isreply',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=formmessmain&action=setting','messselectinfoid',true,'isreply',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
</ul>
<?php } ?>

<?php /* 主题列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'skinlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('templates','skinadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_skinadd'],'hc') ?>','index.php?archive=skinmain&action=skinadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_skinadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_skinadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['skinmain_lockin_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="lockin0" href="#body" onclick="javascript:dbfilter('lockin','lockin',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="lockin1" href="#body" onclick="javascript:dbfilter('lockin','lockin',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['skinmain_lockin_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['skinmain_lockin_botton1'] ?></a></li>
					<li><a class="menuclick" id="lockin2" href="#body" onclick="javascript:dbfilter('lockin','lockin',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['skinmain_lockin_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['skinmain_lockin_botton2'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>


<?php /* 邮件模板列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'emailtemplatelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('templates','mailtemplateadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_mailtemplateadd'],'hc') ?>','index.php?archive=mailtemplatemain&action=mailtemplateadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_mailtemplateadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_mailtemplateadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class'] ?></span>
				<ul>
					<li><a class="menunoclick" id="typeclass0" href="#body" onclick="javascript:dbfilter('typeclass','typeclass',0,0,8,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="typeclass1" href="#body" onclick="javascript:dbfilter('typeclass','typeclass','mailorder',1,8,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class1'] ?></a></li>
					<li><a class="menuclick" id="typeclass2" href="#body" onclick="javascript:dbfilter('typeclass','typeclass','mailenquiry',2,8,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class2'] ?></a></li>
					<li><a class="menuclick" id="typeclass3" href="#body" onclick="javascript:dbfilter('typeclass','typeclass','mailmember',3,8,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class3'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class3'] ?></a></li>
					<li><a class="menuclick" id="typeclass4" href="#body" onclick="javascript:dbfilter('typeclass','typeclass','mailform',4,8,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class4'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class4'] ?></a></li>
					<li><a class="menuclick" id="typeclass5" href="#body" onclick="javascript:dbfilter('typeclass','typeclass','mailbbs',5,8,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class5'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class5'] ?></a></li>
					<li><a class="menuclick" id="typeclass6" href="#body" onclick="javascript:dbfilter('typeclass','typeclass','maildocbbs',6,8,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class6'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class6'] ?></a></li>
					<li><a class="menuclick" id="typeclass7" href="#body" onclick="javascript:dbfilter('typeclass','typeclass','mailother',7,8,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class7'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class7'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_lockin_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="lockin0" href="#body" onclick="javascript:dbfilter('lockin','lockin',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="lockin1" href="#body" onclick="javascript:dbfilter('lockin','lockin',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_lockin_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_lockin_botton1'] ?></a></li>
					<li><a class="menuclick" id="lockin2" href="#body" onclick="javascript:dbfilter('lockin','lockin',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_lockin_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_lockin_botton2'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php /* 打印模板列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'printlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('templates','printadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_printadd'],'hc') ?>','index.php?archive=printtemplatemain&action=printadd&tab=true&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_printadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_printadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['printtemplatemain_lockin_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="lockin0" href="#body" onclick="javascript:dbfilter('lockin','lockin',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="lockin1" href="#body" onclick="javascript:dbfilter('lockin','lockin',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['printtemplatemain_lockin_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['printtemplatemain_lockin_botton1'] ?></a></li>
					<li><a class="menuclick" id="lockin2" href="#body" onclick="javascript:dbfilter('lockin','lockin',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['printtemplatemain_lockin_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['printtemplatemain_lockin_botton2'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>


<?php /* 广告列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'advertlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('communicate','advertadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_advert'],'hc') ?>','index.php?archive=advertmain&action=advertadd&atid=<?php echo $this->_tpl_vars['tabarray']['atid'] ?>&type=add&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_advert'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_advert'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="articleisclass0" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="articleisclass1" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?></a></li>
					<li><a class="menuclick" id="articleisclass2" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_audit_no'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['advertmain_text_istime'] ?></span>
				<ul>
					<li><a class="menunoclick" id="istime0" href="#body" onclick="javascript:dbfilter('istime','istime',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="istime1" href="#body" onclick="javascript:dbfilter('istime','istime',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?></a></li>
					<li><a class="menuclick" id="istime2" href="#body" onclick="javascript:dbfilter('istime','istime',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_audit_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('communicate','advertdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=advertmain&action=advertdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<?php if($this->powercheck('communicate','advertedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=advertmain&action=sort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all','infoid','infopid');" href="#body" title="<?php echo $this->_tpl_vars['ST']['article_log_sort'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','advertedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=advertmain&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=advertmain&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 广告位列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'adverttypelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('communicate','adverttypeadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_adverttype'],'hc') ?>','index.php?archive=adverttypemain&action=adverttypeadd&type=add&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_adverttype'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_adverttype'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="articleisclass0" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="articleisclass1" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_audit_ok'] ?></a></li>
					<li><a class="menuclick" id="articleisclass2" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['article_audit_no'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_audit_no'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('communicate','adverttypedel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=adverttypemain&action=adverttypedel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','adverttypeedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=adverttypemain&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=adverttypemain&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>


<?php /* 文章跟贴列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'acmessagelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="articleisclass0" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="articleisclass1" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['infook_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infook_botton'] ?></a></li>
					<li><a class="menuclick" id="articleisclass2" href="#body" onclick="javascript:dbfilter('articleisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['lockok_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockok_botton'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="articlemessisreply0" href="#body" onclick="javascript:dbfilter('articlemessisreply','isreply',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="articlemessisreply1" href="#body" onclick="javascript:dbfilter('articlemessisreply','isreply',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?></a></li>
					<li><a class="menuclick" id="articlemessisreply2" href="#body" onclick="javascript:dbfilter('articlemessisreply','isreply',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('article','acmessagedel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=acmessagemain&action=acmessagedel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('article','acmessagere')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=acmessagemain&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['infook_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infook_botton'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=acmessagemain&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['lockok_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockok_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>


<?php /* 留言版块列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'bbstypelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('communicate','bbstypeadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_bbstypeadd'],'hc') ?>','index.php?archive=bbstypemain&action=bbstypeadd&type=add&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_bbstypeadd'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_bbstypeadd'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="typeisclass0" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass1" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['infook_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infook_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass2" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['lockok_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockok_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('communicate','bbstypeedit')==true ){ ?>
	<li class="menumain"><a id="sortall" onclick="javascript:sortinput('index.php?archive=bbstypemain&action=sort','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['sort_messok'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['pid_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','bbstypeedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=bbstypemain&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=bbstypemain&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>


<?php /* 话题列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'bbsmainlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="bbsnoreply0" href="#body" onclick="javascript:dbfilter('bbsnoreply','noreply',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="bbsnoreply1" href="#body" onclick="javascript:dbfilter('bbsnoreply','noreply',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?></a></li>
					<li><a class="menuclick" id="bbsnoreply2" href="#body" onclick="javascript:dbfilter('bbsnoreply','noreply',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['forummain_istop_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="bbsistop0" href="#body" onclick="javascript:dbfilter('bbsistop','istop',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="bbsistop1" href="#body" onclick="javascript:dbfilter('bbsistop','istop',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" id="bbsistop2" href="#body" onclick="javascript:dbfilter('bbsistop','istop',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="bbsisclass0" href="#body" onclick="javascript:dbfilter('bbsisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="bbsisclass1" href="#body" onclick="javascript:dbfilter('bbsisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['infook_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infook_botton'] ?></a></li>
					<li><a class="menuclick" id="bbsisclass2" href="#body" onclick="javascript:dbfilter('bbsisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['lockok_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockok_botton'] ?></a></li>
				</ul>
			</li>
			<li><a class="menuclick" id="articleisorder0" href="#body" onclick="javascript:refreshurl('index.php?archive=bbsmain&action=forumlist&lng=&btid=&isclass=&blid=&linkebid=&istop=&recommend=&purview=&noreply=&limitkey=&limitclass=','selectform')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['getalllist_botton'] ?></a></li>
		</ul>
	</li>
	<li class="menumain"><a id="search" href="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['forummain_search_title'] ?>','iframe:index.php?archive=bbsmain&action=search&iframename='+self.frameElement.getAttribute('name'),'550px','250px','iframe',true);" title="<?php echo $this->_tpl_vars['ST']['forummain_search_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['search_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','bbsmaindel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=bbsmain&action=bbsmaindel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','bbsmainedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=bbsmain&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=bbsmain&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['forummain_istop_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=bbsmain&action=setting','selectinfoid',true,'istop',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=bbsmain&action=setting','selectinfoid',true,'istop',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=bbsmain&action=setting','selectinfoid',true,'replynum',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton2'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=bbsmain&action=setting','selectinfoid',true,'replynum',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_isreply_botton1'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 文件管理 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'fileadminlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('communicate','mkdir')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['creatfile_botton'],'hc') ?>','index.php?archive=filemain&action=mkdir&path='+escape(document.getElementById('filepath').value)+'&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),true,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['creatfile_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['creatfile_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','delfile')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:delfile('index.php?archive=filemain&action=delfile','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all','filepath');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php /* 相册列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'albumadminlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('communicate','albumadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_album'],'hc') ?>','index.php?archive=albummain&action=albumadd&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_album'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_album'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="typeisclass0" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass1" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['infook_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infook_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass2" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['lockok_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockok_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('communicate','albumdel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=albummain&action=albumdel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','albumedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=albummain&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=albummain&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 相册文件列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'albumfilelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<?php if($this->powercheck('communicate','albumfiledel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=albummain&action=albumfiledel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
</ul>
<?php } ?>

<?php /* 邮件订阅管理 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'mailinvitelist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('marketing','mailinviteadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_mailinvite'],'hc') ?>','index.php?archive=mailinvite&action=mailinviteadd&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_mailinvite'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_mailinvite'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="typeisclass0" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass1" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['infook_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infook_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass2" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['lockok_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockok_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('marketing','mailinvitedel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=mailinvite&action=mailinvitedel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('marketing','mailinviteedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=mailinvite&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=mailinvite&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'mailinvitesendlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="typeisclass0" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass1" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['infook_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infook_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass2" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['lockok_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockok_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('marketing','mailinvitemaildel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=mailinvite&action=mailinvitemaildel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('marketing','mailinvitemailedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=mailinvite&action=mailsetting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=mailinvite&action=mailsetting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<?php /* 邮件群发 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'mailsendlist'){ ?>
<ul class="listbottonul" id="listbottonul">
	<?php if($this->powercheck('marketing','mailsendadd')==true ){ ?>
	<li class="menumain"><a id="addinfo" class="addinfo" onclick="javascript:parent.onbotton('<?php echo $this->addslashes($this->_tpl_vars['ST']['botton_add_mailsend'],'hc') ?>','index.php?archive=mailsendmain&action=mailsendadd&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),false,'addinfo',self.frameElement.getAttribute('name'));"  href="#body" title="<?php echo $this->_tpl_vars['ST']['botton_add_mailsend'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['botton_add_mailsend'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="selectall" class="selectall" href="javascript:select_change(true,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['selAll_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['selAll_botton'] ?></a></li>
	<li class="menumain"><a id="bolt" href="#body" hidefocus="true" hidefocus="true"><?php echo $this->_tpl_vars['ST']['bolt_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_botton'] ?></span>
				<ul>
					<li><a class="menunoclick" id="typeisclass0" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',0,0,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['all_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['all_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass1" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',1,1,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['infook_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['infook_botton'] ?></a></li>
					<li><a class="menuclick" id="typeisclass2" href="#body" onclick="javascript:dbfilter('typeisclass','isclass',2,2,3,'selectform','selectall','check_all')" title="<?php echo $this->_tpl_vars['ST']['lockok_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['lockok_botton'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php if($this->powercheck('marketing','mailsenddel')==true ){ ?>
	<li class="menumain"><a id="del" onclick="javascript:callrun('index.php?archive=mailsendmain&action=mailsenddel','selectinfoid',false,null,null,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['del_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" href="#body" hidefocus="true"><?php echo $this->_tpl_vars['ST']['del_botton'] ?></a></li>
	<?php } ?>
	<li class="menumain"><a id="refresh" href="#body" onclick="javascript:refresh('selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['refresh_botton'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['refresh_botton'] ?></a></li>
	<?php if($this->powercheck('marketing','mailsendedit')==true ){ ?>
	<li class="menumain"><a id="setbotton" href="#body" hidefocus="true" title="<?php echo $this->_tpl_vars['ST']['set_botton'] ?>"><?php echo $this->_tpl_vars['ST']['set_botton'] ?></a>
		<ul class="menulist">
			<li><span class="menufont"><?php echo $this->_tpl_vars['ST']['lock_set_botton'] ?></span>
				<ul>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=mailsendmain&action=setting','selectinfoid',true,'isclass',1,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['open_botton_title'] ?></a></li>
					<li><a class="menuclick" href="#body" onclick="javascript:callrun('index.php?archive=mailsendmain&action=setting','selectinfoid',true,'isclass',0,'index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['update_messok'] ?>','<?php echo $this->_tpl_vars['ST']['select_no'] ?>',true,'<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>','selectform','selectall','check_all');" title="<?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['close_botton_title'] ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	<?php } ?>
</ul>
<?php } ?>
