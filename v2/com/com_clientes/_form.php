<?php 
$ids=vParam('ids', $_GET['ids'], $_POST['ids'], FALSE);
$det=detRow('db_clientes','md5(cli_id)',$ids);
if ($det){
	$id=$det[cli_id];
	$acc=md5('UPDp');
	$img=vImg("data/db/pac/",lastImgTab('db_clientes_media','cod_pac',$id,'id','DESC'));
	
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc"><i class="fa fa-floppy-o" aria-hidden="true"></i> ACTUALIZAR</button>';
}else{
	$acc=md5("INSp");
	$btnAcc='<button type="button" class="btn btn-info" id="vAcc"><i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR</button>';
}
?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" name="form_grabar" id="form_grabar" role="form">
<fieldset>
	<input name="acc" type="hidden" value="<?php echo $acc; ?>" />
	<input name="mod" type="hidden" value="<?php echo $dM['mod_ref'] ?>" />
	<input name="id" type="hidden" value="<?php echo $id; ?>" />
	<input name="url" type="hidden" value="<?php echo $urlc ?>">
</fieldset>
<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?php echo $dM['mod_nom'] ?> 
      <span class="label label-primary"><?php echo $det['cli_id']; ?></span></a>
    </div>
	<div class="collapse navbar-collapse" id="navbar-collapse-2">
	<ul class="nav navbar-nav">
		
		<li class="active"><a href="#"><?php echo $det['cli_nom'].' '.$det['cli_ape']; ?></a></li>
	</ul>
	<div class="navbar-right btn-group navbar-btn">
		<?php echo $btnAcc ?>
		<?php if($id){ ?>
        <!--<a href="<?php echo $RAIZc ?>com_consultas/form.php?idp=<?php echo $id ?>" class="btn btn-info"><i class="fa fa-eye"></i> VER CONSULTA</a>-->
        <?php } ?>
        <a href="<?php echo $_SESSION['urlc'] ?>" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> NUEVO</a>
		<a href="index.php" class="btn btn-default"><col-md- class="glyphicon glyphicon-remove"></col-md-> CERRAR</a></li>
	</div>
	</div><!-- /.navbar-collapse -->
</nav>
<div class="row">
	<div class="col-md-5">
		<fieldset class="well well-sm">
		<div class="row">
			<div class="col-md-6"><input name="cli_ape" type="text" required class="form-control input-lg" id="cli_ape" value="<?php echo $det['cli_ape']?>" placeholder="Apellidos Completos"/></div>
			<div class="col-md-6"><input name="cli_nom" type="text" required class="form-control input-lg" id="cli_nom" value="<?php echo $det['cli_nom']?>" placeholder="Nombres Completos"/></div>
		</div>
		</fieldset>
		<div class="well well-sm">
        <div class="row">
			<div class="col-md-3 text-center">
			<?php if ($det) { ?>
			<a href="<?php echo $img['n'] ?>" class="fancybox"><img class="img-thumbnail img-responsive" src="<?php echo $img['t'] ?>"></a><br>
			<a href="pacImg/pacImg.php?idp=<?php echo $id ?>" class="btn btn-default btn-xs btn-block fancybox fancybox.iframe fancyreload"><i class="fa fa-camera fa-lg"></i> Cargar</a>
			<?php }else{ ?>
            <a class="btn btn-default disabled"><i class="fa fa-picture-o fa-3x"></i><br>Foto</a>
            <?php } ?>
			</div>
			<div class="col-md-9">
			<fieldset class="form-horizontal" role="form">
				<div class="form-group">
				<label class="col-sm-3 control-label">Registrado</label>
				<div class="col-sm-9"><input name="pac_reg" type="text" class="form-control input-sm" value="<?php echo $det['pac_reg']?>" disabled></div>
				</div>
                <div class="form-group">
				<label for="cli_doc" class="col-sm-3 control-label">Identificacion</label>
				<div class="col-sm-9"><input name="cli_doc" type="text" class="form-control" id="cli_doc" value="<?php echo $det['cli_doc']?>" placeholder="Cedula / RUC / Pasaporte"></div>
				</div>
				<div class="form-group">
				<label for="cli_fec" class="col-sm-3 control-label">Nacimiento</label>
				<div class="col-sm-6"><input name="cli_fec" id="cli_fec" value="<?php echo $det['cli_fec']; ?>" type="date" class="form-control" placeholder="Fecha" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')" onChange="getDataVal(null,this.value,'FechaToEdad','viewEdad')" /></div>
				<div class="col-sm-3"><span class="small" id="viewEdad"><?php echo edadC($det['cli_fec']); ?></span></div>
				</div>
			</fieldset>
			</div>
		</div>
        </div>
		
		<fieldset class="form-horizontal well well-sm">
            
		</fieldset>
		
        <div class="well well-sm">
            <fieldset>
            
            </fieldset>
		</div>
	</div>
	<div class="col-sm-7">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#datos" role="tab" data-toggle="tab">Datos</a></li>
      <?php if($det){ ?>
      <li><a href="#historial" role="tab" data-toggle="tab">Historia</a></li>
      <li><a href="#ginecologia" role="tab" data-toggle="tab">Registro</a></li>
      <?php } ?>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="datos">
        <?php include('form_datos.php') ?>
        </div>
        <div class="tab-pane fade" id="historial">
        <?php include(RAIZc.'com_hc/historia_det.php') ?>
        </div>
        <div class="tab-pane fade" id="ginecologia">
        <?php include(RAIZc.'com_hc/ginecologia_det.php') ?>
        </div>
    </div>
    </div>
</div>
</form>