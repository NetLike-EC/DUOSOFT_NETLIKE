<?php include('../../init.php');
$dM=vLogin('COMPONENTE');
include(RAIZf.'_head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/"><?php echo $cfg[t][home] ?></a></li>
	<li><a href="<?php echo $RAIZc ?>com_modulos/"><?php echo $dM[nom] ?></a></li>
	<li class="active"><?php echo $cfg[t][form] ?></li>
</ul>
<?php sLOG('g'); ?>
<div class="container">
	<?php require('_form.php') ?>
</div>
<?php include(RAIZf.'_foot.php'); ?>