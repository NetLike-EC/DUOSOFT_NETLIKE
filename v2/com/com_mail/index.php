<?php require('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('MAILCE');
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<div class="container">
<div class="page-header">
<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
</div>
<?php fnc_log(); ?>
<div class="row">
    	<div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_mail/index_mess.php">
            <i class="fa fa-comment fa-4x"></i><h4>Messages</h4></a>
        </div>
    	<div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_mail/all_data.php">
            <i class="fa fa-table fa-4x"></i><h4>All Data</h4></a>
        </div>
    	<div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_mail/mail_list.php">
            <i class="fa fa-list fa-4x"></i><h4>Mail List</h4></a>
        </div>
        <div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_mail/mail_exception.php">
            <i class="fa fa-ban fa-4x"></i><h4>Mail Exception</h4></a>
        </div>
    </div>
    <hr>
	<div class="row">
    	<div class="col-sm-12">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_mail/campaign.php">
            <i class="fa fa-envelope fa-4x"></i><h4>Mail Campaign</h4></a>
        </div>
    </div>
    <hr>
	<div class="panel panel-info">
    <div class="panel-heading">Herramientas</div>
    <div class="row">
    	<div class="col-sm-2">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_mail/cleanMails.php">
            <i class="fa fa-envelope fa-4x"></i><h4>Clean Mails</h4></a>
        </div>
    </div>
	</div>
</div>
<?php include(RAIZf.'_foot.php') ?>