<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['softtitle'] ?></title>
<link href="templates/css/baselist.css" rel="stylesheet" type="text/css" />
<link href="templates/css/all.css" rel="stylesheet" type="text/css" />
<link href="templates/css/formdiv.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/control.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript">

	var resizewindow= null;

	window.onresize = function(){
		var h = $(window).height();
		if(resizewindow!=h){
			sizewindow();
			resizewindow=h;
		}
	}

	function sizewindow(){
		var h = $(window).height();
		if(document.getElementById("mainbodybottonauto")){
			$('.managebottonadd').css({height:h-40});
		}
	}
	var mangerlist_js_useranme_empty  = "<?php echo $this->_tpl_vars['ST']['mangerlist_js_useranme_empty'] ?>";
	var mangerlist_js_password_empty = "<?php echo $this->_tpl_vars['ST']['mangerlist_js_password_empty'] ?>";
	var mangerlist_js_password_error = "<?php echo $this->_tpl_vars['ST']['mangerlist_js_password_error'] ?>";
	var mangerlist_js_add_ok = "<?php echo $this->_tpl_vars['ST']['mangerlist_js_add_ok'] ?>";
	var mangerlist_js_add_no = "<?php echo $this->_tpl_vars['ST']['mangerlist_js_add_no'] ?>";
	var username_yes = "<?php echo $this->_tpl_vars['ST']['username_yes'] ?>";
	var username_no = "<?php echo $this->_tpl_vars['ST']['username_no'] ?>";
	var iframename = "<?php echo $this->_tpl_vars['iframename'] ?>";
	iframename = iframename=='' ? "jerichotabiframe_0" : iframename;
	$(document).ready(function(){
		var h = '<?php echo $this->_tpl_vars['iframeheightwindow'] ?>';
		$('.managebottonadd').css({height:h-40});
		var options = {

			beforeSubmit: formverify,

			success:saveResponse,
			resetForm: true
		}
		$('#manageadd').submit(function() {
			$(this).ajaxSubmit(options);
			return false;
		});
	})




	function formverify(formData) {
		var queryString = $.param(formData);
		var get=urlarray(queryString);
		if(get['username']==""){
			document.manageadd.username.focus();
			alert(mangerlist_js_useranme_empty);
			return false;
		}
		if(get['username'].match(/^[a-zA-Z]{1}[a-zA-Z0-9]{4,19}$/ig)==null) {
			document.manageadd.username.focus();
			alert(mangerlist_js_useranme_empty);
			return false;
		}
		if(get['password2']=="" || get['password']=="") {
			document.manageadd.password.focus();
			alert(mangerlist_js_password_empty);
			return false;
		}
		if(get['password'].length<6) {
			document.manageadd.password.focus();
			alert(mangerlist_js_password_empty);
			return false;
		}
		if( get['password2'] != get['password'] ) {
			document.manageadd.password.focus();
			alert(mangerlist_js_password_error);
			return false;
		}
		parent.windowsdig('Loading','iframe:index.php?archive=management&action=load','400px','180px','iframe',false);
	}

	function checkuser(){
		var username=document.getElementById("usernameadd").value;
		if(username==""){
			return false;
		}
		var um=document.getElementById('usernameerr');
		$.ajax({
			type: "POST",
			url: "index.php?archive=management&action=usercheck",
			data: "username="+username,
			success: function(date){
				if (date=="false"){
					um.innerHTML="<font color=\"red\">"+username_yes+"</font>";
					$('#submitbotton').attr('disabled','true');
				}else{
					um.innerHTML="<font color=\"#1CB521\">"+username_no+"</font>";
					$('#submitbotton').attr('disabled','');
				}
			}
		});
	}
	function saveResponse(options){
		parent.closeifram();
		var tab=document.getElementById("manageaddtab").value;
		if (options=='true'){
			if (tab=='true'){
				if(parent.frames[iframename].document.getElementById("selectform")){
					parent.frames[iframename].refresh('selectform','selectall','check_all');
				}
			}
			alert(mangerlist_js_add_ok);
		}else{
			alert(mangerlist_js_add_no);
		}
		if (tab=='true'){
			parent.onaletdoc()
		}
	}
	function appendvariable(str){
		var value=$(":input[name=\"code\"]").val();
		var newvalue=value+str;
		$(":input[name=\"code\"]").val(newvalue);
	}
	function codetext(type){
		var str='<textarea name="code" id="code" style="width:98%;height:80px;" class="smallInput"></textarea>';
		var str2='<input type="text" name="code" size="50" maxlength="100" class="infoInput" />';
		if (type==1){
			$("#codetext").empty();
			$("#codetext").append(str);
		}else{
			$("#codetext").empty();
			$("#codetext").append(str2);
		}
	}
</script>
</head>

<body>
<form name="manageadd" id="manageadd" method="post" action="index.php?archive=management&action=managesava">
<input type="hidden" name="inputclass" value="add">
<input type="hidden" name="tab" id="manageaddtab" value="<?php echo $this->_tpl_vars['tab'] ?>">
<div id="mainbodybottonauto" class="managebottonadd">
	<div class="maindobycontent">
		<!--查看已选择的类型-->
		<div class="suggestion">
			<span class="sugicon"><span class="strong colorgorning2"><?php echo $this->_tpl_vars['ST']['position_title'] ?></span><span class="colorgorningage"><?php echo $this->_tpl_vars['ST']['mangerlist_add_mess'] ?></span></span>
		</div>
		<div class="manageeditdiv">
			<div class="maneditcontent">
				<table class="formtable">
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['mangerlist_add_username'] ?></td>
						<td class="trtitle02"><input type="text" name="username" id="usernameadd" size="50" maxlength="20" class="infoInput"  onblur="checkuser();"/> <span id="usernameerr" class="cautiontitle"><?php echo $this->_tpl_vars['ST']['mangerlist_add_username_mess'] ?></span></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['mangerlist_add_password'] ?></td>
						<td class="trtitle02"><input type="password" name="password" size="50" maxlength="12"  class="infoInput"/> <span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['mangerlist_add_password_mess'] ?></span></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['mangerlist_add_password2'] ?></td>
						<td class="trtitle02"><input type="password" name="password2" size="50" maxlength="12"  class="infoInput"/></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['mangerlist_add_name'] ?></td>
						<td class="trtitle02"><input type="text" name="name" size="50" maxlength="40" class="infoInput"/></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['mangerlist_add_sex'] ?></td>
						<td class="trtitle02">
							<input type="radio" value="1" name="sex" checked="checked"/> <?php echo $this->_tpl_vars['ST']['select_sex_1'] ?>&nbsp;
							<input type="radio" value="0" name="sex"/> <?php echo $this->_tpl_vars['ST']['select_sex_0'] ?>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['mangerlist_add_powergroup'] ?></td>
						<td class="trtitle02">
							<select size="1" name="powergroup" id="powergroup">
								<?php if (count($this->_tpl_vars['powerlist'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['powerlist']); $list++){?>
								<option <?php echo $this->_tpl_vars['powerlist'][$list]['selected'] ?> value="<?php echo $this->_tpl_vars['powerlist'][$list]['id'] ?>"><?php echo $this->_tpl_vars['powerlist'][$list]['powername'] ?></option>
								<?php }} ?>
							</select>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['mangerlist_add_inputclassid'] ?></td>
						<td class="trtitle02">
							<input type="radio" value="1" name="inputclassid" checked="checked"> <?php echo $this->_tpl_vars['ST']['input1_botton'] ?>&nbsp;
							<input type="radio" value="0" name="inputclassid"> <?php echo $this->_tpl_vars['ST']['input0_botton'] ?>&nbsp;
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['mangerlist_add_inputclassid_mess'] ?></span>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<div id="downbotton">
	<div id="subbotton">
		<table border="0" width="100%">
			<tr>
				<td id="right"><input type="submit" id="submitbotton" name="Submit" value="<?php echo $this->_tpl_vars['ST']['botton_add'] ?>" class="buttonface" /></td>
				<td id="left" class="padding-left5"><input type="button" name="cancel" onClick="javascript:parent.onaletdoc();" value="<?php echo $this->_tpl_vars['ST']['botton_add_reset'] ?>" class="buttonface" /></td>
			</tr>
		</table>
	</div>
</div>
</form>
</body>

</html>