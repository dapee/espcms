<div class="logo">
	<table style="width: 100%">
		<tr>
			<td style="width:238px;"><img title="logo" src="<?php echo $this->_tpl_vars['rootpath'] ?>images/logo_en.jpg"/></td>
			<td valign="top" class="padding-right3">
				<table style="width: 100%">
					<tr>
						<td class="right" style="height:35px;">
							214adb21252b0af7b03s214s9lng||60af7b03s21fs
								<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
								<a href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['lngtitle'] ?></a>
								<?php }} ?>
							214adb21252b0af7b03s214s9
						</td>
					<tr>
						<td class="right" ><img title="tel" src="<?php echo $this->_tpl_vars['rootpath'] ?>images/telonline_en.jpg"/></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<div class="menubotton">
	<table class="menu">
		<tr>
			<td class="menuleft"></td>
			<td class="menucenter">
				<ul class="topnav" id="clickmenubotton">
					214adb21252b0af7b03s214s9menu|path:<?php echo $this->_tpl_vars['path'] ?>,current:<?php echo $this->_tpl_vars['current'] ?>|60af7b03s21fs
						<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
						<li <?php if($this->_tpl_vars['array'][$i]['path']==$this->_tpl_vars['path'] && $this->_tpl_vars['array'][$i]['current']==$this->_tpl_vars['current']){ ?>class="hover"<?php } ?>><span><a class="toplink<?php if($this->_tpl_vars['array'][$i]['path']==$this->_tpl_vars['path'] && $this->_tpl_vars['array'][$i]['current']==$this->_tpl_vars['current']){ ?>2<?php } ?>" title="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->_tpl_vars['array'][$i]['title'] ?></a></span>
							<?php if(count( $this->_tpl_vars['array'][$i]['larray'] ) > 0 ){ ?>
							<ul class="subnav" style="display: none; "> 
								<?php if (count($this->_tpl_vars['array'][$i]['larray'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['array'][$i]['larray']); $ii++){?>
								<li><a class="novlink" href="<?php echo $this->_tpl_vars['array'][$i]['larray'][$ii]['link'] ?>" title="<?php echo $this->_tpl_vars['array'][$i]['larray'][$ii]['title'] ?>"><?php echo $this->_tpl_vars['array'][$i]['larray'][$ii]['title'] ?></a></li>
								<?php }} ?>
							</ul>
							<?php } ?>
						</li>
						<?php }} ?>
					214adb21252b0af7b03s214s9
				</ul>
			</td>
			<td class="menuright"></td>
		</tr>
	</table>
</div>