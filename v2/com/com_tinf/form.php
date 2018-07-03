<?php require('../../init.php');
$_SESSION['tab']['con']='cTINF';
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$id=vParam('id',$_GET['id'],$_POST['id']);
$action=vParam('action',$_GET['action'],$_POST['action']);
$detTI=detRow('db_tratamiento_infertilidad','id_ti',$id);//fnc_dataexam($ide);
if($id) {$idp=$detTI['cli_id']; $idc=$detTI['con_num'];}
if($action=='DELEF'){
	header(sprintf("Location: %s", '_fncts.php?id='.$id.'&action=DELEF'));
}
$detpac=detRow('db_clientes','cli_id',$idp);
$detcli_nom=$detpac['cli_nom'].' '.$detpac['cli_ape'];

if($detTI){
	$action='UPD';
	$dateTI=$detTI['date'];
	$btnform='<button type="submit" class="btn btn-success"><i class="fa fa-refresh fa-lg"></i> ACTUALIZAR</button>';
}else{
	$dateTI=$sdate;
	$action='INS';
	$btnform='<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg"></i> CREAR</button>';
}
include(RAIZf.'head.php');
?>
<body class="cero">
<form action="_fncts.php" method="post" id="formexam" enctype="multipart/form-data" style="margin-bottom:0px;">
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
      <a class="navbar-brand" href="#">TRATAMIENTO INFERTILIDAD</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li><a><span class="label label-info"><?php echo $ide ?></span></a></li>
        <li><a><?php echo $detcli_nom?></a></li>
        <li><a>Consulta: <span class="label label-default"><?php echo $idc ?></span></a></li>
        <li><a><?php echo $dateTI ?></a></li>
      </ul>
      <div class="navbar-right btn-group navbar-btn">
      <?php echo $btnform ?>
      <a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO</a>
      </div>
	</div>
</div>
</nav>
<div class="container-fluid">
<?php sLOG('g'); ?>
<fieldset>
			<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
            <input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
			<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
			<input name="action" type="hidden" id="action" value="<?php echo $action ?>">
			<input name="form" type="hidden" id="form" value="fti">
			</fieldset>

<div class="row">
	<div class="col-sm-6"><fieldset class="form-horizontal well well-sm">
		<div class="form-group">
        	<label class="control-label col-sm-3">Estado</label>
            <div class="com-sm-9 text-center">
                <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default btn-sm <?php if($detTI['status']=='1') echo ' active btn-primary '; ?>">
                <input type="radio" name="status" id="status1" value="ACT" <?php if($detTI['status']=='1') echo ' checked '; ?>> ACTIVO
                </label> 
                <label class="btn btn-default btn-sm <?php if($detTI['status']=='0') echo ' active btn-warning '; ?>">
                <input type="radio" name="status" id="status0" value="INA" <?php if($detTI['status']=='0') echo ' checked '; ?>> FINALIZADO
                </label>
                </div>
                </div>
            
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-3" for="date">Registro</label>
			<div class="col-sm-9">
            <input name="date" type="date" id="date" value="<?php echo $dateTI; ?>" class="form-control" disabled>
			</div>
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-3" for="datei">Fecha Inicio</label>
			<div class="col-sm-9">
            <input name="datei" type="date" id="datei" value="<?php echo $detTI['datei']; ?>" class="form-control">
			</div>
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-3" for="datef">Fecha Fin</label>
			<div class="col-sm-9">
            <input name="datef" type="date" id="datef" value="<?php echo $detTI['datef']; ?>" class="form-control">
			</div>
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-3" for="typ_cod">Tipo Tratamiento</label>
			<div class="col-sm-9">
            <?php genSelect('typ_cod',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TTINF'),$detTI['typ_cod'],' form-control '); ?>
			</div>
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-3" for="datef">Donante</label>
			<div class="col-sm-9">
            <input name="don" type="text" id="don" value="<?php echo $detTI['donante']; ?>" class="form-control">
			</div>
		</div>
		<div class="form-group">
        	<label class="control-label col-sm-3" for="des">Observaciones</label>
			<div class="col-sm-9">
			<textarea name="des" rows="4" class="form-control" id="des" placeholder="Detalles del Tratamiento"><?php echo $detTI['des'] ?></textarea>
			</div>
		</div>
        
    </fieldset></div>
    <div class="col-sm-6">	
<div class="well well-sm">
<?php if($detTI){
	$qryfc=sprintf('SELECT * FROM db_tratamiento_infertilidad_media WHERE id_ti=%s ORDER BY id DESC',
	SSQL($id,'int'));
	$RSfc=mysql_query($qryfc);
	$row_RSfc=mysql_fetch_assoc($RSfc);
	$tr_RSfc=mysql_num_rows($RSfc);
?>
<div class="well well-sm" style="background:#FFF">
	
    <textarea name="dfile" rows="2" class="form-control" id="dfile" placeholder="Descripcion de la Imagen"></textarea>
	<input name="efile[]" id="efile" type="file" onChange="uploadImage();" class="form-control" accept="image/gif, image/jpeg, image/png, image/bmp" multiple/>
</div>
<?php	if($tr_RSfc>0){ ?>



<div class="row">
	<?php do{ ?>
            <?php $detMedia=detRow('db_media','id_med',$row_RSfc['id_med']) ?>
        	
            
            
  <div class="col-sm-12">
    <div class="thumbnail">
      <img src="<?php echo $RAIZmdb?>tinf/<?php echo $detMedia['file'] ?>" alt="...">
      <div class="caption">
        <h3><?php echo $detMedia['des'] ?></h3>
        <p>
        <a href="<?php echo $RAIZmdb?>tinf/<?php echo $detMedia['file'] ?>" class="btn btn-primary btn-xs fancybox" role="button">
        <i class="fa fa-eye"></i> Ver</a> 
        <a href="_fncts.php?idtim=<?php echo $row_RSfc['id'] ?>&action=DELMTI&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs" role="button">
        <i class="fa fa-trash-o"></i> Eliminar</a>
        </p>
      </div>
    </div>
  </div>
  
	<?php }while ($row_RSfc = mysql_fetch_assoc($RSfc)); ?>
</div>


<ul class="thumbnails">
        	
        </ul>

<?php }else echo '<div class="alert alert-warning">No han guardado archivos de esta Cirugia</div>'; ?>

<?php }else echo '<div class="alert alert-warning"><h4>No se puede cargar archivos</h4>Aun No Se ha Guardado la Cirugia</div>';?>
</div>
</div>
</div>


</div>
</form>
<script type="text/javascript">
$('#descripcion').focus();
function uploadImage() { formexam.submit(); }
</script>
</body>
</html>