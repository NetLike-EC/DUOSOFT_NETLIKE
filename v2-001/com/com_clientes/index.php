<?php include('../../init.php');
$dM=vLogin('CLIENTE');
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genPageHead($dM['mod_cod'])?>
	<div class="well well-sm"><?php include('fra_cliFind.php'); ?></div>
	<div><?php include('clientes_list.php'); ?></div>
</div>
<?php include(RAIZm.'mod_taskbar/taskb_clientes.php'); ?>
<?php include(RAIZf.'footer.php');?>