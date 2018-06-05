<div class="container-fluid">
	<div class="row-fluid">
		<div class="span8">
		<h3 class="page-title"><?php echo $rowMod['mod_nom']; ?> <small><?php echo $rowMod['mod_des']; ?></small></h3>
		</div>
		<div class="span4 text-right">
			<a href="?singleBirdRemote=+" class="btn blue big"><strong><?php echo fnc_TotCli() ?></strong> Clientes <i class="icon-user"></i></a>
			<a href="clientes_form.php" class="btn big green"><i class="icon-plus"></i> Nuevo</a>
		</div>
	</div>
    <div class="well well-small"><?php include('_fra_cli_find.php'); ?></div>
    <div><?php include('_fra_cli_list.php'); ?></div>
</div>