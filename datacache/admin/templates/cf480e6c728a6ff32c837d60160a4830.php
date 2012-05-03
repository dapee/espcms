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
		var w = $(window).width();
		if(document.getElementById("mainbodybottonauto")){
			$('.managebottonadd').css({height:h-40});
		}
		$('.maneditcontent_editor').css({ width: w-170});
	}
	var setting_js_save_ok = "<?php echo $this->_tpl_vars['ST']['setting_js_save_ok'] ?>";
	var setting_js_save_no = "<?php echo $this->_tpl_vars['ST']['setting_js_save_no'] ?>";
	var iframename = "<?php echo $this->_tpl_vars['iframename'] ?>";
	$(document).ready(function(){
		var h = '<?php echo $this->_tpl_vars['iframeheightwindow'] ?>';
		var w = '<?php echo $this->_tpl_vars['iframewidthwindow'] ?>';
		$('.managebottonadd').css({height:h-40});
		$('.maneditcontent_editor').css({ width: w-170});
		var options = {

			beforeSubmit: formverify,

			success:saveResponse,
			resetForm: false
		}
		$('#setting').submit(function() {
			$(this).ajaxSubmit(options);
			return false;
		});
	})




	function formverify(formData) {
		parent.windowsdig('Loading','iframe:index.php?archive=management&action=load','400px','180px','iframe',false);
	}
	function saveResponse(options){
		parent.closeifram();
		if (options=='true'){
			alert(setting_js_save_ok);
		}else{
			alert(setting_js_save_no);
		}
	}
</script>
</head>

<body>
<form name="setting" id="setting" method="post" action="index.php?archive=management&action=setsave">
<div id="mainbodybottonauto" class="managebottonadd">
	<div class="maindobycontent">
		<!--查看已选择的类型-->
		<div class="suggestion">
			<span class="sugicon"><span class="strong colorgorning2"><?php echo $this->_tpl_vars['ST']['position_title'] ?></span><span class="colorgorningage"><?php echo $this->_tpl_vars['ST']['setting_edit_mess'] ?></span></span>
		</div>
		<div class="lefteditor">
			<ul>
				<li <?php if($this->_tpl_vars['groupid']==1){ ?>class="hover" <?php } ?>id="tabbottonul1"  onmousedown="javascript:windowsclass('#tabbottonul1','#tabcontentdiv1','tabbottonul','tabcontentdiv',1,6,'hover','');"><?php echo $this->_tpl_vars['ST']['setting_edit_title1'] ?></li>
				<li <?php if($this->_tpl_vars['groupid']==2){ ?>class="hover" <?php } ?>id="tabbottonul2"  onmousedown="javascript:windowsclass('#tabbottonul2','#tabcontentdiv2','tabbottonul','tabcontentdiv',2,6,'hover','');"><?php echo $this->_tpl_vars['ST']['setting_edit_title2'] ?></li>
				<li <?php if($this->_tpl_vars['groupid']==3){ ?>class="hover" <?php } ?>id="tabbottonul3"  onmousedown="javascript:windowsclass('#tabbottonul3','#tabcontentdiv3','tabbottonul','tabcontentdiv',3,6,'hover','');"><?php echo $this->_tpl_vars['ST']['setting_edit_title3'] ?></li>
				<li <?php if($this->_tpl_vars['groupid']==4){ ?>class="hover" <?php } ?>id="tabbottonul4"  onmousedown="javascript:windowsclass('#tabbottonul4','#tabcontentdiv4','tabbottonul','tabcontentdiv',4,6,'hover','');"><?php echo $this->_tpl_vars['ST']['setting_edit_title4'] ?></li>
				<li <?php if($this->_tpl_vars['groupid']==5){ ?>class="hover" <?php } ?>id="tabbottonul5"  onmousedown="javascript:windowsclass('#tabbottonul5','#tabcontentdiv5','tabbottonul','tabcontentdiv',5,6,'hover','');"><?php echo $this->_tpl_vars['ST']['setting_edit_title5'] ?></li>
				<li <?php if($this->_tpl_vars['groupid']==6){ ?>class="hover" <?php } ?>id="tabbottonul6"  onmousedown="javascript:windowsclass('#tabbottonul6','#tabcontentdiv6','tabbottonul','tabcontentdiv',6,6,'hover','');"><?php echo $this->_tpl_vars['ST']['setting_edit_title6'] ?></li>
			</ul>
		</div>
		<div class="manageeditdiv">
			<div class="maneditcontent_editor">
			<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
			<table class="formtable <?php if($this->_tpl_vars['array'][$i]['key']!=$this->_tpl_vars['groupid']){ ?>displaynone<?php } ?>" id="tabcontentdiv<?php echo $this->_tpl_vars['array'][$i]['key'] ?>">
				<?php if (count($this->_tpl_vars['array'][$i]['list'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['array'][$i]['list']); $ii++){?>
				<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['isline']==1){ ?>
				<tr class="trstyle2">
					<td class="trtitle03" colspan="2"><?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['str'] ?></td>
				</tr>
					<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['valname']=='title_mail'){ ?>
					<tr class="trstyle2">
						<td class="trtitle01"></td>
						<td class="trtitle02"><a class="infolink05" onclick="javascript:submiturl('index.php?archive=mailtemplatemain&action=maildemo','index.php?archive=management&action=load','<?php echo $this->_tpl_vars['ST']['run_ok'] ?>','<?php echo $this->_tpl_vars['ST']['run_no'] ?>',false,'','selectform','selectall','check_all')" href="#body" title="<?php echo $this->_tpl_vars['ST']['mailtemplatemain_send_demo'] ?>" hidefocus="true"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_send_demo'] ?></a> <span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['mailtemplatemain_send_demo_mess'] ?></span></td>
					</tr>
					<?php } ?>
				<?php }else{ ?>
				<tr class="trstyle2">
					<td class="trtitle01"><?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['content'] ?></td>
					<td class="trtitle02">
						<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['valtype']=='string'){ ?>
						<input type="text" name="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>" size="50" maxlength="250" value="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['value'] ?>" class="infoInput"/>
						<?php } ?>
						<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['valtype']=='password'){ ?>
						<input type="password" name="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>" size="50" maxlength="250" value="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['value'] ?>" class="infoInput"/>
						<?php } ?>
						<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['valtype']=='text'){ ?>
						<textarea name="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>" cols="50" rows="5" class="smallInput" style="width:98%;height:50px;"><?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['value'] ?></textarea>
						<?php } ?>
						<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['valtype']=='font'){ ?>
						<input type="text" name="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>" size="30" maxlength="250" value="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['value'] ?>" class="infoInput"/>
						<?php } ?>
						<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['valtype']=='int'){ ?>
						<input type="text" name="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>" size="10" maxlength="20" value="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['value'] ?>" class="infoInput"/>
						<?php } ?>
						<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['valtype']=='bool'){ ?>
						<input type="radio" value="1" name="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>"<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['value']==1){ ?> checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['b1'] ?>&nbsp;
						       <input type="radio" value="0" name="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>"<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['value']==0){ ?> checked="checked"<?php } ?>/> <?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['b2'] ?>
						<?php } ?>
						<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['valtype']=='select'){ ?>
							<select size="1" name="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>" id="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>">
							<?php if (count($this->_tpl_vars['lngarray'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['lngarray']); $list++){?>
								<option <?php if($this->_tpl_vars['array'][$i]['list'][$ii]['value']==$this->_tpl_vars['lngarray'][$list]['lng']){ ?>selected<?php } ?> value="<?php echo $this->_tpl_vars['lngarray'][$list]['lng'] ?>"><?php echo $this->_tpl_vars['lngarray'][$list]['lngtitle'] ?></option>
							<?php }} ?>
							</select>
						<?php } ?>
						<?php if($this->_tpl_vars['array'][$i]['list'][$ii]['valtype']=='selectkey'){ ?>
							<select size="1" name="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>" id="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['valname'] ?>">
							<?php if (count($this->_tpl_vars['array'][$i]['list'][$ii]['selectkey'])>0){$divid_iii=1;for($iii=0;$iii<count($this->_tpl_vars['array'][$i]['list'][$ii]['selectkey']); $iii++){?>
								<option <?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['selectkey'][$iii]['selected'] ?> value="<?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['selectkey'][$iii]['key'] ?>"><?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['selectkey'][$iii]['name'] ?></option>
							<?php }} ?>
							</select>
						<?php } ?>
						<?php if(empty( $this->_tpl_vars['array'][$i]['list'][$ii]['str'] )!=fase && $this->_tpl_vars['array'][$i]['list'][$ii]['valtype']!='text'){ ?><span class="cautiontitle"><?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['str'] ?></span><?php } ?>
						
					</td>
				</tr>
					<?php if(empty( $this->_tpl_vars['array'][$i]['list'][$ii]['str'] )!=fase && $this->_tpl_vars['array'][$i]['list'][$ii]['valtype']=='text'){ ?>
					<tr class="trstyle2">
						<td></td>
						<td class="trtitle02"><span class="cautiontitle"><?php echo $this->_tpl_vars['array'][$i]['list'][$ii]['str'] ?></span></td>
					</tr>
					<?php } ?>
				<?php } ?>
				<?php }} ?>
				<tr>
					<td colspan="2"></td>
				</tr>
			</table>
			<?php }} ?>
			</div>
		</div>
	</div>
</div>
<div id="downbotton">
	<div id="subbotton">
		<table border="0" width="100%">
			<tr>
				<td id="center"><input type="submit" name="Submit" value="<?php echo $this->_tpl_vars['ST']['botton_edit'] ?>" class="buttonface" /></td>
			</tr>
		</table>
	</div>
</div>
</form>
</body>

</html>