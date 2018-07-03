<?php include('../../init.php');
$dM=vLogin('BLOGC');
include(RAIZf.'_head.php');
include(RAIZm.'mod_menu/menuMain.php') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/">Inicio</a></li>
    <li><a href="<?php echo $RAIZc ?>com_articles/">Content</a></li>
    <li><a href="<?php echo $RAIZc ?>com_articles/cat.php">Blog Categories</a></li>
    <li class="active">Edit Blog Category</li>
</ul>
<div class="container">
	<?php sLOG('g') ?>
	<?php require('_catForm.php') ?>
</div>
<?php include(RAIZf.'_foot.php'); ?>