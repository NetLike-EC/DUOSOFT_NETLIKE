<?php include('../../init.php');
//fnc_accesslev("1,2,3");
$_SESSION['MODSEL']="TYP";
include(RAIZf."head.php");?>
<body>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container-fluid">
	<?php echo gen_pageTit($_SESSION['MODSEL']) ?>
	<div><?php include('_index.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php')?>