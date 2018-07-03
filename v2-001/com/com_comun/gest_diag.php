<?php require('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$detDiag=detRow('db_diagnosticos','id_diag',$id);
if($detDiag){
	$id=$detDiag['id_diag'];
	$action='UPD';
	$btn_action='<button type="submit" class="btn btn-success btn-large"><span class="glyphicon glyphicon-floppy-save"></span> Modificar Diagnostico</button>';
	$btn_new='<a href="'.$_SESSION['urlc'].'" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Nuevo Diagnostico</a>';
}else{
	$action='INS';
	$btn_action='<button type="submit" class="btn btn-primary btn-large"><span class="glyphicon glyphicon-floppy-save"></span> Grabar Diagnostico</button>';
}

$qry='SELECT * FROM db_diagnosticos ORDER BY id_diag DESC';
$RSd=mysql_query($qry);
$row_RSd=mysql_fetch_assoc($RSd);
$tr_RSd=mysql_num_rows($RSd);
$css['body']='cero';
include(RAIZf.'head.php') ?>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Diagnosticos</a>
    </div>
  </div><!-- /.container-fluid -->
</nav>


<div class="container">
	<?php sLOG('g'); ?>
	<div class="well well-sm">
	<form method="post" action="_fncts.php" class="form-inline" role="form">
		<div class="form-group">
			<input name="codigo" type="text" autofocus class="form-control" id="codigo" placeholder="Codigo Internacional" value="<?php echo $detDiag['codigo']?>" maxlength="10">
		</div>
        <div class="form-group">
		  <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre Diagnostico" value="<?php echo $detDiag['nombre']?>" maxlength="100" required>
		</div>
        <div class="form-group">
		  <input name="form" type="hidden" id="form" value="fdiag">
			<input name="id" type="hidden" id="id" value="<?php echo $id?>">
			<input name="action" type="hidden" id="action" value="<?php echo $action?>">
			<?php echo $btn_action ?>
            <?php echo $btn_new ?>
		</div>
	</form>
	</div>
<?php if ($tr_RSd>0){ ?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th>ID</th>
			<th>Codigo</th>
			<th>Nombre</th>
			<th><abbr title="Consultas relacionadas">Consultas</abbr></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php do{?>
		<tr>
			<td><?php echo $row_RSd['id_diag'] ?></td>
			<td><?php echo $row_RSd['codigo'] ?></td>
			<td><?php echo $row_RSd['nombre']?></td>
			<td><?php echo fnc_numdiagcon($row_RSd['id_diag']) ?></td>
			<td><div class="btn-group">
				<a href="<?php echo $_SESSION['urlc'] ?>?id=<?php echo $row_RSd['id_diag'] ?>" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i> Modificar</a>
				<a href="_fncts.php?id=<?php echo $row_RSd['id_diag'] ?>&action=DEL" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
			</div></td>
		</tr>
	<?php } while ($row_RSd = mysql_fetch_assoc($RSd));?>
	</tbody>
	</table>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Diagnosticos Generados</h4></div>'; }?>
</div>
<?php include(RAIZf.'footer.php') ?>