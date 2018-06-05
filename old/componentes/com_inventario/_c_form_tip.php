<?php
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$detTip=detInvTip($id);
$rowMod=detMod($_SESSION['MODSEL']);
$iColor='green';$btn_ico='icon-th';
if($detTip){
	$action='UPD';
	$btnaction='<input type="submit" name="btn_grabar" value="ACTUALIZAR" class="btn red"/>';
	$query_RSpt = sprintf("SELECT prod_id as sID, prod_nom as sVAL FROM tbl_inv_productos WHERE tbl_inv_productos.tip_cod=%s",
		GetSQLValueString($id, "int"));
	$RSpt = mysql_query($query_RSpt) or die(mysql_error());
}else{
	$action='INS';
	$btnaction='<input type="submit" name="btn_grabar" value="GRABAR" class="btn red" onClick="ansclose=false;"/>';
}
$query_RSc = sprintf("SELECT cat_cod as sID, cat_nom as sVAL FROM tbl_inv_categorias WHERE cat_stat=%s",
	GetSQLValueString('1', "text"));
$RSc = mysql_query($query_RSc) or die(mysql_error());
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
		<a href="<?php echo $RAIZc?>com_inventario/inv_gest_tip.php">Tipos</a>
		<span class="icon-angle-right"></span>
	</li>
	<li class="muted">Crear Tipo</li>
</ul>
<?php sLOG('g'); ?>
<form enctype="multipart/form-data" id="form" name="form" method="post" action="_fncts.php">
<div class="portlet box <?php echo $iColor ?>">
<div class="portlet-title">
	<span class="badge badge-info"><h4><i class="<?php echo $btn_ico ?>"></i> <strong><?php echo $detTip['tip_cod']; ?></strong></h4></span>
	<span class="badge badge-info"><h4><?php echo $detTip['tip_nom']; ?></h4></span>
    <div class="actions">        
        <input name="form" type="hidden" id="form" value="form_tip">
    	<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
        <input name="action" type="hidden" id="action" value="<?php echo $action; ?>" />
		<input name="mod" type="hidden" id="mod" value="<?php echo $rowMod['mod_ref'] ?>" />
		<div class="btn-group">
		<?php echo $btnaction ?>
		<a href="<?php echo $_SESSION['urlc'] ?>" class="btn"><i class="icon-plus"></i> Nuevo</a>
        <a href="<?php echo $RAIZc ?>com_inventario/inv_gest_tip.php" class="btn black"><i class="icon-remove"></i> Cerrar</a>
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
        <input type="text" name="txt_nom" id="txt_nom" class="input-block-level" value="<?php echo $detTip['tip_nom']; ?>" required/>
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="txt_des">Descripcion</label>
    <div class="controls">
      <textarea name="txt_des" id="txt_des" class="input-block-level"rows="3"><?php echo $detTip['tip_des']; ?></textarea>
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="txt_des">Categoria</label>
    <div class="controls">
      <?php echo generarselect("id_cat_sel",$RSc,$detTip['cat_cod'],'input-block-level', 'required'); ?>
    </div>
    </div>
</fieldset>
		</div>    
    </div>
	<div class="span4">
	<div class="well well-small">
    <fieldset>
    <legend>Artículos Relacionados</legend>
    <?php
    if ($detTip){
	echo generarselect("id_prod_sel",$RSpt,' ','input-block-level', 'multiple disabled size="5"');
	}?>
    </fieldset>
    </div>
    </div>
</div>
	
</div>
</form>
</div>