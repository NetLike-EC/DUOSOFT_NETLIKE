<?php $ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$det=detRow('tbl_menus','md5(id)',$ids);
if ($det){ 
	$acc=md5(UPDmc);
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc">'.$cfg[i][upd].$cfg[b][upd].'</button>';
}else {
	$acc=md5(INSmc);
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc">'.$cfg[i][ins].$cfg[b][ins].'</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default">'.$cfg[i]['new'].$cfg[b]['new'].'</a>';
?>
<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<fieldset>
<input name="acc" type="hidden" value="<?php echo $acc ?>">
<input name="form" type="hidden" value="<?php echo md5(formMC) ?>">
<input name="ids" type="hidden" value="<?php echo $ids ?>" />
<input name="url" type="hidden" value="<?php echo $urlc ?>" />
</fieldset>
<?php echo genPageNavbar($dM['mod_cod']) ?>
<div class="btn-group pull-right">
	<?php echo $btnAcc ?>
    <?php echo $btnNew ?>
</div>
<?php echo genPageHead(NULL,$det['nom'],'h2', $id) ?>
<?php sLog('g'); ?>
<div class="row">
<div class="col-sm-6">
<div class="well">
	<fieldset class="form-horizontal">
    	<div class="form-group">
			<label class="control-label col-sm-4" for="iNom">Nombre</label>
			<div class="col-sm-8">
		  <input name="iNom" type="text" id="iNom" placeholder="Nombre del Menú" value="<?php echo $det['nom']; ?>" class="form-control"></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="iRef">Referencia</label>
			<div class="col-sm-8">
		  <input name="iRef" type="text" id="iRef" placeholder="Referencia del menú" value="<?php echo $det['ref']; ?>" class="form-control"></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="iRef">Section</label>
			<div class="col-sm-8">
			 <input list="sec" name="iSec" value="<?php echo $det['sec'] ?>" class="form-control" required>
				<datalist id="sec">
				<option value="F">WEBSITE (FRONT END)</option>
				<option value="B">ADMINISTRATOR (BACK END)</option>
				</datalist>
			 </div>
		</div>
	</fieldset>
</div>
</div>
<div class="col-sm-6">
	<div class="panel panel-default">
    	<div class="panel-heading">Menus en este contenedor</div>
        <div class="panel-body">Coding</div>
    </div>
</div>
</div>
</form>