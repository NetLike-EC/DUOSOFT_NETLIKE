<?php require('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('MVID');
include(RAIZf.'_head.php'); ?>
<?php include(RAIZf.'_fra_top_min.php') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/">Home</a></li>
	<li><a href="<?php echo $RAIZc ?>com_multimedia/">Multimedia</a></li>
	<li class="active">Video Center</li>
</ul>
<div class="container">
<div class="page-header">
<div class="row">
	<div class="col-md-8"><?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?></div>
    <div class="col-md-4 text-right"><a href="videoForm.php" class="btn btn-primary btn-sm"><i class="fa fa-plus fa-lg"></i> NEW</a></div>
    
</div>
</div>
<?php sLOG('g'); ?>
<?php include('_index.php') ?>
</div>
<?php include(RAIZf.'_foot.php'); ?>