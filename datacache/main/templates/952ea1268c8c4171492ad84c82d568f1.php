<ul class="bbslist">
	<?php if(count($this->_tpl_vars['array'])>0){ ?>
	<?php if (count($this->_tpl_vars['array'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['array']); $i++){?>
	<li>
		<div class="sendname"><span class="colorgorningage">留言人：<?php echo $this->_tpl_vars['array'][$i]['name'] ?></span><span class="padding-left10 colorgorning3">留言时间：<?php echo $this->timeformat($this->_tpl_vars['array'][$i]['addtime'],3) ?></span></div>
		<div class="messagelist">咨询内容：<?php echo $this->_tpl_vars['array'][$i]['content'] ?></div>
		<?php if($this->_tpl_vars['array'][$i]['recontent']!=''){ ?>
		<div class="remessagelist colorgreen bgcolorthree2">
			管理员回复：<br/><?php echo $this->_tpl_vars['array'][$i]['recontent'] ?><br/>
			<span class="colorgorning3">回复时间：<?php echo $this->timeformat($this->_tpl_vars['array'][$i]['retime'],3) ?></span>
		</div>
		<?php } ?>
	</li>
	<?php }} ?>
	<li>
		<div class="sendname"><span class="colorgreg fontsize14">共<?php echo $this->_tpl_vars['num'] ?>条留言<?php if($this->_tpl_vars['num']>0){ ?>  <u><a target="_blank" class="infolink04" href="<?php echo $this->_tpl_vars['link'] ?>">浏览全部留言</a></u><?php } ?></span></div>
	</li>
	<?php }else{ ?>
	<li class="center colorgorningage">暂无留言</li>
	<?php } ?>
</ul>