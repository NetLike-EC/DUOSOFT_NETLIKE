<?php include('../../init.php');
loginN(); 
$mSel='mConAnu';
$_SESSION['MODSEL']="ACOM";//Variable para identificar el MODULO en el que se encuentra
$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php'); ?>
<div class="page-container row-fluid">
	<!-- BEGIN SIDEBAR -->
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<!-- END SIDEBAR -->
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<?php include(RAIZm.'mod_portlet/index.php'); ?>
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE -->
		<?php include('_c_anulacion.php'); ?>
		<!-- END PAGE -->
       </div>
</div>
</body>
</html>