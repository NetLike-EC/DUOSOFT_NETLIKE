<?php include('../../init.php');
$dM=vLogin('USERS');
include(RAIZf."_head.php");
include(RAIZm.'mod_menu/menuMain.php');
sLOG('g') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li> 
	<li><a href="<?php echo $RAIZc ?>com_usersystem">Usuarios</a></li>
    <li class="active">Formulario</li>
</ul>
<div class="container">
	<?php require('_form.php') ?>
</div>
<?php include(RAIZf.'_foot.php')?>