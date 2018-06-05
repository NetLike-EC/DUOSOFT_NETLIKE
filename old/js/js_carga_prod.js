// JavaScript Document
var web=RAIZc+"com_commons/producto_detail.php";
var webNP=RAIZc+"com_commons/form_newProd.php";
var webNPa=RAIZc+"com_commons/fnc_newProd.php";
var webList="_fra_list_session.php";
var webSel=RAIZc+"com_commons/producto_detail.php";
$(document).ready(function() {
/*VARS AGREGAR*/
	var SBR = $("#singleBirdRemote");
	var idSel = $("#idSel");
	var contWeb = $("#selProdCont");
	var contNewProd = $("#selProdNew");
	GenSBRa();
		SBR.focus();
	
	$("#BusSel").on( "change", function() {
		GenSBRa();
		SBR.focus();
	});
	
	function GenSBRa(){
	SBR.autocomplete({
		source: RAIZc+"com_commons/json_searchProd.php?bus="+$("#BusSel").attr("value"),
		select: function( event, ui ) {
			if(ui.item.code>0){
			roleModal = $("#ModalAgre").attr("role");
			webProd=web+'?id_prod='+ui.item.code+'&mod='+roleModal;
			$('#ModalAgre').modal({ keyboard: false, remote:webProd})
			$('#ModalAgre').modal('show');
			idSel.val(0);
			}else{ alert ('No Existe Producto'); }
		},
	});
	}

	$("#btn_Agre").on( "click", function() {
		SBR.val('');
		var paramsAdd = {
            id_prod: $('#id_prod').val(),
			txt_can: parseInt($('#txt_can').val()),
			can_max: parseInt($('#can_max').val()),
			txt_val: parseFloat($('#txt_val').val()),
            action: 'add',
			mod: $('#mod').val(),
    	};
		if (paramsAdd['mod']=='VEN'){
			if((paramsAdd['txt_can']>0)&&(paramsAdd['txt_can']<=paramsAdd['can_max'])){
				if(paramsAdd['txt_val']>=0){
				$('#contReload').load(webSel,paramsAdd,document.getElementById('btnClose').click());
				conSESreload();
				gritterShow('Producto Agregado','Producto Añadido a la Lista');
				SBR.focus();
				}else{
					alert ("Precio Incorrecto");
					txt_val.focus();
				}
			}else{
				alert ("Cantidad Incorrecta. Maximo: "+paramsAdd['can_max']+" productos");
				txt_can.focus();
			}
		}
		if (paramsAdd['mod']=='COM'){
			if(paramsAdd['txt_can']>0){
				if(paramsAdd['txt_val']>=0){
					$('#contReload').load(webSel,paramsAdd,document.getElementById('btnClose').click());
					conSESreload();
					gritterShow('Producto Agregado','Producto Añadido a la Lista');
					SBR.focus();
				}else{
					alert ("Precio Incorrecto");
					txt_val.focus();
				}
			}else{
				alert ("Cantidad Incorrecta. Minimo: 1 producto");
				txt_can.focus();
			}
		}
	});
	
	
			
	function viewDetail(id,sid){
		alert('Carga_det');
		if (id>0){
				contWeb.slideUp();
				contWeb.load(web,{id:id, sid:sid}, hideLoading);
				contWeb.slideDown();
		}else{
			hideLoading(); alert("Seleccione Un Producto"); }
	}
	
	
	
	
	$('#testEve').on( "click", function() {
		$('#ModalAgre').modal('hide');
	});
	
	$('#SaveProd').on( "click", function() {
		data = new FormData($('#formComProdNew')[0]);
        $.ajax({
            type: 'POST',
            url: webNPa,
            data: data,
			dataType:"json",
            cache: false,
            contentType: false,
            processData: false
        }).done(function(data) {
			siRespuesta(data);
        }).fail(function(jqXHR,status, errorThrown) {
            alert('Corriga Campos');
        });
		
	});
	
	function siRespuesta(r){
		var rHtml_tit = r.accion['msg'];
		var rHtml_msg = r.accion['tit'];
		if(r.accion['est']=='TRUE'){
        // Crear HTML con las respuestas del servidor
			document.getElementById('btnCloseP').click();
			SBR.val('');
			SBR.focus();
			
			conSESreload();			
		}
		gritterShow(rHtml_tit,rHtml_msg);
        //$('#respuesta').html(rHtml);   // Mostrar la respuesta del servidor en el div con el id "respuesta"
    }
 
    function siError(e){
        alert('Ocurrió un error al realizar la petición: '+e.statusText);
    }

	$( "#btn_addProd" ).on( "click", function() {
		$('#Modal_prod').modal({
		keyboard: false,
		remote:webNP
	})
	$('#Modal_prod').modal('show');
		$('#prod_nom').focus();
	});
	$('#Modal_prod').on('hidden', function () {
		SBR.focus();
	});	
	$('#ModalAgre').on('shown', function () {
		$('#txt_uni').focus();
	});
	$('#Modal_ven').on('shown', function () {
		$('#txt_uni').focus();
	});
	$('#ModalAgre').on('hidden hide', function () {
		SBR.val('');
		SBR.focus();
	});
	$('#Modal_ven').on('hidden hide', function () {
		SBR.val('');
		SBR.focus();
	});
	
});
function remTabRow_Com(trId){
    var url=RAIZc+'com_commons/prod_detail_eliminar.php';
	$.ajax({
		type:"POST",
		url:url,
		data:"IndiceSES="+trId,
		success: function(){
			$('tr.TrNiv#' + trId).remove();
			conSESreload();
		}
	});
}

function conSESreload(){
	//show the loading bar
	showLoading();
	//load selected section
	$("#contSESSION").slideUp();
	$("#contSESSION").load(webList,{action:"load"}, hideLoading);
	$("#contSESSION").slideDown();
};