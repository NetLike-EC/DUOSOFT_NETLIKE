<?php include('../../init.php');
$dM=vLogin('INVT');
include(RAIZf.'_head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZ ?>">Home</a></li>
	<li><a href="<?php echo $RAIZc ?>com_inventario/">Inventory</a></li>
	<li><a href="<?php echo $RAIZc ?>com_inventario/invCat.php">Categories</a></li>
	<li class="active">Edit</li>
</ul>
<?php sLOG('g'); ?>
<div class="container">
	<?php include('_invCatForm.php'); ?>
</div>
<?php include(RAIZf.'_foot.php');?>