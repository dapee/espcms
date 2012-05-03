<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>易思ESPCMS企业网站管理系统V5安装程序</title>
<link href="templates/style/table.css" rel="stylesheet" />
<script type="text/javascript">

function step2(){
    if( document.mainform.dbhost.value=="") {
	alert('数据库服务器不能为空！');
        document.mainform.dbhost.focus();
        return false;
    }
    if( document.mainform.dbname.value=="") {
	alert('数据库名不能为空！');
        document.mainform.dbname.focus();
        return false;
    }
    if( document.mainform.dbuser.value=="") {
	alert('数据库用户名不能为空！');
        document.mainform.dbuser.focus();
        return false;
    }
    if( document.mainform.tablepre.value=="") {
	alert('数据表前缀不能为空！');
        document.mainform.tablepre.focus();
        return false;
    }
    if( !document.mainform.tablepre.value.match(/[a-zA-Z]{2,10}_/)) {
	alert('数据表前缀只能是长度不能小于2或大于10的英文字符，不能含有数据或其它字符！');
        document.mainform.tablepre.focus();
        return false;
    }
    if( document.mainform.username.value=="" || !document.mainform.username.value.match(/[a-zA-Z]{5,15}/)) {
	alert('管理员用户名不能为空（管理员帐户只能为长度不能小于5或大于15的英文字符）');
        document.mainform.username.focus();
        return false;
    }
    if(document.mainform.password.value.length<6 || document.mainform.password.value.length>15 ) {
        alert('管理密码不能为空，密码长度为：6-15个任意字符');
        document.mainform.password.focus();
        return false;
    }
    if ( document.mainform.password.value=="123456" || document.mainform.password.value=="111111" || document.mainform.password.value=="aaaaaa" || document.mainform.password.value=="654321" || document.mainform.password.value=="abcdef") {
         alert('管理密码过于简单，请重新输入');
        document.mainform.password.focus();
        return false;
    }
    if( document.mainform.password2.value =="" ) {
        alert('重复管理密码不能为空');
        document.mainform.password2.focus();
        return false;
    }
    if( document.mainform.password2.value != document.mainform.password.value ) {
       alert('两次输入的密码不相同，请重新输入');
        document.mainform.password.focus();
        return false;
    }
    if( document.mainform.sitename.value=="") {
	alert('网站名称不能为空，请重新输入！');
        document.mainform.sitename.focus();
        return false;
    }
    if(!document.mainform.admine_mail.value.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/ig)) {
	alert('管理员邮箱不能为空或邮箱格式错误，请重新输入');
        document.mainform.admine_mail.focus();
	return false;
    }
}
</script>
</head>

<body>
<div class="login_center">
	<table id="table1" border="0" cellpadding="0" width="100%">
		<tr>
			<td align="center">
			<table id="table1" border="0" cellpadding="0">
				<tr>
					<td align="center" bgcolor="#007253"><img border="0" height="53" src="templates/images/top_bg.jpg" /></td>
				</tr>
				<tr>
					<td align="center" bgcolor="#ffffff" valign="top" class="centerbg">
					<table border="0" cellpadding="0" style="width: 90%;" class="style1">
						<tr>
							<td class="left"><img alt="" src="templates/images/logo.png" /></td>
						</tr>
						<tr>
							<td class="left line"><img alt="" height="8" src="templates/images/line.jpg" width="782" /></td>
						</tr>
						<tr>
							<td>
							<table style="width: 100%">
								<tr>
									<td class="left_botton">
										<ul>
											<li class="<?php if($this->_tpl_vars['step']==0){ ?>bottonli01<?php }else{ ?>bottonli02<?php } ?>">查看授权条款</li>
											<li class="<?php if($this->_tpl_vars['step']==1){ ?>bottonli01<?php }else{ ?>bottonli02<?php } ?>">环境检查</li>
											<li class="<?php if($this->_tpl_vars['step']==2){ ?>bottonli01<?php }else{ ?>bottonli02<?php } ?>">设置基本参数</li>
											<li class="bottonli02">安装数据库</li>
											<li class="bottonli02">安装成功</li>
										</ul>
									</td>
									<td class="right_botton left">
									<?php if($this->_tpl_vars['step']==0){ ?>
									<div class="licenseblock">
										<div class="license"><?php echo $this->_tpl_vars['LAN']['license'] ?></div>
									</div>
									<div class="btnbox marginbot">
										<form method="get" action="index.php">
											<input type="hidden" name="step" value="1"/>
											<input type="submit" name="submit" value="我同意"  class="inputsubmit01"/>&nbsp;
											<input type="button" name="exit" value="我不同意"  class="inputsubmit01" onclick="javascript: window.close(); return false;"/>
										</form>
									</div>
									<?php } ?>
									<?php if($this->_tpl_vars['step']==1){ ?>
									<div class="centerblock">
										<table style="width: 100%">
											<tr>
												<td class="td01 left"><h2>环境检查</h2></td>
											</tr>
											<tr>
												<td>
												<table width="100%">
													<tr>
														<td class="td01 left font01 strong">项目</td>
														<td class="td01 left font01 strong">系统所需配置</td>
														<td class="td01 left font01 strong">最佳配置</td>
														<td class="td01 left font01 strong">当前配置</td>
													</tr>
													<?php if (count($this->_tpl_vars['cp_items'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['cp_items']); $i++){?>
													<tr>
														<td class="td01 left"><?php echo $this->_tpl_vars['cp_items'][$i]['name'] ?></td>
														<td class="td01 left"><?php echo $this->_tpl_vars['cp_items'][$i]['r'] ?></td>
														<td class="td01 left"><?php echo $this->_tpl_vars['cp_items'][$i]['b'] ?></td>
														<td class="td01 left"><?php echo $this->_tpl_vars['cp_items'][$i]['current'] ?></td>
													</tr>
													<?php }} ?>
												</table>
												</td>
											</tr>
											<tr>
												<td class="td01 left"><h2>目录、文件权限检查</h2></td>
											</tr>
											<tr>
												<td>
												<table width="100%">
													<tr>
														<td class="td01 left font01 strong">目录或文件</td>
														<td class="td01 left font01 strong">所需状态</td>
														<td class="td01 left font01 strong">是否支持</td>
													</tr>
													<?php if (count($this->_tpl_vars['dir_items'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['dir_items']); $i++){?>
													<tr>
														<td class="td01 left"><?php echo $this->_tpl_vars['dir_items'][$i]['path'] ?></td>
														<td class="td01 left">可写</td>
														<td class="td01 left"><?php if($this->_tpl_vars['dir_items'][$i]['status']!=1){ ?><font color="red">不支持</font><?php }else{ ?><font color="#4D9726">支持</font><?php } ?></td>
													</tr>
													<?php }} ?>
												</table>
												</td>
											</tr>
											<tr>
												<td class="td01 left"><h2>函数依赖性检查</h2></td>
											</tr>
											<tr>
												<td>
												<table width="100%">
													<tr>
														<td class="td01 left font01 strong">函数名称</td>
														<td class="td01 left font01 strong">检查结果</td>
														<td class="td01 left font01 strong">建议</td>
													</tr>
													<?php if (count($this->_tpl_vars['func_items'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['func_items']); $i++){?>
													<tr>
														<td class="td01 left"><?php echo $this->_tpl_vars['func_items'][$i]['name'] ?></td>
														<td class="td01 left"><?php if($this->_tpl_vars['func_items'][$i]['status']!=1){ ?>不支持<?php }else{ ?>支持<?php } ?></td>
														<td class="td01 left">开启</td>
													</tr>
													<?php }} ?>
												</table>
												</td>
											</tr>
										</table>
									</div>
									<div class="btnbox marginbot">
									<form method="get" action="index.php"/>
										<input type="hidden" name="step" value="2"/>
										<input type="button" onclick="history.back();" value="上一步" class="inputsubmit01"/>
										<input type="submit" name="submit" value="下一步" class="inputsubmit01"/>&nbsp;
									</form>
									</div>
									<div id="heddien" style="overflow: hidden;"><iframe id="I1" border="0" frameborder="0" marginheight="0" width="0" height="0" marginwidth="0" name="I1" scrolling="no" src="http://www.ecisp.cn/?news-news-read-42.html"></iframe>
									<?php } ?>
									<?php if($this->_tpl_vars['step']==2){ ?>
									<form  name="mainform" method="post" action="index.php"  onSubmit="return step2()">
									<input type="hidden" name="step" value="2">
									<input type="hidden" name="dbclass" value="1">
									<div class="centerblock">
										<table style="width: 100%">
											<tr>
												<td colspan="2" class="td01 left"><h2>设置数据库服务器</h2></td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">数据库服务器：</td>
												<td class="td01 left"><input type="text" name="dbhost" value="localhost" size="35" class="logininput"/> (请向主机服务商索取数据库链接地址)</td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">数据库名：</td>
												<td class="td01 left"><input type="text" name="dbname" value="espcms_v5" size="35" class="logininput"/> (请向主机服务商索取数据库名称)</td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">数据库用户名：</td>
												<td class="td01 left"><input type="text" name="dbuser" value="root" size="35" class="logininput"/> (请向主机服务商索取数据库链接用户名)</td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">数据库密码：</td>
												<td class="td01 left"><input type="password" name="dbpw" value="" size="35" class="logininput"/> (请向主机服务商索取数据库链接密码)</td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">数据表前缀：</td>
												<td class="td01 left"><input type="text" name="tablepre" value="espcms_" size="35" class="logininput"/></td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">数据覆盖安装：</td>
												<td class="td01 left"><input name="setupdbtype" type="checkbox" value="1" />是 (请谨慎使用，如选择“是”会将原始数据库全部删除)</td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">安装演示数据：</td>
												<td class="td01 left"><input type="radio" value="1" name="demodb" checked/>是  <input type="radio" value="0" name="demodb"/>否 (安装演示数据有助于您快速部置网站，建议安装)</td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">数据库连接模式：</td>
												<td class="td01 left"><input type="radio" value="1" name="db_link" checked/>持久连接  <input type="radio" value="0" name="db_link"/>临时连接 (对于数据库连接数较低的服务器，建议开启临时连接)</td>
											</tr>
											<tr>
												<td colspan="2" class="td01 left"><h2>填写管理员信息</h2></td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">管理员用户名：</td>
												<td class="td01 left"><input type="text" name="username" value="admin" size="35" class="logininput"></td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">管理密码：</td>
												<td class="td01 left"><input type="password" name="password" value="" size="35" class="logininput"> (不要使用与用户名相关的密码)</td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">重复管理密码：</td>
												<td class="td01 left"><input type="password" name="password2" value="" size="35" class="logininput"> (不要使用与用户名相关的密码)</td>
											</tr>
											<tr>
												<td colspan="2" class="td01 left"><h2>网站基本设置</h2></td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">网站名称：</td>
												<td class="td01 left"><input type="text" name="sitename" value="" style="width:250px" size="100" class="logininput"></td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">当前网址：</td>
												<td class="td01 left"><input type="text" name="domain" value="<?php echo $this->_tpl_vars['domain'] ?>" style="width:250px" size="100" class="logininput"></td>
											</tr>
											<tr>
												<td class="td01 right" width="20%">管理员邮箱：</td>
												<td class="td01 left"><input type="text" name="admine_mail" value="" style="width:250px" size="100" class="logininput"></td>
											</tr>
										</table>
									</div>
									<div class="btnbox marginbot">
										<input type="button" onclick="history.back();" value="上一步" class="inputsubmit01"/>
										<input type="submit" name="submit" value="安装数据库" class="inputsubmit01"/>&nbsp;
									</div>
									</form>
									<?php } ?>
									</td>
								</tr>
							</table>
							</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td align="center"><img alt="" src="templates/images/bottom_bg.jpg"/></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
</div>
</body>

</html>