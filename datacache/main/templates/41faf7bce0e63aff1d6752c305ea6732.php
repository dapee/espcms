<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
<ul>
	<li class="center"><a class="infolist" title="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><img title="tel" src="<?php echo $this->zoom($this->_tpl_vars['array'][$i]['pic'],180,120) ?>"/></a></li>
	<li class="center"><a class="infolist" title="<?php echo $this->_tpl_vars['array'][$i]['title'] ?>" href="<?php echo $this->_tpl_vars['array'][$i]['link'] ?>"><?php echo $this->cutstr($this->_tpl_vars['array'][$i]['title'],17) ?></a></li>
</ul>
<?php }} ?>
