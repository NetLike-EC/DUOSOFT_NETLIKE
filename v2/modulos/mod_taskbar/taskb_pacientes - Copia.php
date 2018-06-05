<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-7">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">PACIENTES</a>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse">
		<a href="<?php echo $RAIZ; ?>com/com_pacientes/form.php" class="btn btn-primary navbar-btn"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Paciente</a>
		<p class="navbar-text navbar-right">Total Pacientes <strong><?php echo fnc_totpac();?></strong></p>
	</div><!-- /.navbar-collapse -->
</nav>