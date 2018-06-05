<?php require('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$detMed=detRow('db_medicamentos','id_form',$id);
if($detMed){
	$id=$detMed['id_form'];
	$action='UPD';
	$btn_action='<button type="submit" class="btn btn-success btn-large"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
}else{
	$action='INS';
	$btn_action='<button type="submit" class="btn btn-primary btn-large"><i class="fa fa-floppy-o fa-lg"></i> CREAR</button>';
}

$qry='SELECT * FROM db_medicamentos ORDER BY id_form DESC';
$RSd=mysql_query($qry);
$row_RSd=mysql_fetch_assoc($RSd);
$tr_RSd=mysql_num_rows($RSd);
include(RAIZf.'head.php');
?>
<body class="cero">
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
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
      <a class="navbar-brand" href="#">Medicamentos</a>
    </div>
  </div><!-- /.container-fluid -->
</nav>


<div class="container-fluid">
	<?php sLOG('g'); ?>
	<div class="well well-sm">
	<form method="post" action="actions.php" role="form">
    <fieldset>
        <input name="form" type="hidden" id="form" value="fmed">
        <input name="id" type="hidden" id="id" value="<?php echo $id?>">
        <input name="action" type="hidden" id="action" value="<?php echo $action?>">
    </fieldset>
    <div class="row">
    <div class="col-sm-6"><fieldset class="form-horizontal">
    <div class="form-group">
    	<label for="generico" class="col-sm-2 control-label">Medicamento</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-6">
            <input name="generico" type="text" class="form-control" id="generico" placeholder="Generico" value="<?php echo $detMed['generico'] ?>" required></div>
			<div class="col-sm-6">
            <input name="comercial" type="text" class="form-control" id="comercial" placeholder="Comercial" value="<?php echo $detMed['comercial'] ?>"></div>
		</div>
	</div>
	</div>
	<div class="form-group">
    	<label for="presentacion" class="col-sm-2 control-label">Información</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-8"><input name="presentacion" type="text" class="form-control" id="presentacion" placeholder="Presentación" value="<?php echo $detMed['presentacion'] ?>"></div>
			<div class="col-sm-4"><input name="cantidad" type="number" class="form-control" id="cantidad" placeholder="Cantidad" value="<?php echo $detMed['cantidad'] ?>"></div>
		</div>
    </div>
	</div>
    </fieldset></div>
    <div class="col-sm-3"><fieldset class="form-horizontal">
    
    <div class="form-group">
    	<label for="descripcion" class="col-sm-2 control-label">RP.</label>
    	<div class="col-sm-10">
    	<textarea name="descripcion" rows="3" class="form-control" id="descripcion"><?php echo $detMed['descripcion'] ?></textarea>
    	</div>
	</div>
    </fieldset></div>
    <div class="col-sm-3"><fieldset class="form-horizontal">
    <div class="form-group">
    	<label for="" class="col-sm-2 control-label"></label>
    	<div class="col-sm-10">
    	<?php echo $btn_action ?>
    	<a href="<?php echo $_SESSION['urlc']?>" class="btn btn-default navbar-btn"><i class="fa fa-plus"></i> NUEVO</a>
    	</div>
	</div>
    </fieldset></div>
    </div>
            
	</form>
	</div>
<?php if ($tr_RSd>0){ ?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th>ID</th>
			<th>Generico</th>
			<th>Comercial</th>
            <th>Presentacion</th>
            <th>Cantidad</th>
            <th style="width:35%">Prescripción</th>
			<th><abbr title="Consultas relacionadas">Recetas</abbr></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php do{?>
		<tr>
			<td><?php echo $row_RSd['id_form'] ?></td>
			<td><?php echo $row_RSd['generico'] ?></td>
			<td><?php echo $row_RSd['comercial']?></td>
            <td><?php echo $row_RSd['presentacion']?></td>
            <td><?php echo $row_RSd['cantidad']?></td>
            <td><?php echo $row_RSd['descripcion']?></td>
			<td><?php echo totRowsTab('db_tratamientos_detalle','id_form',$row_RSd['id_form']) ?></td>
			<td>
				<a href="<?php echo $_SESSION['urlc'] ?>?id=<?php echo $row_RSd['id_form'] ?>" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i> Modificar</a>
				<a href="actions.php?id=<?php echo $row_RSd['id_form'] ?>&action=DEL" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
			</td>
		</tr>
	<?php } while ($row_RSd = mysql_fetch_assoc($RSd));?>
	</tbody>
	</table>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Diagnosticos Generados</h4></div>'; }?>
</div>
</body>
</html>