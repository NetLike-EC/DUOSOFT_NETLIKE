<?php include('../../init.php');
$dM=vLogin('MENU CONTENT');
$id=vParam('id', $_GET['id'], $_POST['id']);
$acc=vParam('action', $_GET['action'], $_POST['action']);
$det=detRow('tbl_menus','id',$id);
if ($det){ 
	$acc="UPD";
	$btnAction='<button type="submit" class="btn btn-success" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
}else {
	$acc="INS";
	$btnAction='<button type="submit" class="btn btn-primary" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default"><span class="fa fa-plus"></span> NUEVO</a>';
include(RAIZf.'head.php'); ?>
<div class="container">
<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<fieldset>
<input name="acc" type="hidden" value="<?php echo $acc ?>">
<input name="form" type="hidden" value="form_men">
<input name="id" type="hidden" value="<?php echo $id ?>" />
<input name="url" type="hidden" value="<?php echo $urlc ?>" />
</fieldset>
<?php echo genPageNavbar($dM['mod_cod']) ?>
<div class="btn-group pull-right">
	<?php echo $btnAction ?>
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
</div>
<?php include(RAIZf.'footer.php'); ?>