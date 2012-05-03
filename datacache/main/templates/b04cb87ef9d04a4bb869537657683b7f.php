<script type="text/javascript">
	$().ready(function() {
		$.ajax({
			url: "<?php echo $this->_tpl_vars['ajaxurl'] ?>index.php?ac=messmain&at=ajaxlist&did=<?php echo $this->_tpl_vars['did'] ?>&max=<?php echo $this->_tpl_vars['max'] ?>&ismess=<?php echo $this->_tpl_vars['ismess'] ?>",
			success: function(date){
				$('#bbsajaxlist').html(date);
			}
		});
	});
</script>
<div class="righttext">
	<div class="readlist">
		<div class="tg1">留言咨询</div>
		<div class="l" id="bbsajaxlist"></div>
		<div class="tg3">提交留言 (* 为必填项目)</div>
		<script type="text/javascript">
			var forum_input_err = "<?php echo $this->_tpl_vars['lngpack']['forum_input_err'] ?>";
			var seccode_empty = "<?php echo $this->_tpl_vars['lngpack']['seescodeerr'] ?>";
		</script>
		<form name="messformsave" method="post" action="<?php echo $this->_tpl_vars['messform'] ?>" onSubmit="return messform('<?php echo $this->_tpl_vars['bbs_isseccode'] ?>')">
			<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['member']['userid'] ?>">
			<input type="hidden" name="did" value="<?php echo $this->_tpl_vars['did'] ?>">
			<input type="hidden" name="lng" value="<?php echo $this->_tpl_vars['lng'] ?>">
			<table class="formlist" style="width:662px;">
				<tr>
					<th class="fontsize14" width="15%">* 姓名</th>
					<td><input type="text" name="name" class="infoInput" value="<?php echo $this->_tpl_vars['member']['alias'] ?>" style="width:95%;"/></td>
				</tr>
				<tr>
					<th class="fontsize14">* 内容</th>
					<td><textarea name="content" rows="15" class="infoInput" style="width:95%;height:150px;"></textarea></td>
				</tr>
				<?php if($this->_tpl_vars['bbs_isseccode']==1){ ?>
				<tr>
					<th class="fontsize14">* 验证码</th>
					<td>
						<input type="text" id="seccode" name="seccode" class="infoInput" maxlength="4" size="5" style="text-transform: uppercase;"/>
						<img title="点击更换验证码" id="memberseccodesrc" onclick="sessionimg('memberseccodesrc','<?php echo $this->_tpl_vars['rootdir'] ?>')" src="<?php echo $this->_tpl_vars['seccodelink'] ?>" style="cursor: pointer;" align="absmiddle"/>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<th></th>
					<td><input type="submit" name="submit" value="提交留言" class="buttonface" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>