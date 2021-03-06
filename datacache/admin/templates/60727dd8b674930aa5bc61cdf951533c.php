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
			$('#content').css({height:h-160});
		}
	}
	var templatemain_js_content_empty  = "<?php echo $this->_tpl_vars['ST']['templatemain_js_content_empty'] ?>";
	var templatemain_js_edit_ok = "<?php echo $this->_tpl_vars['ST']['templatemain_js_edit_ok'] ?>";
	var templatemain_js_edit_no = "<?php echo $this->_tpl_vars['ST']['templatemain_js_edit_no'] ?>";
	var iframename = "<?php echo $this->_tpl_vars['iframename'] ?>";
	$(document).ready(function(){
		var h = '<?php echo $this->_tpl_vars['iframeheightwindow'] ?>';
		$('.managebottonadd').css({height:h-40});
		$('#content').css({height:h-160});
		
		var options = {
			beforeSubmit: formverify,
			success:saveResponse
		}
		$('#templateedit').submit(function() {
			$(this).ajaxSubmit(options);
			return false;
		});
	})




	function formverify(formData) {
		var queryString = $.param(formData);
		var get=urlarray(queryString);
		if(get['content']==''){
			document.templateedit.content.focus();
			alert(templatemain_js_content_empty);
			return false;
		}
		parent.windowsdig('Loading','iframe:index.php?archive=management&action=load','400px','180px','iframe',false);
	}
	function saveResponse(options){
		parent.closeifram();
		if (options=='true'){
			parent.frames[iframename].refresh('selectform','selectall','check_all');
			alert(templatemain_js_edit_ok);
		}else{
			alert(templatemain_js_edit_no);
		}
		parent.onaletdoc()
	}
</script>
</head>

<body>
<form name="templateedit" id="templateedit" method="post" action="index.php?archive=templatemain&action=save">
<input type="hidden" name="inputclass" value="edit">
<input type="hidden" name="dir" value="<?php echo $this->_tpl_vars['dir'] ?>">
<input type="hidden" name="filename" value="<?php echo $this->_tpl_vars['filename'] ?>">
<div id="mainbodybottonauto" class="managebottonadd">
	<div class="maindobycontent">
		<div class="suggestion">
			<span class="sugicon"><span class="strong colorgorning2"><?php echo $this->_tpl_vars['ST']['position_title'] ?></span><span class="colorgorningage"><?php echo $this->_tpl_vars['ST']['templatemain_edit_mess'] ?> <?php echo $this->_tpl_vars['dir'] ?><?php echo $this->_tpl_vars['filename'] ?></span></span>
		</div>
		<div class="manageeditdiv">
			<div class="maneditcontent">
				<table class="formtable">
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['templatemain_add_code'] ?></td>
						<td class="trtitle02"><?php echo $this->_tpl_vars['dir'] ?><?php echo $this->_tpl_vars['filename'] ?></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle011"><?php echo $this->_tpl_vars['ST']['templatemain_add_content'] ?></td>
						<td class="trtitle02"><textarea wrap="off" name="content" id="content" style="width:98%" class="smallInput"><?php echo $this->_tpl_vars['content'] ?></textarea></td>
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
				<td id="right"><input type="submit" name="Submit" value="<?php echo $this->_tpl_vars['ST']['botton_edit'] ?>" class="buttonface" /></td>
				<td id="left" class="padding-left5"><input type="button" name="cancel" onClick="javascript:parent.onaletdoc();" value="<?php echo $this->_tpl_vars['ST']['botton_edit_reset'] ?>" class="buttonface" /></td>
			</tr>
		</table>
	</div>
</div>
</form>
</body>

</html>