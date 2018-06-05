<?php include('../../init.php');
loginN();
$mSel='mComIng';
$_SESSION['MODSEL']="COM";
if($_SESSION['stat_proc']=="SAVED"){
	$_SESSION['stat_proc']='PROCESS';
	header('Location: '.$RAIZc.'com_compras');
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
		<?php include ('_c_compra_form.php') ?>
	</div>
</div>
</body>
</html>
<?php } ?>