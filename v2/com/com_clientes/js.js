// JavaScript Document
function setDB(campo, valor){
	var cod=$('#id').val();
	var tbl=$('#tbl').val()
	$.get( RAIZc+"com_comun/actionsJS.php", { campo: campo, valor: valor, cod:cod, tbl: tbl}, function( data ) {
		showLoading();
		$("#logF").show(100).text(data.inf).delay(3000).hide(200);
		hideLoading();
	}, "json" );
}

function viewEdad(valor){
	alert('OK');
}