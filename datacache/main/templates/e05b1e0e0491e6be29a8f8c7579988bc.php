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
	885BA145EFC8431D34F5CC06D142F143default/en/public/head.html|885BA145EFC8431D34F5CC06D142F143
	<div class="bann"><img src="<?php echo $this->_tpl_vars['rootpath'] ?>images/bann.jpg"/></div>
	<?php if($this->_tpl_vars['out']=='list'){ ?>
	<!--购物车列表-->
	<script type="text/javascript">
	var order_amout_err = "<?php echo $this->_tpl_vars['lngpack']['order_amout_err'] ?>";
	var address_title = "<?php echo $this->_tpl_vars['lngpack']['address_title'] ?>";
	var zipcode_empty = "<?php echo $this->_tpl_vars['lngpack']['zipcode_empty'] ?>";
	var alias_empty = "<?php echo $this->_tpl_vars['lngpack']['alias_empty'] ?>";
	var email_err = "<?php echo $this->_tpl_vars['lngpack']['email_err'] ?>";
	var tel_empty = "<?php echo $this->_tpl_vars['lngpack']['tel_empty'] ?>";
	</script>
	<div class="bann">
		<div class="location"><a href="<?php echo $this->_tpl_vars['homelink'] ?>">Home</a> » <?php echo $this->_tpl_vars['lngpack']['enquirytitle'] ?> » <b>Inquiry Product List</b></div>
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
							<td><span class="messtext strong fontsize14">Items</span></td>
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
							<td class="td01 center">Items</td>
							<td class="td01 center">Product Code</td>
							<td class="td01 center">Qty</td>
							<td class="td01 center">Remove</td>
						</tr>
						<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
						<tr>
							<td class="td02 left"><input type="hidden" name="ptitle[]" value="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>"><a target="_blank" class="infolink05" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['title'] ?></a></td>
							<td class="td02 center"><input type="hidden" name="tsn[]" value="<?php echo $this->_tpl_vars['array'][$i]['tsn'] ?>"><?php echo $this->_tpl_vars['array'][$i]['tsn'] ?></td>
							<td class="td02 center">
								<input type="text" name="amount[]" id="amount<?php echo $this->_tpl_vars['array'][$i]['did'] ?>" value="<?php echo $this->_tpl_vars['array'][$i]['amount'] ?>" onBlur="javascript:orderamount(<?php echo $this->_tpl_vars['array'][$i]['did'] ?>);" size="2" maxlength="5" class="infoInput">
								<input type="hidden" name="did[]" value="<?php echo $this->_tpl_vars['array'][$i]['did'] ?>">
							</td>
							<td class="td02 center"><a class="infolink04" href="javascript:if (confirm('Are you sure you want to remove it?')) location.href='<?php echo $this->_tpl_vars['array'][$i]['dellink'] ?>';">Remove</a></td>
						</tr>
						<?php }} ?>
						<tr class="tdheight4">
							<td colspan="6" class="td02 right">
								<input name="addch" class="buttonface2" type="button" value="Keep shopping" onclick="javascript:location.href='<?php echo $this->_tpl_vars['homelink'] ?>';">
								<input name="addch" class="buttonface2" type="button" value="Delete" onclick="javascript:if (confirm('Are you sure you want to empty it?')) location.href='<?php echo $this->_tpl_vars['mlink']['cleargoods'] ?>';">
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
							<td><span class="messtext strong fontsize14">Contact Information</span> </td>
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
						    <td class="td02 right" width="20%">Name:</td>
						    <td class="td02 left"><input type="text" name="alias" value="<?php echo $this->_tpl_vars['member']['alias'] ?>" maxlength="50" size="20" class="infoInput"></td>
						</tr>
						<tr>
							<td class="td02 right">Sex:</td>
							<td class="td02 left">
								<input type="radio" value="1" name="sex" <?php if($this->_tpl_vars['member']['sex']==1){ ?>checked<?php } ?>> Male&nbsp;
								<input type="radio" value="0" name="sex" <?php if($this->_tpl_vars['member']['sex']==0){ ?>checked<?php } ?>> Female
							</td>
						</tr>
						<tr>
						    <td class="td02 right">E-mail:</td>
						    <td class="td02 left"><input type="text" name="email" value="<?php echo $this->_tpl_vars['member']['email'] ?>" maxlength="100" size="50" class="infoInput" style="width:40%;" ></td>
						</tr>
						<tr>
						    <td class="td02 right">Tel:</td>
						    <td class="td02 left"><input type="text" name="tel" value="<?php echo $this->_tpl_vars['member']['tel'] ?>" maxlength="50" size="50" class="infoInput" style="width:40%;" ></td>
						</tr>
						<tr>
						    <td class="td02 right">Fax:</td>
						    <td class="td02 left"><input type="text" name="fax" value="<?php echo $this->_tpl_vars['member']['fax'] ?>" maxlength="50" size="50" class="infoInput" style="width:40%;" ></td>
						</tr>
						<tr>
						    <td class="td02 right">Mobile:</td>
						    <td class="td02 left"><input type="text" name="mobile" value="<?php echo $this->_tpl_vars['member']['mobile'] ?>" maxlength="50" size="50" class="infoInput" style="width:40%;" ></td>
						</tr>
						<tr>
							<td class="td02 right">Address:</td>
							<td class="td02 left"><input type="text" name="address" value="<?php echo $this->_tpl_vars['member']['address'] ?>" style="width:70%;" maxlength="120" size="60" class="infoInput"></td>
						</tr>
						<tr>
							<td class="td02 right">Zipcode</td>
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
							<td><span class="messtext strong fontsize14">Other information</span> </td>
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
						    <td class="td02 right" width="20%">Remarks:</td>
						    <td class="td02 left"><textarea name="content" rows="3" style="width:100%;height: 100px;"></textarea></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="center" style="padding-top:20px"><input type="submit" name="submit" id="submit" class="buttonface2" value="Submit"></td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td style="padding-top:10px">
				<table class="tablelist" width="100%" style="margin:0 auto;">
					<tr>
						<td colspan="6" class="td02 center">0 items added to Cart!</td>
					</tr>
				</table>
				</td>
			</tr>
			<?php } ?>
		</table>
		</form>
	</div>
	<?php } ?>
	885BA145EFC8431D34F5CC06D142F143default/en/public/link.html|885BA145EFC8431D34F5CC06D142F143
</div>
885BA145EFC8431D34F5CC06D142F143default/en/public/footer.html|885BA145EFC8431D34F5CC06D142F143

</body>

</html>
