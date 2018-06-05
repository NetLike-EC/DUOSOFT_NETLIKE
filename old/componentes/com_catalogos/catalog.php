<?php include('../../init.php');
loginN(); 
$mSel='mCtlGen';
$_SESSION['MODSEL']="CTL";
$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php'); ?>
<div class="page-container row-fluid">
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<div class="page-content">
		<?php
        $viewContPanel=TRUE;
		include('_c_catalog.php'); ?>
	</div>
</div>
</body>
</html>