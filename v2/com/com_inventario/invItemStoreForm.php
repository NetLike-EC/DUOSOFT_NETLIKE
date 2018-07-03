<?php include('../../init.php');
fnc_accessnorm();
$rowMod=detRow('tbl_modules','mod_ref','INVP');
$cssBody='cero';
include(RAIZf.'_head.php');
include('_invItemStoreForm.php');
include(RAIZf.'_foot.php');?>