<?php include('../../init.php');
fnc_accesslev("1,2,3");
$_SESSION['MODSEL']="TINF";
include(RAIZf."head.php");?>
<body>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo gen_pageTit($_SESSION['MODSEL']) ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>
	<div><?php include('_index.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php')?>