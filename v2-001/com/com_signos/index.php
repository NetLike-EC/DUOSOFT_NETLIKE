<?php include('../../init.php');
$dM=vLogin('SIGVIT');
include(RAIZf."head.php"); ?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genPageHead($dM['mod_cod']) ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>
	<div><?php include('signos_list.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php');?>