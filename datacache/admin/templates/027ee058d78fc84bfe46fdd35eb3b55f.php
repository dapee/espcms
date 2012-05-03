<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['softtitle'] ?></title>
<link href="templates/css/baselist.css" rel="stylesheet" type="text/css" />
<link href="templates/css/all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="JavaScript">
	var createmain_doc_mess_title  = "<?php echo $this->_tpl_vars['ST']['createmain_doc_mess_title'] ?>";
	var createmain_doc_mess_title2  = "<?php echo $this->_tpl_vars['ST']['createmain_doc_mess_title2'] ?>";
	var createmain_mess_title3  = "<?php echo $this->_tpl_vars['ST']['createmain_mess_title3'] ?>";
	var createmain_mess_title4  = "<?php echo $this->_tpl_vars['ST']['createmain_mess_title4'] ?>";
	var createmain_creat_yes  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_yes'] ?>";
	var createmain_creat_no  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_no'] ?>";
	var createmain_creat_no_c  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_no_c'] ?>";
	var createmain_creat_no_w  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_no_w'] ?>";
	var createmain_creat_no_t  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_no_t'] ?>";
	var createmain_creat_bottonname  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_bottonname'] ?>";
	var botton_close  = "<?php echo $this->_tpl_vars['ST']['botton_close'] ?>";
	var createmain_creat_title  = "<?php echo $this->_tpl_vars['ST']['createmain_creat_title'] ?>";
	var err_createmain_err_title  = "<?php echo $this->_tpl_vars['ST']['err_createmain_err_title'] ?>";
	var createmain_js_add_ok  = "<?php echo $this->_tpl_vars['ST']['createmain_js_add_ok'] ?>";
	var is_html  = "<?php echo $this->_tpl_vars['is_html'] ?>";
	$(document).ready(function(){
		var h = $(window).height();
		$('#mainwindowhidden').css({height:h-39});
		if (is_html==1){
			get_load();
		}else{
			$('#doccheckmanger').empty();
			$('#doccheckmanger').append(err_createmain_err_title);
		}
	});
	function get_load(){
		var loadurl="index.php?archive=createmain&action=statype";
		$('#doccoasecreat').attr('disabled','true');
		$('#doccoasecreat').val(createmain_creat_bottonname);
		$.ajax({
			type: "POST",
			url: loadurl,
			dataType:'json',
			data: "lng=<?php echo $this->_tpl_vars['read']['lng'] ?>&mid=<?php echo $this->_tpl_vars['read']['mid'] ?>&tid=<?php echo $this->_tpl_vars['read']['tid'] ?>&creattype=1&startid=<?php echo $this->_tpl_vars['read']['startid'] ?>&endid=<?php echo $this->_tpl_vars['read']['endid'] ?>",
			success: function(date){
				if (date.num>0) {
					$('#doccheckmanger').remove();
					$('#doccheckloading').removeClass().addClass('formdiv displaytrue');
					var newHTML=createmain_doc_mess_title+'<b><u> '+date.num+' </u></b>'+createmain_doc_mess_title2;
					$("#docloadtext").append(newHTML);
					loadingtext(date.typelist);
				}else{
					$('#doccheckmanger').remove();
					$('#doccheckloading').removeClass().addClass('formdiv displaytrue');
					var newHTML=createmain_doc_mess_title+'<b><u> '+date.num+' </u></b>'+createmain_doc_mess_title2;
					$("#docloadtext").append(newHTML);
					$("#dochtmltext").append(createmain_js_add_ok);
					$('#doccoasecreat').val(botton_close);
					$('#doccoasecreat').attr('disabled','');
				}
			}
		});
	}
	function loadingtext(typelist){

		var typeArray=typelist.split(',');

		var count=typeArray.length;
		var loadurl="index.php?archive=createmain&action=creatdocsave";

		var countmax=500/count;

		var equanum=100/count;
		var equ=0;
		var width=0;
		var st=new Date().getTime()

		for(var i=0;i<count;i++){
			var typeid=typeArray[i];
			$("#loadnum").empty().append(i+1);
			$.ajax({
				type: "POST",
				url: loadurl,
				data: "lng=<?php echo $this->_tpl_vars['read']['lng'] ?>&mid=<?php echo $this->_tpl_vars['read']['mid'] ?>&tid="+typeid+"&startid=<?php echo $this->_tpl_vars['read']['startid'] ?>&endid=<?php echo $this->_tpl_vars['read']['endid'] ?>",
				success: function(date){
					width = width + countmax;
					equ =  equ + equanum;
					var text = parseInt(equ) + "%";
					loadtxt(date,width,text);
				}
			});
		}

		var st2=new Date().getTime() - st;
		var mi = st2 / 60;
		$(this).ajaxStop(function(){
			$("#dochtmltext").append("<br>"+createmain_js_add_ok);
			var stimetxt=createmain_mess_title3+mi+createmain_mess_title4;
			$("#docloadtext").append(stimetxt);
			$('#doccoasecreat').val(botton_close);
			$('#doccoasecreat').attr('disabled','');
		});
	}
	function loadtxt(date,width,text){
		if (date=='false') return false;
		var str=date+'<br/>';
		$("#dochtmltext").append(str);
		$('#docloadingline').css("width",width);
		$("#docloadingline").empty().append(text);
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
		<div class="formdiv" id="doccheckmanger">
			<table border="0" width="100%">
				<tr>
					<td id="center" style="padding:25px;"><img alt="" src="templates/images/loading_02.gif" /></td>
				</tr>
				<tr>
					<td id="center" class="strong colorgorning2" style="padding:0px"><?php echo $this->_tpl_vars['ST']['loading_title_mess'] ?></td>
				</tr>
			</table>
		</div>
		<div class="formdiv displaynone" id="doccheckloading">
			<table border="0" width="100%">
				<tr>
					<td id="docloadtext" style="padding-top:10px;" class="colorgorning2 center lineheight160"></td>
				</tr>
				<tr>
					<td width="100%" style="padding-top:10px;" class="center">
						<div class="loadingtable" id="loadingtable">
							<div class="loadingline" id="docloadingline">0</div>
						</div>
					</td>
				</tr>
				<tr>
					<td id="dochtmltext" style="padding-top:5px;" class="colorgorningage center lineheight160"></td>
				</tr>
			</table>
		</div>
	</div>
	<div id="downbotton">
		<div id="subbotton">
			<table border="0" width="100%">
				<tr id="bottonsubmit">
					<td id="center"><input type="button" name="cancel" id="doccoasecreat" onClick="javascript:loadclose();" value="<?php echo $this->_tpl_vars['ST']['botton_close'] ?>" class="buttonface"/></td>
				</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>
