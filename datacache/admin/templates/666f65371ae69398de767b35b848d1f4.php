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
	var iframename = "<?php echo $this->_tpl_vars['iframename'] ?>";
	$(document).ready(function(){
		var h = '<?php echo $this->_tpl_vars['iframeheightwindow'] ?>';
		$('.managebottonadd').css({height:h-40});
		var optionsbat = {
			beforeSubmit: bat_formverify,
			success:function(){}
		}
		$("#createbat").submit(function() {
			$(this).ajaxSubmit(optionsbat);
			return false;
		});
	})
	function bat_formverify(formData, jqForm, options) {
		var queryString = $.param(formData);
		var get=urlarray(queryString);
		var loadurl='index.php?archive=createmain&action=createbatwindow&lng='+get['lng']+'&creattype='+get['creattype']+'&time='+get['time'];
		parent.windowsdig('Loading','iframe:'+loadurl,'750px','400px','iframe',false);
		return false;
	}
</script>
</head>

<body>
<form method="post" name="createbat" id="createbat" action="index.php?archive=createmain&action=indexsave">
<div id="mainbodybottonauto" class="managebottonadd">
	<div class="maindobycontent">
		<div class="suggestion">
			<span class="sugicon"><span class="strong colorgorning2"><?php echo $this->_tpl_vars['ST']['position_title'] ?></span><span class="colorgorningage"><?php echo $this->_tpl_vars['ST']['createmain_bat_mess_title'] ?></span></span>
		</div>
		<div class="manageeditdiv">
			<div class="maneditcontent">
				<table class="formtable">
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['createmain_add_lng'] ?></td>
						<td class="trtitle02">
							<?php if($this->_tpl_vars['is_alonelng']==1){ ?>
								<?php echo $this->_tpl_vars['home_lng'] ?>
								<input type="hidden" name="lng" value="<?php echo $this->_tpl_vars['home_lng'] ?>">
							<?php }else{ ?>
								<select size="1" name="lng">
								<?php if (count($this->_tpl_vars['lnglist'])>0){$divid_list=1;for($list=0;$list<count($this->_tpl_vars['lnglist']); $list++){?>
									<option <?php echo $this->_tpl_vars['lnglist'][$list]['selected'] ?> value="<?php echo $this->_tpl_vars['lnglist'][$list]['lng'] ?>"><?php echo $this->_tpl_vars['lnglist'][$list]['lngtitle'] ?></option>
								<?php }} ?>
								</select>
							<?php } ?>
						</td>
					</tr>
					<tr class="trstyle2">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['createmain_bat_add_type'] ?></td>
						<td class="trtitle02">
							<input type="radio" value="1" name="creattype" onclick="ondisplay('validatetextdiv','trstyle2 displaytrue')"/> <?php echo $this->_tpl_vars['ST']['createmain_bat_add_type1'] ?>&nbsp;
							<input type="radio" value="0" name="creattype" checked="checked" onclick="ondisplay('validatetextdiv','trstyle2 displaynone')"/> <?php echo $this->_tpl_vars['ST']['createmain_bat_add_type2'] ?>
						</td>
					</tr>
					<tr class="trstyle2 displaynone" id="validatetextdiv">
						<td class="trtitle01"><?php echo $this->_tpl_vars['ST']['createmain_bat_add_time'] ?></td>
						<td class="trtitle02">
							<input type="text" name="time" id="time" maxlength="20" size="20" value="<?php echo $this->_tpl_vars['time'] ?>" onclick="WdatePicker({el:'time',readOnly:true,dateFmt:'yyyy-MM-dd'})" class="infoInput">
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