<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['softtitle'] ?></title>
<link href="templates/css/baselist.css" rel="stylesheet" type="text/css" />
<link href="templates/css/all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="JavaScript">

	$(document).ready(function(){
		var h = $(window).height();
		$('#mainwindowhidden').css({height:h-10});
	});
</script>
</head>

<body>
<div class="centerrightwindow">
	<div id="mainwindowhidden">
	<div class="suggestion">
		<span class="sugicon"><span class="strong colorgorning2"><?php echo $this->_tpl_vars['ST']['position_title'] ?>：</span><span class="padding-left5 colorgorningage"><?php echo $this->_tpl_vars['ST']['loading_title'] ?></span></span>
	</div>
	<div class="sugtitle-line"></div>
	<div class="formdiv">
		<table border="0" width="100%">
			<tr>
				<td id="center" style="padding:25px;"><img alt="" src="templates/images/loading_02.gif" /></td>
			</tr>
			<tr>
				<td id="center" class="strong colorgorning2" style="padding:0px"><?php echo $this->_tpl_vars['ST']['loading_title_mess'] ?></td>
			</tr>
		</table>
	</div>
	</div>
</div>
</body>

</html>
