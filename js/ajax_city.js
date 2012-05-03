/*
PHP version 5
Copyright (c) 2002-2010 ECISP.CN
声明：这不是一个免费的软件，请在许可范围内使用
作者：Bili E-mail:huangqyun@163.com  QQ:6326420
http://www.ecisp.cn	http://www.easysitepm.com
*/
$(document).ready(function() {
	$('#cityone').change(function(){
		var parentid=$(this).val();
		sec_cityone(parentid);
	});
	$('#citytwo').change(function(){
		var parentid=$(this).val();
		sec_citytwo(parentid);
	});
	$('#citythree').change(function(){
		var parentid=$(this).val();
		sec_district(parentid);
	});
	$('#loading').hide();
	$('#loading').ajaxStart(function() {
		$('#loading').show();
	}).ajaxStop(function() {
		$('#loading').hide();
	});
});
///**
//*执行GET请求
//* parentid:所属国家 verid:所属省份，缺省为0
//* 返回省份列表
//*/
function sec_cityone(parentid,verid){
	if (parentid==0){
		$("#citytwo").empty();
		$("#citythree").empty();
		$("#district").empty();
		$("#citytwo").append('<option selected value="0">'+citytwo_title+'</option>');
		$("#citythree").append('<option selected value="0">'+citythree_title+'</option>');
		$("#district").append('<option selected value="0">'+district_title+'</option>');
	}else{
		$.get('index.php?ac=public&at=citylist&parentid='+parentid+'&verid='+verid, {},function(data){
			$("#citytwo").append(data);
		})
	}
}
///**
//*执行GET请求
//* parentid:所属省份 verid:所属城市，缺省为0
//* 返回城市列表
//*/
function sec_citytwo(parentid,verid){
	if (parentid==0){
		$("#citythree").empty();
		$("#district").empty();
		$("#citythree").append('<option selected value="0">'+citythree_title+'</option>');
		$("#district").append('<option selected value="0">'+district_title+'</option>');
	}else{
		$.get('index.php?ac=public&at=citylist&parentid='+parentid+'&verid='+verid, {},function(data){
			$("#citythree").empty();
			$("#district").empty();
			$("#citythree").append('<option selected value="0">'+citythree_title+'</option>');
			$("#citythree").append(data);
			$("#district").append('<option selected value="0">'+district_title+'</option>');
		})
	}
}
///**
//*执行GET请求
//* parentid:所属城市 verid:所属地区，缺省为0
//* 返回城市列表
//*/
function sec_district(parentid,verid){
	if (parentid==0){
		$("#district").empty();
		$("#district").append('<option selected value="0">'+district_title+'</option>');
	}else{
		$.get('index.php?ac=public&at=citylist&parentid='+parentid+'&verid='+verid, {},function(data){
			$("#district").empty();
			$("#district").append(data);
		})
	}
}