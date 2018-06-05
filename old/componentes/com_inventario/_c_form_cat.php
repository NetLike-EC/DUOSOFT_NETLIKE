<?php
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$detCat=detInvCat($id);
$rowMod=detMod($_SESSION['MODSEL']);
$iColor='purple';$btn_ico='icon-th-large';
if($detCat){
	$action='UPD';
	$query_RSct = sprintf("SELECT tip_cod as sID, tip_nom as sVAL FROM tbl_inv_tipos WHERE tbl_inv_tipos.cat_cod=%s",
		GetSQLValueString($id, "int"));
	$RSct = mysql_query($query_RSct) or die(mysql_error());
	$btnaction='<input type="submit" name="btn_grabar" value="ACTUALIZAR" class="btn red"/>';
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
		<a href="<?php echo $RAIZc?>com_inventario/inv_gest_cat.php">Categorias</a>
		<span class="icon-angle-right"></span>
	</li>
	<li class="muted">Crear Categoria</li>
</ul>
<?php fnc_log(); ?>
<form id="form_cat" name="form" method="post" action="_fncts.php?action=<?php echo $action;?>">
<div class="portlet box <?php echo $iColor ?>">
<div class="portlet-title">
	<span class="badge badge-info"><h4><i class="<?php echo $btn_ico ?>"></i> <strong><?php echo $detCat['cat_cod']; ?></strong></h4></span>
	<span class="badge badge-info"><h4><?php echo $detCat['cat_nom']; ?></h4></span>
    <div class="actions">        
        <input name="form" type="hidden" id="form" value="form_cat">
    	<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
        <input name="action" type="hidden" id="action" value="<?php echo $action; ?>" />
		<input name="mod" type="hidden" id="mod" value="<?php echo $rowMod['mod_ref'] ?>" />
		<div class="btn-group">
		<?php echo $btnaction ?>
        <a href="<?php echo $_SESSION['urlc'] ?>" class="btn"><i class="icon-plus"></i> Nuevo</a>
        <a href="<?php echo $RAIZc ?>com_inventario/inv_gest_cat.php" class="btn black"><i class="icon-remove"></i> Cerrar</a>
        </div>
	</div>
</div>
<div class="portlet-body">
<div class="row-fluid">
	<div class="span8">	
    <div class="well">
    <fieldset class="form-horizontal">
    <div class="control-group">
		<label class="control-label" for="txt_nom">Nombre</label>
    <div class="controls">
        <input name="txt_nom" id="txt_nom" type="text" class="input-block-level" value="<?php echo $detCat['cat_nom']; ?>" placeholder="Nombre de la Categoría" required/>
    </div>
  </div>
	<div class="control-group">
		<label class="control-label" for="txt_des">Descripcion</label>
		<div class="controls">
		<textarea name="txt_des" id="txt_des" class="input-block-level" rows="3"><?php echo $detCat['cat_des']; ?></textarea>
		</div>
	</div>
    </fieldset>
    </div>
    </div>
	<div class="span4">	
    <div class="well">
    <fieldset>
    <legend>Tipos Relacionados</legend>
    <?php if ($detCat){
		echo generarselect("list_tip",$RSct,' ','input-block-level', 'multiple disabled size="5"');
    } ?>
    </fieldset>
    </div>
    </div>
</div>
</div>
</div>
</form>
</div>