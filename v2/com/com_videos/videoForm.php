<?php require('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('MVID');
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/">Home</a></li>
	<li><a href="<?php echo $RAIZc ?>com_videos/">Video Center</a></li>
	<li class="active">Edit / Create</li>
</ul>
<div class="container">
<div class="page-header">
<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
</div>
<?php sLOG('g'); ?>
<?php include('_videoForm.php'); ?>
</div>
<?php include(RAIZf.'_foot.php') ?>