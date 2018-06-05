<?php include_once('../../init.php');
$id=vParam('id_prod', $_GET['id_prod'], $_POST['id_prod']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$detProd=detInvProd($id);
$rowMod=detMod($_SESSION['MODSEL']);
if($detProd){
	$action='UPD';
}else{
	$action='INS';
}
?>
<?php include(RAIZf.'_head.php');?>
<form id="formComProdNew" name="formComProdNew">
<div>
		<input name="form" type="hidden" id="form" value="form_prodc">
		<input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id; ?>" />
		<input name="action" type="hidden" id="action" value="<?php echo $action; ?>" />
		<input name="mod" type="hidden" id="mod" value="<?php echo $rowMod['mod_ref'] ?>" />
		<input name="imagea" type="hidden" id="imagea" value="<?php echo $detProd['prod_img'] ?>">
		
	</div>
<div class="row-fluid">
	<div class="well well-small">
    <div class="alert alert-info" style="display:none">Grabado Correctamente</div>
    <fieldset class="form-horizontal">
    <div class="control-group">
    	<label class="control-label">Codigo</label>
    	<div class="controls">
      	<input name="prod_cod" type="text" id="prod_cod" value="<?php echo $detProd['prod_cod']; ?>" class="input-block-level"/>
    	</div>
  	</div>
    <div class="control-group">
    	<label class="control-label">* Nombre</label>
    	<div class="controls">
        <input name="prod_nom" type="text" class="input-block-level" id="prod_nom" value="<?php echo $detProd['prod_nom']; ?>" size="35" required/>
    </div>
  	</div>
    <div class="control-group">
    	<label class="control-label">* Marca</label>
    	<div class="controls">
      	<?php echo generarselect("mar_id",listInvMar(),$detProd['mar_id'],'input-block-level','required'); ?>
    	</div>
  	</div>
    <div class="control-group">
    	<label class="control-label">* Tipo</label>
    	<div class="controls">
      	<?php echo generarselect("tip_cod",listInvTip(),$detProd['tip_cod'],'input-block-level','required'); ?>
    	</div>
  	</div>
    
    <div class="text-center">
	<input name="userfile" type="file" class="txt_values-sec" id="userfile" size="0" />
    </div>
    </fieldset>
    
    </div>
    <div class="well well-small"><div class="row-fluid">
		<div class="span4">
        <h4>Precio 1</h4>
        <input name="pri_1" id="pri_1" value="<?php echo $detProd['pri_1'] ?>" class="input-block-level">
        </div>
		<div class="span4">
        <h4>Precio 2</h4>
        <input name="pri_2" id="pri_2" value="<?php echo $detProd['pri_2'] ?>" class="input-block-level">
        </div>
		<div class="span4">
        <h4>Precio 3</h4>
        <input name="pri_3" id="pri_3" value="<?php echo $detProd['pri_3'] ?>" class="input-block-level">
        </div>
	</div></div>
    
</div>
</form>