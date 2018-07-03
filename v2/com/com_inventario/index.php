<?php require('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('INV');
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<div class="container">
<?php fnc_log(); ?>
<div class="page-header">
<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
</div>
<?php include('_index.php') ?>
</div>
<?php include(RAIZf.'_foot.php') ?>