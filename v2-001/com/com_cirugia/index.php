<?php include('../../init.php');
$dM=vLogin('CIRUGIA');
include(RAIZf."head.php");?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genPageHead($dM['mod_cod']) ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>
	<div><?php include('_index.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php');?>