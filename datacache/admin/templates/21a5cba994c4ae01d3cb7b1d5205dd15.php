<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['softtitle'] ?></title>
<link href="templates/css/baselist.css" rel="stylesheet" type="text/css" />
<link href="templates/css/all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="JavaScript">
	var createmain_bat_typeinfo  = "<?php echo $this->_tpl_vars['ST']['createmain_bat_typeinfo'] ?>";
	var createmain_bat_typeinfo2  = "<?php echo $this->_tpl_vars['ST']['createmain_bat_typeinfo2'] ?>";
	var createmain_bat_typeinfo3  = "<?php echo $this->_tpl_vars['ST']['createmain_bat_typeinfo3'] ?>";
	var createmain_mess_title3  = "<?php echo $this->_tpl_vars['ST']['createmain_mess_title3'] ?>";
	var createmain_mess_title4  = "<?php echo $this->_tpl_vars['ST']['createmain_mess_title4'] ?>";
	var createmain_creat_yes  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_yes'] ?>";
	var createmain_creat_no  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_no'] ?>";
	var createmain_js_add_ok  = "<?php echo $this->_tpl_vars['ST']['createmain_js_add_ok'] ?>";
	var createmain_creat_no_c  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_no_c'] ?>";
	var createmain_creat_no_w  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_no_w'] ?>";
	var createmain_creat_no_t  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_no_t'] ?>";
	var createmain_creat_bottonname  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_bottonname'] ?>";
	var botton_close  = "<?php echo $this->_tpl_vars['ST']['botton_close'] ?>";
	var createmain_creat_title  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_title'] ?>";
	var err_createmain_err_title  = "<?php echo $this->_tpl_vars['ST']['err_createmain_err_title'] ?>";
	var is_html  = "<?php echo $this->_tpl_vars['is_html'] ?>";
	$(document).ready(function(){
		var h = $(window).height();
		$('#mainwindowhidden').css({height:h-39});
		if (is_html==1){
			get_load();
		}else{
			$('#filecheckmanger').empty();
			$('#filecheckmanger').append(err_createmain_err_title);
		}
	});
	function get_load(){
		$('#coasecreat').attr('disabled','true');
		$('#coasecreat').val(createmain_creat_bottonname);
		$('#filecheckmanger').remove();
		$('#filecheckloading').removeClass().addClass('formdiv displaytrue');
		var st=new Date().getTime()

		homeload();

		var midlist = '<?php echo $this->_tpl_vars['midlist'] ?>';
		var midArray = midlist.split(',');
		var count = midArray.length;
		if ( count <=0 ) return false;
		var typeloadurl="index.php?archive=createmain&action=statype&class=type";
		var subloadurl="index.php?archive=createmain&action=stasub";

		var countmax=500/count;
		var width=0;

		for(var ii=0;ii<count;ii++){
			width = width + countmax;
			$('#loadingline').css("width",width);

			var mid=midArray[ii];
			$.ajax({
				type: "POST",
				url: typeloadurl,
				dataType:'json',
				data: "lng=<?php echo $this->_tpl_vars['read']['lng'] ?>&mid="+mid+"&tid=0&creattype=1&pnumber=0&time=0",
				success: function(datenum){
					if (datenum.num>0) {
						doctypeload(datenum.typelist,datenum.mid);
					}
				}
			});
		}
		width=0;
		$('#loadingline').css("width",width);

		for(var ii=0;ii<count;ii++){
			width = width + countmax;
			$('#loadingline').css("width",width);

			var mid=midArray[ii];
			$.ajax({
				type: "POST",
				url: subloadurl,
				dataType:'json',
				data: "lng=<?php echo $this->_tpl_vars['read']['lng'] ?>&mid="+mid+"&sid=0",
				success: function(datenum){
					if (datenum.num>0) {
						subload(datenum.typelist,datenum.mid);
					}
				}
			});
		}

		var st2=new Date().getTime() - st;
		var mi = st2 / 60;
		$(this).ajaxStop(function(){
		        var stimetxt=createmain_mess_title3+mi+createmain_mess_title4;
			$("#htmltext").append("<br>"+createmain_js_add_ok);
			$('#coasecreat').val(botton_close);
			$('#coasecreat').attr('disabled','');
			$("#loadtext").append(stimetxt);
		 });
	}

	function homeload(){
		var loadurl="index.php?archive=createmain&action=indexsave";
		$.ajax({
			type: "POST",
			url: loadurl,
			data: "lng=<?php echo $this->_tpl_vars['read']['lng'] ?>"
		});
		return true;
	}

	function doctypeload(typelist,mid){

		var typeArray=null;
		typeArray=typelist.split(',');

		var typecount=typeArray.length;
		var loadurl="index.php?archive=createmain&action=creattypesave&class=type";
		var docloadurl="index.php?archive=createmain&action=creatdocsave";

		for(var i=0;i<typecount;i++){
			var typeid=typeArray[i];

			$.ajax({
				type: "POST",
				url: loadurl,
				data: "lng=<?php echo $this->_tpl_vars['read']['lng'] ?>&mid="+mid+"&tid="+typeid+"&creattype=1",
				success: function(date){
					if (date!='false'){
						var str=date+'<br/>';
						$("#htmltext").append(str);
					}
				}
			});
			$.ajax({
				type: "POST",
				url: docloadurl,
				data: "lng=<?php echo $this->_tpl_vars['read']['lng'] ?>&mid="+mid+"&tid="+typeid+"&creattype=<?php echo $this->_tpl_vars['read']['creattype'] ?>&dtime=<?php echo $this->_tpl_vars['read']['time'] ?>"
			});
		}
		return true;
	}

	function subload(sublist,mid){

		var typeArray=sublist.split(',');

		var count=typeArray.length;
		var sloadurl="index.php?archive=createmain&action=creatsubjectsave";
		for(var i=0;i<count;i++){
			var sid=typeArray[i];
			$.ajax({
				type: "POST",
				url: sloadurl,
				data: "lng=<?php echo $this->_tpl_vars['read']['lng'] ?>&mid="+mid+"&sid="+sid,
				success: function(date){
					if (date!='false'){
						var str=date+'<br/>';
						$("#htmltext").append(str);
					}
				}
			});
		}
		return true;
	}
	function loadclose(){
		parent.closeifram();
	}
</script>
</head>

<body>
<div class="centerrightwindow">
	<div id="mainwindowhidden">
		<div class="suggestion">
			<span class="sugicon"><span class="strong colorgorning2"><?php echo $this->_tpl_vars['ST']['position_title'] ?></span><span class="padding-left5 colorgorningage"><?php echo $this->_tpl_vars['ST']['createmain_creattype_title'] ?></span></span>
		</div>
		<div class="sugtitle-line"></div>
		<div class="formdiv" id="filecheckmanger">
			<table border="0" width="100%">
				<tr>
					<td id="center" style="padding:25px;"><img alt="" src="templates/images/loading_02.gif" /></td>
				</tr>
				<tr>
					<td id="center" class="strong colorgorning2" style="padding:0px"><?php echo $this->_tpl_vars['ST']['loading_title_mess'] ?></td>
				</tr>
			</table>
		</div>
		<div class="formdiv displaynone" id="filecheckloading">
			<table border="0" width="100%">
				<tr>
					<td id="loadtext" style="padding-top:10px;" class="colorgorning2 center lineheight160"></td>
				</tr>
				<tr>
					<td id="htmltext" style="padding-top:5px;" class="colorgorningage center lineheight160"></td>
				</tr>
			</table>
		</div>
	</div>
	<div id="downbotton">
		<div id="subbotton">
			<table border="0" width="100%">
				<tr id="bottonsubmit">
					<td id="center"><input type="button" name="cancel" id="coasecreat" onClick="javascript:loadclose();" value="<?php echo $this->_tpl_vars['ST']['botton_close'] ?>" class="buttonface"/></td>
				</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>
