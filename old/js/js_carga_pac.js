// JavaScript Document
var web=RAIZ+"componentes/com_clientes/pacientes_detail.php";
$(document).ready(function() {
	var BCR=$("#busCli");
	BCR.autocomplete({
		source: RAIZc+"com_clientes/json_searchCli.php",
		select: function( event, ui ) {
			loadCliDet(ui);
			/*roleModal = $("#Modal_com").attr("role");
			webProd=web+'?id_prod='+ui.item.code+'&mod='+roleModal;
			$('#Modal_com').modal({ keyboard: false, remote:webProd})
			$('#Modal_com').modal('show');
			idSel.val(0);*/
			//alert(ui.item.ruc)
		}
	});
	
	function loadCliDet(ui){
		$("#cliCOD").html(ui.item.code);
		$("#cli_cod").val(ui.item.code);
		$("#cliRUC").html(ui.item.ruc);
		$("#cliNOM").html(ui.item.value);
		$("#cliDIR").html(ui.item.dir);
		$("#cliTEL").html(ui.item.tel);
	}
	
	var loading = $("#loading");
	var cont_cli = $("#cont_cli");
	var btn_cons_cli = $(".btn_cons_cli");
	var btn_list_cli = $(".btn_list_cli");
	var id_find_cli = $(".id_find_cli");
	var id_list_cli = $(".id_list_cli2");

	//Manage click events
	btn_cons_cli.click(function(){
		//show the loading bar
		showLoading();
		//load selected section
		var id_cli = id_find_cli.attr("value");
		if (id_cli>0){
				cont_cli.slideUp();
				cont_cli.load(web,{cli_sel_find:id_cli, acc:"2"}, hideLoading);
				cont_cli.slideDown();
		}else{
			hideLoading();
			alert("Seleccione Un Cliente");
		}
	});
	
	//show loading bar
	function showLoading(){
		loading
			.css({visibility:"visible"})
			.css({opacity:"1"})
			.css({display:"block"})
		;
	}

	//hide loading bar
	function hideLoading(){
		loading.fadeTo(200, 0);
	};
});
function show_det_cli_list(id_pac){
	//alert (id_pac);
	
	var loading = $("#loading");
	var cont_cli = $("#cont_cli");
	
	showLoading();
	//load selected section
	cont_cli.slideUp();
	cont_cli.load(web,{cli_sel_find:id_pac}, hideLoading);
	cont_cli.slideDown();
	hideLoading();

	//show loading bar
	function showLoading(){
		loading
			.css({visibility:"visible"})
			.css({opacity:"1"})
			.css({display:"block"})
		;
	}

	//hide loading bar
	function hideLoading(){
		loading.fadeTo(200, 0);
	};
};