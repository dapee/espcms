<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['read']['title'] ?> - <?php echo $this->_tpl_vars['lngpack']['sitename'] ?></title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['lngpack']['keyword'] ?>" />
<meta name="description" content="<?php echo $this->_tpl_vars['lngpack']['description'] ?>" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/tempates_div.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/pagebotton.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/basicrun.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>index.php?ac=public&at=readpuv&did=<?php echo $this->_tpl_vars['read']['did'] ?>"></script>
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
	<!--bann-->
	<?php if($this->_tpl_vars['type']['typepic']!=''){ ?>
	<div class="bann">
		<div class="bann">
			<img title="tel" src="<?php echo $this->_tpl_vars['rootdir'] ?><?php echo $this->_tpl_vars['type']['typepic'] ?>"/>
		</div>
	</div>
	<?php } ?>
	<div class="bann">
		<div class="location">您现在的位置：6623ef97c6f6ccf2fb032e800d2edda9path|type:type,id:<?php echo $this->_tpl_vars['type']['tid'] ?>||6623ef97c6f6ccf2fb032e800d2edda9 » <b><?php echo $this->_tpl_vars['read']['title'] ?></b></div>
	</div>
	
	<div class="framecenter margintop10">
		<div class="frameright ">
			<div class="fup3"><span class="spantitle"><?php echo $this->_tpl_vars['type']['typename'] ?></span></div>
			<div class="fcontent3">
				214adb21252b0af7b03s214s9typelist|tid:<?php echo $this->_tpl_vars['type']['tid'] ?>,utid:<?php echo $this->_tpl_vars['type']['topid'] ?>|60af7b03s21fs
				<ul class="three">
					<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
						<?php if($this->_tpl_vars['array'][$i]['level']==1){ ?>
						<li class="b"><a class="typelink" title="<?php echo $this->_tpl_vars['array'][$i]['typename'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['typename'] ?></a></li>
						<?php }else{ ?>
						<li class="a"><a title="<?php echo $this->_tpl_vars['array'][$i]['typename'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['typename'] ?></a></li>
						<?php } ?>
					<?php }} ?>
				</ul>
				214adb21252b0af7b03s214s9
			</div>
			<div class="fdown3"></div>
			
			885BA145EFC8431D34F5CC06D142F143default/cn/public/left.html|885BA145EFC8431D34F5CC06D142F143
		</div>
		
		<div class="pagecontent margintleft10">
			<div class="pagecontentstr">
				<div class="righttext center lineheight200">
					<h3><?php echo $this->_tpl_vars['read']['title'] ?></h3>
				</div>
				
				<div class="righttext center lineheight200 margintop8"> 
					<?php echo $this->timeformat($this->_tpl_vars['read']['addtime'],3) ?>  <?php echo $this->_tpl_vars['read']['author'] ?> <?php echo $this->_tpl_vars['read']['source'] ?> 点击数： <script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>index.php?ac=scriptout&at=click&did=<?php echo $this->_tpl_vars['read']['did'] ?>"></script>
					<?php if(count($this->_tpl_vars['tag'])>0){ ?>
						<br/>
						<span class="strong padding-right3"> 关键字：</span>
						<?php if (count($this->_tpl_vars['tag'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['tag']); $i++){?>
							<a target="_blank" title="<?php echo $this->_tpl_vars['tag'][$i]['title'] ?>" href="<?php echo $this->_tpl_vars['tag'][$i]['link'] ?>"><?php echo $this->_tpl_vars['tag'][$i]['title'] ?></a>
						<?php }} ?>
					<?php } ?>
					<div class="bookline"></div> 
				</div>
				
				<div class="righttext_padding lineheight200 fonttextindent2em margintop8"><?php echo $this->_tpl_vars['read']['content'] ?></div>
				
				<?php if(count($this->_tpl_vars['page'])>0 ){ ?>
				<div class="righttext center" style="float: left">
					<table style="margin: 0 auto;">
						<tr>
							<td>
								<div id="Pagination" class="pagination">
									<?php if($this->_tpl_vars['read']['plink']!=''){ ?>
									<span><a href="<?php echo $this->_tpl_vars['read']['plink'] ?>">上一页</a></span>
									<?php } ?>
									<?php if (count($this->_tpl_vars['page'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['page']); $i++){?>
									<?php if($this->_tpl_vars['page'][$i]['n']==1){ ?>
									<span class="current disabled"><?php echo $this->_tpl_vars['page'][$i]['num'] ?></span>
									<?php }else{ ?>
									<span><a href="<?php echo $this->_tpl_vars['page'][$i]['link'] ?>"><?php echo $this->_tpl_vars['page'][$i]['num'] ?></a></span>
									<?php } ?>
									<?php }} ?>
									<?php if($this->_tpl_vars['read']['nlink']!=''){ ?>
									<span><a href="<?php echo $this->_tpl_vars['read']['nlink'] ?>">下一页</a></span>
									<?php } ?>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<?php } ?>
				
				<div class="righttext" style="float: left;">
					<div class="otherZt"></div>
					<table style="width:100%">
						<tr>
							<td align="left">
								214adb21252b0af7b03s214s9plist|did:<?php echo $this->_tpl_vars['read']['did'] ?>|60af7b03s21fs
									<?php if($this->_tpl_vars['read']['ctitle']!=''){ ?>上一篇：<a title="<?php echo $this->_tpl_vars['read']['title'] ?>" href="<?php echo $this->_tpl_vars['read']['link'] ?>"><?php echo $this->_tpl_vars['read']['ctitle'] ?></a><?php } ?>
								214adb21252b0af7b03s214s9
							</td>
							<td align="right">
								214adb21252b0af7b03s214s9plist|did:<?php echo $this->_tpl_vars['read']['did'] ?>,class:1|60af7b03s21fs
									<?php if($this->_tpl_vars['read']['ctitle']!=''){ ?>下一篇：<a title="<?php echo $this->_tpl_vars['read']['title'] ?>" href="<?php echo $this->_tpl_vars['read']['link'] ?>"><?php echo $this->_tpl_vars['read']['ctitle'] ?></a><?php } ?>
								214adb21252b0af7b03s214s9
							</td>
						</tr>
					</table>
					<div class="otherZt"></div> 
				</div>
				<?php if($this->_tpl_vars['read']['linkdid']!=''){ ?>
				<div class="righttext"> 
					<div class="readlist"> 
						<div class="tg">相关内容</div>
						<div class="l"> 
							<table style="width:100%"> 
								<tr> 
									<td> 
										<ul class="three_fg">
										214adb21252b0af7b03s214s9list|mid:<?php echo $this->_tpl_vars['read']['mid'] ?>,tid:<?php echo $this->_tpl_vars['read']['tid'] ?>,linkdid:<?php echo $this->_tpl_vars['read']['linkdid'] ?>,max:6|60af7b03s21fs
											<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
											<li class="b"><a class="infolist" title="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['title'] ?></a></li> 
											<li></li>
											<?php }} ?>
										214adb21252b0af7b03s214s9
										</ul> 
									</td> 
								</tr> 
							</table> 
						</div> 
					</div> 
				</div>
				<?php } ?>
				6623ef97c6f6ccf2fb032e800d2edda9messlist|did:<?php echo $this->_tpl_vars['read']['did'] ?>,ismess:<?php echo $this->_tpl_vars['read']['ismess'] ?>||6623ef97c6f6ccf2fb032e800d2edda9
			</div>
		</div>
	</div>
	885BA145EFC8431D34F5CC06D142F143default/cn/public/link.html|885BA145EFC8431D34F5CC06D142F143
</div>
885BA145EFC8431D34F5CC06D142F143default/cn/public/footer.html|885BA145EFC8431D34F5CC06D142F143	
</body>

</html>