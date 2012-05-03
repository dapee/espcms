<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>易思ESPCMS企业网站管理系统V5安装程序</title>
<link href="templates/style/table.css" rel="stylesheet" />
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
									<td class="right_botton left">
									<div class="centerblock">
										<table style="width: 100%">
											<tr>
												<td class="td01 right" width="20%">安装提示：</td>
												<td class="td01 left"><h2><?php echo $this->_tpl_vars['mess'] ?></h2></td>
											</tr>
											<tr>
												<td colspan="2" class="td01 center"></td>
											</tr>
											<?php if($this->_tpl_vars['messageid']==0){ ?>
											<tr>
												<td class="td01 right" width="20%">错误信息：</td>
												<td class="td01 left"><?php echo $this->_tpl_vars['btname'] ?></td>
											</tr>
											<tr>
												<td class="td01 right" width="20%"></td>
												<td class="td01 left">您必须解决以上问题，安装才可以继续</td>
											</tr>
											<?php } ?>
										</table>
									</div>
									<?php if($this->_tpl_vars['classbotton']==0){ ?>
									<div class="btnbox marginbot">
										<input type="button" onclick="history.back();" value="返回上一步" class="inputsubmit01"/>
									</div>
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