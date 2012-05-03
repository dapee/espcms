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
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/skin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/basicrun.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/picshow.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/jquery.lightbox-0.5.min.js"></script>
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
	$('#mycarousel').jcarousel({start: 1});
	$(function() {$('#mycarousel a').lightBox({
		imageLoading: '<?php echo $this->_tpl_vars['rootpath'] ?>images/lightbox-ico-loading.gif',
		imageBtnClose: '<?php echo $this->_tpl_vars['rootpath'] ?>images/lightbox-btn-close.gif',
		imageBtnPrev: '<?php echo $this->_tpl_vars['rootpath'] ?>images/lightbox-btn-prev.gif',
		imageBtnNext: '<?php echo $this->_tpl_vars['rootpath'] ?>images/lightbox-btn-next.gif'
	});});
});
</script>
</head>

<body>
<div class="head">
	885BA145EFC8431D34F5CC06D142F143default/en/public/head.html|885BA145EFC8431D34F5CC06D142F143
	<!--bann-->
	<?php if($this->_tpl_vars['type']['typepic']!=''){ ?>
	<div class="bann">
		<div class="bann">
			<img title="tel" src="<?php echo $this->_tpl_vars['rootdir'] ?><?php echo $this->_tpl_vars['type']['typepic'] ?>"/>
		</div>
	</div>
	<?php } ?>
	<div class="bann">
		<div class="location">6623ef97c6f6ccf2fb032e800d2edda9path|type:type,id:<?php echo $this->_tpl_vars['type']['tid'] ?>||6623ef97c6f6ccf2fb032e800d2edda9 » <b><?php echo $this->_tpl_vars['read']['title'] ?></b></div>
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
			
			885BA145EFC8431D34F5CC06D142F143default/en/public/left.html|885BA145EFC8431D34F5CC06D142F143
		</div>
		
		<div class="pagecontent margintleft10">
			<div class="pagecontentstr">
				<div class="righttext center">
					<div class="readpic"><img src="<?php echo $this->zoom($this->_tpl_vars['read']['pic'],225,225) ?>" alt="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>"></div>
					<div class="readtitle">
						<dl>
							<dt><h4><?php echo $this->_tpl_vars['read']['title'] ?></h4></dt>
							<dd>Product ID：<strong class="priceclass"><?php echo $this->_tpl_vars['read']['tsn'] ?></strong></dd>
							<dd class="fastline">Original Price：<strong class="priceclass">$<?php echo $this->_tpl_vars['read']['oprice'] ?></strong></dd>
							<dd>Price：<strong class="priceclass">$<?php echo $this->_tpl_vars['read']['bprice'] ?></strong></dd>
							<dd>
								<div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到开心网" class="bshare-kaixin001"></a><a title="分享到豆瓣" class="bshare-douban"></a><a title="更多平台" class="bshare-more bshare-more-icon"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC2.js"></script>
							</dd>
							<dd class="orderbotton"><a target="_blank" class="btninfo1" href="<?php echo $this->_tpl_vars['read']['buylink'] ?>">ADD TO CART</a>&nbsp;&nbsp; <a target="_blank" class="btninfo2" href="<?php echo $this->_tpl_vars['read']['enqlink'] ?>">INQUIRY</a></dd>
						</dl>
					</div>
				</div>
				<?php if(count($this->_tpl_vars['photo'])>0){ ?>
				<div class="righttext">
					<div class="readlist">
						<div class="tg">Picture</div>
						<div class="l">
							<ul id="mycarousel"  class="jcarousel-skin-tango">
								<?php if (count($this->_tpl_vars['photo'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['photo']); $i++){?>
								<li><a href="<?php echo $this->_tpl_vars['rootdir'] ?><?php echo $this->_tpl_vars['photo'][$i]['picfile'] ?>" title="<?php echo $this->_tpl_vars['photo'][$i]['picname'] ?>"><img src="<?php echo $this->zoom($this->_tpl_vars['photo'][$i]['picfile'],120,120) ?>"/></a></li>
								<?php }} ?>
							</ul>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<div class="righttext">
					<div class="readlist">
						<div class="tg">Description</div>
						<div class="l lineheight200" style="padding-left: 10px;padding-right:10px;"><?php echo $this->_tpl_vars['read']['content'] ?></div>
					</div>
				</div>
				
				<?php if(count($this->_tpl_vars['page'])>0 ){ ?>
				<div class="righttext center">
					<table style="margin: 0 auto;">
						<tr>
							<td>
								<div id="Pagination" class="pagination">
									<?php if (count($this->_tpl_vars['page'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['page']); $i++){?>
									<?php if($this->_tpl_vars['page'][$i]['n']==1){ ?>
									<span class="current disabled"><?php echo $this->_tpl_vars['page'][$i]['num'] ?></span>
									<?php }else{ ?>
									<span><a href="<?php echo $this->_tpl_vars['page'][$i]['link'] ?>"><?php echo $this->_tpl_vars['page'][$i]['num'] ?></a></span>
									<?php } ?>
									<?php }} ?>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<?php } ?>
				
				<?php if($this->_tpl_vars['read']['linkdid']!=''){ ?>
				<div class="righttext">
					<div class="readlist">
						<div class="tg">Related Products</div>
						<div class="l">
							<ul class="piclist">
								214adb21252b0af7b03s214s9list|mid:<?php echo $this->_tpl_vars['read']['mid'] ?>,tid:<?php echo $this->_tpl_vars['read']['tid'] ?>,linkdid:<?php echo $this->_tpl_vars['read']['linkdid'] ?>,max:5|60af7b03s21fs
								<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
								<li title="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>">
									<a href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><img src="<?php echo $this->zoom($this->_tpl_vars['array'][$i]['pic'],120,120) ?>" alt="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>"></a>
									<span class="t"><a class="infolist" title="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->cutstr($this->_tpl_vars['array'][$i]['title'],10,'') ?></a></span><p>Price<em>$<?php echo $this->_tpl_vars['array'][$i]['bprice'] ?></em></p>
								</li>
								<?php }} ?>
								214adb21252b0af7b03s214s9
							</ul>
						</div>
					</div>
				</div>
				<?php } ?>
				
				6623ef97c6f6ccf2fb032e800d2edda9messlist|did:<?php echo $this->_tpl_vars['read']['did'] ?>,ismess:<?php echo $this->_tpl_vars['read']['ismess'] ?>||6623ef97c6f6ccf2fb032e800d2edda9
			</div>
		</div>
	</div>
	885BA145EFC8431D34F5CC06D142F143default/en/public/link.html|885BA145EFC8431D34F5CC06D142F143
</div>
885BA145EFC8431D34F5CC06D142F143default/en/public/footer.html|885BA145EFC8431D34F5CC06D142F143	
</body>

</html>