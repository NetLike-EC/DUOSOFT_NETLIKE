<?php include('../../init.php');
fnc_accesslev("1,2,3");
$_SESSION['MODSEL']="EXA";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
include(RAIZf."head.php");
sLOG('g');?>
<body>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
    <div><?php include('_gest.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php')?>