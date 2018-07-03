<?php require('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('REP');
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Home</a></li>
    <li class="active">REPORTS</li>
</ul>
<div class="container">
<div class="page-header">
<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
</div>
<?php fnc_log(); ?>
<div class="row">
    	<div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_reportes/rep_pacProc.php">
            <i class="fa fa-user fa-4x"></i><h4>Contacts Source</h4></a>
        </div>
        <div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_reportes/rep_prods-mercousaForm.php">
            <i class="fa fa-user fa-4x"></i><h4>Migrate to Merco USA</h4></a>
        </div>
    	
    </div>
<br>	
	<div class="panel panel-info">
    <div class="panel-heading">Tools</div>
    <div class="panel-body">No Tools</div>
	</div>
</div>
<?php include(RAIZf.'_foot.php'); ?>