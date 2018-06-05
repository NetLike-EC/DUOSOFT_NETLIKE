<?php include('../../init.php');
loginN(); 
$mSel='mComFac';
$_SESSION['MODSEL']="COMF";//Variable para identificar el MODULO en el que se encuentra
$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<div class="page-container row-fluid">
	<div class="page-content">
		<?php include('_c_form-fac.php'); ?>
       </div>
</div>
</body>
</html>