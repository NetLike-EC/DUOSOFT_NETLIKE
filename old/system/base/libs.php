<!-- BEGIN JAVASCRIPTS -->
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="<?php echo $RAIZa; ?>js/jquery-1.8.3.min.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo $RAIZa; ?>js/excanvas.js"></script>
<script src="<?php echo $RAIZa; ?>js/respond.js"></script>	
<![endif]-->	
<script src="<?php echo $RAIZa; ?>breakpoints/breakpoints.js"></script>		
<script src="<?php echo $RAIZa; ?>jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $RAIZa; ?>jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo $RAIZa; ?>jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo $RAIZa; ?>fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo $RAIZa; ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $RAIZa; ?>js/jquery.blockui.js"></script>	
<script src="<?php echo $RAIZa; ?>js/jquery.cookie.js"></script>
<script src="<?php echo $RAIZa; ?>jquery-knob/js/jquery.knob.js"></script>
<script src="<?php echo $RAIZa; ?>jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>	
<script src="<?php echo $RAIZa; ?>jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="<?php echo $RAIZa; ?>jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="<?php echo $RAIZa; ?>jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="<?php echo $RAIZa; ?>jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="<?php echo $RAIZa; ?>jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="<?php echo $RAIZa; ?>jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
<script src="<?php echo $RAIZa; ?>flot/jquery.flot.js"></script>
<script src="<?php echo $RAIZa; ?>flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa; ?>gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa; ?>uniform/jquery.uniform.min.js"></script>	
<script type="text/javascript" src="<?php echo $RAIZa; ?>js/jquery.pulsate.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa; ?>bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa; ?>bootstrap-daterangepicker/daterangepicker.js"></script>	
<script type="text/javascript" src="<?php echo $RAIZa; ?>jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $RAIZa; ?>js/app.js"></script>
<script src="<?php echo $RAIZj; ?>datep.duotics.js"></script>
<script src="<?php echo $RAIZa; ?>fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo $RAIZj; ?>shadowbox.js"></script>
<script type="text/javascript">
	Shadowbox.init({ modal: true });
	function closeShadowbox(){ this.Shadowbox.close(); };
</script>

<script type="text/javascript" src="<?php echo $RAIZj; ?>jquery.price_format.1.8.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZj; ?>js_system.js"></script>
<script type="text/javascript" src='<?php echo $RAIZ ?>js/chosen.jquery.min.js'></script>
<!--<script type="text/javascript" src='<?php //echo $RAIZ ?>js/jquery.autocomplete.min.js'></script>-->
<script type="text/javascript">
$(document).ready(function() {		
	//App.setPage("index");  // set current page
	App.setPage("sliders");
	App.init(); // init the rest of plugins and elements		
});

//*****INICIO GRITTER*****
	$.extend($.gritter.options, {
		class_name: 'gritter-light', // for light notifications (can be added directly to $.gritter.add too)
		position: 'bottom-right', // possibilities: bottom-left, bottom-right, top-left, top-right
		fade_in_speed: 1000, // how fast notifications fade in (string or int)
		fade_out_speed: 1500, // how fast the notices fade out
		time: 5000 // hang on the screen for...
	});
	function logGritter(titulo,descripcion,imagen){
		$.gritter.add({
			// (string | mandatory) the heading of the notification
			title: titulo,
			// (string | mandatory) the text inside the notification
			text: descripcion,
			// (string | optional) the image to display on the left
			image: imagen,
			// (bool | optional) if you want it to fade out on its own or just sit there
			sticky: false,
				// (int | optional) the time you want it to be alive for before fading out
			time: '',
			// (string | optional) the class name you want to apply to that specific message
			class_name: 'my-sticky-class'
		});
	}
	//*****FIN GRITTER*****	
</script>

<!-- Add fancyBox JS -->
<script type="text/javascript" src="<?php echo $RAIZj ?>fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo $RAIZj ?>fancybox/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo $RAIZj ?>fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php echo $RAIZj ?>fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="<?php echo $RAIZj ?>fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.fancybox').fancybox({'autoSize':true});
});
</script>