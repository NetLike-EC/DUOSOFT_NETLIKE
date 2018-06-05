<?php require('../../init.php');
$_SESSION['tab']['con']='cCIR';
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$idr=vParam('idr',$_GET['idr'],$_POST['idr']);
$detCir=detRow('db_cirugias','id_cir',$idr);
if($idr) {$idp=$detCir['pac_cod']; $idc=$detCir['con_num'];}
$detpac=detRow('db_clientes','pac_cod',$idp);
if($detCir){
	$acc='UPD';
	$btnform='<button type="submit" class="btn btn-success"><i class="fa fa-refresh fa-lg"></i> ACTUALIZAR</button>';
	$detCir_fecr=$detCir['fechar'];
}else{
	$acc='INS';
	$btnform='<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg"></i> GRABAR</button>';
}
$acc=md5($acc);
$css['body']='cero';
include(RAIZf.'head.php'); ?>
<?php sLOG('g'); ?>
<form action="actions.php" method="post" id="formexam" enctype="multipart/form-data">
<fieldset>
    <input name="idr" type="hidden" id="idr" value="<?php echo $idr ?>">
    <input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
    <input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
    <input name="acc" type="hidden" id="acc" value="<?php echo $acc?>">
    <input name="form" type="hidden" id="form" value="fcirugia">
</fieldset>
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
      <a class="navbar-brand" href="#"><i class="fa fa-medkit fa-lg"></i> CIRUGIA</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li><a><span class="label label-info"><?php echo $idr ?></span></a></li>
        <li><a><?php echo $detpac['pac_nom'].' '.$detpac['pac_ape'] ?></a></li>
        <li><a>Consulta: <span class="label label-default"><?php echo $idc ?></span></a></li>
        <li><a><?php echo $detCir['fecha'] ?></a></li>
      </ul>
      <div class="navbar-right btn-group navbar-btn">
      <?php echo $btnform ?>
      <a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO</a>
      </div>
	</div>
</div>
</nav>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-8">
    <fieldset class="form-horizontal well well-sm">
		<div class="form-group">
        <label class="control-label col-sm-4" for="resultado">Diagnostico</label>
			<div class="col-sm-8">
            <input name="diagnostico" type="text" id="diagnostico" value="<?php echo $detCir['diagnostico'] ?>" class="form-control" autofocus>
			</div>
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-4" for="resultado"><strong>Cirugia Realizada</strong></label>
			<div class="col-sm-8">
            <input name="cirugiar" type="text" id="cirugiar" value="<?php echo $detCir['cirugiar'] ?>" class="form-control">
			</div>
		</div>
        
        
        <div class="form-group">
        	<label class="control-label col-sm-4" for="fechar"><strong>Fecha Realizada</strong></label>
			<div class="col-sm-8">
            <input type="date" name="fechar" id="fechar" value="<?php echo $detCir_fecr ?>" class="form-control">
			</div>
		</div>
        
		<div class="form-group">
        	<label class="control-label col-sm-4" for="resultado">Protocolo</label>
			<div class="col-sm-8">
			<textarea name="protocolo" rows="5" class="form-control" id="protocolo" placeholder="Descripcion"><?php echo $detCir['protocolo'] ?></textarea>
			</div>
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-4" for="resultado">Evolucion</label>
			<div class="col-sm-8">
            <input name="evolucion" type="text" id="evolucion" value="<?php echo $detCir['evolucion'] ?>" class="form-control">
			</div>
		</div>
    </fieldset>
	</div>

	<div class="col-sm-4">	
<div class="well well-sm">
<?php if($detCir){
	$qryfc=sprintf('SELECT * FROM db_cirugias_media WHERE id_cir=%s ORDER BY id DESC',
	SSQL($idr,'int'));
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
      <img src="<?php echo $RAIZmdb?>cir/<?php echo $detMedia['file'] ?>" alt="...">
      <div class="caption">
        <h3><?php echo $detMedia['des'] ?></h3>
        <p>
        <a href="<?php echo $RAIZmdb?>cir/<?php echo $detMedia['file'] ?>" class="btn btn-primary btn-xs fancybox" role="button">
        <i class="fa fa-eye"></i> Ver</a> 
        <a href="actions.php?idcm=<?php echo $row_RSfc['id'] ?>&acc=DELMC" class="btn btn-danger btn-xs" role="button">
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
<script type="text/javascript"> function uploadImage() { formexam.submit(); } </script>
<?php include(RAIZf.'footer.php'); ?>