<?php
$_SESSION['MODSEL']="PROV";
$rowMod=detMod($_SESSION['MODSEL']);
$idprov=vParam('id', $_GET['id'], $_POST['id']);
$dataProv=detRow('tbl_proveedores','prov_id',$idprov);
$detPer=detPer($dataProv['per_id']);
if($dataProv){
	$action='UPD';
	$btnaction='<button type="submit" class="btn green" onClick="ansclose=false;"><i class="icon-save"></i> ACTUALIZAR</button>';
	$dataProv_nom=$detPer['per_nom'].' '.$detPer['per_ape'];
}else{
	$action="INS";
	$btnaction='<button type="submit" class="btn red" onClick="ansclose=false;">GUARDAR</button>';
}
?>
<div class="container-fluid">
	<h3 class="page-title"><?php echo $rowMod['mod_nom'] ?> <small><?php echo $rowMod['mod_des'] ?></small></h3>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="<?php echo $RAIZc?>com_index/">Inicio</a> 
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <i class="icon-user"></i>
            <a href="<?php echo $RAIZc?>com_proveedores/">Proveedores</a> 
            <span class="icon-angle-right"></span>
        </li>
        <li class="muted">Edición Proveedor</li>
    </ul>
<?php fnc_log(); ?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" name="form_grabar" id="form_grabar">
<div class="portlet box blue">
<div class="portlet-title">
	<span class="badge badge-info"><h4><i class="icon-user"></i> <strong><?php echo $dataProv['prov_cod']; ?></strong></h4></span>
	<span class="badge badge-info"><h4><?php echo $dataProv_nom ?></h4></span>
    <div class="actions">
    	<input name="action" type="hidden" id="action" value="<?php echo $action; ?>" />
		<input name="mod" type="hidden" id="mod" value="PROV" />
		<input name="id" type="hidden" id="id" value="<?php echo $idprov; ?>" />
		<?php echo $btnaction ?>
        <a href="<?php echo $_SESSION['urlc'] ?>" class="btn"><i class="icon-plus"></i> Nuevo</a>
	</div>
</div>
<div class="portlet-body">
<fieldset class="form-horizontal">
<h3 class="form-section">Información Empresa</h3>
<div class="row-fluid">
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Nombres</label>
			<div class="controls">
				<input type="text" name="form_nom" id="form_nom" class="span6" placeholder="Nombres" value="<?php echo $detPer['per_nom']?>" autocomplete="on" autofocus required>
                <input type="text" name="form_ape" id="form_ape" class="span6" placeholder="Apellidos" value="<?php echo $detPer['per_ape']?>" required>
			</div>
		</div>
	</div>
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Identificación</label>
			<div class="controls">
            	<input type="text" name="form_doc" id="form_doc" class="input-block-level" value="<?php echo $detPer['per_doc']?>" placeholder="Cedula / RUC / Pasaporte" required>
			</div>
		</div>
	</div>
</div>
<h3 class="form-section">Información Contacto</h3>

<div class="row-fluid">
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Ciudad</label>
			<div class="controls">
				<input name="form_ciu" type="text" class="input-block-level" id="form_ciu" value="<?php echo $detPer['per_ciu']; ?>"/>
            </div>
		</div>
	</div>
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Dirección</label>
			<div class="controls">
				<input name="form_dir" type="text" class="input-block-level" id="form_dir" value="<?php echo $detPer['per_dir']; ?>"/>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Telefono</label>
			<div class="controls">
				<input name="form_tel" type="text" class="input-block-level" id="form_tel" value="<?php echo $detPer['per_tel']; ?>" />
            </div>
		</div>
	</div>
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Movil</label>
			<div class="controls">
				<input name="form_movil" type="text" class="input-block-level" id="form_movil" value="<?php echo $detPer['per_cel']; ?>" />
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Correo</label>
			<div class="controls">
				<input name="form_mail" type="email" class="input-block-level" id="form_mail" value="<?php echo $detPer['per_mail']; ?>"/>
            </div>
		</div>
	</div>
</div>
<h3 class="form-section">Referencias</h3>
<div class="row-fluid">
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Nombre</label>
			<div class="controls">
				<input name="form_cont_nom" type="text" class="input-block-level" id="form_cont_nom" placeholder="Nombre Contacto" value="<?php echo $detPer['per_cont_nom']; ?>"/>
            </div>
		</div>
	</div>
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Telefono</label>
			<div class="controls">
				<input name="form_cont_tel" type="text" class="input-block-level" id="form_cont_tel" placeholder="Telefono Contacto" value="<?php echo $detPer['per_cont_tel']; ?>"/>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Dirección</label>
			<div class="controls">
				<input name="form_cont_dir" type="text" class="input-block-level" id="form_cont_dir" placeholder="Dirección Contacto" value="<?php echo $detPer['per_cont_dir']; ?>"/>
            </div>
		</div>
	</div>
	<div class="span6 ">
		<div class="control-group">
			<label class="control-label">Correo</label>
			<div class="controls">
				<input name="form_cont_mail" type="email" class="input-block-level" id="form_cont_mail" placeholder="Email Contacto" value="<?php echo $detPer['per_cont_mail']; ?>"/>
			</div>
		</div>
	</div>
</div>
</fieldset>
</div>
</div>
</form>
</div>