<?php
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$detMar=detInvMar($id);
$rowMod=detMod($_SESSION['MODSEL']);
$iColor='yellow';$btn_ico='icon-tags';
if($detMar){
	$action='UPD';
	$btnaction='<input type="submit" name="btn_grabar" value="ACTUALIZAR" class="btn red"/>';
	$query_RSpm = sprintf("SELECT prod_id as sID, CONCAT('(',prod_id,') ',prod_nom) as sVAL FROM tbl_inv_productos WHERE tbl_inv_productos.mar_id=%s",
		GetSQLValueString($id, "int"));
	$RSpm = mysql_query($query_RSpm) or die(mysql_error());
}else{
	$action='INS';
	$btnaction='<input type="submit" name="btn_grabar" value="GRABAR" class="btn red" onClick="ansclose=false;"/>';
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
		<i class="icon-table"></i>
		<a href="<?php echo $RAIZc?>com_inventario/">Inventario</a> 
		<span class="icon-angle-right"></span>
	</li>
	<li>
		<a href="<?php echo $RAIZc?>com_inventario/inv_gest_mar.php">Marcas</a>
		<span class="icon-angle-right"></span>
	</li>
	<li class="muted">Crear Marca</li>
</ul>
<?php fnc_log(); ?>
<form method="post" action="_fncts.php" class="form-horizontal">
<div class="portlet box <?php echo $iColor ?>">
<div class="portlet-title">
	<span class="badge badge-info"><h4><i class="<?php echo $btn_ico ?>"></i> <strong><?php echo $detMar['mar_id'] ?></strong></h4></span>
	<span class="badge badge-info"><h4><?php echo $detMar['mar_nom'] ?></h4></span>
    <div class="actions">        
        <input name="form" type="hidden" id="form" value="form_mar">
    	<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
        <input name="action" type="hidden" id="action" value="<?php echo $action; ?>" />
		<input name="mod" type="hidden" id="mod" value="<?php echo $rowMod['mod_ref'] ?>" />
		<div class="btn-group">
		<?php echo $btnaction ?>
        <a href="<?php echo $_SESSION['urlc'] ?>" class="btn"><i class="icon-plus"></i> Nuevo</a>
        <a href="<?php echo $RAIZc ?>com_inventario/inv_gest_mar.php" class="btn black"><i class="icon-remove icon-white"></i> Cerrar</a>
		</div>
    </div>
</div>
<div class="portlet-body">
<div class="row-fluid">
	<div class="span8">
	
    <div class="well">
<div class="control-group">
	<label class="control-label" for="txt_nom">Nombre</label>
	<div class="controls">
		<input name="txt_nom" type="text" class="input-block-level" id="txt_nom" value="<?php echo $detMar['mar_nom']; ?>" placeholder="Nombre de la Marca" required autofocus/>
	</div>
</div>
</div>    
    </div>
	<div class="span4">
	<div class="well well-small">
    <fieldset>
    <legend>Artículos Relacionados</legend>
    <?php
    if ($detMar){
	echo generarselect("id_mar_sel",$RSpm,' ','input-block-level', 'multiple disabled size="6"');
	}?>
    </fieldset>
    </div>
    </div>
</div>
</div>
</div>
</form>
</div>