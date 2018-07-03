<?php include('../../init.php');
$dM=vLogin('INVI');
include(RAIZf.'_head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZ ?>">Home</a></li>
	<li><a href="<?php echo $RAIZc ?>com_inventario/">Inventory</a></li>
	<li><a href="<?php echo $RAIZc ?>com_inventario/invItem.php">Products</a></li>
	<li class="active">Edit</li>
</ul>
<?php sLOG('g'); ?>
<div class="container">
	<?php include('_invItemForm.php') ?>
</div>
<?php include(RAIZf.'_foot.php');?>