// JavaScript Document
$(document).ready(function(){ 
	var contlog = $("#log");
	contlog.hide().delay(200).slideDown(400).delay(3800).slideUp(400);
	$("#div_loading").hide();
});
function shadbox_open(dir_sel, tit_sel, dim_width, action_sel, id_sel){
    Shadowbox.open({
        content:    dir_sel+"?action="+action_sel+"&id_sel="+id_sel,
        player:     "iframe",
		width:		dim_width,
        title:      tit_sel,
		options: 	{relOnClose:true}
    });
}
function shadbox_pic(image, title){
    Shadowbox.open({
        content:    image,
        player:   "img",
        title:      title,
		//options: 	{relOnClose:true}
    });
}
function cont_panel(panel, banhead){
	$(document).ready(function(){ 
		var cont_cli = $("#div_cont"); 
		var div_head = $("#div_head"); 
		var div_loading = $("#div_loading"); 
		div_loading.hide();
		if(banhead==true) div_head.slideUp();
		else div_head.hide();
		div_loading.fadeIn();
		cont_cli.fadeOut(300);
		
	cont_cli.load(panel, function() {
		div_loading.fadeOut();
		cont_cli.fadeIn();
	});
		
		
	});
}