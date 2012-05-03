<ul class="bbslist">
	<?php if(count($this->_tpl_vars['array'])>0){ ?>
	<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
	<li>
		<div class="sendname"><span class="colorgorningage">Name：<?php echo $this->_tpl_vars['array'][$i]['name'] ?></span><span class="padding-left10 colorgorning3">Time：<?php echo $this->timeformat($this->_tpl_vars['array'][$i]['addtime'],3) ?></span></div>
		<div class="messagelist">Details：<?php echo $this->_tpl_vars['array'][$i]['content'] ?></div>
		<?php if($this->_tpl_vars['array'][$i]['recontent']!=''){ ?>
		<div class="remessagelist colorgreen bgcolorthree2">
			Administrator Reply ：<br/><?php echo $this->_tpl_vars['array'][$i]['recontent'] ?><br/>
			<span class="colorgorning3">Turnaround time：<?php echo $this->timeformat($this->_tpl_vars['array'][$i]['retime'],3) ?></span>
		</div>
		<?php } ?>
	</li>
	<?php }} ?>
	<li>
		<div class="sendname"><span class="colorgreg fontsize14"><?php echo $this->_tpl_vars['num'] ?><?php if($this->_tpl_vars['num']>0){ ?>  <u><a target="_blank" class="infolink04" href="<?php echo $this->_tpl_vars['link'] ?>">Browse all message</a></u><?php } ?></span></div>
	</li>
	<?php }else{ ?>
	<li class="center colorgorningage">No message</li>
	<?php } ?>
</ul>