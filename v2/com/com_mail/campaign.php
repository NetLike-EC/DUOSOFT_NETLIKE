<?php require('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL'] = 'MAILCA';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<?php sLOG('g') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/">Home</a></li>
   	<li><a href="<?php echo $RAIZc ?>com_mail/">Contact Center</a></li>
    <li class="active">List Mail Campaign</li>
</ul>

<div class="container">
	<div class="page-header">
		<div class="btn-group pull-right">
		<a href="campaignForm.php" class="btn btn-primary"><i class="fa fa-plus"></i> New Mail Campaign</a>
		</div>
		<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
	</div>
	<?php include('_campaign.php') ?>
</div>
<?php include(RAIZf.'_foot.php') ?>