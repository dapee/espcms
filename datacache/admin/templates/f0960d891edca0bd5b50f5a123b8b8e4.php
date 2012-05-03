<?php if($this->_tpl_vars['menutype'] == 'loglist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['loglist_text_id'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['loglist_text_username'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['loglist_text_time'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['loglist_text_ip'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['loglist_text_function'] ?></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['loglist_text_mess'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'mangerlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" value="1" id="check_all" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="6%"><?php echo $this->_tpl_vars['ST']['mangerlist_text_id'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['mangerlist_text_username'] ?></td>
		<td width="13%"><?php echo $this->_tpl_vars['ST']['mangerlist_text_name'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['mangerlist_text_group'] ?></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['mangerlist_text_addtime'] ?></td>
		<td width="5%"><?php echo $this->_tpl_vars['ST']['mangerlist_text_hit'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['mangerlist_text_ip'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['mangerlist_text_class'] ?></td>
		<td width="16%"><?php echo $this->_tpl_vars['ST']['mangerlist_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'grouplist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['grouplist_text_id'] ?></td>
		<td width="60%"><?php echo $this->_tpl_vars['ST']['grouplist_text_name'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['grouplist_text_class'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['grouplist_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'sqllist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['sqllist_text_name'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['sqllist_text_type'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['sqllist_text_count'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['sqllist_text_size'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['sqllist_text_osize'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['sqllist_text_class'] ?></td>
		<td width="13%"><?php echo $this->_tpl_vars['ST']['sqllist_text_encode'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['sqllist_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'languagelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','asc','#btlimit_pid','#limit_pid','#limit_id','selectform','selectall','check_all')" hidefocus="true"><?php echo $this->_tpl_vars['ST']['language_text_pid'] ?></a><span id="limit_pid" class="limitdesc displaynone"></span></td>
		<td width="8%"><a id="btlimit_id" class="infolink06" href="javascript:onlimit('id','asc','#btlimit_id','#limit_id','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['language_text_id'] ?></a><span id="limit_id" class="limitdesc"></span></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['language_text_name'] ?></td>
		<td width="13%"><?php echo $this->_tpl_vars['ST']['language_text_key'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['language_text_class'] ?></td>
		<td width="38%"><?php echo $this->_tpl_vars['ST']['language_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'lanpacklist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="5%"><a id="btlimit_id" class="infolink06" href="javascript:onlimit('lpid','desc','#btlimit_id','#limit_id','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['languagepack_text_id'] ?></a><span id="limit_id" class="limitasc"></span></td>
		<td width="21%"><?php echo $this->_tpl_vars['ST']['languagepack_text_title'] ?></td>
		<td width="18%"><?php echo $this->_tpl_vars['ST']['languagepack_text_key'] ?></td>
		<td width="42%"><?php echo $this->_tpl_vars['ST']['languagepack_text_langstr'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['languagepack_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'callinglist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','asc','#btlimit_pid','#limit_pid','#limit_id','selectform','selectall','check_all')" hidefocus="true"><?php echo $this->_tpl_vars['ST']['callmain_text_pid'] ?></a><span id="limit_pid" class="limitdesc displaynone"></span></td>
		<td width="10%"><a id="btlimit_id" class="infolink06" href="javascript:onlimit('cid','asc','#btlimit_id','#limit_id','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['callmain_text_id'] ?></a><span id="limit_id" class="limitdesc"></span></td>
		<td width="30%"><?php echo $this->_tpl_vars['ST']['callmain_text_name'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['callmain_text_type'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['callmain_text_class'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['callmain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'seolinklist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','asc','#btlimit_pid','#limit_pid','#limit_id','selectform','selectall','check_all')" hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_text_pid'] ?></a><span id="limit_pid" class="limitdesc displaynone"></span></td>
		<td width="10%"><a id="btlimit_id" class="infolink06" href="javascript:onlimit('kid','asc','#btlimit_id','#limit_id','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_text_kid'] ?></a><span id="limit_id" class="limitdesc"></span></td>
		<td width="30%"><?php echo $this->_tpl_vars['ST']['seomanage_text_keywordname'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['seomanage_text_hit'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['seomanage_text_islink'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['seomanage_text_class'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['seomanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 内链接TAB列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'keywordlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['seomanage_text_kid'] ?></td>
		<td><?php echo $this->_tpl_vars['ST']['seomanage_text_keywordname'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'keytypewordlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['seomanage_text_kid'] ?></td>
		<td width="42%"><?php echo $this->_tpl_vars['ST']['seomanage_add_keyworklist'] ?></td>
		<td width="42%"><?php echo $this->_tpl_vars['ST']['seomanage_add_description'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['seomanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'seolinktypelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><a id="btlimit_id" class="infolink06" href="javascript:onlimit('ktid','asc','#btlimit_id','#limit_id','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['seomanage_text_kid'] ?></a><span id="limit_id" class="limitdesc"></span></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['lng_title'] ?></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['seomanage_text_keywordtypename'] ?></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['seomanage_text_keywordnamelist'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['seomanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>

<?php if($this->_tpl_vars['menutype'] == 'modellist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><a id="btlimit_id" class="infolink06" href="javascript:onlimit('mid','asc','#btlimit_id','#limit_id','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['modelmanage_text_mid'] ?></a><span id="limit_id" class="limitdesc"></span></td>
		<td width="50%"><?php echo $this->_tpl_vars['ST']['modelmanage_text_modelname'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['modelmanage_text_class'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['modelmanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'modelattlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="6%"><a id="btlimit_attr_pid" class="infolink06" href="javascript:onlimit('pid','asc','#btlimit_attr_pid','#limit_attr_pid','#limit_attr_aid','selectform','selectall','check_all')" hidefocus="true"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_pid'] ?></a><span id="limit_attr_pid" class="limitdesc displaynone"></span></td>
		<td width="6%"><a id="btlimit_attr_aid" class="infolink06" href="javascript:onlimit('aid','asc','#btlimit_attr_aid','#limit_attr_aid','#limit_attr_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['modelmanage_text_mid'] ?></a><span id="limit_attr_aid" class="limitdesc"></span></td>
		<td width="18%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_modelname'] ?></td>
		<td width="17%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_attrname'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_type'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_issearch'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_isvalidate'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_issys'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['modelmanage_attr_isclass_validatetext'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['modelmanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'typelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="3%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="6%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','desc','#btlimit_pid','#limit_pid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['typemanage_text_pid'] ?></a><span id="limit_pid" class="limitasc"></span></td>
		<td width="5%"><?php echo $this->_tpl_vars['ST']['typemanage_text_tid'] ?></td>
		<td width="22%"><?php echo $this->_tpl_vars['ST']['typemanage_text_typename'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['typemanage_text_purview'] ?></td>
		<!--<td width="13%"><?php echo $this->_tpl_vars['ST']['modelmanage_text_class'] ?></td>
		<td width="33%"><?php echo $this->_tpl_vars['ST']['modelmanage_text_set'] ?></td>
		-->
		<td width="56%"><?php echo $this->_tpl_vars['ST']['modelmanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'articlelist' || $this->_tpl_vars['menutype'] == 'modelarticlelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="7%"><a id="ddbtlimit_pid" class="infolink06" href="javascript:onlimit('pid','desc','#ddbtlimit_pid','#ddlimit_pid','#limit_did','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_text_pid'] ?></a><span id="ddlimit_pid" class="limitdesc displaynone"></span></td>
		<td width="7%"><a id="btlimit_did" class="infolink06" href="javascript:onlimit('did','asc','#btlimit_did','#limit_did','#ddlimit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['article_text_did'] ?></a><span id="limit_did" class="limitdesc"></span></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['article_text_title'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['article_text_type'] ?></td>
		<td width="11%"><?php echo $this->_tpl_vars['ST']['article_text_class'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['article_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'subjectlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','desc','#btlimit_pid','#limit_pid','#limit_sid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['subjectmanage_text_pid'] ?></a><span id="limit_pid" class="limitdesc displaynone"></span></td>
		<td width="8%"><a id="btlimit_sid" class="infolink06" href="javascript:onlimit('sid','asc','#btlimit_sid','#limit_sid','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['subjectmanage_text_tid'] ?></a><span id="limit_sid" class="limitdesc"></span></td>
		<td width="6%"><?php echo $this->_tpl_vars['ST']['lng_title'] ?></td>
		<td width="34%"><?php echo $this->_tpl_vars['ST']['subjectmanage_text_subjectname'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['subjectmanage_text_purview'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['subjectmanage_text_class'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['subjectmanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'recomlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="8%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><a id="btlimit_dlid" class="infolink06" href="javascript:onlimit('dlid','asc','#btlimit_dlid','#limit_dlid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['recommanage_text_tid'] ?></a><span id="limit_dlid" class="limitdesc"></span></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['lng_title'] ?></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['recommanage_text_labelname'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['recommanage_text_mid'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['recommanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'memclasslist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['memclassmanage_text_mcid'] ?></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['memclassmanage_text_rankname'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['memclassmanage_text_inter'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['memclassmanage_text_isinter'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['memclassmanage_text_class'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['memclassmanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'memberattlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','desc','#btlimit_pid','#limit_pid','#limit_maid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['memattmanage_text_pid'] ?></a><span id="limit_pid" class="limitdesc displaynone"></span></td>
		<td width="8%"><a id="btlimit_maid" class="infolink06" href="javascript:onlimit('maid','asc','#btlimit_maid','#limit_maid','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['memattmanage_text_mcid'] ?></a><span id="limit_maid" class="limitdesc"></span></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['memattmanage_text_typename'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['memattmanage_text_attrname'] ?></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['memattmanage_text_type'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['memattmanage_text_isvalidate'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['memattmanage_text_class'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['memattmanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 会员列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'memberlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_userid" class="infolink06" href="javascript:onlimit('userid','asc','#btlimit_userid','#limit_userid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['membermain_text_did'] ?></a><span id="limit_userid" class="limitdesc"></span></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['membermain_text_username'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['membermain_text_rankname'] ?></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['membermain_text_email'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['membermain_text_integral'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['membermain_text_visitcount'] ?></td>
		<td width="5%"><?php echo $this->_tpl_vars['ST']['membermain_text_class'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['membermain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'shiplist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','desc','#btlimit_pid','#limit_pid','#limit_osid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordershipping_text_pid'] ?></a><span id="limit_pid" class="limitdesc displaynone"></span></td>
		<td width="10%"><a id="btlimit_osid" class="infolink06" href="javascript:onlimit('osid','asc','#btlimit_osid','#limit_osid','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordershipping_text_osid'] ?></a><span id="limit_osid" class="limitdesc"></span></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['ordershipping_text_name'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['ordershipping_text_price'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordershipping_text_iscash'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordershipping_text_isinsure'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordershipping_text_class'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordershipping_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 支付方式列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'paylist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','desc','#btlimit_pid','#limit_pid','#limit_opid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['orderpay_text_pid'] ?></a><span id="limit_pid" class="limitdesc displaynone"></span></td>
		<td width="10%"><a id="btlimit_opid" class="infolink06" href="javascript:onlimit('opid','asc','#btlimit_opid','#limit_opid','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['orderpay_text_opid'] ?></a><span id="limit_opid" class="limitdesc"></span></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['orderpay_text_name'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['orderpay_text_paycode'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['orderpay_text_price'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['orderpay_text_payplugver'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['orderpay_text_class'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['orderpay_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'payreceiptlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_oprid" class="infolink06" href="javascript:onlimit('oprid','asc','#btlimit_oprid','#limit_oprid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['payreceiptlist_text_oprid'] ?></a><span id="limit_oprid" class="limitdesc"></span></td>
		<td width="23%"><?php echo $this->_tpl_vars['ST']['payreceiptlist_text_paysn'] ?></td>
		<td width="22%"><?php echo $this->_tpl_vars['ST']['payreceiptlist_text_ordersn'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['payreceiptlist_text_orderamount'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['payreceiptlist_text_bankaccount'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['payreceiptlist_text_class'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['payreceiptlist_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'shipreceiptlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_osrid" class="infolink06" href="javascript:onlimit('osrid','asc','#btlimit_osrid','#limit_osrid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_oprid'] ?></a><span id="limit_osrid" class="limitdesc"></span></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_shippingsn'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_ordersn'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_shippingmoney'] ?></td>
		<td width="17%"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_addtime'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_class'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['shipreceiptlist_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'orderlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="7%"><a id="btlimit_osrid" class="infolink06" href="javascript:onlimit('oid','asc','#btlimit_osrid','#limit_osrid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['ordermain_text_oid'] ?></a><span id="limit_osrid" class="limitdesc"></span></td>
		<td width="16%"><?php echo $this->_tpl_vars['ST']['ordermain_text_ordersn'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['ordermain_text_ordertype'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordermain_text_money'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordermain_text_consignee'] ?></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['ordermain_text_addtime'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordermain_text_paysn'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordermain_text_shippingsn'] ?></td>
		<td width="11%"><?php echo $this->_tpl_vars['ST']['ordermain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'orderaddlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_id'] ?></td>
		<td width="84%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_name'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'orderaddendlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_id'] ?></td>
		<td width="60%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_name'] ?></td>
		<td width="11%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_price'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_count'] ?></td>
		<td width="11%"><?php echo $this->_tpl_vars['ST']['ordermain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'orderaddendlistedit'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_id'] ?></td>
		<td width="50%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_name'] ?></td>
		<td width="11%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_price'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_count'] ?></td>
		<td width="11%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_total'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'enquirylist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><a id="btlimit_osrid" class="infolink06" href="javascript:onlimit('eid','asc','#btlimit_osrid','#limit_osrid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['enquirymain_text_eid'] ?></a><span id="limit_osrid" class="limitdesc"></span></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['enquirymain_text_enquirysn'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['enquirymain_text_linkman'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['enquirymain_text_userid'] ?></td>
		<td width="17%"><?php echo $this->_tpl_vars['ST']['enquirymain_text_addtime'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['enquirymain_text_isclass'] ?></td>
		<td width="13%"><?php echo $this->_tpl_vars['ST']['enquirymain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'enquiryaddendlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['enquirymain_infolist_text_id'] ?></td>
		<td width="50%"><?php echo $this->_tpl_vars['ST']['enquirymain_infolist_text_name'] ?></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['enquirymain_infolist_text_sn'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['ordermain_infolist_text_count'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'formlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="6%"><a id="btlimit_fgid" class="infolink06" href="javascript:onlimit('fgid','asc','#btlimit_fgid','#limit_fgid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmain_text_mid'] ?></a><span id="limit_fgid" class="limitdesc"></span></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['formmain_text_lng'] ?></td>
		<td width="39%"><?php echo $this->_tpl_vars['ST']['formmain_text_formgroupname'] ?></td>
		<td width="6%"><?php echo $this->_tpl_vars['ST']['formmain_text_ismenu'] ?></td>
		<td width="6%"><?php echo $this->_tpl_vars['ST']['formmain_text_class'] ?></td>
		<td width="30%"><?php echo $this->_tpl_vars['ST']['formmain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php if($this->_tpl_vars['menutype'] == 'formattlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','desc','#btlimit_pid','#limit_pid','#limit_maid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmain_att_text_pid'] ?></a><span id="limit_pid" class="limitdesc displaynone"></span></td>
		<td width="8%"><a id="btlimit_maid" class="infolink06" href="javascript:onlimit('faid','asc','#btlimit_maid','#limit_maid','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmain_text_mid'] ?></a><span id="limit_maid" class="limitdesc"></span></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_modelname'] ?></td>
		<td width="17%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_attrname'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_type'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['formmain_att_text_isline'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['modelmanage_att_text_isvalidate'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['modelmanage_attr_isclass_validatetext'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['modelmanage_text_set'] ?></td>

	</tr>
</table>
<?php } ?>
<?php /* 表单留言列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'messlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><a id="btlimit_fvid" class="infolink06" href="javascript:onlimit('fvid','asc','#btlimit_fvid','#limit_fvid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['formmessmain_text_tid'] ?></a><span id="limit_fgid" class="limitdesc"></span></td>
		<td width="60%"><?php echo $this->_tpl_vars['ST']['formmessmain_text_addtime'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['formmessmain_text_reclass'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['formmessmain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 网站主题列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'skinlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><a id="btlimit_skid" class="infolink06" href="javascript:onlimit('skid','asc','#btlimit_skid','#limit_skid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['skinmain_text_mid'] ?></a><span id="limit_skid" class="limitdesc"></span></td>
		<td width="35%"><?php echo $this->_tpl_vars['ST']['skinmain_text_title'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['skinmain_text_code'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['skinmain_text_lockin'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['skinmain_text_class'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['skinmain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 网站模板列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'templatelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="45%"><?php echo $this->_tpl_vars['ST']['templatemain_text_title'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['templatemain_text_class'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['templatemain_text_time'] ?></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['templatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 网站模板Tab选择列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'templatestab'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['templatemain_text_mid'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['templatemain_text_lng'] ?></td>
		<td width="22%"><?php echo $this->_tpl_vars['ST']['templatemain_text_title'] ?></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['templatemain_text_code'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['templatemain_text_class'] ?></td>
		<td width="12%"><?php echo $this->_tpl_vars['ST']['templatemain_text_fileclass'] ?></td>
		<td><?php echo $this->_tpl_vars['ST']['templatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 邮件模板列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'emailtemplatelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="7%"><a id="btlimit_skid" class="infolink06" href="javascript:onlimit('tmid','asc','#btlimit_skid','#limit_skid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_mid'] ?></a><span id="limit_skid" class="limitdesc"></span></td>
		<td width="5%"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_lng'] ?></td>
		<td width="28%"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_title'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_templatecode'] ?></td>
		<td width="17%"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_class'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_lockin'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 打印邮件单据 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'printlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="10%"><a id="btlimit_skid" class="infolink06" href="javascript:onlimit('tmid','asc','#btlimit_skid','#limit_skid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['printtemplatemain_text_mid'] ?></a><span id="limit_skid" class="limitdesc"></span></td>
		<td width="60%"><?php echo $this->_tpl_vars['ST']['printtemplatemain_text_title'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['printtemplatemain_text_lockin'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['printtemplatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 广告列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'advertlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="bbslimit_pid" class="infolink06" href="javascript:onlimit('pid','desc','#bbslimit_pid','#bbs_limit_pid','#bbs_limit_adid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['language_text_pid'] ?></a><span id="bbs_limit_pid" class="limitdesc displaynone"></span></td>
		<td width="8%"><a id="bbslimit_adid" class="infolink06" href="javascript:onlimit('adid','asc','#bbslimit_adid','#bbs_limit_adid','#bbs_limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forummain_text_mid'] ?></a><span id="bbs_limit_adid" class="limitdesc"></span></td>
		<td width="38%"><?php echo $this->_tpl_vars['ST']['advertmain_text_title'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['advertmain_text_type'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['advertmain_text_class'] ?></td>
		<td width="13%"><?php echo $this->_tpl_vars['ST']['printtemplatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 广告位置列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'adverttypelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><a id="bbslimit_adid" class="infolink06" href="javascript:onlimit('atid','asc','#bbslimit_adid','#bbs_limit_adid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forummain_text_mid'] ?></a><span id="bbs_limit_adid" class="limitdesc"></span></td>
		<td width="30%"><?php echo $this->_tpl_vars['ST']['adverttypemain_text_title'] ?></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['adverttypemain_text_size'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['advertmain_text_class'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['printtemplatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 内容跟贴留言列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'acmessagelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="7%"><a id="bbslimit_adid" class="infolink06" href="javascript:onlimit('dmid','asc','#bbslimit_adid','#bbs_limit_adid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forummain_text_mid'] ?></a><span id="bbs_limit_adid" class="limitdesc"></span></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['acmessagelmain_text_ip'] ?></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['acmessagelmain_text_name'] ?></td>
		<td width="6%"><?php echo $this->_tpl_vars['ST']['acmessagelmain_text_support'] ?></td>
		<td width="6%"><?php echo $this->_tpl_vars['ST']['acmessagelmain_text_oppose'] ?></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['acmessagelmain_text_addtime'] ?></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['acmessagelmain_text_retime'] ?></td>
		<td width="6%"><?php echo $this->_tpl_vars['ST']['acmessagelmain_text_isreply'] ?></td>
		<td width="6%"><?php echo $this->_tpl_vars['ST']['acmessagelmain_text_isclass'] ?></td>
		<td width="9%"><?php echo $this->_tpl_vars['ST']['printtemplatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 论坛分类列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'bbstypelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="4%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="7%"><a id="btlimit_pid" class="infolink06" href="javascript:onlimit('pid','desc','#btlimit_pid','#limit_pid','#limit_sid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forumtype_text_pid'] ?></a><span id="limit_pid" class="limitdesc displaynone"></span></td>
		<td width="7%"><a id="btlimit_sid" class="infolink06" href="javascript:onlimit('btid','asc','#btlimit_sid','#limit_sid','#limit_pid','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forumtype_text_tid'] ?></a><span id="limit_sid" class="limitdesc"></span></td>
		<td width="6%"><?php echo $this->_tpl_vars['ST']['lng_title'] ?></td>
		<td width="30%"><?php echo $this->_tpl_vars['ST']['forumtype_text_subjectname'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['forumtype_text_purview'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['formmain_text_ismenu'] ?></td>
		<td width="11%"><?php echo $this->_tpl_vars['ST']['forumtype_text_class'] ?></td>
		<td width="18%"><?php echo $this->_tpl_vars['ST']['forumtype_text_set'] ?></td>
	</tr>
</table>
<?php } ?>
<?php /* 话题列表 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'bbsmainlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="3%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="7%"><a id="bbslimit_bid" class="infolink06" href="javascript:onlimit('bid','asc','#bbslimit_bid','#bbs_limit_bid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forummain_text_mid'] ?></a><span id="bbs_limit_bid" class="limitdesc"></span></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['forummain_text_title'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['formmessmain_text_addtime'] ?></td>
		<td width="5%"><?php echo $this->_tpl_vars['ST']['forummain_text_replynum'] ?></td>
		<td width="5%"><?php echo $this->_tpl_vars['ST']['forummain_text_istop'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['forummain_text_class'] ?></td>
		<td width="17%"><?php echo $this->_tpl_vars['ST']['forummain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>

<?php /* 图片列表选择窗口 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'filelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('filemodelattselectform','fileselectall','check_all');"/></td>
		<td width="35%"><?php echo $this->_tpl_vars['ST']['filemanage_text_name'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['filemanage_text_size'] ?></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['filemanage_text_time'] ?></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['filemanage_text_set'] ?></td>
	</tr>
</table>
<?php } ?>

<?php /* 网站文件管理 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'fileadminlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['filemanage_text_name'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['filemanage_text_size'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['templatemain_text_time'] ?></td>
		<td width="25%"><?php echo $this->_tpl_vars['ST']['templatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>


<?php /* 相册管理 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'albumadminlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="10%"><a id="btlimit_amid" class="infolink06" href="javascript:onlimit('amid','asc','#btlimit_amid','#limit_amid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forumtype_text_tid'] ?></a><span id="limit_amid" class="limitdesc"></span></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['albummain_text_name'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['templatemain_text_time'] ?></td>
		<td width="10%"><?php echo $this->_tpl_vars['ST']['forumtype_text_class'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['templatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>

<?php /* 相册文件管理 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'albumfilelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_amid" class="infolink06" href="javascript:onlimit('afid','asc','#btlimit_amid','#limit_amid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forumtype_text_tid'] ?></a><span id="limit_amid" class="limitdesc"></span></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['albummain_text_file_name'] ?></td>
		<td width="20%"><?php echo $this->_tpl_vars['ST']['filemanage_text_name'] ?></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['templatemain_text_time'] ?></td>
		<td width="13%"><?php echo $this->_tpl_vars['ST']['templatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>

<?php /* 邮件订阅分类 */ ?>
<?php if($this->_tpl_vars['menutype'] == 'mailinvitelist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_amid" class="infolink06" href="javascript:onlimit('mlvid','asc','#btlimit_amid','#limit_amid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forumtype_text_tid'] ?></a><span id="limit_amid" class="limitdesc"></span></td>
		<td width="34%"><?php echo $this->_tpl_vars['ST']['mailinvite_text_title'] ?></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['templatemain_text_time'] ?></td>
		<td width="7%"><?php echo $this->_tpl_vars['ST']['forumtype_text_class'] ?></td>
		<td width="32%"><?php echo $this->_tpl_vars['ST']['templatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>

<?php if($this->_tpl_vars['menutype'] == 'mailinvitesendlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_amid" class="infolink06" href="javascript:onlimit('mlvid','asc','#btlimit_amid','#limit_amid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forumtype_text_tid'] ?></a><span id="limit_amid" class="limitdesc"></span></td>
		<td width="40%"><?php echo $this->_tpl_vars['ST']['mailinvite_mail_text_mail'] ?></td>
		<td width="14%"><?php echo $this->_tpl_vars['ST']['mailinvite_mail_text_name'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['templatemain_text_time'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['forumtype_text_class'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['templatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>

<?php if($this->_tpl_vars['menutype'] == 'mailsendlist'){ ?>
<table border="0" width="100%" bordercolor="#FFFFFF">
	<tr>
		<td width="5%"><input type="checkbox" name="check_all" id="check_all" value="1" onClick="select_ok('selectform','selectall','check_all');"/></td>
		<td width="8%"><a id="btlimit_amid" class="infolink06" href="javascript:onlimit('mlvid','asc','#btlimit_amid','#limit_amid','','selectform','selectall','check_all')"  hidefocus="true"><?php echo $this->_tpl_vars['ST']['forumtype_text_tid'] ?></a><span id="limit_amid" class="limitdesc"></span></td>
		<td width="26%"><?php echo $this->_tpl_vars['ST']['mailinvite_send_text_title'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['mailinvite_send_text_sendhow'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['mailinvite_send_text_sendtime'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['templatemain_text_time'] ?></td>
		<td width="8%"><?php echo $this->_tpl_vars['ST']['forumtype_text_class'] ?></td>
		<td width="15%"><?php echo $this->_tpl_vars['ST']['templatemain_text_set'] ?></td>
	</tr>
</table>
<?php } ?>