<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['type']['typename'] ?> - <?php echo $this->_tpl_vars['lngpack']['sitename'] ?></title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['lngpack']['keyword'] ?>" />
<meta name="description" content="<?php echo $this->_tpl_vars['lngpack']['description'] ?>" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/tempates_div.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['rootpath'] ?>style/pagebotton.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/basicrun.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>index.php?ac=public&at=typepuv&tid=<?php echo $this->_tpl_vars['type']['tid'] ?>"></script>
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
		<div class="location">您现在的位置：6623ef97c6f6ccf2fb032e800d2edda9path|type:type,id:<?php echo $this->_tpl_vars['type']['tid'] ?>||6623ef97c6f6ccf2fb032e800d2edda9</div>
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
		
		<div class="frameleft margintleft10">
			<?php if(count($this->_tpl_vars['array']) > 0){ ?>
			<div class="pagelist center">
				<ul class="newslist">
					<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
					<li><span class="data"><?php echo $this->timeformat($this->_tpl_vars['array'][$i]['addtime'],3) ?></span><a class="infolist" title="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['ctitle'] ?></a></li>
					<?php }} ?>
				</ul>
			</div>
			<div class="pagelist center margintop8">
				<div id="pagelist">
					<?php echo $this->_tpl_vars['pagetext'] ?>
				</div>
			</div>
			<div class="pagelist center margintop8">
				<div id="Pagination" class="pagination">
					<?php echo $this->_tpl_vars['pagebotton'] ?>
				</div>
			</div>
			<?php }else{ ?>
			<div class="pagelist center margintop8">
				<div id="pagelist">暂无内容</div>
			</div>
			<?php } ?>
		</div>
	</div>
	
	885BA145EFC8431D34F5CC06D142F143default/cn/public/link.html|885BA145EFC8431D34F5CC06D142F143
</div>
885BA145EFC8431D34F5CC06D142F143default/cn/public/footer.html|885BA145EFC8431D34F5CC06D142F143	
</body>

</html>