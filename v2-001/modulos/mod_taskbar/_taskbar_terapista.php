<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-7">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">Terapias por realizar</a>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
     <div class="collapse navbar-collapse" id="nav_taskb">
      <a class="btn btn-primary navbar-btn" onClick="loadFancyBoxcalendario()">Revisar Agenda</a>
</nav>

<script>

function loadFancyBoxcalendario(){
	//alert("OK");
	$.fancybox({
		type: 'iframe',
		href: '../com_calendar_terapias/',
		title: 'Calendario',
		preload  : true,
		autoSize : false,
		width    : "100%",
		height   : "100%",
		beforeClose: function() {
			location.reload();					
   		}
	});
};
</script>