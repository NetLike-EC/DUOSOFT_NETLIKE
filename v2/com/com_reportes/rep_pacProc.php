<?php include('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('RPPP');
include(RAIZf."_head.php");?>
<?php include(RAIZm.'mod_navbar/mod.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Home</a></li>
    <li><a href="<?php echo $RAIZc ?>com_reportes">Reports</a></li>
    <li class="active">Contacts Source</li>
</ul>
<div class="container">
	<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']) ?>
	<?php fnc_log(); ?>
	<div class="well well-sm"><?php include('rep_pacProc_fra.php'); ?></div>
	<div><?php include('rep_pacProc_list.php'); ?></div>
</div>
<?php include(RAIZf.'_foot.php')?>