<ul class="topnav" id="clickmenubotton">
	<?php if (count($this->_tpl_vars['menulinkarray'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['menulinkarray']); $i++){?>
	<li><span<?php if($this->_tpl_vars['menulinkarray'][$i]['mlid']==$this->_tpl_vars['menuid']){ ?> class="bgmenuhove"<?php } ?>><?php echo $this->_tpl_vars['menulinkarray'][$i]['menuname'] ?></span>
		<ul class="subnav">
			<?php if (count($this->_tpl_vars['menulinkarray'][$i]['menulink'])>0){$divid_ii=1;for($ii=0;$ii<count($this->_tpl_vars['menulinkarray'][$i]['menulink']); $ii++){?>
			<?php if($this->_tpl_vars['menulinkarray'][$i]['menulink'][$ii]['loadfun']==$this->_tpl_vars['loadfun'] && $this->_tpl_vars['menulinkarray'][$i]['mlid']==$this->_tpl_vars['menuid']){ ?>
			<li><a class="hover" title="<?php echo $this->_tpl_vars['menulinkarray'][$i]['menulink'][$ii]['menuname'] ?>"><?php echo $this->_tpl_vars['menulinkarray'][$i]['menulink'][$ii]['menuname'] ?></a></li>
			<?php }else{ ?>
			<li><a title="<?php echo $this->_tpl_vars['menulinkarray'][$i]['menulink'][$ii]['menuname'] ?>" href="<?php echo $this->_tpl_vars['menulinkarray'][$i]['menulink'][$ii]['linkurl'] ?>&menuid=<?php echo $this->_tpl_vars['menulinkarray'][$i]['menulink'][$ii]['topmlid'] ?>"><?php echo $this->_tpl_vars['menulinkarray'][$i]['menulink'][$ii]['menuname'] ?></a></li>
			<?php } ?>
			<?php }} ?>
		</ul>
	</li>
	<?php }} ?>
	<li><span class="yallow">语言</span>
		<ul class="subnav">
			<?php if (count($this->_tpl_vars['lanarray'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['lanarray']); $i++){?>
			<?php if($this->_tpl_vars['lanarray'][$i]['lng']==$this->_tpl_vars['lng']){ ?>
			<li><a class="hover" title="<?php echo $this->_tpl_vars['lanarray'][$i]['lngtitle'] ?>"><?php echo $this->_tpl_vars['lanarray'][$i]['lngtitle'] ?></a></li>
			<?php }else{ ?>
			<li><a href="<?php echo $this->_tpl_vars['lanarray'][$i]['url'] ?>" title="<?php echo $this->_tpl_vars['lanarray'][$i]['lngtitle'] ?>"><?php echo $this->_tpl_vars['lanarray'][$i]['lngtitle'] ?></a></li>
			<?php } ?>
			<?php }} ?>
		</ul>
	</li>
</ul>