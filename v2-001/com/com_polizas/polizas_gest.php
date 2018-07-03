<?php include('../../init.php');
$_SESSION['MODSEL']="POL";
$_SESSION['DIRSEL']="polizas_gest.php";
$rowMod = fnc_datamod($_SESSION['MODSEL']);
include(RAIZf."head.php");
include(RAIZf.'fraTop.php'); ?>
<div class="container">
	<div class="page-header">
    	<h1><img src="<?php echo $RAIZi ?>struct/icon/pac-search.png"> <?php echo $rowMod['mod_nom']; ?>
        <small><?php echo $rowMod['mod_des']; ?></small></h1>
	</div>
    
    <div id="middlecont">
        <div id="middle_find"><?php include('polizas_find.php'); ?></div>
        <div id="middle_list"><?php include('../com_pacientes/pacientes_list.php'); ?></div>
    </div>
    <div id="bottomcont"><?php include(RAIZ.'frames/fraBot.php'); ?></div>
</div>
<?php include(RAIZ.'modulos/taskbar/_taskbar_pacientes.php'); ?>
</body>
</html>