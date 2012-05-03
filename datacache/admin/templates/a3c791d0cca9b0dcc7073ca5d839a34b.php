<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['softtitle'] ?></title>
<link href="templates/css/baselist.css" rel="stylesheet" type="text/css" />
<link href="templates/css/all.css" rel="stylesheet" type="text/css" />
<link href="templates/css/formdiv.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/control.js"></script>
<script type="text/javascript" src="js/dialog.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/clickmenu.js"></script>
<script type="text/javascript" src="js/pagebotton.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$.fn.clickMenu.setDefaults({arrowSrc:'templates/images/arrow_right.gif'});
		$('#listbottonul').clickMenu();
		if ($.browser.msie){
			var h = '<?php echo $this->_tpl_vars['iframeheightwindow'] ?>';
			$('#mainbody').css({height:h-99});
			var formlist=document.getElementById('selectform');
			var loadurl=formlist.elements[0].value;
			var maxperpage=formlist.elements[1].value;
			var maxhit=formlist.elements[2].value;
			var nowpage=formlist.elements[3].value;
			var loadname=formlist.elements[6].value;
			var pagetextname=formlist.elements[7].value;
			var pagebottonname=formlist.elements[8].value;
			pageDimensions(h,maxperpage,maxhit,nowpage,loadurl,loadname,pagetextname,pagebottonname,'selectform');
		}
	})

	function search(loadurl){
		if ($.browser.version==6.0){
			var h=document.body.clientHeight;
		}else{
			var h = $(window).height();
		}
		var formlist=document.getElementById('selectform');

		var loadurl=loadurl;

		var maxperpage=formlist.elements[1].value;

		var maxhit=formlist.elements[2].value;

		var nowpage=formlist.elements[3].value;

		var loadname=formlist.elements[6].value;

		var pagetextname=formlist.elements[7].value;

		var pagebottonname=formlist.elements[8].value;
		formlist.elements[0].value = loadurl;
		pageDimensions(h,maxperpage,maxhit,nowpage,loadurl,loadname,pagetextname,pagebottonname,'selectform');
	}

	function sizewindow(){
		var h = $(window).height();
		if(document.getElementById("mainbody")){
			$('#mainbody').css({height:h-99});
		}
		if(document.getElementById("mainbodybottonauto")){
			$('.managebottonadd').css({height:h-120});
		}
		
		if(document.getElementById("selectform")){
			var formlist=document.getElementById('selectform');

			var loadurl=formlist.elements[0].value;

			var maxperpage=formlist.elements[1].value;

			var maxhit=formlist.elements[2].value;

			var nowpage=formlist.elements[3].value;

			var loadname=formlist.elements[6].value;

			var pagetextname=formlist.elements[7].value;

			var pagebottonname=formlist.elements[8].value;
			pageDimensions(h,maxperpage,maxhit,nowpage,loadurl,loadname,pagetextname,pagebottonname,'selectform');
		}
	}
	var resizewindow= null;

	window.onresize = function(){
		var h = $(window).height();
		if(resizewindow!=h){
			sizewindow();
			resizewindow=h;
		}
	}
	document.oncontextmenu=new Function('event.returnValue=false;');
	document.onselectstart=new Function('event.returnValue=false;');
</script>
</head>

<body>
<div id="mainlistbotton">826dfebd693cd4d9f372d59e23d5a077tabmenubotton|<?php echo $this->_tpl_vars['listfunction'] ?>,<?php echo $this->_tpl_vars['lng'] ?>,<?php echo $this->_tpl_vars['mid'] ?>,<?php echo $this->_tpl_vars['isclass'] ?>,<?php echo $this->_tpl_vars['tabarray'] ?>||826dfebd693cd4d9f372d59e23d5a077</div>
<div class="listitle">826dfebd693cd4d9f372d59e23d5a077tablabel|<?php echo $this->_tpl_vars['listfunction'] ?>||826dfebd693cd4d9f372d59e23d5a077</div>
<div id="mainbody" class="tablist">
	<form name="selectform" id="selectform" method="post">
		<input type="hidden" name="loadurl" id="loadurl" value="<?php echo $this->_tpl_vars['loadurl'] ?>">
		<input type="hidden" name="maxperpage" id="maxperpage" value="<?php echo $this->_tpl_vars['MaxPerPage'] ?>">
		<input type="hidden" name="maxhit" id="maxhit" value="<?php echo $this->_tpl_vars['MaxHit'] ?>">
		<input type="hidden" name="nowpage" id="nowpage" value="<?php echo $this->_tpl_vars['nowpage'] ?>">
		<input type="hidden" name="limitkey" id="limitkey" value="<?php echo $this->_tpl_vars['limitkey'] ?>">
		<input type="hidden" name="limitclass" id="limitclass" value="<?php echo $this->_tpl_vars['limitclass'] ?>">
		<input type="hidden" name="loadname" id="loadname" value="#loadingtabelist">
		<input type="hidden" name="pagetextname" id="pagetextname" value="#pageinfo">
		<input type="hidden" name="pagebottonname" id="pagebottonname" value="#Pagination">
		<input type="hidden" name="oldloadurladd" id="oldloadurladd" value="<?php echo $this->_tpl_vars['loadurl'] ?>">
		<div class="loadingdiv" id="loadingtabelist"></div>
	</form>
</div>
<div class="pagelistdiv">
	<div class="pageinfotext" id="pageinfo"></div>
	<div class="pagebottonlist" id="pagebotton"><span id="Pagination" class="pagination"></span></div>
</div>
</body>

</html>


