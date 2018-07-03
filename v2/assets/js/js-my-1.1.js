// JavaScript Document
$(document).ready(function() {
	var txtIcon=$("#txtIcon");
	txtIcon.on('keypress keyup focusout', function(evt, params) {
		iconClass(txtIcon.val());
	});
	$('.toolTipU').tooltip();
});
function iconClass(clase){
	$("#iconRes").removeClass();
	$("#iconRes").addClass(clase);
}
//Personal FUnctions
function aconfirm(actsel) {
	var txtsel='Are you sure ?';
	if (actsel=='DEL') txtsel='Are you sure Delete ?';
	if (actsel=='INS') txtsel='Are you sure Insert ?';
	if (actsel=='UPD') txtsel='Are you sure Update ?';
	return confirm(txtsel);
}
function logGritter(titulo,descripcion,imagen){
	$.gritter.add({
		position: 'bottom-right',
		title: titulo,// (string | mandatory) the heading of the notification
		text: descripcion,// (string | mandatory) the text inside the notification
		image: imagen,// (string | optional) the image to display on the left
		sticky: false,// (bool | optional) if you want it to fade out on its own or just sit there
		time: '',// (int | optional) the time you want it to be alive for before fading out
		//class_name: 'my-sticky-class'// (string | optional) the class name you want to apply to that specific message
	});
}
//show loading bar
function showLoading(){ $('#loading').css({visibility:"visible"}).css({opacity:"1"});}
//hide loading bar
function hideLoading(){ $('#loading').fadeTo(200, 0);};
//COPY TO CLIPBOARD
function copyTextToClipboard(text) {
  var textArea = document.createElement("textarea");
  // *** This styling is an extra step which is likely not required. ***
  // Why is it here? To ensure:
  // 1. the element is able to have focus and selection.
  // 2. if element was to flash render it has minimal visual impact.
  // 3. less flakyness with selection and copying which **might** occur if the textarea element is not visible.
  // The likelihood is the element won't even render, not even a flash, so some of these are just precautions. However in IE the element  visible whilst the popup box asking the user for permission for the web page to copy to the clipboard.
  // Place in top-left corner of screen regardless of scroll position.
  textArea.style.position = 'fixed';
  textArea.style.top = 0;
  textArea.style.left = 0;
  // Ensure it has a small width and height. Setting to 1px / 1em
  // doesn't work as this gives a negative w/h on some browsers.
  textArea.style.width = '2em';
  textArea.style.height = '2em';
  // We don't need padding, reducing the size if it does flash render.
  textArea.style.padding = 0;
  // Clean up any borders.
  textArea.style.border = 'none';
  textArea.style.outline = 'none';
  textArea.style.boxShadow = 'none';
  // Avoid flash of white box if rendered for any reason.
  textArea.style.background = 'transparent';
  textArea.value = text;
  document.body.appendChild(textArea);
  textArea.select();
  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
  } catch (err) {
    console.log('Oops, unable to copy');
  }
  document.body.removeChild(textArea);
}