<?php include('../_config.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
  $_SESSION['MODSEL']="EMP";
  $_SESSION['DIRSEL']="empleados_gest.php";
}else{
	$_SESSION['singleBirdRemote']="";
}
?>
<?php include(RAIZ."/frames/_head.php"); ?>
<?php $rowMod=detMod($_SESSION['MODSEL']); ?>
<body>
<div id="generalcont">
    <div id="headcont"><?php include(RAIZ.'/frames/_fra_top_min.php'); ?></div>
    <div id="middlecont">
        <div id="head_sec"><a href="#"><?php echo strtoupper($rowMod['mod_des']); ?></a></div>
        <div id="middle_find"><?php include('empleados_find.php'); ?></div>
        <div id="middle_find"><?php include('empleados_list.php'); ?></div>
    </div>
    <?php include(RAIZ.'modulos/taskbar/_taskbar_empleado.php'); ?>
    <div id="bottomcont"><?php include(RAIZ.'frames/_fra_bottom.php'); ?></div>
</div>
</body>
</html>