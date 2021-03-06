(function(){
	tinymce.PluginManager.requireLangPack('adimages');
	tinymce.create('tinymce.plugins.adimages',{
		init:function(ed,url){
			ed.addCommand('mceaddadimages',function(){
				parent.windowsdig('批量添加图片','iframe:index.php?archive=filemanage&action=filewindow&listfunction=filelist&maxselect=10&iframeid=&checkfrom=edit&filetype=img&fileinputid=&iframename='+self.frameElement.getAttribute('name'),'900px','480px','iframe');
				});
			ed.addButton('adimages',{
				title:'adimages.adimages_button_desc',
				cmd:'mceaddadimages',
				image:url+'/img/adimages.gif'
				});
			ed.onNodeChange.add(function(ed,cm,n){
				//如果在内容选择相应的内容属性，比如链接，<a> 图片<IMG> 则在按钮上面显示相应的已选按扭状态
				cm.setActive('adimages',n.nodeName=='SRC')
				})
			},
		getInfo:function(){
			return{
				longname:'adimages',
				author:'QQ:6326420',
				authorurl:'http://www.ecisp.cn',
				infourl:'http://www.ecisp.cn',
				version:"1.0"
			}
		}
	});
tinymce.PluginManager.add('adimages',tinymce.plugins.adimages)
	})();