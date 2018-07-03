<?php include('../../init.php');
$dM=vLogin('TERAPY');
$_SESSION['MODSEL']="EMP";
$_SESSION['DIRSEL']="empleados_gest.php";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genPageHead($dM['mod_cod']) ?>
    <?php include('terapias_list.php'); ?>
    <?php include(RAIZm.'mod_taskbar/_taskbar_terapista.php'); ?>
</div>
<?php include(RAIZf.'footer.php'); ?>