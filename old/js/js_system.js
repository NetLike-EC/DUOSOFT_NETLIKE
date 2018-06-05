// JavaScript Document
$(document).ready(function(){ 
	$("#log").hide().delay(200).slideDown(400).delay(3800).slideUp(400);
});
function aconfirm(actsel) {
	var txtsel='Are you sure ?';
	if (actsel=='DEL') txtsel='Seguro que desea Eliminar ?';
	if (actsel=='INS') txtsel='Seguro que desea Grabar ?';
	if (actsel=='UPD') txtsel='Seguro que desea Actualizar ?';
	return confirm(txtsel);
}

	//show loading bar
	function showLoading(){
		$("#loading")
			.css({visibility:"visible"})
			.css({opacity:"1"})
			.css({display:"block"});
	}
	//hide loading bar
	function hideLoading(){ $("#loading").fadeTo(200, 0);	};
	
function gritterShow(tit,msg,img){
	$.gritter.add({
		title: tit,// (string | mandatory) the heading of the notification
		text: msg,// (string | mandatory) the text inside the notification
		image: img,// (string | optional) the image to display on the left
		sticky: false,// (bool | optional) if you want it to fade out on its own or just sit there
		time: '3000'// (int | optional) the time you want it to be alive for before fading out
	});
	return false;	
}