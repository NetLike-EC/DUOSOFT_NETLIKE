<?php include('../../init.php');
$dM=vLogin('COMPONENTE');
include(RAIZf.'_head.php');
include(RAIZm.'mod_menu/menuMain.php') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/"><?php echo $cfg[t][home] ?></a></li>
	<li class="active"><?php echo $dM[nom] ?></li>
</ul>
<div class="container">
	<?php include('_index.php'); ?>
</div>
<?php include(RAIZf.'_foot.php')?>