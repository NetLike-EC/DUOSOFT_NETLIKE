// JavaScript Document
var web="producto_detail.php";

$(document).ready(function() {
	var loading = $("#loading");
	//var cont_cli = $("#cont_cli");
	var btn_cons_cli = $("#btn_cons_cli");
	var id_find_cli = $(".id_find_cli");

	//Manage click events
	btn_cons_cli.click(function(){
		//show the loading bar
		showLoading();
		//load selected section
		var id_cli = id_find_cli.attr("value");
		if (id_cli>0){
				/*cont_cli.slideUp();
				cont_cli.load(web,{cli_sel_find:id_cli, acc:"2"}, hideLoading);
				cont_cli.slideDown();*/
				window.location.href = 'inv_form_prod.php?id='+id_cli;				
		}else{
			hideLoading();
			alert("Seleccione Un Producto");
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