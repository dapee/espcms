<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="zh-cn" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['softtitle'] ?></title>
<link href="templates/css/all.css" rel="stylesheet" type="text/css" />
<link href="templates/css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/control.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var h = $(window).height();
   		$('#centerlogin').css({height:h});
	});
	var resizeTimer = null;

	function sizewindow(){
		var h = $(window).height();
   		$('#centerlogin').css({height:h});
	}

	window.onresize=sizewindow;
	var adminuser_login_login_error="<?php echo $this->_tpl_vars['ST']['adminuser_login_login_error'] ?>";
	var adminuser_login_incorrect="<?php echo $this->_tpl_vars['ST']['adminuser_login_incorrect'] ?>";
	var adminuser_login_seccode_error="<?php echo $this->_tpl_vars['ST']['adminuser_login_seccode_error'] ?>";
	var ie_cookie_err="<?php echo $this->_tpl_vars['ST']['ie_cookie_err'] ?>";
</script>
<!--[if IE 6]> 
<style type="text/css" media="screen"> 
body {behavior:url("templates/css/csshover.htc"); } 
</style>
<![endif]--> 
</head>

<body>
<div class="login-div">
 <table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" id="centerlogin">
    <tr>
            <td valign="middle" align="center" style="width:564px;">
            <div class="login-form">
	        <table border="0" cellpadding="0" style="border-collapse: collapse" width="564">
			    <tr>
			            <td class="login-top"></td>
			    </tr>
			    <tr>
			            <td class="login-bg">
			            <table style="width:100%">
							<tr>
								<td class="login"><img src="templates/images/login_logo.jpg" title="<?php echo $this->_tpl_vars['softtitle'] ?>"/></td>
							</tr>
							<tr>
								<td>
								<table style="width:100%">
									<tr>
										<td class="login-title">
										<table style="width:100%">
											<tr>
												<td><img src="templates/images/login_title.png" title="<?php echo $this->_tpl_vars['softtitle'] ?>"/></td>
											</tr>
											<tr>
												<td class="loigntitle"><?php echo $this->_tpl_vars['ST']['adminuser_lonin_text'] ?></td>
											</tr>
										</table>
										</td>
										<td class="loign-line"><img alt="line" src="templates/images/login_line.png" /></td>
										<td class="login-form-center">
										<!--from-->
									            <form name="loginform" id="loginform" method="post" action="index.php" onSubmit="return loginformsave()">
										    <input type="hidden" name="archive" value="adminuser">
										    <input type="hidden" name="action" value="login_into">
									            <table border="0" cellpadding="0">
									            		<tr>
									            			<td class="logintd"></td>
									            			<td class="logintd2"><div class="loginwanntile"><ul><li><span id="logintitle"><?php echo $this->_tpl_vars['ST']['adminuser_login_login_error'] ?></span></li></ul></div></td>
									            		</tr>
									                    <tr>
									                            <td class="logintd"><?php echo $this->_tpl_vars['ST']['adminuser_lonin_username'] ?></td>
									                            <td class="logintd2"><input type="text" name="username" class="infoInput" maxlength="20" id="username" value="" style="width:175px;"/></td>
									                    </tr>
									                    <tr>
									                            <td class="logintd"><?php echo $this->_tpl_vars['ST']['adminuser_login_password'] ?></td>
									                            <td class="logintd2"><input type="password" name="password" class="infoInput" maxlength="20" id="password" style="width:175px;"/></td>
									                    </tr>
									                    <tr>
									                            <td class="logintd"><?php echo $this->_tpl_vars['ST']['adminuser_login_seccode'] ?></td>
									                            <td class="logintd2"><input type="text" name="seccode" class="infoInput" id="seccode" maxlength="4" style="width:80px;text-transform: uppercase;"/> <img title="<?php echo $this->_tpl_vars['ST']['adminuser_login_seccode_tips'] ?>" id="seccodesrc" onclick="this.src='../public/seccode.php?secode=ecisp_seccode&' + Math.random()" src="../public/seccode.php?secode=ecisp_seccode" style="cursor: pointer;" align="absmiddle"/></td>
									                    </tr>
									                    <tr>
									                            <td class="logintd"></td>
									                            <td class="logintd2"><input type="submit" class="buttonface" name="button" value="<?php echo $this->_tpl_vars['ST']['adminuser_login_log_action'] ?>"/></td>
									                    </tr>
									            </table>
									            </form>
										<!--form_end-->
										</td>
									</tr>

								</table>
								</td>
							</tr>
						</table>
			            </td>
			    </tr>
			    <tr>
			            <td class="login-down"></td>
			    </tr>
			</table>
		</div>
		<div class="fotter">EarcLink.COM 2002-2011 All Rights Reserved 后台推荐使用IE8、谷歌或Firefox浏览器</div>
    </tr>
</table>
</div>
</body>

</html>
