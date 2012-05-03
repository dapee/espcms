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
<script type="text/javascript" src="../public/tinyMCE/jquery.tinymce.js"></script>
<script type="text/javascript" src="js/initedit.js"></script>
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
	var mailtemplatemain_js_name_empty  = "<?php echo $this->_tpl_vars['ST']['mailtemplatemain_js_name_empty'] ?>";
	var mailtemplatemain_js_title_empty  = "<?php echo $this->_tpl_vars['ST']['mailtemplatemain_js_title_empty'] ?>";
	var mailtemplatemain_js_type_empty  = "<?php echo $this->_tpl_vars['ST']['mailtemplatemain_js_type_empty'] ?>";
	var mailtemplatemain_js_content_empty  = "<?php echo $this->_tpl_vars['ST']['mailtemplatemain_js_content_empty'] ?>";
	var mailtemplatemain_js_edit_ok = "<?php echo $this->_tpl_vars['ST']['mailtemplatemain_js_edit_ok'] ?>";
	var mailtemplatemain_js_edit_no = "<?php echo $this->_tpl_vars['ST']['mailtemplatemain_js_edit_no'] ?>";
	var iframename = "<?php echo $this->_tpl_vars['iframename'] ?>";
	$(document).ready(function(){
		var h = '<?php echo $this->_tpl_vars['iframeheightwindow'] ?>';
		$('.managebottonadd').css({height:h-40});
		editsimpleshow_height("#content");
		var options = {
			beforeSubmit: formverify,
			success:saveResponse
		}
		$('#mailtemplateedit').submit(function() {
			$(this).ajaxSubmit(options);
			return false;
		});
	})




	function formverify(formData) {
		for (var i=0; i< formData.length; i++){
			if (formData[i].name == "content"){
				formData[i].value=tinyMCE.get('content').getContent()
			}
		}
		var queryString = $.param(formData);
		var get=urlarray(queryString);
		if(get['templatename']==''){
			document.mailtemplateedit.templatename.focus();
			alert(mailtemplatemain_js_name_empty);
			return false;
		}
		if(get['title']=='') {
			document.mailtemplateedit.title.focus();
			alert(mailtemplatemain_js_title_empty);
			return false;
		}
		if(get['content']=='') {
			alert(mailtemplatemain_js_content_empty);
			return false;
		}
		parent.windowsdig('Loading','iframe:index.php?archive=management&action=load','400px','180px','iframe',false);
	}
	function saveResponse(options){
		parent.closeifram();
		if (options=='true'){
			parent.frames[iframename].refresh('selectform','selectall','check_all');
			alert(mailtemplatemain_js_edit_ok);
		}else{
			alert(mailtemplatemain_js_edit_no);
		}
		parent.onaletdoc()
	}
	function appendvariable(str){
		tinyMCE.execCommand('mceInsertContent',false,str);
	}

	function mailtypeclass(typeclass){
		if (typeclass!=0){
			if(document.getElementById('ulbottonlist')){
				$("#ulbottonlist").load('index.php?archive=mailtemplatemain&action=typeclasslist&typeclass='+typeclass+'&freshid='+Math.random());
			}
		}
	}
</script>
</head>

<body>
<form name="mailtemplateedit" id="mailtemplateedit" method="post" action="index.php?archive=mailtemplatemain&action=save">
<input type="hidden" name="inputclass" value="edit">
<input type="hidden" name="styleclass" value="3">
<input type="hidden" name="lng" value="<?php echo $this->_tpl_vars['read']['lng'] ?>">
<input type="hidden" name="tmid" value="<?php echo $this->_tpl_vars['read']['tmid'] ?>">
<input type="hidden" name="typeclass" value="<?php echo $this->_tpl_vars['read']['typeclass'] ?>">
<div id="mainbodybottonauto" class="managebottonadd">
	<div class="maindobycontent">
		<div class="suggestion">
			<span class="sugicon"><span class="strong colorgorning2"><?php echo $this->_tpl_vars['ST']['position_title'] ?></span><span class="colorgorningage"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_edit_mess'] ?> <u><?php echo $this->_tpl_vars['read']['templatename'] ?></u></span></span>
		</div>
		<div class="manageeditdiv">
			<div class="maneditcontent">
				<table class="formtable">
					<tr>
						<td  class="trtitle03" colspan="2"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_mess_text'] ?></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle011"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_tempcode'] ?></td>
						<td class="trtitle02"><?php echo $this->_tpl_vars['read']['templatecode'] ?></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle011"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_name'] ?></td>
						<td class="trtitle02">
							<input type="text" name="templatename" value="<?php echo $this->_tpl_vars['read']['templatename'] ?>" size="50" maxlength="50" class="infoInput"/>
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_name_mess'] ?></span>
						</td>
					</tr>
					<tr class="trstyle3">
						<td class="trtitle011"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_title'] ?></td>
						<td class="trtitle02">
							<input type="text" name="title" value="<?php echo $this->_tpl_vars['read']['title'] ?>" size="80" maxlength="80" class="infoInput"/>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle011"></td>
						<td class="trtitle02">
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_title_option'] ?></span>
						</td>
					</tr>
					<tr>
						<td  class="trtitle03" colspan="2"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_mess_text2'] ?></td>
					</tr>
					<tr class="trstyle3">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_re'] ?></td>
						<td class="trtitle02">
							<select size="1" name="setypeclass" id="setypeclass" onchange="javascript:mailtypeclass(this.value)">
								<option value="0"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_re_select'] ?></option>
								<?php if (count($this->_tpl_vars['typeclass'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['typeclass']); $list++){?>
								<option <?php echo $this->_tpl_vars['typeclass'][$list]['selected'] ?> value="<?php echo $this->_tpl_vars['typeclass'][$list]['key'] ?>"><?php echo $this->_tpl_vars['typeclass'][$list]['name'] ?></option>
								<?php }} ?>
							</select>
						</td>
					</tr>
					<tr class="trstyle3">
						<td class="trtitle011"></td>
						<td class="trtitle02"><span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_re_select_mess'] ?></span></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"></td>
						<td class="trtitle02" id="ulbottonlist">
							<ul class="ulbottonlist">
							<?php if (count($this->_tpl_vars['array'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['array']); $list++){?>
								<li><input type="button" name="ordertitle" onClick="javascript:appendvariable('<?php echo $this->_tpl_vars['array'][$list]['title'] ?>');" value="<?php echo $this->_tpl_vars['array'][$list]['name'] ?>" class="bottons03" /></li>
							<?php }} ?>
							</ul>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle011"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_add_content'] ?></td>
						<td class="trtitle02">
							<textarea name="content" id="content" style="width:98%;height:200px;" class="smallInput"><?php echo $this->_tpl_vars['read']['templatecontent'] ?></textarea>
						</td>
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