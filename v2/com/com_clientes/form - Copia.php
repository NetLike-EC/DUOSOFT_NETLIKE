<?php include('../../init.php');
fnc_accesslev("1,2,3");
$_SESSION['MODSEL']="PAC";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$id=vParam('id', $_GET['id'], $_POST['id'], FALSE);
$detPac=dataPac($id);
if ($detPac){
	$detPac_id=$detPac['cli_id'];
	$action="UPD";
	$detPacSig=detRow('db_signos','cli_id',$id);
	$IMC=$detPacSig['imc'];
	$IMC=calcIMC($IMC,$detPacSig['peso'],$detPacSig['talla']);
	$dirimg=fncImgExist("images/db/pac/",lastImgPac($id));
	$btnaction='<button type="submit" class="btn btn-success" onClick="ansclose=false;">
	<col-md- class="glyphicon glyphicon-refresh"></col-md-> ACTUALIZAR</button>';
}else{
	$action="INS";
	$btnaction='<button type="submit" class="btn btn-info" onClick="ansclose=false;">
	<col-md- class="glyphicon glyphicon-floppy-save"></col-md-> GUARDAR</button>';
}
include(RAIZf.'head.php');
?>
<body>
<?php include(RAIZm.'mod_navbar/mod.php'); ?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" name="form_grabar" id="form_grabar" role="form">
<div class="container-fluid">
<fieldset>
	<input name="action" type="hidden" id="action" value="<?php echo $action; ?>" />
	<input name="mod" type="hidden" id="mod" value="<?php echo $rowMod['mod_ref'] ?>" />
	<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
	<input name="urlr" type="hidden" id="urlr" value="<?php echo $_SESSION['urlc'] ?>">
</fieldset>
<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?php echo $rowMod['mod_nom'] ?> 
      <span class="label label-primary"><?php echo $detPac['cli_id']; ?></span></a>
    </div>
	<div class="collapse navbar-collapse" id="navbar-collapse-2">
	<ul class="nav navbar-nav">
		
		<li class="active"><a href="#"><?php echo $detPac['cli_nom'].' '.$detPac['cli_ape']; ?></a></li>
	</ul>
	<div class="navbar-right btn-group navbar-btn">
		<?php echo $btnaction ?>
		<?php if($id){ ?>
        <a href="<?php echo $RAIZc ?>com_consultas/form.php?id_pac=<?php echo $id ?>" class="btn btn-info"><i class="fa fa-eye"></i> VER CONSULTA</a>
        <?php } ?>
        <a href="<?php echo $_SESSION['urlc'] ?>" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> NUEVO</a>
		<a href="index.php" class="btn btn-default"><col-md- class="glyphicon glyphicon-remove"></col-md-> CERRAR</a></li>
	</div>
	</div><!-- /.navbar-collapse -->
</nav>
<?php sLOG('g'); ?>
<div class="row">
	<div class="col-md-5">
		<fieldset class="well well-sm">
		<div class="row">
			<div class="col-md-6"><input name="cli_nom" type="text" required class="form-control input-lg" id="cli_nom" value="<?php echo $detPac['cli_nom']?>" placeholder="Nombres Completos"></div>
			<div class="col-md-6"><input name="cli_ape" type="text" required class="form-control input-lg" id="cli_ape" value="<?php echo $detPac['cli_ape']?>" placeholder="Apellidos Completos"></div>
		</div>
		</fieldset>
		<div class="well well-sm">
        <div class="row">
			<div class="col-md-3 text-center">
			<?php if ($action=="UPD") { ?>
			<a href="<?php echo $dirimg ?>" class="fancybox"><img class="img-thumbnail img-responsive" src="<?php echo $dirimg ?>"></a><br>
			<a href="pacientes_loadimage.php?idpac=<?php echo $detPac['cli_id']; ?>" class="btn btn-default btn-xs btn-block fancybox fancybox.iframe fancyreload"><i class="fa fa-camera fa-lg"></i> Cargar</a>
			<?php }else{ ?>
            <a class="btn btn-default disabled"><i class="fa fa-picture-o fa-3x"></i><br>
Foto</a>
            <?php } ?>
			</div>
			<div class="col-md-9">
			<fieldset class="form-horizontal" role="form">
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 col-md-3 control-label">Identificacion</label>
				<div class="col-sm-9"><input name="cli_doc" type="text" class="form-control" id="cli_doc" value="<?php echo $detPac['cli_doc']?>" placeholder="Cedula / RUC / Pasaporte"></div>
				</div>
				<div class="form-group">
				<label for="inputPassword3" class="col-sm-3 col-md-3 control-label">Nacimiento</label>
				<div class="col-sm-6"><input name="cli_fec" id="cli_fec" value="<?php echo $detPac['cli_fec']; ?>" type="date" class="form-control" placeholder="Fecha"/></div>
				<div class="col-sm-3"><span class="label label-primary"><?php echo edad($detPac['cli_fec']); ?> Años</span></div>
				</div>
			</fieldset>
			</div>
		</div>
        </div>
		<fieldset class="form-horizontal well well-sm">
            <div class="form-group">
            	<label class="col-md-4 control-label" for="pac_tipsan">Tipo Paciente</label>
            	<div class="col-md-8"><?php echo listatipos('pac_tipst',"PACTIPST",$detPac['pac_tipst'],'form-control'); ?></div>
            </div>
            <div class="form-group">
				<label class="col-md-4 control-label" for="pac_tipsan">Tipo Sangre</label>
				<div class="col-md-8"><?php echo listatipos('pac_tipsan',"TIPSAN",$detPac['pac_tipsan'],'form-control'); ?></div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="pac_estciv">Estado Civil</label>
				<div class="col-md-8"><?php echo listatipos("pac_estciv","ESTCIV",$detPac['pac_estciv'],'form-control'); ?></div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="pac_sexo">Género</label>
				<div class="col-md-8"><?php echo listatipos("pac_sexo","SEXO",$detPac['pac_sexo'],'form-control',''); ?></div>
			</div>
		</fieldset>
        <div class="well well-sm">
            <fieldset>
            <div class="form-group">
				<label class="col-md-2 col-md-3 control-label" for="">Signos</label>
				<div class="col-md-10">
				<div class="row">
					<div class="col-xs-3"><input placeholder="PESO kg" name="" type="text" value="<?php echo $detPacSig['peso']; ?>" class="form-control" disabled/>
                    <col-md- class="help-block">Peso en KG.</col-md->
					</div>
					<div class="col-xs-3"><input placeholder="TALLA cm" type="text" value="<?php echo $detPacSig['talla']; ?>" class="form-control" disabled/>
                    <col-md- class="help-block">Talla cm.</col-md->
					</div>
                    <div class="col-xs-3"><input placeholder="IMC" type="text" value="<?php echo $IMC['val']; ?>" class="form-control" disabled/>
                    <col-md- class="help-block">IMC.</col-md->
					</div>
					<div class="col-xs-3"><input placeholder="Presion Arterial" type="text" value="<?php echo $detPacSig['pa']; ?>" class="form-control" disabled/>
					<col-md- class="help-block">Presion Arterial</col-md->
					</div>
				</div>
                
				</div>
			</div>
            </fieldset>
            <div><?php if ($action=="UPD") { ?>
			<a href="<?php echo $RAIZc ?>com_comun/gest_hist.php?id=<?php echo $detPac_id ?>" class="btn btn-success btn-block fancybox fancybox.iframe fancyreload">
            <i class="fa fa-bars fa-lg"></i> Registrar</a>
			<?php } ?></div>
		</div>
	</div>
	<div class="col-md-3">
	<fieldset class="form-horizontal well well-sm">
		<div class="form-group"><label class="col-md-3 control-label">Procedencia</label>
			<div class="col-md-9"><input name="cli_lugp" type="text" value="<?php echo $detPac['cli_lugp']; ?>" class="form-control" placeholder="Lugar de Procedencia"/></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label">Residencia</label>
			<div class="col-md-9"><input name="pac_lugr" type="text" value="<?php echo $detPac['pac_lugr']; ?>" class="form-control" placeholder="Lugar de Residencia"/></div>
		</div>
        <div class="form-group"><label class="col-md-3 control-label" for="pac_dir">Dirección</label>
			<div class="col-md-9"><input name="pac_dir" id="pac_dir" type="text" value="<?php echo $detPac['pac_dir']; ?>" class="form-control" placeholder="Dirección"/></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label" for="SEXO">Sector</label>
			<div class="col-md-9"><?php echo listatipos("pac_sect","SECTOR",$detPac['pac_sect'],'form-control'); ?></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label">Telefono 1</label>
			<div class="col-md-9"><input name="pac_tel1" type="text" value="<?php echo $detPac['pac_tel1']; ?>" class="form-control" /></div>
		</div>
        <div class="form-group"><label class="col-md-3 control-label">Telefono 2</label>
			<div class="col-md-9"><input name="pac_tel2" type="text" value="<?php echo $detPac['pac_tel2']; ?>" class="form-control" /></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label">E-Mail</label>
			<div class="col-md-9"><input name="pac_email" type="email" placeholder="nombre@mail.com" value="<?php echo $detPac['pac_email']; ?>" class="form-control" /></div>
		</div>
        <div class="form-group"><label class="col-md-3 control-label" for="pac_ins">Instrucción</label>
			<div class="col-md-9"><?php echo listatipos('pac_ins',"INST",$detPac['pac_ins'],'form-control'); ?></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label">Profesión</label>
			<div class="col-md-9"><input name="pac_pro" type="text" value="<?php echo $detPac['pac_pro']; ?>" class="form-control"/></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label" for="SEXO">Empresa</label>
			<div class="col-md-9"><?php echo listatipos("pac_emp","EMPTRB",$detPac['pac_emp'],'form-control'); ?></div>
		</div>
        <div class="form-group"><label class="col-md-3 control-label">Ocupación</label>
			<div class="col-md-9"><input name="pac_ocu" type="text" value="<?php echo $detPac['pac_ocu']; ?>" class="form-control"/></div>
		</div>
	</fieldset>
    </div>
	<div class="col-md-4">
	<fieldset class="form-horizontal well well-sm">
	<div class="form-group"><label class="col-md-4 control-label">Nombre Cónyuge</label>
		<div class="col-md-8"><input name="cli_nompar" type="text" value="<?php echo $detPac['cli_nompar']; ?>" class="form-control"/></div>
	</div>
	<div class="form-group">
		<label for="cli_fecpar" class="col-md-4 control-label">Nacimiento</label>
		<div class="col-md-5"><input name="cli_fecpar" id="cli_fecpar" value="<?php echo $detPac['cli_fecpar']; ?>" type="date" class="form-control" placeholder="Fecha"/></div>
		<div class="col-sm-3"><span class="label label-primary"><?php echo edad($detPac['cli_fecpar']); ?> Años</span></div>
	</div>
    <div class="form-group">
		<label class="col-md-4 control-label" for="pac_tipsan">Tipo Sangre</label>
		<div class="col-md-8"><?php echo listatipos('pac_tipsanpar',"TIPSAN",$detPac['pac_tipsanpar'],'form-control'); ?></div>
	</div>
    <div class="form-group"><label class="col-md-4 control-label">Teléfono Cónyuge</label>
		<div class="col-md-8"><input name="pac_telpar" type="text" value="<?php echo $detPac['pac_telpar']; ?>" class="form-control"/></div>
	</div>
    <div class="form-group"><label class="col-md-4 control-label">Ocupación</label>
		<div class="col-md-8"><input name="pac_ocupar" type="text" value="<?php echo $detPac['pac_ocupar']; ?>" class="form-control"/></div>
	</div>
	</fieldset>
    <fieldset class="form-horizontal well well-sm">
    <div class="form-group"><label class="col-md-4 control-label">Publicidad</label>
		<div class="col-md-8"><?php echo listatipos("publi","PUBLI",$detPac['publi'],'form-control'); ?></div>
	</div>
    <div class="form-group"><label class="col-md-4 control-label">Observaciones</label>
		<div class="col-md-8">
        	<textarea name="pac_obs" rows="9" class="form-control" id="pac_obs"><?php echo $detPac['pac_obs'] ?></textarea>
        </div>
	</div>
	</fieldset>
    </div>
</div>
</div>
</form>

<?php include(RAIZf.'footer.php') ?>