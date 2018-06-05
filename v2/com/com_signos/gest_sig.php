<?php require_once('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$detPac=dPac($id);
$detSig=detRow('db_signos','id',$ids);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
if($detPac['pac_fec']) $detPac_fec=edad($detPac['pac_fec']).'Años';
if($detSig){
	$acc='UPD';
	$btnAcc='<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
}else{
	$acc='INS';
	$btnAcc='<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg"></i> GRABAR</button>';
}
include(RAIZf.'head.php');
?>
<body>
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
      <a class="navbar-brand" href="#">SIGNOS VITALES</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><?php echo $detPac_nom ?></a></li>
        <li><a><?php echo $detPac_fec ?></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php if($detPac){
$qry='SELECT * FROM db_signos WHERE pac_cod='.$id.' ORDER BY id DESC';
$RSh=mysql_query($qry);
$row_RSh=mysql_fetch_assoc($RSh);
$tr_RSh=mysql_num_rows($RSh);
?>
<?php echo sLOG('g') ?>
<div class="container-fluid">
<form method="post" action="actions.php">
	<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
    <input name="ids" type="hidden" id="ids" value="<?php echo $ids ?>">
	<input name="form" type="hidden" id="form" value="hispac">
    <input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
	<div class="row">
    	<div class="col-md-10">
        <fieldset class="form-inline well well-sm">
        <div class="form-group">
        	<span class="help-block"><small>Peso en Kilogramos</small></span>
            <input name="hpeso" type="number" step="any" class="form-control input-sm" id="hpeso" placeholder="Peso en Kg." value="<?php echo $detSig['peso'] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Talla en centimetros</small></span>
            <input name="htalla" type="number" step="any" class="form-control input-sm" id="htalla" placeholder="Talla en cm." value="<?php echo $detSig['talla'] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Índice de Masa Corporal</small></span>
            <input name="himc" type="number" step="any" class="form-control input-sm" id="himc" placeholder="Indice de Masa Corporal" value="<?php echo $detSig['imc'] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Presión Arterial</small></span>
            <input name="hpa" type="text" class="form-control input-sm" id="hpa" placeholder="Presion Arterial" value="<?php echo $detSig['pa'] ?>">
        </div>
        </fieldset>
        </div>
        <div class="col-md-2"><?php echo $btnAcc ?></div>  
    </div>
</form>
<?php if ($tr_RSh>0){ ?>
	<div>
	  <table class="table table-striped table-bordered">
        <thead>
        <tr>
        	<th>ID</th>
            <th>Fecha</th>
            <th>Peso</th>
			<th>Talla</th>
            <th>IMC</th>            
            <th>PA</th>
            <th></th>
		</tr>
        </thead>
        <tbody>
        <?php do{
		$pesoKG=$row_RSh['peso'].' Kg.';
		$pesoLB=round($row_RSh['peso']*2.20462262, 2);
		$pesoLB.=' Lb.';
		$tallaCM;
		$tallaPL;
		if($row_RSh['talla']){
			$tallaCM=$row_RSh['talla'].' Cm';
			$tallaPL=round($row_RSh['talla']/2.54, 2);
			$tallaPL.=' "';
			$tallaM=$tallaCM/100;
		} 
		
		$IMC=$row_RSh['imc'];
		$IMC=calcIMC($IMC,$pesoKG,$tallaCM);
		?>
        <tr>
        	<td><?php echo $row_RSh['id'] ?></td>
			<td><?php echo $row_RSh['fecha'] ?></td>
			<td><?php echo $pesoKG.' / '.$pesoLB?></td>
			<td><?php echo $tallaCM?></td>
			<td><?php echo $IMC['val'].' '.$IMC['inf']; ?></td>
			<td><?php echo $row_RSh['pa'] ?></td>
            <td>
            <a href="form.php?id=<?php echo $id ?>&ids=<?php echo $row_RSh['id'] ?>" class="btn btn-primary btn-xs">
            <i class="fa fa-edit"></i> Editar</a>
            <a href="actions.php?id=<?php echo $id ?>&idh=<?php echo $row_RSh['id'] ?>&action=DEL" class="btn btn-danger btn-xs">
            <i class="fa fa-trash-o"></i> Eliminar</a></td>
        </tr>
        <?php } while ($row_RSh = mysql_fetch_assoc($RSh));
		$rows = mysql_num_rows($RSh);
		if($rows > 0) {
			mysql_data_seek($RSh, 0);
			$row_RSh = mysql_fetch_assoc($RSh);
		}?>
        </tbody>
        </table>
    </div>
<?php }else{
	echo '<div class="alert alert-warning"><h4>No Existen Registros</h4></div>';
}?>
</div>
<?php mysql_free_result($RSh);
}else{ ?>
<div class="alert alert-warning"><h4>Paciente No Existe</h4></div>
<?php } ?>
<?php include(RAIZf.'footer.php') ?>