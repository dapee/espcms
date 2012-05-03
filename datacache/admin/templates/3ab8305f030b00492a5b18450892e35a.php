<div id="headbg">
	<div id="head">
		<div class="logo"><div id="logo"></div></div>
		<div id="botton">
			<ul>
				<li id="topleftbg"></li>
				<li id="bottonbg"><a class="annex" hidefocus="true" href="index.php?archive=management&action=tab&loadfun=mangercenter&out=tabcenter">管理主页</a></li>
				<li id="bottonbg"><a class="annex" hidefocus="true" href="#body" onclick="windowsdig('<?php echo $this->_tpl_vars['ST']['adminuser_top_password_edit'] ?>','iframe:index.php?archive=management&action=password&iframename=','650px','340px','iframe');"><?php echo $this->_tpl_vars['ST']['adminuser_top_password_edit'] ?></a></li>
				<?php if($this->powercheck('system','loglist')==true ){ ?>
				<li id="bottonbg"><a class="annex" hidefocus="true" href="index.php?archive=management&action=tab&out=tabcenter&loadfun=loglist&menuname_title=%E6%88%91%E7%9A%84%E7%B3%BB%E7%BB%9F%E6%97%A5%E5%BF%97&menuid=8"><?php echo $this->_tpl_vars['ST']['adminuser_top_myloglist'] ?></a></li>
				<?php } ?>
				<?php if($this->powercheck('system','clearcache')==true ){ ?>
				<li id="bottonbg"><a class="annex" hidefocus="true" href="#body" onclick="windowsdig('<?php echo $this->_tpl_vars['ST']['adminuser_top_clearcache'] ?>','iframe:index.php?archive=management&action=clearcache&iframename=','650px','250px','iframe');"><?php echo $this->_tpl_vars['ST']['adminuser_top_clearcache'] ?></a></li>
				<?php } ?>
				<?php if($this->powercheck('system','filecheck')==true ){ ?>
				<li id="bottonbg"><a class="annex" hidefocus="true" href="#body" onclick="windowsdig('<?php echo $this->_tpl_vars['ST']['adminuser_top_filecheck'] ?>','iframe:index.php?archive=management&action=filecheck&iframename=','650px','450px','iframe');"><?php echo $this->_tpl_vars['ST']['adminuser_top_filecheck'] ?></a></li>
				<?php } ?>
				<?php if($this->powercheck('system','clearlog')==true ){ ?>
				<li id="bottonbg"><a class="annex" hidefocus="true" href="#body" onclick="windowsdig('<?php echo $this->_tpl_vars['ST']['adminuser_top_clearlog'] ?>','iframe:index.php?archive=management&action=clearlog&iframename=','650px','340px','iframe');"><?php echo $this->_tpl_vars['ST']['adminuser_top_clearlog'] ?></a></li>
				<?php } ?>
				<li id="bottonbg"><a class="annex" target="_blank" hidefocus="true" href="<?php echo $this->_tpl_vars['adminurl'] ?>">网站预览</a></li>
				<li id="bottonbg"><a class="annex" hidefocus="true" href="index.php?archive=adminuser&amp;action=loingout">退出</a></li>
				<li id="rightbg"></li>
			</ul>
		</div>
	</div>
	<div class="menubotton">
		826dfebd693cd4d9f372d59e23d5a077menu|<?php echo $this->_tpl_vars['menuid'] ?>||826dfebd693cd4d9f372d59e23d5a077
	</div>
	<div class="menuline"></div>
	<div class="menuline2"></div>
</div>
<?php echo $this->_tpl_vars['lng'] ?>