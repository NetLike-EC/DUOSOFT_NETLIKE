<?php

?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo $RAIZc?>com_index/index.php">FREIMO</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
		<li><a href="<?php echo $RAIZc?>com_index/index.php"><i class="fa fa-home fa-lg"></i></a></li>
		<li><a href="<?php echo $RAIZc?>com_calendar/"><i class="fa fa-calendar fa-lg"></i></a></li>
        <li><a href="<?php echo $RAIZc?>com_pacientes/">Pacientes</a></li>
		<li><a href="<?php echo $RAIZc?>com_consultas/">Consultas</a></li>
		<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Historia<b class="caret"></b></a>
        	
			<ul class="dropdown-menu">
				<li><a href="<?php echo $RAIZc?>com_signos/">Signos Vitales</a></li>
                <li><a href="<?php echo $RAIZc?>com_examen/">Examenes</a></li>
                <li><a href="<?php echo $RAIZc?>com_reps/obs_list_gen.php">Reportes Obstetricos</a></li>
                <li><a href="<?php echo $RAIZc?>com_reps/gin_list_gen.php">Reportes Ginecologicos</a></li>
                <li><a href="<?php echo $RAIZc?>com_cirugia/">Cirugias</a></li>
                <li><a href="<?php echo $RAIZc?>com_tinf/">Tratamientos Infertilidad</a></li>
			</ul>
            
		</li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes<b class="caret"></b></a>
        	
			<ul class="dropdown-menu">
				<li><a href="<?php echo $RAIZc?>com_reportes/rep_pacProc.php">Reporte Origen Pacientes</a></li>
			</ul>
            
		</li>
	</ul>
    <ul class="nav navbar-nav navbar-right">
		<li><a><div id="logF"></div></a></li>
        <li><a href="#"><div id="loading"><img src="<?php echo $RAIZa ?>images/struct/loader.gif"/></div></a></li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Sistema<span class="glyphicon glyphicon-cog"></span></a>
			<ul class="dropdown-menu">
				
                <li><a href="<?php echo $RAIZc?>com_empleados/empleados_gest.php">Talento Humano</a></li>
				<li><a href="<?php echo $RAIZc?>com_usersystem/users_gest.php">Usuarios</a></li>
				<li class="divider"></li>
                <!--
                <li><a href="<?php echo $RAIZc?>com_comun/gest_diag.php" class="fancybox fancybox.iframe fancyreload">Diagnosticos</a></li>
                -->
                <li><a href="<?php echo $RAIZc?>com_tratamientos/gest_tratamiento.php" class="fancybox fancybox.iframe fancyreload">Tratamientos</a></li>
                <li><a href="<?php echo $RAIZc?>com_terapistas/gest_terapistas.php" class="fancybox fancybox.iframe fancyreload">Terapistas</a></li>
                <!--
                <li class="divider"></li>
				<li><a href="<?php echo $RAIZc?>com_mandb/mant_docsformat.php" class="fancybox fancybox.iframe fancyreload">Mantenimiento Documentos Formato</a></li>
                <li><a href="<?php echo $RAIZc?>com_mandb/mant_tbl_types.php" class="fancybox fancybox.iframe fancyreload">Mantenimiento Types</a></li>
                <li><a href="<?php echo $RAIZc?>com_mandb/man_db_clientes_fecr.php" class="fancybox fancybox.iframe fancyreload">Mantenimiento Fecha Registro Paciente</a></li>
                -->
			</ul>
			</li>
      
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $detEmp_fullname ?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo $RAIZc?>com_usersystem/user_perfil.php">Informacion Usuario</a></li>
		  <li><a href="<?php echo $RAIZc?>com_usersystem/changePass.php" class="fancybox fancybox.iframe fancyreload">Cambiar Contraseña</a></li>
		  <li class="divider"></li>
		  <li><a href="<?php echo $RAIZ; ?>logout.php">Salir</a></li>          
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>