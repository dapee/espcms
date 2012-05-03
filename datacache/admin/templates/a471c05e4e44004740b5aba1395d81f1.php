<?php if($this->_tpl_vars['loadfun']=='articlelist'){ ?>
<div class="modeltitle">按所属模型查看</div>
<div class="scrolltext">
	<div class="srcolcontent" style="height:75px;">
		<ul>
			<?php if (count($this->_tpl_vars['modelarray'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['modelarray']); $i++){?>
			<?php if($this->_tpl_vars['modelarray'][$i]['selected']=='selected'){ ?>
			<li><b><?php echo $this->_tpl_vars['modelarray'][$i]['modelname'] ?></b></li>
			<?php }else{ ?>
			<li><a href="<?php echo $this->_tpl_vars['modelarray'][$i]['url'] ?>" title="<?php echo $this->_tpl_vars['modelarray'][$i]['modelname'] ?>"><?php echo $this->_tpl_vars['modelarray'][$i]['modelname'] ?></a></li>
			<?php } ?>
			<?php }} ?>
		</ul>
	</div>
</div>

<div class="modeltitle2">按分类查看</div>
<div class="scrolltext">
	<div class="srcolcontent" style="height:250px;" id="srcolcontent">
		<ul>
			<?php if (count($this->_tpl_vars['typelist'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['typelist']); $i++){?>
			<?php if($this->_tpl_vars['typelist'][$i]['level']>0){ ?><li class="tree<?php echo $this->_tpl_vars['typelist'][$i]['level'] ?>"><?php }else{ ?><li><?php } ?>
				<?php if($this->_tpl_vars['typelist'][$i]['selected']=='selected'){ ?>
				<b><?php echo $this->_tpl_vars['typelist'][$i]['typename'] ?></b>
				<?php }else{ ?>
					<?php if($this->_tpl_vars['typelist'][$i]['styleid']==4){ ?>
						<p class="tabclick" datatype="iframe" datalink="index.php?archive=article&action=docedit&did=<?php echo $this->_tpl_vars['typelist'][$i]['linkid'] ?>&tid=<?php echo $this->_tpl_vars['typelist'][$i]['tid'] ?>&mid=<?php echo $this->_tpl_vars['typelist'][$i]['mid'] ?>&type=edit&iframename=jerichotabiframe_0" iconimg="templates/images/tab.gif" jerichotabindex="10000"><a href="#body" class="tabclicklink" hidefocus="true"><?php echo $this->_tpl_vars['typelist'][$i]['typename'] ?></a></p>
					<?php }else{ ?>
						<a href="<?php echo $this->_tpl_vars['typelist'][$i]['url'] ?>" title="<?php echo $this->_tpl_vars['typelist'][$i]['typename'] ?>"><?php echo $this->_tpl_vars['typelist'][$i]['typename'] ?></a>
					<?php } ?>
				<?php } ?>
			</li>
			<?php }} ?>
		</ul>
	</div>
</div>
<?php } ?>

<?php if($this->_tpl_vars['loadfun']=='seolinklist' || $this->_tpl_vars['loadfun']=='seolinktypelist'){ ?>
<div class="modeltitle">按所属模型查看</div>
<div class="scrolltext">
	<div class="srcolcontent" style="height:75px;">
		<ul>
			<?php if (count($this->_tpl_vars['modelarray'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['modelarray']); $i++){?>
			<?php if($this->_tpl_vars['modelarray'][$i]['selected']=='selected'){ ?>
			<li><b><?php echo $this->_tpl_vars['modelarray'][$i]['modelname'] ?></b></li>
			<?php }else{ ?>
			<li><a href="<?php echo $this->_tpl_vars['modelarray'][$i]['url'] ?>" title="<?php echo $this->_tpl_vars['modelarray'][$i]['modelname'] ?>"><?php echo $this->_tpl_vars['modelarray'][$i]['modelname'] ?></a></li>
			<?php } ?>
			<?php }} ?>
		</ul>
	</div>
</div>

<div class="modeltitle2">按分类查看</div>
<div class="scrolltext">
	<div class="srcolcontent" style="height:250px;" id="srcolcontent">
		<ul>
			<?php if (count($this->_tpl_vars['typelist'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['typelist']); $i++){?>
			<?php if($this->_tpl_vars['typelist'][$i]['level']>0){ ?><li class="tree<?php echo $this->_tpl_vars['typelist'][$i]['level'] ?>"><?php }else{ ?><li><?php } ?>
				<?php if($this->_tpl_vars['typelist'][$i]['selected']=='selected'){ ?>
				<b><?php echo $this->_tpl_vars['typelist'][$i]['typename'] ?></b>
				<?php }else{ ?>
				<a href="<?php echo $this->_tpl_vars['typelist'][$i]['url'] ?>" title="<?php echo $this->_tpl_vars['typelist'][$i]['typename'] ?>"><?php echo $this->_tpl_vars['typelist'][$i]['typename'] ?></a>
				<?php } ?>
			</li>
			<?php }} ?>
		</ul>
	</div>
</div>
<?php } ?>

<?php if($this->_tpl_vars['loadfun']=='typelist' || $this->_tpl_vars['loadfun']=='subjectlist' || $this->_tpl_vars['loadfun']=='recomlist'){ ?>
<div class="modeltitle">按所属模型查看</div>
<div class="scrolltext">
	<div class="srcolcontent" style="height:75px;" id="modelleftcontent">
		<ul>
			<?php if (count($this->_tpl_vars['modelarray'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['modelarray']); $i++){?>
				<?php if($this->_tpl_vars['modelarray'][$i]['selected']=='selected'){ ?>
				<li><b><?php echo $this->_tpl_vars['modelarray'][$i]['modelname'] ?></b></li>
				<?php }else{ ?>
				<li><a href="<?php echo $this->_tpl_vars['modelarray'][$i]['url'] ?>" title="<?php echo $this->_tpl_vars['modelarray'][$i]['modelname'] ?>"><?php echo $this->_tpl_vars['modelarray'][$i]['modelname'] ?></a></li>
				<?php } ?>
			<?php }} ?>
		</ul>
	</div>
</div>
<?php } ?>

<?php if($this->_tpl_vars['loadfun']=='memberlist'){ ?>
<div class="modeltitle">按会员等级查看</div>
<div class="scrolltext">
	<div class="srcolcontent" style="height:75px;" id="modelleftcontent">
		<ul>
			<?php if (count($this->_tpl_vars['memberclass'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['memberclass']); $i++){?>
				<?php if($this->_tpl_vars['memberclass'][$i]['selected']=='selected'){ ?>
				<li><b><?php echo $this->_tpl_vars['memberclass'][$i]['rankname'] ?></b></li>
				<?php }else{ ?>
				<li><a href="<?php echo $this->_tpl_vars['memberclass'][$i]['url'] ?>" title="<?php echo $this->_tpl_vars['memberclass'][$i]['rankname'] ?>"><?php echo $this->_tpl_vars['memberclass'][$i]['rankname'] ?></a></li>
				<?php } ?>
			<?php }} ?>
		</ul>
	</div>
</div>
<?php } ?>

<?php if($this->_tpl_vars['loadfun']=='advertlist'){ ?>
<div class="modeltitle">按广告位查看</div>
<div class="scrolltext">
	<div class="srcolcontent" style="height:75px;" id="modelleftcontent">
		<ul>
			<?php if (count($this->_tpl_vars['adtype'])>0){$divid_i=1;for($i=0;$i<count($this->_tpl_vars['adtype']); $i++){?>
				<?php if($this->_tpl_vars['adtype'][$i]['selected']=='selected'){ ?>
				<li><b><?php echo $this->_tpl_vars['adtype'][$i]['adtypename'] ?></b></li>
				<?php }else{ ?>
				<li><a href="<?php echo $this->_tpl_vars['adtype'][$i]['url'] ?>" title="<?php echo $this->_tpl_vars['adtype'][$i]['adtypename'] ?>"><?php echo $this->_tpl_vars['adtype'][$i]['adtypename'] ?></a></li>
				<?php } ?>
			<?php }} ?>
		</ul>
	</div>
</div>
<?php } ?>


