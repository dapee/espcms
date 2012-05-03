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
	var createmain_js_mid_empty  = "<?php echo $this->_tpl_vars['ST']['createmain_js_mid_empty'] ?>";
	var createmain_js_pnumber_empty  = "<?php echo $this->_tpl_vars['ST']['createmain_js_pnumber_empty'] ?>";
	var createmain_js_tid_empty  = "<?php echo $this->_tpl_vars['ST']['createmain_js_tid_empty'] ?>";
	var createmain_js_add_ok  = "<?php echo $this->_tpl_vars['ST']['createmain_js_add_ok'] ?>";
	var createmain_js_add_no  = "<?php echo $this->_tpl_vars['ST']['createmain_js_add_no'] ?>";
	var iframename = "<?php echo $this->_tpl_vars['iframename'] ?>";
	iframename = iframename=='' ? "jerichotabiframe_0" : iframename;
	$(document).ready(function(){
		var h = '<?php echo $this->_tpl_vars['iframeheightwindow'] ?>';
		$('.managebottonadd').css({height:h-40});
		var options = {
			beforeSubmit: formverify,
			success:saveResponse
		}
		$("#creatindex").submit(function() {
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
			alert(createmain_js_add_ok);
		}else{
			alert(createmain_js_add_no+options);
		}
		parent.onaletdoc()
	}
	function lngtype(lng){
		$.ajax({
			type:"POST",
			url:'index.php?archive=language&action=getlngdir',
			data: 'lng='+lng,
			success:function(data){
				if (data!='') {
					$("#htmldir").empty();
					$("#htmldir").append(data);
				}
			}
		});
		
	}
</script>
</head>

<body>
<form method="post" name="creatindex" id="creatindex" action="index.php?archive=createmain&action=indexsave">
<div id="mainbodybottonauto" class="managebottonadd">
	<div class="maindobycontent">
		<div class="suggestion">
			<span class="sugicon"><span class="strong colorgorning2"><?php echo $this->_tpl_vars['ST']['position_title'] ?></span><span class="colorgorningage"><?php echo $this->_tpl_vars['ST']['createmain_home_creat_title'] ?></span></span>
		</div>
		<div class="manageeditdiv">
			<div class="maneditcontent">
				<table class="formtable">
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['createmain_add_lng'] ?></td>
						<td class="trtitle02">
							<?php if($this->_tpl_vars['is_alonelng']==1){ ?>
								<?php echo $this->_tpl_vars['home_lng'] ?>
								<input type="hidden" name="lng" id="lng" value="<?php echo $this->_tpl_vars['home_lng'] ?>">
							<?php }else{ ?>
								<select size="1" name="lng" id="lng" onchange="javascript:lngtype(this.value);">
								<?php if (count($this->_tpl_vars['lnglist'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['lnglist']); $list++){?>
									<option <?php echo $this->_tpl_vars['lnglist'][$list]['selected'] ?> value="<?php echo $this->_tpl_vars['lnglist'][$list]['lng'] ?>"><?php echo $this->_tpl_vars['lnglist'][$list]['lngtitle'] ?></option>
								<?php }} ?>
								</select>
							<?php } ?>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['createmain_home_add_path'] ?></td>
						<td class="trtitle02">
						<?php if($this->_tpl_vars['is_alonelng']==1){ ?>
							/<?php echo $this->_tpl_vars['htmldir'] ?><?php echo $this->_tpl_vars['entrance'] ?>.<?php echo $this->_tpl_vars['fileex'] ?>
						<?php }else{ ?>
							/<?php echo $this->_tpl_vars['htmldir'] ?><span id="htmldir"><?php echo $this->_tpl_vars['lngdir'] ?></span>/<?php echo $this->_tpl_vars['entrance'] ?>.<?php echo $this->_tpl_vars['fileex'] ?>
						<?php } ?>
						<span class="cautiontitle"><?php echo $this->_tpl_vars['ST']['createmain_home_add_path_mess'] ?></span>
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
				<td><input type="submit" name="Submit" value="<?php echo $this->_tpl_vars['ST']['botton_cerathtml'] ?>" class="buttonface" /></td>
			</tr>
		</table>
	</div>
</div>
</form>
</body>

</html>