function  Save_Button_onclick() {
	var val =  document.getElementById("CodeArea").value;
	if (document.getElementById("CodeArea").value == ''){
		tinyMCEPopup.close();
		return false;
	}
	var code='<p style="text-align: center;">'+val+'</p>';
	tinyMCEPopup.execCommand('mceInsertContent', false, code);
	tinyMCEPopup.close();
}

function Cancel_Button_onclick(){
	tinyMCEPopup.close();
	return false;
}