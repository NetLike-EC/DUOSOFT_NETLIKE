<?php include('../../init.php');
loginN();
$mSel='mInvCat';
$_SESSION['MODSEL']="INVC";
$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php');?>
<div class="page-container row-fluid">
	<!-- BEGIN SIDEBAR -->
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<!-- END SIDEBAR -->
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<?php include(RAIZm.'mod_portlet/index.php'); ?>
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE -->
		<?php include('_c_form_cat.php'); ?>
		<!-- END PAGE -->
       </div>
</div>
</body>
</html>