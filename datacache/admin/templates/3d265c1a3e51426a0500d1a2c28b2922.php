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
	var grouplist_js_powername_empty  = "<?php echo $this->_tpl_vars['ST']['grouplist_js_powername_empty'] ?>";
	var grouplist_js_add_ok = "<?php echo $this->_tpl_vars['ST']['grouplist_js_add_ok'] ?>";
	var grouplist_js_add_no = "<?php echo $this->_tpl_vars['ST']['grouplist_js_add_no'] ?>";
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
		$('#poweradd').submit(function() {
			$(this).ajaxSubmit(options);
			return false;
		});
	})
	function formverify(formData) {
		var queryString = $.param(formData);
		var get=urlarray(queryString);
		if(get['powername']==""){
			document.poweradd.powername.focus();
			alert(grouplist_js_powername_empty);
			return false;
		}
		parent.windowsdig('Loading','iframe:index.php?archive=management&action=load','400px','180px','iframe',false);
	}
	function saveResponse(options){
		parent.closeifram();
		var tab=document.getElementById("poweraddtab").value;
		if (options=='true'){
			if (tab=='true'){
				if(parent.frames[iframename].document.getElementById("selectform")){
					parent.frames[iframename].refresh('selectform','selectall','check_all');
				}
			}
			alert(grouplist_js_add_ok);
		}else{
			alert(grouplist_js_add_no);
		}
		if (tab=='true'){
			parent.onaletdoc()
		}
	}
</script>
</head>

<body>
<form name="poweradd" id="poweradd" method="post" action="index.php?archive=powergroup&action=powerlistsava">
<input type="hidden" name="inputclass" value="add">
<input type="hidden" name="tab" id="poweraddtab" value="<?php echo $this->_tpl_vars['tab'] ?>">
<div id="mainbodybottonauto" class="managebottonadd">
	<div class="maindobycontent">
		<div class="suggestion">
			<span class="sugicon"><span class="strong colorgorning2"><?php echo $this->_tpl_vars['ST']['position_title'] ?></span><span class="colorgorningage"><?php echo $this->_tpl_vars['ST']['grouplist_add_mess'] ?></span></span>
		</div>
		<div class="manageeditdiv">
			<div class="maneditcontent">
				<table class="formtable">
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['grouplist_add_powername'] ?></td>
						<td class="trtitle02"><input type="text" name="powername" size="25" maxlength="20" class="infoInput"/> <span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['grouplist_add_powername_mess'] ?></span></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['grouplist_add_powerlist'] ?></td>
						<td class="trtitle02">
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
							<?php if (count($this->_tpl_vars['powermenulist'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['powermenulist']); $list++){?>
								<tr>
									<td colspan="4" style="padding:5px 5px 5px 0px;">
										<input type="checkbox" name="powerlist[]" CHECKED value="<?php echo $this->_tpl_vars['powermenulist'][$list]['loadfun'] ?>" id="powerlist">
										<b><?php echo $this->_tpl_vars['powermenulist'][$list]['menuname'] ?></b>  <span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['grouplist_add_powerlist_mess'] ?></span>
									</td>
								</tr>
								<?php if (count($this->_tpl_vars['powermenulist'][$list]['menu'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['powermenulist'][$list]['menu']); $i++){?>
								<tr>
									<td colspan="1" style="padding:5px 5px 5px 0px;" valign="top">
										<input type="checkbox" name="powerlist[]" CHECKED value="<?php echo $this->_tpl_vars['powermenulist'][$list]['menu'][$i]['loadfun'] ?>" id="powerlist"> <?php echo $this->_tpl_vars['powermenulist'][$list]['menu'][$i]['menuname'] ?>
									</td>
									<td colspan="3">
										<table border="0" cellspacing="0" cellpadding="2">
											<tr>
											<?php if (count($this->_tpl_vars['powermenulist'][$list]['menu'][$i]['linked'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['powermenulist'][$list]['menu'][$i]['linked']); $ii++){?>
												<td style="padding:5px 5px 5px 0px;">
													<input type="checkbox" name="powerlist[]" CHECKED value="<?php echo $this->_tpl_vars['powermenulist'][$list]['menu'][$i]['linked'][$ii]['loadfun'] ?>" id="powerlist"> <?php echo $this->_tpl_vars['powermenulist'][$list]['menu'][$i]['linked'][$ii]['menuname'] ?>
												</td>
											<?php if($divid_ii==6){ ?></tr><tr><?php $divid_ii=0;}$divid_ii++;?>
											<?php }} ?>
											</tr>
										</table>
									</td>
								</tr>
								<?php }} ?>
								<tr>
									<td colspan="4"><hr></td>
								</tr>
							<?php }} ?>
							</table>
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