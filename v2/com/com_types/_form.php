<?php 
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$ref=vParam('ref', $_GET['ref'], $_POST['ref']);
$det=detRow('tbl_types','md5(typ_cod)',$ids);
if($det){
	$id=$det['typ_cod'];
	$acc=md5("UPDt");
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc">'.$cfg[i]['upd'].$cfg[b]['upd'].'</button>';
	$detRef=$det['typ_ref'];
	$btnNewR='<a href="'.$urlc.'?ref='.$detRef.'" class="btn btn-default">'.$cfg[i]['new'].$cfg[b]['new-sim'].'</a>';
}else{
	$acc=md5("INSt");
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc">'.$cfg[i]['ins'].$cfg[b]['ins'].'</button>';
	$detRef=$ref;
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default">'.$cfg[i]['new'].$cfg[b]['new'].'</a>';
?>
<form enctype="multipart/form-data" method="post" action="_fnc.php" class="form-horizontal">
<fieldset>
<input name="acc" type="hidden" value="<?php echo $acc ?>">
<input name="form" type="hidden" value="<?php echo md5('formType') ?>">
<input name="ids" type="hidden" value="<?php echo $ids ?>" />
<input name="url" type="hidden" value="<?php echo $urlc ?>" />
</fieldset>
<?php echo genPageHeader($dM['mod_cod'],'navbar') ?>
<?php echo genPageHeader(NULL,'header','h2',array("nom"=>$det[typ_nom], "id"=>$id),NULL,$btnAcc.$btnNew.$btnNewR) ?>
<?php sLog('g'); ?>
<div class="well">
	<fieldset class="form-horizontal">
    	<div class="form-group">
			<label class="col-sm-4 control-label" for="iMod">Módulo</label>
			<div class="col-sm-8">
		  <input name="iMod" type="text" id="iMod" placeholder="Módulo" value="<?php echo $det['mod_ref']; ?>" class="form-control"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label" for="iNom">Nombre</label>
			<div class="col-sm-8">
		  <input name="iNom" type="text" id="iNom" placeholder="Nombre del tipo" value="<?php echo $det['typ_nom'] ?>" class="form-control" required></div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label" for="iRef">Referencia</label>
			<div class="col-sm-8">
		  <input name="iRef" type="text" id="iRef" placeholder="Referencia del módulo" value="<?php echo $detRef ?>" class="form-control input-lg" required></div>
		</div>
        <div class="form-group">
			<label class="col-sm-4 control-label" for="iVal">Valor</label>
			<div class="col-sm-8">
		  <input name="iVal" type="text" id="iVal" placeholder="Valor del tipo" value="<?php echo $det['typ_val']; ?>" class="form-control input-lg" required></div>
		</div>
       	<div class="form-group">
			<label class="col-sm-4 control-label" for="iVal">Auxiliar</label>
			<div class="col-sm-8">
		  <input name="iAux" type="text" id="iAux" placeholder="Valor auxiliar" value="<?php echo $det['typ_aux']; ?>" class="form-control input-lg"></div>
		</div>
        <div class="form-group">
			<label class="col-sm-4 control-label" for="iIcon">Icono</label>
			<div class="col-sm-8">
		  <input name="iIcon" type="text" id="iIcon" placeholder="Icono" value="<?php echo $det['typ_icon']; ?>" class="form-control" ></div>
		</div>
                          
	</fieldset>
</div>
</form>