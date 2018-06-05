<?php include('../../init.php');
loginN();
$mSel='mEgreso';
$_SESSION['MODSEL']="VEN";
if($_SESSION['stat_proc']=="SAVED"){
	$_SESSION['stat_proc']='PROCESS';
	header('Location: '.$RAIZc.'com_ventas');
}else{
	$_SESSION['stat_proc']='PROCESS';
	$rowMod=detMod($_SESSION['MODSEL']);
	include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php'); ?>
<div class="page-container row-fluid">
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<div class="page-content">
		<?php include(RAIZm.'mod_portlet/index.php'); ?>
		<?php include ('_c_egreso.php') ?>
	</div>
</div>
</body>
</html>
<?php } ?>