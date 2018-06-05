<?php include('../../init.php');
loginN(); 
$mSel='mComFac';
$_SESSION['MODSEL']="COMF";//Variable para identificar el MODULO en el que se encuentra
$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php'); ?>
<div class="page-container row-fluid">
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<div class="page-content">
		<?php include(RAIZm.'mod_portlet/index.php'); ?>
		<?php include('_c_facturas.php'); ?>
       </div>
</div>
</body>
</html>