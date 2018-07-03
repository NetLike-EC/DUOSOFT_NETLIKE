// JavaScript Document
$(function() {
var loading=$('#loading');
var web=RAIZc+"com_clientes/detail_min.php";
var SelUrl=$("#locUrl").val();
	//alert(SelUrl);
switch (SelUrl){
case "CLI":
	webForm=RAIZc+"com_clientes/form.php?ids=";
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
	default:
		webForm=null;
	break;
}
	//alert(webForm);
	//console.log(webForm);

    $( "#tags" ).autocomplete({
		source: RAIZc+'com_clientes/json.php',//availableTags,
		select: function( event, ui ) { 
			//alert(ui.item.ids);
			openDetCli(ui.item.ids);
		},
		focus: function( event, ui ) {
			//alert(ui.item.ids);
			showDetCli(ui.item.ids);
		}
    });	
	function showDetCli(codCli){
		//alert('yes');
	showLoading();
		if (codCli){
		$( "#cont_cli" ).load( web, { ids: codCli, acc:'2' },hideLoading);
		}else{ alert("Seleccione Un Cliente"); }
	}
	function openDetCli(codCli){
		showLoading();
		if (codCli){
			webForm=webForm+codCli;
		$(location).attr('href',webForm);
		}else{ alert("Seleccione Un Cliente"); }
	}
//show loading bar
function showLoading(){ loading.css({visibility:"visible"}).css({opacity:"1"});}
//hide loading bar
function hideLoading(){ loading.fadeTo(200, 0);};
});