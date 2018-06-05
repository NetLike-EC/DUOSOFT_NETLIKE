// JavaScript Document
$(function() {
var loading=$('#loading');
var web=RAIZc+"com_pacientes/pacientes_detail.php";
var SelUrl=$("#locUrl").val();
switch (SelUrl){
case "PAC":
	webForm=RAIZc+"com_pacientes/form.php?id=";
	break;
case "CON":
	webForm=RAIZc+"com_consultas/form.php?idp=";
	break;
case "SIG":
	webForm=RAIZc+"com_signos/form.php?id=";
	break;
case "EXA":
	webForm=RAIZc+"com_examen/gest.php?id=";
	break;
case "CIR":
	webForm=RAIZc+"com_cirugia/gest.php?id=";
	break;
case "ECOO":
	webForm=RAIZc+"com_reps/obs_list_gest.php?id=";
	break;
case "ECOG":
	webForm=RAIZc+"com_reps/gin_list_gest.php?id=";
	break;
}

    $( "#tags" ).autocomplete({
		source: RAIZc+'com_pacientes/json.php',//availableTags,
		select: function( event, ui ) { 
			//alert(ui.item.code);
			openDetCli(ui.item.code);
		},
		focus: function( event, ui ) {
			//alert("focus");
			showDetCli(ui.item.code);
		}
    });	
			
	function showDetCli(codCli){
	showLoading();
		if (codCli>0){
		$( "#cont_cli" ).load( web, { cli_sel_find: codCli, acc:'2' },hideLoading);
		}else{ alert("Seleccione Un Cliente"); }
	}
	function openDetCli(codCli){
		showLoading();
		if (codCli>0){
			webForm=webForm+codCli;
		$(location).attr('href',webForm);
		}else{ alert("Seleccione Un Cliente"); }
	}
//show loading bar
function showLoading(){ loading.css({visibility:"visible"}).css({opacity:"1"});}
//hide loading bar
function hideLoading(){ loading.fadeTo(200, 0);};
});