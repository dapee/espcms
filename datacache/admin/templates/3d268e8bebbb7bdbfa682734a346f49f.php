<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['softtitle'] ?></title>
<link href="templates/css/baselist.css" rel="stylesheet" type="text/css" />
<link href="templates/css/all.css" rel="stylesheet" type="text/css" />
<link href="templates/css/formdiv.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/control.js"></script>
<script type="text/javascript" src="../public/tinyMCE/jquery.tinymce.js"></script>
<script type="text/javascript" src="js/dialog.js"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript" src="js/initedit.js"></script>
<script type="text/javascript" src="../js/My97DatePicker/WdatePicker.js"></script>
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
	var article_js_noselect_empty  = "<?php echo $this->_tpl_vars['ST']['article_js_noselect_empty'] ?>";
	var article_js_input_err  = "<?php echo $this->_tpl_vars['ST']['article_js_input_err'] ?>";
	var article_doc_add_tid  = "<?php echo $this->_tpl_vars['ST']['article_doc_add_tid'] ?>";
	var article_js_link_empty  = "<?php echo $this->_tpl_vars['ST']['article_js_link_empty'] ?>";
	var article_js_template_empty  = "<?php echo $this->_tpl_vars['ST']['article_js_template_empty'] ?>";
	var article_js_filename_empty  = "<?php echo $this->_tpl_vars['ST']['article_js_filename_empty'] ?>";
	var article_js_doc_edit_ok = "<?php echo $this->_tpl_vars['ST']['article_js_doc_edit_ok'] ?>";
	var article_js_doc_edit_no = "<?php echo $this->_tpl_vars['ST']['article_js_doc_edit_no'] ?>";
	var article_js_doc_copy_ok = "<?php echo $this->_tpl_vars['ST']['article_js_doc_copy_ok'] ?>";
	var article_js_doc_copy_no = "<?php echo $this->_tpl_vars['ST']['article_js_doc_copy_no'] ?>";
	var refalse = "<?php echo $this->_tpl_vars['refalse'] ?>";
	var imagestitle="<?php echo $this->_tpl_vars['ST']['filemanage_select_title'] ?>";
	var addbottonname="<?php echo $this->_tpl_vars['ST']['selectfile_botton'] ?>";
	var remimages="<?php echo $this->_tpl_vars['ST']['remimages_botton'] ?>";
	var adminurl = "<?php echo $this->_tpl_vars['adminurl'] ?>";
	var mid = "<?php echo $this->_tpl_vars['mid'] ?>";
	var iframename = "<?php echo $this->_tpl_vars['iframename'] ?>";
	var addtype = "<?php echo $this->_tpl_vars['type'] ?>";
	
	$(document).ready(function(){
		editshow("#content");
		<?php if (count($this->_tpl_vars['modelatt'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['modelatt']); $list++){?>
		<?php if(($this->_tpl_vars['modelatt'][$list]['inputtype']=='editor' && $this->_tpl_vars['modelatt'][$list]['attrname']!='content')){ ?>
		editsimpleshow("#<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>");
		<?php } ?>
		<?php }} ?>
		
		$('#color').EasySiteColorSelect();
		var h = '<?php echo $this->_tpl_vars['iframeheightwindow'] ?>';
		$('.managebottonadd').css({height:h-40});
		var options = {
			beforeSubmit: formverify,
			success:saveResponse,
			resetForm: false
		};
		$('#docadd').submit(function() {
			$(this).ajaxSubmit(options);
			return false;
		});
		parent.scrolclear();
	})




	function formverify(formData, jqForm, options) {
		for (var i=0; i< formData.length; i++){
			<?php if (count($this->_tpl_vars['modelatt'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['modelatt']); $list++){?>
			<?php if(($this->_tpl_vars['modelatt'][$list]['inputtype']=='editor')){ ?>
				if (formData[i].name == "<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>"){
					formData[i].value=tinyMCE.get('<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>').getContent();
				}
			<?php } ?>
			<?php }} ?>
		}
		var queryString = $.param(formData);
		var get=urlarray(queryString);
		
		<?php if (count($this->_tpl_vars['modelatt'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['modelatt']); $list++){?>
			<?php if(($this->_tpl_vars['modelatt'][$list]['isvalidate']==1)){ ?>
			<?php if(($this->_tpl_vars['modelatt'][$list]['validatetext']!='')){ ?>
				if(get['<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>'].match(<?php echo $this->_tpl_vars['modelatt'][$list]['validatetext'] ?>ig)==null) {
			<?php }else{ ?>
				if(get['<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>']==''){
			<?php } ?>
				document.docadd.<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>.focus();
				alert('<?php echo $this->_tpl_vars['modelatt'][$list]['typename'] ?>'+article_js_input_err);
				return false;
			}
			<?php } ?>
		<?php }} ?>
		
		if(get['islink']==1){
			if(get['link'].match(/^http:\/\/[a-zA-Z.0-9-%&?=/_]+$/ig)==null) {
				document.docadd.link.focus();
				alert(article_js_link_empty);
				return false;
			}
		}
		
		if(get['tid']==0){
			document.docadd.tid.focus();
			alert(article_doc_add_tid+article_js_noselect_empty);
			return false;
		}
		if(get['istemplates']==1){
			if(get['template'].match(/^[\w-]+$/ig)==null) {
				document.docadd.template.focus();
				alert(article_js_template_empty);
				return false;
			}
		}
		if(get['filename']!=''){
			if(get['filename'].match(/^[\w-//]+$/ig)==null) {
				document.docadd.filename.focus();
				alert(article_js_filename_empty);
				return false;
			}
		}
		parent.windowsdig('Loading','iframe:index.php?archive=management&action=load','400px','180px','iframe',false);
	}
	function saveResponse(options){
		parent.closeifram();
		if (options=='true'){
			if(parent.frames[iframename].document.getElementById("selectform")){
				parent.frames[iframename].refresh('selectform','selectall','check_all');
			}
			if (addtype=='edit'){
				alert(article_js_doc_edit_ok);
			}else{
				alert(article_js_doc_copy_ok);
			}
			
		}else{
			if (addtype=='edit'){
				alert(article_js_doc_edit_no+'Return message:'+options);
			}else{
				alert(article_js_doc_copy_no+'Return message:'+options);
			}
			
		}
		parent.scrolopen();
		parent.onaletdoc();
	}
</script>
</head>

<body>
<form name="docadd" id="docadd" method="post" action="index.php?archive=article&action=docsave">
<input type="hidden" name="inputclass" value="<?php echo $this->_tpl_vars['type'] ?>">
<input type="hidden" name="tab" id="docaddtab" value="<?php echo $this->_tpl_vars['tab'] ?>">
<input type="hidden" name="mid" id="mid" value="<?php echo $this->_tpl_vars['mid'] ?>">
<input type="hidden" name="lng" id="lng" value="<?php echo $this->_tpl_vars['lng'] ?>">
<input type="hidden" name="did" id="did" value="<?php echo $this->_tpl_vars['read']['did'] ?>">

<div id="mainbodybottonauto" class="managebottonadd">
	<div class="maindobycontent">
		<div class="suggestion">
			<span class="sugicon"><span class="strong colorgorning2"><?php if($this->_tpl_vars['type']=='edit'){ ?><?php echo $this->_tpl_vars['ST']['article_doc_edit_title'] ?><?php }else{ ?><?php echo $this->_tpl_vars['ST']['article_doc_copy_title'] ?><?php } ?></span> <span class="colorgorningage"><?php echo $this->_tpl_vars['read']['title'] ?>（<?php echo $this->_tpl_vars['modelview']['modelname'] ?>）</span></span>
		</div>
		<div class="manageeditdiv">
			<div class="maneditcontent">
				<table class="formtable">
					<?php if($this->_tpl_vars['modelview']['istsn'] && $this->_tpl_vars['typeread']['styleid']<=2){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_tsn'] ?></td>
						<td class="trtitle02">
							<input type="text" name="tsn" size="25" maxlength="20" value="<?php echo $this->_tpl_vars['read']['tsn'] ?>" id="tsn" class="infoInput"/>
							<span class="cautiontitle" id="dirnameerr"><?php echo $this->_tpl_vars['ST']['article_doc_add_tsn_mess'] ?></span>
						</td>
					</tr>
					<?php } ?>
					<?php if (count($this->_tpl_vars['modelatt'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['modelatt']); $list++){?>
						<tr class="trstyle2">
							<td class="trtitle01"><?php echo $this->_tpl_vars['modelatt'][$list]['typename'] ?></td>
							<td class="trtitle02">
								<?php if($this->_tpl_vars['modelatt'][$list]['inputtype']=='string' || $this->_tpl_vars['modelatt'][$list]['inputtype']=='int' || $this->_tpl_vars['modelatt'][$list]['inputtype']=='float' || $this->_tpl_vars['modelatt'][$list]['inputtype']=='decimal'){ ?>
								<input type="text" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" size="<?php echo $this->_tpl_vars['modelatt'][$list]['attrsize'] ?>" id="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" value="<?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'] ?>" maxlength="<?php echo $this->_tpl_vars['modelatt'][$list]['attrlenther'] ?>" class="infoInput"/>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='text' || $this->_tpl_vars['modelatt'][$list]['inputtype']=='editor')){ ?>
								<textarea name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" id="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>"  style="width:99%;height:<?php echo $this->_tpl_vars['modelatt'][$list]['attrrow'] ?>px;" class="infoInput"><?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'] ?></textarea>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='htmltext')){ ?>
								<textarea name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" id="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>"  style="width:99%;height:<?php echo $this->_tpl_vars['modelatt'][$list]['attrrow'] ?>px;" class="infoInput"><?php echo $this->Html2Text($this->_tpl_vars['modelatt'][$list]['attrvalue'],'0') ?></textarea>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='img')){ ?>
								<ul class="addpiclist">
									<li><a title="<?php echo $this->_tpl_vars['ST']['selectfile_botton'] ?>" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['filemanage_select_title'] ?>','iframe:index.php?archive=filemanage&action=filewindow&listfunction=filelist&filetype=img&checkfrom=picshow&getbyid=addsr<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>&fileinputid=<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>&maxselect=1&iframename='+self.frameElement.getAttribute('name'),'900px','480px','iframe')" href="#body"><p><img id="addsr<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" width="100" height="100" src="<?php if($this->_tpl_vars['modelatt'][$list]['attrvalue']!=''){ ?><?php echo $this->_tpl_vars['path'] ?><?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'] ?><?php }else{ ?>templates/images/pic.png<?php } ?>"></p></a></li>
								</ul>
								<input type="hidden" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" value="<?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'] ?>" id="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>"/>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='selectinput')){ ?>
								<input type="text" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" size="<?php echo $this->_tpl_vars['modelatt'][$list]['attrsize'] ?>" id="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" value="<?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'] ?>" maxlength="<?php echo $this->_tpl_vars['modelatt'][$list]['attrlenther'] ?>" class="infoInput"/>
								<select size="1" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>selectinputvalue" onchange="javascript:$('#<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>').val(this.value)">
									<option value=""><?php echo $this->_tpl_vars['ST']['botton_select_name'] ?><?php echo $this->_tpl_vars['modelatt'][$list]['typename'] ?></option>
									<?php if (count($this->_tpl_vars['modelatt'][$list]['selectinputvalue'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['modelatt'][$list]['selectinputvalue']); $ii++){?>
									<option value="<?php echo $this->_tpl_vars['modelatt'][$list]['selectinputvalue'][$ii]['name'] ?>"><?php echo $this->_tpl_vars['modelatt'][$list]['selectinputvalue'][$ii]['name'] ?></option>
									<?php }} ?>
								</select>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='addon')){ ?>
								<input type="text" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" size="<?php echo $this->_tpl_vars['modelatt'][$list]['attrsize'] ?>" id="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" value="<?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'] ?>" maxlength="<?php echo $this->_tpl_vars['modelatt'][$list]['attrlenther'] ?>" class="infoInput"/>
								<a class="filecheck" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['filemanage_select_title'] ?>','iframe:index.php?archive=filemanage&action=filewindow&listfunction=filelist&filetype=file&checkfrom=input&getbyid=&fileinputid=<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>&maxselect=1&iframename='+self.frameElement.getAttribute('name'),'900px','480px','iframe')" href="#body"><?php echo $this->_tpl_vars['ST']['selectfile_botton'] ?></a>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='video')){ ?>
								<input type="text" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" size="<?php echo $this->_tpl_vars['modelatt'][$list]['attrsize'] ?>" id="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" value="<?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'] ?>" maxlength="<?php echo $this->_tpl_vars['modelatt'][$list]['attrlenther'] ?>" class="infoInput"/>
								<a class="movercheck" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['filemanage_select_title'] ?>','iframe:index.php?archive=filemanage&action=filewindow&listfunction=filelist&filetype=mover&checkfrom=input&getbyid=&fileinputid=<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>&maxselect=1&iframename='+self.frameElement.getAttribute('name'),'900px','480px','iframe')" href="#body"><?php echo $this->_tpl_vars['ST']['selectfile_botton'] ?></a>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='datetime')){ ?>
								<input type="text" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" size="<?php echo $this->_tpl_vars['modelatt'][$list]['attrsize'] ?>" id="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" value="<?php echo $this->timeformat($this->_tpl_vars['modelatt'][$list]['attrvalue'],3) ?>" maxlength="<?php echo $this->_tpl_vars['modelatt'][$list]['attrlenther'] ?>" class="infoInput"/>
								<a class="datetime" onclick="WdatePicker({el:'<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>',readOnly:true,dateFmt:'yyyy-MM-dd HH:mm:ss'})" href="#body"><?php echo $this->_tpl_vars['ST']['selectdata_botton'] ?></a>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='select')){ ?>
								<select size="1" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" id="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>">
									<option value=""><?php echo $this->_tpl_vars['ST']['botton_select_name'] ?><?php echo $this->_tpl_vars['modelatt'][$list]['typename'] ?></option>
									<?php if (count($this->_tpl_vars['modelatt'][$list]['attrvalue'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['modelatt'][$list]['attrvalue']); $ii++){?>
									<option <?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'][$ii]['selected'] ?> value="<?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'][$ii]['name'] ?>"><?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'][$ii]['name'] ?></option>
									<?php }} ?>
								</select>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='radio')){ ?>
									<?php if (count($this->_tpl_vars['modelatt'][$list]['attrvalue'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['modelatt'][$list]['attrvalue']); $ii++){?>
									<input type="radio" value="<?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'][$ii]['name'] ?>" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>" <?php if($this->_tpl_vars['modelatt'][$list]['attrvalue'][$ii]['selected']=='selected'){ ?>checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'][$ii]['name'] ?>&nbsp;
									<?php }} ?>
								<?php } elseif(($this->_tpl_vars['modelatt'][$list]['inputtype']=='checkbox')){ ?>
									<?php if (count($this->_tpl_vars['modelatt'][$list]['attrvalue'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['modelatt'][$list]['attrvalue']); $ii++){?>
									<input type="checkbox" value="<?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'][$ii]['name'] ?>" name="<?php echo $this->_tpl_vars['modelatt'][$list]['attrname'] ?>[]" <?php if($this->_tpl_vars['modelatt'][$list]['attrvalue'][$ii]['selected']=='selected'){ ?>checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['modelatt'][$list]['attrvalue'][$ii]['name'] ?>&nbsp;
									<?php }} ?>
								<?php } ?>
								<?php if($this->_tpl_vars['modelatt'][$list]['attrname']=='title'){ ?><input id="color" name="color" value="<?php echo $this->_tpl_vars['read']['color'] ?>"/><?php } ?>
								<?php if($this->_tpl_vars['modelatt'][$list]['typeremark']!=''){ ?><span class="cautiontitle"><?php echo $this->_tpl_vars['modelatt'][$list]['typeremark'] ?></span><?php } ?>
							</td>
						</tr>
						<?php if($this->_tpl_vars['modelatt'][$list]['attrname']=='content'){ ?>
						<tr class="trstyle2">
							<td class="trtitle01"></td>
							<td class="trtitle02 colorgblue">
								<input type="checkbox" value="1" name="input_isdellink" checked="checked"> <?php echo $this->_tpl_vars['ST']['article_doc_add_content_b1'] ?>&nbsp;
								<input type="checkbox" value="1" name="donwloadpic"/> <?php echo $this->_tpl_vars['ST']['article_doc_add_content_b2'] ?>&nbsp;
							</td>
						</tr>
						<?php } ?>
					<?php }} ?>
					
					<tr class="trstyle2">
						<td class="trtitle03" colspan="2"><?php echo $this->_tpl_vars['ST']['article_doc_tab_title01'] ?></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"></td>
						<td class="trtitle02">
							<a class="keyselect" href="#body" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['selecttag_botton'] ?>','iframe:index.php?archive=seomanage&action=listwindow&inputtext=tags&listfunction=key&checkfrom=input&mid=<?php echo $this->_tpl_vars['mid'] ?>&tid='+document.docadd.tid.value+'&iframename='+self.frameElement.getAttribute('name'),'650px','380px','iframe');"><?php echo $this->_tpl_vars['ST']['selecttag_botton'] ?></a>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_tags'] ?></td>
						<td class="trtitle02">
							<input type="text" name="tags" id="tags" maxlength="100" value="<?php echo $this->_tpl_vars['read']['tags'] ?>" class="infoInput" style="width:98%;"/>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"></td>
						<td class="trtitle02"><span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['article_doc_add_tags_mess'] ?></span></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"></td>
						<td class="trtitle02">
							<a class="keyselect" href="#body" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['selectkeytype_botton'] ?>','iframe:index.php?archive=seomanage&action=listwindow&inputtext=keywords&listfunction=keytype&checkfrom=function&maxselect=1&mid=<?php echo $this->_tpl_vars['mid'] ?>&tid='+document.docadd.tid.value+'&iframename='+self.frameElement.getAttribute('name'),'850px','450px','iframe');"><?php echo $this->_tpl_vars['ST']['selectkeytype_botton'] ?></a>
							<a class="keyselect" href="#body" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['selectkeyword_botton'] ?>','iframe:index.php?archive=seomanage&action=listwindow&inputtext=keywords&listfunction=key&checkfrom=input&mid=<?php echo $this->_tpl_vars['mid'] ?>&tid='+document.docadd.tid.value+'&iframename='+self.frameElement.getAttribute('name'),'650px','380px','iframe');"><?php echo $this->_tpl_vars['ST']['selectkeyword_botton'] ?></a>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_keywords'] ?></td>
						<td class="trtitle02">
							<input type="text" name="keywords" id="keywords" maxlength="100" value="<?php echo $this->_tpl_vars['read']['keywords'] ?>" class="infoInput" style="width:98%;"/>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_description'] ?></td>
						<td class="trtitle02">
							<textarea name="description" id="description"  style="width:98%;height:50px;" class="smallInput"><?php echo $this->_tpl_vars['read']['description'] ?></textarea>
						</td>
					</tr>
				<?php if($this->_tpl_vars['typeread']['styleid']<=2){ ?>
					<tr class="trstyle2">
						<td class="trtitle03" colspan="2"><?php echo $this->_tpl_vars['ST']['article_doc_tab_title02'] ?></td>
					</tr>
					<?php if(count($this->_tpl_vars['doclabel'])>0){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_recommend'] ?></td>
						<td class="trtitle02" style="line-height: 200%">
							<?php if (count($this->_tpl_vars['doclabel'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['doclabel']); $list++){?>
								<input type="checkbox" value="<?php echo $this->_tpl_vars['doclabel'][$list]['dlid'] ?>" <?php echo $this->_tpl_vars['doclabel'][$list]['selected'] ?> name="recommend[]"/> <?php echo $this->_tpl_vars['doclabel'][$list]['labelname'] ?>&nbsp;
								<?php if($divid_list==5){ ?><br><?php $divid_list=0;}$divid_list++;?>
							<?php }} ?>
						</td>
					</tr>
					<?php } ?>
					<?php if($this->_tpl_vars['modelview']['isbase']==0){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_tid'] ?></td>
						<td class="trtitle02">
							<select size="1" name="tid" id="tid">
								<option selected="selected" value="0"><?php echo $this->_tpl_vars['ST']['article_doc_add_tid_option'] ?></option>
								<?php if (count($this->_tpl_vars['typelist'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['typelist']); $list++){?>
								<option <?php echo $this->_tpl_vars['typelist'][$list]['selected'] ?> value="<?php echo $this->_tpl_vars['typelist'][$list]['tid'] ?>"><?php if($this->_tpl_vars['typelist'][$list]['level']>0){ ?>├<?php } ?><?php echo $this->treelist($this->_tpl_vars['typelist'][$list]['level'],'─') ?> <?php echo $this->_tpl_vars['typelist'][$list]['typename'] ?></option>
								<?php }} ?>
							</select>
						</td>
					</tr>
					<?php } ?>
					<?php if($this->_tpl_vars['modelview']['isextid']==1){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_extid'] ?></td>
						<td class="trtitle02">
							<select size="3" name="extid[]" id="extid" multiple="multiple">
								<optgroup label="<?php echo $this->_tpl_vars['ST']['article_doc_add_extid_option'] ?>">
								<?php if (count($this->_tpl_vars['typelist'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['typelist']); $list++){?>
								<option <?php if(in_array( $this->_tpl_vars['typelist'][$list]['tid'] , $this->_tpl_vars['extid'] )){ ?>selected<?php } ?> value="<?php echo $this->_tpl_vars['typelist'][$list]['tid'] ?>"><?php if($this->_tpl_vars['typelist'][$list]['level']>0){ ?>├<?php } ?><?php echo $this->treelist($this->_tpl_vars['typelist'][$list]['level'],'─') ?> <?php echo $this->_tpl_vars['typelist'][$list]['typename'] ?></option>
								<?php }} ?>
								</optgroup>
							</select>
						</td>
					</tr>
					<?php } ?>
					<?php if($this->_tpl_vars['modelview']['issid']==1){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_sid'] ?></td>
						<td class="trtitle02">
							<select size="1" name="sid" id="sid">
								<option selected="selected" value="0"><?php echo $this->_tpl_vars['ST']['article_doc_add_sid_option'] ?></option>
								<?php if (count($this->_tpl_vars['subjectlistarray'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['subjectlistarray']); $list++){?>
								<option <?php echo $this->_tpl_vars['subjectlistarray'][$list]['selected'] ?>  value="<?php echo $this->_tpl_vars['subjectlistarray'][$list]['sid'] ?>"><?php echo $this->_tpl_vars['subjectlistarray'][$list]['subjectname'] ?></option>
								<?php }} ?>
							</select>
						</td>
					</tr>
					<?php } ?>
				<?php } ?>
					<?php if($this->_tpl_vars['modelview']['isfgid']==1){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_fgid'] ?></td>
						<td class="trtitle02">
							<select size="1" name="fgid" id="fgid">
								<option selected="selected" value="0"><?php echo $this->_tpl_vars['ST']['article_doc_add_fgid_option'] ?></option>
								<?php if (count($this->_tpl_vars['formarray'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['formarray']); $list++){?>
								<option <?php echo $this->_tpl_vars['formarray'][$list]['selected'] ?> value="<?php echo $this->_tpl_vars['formarray'][$list]['fgid'] ?>"><?php echo $this->_tpl_vars['formarray'][$list]['formgroupname'] ?></option>
								<?php }} ?>
							</select>
							<span class="cautiontitle" id="dirnameerr"><?php echo $this->_tpl_vars['ST']['article_doc_add_fgid_mess'] ?></span>
						</td>
					</tr>
					<?php } ?>
				<?php if($this->_tpl_vars['typeread']['styleid']<=2){ ?>
					<?php if($this->_tpl_vars['modelview']['ispurview']==1){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_purview'] ?></td>
						<td class="trtitle02">
							<select size="1" name="purview" id="purview">
								<option selected="selected" value="0"><?php echo $this->_tpl_vars['ST']['article_doc_add_purview_option'] ?></option>
								<?php if (count($this->_tpl_vars['memberpuvlist'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['memberpuvlist']); $list++){?>
								<option <?php echo $this->_tpl_vars['memberpuvlist'][$list]['selected'] ?> value="<?php echo $this->_tpl_vars['memberpuvlist'][$list]['mcid'] ?>"><?php echo $this->_tpl_vars['memberpuvlist'][$list]['rankname'] ?></option>
								<?php }} ?>
							</select>
						</td>
					</tr>
					<?php } ?>
					<?php if($this->_tpl_vars['modelview']['isbase']==0){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_addtime'] ?></td>
						<td class="trtitle02">
							<input type="text" name="addtime" size="20" maxlength="30" id="addtime" value="<?php echo $this->timeformat($this->_tpl_vars['read']['addtime'],3) ?>" class="infoInput"/>
							<a class="datetime" onclick="WdatePicker({el:'addtime',isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd HH:mm:ss'})" href="#body"><?php echo $this->_tpl_vars['ST']['selectdata_botton'] ?></a>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_click'] ?></td>
						<td class="trtitle02">
							<input type="text" name="click" size="5" maxlength="5" value="<?php echo $this->_tpl_vars['read']['click'] ?>" id="click" class="infoInput"/>
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['article_doc_add_click_mess'] ?></span>
						</td>
					</tr>
					<?php } ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_islink'] ?></td>
						<td class="trtitle02">
							<input type="radio" value="1" name="islink" <?php if($this->_tpl_vars['read']['islink']==1){ ?>checked="checked" <?php } ?>onclick="ondisplay('islinkdiv','trstyle2 displaytrue')" /> <?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>&nbsp;
							<input type="radio" value="0" name="islink" <?php if($this->_tpl_vars['read']['islink']==0){ ?>checked="checked" <?php } ?>onclick="ondisplay('islinkdiv','trstyle2 displaynone')"/> <?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['article_doc_add_islink_mess'] ?></span>
						</td>
					</tr>
					<tr class="trstyle2 <?php if($this->_tpl_vars['read']['islink']==1){ ?>displaytrue<?php }else{ ?>displaynone<?php } ?>" id="islinkdiv">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_link'] ?></td>
						<td class="trtitle02">
							<input type="text" name="link" size="50" maxlength="230" value="<?php echo $this->_tpl_vars['read']['link'] ?>" class="infoInput"/>
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['article_doc_add_link_mess'] ?></span>
						</td>
					</tr>
				<?php } ?>
					<tr class="trstyle2">
						<td class="trtitle03" colspan="2"><?php echo $this->_tpl_vars['ST']['article_doc_tab_title03'] ?></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_ishtml'] ?></td>
						<td class="trtitle02">
							<input type="radio" value="1" name="ishtml"<?php if($this->_tpl_vars['read']['ishtml']==1){ ?> checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['ST']['article_doc_add_ishtml_1'] ?>&nbsp;
							<input type="radio" value="0" name="ishtml"<?php if($this->_tpl_vars['read']['ishtml']==0){ ?> checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['ST']['article_doc_add_ishtml_0'] ?>
						</td>
					</tr>
					<?php if($this->_tpl_vars['modelview']['isorder']==1 && $this->_tpl_vars['typeread']['styleid']!=3){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_isorder'] ?></td>
						<td class="trtitle02">
							<input type="radio" value="1" name="isorder"<?php if($this->_tpl_vars['read']['isorder']==1){ ?> checked="checked"<?php } ?>> <?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>&nbsp;
							<input type="radio" value="0" name="isorder"<?php if($this->_tpl_vars['read']['isorder']==0){ ?> checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['article_doc_add_isorder_mess'] ?></span>
						</td>
					</tr>
					<?php } ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_istemplates'] ?></td>
						<td class="trtitle02">
							<input type="radio" value="1" name="istemplates"<?php if($this->_tpl_vars['read']['istemplates']==1){ ?> checked="checked"<?php } ?>/ onclick="ondisplay('istemplatesdiv','trstyle2 displaytrue')"/> <?php echo $this->_tpl_vars['ST']['open_botton_title'] ?>&nbsp;
							<input type="radio" value="0" name="istemplates"<?php if($this->_tpl_vars['read']['istemplates']==0){ ?> checked="checked"<?php } ?>/ onclick="ondisplay('istemplatesdiv','trstyle2 displaynone')"/> <?php echo $this->_tpl_vars['ST']['close_botton_title'] ?>
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['article_doc_add_istemplates_mess'] ?></span>
						</td>
					</tr>
					<tr class="trstyle2 <?php if($this->_tpl_vars['read']['istemplates']!=1){ ?>displaynone<?php } ?>" id="istemplatesdiv">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_template'] ?></td>
						<td class="trtitle02">
							<input type="text" name="template" id="templatename" size="40" value="<?php echo $this->_tpl_vars['read']['template'] ?>" maxlength="100" class="infoInput"/>
							<a class="filecheck" href="#body" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['selecttempfile_botton'] ?>','iframe:index.php?archive=templatemain&action=listwindow&inputtext=templatename&typeclass=article&skindir=&filedir=article&fileclass=&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),'750px','400px','iframe');"><?php echo $this->_tpl_vars['ST']['selecttempfile_botton'] ?></a>
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['article_doc_add_template_mess'] ?></span>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_filename'] ?></td>
						<td class="trtitle02">
							<input type="text" name="filename" size="40" value="<?php echo $this->_tpl_vars['read']['filename'] ?>" maxlength="50" class="infoInput"/>
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['article_doc_add_filename_mess'] ?></span>
						</td>
					</tr>
					<?php if($this->_tpl_vars['modelview']['ismessage']==1 && $this->_tpl_vars['typeread']['styleid']!=3){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_ismessage'] ?></td>
						<td class="trtitle02">
							<input type="radio" value="1" name="ismessage"<?php if($this->_tpl_vars['read']['ismess']==1){ ?> checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['ST']['article_doc_add_ismessage_1'] ?>&nbsp;
							<input type="radio" value="0" name="ismessage"<?php if($this->_tpl_vars['read']['ismess']==0){ ?> checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['ST']['article_doc_add_ismessage_0'] ?>
						</td>
					</tr>
					<?php } ?>
					<?php if($this->_tpl_vars['modelview']['isalbum']==1 && $this->_tpl_vars['typeread']['styleid']!=3){ ?>
					<tr class="trstyle2">
						<td class="trtitle03" colspan="2"><?php echo $this->_tpl_vars['ST']['article_doc_tab_title00'] ?></td>
					</tr>
					<tr class="trstyle3">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_piclist'] ?></td>
						<td class="trtitle02">
							<a class="picselect" href="#body" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['selectpic_botton'] ?>','iframe:index.php?archive=filemanage&action=filewindow&listfunction=filelist&filetype=img&checkfrom=function&getbyid=addpiclist&fileinputid=albumlist&maxselect=20&iframename='+self.frameElement.getAttribute('name'),'900px','480px','iframe')"><?php echo $this->_tpl_vars['ST']['selectpic_botton'] ?></a>
							<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['selectpic_botton_mess'] ?></span>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"></td>
						<td class="trtitle02">
							<ul class="albumlistinput" id="addpiclist">
								<?php if (count($this->_tpl_vars['picarray'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['picarray']); $list++){?>
								<li ondblclick="$(this).remove();removeval('albumlist','<?php echo $this->_tpl_vars['picarray'][$list]['picfile'] ?>');">
									<div class="albumpic"><p><img src="../<?php echo $this->_tpl_vars['picarray'][$list]['picfile'] ?>" width="100" height="100"></p></div>
									<div class="albuminput">
										<p><input type="text" name="picname[]" value="<?php echo $this->_tpl_vars['picarray'][$list]['picname'] ?>" style="width:550px;" maxlength="150" class="infoInput"></p>
										<p><textarea name="filedes[]" style="width:550px;height:75px;" class="smallInput"><?php echo $this->_tpl_vars['picarray'][$list]['filedes'] ?></textarea></p>
									</div>
								</li>
								<?php }} ?>
							</ul>
							<input type="hidden" name="albumlist" id="albumlist" value="<?php echo $this->_tpl_vars['aidlist'] ?>"/>
						</td>
					</tr>
					<?php } ?>
					<?php if($this->_tpl_vars['modelview']['islinkdid']==1 && $this->_tpl_vars['typeread']['styleid']!=3){ ?>
					<tr class="trstyle2">
						<td class="trtitle03" colspan="2"><?php echo $this->_tpl_vars['ST']['article_doc_tab_title04'] ?></td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['article_doc_add_linkdid'] ?></td>
						<td class="trtitle02">
							<a class="filecheck" href="#body" onclick="javascript:parent.windowsdig('<?php echo $this->_tpl_vars['ST']['article_doc_add_linkdid'] ?>','iframe:index.php?archive=article&action=listwindow&checkfrom=function&getbyid=infolinked&inputtext=linkdid&mid=<?php echo $this->_tpl_vars['mid'] ?>&tid=<?php echo $this->_tpl_vars['tid'] ?>&freshid='+Math.random()+'&iframename='+self.frameElement.getAttribute('name'),'800px','400px','iframe');">选择内容</a>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"></td>
						<td class="trtitle02">
							<ul class="infolinked" id="infolinked">
								<?php if (count($this->_tpl_vars['linkdid'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['linkdid']); $list++){?>
								<li id="didlinklist<?php echo $this->_tpl_vars['linkdid'][$list]['did'] ?>"><?php echo $this->_tpl_vars['linkdid'][$list]['title'] ?> <span class="del" onclick="delinfolist('didlinklist<?php echo $this->_tpl_vars['linkdid'][$list]['did'] ?>','<?php echo $this->_tpl_vars['linkdid'][$list]['did'] ?>','linkdid')">删除</span></li>
								<?php }} ?>
							</ul>
							<input type="hidden" name="linkdid" id="linkdid" value="<?php echo $this->_tpl_vars['read']['linkdid'] ?>"/>
						</td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>
<div id="downbotton">
	<div id="subbotton">
		<?php if($this->_tpl_vars['type']=='edit'){ ?>
		<table width="100%">
			<tr>
				<td id="right"><input type="submit" id="docaddsubmitbotton" name="Submit" value="<?php echo $this->_tpl_vars['ST']['botton_edit'] ?>" class="buttonface" /></td>
				<td id="left" class="padding-left5"><input type="button" name="cancel" onClick="javascript:closewindow();" value="<?php echo $this->_tpl_vars['ST']['botton_edit_reset'] ?>" class="buttonface" /></td>
			</tr>
		</table>
		<?php }else{ ?>
		<table width="100%">
			<tr>
				<td id="right"><input type="submit" id="docaddsubmitbotton" name="Submit" value="<?php echo $this->_tpl_vars['ST']['botton_add'] ?>" class="buttonface" /></td>
				<td id="left" class="padding-left5"><input type="button" name="cancel" onClick="javascript:closewindow();" value="<?php echo $this->_tpl_vars['ST']['botton_add_reset'] ?>" class="buttonface" /></td>
			</tr>
		</table>
		<?php } ?>
	</div>
</div>
<input type="hidden" name="datid" id="datid" value="<?php echo $this->_tpl_vars['read']['datid'] ?>">
<input type="hidden" name="dcid" id="dcid" value="<?php echo $this->_tpl_vars['read']['dcid'] ?>">
<?php if($this->_tpl_vars['read']['isbase']==1 && $this->_tpl_vars['typeread']['styleid']>2){ ?>
<input type="hidden" name="addtime" id="addtime" value="<?php echo $this->timeformat($this->_tpl_vars['read']['addtime'],3) ?>">
<input type="hidden" name="click" id="click" value="<?php echo $this->_tpl_vars['read']['click'] ?>">
<input type="hidden" name="tid" id="tid" value="<?php echo $this->_tpl_vars['read']['tid'] ?>">
<?php } ?>
</form>
</body>

</html>


