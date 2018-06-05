<?php include('../../init.php');
$dM=vLogin('COMPONENTE');
$dC=detMod($dM['mod_cod']);
include(RAIZf.'head.php'); ?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php include('_c-index.php'); ?>
</div>
<?php include(RAIZf.'footer.php')?>