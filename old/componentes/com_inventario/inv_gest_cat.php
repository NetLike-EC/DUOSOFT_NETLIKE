<?php include('../../init.php');
loginN();
$mSel='mInvCat';
$_SESSION['MODSEL']="INVC";
$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php');?>
<div class="page-container row-fluid">
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<div class="page-content">
		<?php include(RAIZm.'mod_portlet/index.php'); ?>
		<?php include('_c_gest_cat.php'); ?>
	</div>
</div>
</body>
</html>