<script type="text/javascript">
var RAIZ0='<?php echo $RAIZ0 ?>';
var RAIZ='<?php echo $RAIZ ?>';
var RAIZa='<?php echo $RAIZa ?>';
var RAIZc='<?php echo $RAIZc ?>';
</script>
<!-- _libs -->
<script type="text/javascript" src="<?php echo $RAIZa ?>js/jquery-1.12.1.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>js/js-my-1.1.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>js/bootstrap.min.js"></script>
<!--<script type='text/javascript' src='<?php echo $RAIZa ?>plugins/tinymce/tinymce.min.js' ></script>-->
<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=3b9r8njg85t7h46luc0u96ud8ec1jgbfzybc3il44kjgc82g"></script>-->
<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>-->
<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=jpwll5ka12lix7fkgq6w4t9iwd9qj3qurqcpwvuhnn7jo646"></script>-->
<script type='text/javascript' src='<?php echo $RAIZa ?>plugins/tinymce-4.0.7/tinymce.min.js' ></script>
<script type="text/javascript" src='<?php echo $RAIZa ?>js/chosen1-3-0.jquery.min.js' ></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>js/jquery.gritter.min.js"></script>
<!-- Fancybox -->
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(window).bind('keydown', function(event) {
		if (event.ctrlKey || event.metaKey) {
			switch (String.fromCharCode(event.which).toLowerCase()) {
			case 's':
				event.preventDefault();
				if($("#vAcc").length > 0) $("#vAcc").click(); 
				else alert ("No Controls to save");
				break;
			/* case 'f': event.preventDefault(); alert('ctrl-f'); break;
			case 'g': event.preventDefault(); alert('ctrl-g'); break; */
			}
		}
	});
	//Verify Acction SAVE Buttons DATABASE
	$('#vAcc').on('click', function () {
    var $btn = $(this).button('loading');
	var r = confirm('Are You Sure?');
	if (r == true) $('form').submit();
    else $btn.button('reset');
	});
	
	//Verifi Action of button, submit in a List interface (table tr td list)
	$('.vAccTM').on('click', function (e) {
		var $btn = $(this).button('loading');
		var paramTit = $(this).attr('data-title');
		var paramText = $(this).attr('data-text');


		var r = confirm(paramTit);
		if (r == true) {
			$('form').submit();
		} else {
			e.preventDefault();
			$btn.button('reset');
		}
	});
	$('.vAccL').on('click', function (e) {
		var link = this;
		var paramTit = $(this).attr('data-title');
		var paramText = $(this).attr('data-text');
		if(!paramTit) paramTit='Are you sure ?';
		if(!paramText) paramText='Danger';
		e.preventDefault();
		$("<div>"+paramText+"</div>").dialog({
			title:paramTit,
			buttons: {
				"Aceptar": function() {
					$(this).dialog("close");
					window.location = link.href;
					
				},
				"Cancelar": function() {
					$(this).dialog("close");
				}
			},
			show: { effect: "blind", duration: 400 },
			minWidth: 350
		});
	});
	$('.vAccT').on('click', function (e) {
		var link = this;
		var paramTit = $(this).attr('data-title');
		var paramText = $(this).attr('data-text');
		e.preventDefault();
		$("<div>"+paramText+"</div>").dialog({
			title:paramTit,
			buttons: {
				"Aceptar": function() {
					$(this).dialog("close");
					$('form').submit();
				},
				"Cancelar": function() {
					$(this).dialog("close");
				}
			},
			show: { effect: "blind", duration: 400 },
			minWidth: 350
		});
	});
	
	var contlog = $("#log");
	contlog.hide().delay(200).slideDown(250).delay(3500).slideUp(300);
	//var loading=$('#loading');
	
	//Fancybox Functions
	
	$('.fancybox').fancybox();
	$(".fancyreload").fancybox({
		autoSize : false, width : "95%", height : "95%", mouseWheel	: false, beforeClose: function() { location.reload(); }
	});
	$(".fancyclose").fancybox({
		autoSize : true, beforeClose: function() { location.reload(); }
	});
	$(".fancyTab").fancybox({
		prevEffect		: 'elastic', nextEffect : 'elastic',
		closeBtn		: true,	arrows : false, mouseWheel : false,
		autoSize 		: false, width : "95%", height : "95%",
		helpers			: {
			title		: { type : 'inside' },
			buttons		: {}
		},
		beforeClose: function() { location.reload(); }
	});
	$(".fancybox-thumb").fancybox({
		prevEffect	: 'none', nextEffect : 'none',
		helpers	: {
			title	: { type: 'outside' },
			thumbs	: { width	: 50, height	: 50 }
		}
	});

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	//Init TableSorted
	$(function() { $("#deftab").tablesorter({widgets: ['zebra']}); });
	$(function() { $("#mytable").tablesorter({sortList:[[2,0],[3,0]], widgets: ['zebra']}); });
	$(function() { $("#itm_table").tablesorter({sortList:[[0,1]], widgets: ['zebra']}); });
	$(function() { $("#tab_base").tablesorter({sortList:[[0,1]], widgets: ['zebra']}); });

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Init tinymce
	/*
	console.log(RAIZ0+"assets/css/bootstrap-yeti.min.css");
	console.log(RAIZ0+"assets/css/font-awesome.min.css");
	console.log(RAIZ0+"assets/css/cssb_201512-002.css");
	*/
	tinymce.init({
		selector: "textarea.tmce",
		body_class: "contProdDes cero",
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor"
		],
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		toolbar2: " preview media | forecolor backcolor emoticons | code",
		image_advtab: true,
		convert_urls: false,
		extended_valid_elements : "i[class],strong/b",
		invalid_elements : "",
		content_css : [RAIZ0+"assets/css/bootstrap-yeti.min.css",RAIZ0+"assets/css/font-awesome.min.css",RAIZ0+"assets/css/cssb_201512-002.css"]
	});
	tinymce.init({
		selector: "textarea.tmcem",
		body_class: "contProdDes cero",
		plugins: [
		"advlist autolink lists link image charmap print preview hr anchor pagebreak",
		"searchreplace wordcount visualblocks visualchars code fullscreen",
		"insertdatetime media nonbreaking save table contextmenu directionality",
		"emoticons template paste textcolor"
		],
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor emoticons | code",
		//toolbar2: " preview media | forecolor backcolor emoticons",
		image_advtab: true,
		convert_urls: false,
		extended_valid_elements : "i[class],strong/b",
		invalid_elements : "",
		content_css : [RAIZ0+"assets/css/bootstrap-yeti.min.css",RAIZ0+"assets/css/font-awesome.min.css",RAIZ0+"assets/css/cssb_201512-002.css"]
	});

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//GRITTER
	$.extend($.gritter.options, {
		//class_name: 'gritter-light', // for light notifications (can be added directly to $.gritter.add too)
		position: 'bottom-right', // possibilities: bottom-left, bottom-right, top-left, top-right
		fade_in_speed: 1000, // how fast notifications fade in (string or int)
		fade_out_speed: 1500, // how fast the notices fade out
		time: 5000 // hang on the screen for...
	});

});
</script>