<?php include('../../init.php');
$dM=vLogin('USERS');
include(RAIZf.'head.php') ?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<script type="text/javascript" src="js.js"></script>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Home</a></li> 
	<li><a href="<?php echo $RAIZc ?>com_usersystem">Users</a></li> 
</ul>
<div class="container">
	<div class="btn-group pull-right">
    	<a class="btn btn-default" href="form.php"><i class="fa fa-plus fa-lg"></i> NEW</a>
    </div>
	<?php echo genPageHead($dM['mod_cod']); ?>
    <?php sLOG('g'); ?>
    <div><?php include('users_list.php'); ?></div>  
</div>
<?php include(RAIZf.'footer.php'); ?>