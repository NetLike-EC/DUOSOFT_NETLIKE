<?php require('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL'] = 'MAILCA';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/">Home</a></li>
    <li><a href="<?php echo $RAIZc ?>com_mail/">Contact Center</a></li>
    <li><a href="<?php echo $RAIZc ?>com_mail/campaign.php">List Mail Campaign</a></li>
    <li class="active">Form Campaign</li>
</ul>
<?php sLOG('g') ?>
<div class="container">
	<?php include('_campaignForm.php') ?>
</div>
<?php include(RAIZf.'_foot.php');?>