<!--js-->
<script type="text/javascript" src="<?php echo $this->_tpl_vars['rootdir'] ?>js/float.js"></script>
<?php if($this->_tpl_vars['call']['call_style']==1){ ?>
<link href="<?php echo $this->_tpl_vars['rootdir'] ?>public/plug/im/sky.css" rel="stylesheet" type="text/css" />
<?php } ?>
<?php if($this->_tpl_vars['call']['call_style']==2){ ?>
<link href="<?php echo $this->_tpl_vars['rootdir'] ?>public/plug/im/green.css" rel="stylesheet" type="text/css" />
<?php } ?>
<?php if($this->_tpl_vars['call']['call_style']==3){ ?>
<link href="<?php echo $this->_tpl_vars['rootdir'] ?>public/plug/im/purple.css" rel="stylesheet" type="text/css" />
<?php } ?>
<!--end_js-->
<?php if($this->_tpl_vars['call']['call_type']==1){ ?>
<div id="right-float-box" class="im_floatonline">
	<div class="float-box-content">
		<div class="toptitle">
			<div class="btitle"><?php echo $this->_tpl_vars['lngpack']['call_title'] ?></div>
		</div>
		<div class="addlist">
			<ul>
				<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
					<?php if($this->_tpl_vars['array'][$i]['type']==1){ ?>
					<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <?php echo $this->_tpl_vars['array'][$i]['code'] ?></li>
					<?php } elseif($this->_tpl_vars['array'][$i]['type']==2){ ?>
						<?php if($this->_tpl_vars['array'][$i]['style']==1){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&site=cntaobao&s=1&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&site=cntaobao&s=1&charset=utf-8"/></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==2){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&site=cntaobao&s=2&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&site=cntaobao&s=2&charset=utf-8"/></a></li>
						<?php } ?>
					<?php } elseif($this->_tpl_vars['array'][$i]['type']==3){ ?>
						<?php if($this->_tpl_vars['array'][$i]['style']==1){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a href="skype:<?php echo $this->_tpl_vars['array'][$i]['code'] ?>?call"><img src="http://mystatus.skype.com/smallclassic/<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"/></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==2){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a href="skype:<?php echo $this->_tpl_vars['array'][$i]['code'] ?>?call"><img src="http://mystatus.skype.com/bigclassic/<?php echo $this->_tpl_vars['array'][$i]['code'] ?>" width="110"/></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==3){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a href="skype:<?php echo $this->_tpl_vars['array'][$i]['code'] ?>?call"><img src="http://mystatus.skype.com/mediumicon/<?php echo $this->_tpl_vars['array'][$i]['code'] ?>" /><?php echo $this->_tpl_vars['array'][$i]['code'] ?></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==4){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a href="skype:<?php echo $this->_tpl_vars['array'][$i]['code'] ?>?call"><img src="http://mystatus.skype.com/balloon/<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"  width="110"/></a></li>
						<?php } ?>
					<?php } elseif($this->_tpl_vars['array'][$i]['type']==4){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>@apps.messenger.live.com&mkt=zh-cn"><img style="border-style: none;" src="<?php echo $this->_tpl_vars['rootdir'] ?>public/plug/im/msn_icon/<?php echo $this->_tpl_vars['array'][$i]['style'] ?>.gif"/></a></li>
					<?php } elseif($this->_tpl_vars['array'][$i]['type']==5){ ?>
						<?php if($this->_tpl_vars['array'][$i]['style']==102){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos1.sh1.china.alibaba.com/msg.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"><img border="0" src="http://amos1.sh1.china.alibaba.com/online.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&s=102"></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==101){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos1.sh1.china.alibaba.com/msg.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"><img border="0" src="http://amos1.sh1.china.alibaba.com/online.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&s=101"></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==1){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos1.sh1.china.alibaba.com/msg.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"><img border="0" src="http://amos1.sh1.china.alibaba.com/online.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&s=1"></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==2){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos1.sh1.china.alibaba.com/msg.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"><img border="0" src="http://amos1.sh1.china.alibaba.com/online.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&s=2"></a></li>
						<?php } ?>
					<?php } ?>
				<?php }} ?>
			</ul>
		</div>
		<div class="serverbotton">
			<ul>
				<li class="bottonstyle_red"><a href="<?php echo $this->_tpl_vars['memberlink'] ?>"><?php echo $this->_tpl_vars['lngpack']['call_form_botton'] ?></a></li>
				<li class="bottonstyle_grup"><a onclick="closeim();" href="#"><?php echo $this->_tpl_vars['lngpack']['close_im'] ?></a></li>
			</ul>
		</div>
		<div class="bottomline"></div>
	</div>
</div>
<?php } ?>
<?php if($this->_tpl_vars['call']['call_type']==2){ ?>
<div id="float-bottom" class="im_floatonline">
	<div class="right">
		<div class="ricon"></div>
		<div class="rtitle"><?php echo $this->_tpl_vars['lngpack']['call_botton'] ?></div>
	</div>
	<div class="float-box-content">
		<div class="toptitle">
			<div class="btitle"><?php echo $this->_tpl_vars['lngpack']['call_title'] ?></div>
		</div>
		<div class="addlist">
			<ul>
				<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
					<?php if($this->_tpl_vars['array'][$i]['type']==1){ ?>
					<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <?php echo $this->_tpl_vars['array'][$i]['code'] ?></li>
					<?php } elseif($this->_tpl_vars['array'][$i]['type']==2){ ?>
						<?php if($this->_tpl_vars['array'][$i]['style']==1){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&site=cntaobao&s=1&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&site=cntaobao&s=1&charset=utf-8"/></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==2){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&site=cntaobao&s=2&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&site=cntaobao&s=2&charset=utf-8"/></a></li>
						<?php } ?>
					<?php } elseif($this->_tpl_vars['array'][$i]['type']==3){ ?>
						<?php if($this->_tpl_vars['array'][$i]['style']==1){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a href="skype:<?php echo $this->_tpl_vars['array'][$i]['code'] ?>?call"><img src="http://mystatus.skype.com/smallclassic/<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"/></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==2){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a href="skype:<?php echo $this->_tpl_vars['array'][$i]['code'] ?>?call"><img src="http://mystatus.skype.com/bigclassic/<?php echo $this->_tpl_vars['array'][$i]['code'] ?>" width="110"/></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==3){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a href="skype:<?php echo $this->_tpl_vars['array'][$i]['code'] ?>?call"><img src="http://mystatus.skype.com/mediumicon/<?php echo $this->_tpl_vars['array'][$i]['code'] ?>" /><?php echo $this->_tpl_vars['array'][$i]['code'] ?></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==4){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a href="skype:<?php echo $this->_tpl_vars['array'][$i]['code'] ?>?call"><img src="http://mystatus.skype.com/balloon/<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"  width="110"/></a></li>
						<?php } ?>
					<?php } elseif($this->_tpl_vars['array'][$i]['type']==4){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>@apps.messenger.live.com&mkt=zh-cn"><img style="border-style: none;" src="<?php echo $this->_tpl_vars['url'] ?>public/plug/im/msn_icon/<?php echo $this->_tpl_vars['array'][$i]['style'] ?>.gif"/></a></li>
					<?php } elseif($this->_tpl_vars['array'][$i]['type']==5){ ?>
						<?php if($this->_tpl_vars['array'][$i]['style']==102){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos1.sh1.china.alibaba.com/msg.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"><img border="0" src="http://amos1.sh1.china.alibaba.com/online.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&s=102"></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==101){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos1.sh1.china.alibaba.com/msg.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"><img border="0" src="http://amos1.sh1.china.alibaba.com/online.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&s=101"></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==1){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos1.sh1.china.alibaba.com/msg.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"><img border="0" src="http://amos1.sh1.china.alibaba.com/online.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&s=1"></a></li>
						<?php } elseif($this->_tpl_vars['array'][$i]['style']==2){ ?>
						<li><?php echo $this->_tpl_vars['array'][$i]['name'] ?> <br/> <a target="_blank" href="http://amos1.sh1.china.alibaba.com/msg.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>"><img border="0" src="http://amos1.sh1.china.alibaba.com/online.atc?v=1&uid=<?php echo $this->_tpl_vars['array'][$i]['code'] ?>&s=2"></a></li>
						<?php } ?>
					<?php } ?>
				<?php }} ?>
			</ul>
		</div>
		<div class="serverbotton">
			<ul>
				<li class="bottonstyle_red"><a href="<?php echo $this->_tpl_vars['memberlink'] ?>"><?php echo $this->_tpl_vars['lngpack']['call_form_botton'] ?></a></li>
				<li class="bottonstyle_grup"><a onclick="closeim();" href="#"><?php echo $this->_tpl_vars['lngpack']['close_im'] ?></a></li>
			</ul>
		</div>
		<div class="bottomline"></div>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
	<?php if($this->_tpl_vars['call']['call_type']==1){ ?>
	<?php if($this->_tpl_vars['call']['call_position']==1){ ?>
	$("#right-float-box").float({position:"lm",delay:500});
	<?php }else{ ?>
	$("#right-float-box").float({position:"rm",delay:500});
	<?php } ?>
	<?php } ?>
	<?php if($this->_tpl_vars['call']['call_type']==2){ ?>
	$("#float-bottom").float({position:"lm",offset : {left : -136},style:{width:170}});
	$("#float-bottom").hover(function(){
		$(this).float("clearOffset");

	},function(){
		$(this).float("addOffset");
	})
	<?php } ?>
</script>