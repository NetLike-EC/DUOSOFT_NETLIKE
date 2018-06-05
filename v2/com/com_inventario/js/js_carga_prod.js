var web="producto_detail.php";
$(document).ready(function() {
	var loading = $("#loading");
	var cont_cli = $("#cont_cli");
	var btn_cons_cli = $(".btn_cons_cli");
	var id_find_cli = $(".id_find_cli");
	//Manage click events
	btn_cons_cli.click(function(){
		//show the loading bar
		showLoading();
		//load selected section
		var id_cli = id_find_cli.attr("value");
		if (id_cli>0){
				Shadowbox.open({
        		content:    'producto_detail.php?prod_sel_find='+id_cli,
        		player:     "iframe",
        		title:      "<strong>DETALLE PRODUCTO</strong>",
				width:		500,
				options:	{relOnClose:true}
    			});
				
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