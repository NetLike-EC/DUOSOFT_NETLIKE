<?php include('../../init.php');
fnc_accesslev("1,2,3");
$_SESSION['MODSEL']="ECOO";
include(RAIZf."head.php");?>
<body>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container-fluid">
	<div><?php include('_obs_list_gest.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php')?>