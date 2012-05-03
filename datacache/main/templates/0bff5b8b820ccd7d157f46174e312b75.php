<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['lngpack']['enquirytitle'] ?> - <?php echo $this->_tpl_vars['lngpack']['sitename'] ?></title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['lngpack']['keyword'] ?>" />
<meta name="description" content="<?php echo $this->_tpl_vars['lngpack']['description'] ?>" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/tempates_div.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/pagebotton.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/basicrun.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/ajax_city.js"></script>
<script type="text/javascript">
$().ready(function() {
	$("#clickmenubotton li span").hover(function() {
		$(this).addClass("bgmenuhove2");
		$(this).parent().find("ul.subnav").slideDown('fast').show(); 
		$(this).parent().hover(function() {}, function(){
			$(this).parent().find("ul.subnav").fadeOut('fast');
			$(this).parent().find("span").removeClass("bgmenuhove2");
		});
	});
});
</script>
</head>

<body>
<div class="head">
	885BA145EFC8431D34F5CC06D142F143default/cn/public/head.html|885BA145EFC8431D34F5CC06D142F143
	<div class="bann"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/bann.jpg"/></div>
	<?php if($this->_tpl_vars['out']=='list'){ ?>
	<!--购物车列表-->
	<script type="text/javascript">
		var order_amout_err = "<?php echo $this->_tpl_vars['lngpack']['order_amout_err'] ?>";
	</script>
	<script type="text/javascript">
	<?php if($this->_tpl_vars['mem_isaddress']==1){ ?>
	$(function() {
	    sec_cityone('<?php echo $this->_tpl_vars['member']['country'] ?>','<?php echo $this->_tpl_vars['member']['province'] ?>');
	    sec_citytwo('<?php echo $this->_tpl_vars['member']['province'] ?>','<?php echo $this->_tpl_vars['member']['city'] ?>');
	    sec_district('<?php echo $this->_tpl_vars['member']['city'] ?>','<?php echo $this->_tpl_vars['member']['district'] ?>');
	});
	<?php } ?>
	var citytwo_title = "省";
	var citythree_title = "市";
	var district_title = "区";
	var address_title = "<?php echo $this->_tpl_vars['lngpack']['address_title'] ?>";
	var alias_empty = "<?php echo $this->_tpl_vars['lngpack']['alias_empty'] ?>";
	var email_err = "<?php echo $this->_tpl_vars['lngpack']['email_err'] ?>";
	var tel_empty = "<?php echo $this->_tpl_vars['lngpack']['tel_empty'] ?>";
	</script>
	<div class="bann">
		<div class="location">您现在的位置：<a href="<?php echo $this->_tpl_vars['homelink'] ?>">首页</a> » <?php echo $this->_tpl_vars['lngpack']['enquirytitle'] ?> » <b>询价产品清单</b></div>
	</div>
	<div class="framecenter margintop8">
		<form name="mainform" method="post" action="<?php echo $this->_tpl_vars['mlink']['enquirysave'] ?>" onsubmit="return enquirysave()">
		<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['member']['userid'] ?>"/>
		<table style="width:95%;margin:0px auto;margin-top:30px;margin-bottom:30px;">
			<tr>
				<td>
					<table>
						<tr>
							<td><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/status_online.gif" /></span></td>
							<td><span class="messtext strong fontsize14">询价列表</span></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="hrline"/></td>
			</tr>
			<?php if(count($this->_tpl_vars['array']) > 0 ){ ?>
			<tr>
				<td style="padding-top:10px">
					<table class="tablelist" width="100%" style="margin:0 auto;">
						<tr>
							<td class="td01 center">商品名</td>
							<td class="td01 center">商品编号</td>
							<td class="td01 center">订购数量</td>
							<td class="td01 center">操作</td>
						</tr>
						<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
						<tr>
							<td class="td02 left"><input type="hidden" name="ptitle[]" value="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>"><a target="_blank" class="infolink05" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['title'] ?></a></td>
							<td class="td02 center"><input type="hidden" name="tsn[]" value="<?php echo $this->_tpl_vars['array'][$i]['tsn'] ?>"><?php echo $this->_tpl_vars['array'][$i]['tsn'] ?></td>
							<td class="td02 center">
								<input type="text" name="amount[]" id="amount<?php echo $this->_tpl_vars['array'][$i]['did'] ?>" value="<?php echo $this->_tpl_vars['array'][$i]['amount'] ?>" onBlur="javascript:orderamount(<?php echo $this->_tpl_vars['array'][$i]['did'] ?>);" size="2" maxlength="5" class="infoInput">
								<input type="hidden" name="did[]" value="<?php echo $this->_tpl_vars['array'][$i]['did'] ?>">
							</td>
							<td class="td02 center"><a class="infolink04" href="javascript:if (confirm('您确定要从询价列表中删除该商品吗？')) location.href='<?php echo $this->_tpl_vars['array'][$i]['dellink'] ?>';">删除询价</a></td>
						</tr>
						<?php }} ?>
						<tr class="tdheight4">
							<td colspan="6" class="td02 right">
								<input name="addch" class="buttonface2" type="button" value="继续选择商品" onclick="javascript:location.href='<?php echo $this->_tpl_vars['homelink'] ?>';">
								<input name="addch" class="buttonface2" type="button" value="清空询价表" onclick="javascript:if (confirm('您确定要清空所询价的商品吗？')) location.href='<?php echo $this->_tpl_vars['mlink']['cleargoods'] ?>';">
							</td>
						</tr>
					</table>
					
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/status_online.gif" /></span></td>
							<td><span class="messtext strong fontsize14">填写联系信息</span> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="hrline"/></td>
			</tr>
			<tr>
				<td style="padding-top:10px">
					<table class="tablelist" width="100%" style="margin:0 auto;">
						<tr>
						    <td class="td02 right" width="20%">联系人姓名：</td>
						    <td class="td02 left"><input type="text" name="linkman" value="<?php echo $this->_tpl_vars['member']['alias'] ?>" maxlength="50" size="20" class="infoInput"></td>
						</tr>
						<tr>
							<td class="td02 right">性别：</td>
							<td class="td02 left">
								<input type="radio" value="1" name="sex" <?php if($this->_tpl_vars['member']['sex']==1){ ?>checked<?php } ?>> 男&nbsp;
								<input type="radio" value="0" name="sex" <?php if($this->_tpl_vars['member']['sex']==0){ ?>checked<?php } ?>> 女
							</td>
						</tr>
						<tr>
						    <td class="td02 right">电子邮件：</td>
						    <td class="td02 left"><input type="text" name="email" value="<?php echo $this->_tpl_vars['member']['email'] ?>" maxlength="100" size="50" class="infoInput" style="width:40%;" ></td>
						</tr>
						<tr>
						    <td class="td02 right">联系电话：</td>
						    <td class="td02 left"><input type="text" name="tel" value="<?php echo $this->_tpl_vars['member']['tel'] ?>" maxlength="50" size="50" class="infoInput" style="width:40%;" ></td>
						</tr>
						<tr>
						    <td class="td02 right">手机：</td>
						    <td class="td02 left"><input type="text" name="mobile" value="<?php echo $this->_tpl_vars['member']['mobile'] ?>" maxlength="50" size="50" class="infoInput" style="width:40%;" ></td>
						</tr>
						<tr>
						    <td class="td02 right">传真：</td>
						    <td class="td02 left"><input type="text" name="fax" value="<?php echo $this->_tpl_vars['member']['fax'] ?>" maxlength="50" size="50" class="infoInput" style="width:40%;" ></td>
						</tr>
						<?php if($this->_tpl_vars['mem_isaddress']==1){ ?>
						<tr>
							<td class="td02 right">地区：</td>
							<td class="td02 left">
								<select size="1" name="cityone" class="select" id="cityone">
								    <option value="0" <?php if($this->_tpl_vars['member']['country']==0){ ?>selected<?php } ?>>国家</option>
								    <option value="1" <?php if($this->_tpl_vars['member']['country']==1){ ?>selected<?php } ?>>中国</option>
								</select>
								<select size="1" name="citytwo" class="select" id="citytwo">
								    <option selected value="0">省</option>
								</select>
								<select size="1" name="citythree" class="select" id="citythree">
								    <option selected value="0">市</option>
								</select>
								<select size="1" name="district" class="select" id="district">
								    <option selected value="0">区</option>
								</select>
								<span id="loading">正在读取</span>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td class="td02 right">详细地址：</td>
							<td class="td02 left"><input type="text" name="address" value="<?php echo $this->_tpl_vars['member']['address'] ?>" maxlength="120" size="60" style="width:70%;" class="infoInput"></td>
						</tr>
						<tr>
							<td class="td02 right">邮编：</td>
							<td class="td02 left"><input type="text" name="zipcode" value="<?php echo $this->_tpl_vars['member']['zipcode'] ?>" maxlength="10" size="10" class="infoInput"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/status_online.gif" /></span></td>
							<td><span class="messtext strong fontsize14">其它信息</span> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><hr class="hrline"/></td>
			</tr>
			<tr>
				<td style="padding-top:10px">
					<table class="tablelist" width="100%" style="margin:0 auto;">
						<tr>
						    <td class="td02 right" width="20%">备注：</td>
						    <td class="td02 left"><textarea name="content" rows="3" style="width:100%;height: 100px;"></textarea></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="center" style="padding-top:20px"><input type="submit" name="submit" id="submit" class="buttonface2" value="确认提交询价"></td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td style="padding-top:10px">
				<table class="tablelist" width="100%" style="margin:0 auto;">
					<tr>
						<td colspan="6" class="td02 center">您还没有选择询价商品!</td>
					</tr>
				</table>
				</td>
			</tr>
			<?php } ?>
		</table>
		</form>
	</div>
	<?php } ?>
	885BA145EFC8431D34F5CC06D142F143default/cn/public/link.html|885BA145EFC8431D34F5CC06D142F143
</div>
885BA145EFC8431D34F5CC06D142F143default/cn/public/footer.html|885BA145EFC8431D34F5CC06D142F143

</body>

</html>
