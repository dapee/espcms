function  Save_Button_onclick() {
	var lang = document.getElementById("ProgrammingLanguages").value;
	var code =  WrapCode(lang);
	var val =  document.getElementById("CodeArea").value;
	val = val.replace('<?', '##?');
	val = val.replace('?>', '?##');
	val = val.replace(/&/g,'&amp;');
        val = val.replace(/>/g,'&gt;');
        val = val.replace(/</g,'&lt;');
        val = val.replace(/"/g,'&quot;');
	code = code + val;
	code = code + "</pre> "
	if (document.getElementById("CodeArea").value == ''){
		tinyMCEPopup.close();
		return false;
	}
	tinyMCEPopup.execCommand('mceInsertContent', false, code);
	tinyMCEPopup.close();
}
    
function  WrapCode(lang){
	var options = "";
	if (document.getElementById("nogutter").checked == true)
		options = ";gutter:false";
       
	if (document.getElementById("collapse").checked == true)
		options = options + ";collapse:true";
              
	if (document.getElementById("nocontrols").checked == true)
		options = options + ";toolbar:false";
              
	if (document.getElementById("showcolumns").checked == true)
		options = options + ";ruler:true";
       
	return "<pre class='brush:"+lang+options+"'>";
}

function Cancel_Button_onclick(){
	tinyMCEPopup.close();
	return false;
}