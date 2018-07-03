<?php include('../../init.php');
vLogin();
$dM=detRow('db_componentes','mod_ref','INI');
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');
sLOG("g",$_REQUEST['LOG']) ?>
<div class="container">
    <?php echo genPageHead($dM['mod_cod'])?>
    <div class="well well-sm">
		<?php include('_index.php') ?>
	</div>
</div>
<?php include(RAIZf."footer.php") ?>