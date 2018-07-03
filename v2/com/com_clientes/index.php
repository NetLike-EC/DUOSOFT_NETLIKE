<?php include('../../init.php');
$dM=vLogin('CLI');
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');
$btnNew=genLink('form.php',$cfg[i]['new'].$cfg[b]['new'],$css='btn btn-primary');
//var_dump($dM);
?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/"><?php echo $cfg[t][home] ?></a></li>
    <li class="active"><?php echo $dM[nom] ?></li>
</ul>
<div class="container">
	<?php echo genPageHeader($dM[id],'header','h1',NULL,NULL,$btnNew); ?>
	<div class="well well-sm"><?php include('fra_find.php'); ?></div>
	<div><?php include('list.php'); ?></div>
</div>
<?php include(RAIZm.'mod_taskbar/taskb_clientes.php'); ?>
<?php include(RAIZf.'footer.php');?>