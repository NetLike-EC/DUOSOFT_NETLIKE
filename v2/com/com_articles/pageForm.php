<?php include('../../init.php');
$dM=vLogin('BLOGP');
include(RAIZf.'_head.php');
include(RAIZm.'mod_menu/menuMain.php') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/"><?php echo $cfg[t][home] ?></a></li>
    <li><a href="<?php echo $RAIZc ?>com_articles/"><?php echo $cfg[com_art][content] ?></a></li>
    <li><a href="<?php echo $RAIZc ?>com_articles/page.php"><?php echo $dM[nom] ?></a></li>
    <li class="active"><?php echo $cfg[t][form] ?></li>
</ul>
<div class="container">
	<?php sLOG('g'); ?>
	<?php require('_pageForm.php') ?>
</div>
<?php include(RAIZf.'_foot.php') ?>