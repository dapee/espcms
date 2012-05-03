<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['lngpack']['ordertitle'] ?> - <?php echo $this->_tpl_vars['lngpack']['sitename'] ?></title>
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
	<?php if($this->_tpl_vars['out']=='buylist'){ ?>
	<script type="text/javascript">
		var order_amout_err = "<?php echo $this->_tpl_vars['lngpack']['order_amout_err'] ?>";
	</script>
	<div class="bann">
		<div class="location">您现在的位置：<a href="<?php echo $this->_tpl_vars['homelink'] ?>">首页</a> » <?php echo $this->_tpl_vars['lngpack']['ordertitle'] ?> » <b>购物车查看</b></div>
	</div>
	<div class="framecenter margintop8">
			<table style="width:95%;margin:0px auto;margin-top:30px;margin-bottom:30px;">
				<tr>
					<td>
						<table>
							<tr>
								<td><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/cart_go.gif" /></span></td>
								<td><span class="messtext strong fontsize14">我的购物车</span></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><hr class="hrline"/></td>
				</tr>
				<tr>
					<td style="padding-top:10px">
						<?php if(count($this->_tpl_vars['array']) > 0 ){ ?>
						<form name="mainform" method="post" action="<?php echo $this->_tpl_vars['mlink']['orderupdae'] ?>">
						<table class="tablelist" width="100%" style="margin:0 auto;">
							<tr>
								<td class="td01 center">商品名</td>
								<td class="td01 center">商品编号</td>
								<td class="td01 center">订购价格</td>
								<td class="td01 center">数量</td>
								<td class="td01 center">小计</td>
								<td class="td01 center">操作</td>
							</tr>
							<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
							<tr>
								<td class="td02 left"><a target="_blank" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['title'] ?></a></td>
								<td class="td02 center"><?php echo $this->_tpl_vars['array'][$i]['tsn'] ?></td>
								<td class="td02 center">
									<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['array'][$i]['bprice'] ?>
									<input type="hidden" name="bprice[]" value="<?php echo $this->_tpl_vars['array'][$i]['bprice'] ?>">
									<input type="hidden" name="did[]" value="<?php echo $this->_tpl_vars['array'][$i]['did'] ?>">
								</td>
								<td class="td02 center">
									<input type="text" name="amount[]" id="amount<?php echo $this->_tpl_vars['array'][$i]['did'] ?>" value="<?php echo $this->_tpl_vars['array'][$i]['amount'] ?>" onBlur="javascript:orderamount(<?php echo $this->_tpl_vars['array'][$i]['did'] ?>);" size="2" maxlength="5" class="infoInput">
								</td>
								<td class="td02 center">
									<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['array'][$i]['countprice'] ?>
									<input type="hidden" name="countprice[]" id="countprice" value="<?php echo $this->_tpl_vars['array'][$i]['countprice'] ?>">
								</td>
								<td class="td02 center"><a class="infolink04" href="javascript:if (confirm('您确定要从购物车移出该商品吗？')) location.href='<?php echo $this->_tpl_vars['array'][$i]['dellink'] ?>';">删除</a></td>
							</tr>
							<?php }} ?>
							<tr>
								<td colspan="6" class="td02 right"><span class="font05 colorgreg strong">商品总金额：<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['ordertotal'] ?></span></td>
							</tr>
							<tr class="tdheight4">
								<td colspan="6" class="td02 right">
									<input type="submit" class="buttonface2" name="Submit" value="更新购物车">&nbsp;
									<input name="addch" class="buttonface2" type="button" value="清空购物车" onclick="javascript:if (confirm('您确定要清空所选购的商品吗？')) location.href='<?php echo $this->_tpl_vars['mlink']['clearcart'] ?>';">
								</td>
							</tr>
							<tr>
								<td colspan="6" class="td02 center">
									<table class="tablelist" width="100%" style="margin:0 auto;">
										<tr>
											<td class="left"><input name="addch" class="buttonface2" type="button" value="继续购物" onclick="javascript:location.href='<?php echo $this->_tpl_vars['homelink'] ?>';"></td>
											<td class="right"><input name="addch" class="buttonface2" type="button" value="结算" onclick="javascript:location.href='<?php echo $this->_tpl_vars['mlink']['orderpay'] ?>';"></td>										</tr>
									</table>
									
									
								</td>
							</tr>
						</table>
						</form>
						<?php }else{ ?>
						<table class="tablelist" width="100%" style="margin:0 auto;">
							<tr>
								<td colspan="6" class="td02 center">您还没有挑选商品!</td>
							</tr>
						</table>
						<?php } ?>
					</td>
				</tr>
			</table>
	</div>
	<?php } elseif($this->_tpl_vars['out']=='buyedit'){ ?>
	<!--购物车信息填写-->
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
	var zipcode_empty = "<?php echo $this->_tpl_vars['lngpack']['zipcode_empty'] ?>";
	var alias_empty = "<?php echo $this->_tpl_vars['lngpack']['alias_empty'] ?>";
	var email_err = "<?php echo $this->_tpl_vars['lngpack']['email_err'] ?>";
	var tel_empty = "<?php echo $this->_tpl_vars['lngpack']['tel_empty'] ?>";
	</script>
	<div class="bann">
		<div class="location">您现在的位置：<a href="<?php echo $this->_tpl_vars['homelink'] ?>">首页</a> » <?php echo $this->_tpl_vars['lngpack']['ordertitle'] ?> » <b>填写收货信息</b></div>
	</div>
	<div class="framecenter margintop8">
			<form name="ordersaveform" method="post" action="<?php echo $this->_tpl_vars['mlink']['ordersave'] ?>" onsubmit="return ordersave()">
			<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['member']['userid'] ?>">
			<input type="hidden" name="productmoney" value="<?php echo $this->_tpl_vars['productmoney'] ?>">
			<input type="hidden" name="discount_productmoney" value="<?php echo $this->_tpl_vars['discount_productmoney'] ?>">
			<input type="hidden" name="discountmoney" value="<?php echo $this->_tpl_vars['discountmoney'] ?>">
			<table style="width:90%;margin:0px auto;margin-top:30px;margin-bottom:30px;">
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td width="5%"><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/cart_go.gif" /></span></td>
								<td width="20%" class="left"><span class="messtext strong fontsize14">填写收货信息</span> </td>
								<td class="right"><a class="linimage" href="<?php echo $this->_tpl_vars['mlink']['buylist'] ?>">修改订购商品列表</a></td>
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
								<td class="td01 center">订购价格</td>
								<td class="td01 center">数量</td>
								<td class="td01 center">小计</td>
							</tr>
							<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
							<tr>
								<td class="td02 center">
									<input type="hidden" name="ptitle[]" value="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>">
									<a target="_blank" class="infolink05" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['title'] ?></a>
								</td>
								<td class="td02 center"><input type="hidden" name="tsn[]" value="<?php echo $this->_tpl_vars['array'][$i]['tsn'] ?>"><?php echo $this->_tpl_vars['array'][$i]['tsn'] ?></td>
								<td class="td02 center">
									<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['array'][$i]['bprice'] ?>
									<input type="hidden" name="bprice[]" value="<?php echo $this->_tpl_vars['array'][$i]['bprice'] ?>">
									<input type="hidden" name="oprice[]" value="<?php echo $this->_tpl_vars['array'][$i]['oprice'] ?>">
									<input type="hidden" name="did[]" value="<?php echo $this->_tpl_vars['array'][$i]['did'] ?>">
								</td>
								<td class="td02 center"><?php echo $this->_tpl_vars['array'][$i]['amount'] ?><input type="hidden" name="amount[]" id="orderhow" value="<?php echo $this->_tpl_vars['array'][$i]['amount'] ?>"></td>
								<td class="td02 center"><?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['array'][$i]['countprice'] ?><input type="hidden" name="countprice[]" id="countprice" value="<?php echo $this->_tpl_vars['array'][$i]['countprice'] ?>"></td>
							</tr>
							<?php }} ?>
							<tr>
								<td colspan="6" class="td02 right"><span class="font05 colorgreg strong">商品总金额：<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['productmoney_f'] ?> - 折扣<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['discountmoney'] ?> = <?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['discount_productmoney_f'] ?></span></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/page_edit.gif" /></span></td>
								<td><span class="messtext strong fontsize14">填写收货信息</span> </td>
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
							    <td class="td02 right" width="20%">收货人姓名：</td>
							    <td class="td02 left"><input type="text" name="alias" value="<?php echo $this->_tpl_vars['member']['alias'] ?>" maxlength="50" size="20" class="infoInput"></td>
							</tr>
							<tr>
								<td class="td02 right">性别：</td>
								<td class="td02 left">
									<input type="radio" value="1" name="sex" <?php if($this->_tpl_vars['member']['sex']==1){ ?>checked<?php } ?>> 男&nbsp;
									<input type="radio" value="0" name="sex" <?php if($this->_tpl_vars['member']['sex']==0){ ?>checked<?php } ?>> 女
								</td>
							</tr>
							<tr>
							    <td class="td02 right">电子邮件地址：</td>
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
								<td class="td02 left"><input type="text" name="address" value="<?php echo $this->_tpl_vars['member']['address'] ?>" style="width:70%;" maxlength="120" size="60" class="infoInput"></td>
							</tr>
							<tr>
								<td class="td02 right">邮编：</td>
								<td class="td02 left"><input type="text" name="zipcode" value="<?php echo $this->_tpl_vars['member']['zipcode'] ?>" maxlength="10" size="10" class="infoInput"></td>
							</tr>
							<tr>
							    <td class="td02 right">送货时间：</td>
							    <td class="td02 left">
								<select size="1" name="sendtime" class="select">
								    <option value="1" selected>工作日、双休日与假日均可送货</option>
								    <option value="2">只双休日、假日送货(工作日不用送)</option>
								    <option value="3">只工作日送货(双休日、假日不用送) (注：写字楼/商用地址请客户备注说明)</option>
								    <option value="4">尽量安排其他时间送货,请备注说明</option>
								</select>
							    </td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/page_edit.gif" /></span></td>
								<td><span class="messtext strong fontsize14">配送方式</span> </td>
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
							<?php if(count($this->_tpl_vars['shipplug']) > 0 ){ ?>
							<?php if (count($this->_tpl_vars['shipplug'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['shipplug']); $i++){?>
							<tr>
							    <td class="td02 right" width="20%"><?php echo $this->_tpl_vars['shipplug'][$i]['title'] ?></td>
							    <td class="td02 left">
								    <input type="radio" name="osid" value="<?php echo $this->_tpl_vars['shipplug'][$i]['osid'] ?>"<?php if($i+1==1){ ?> checked<?php } ?>>
							            运费：<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['shipplug'][$i]['price'] ?> <BR><?php echo $this->_tpl_vars['shipplug'][$i]['content'] ?>
							    </td>
							</tr>
							<?php }} ?>
							<?php }else{ ?>
							<tr>
							    <td class="center">暂无配送方式</td>
							</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/page_edit.gif" /></span></td>
								<td><span class="messtext strong fontsize14">支付方式</span> </td>
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
							<?php if(count($this->_tpl_vars['payplug']) > 0 ){ ?>
							<?php if (count($this->_tpl_vars['payplug'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['payplug']); $i++){?>
							<tr>
							    <td class="td02 right" width="20%"><?php echo $this->_tpl_vars['payplug'][$i]['payname'] ?></td>
							    <td class="td02 left">
								    <input type="radio" name="opid" value="<?php echo $this->_tpl_vars['payplug'][$i]['opid'] ?>" <?php if($i+1==1){ ?> checked<?php } ?>>
							            手续费比例：<?php echo $this->_tpl_vars['payplug'][$i]['payis'] ?>% <BR><?php echo $this->_tpl_vars['payplug'][$i]['paycontent'] ?>
							    </td>
							</tr>
							<?php }} ?>
							<?php }else{ ?>
							<tr>
							    <td class="center">暂无支付方式</td>
							</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/page_edit.gif" /></span></td>
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
							    <td class="td02 left"><textarea name="content" rows="3" cols="60" style="width:100%;height:100px;"></textarea></td>
							</tr>
							<tr>
							    <td class="td02 right" width="20%">发票抬头：</td>
							    <td class="td02 left"><input type="text" name="invpayee" maxlength="30" size="40" class="infoInput" style="width:40%;"/></td>
							</tr>
							<tr>
							    <td class="td02 right" width="20%">发票内容：</td>
							    <td class="td02 left"><input type="text" name="invcontent" maxlength="30" size="20" class="infoInput" style="width:40%"/></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="center" style="padding-top:20px"><input type="submit" name="submit" id="submit" class="buttonface2" value="确认提交订单"></td>
				</tr>
				<?php }else{ ?>
				<tr>
					<td style="padding-top:10px">
					<table class="tablelist" width="100%" style="margin:0 auto;">
						<tr>
							<td colspan="6" class="td02 center">您还没有挑选商品!</td>
						</tr>
					</table>
					</td>
				</tr>
				<?php } ?>
			</table>
		</form>
	</div>
	<?php } elseif($this->_tpl_vars['out']=='buyok'){ ?>
	<div class="bann">
		<div class="location">您现在的位置：<a href="<?php echo $this->_tpl_vars['homelink'] ?>">首页</a> » <?php echo $this->_tpl_vars['lngpack']['ordertitle'] ?> » <b>提交成功</b></div>
	</div>
	<div class="framecenter margintop8">
			<table style="width:90%;margin:0px auto;margin-top:30px;margin-bottom:30px;">
				<tr>
					<td>
						<table>
							<tr>
								<td><span class="messicon"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/cart_go.gif" /></span></td>
								<td><span class="messtext strong fontsize14">恭喜，您的订单已提交成功，请记住您的订单号：<span class="colorgreg"><?php echo $this->_tpl_vars['ordersn'] ?></span></span></td>
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
								<td class="td02 center">您订单总金额为：商品合计<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['discount'] ?> + 邮寄费用<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['shipprice'] ?> + 支付手续费<?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['payprice'] ?> = <span class="colorgreg"><?php echo $this->_tpl_vars['moneytype'] ?><?php echo $this->_tpl_vars['orderamount'] ?></span></td>
							</tr>
							<tr>
								<td class="td02 center"><?php echo $this->_tpl_vars['orderonline'] ?></td>
							</tr>
							<tr>
								<td class="td02 center">您可以去：<a class="infolist_orning" href="<?php echo $this->_tpl_vars['mlink']['center'] ?>">会员中心</a> 或 <a class="infolist_orning" href="<?php echo $this->_tpl_vars['homelink'] ?>">返回网站首页</a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
	</div>
	<?php } ?>
	<!--版权声明-->
	885BA145EFC8431D34F5CC06D142F143default/cn/public/link.html|885BA145EFC8431D34F5CC06D142F143
</div>
885BA145EFC8431D34F5CC06D142F143default/cn/public/footer.html|885BA145EFC8431D34F5CC06D142F143

</body>

</html>
