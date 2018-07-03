<?php include('../../init.php');
//fnc_accesslev("1,2,3");
$_SESSION['MODSEL']='TYP';
//$rowMod=detMod($_SESSION['MODSEL']);
$id=vParam('id', $_GET['id'], $_POST['id']);
$ref=vParam('ref', $_GET['ref'], $_POST['ref']);
$det=detRow('db_types','typ_cod',$id);
if ($det){ 
	$acc="UPD";
	$btnAction='<button type="submit" class="btn green" onClick="return confirm('."'Are you sure Update?'".');"><span class="fa fa-floppy-o fa-lg"></span> ACTUALIZAR</button>';
	$detRef=$det['typ_ref'];
}else {
	$acc="INS";
	$btnAction='<button type="submit" class="btn blue" onClick="return confirm('."'Are upu sure Insert?'".');"><span class="fa fa-floppy-o fa-lg"></span> GUARDAR</button>';
	$detRef=$ref;
}
include(RAIZf.'head.php'); ?>
<body class="cero">
<div class="container">
<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<fieldset>
<input name="acc" type="hidden" value="<?php echo $acc ?>">
<input name="form" type="hidden" value="form_mod">
<input name="id" type="hidden" value="<?php echo $id ?>" />
<input name="url" type="hidden" value="<?php echo $urlc ?>" />
</fieldset>
<nav class="navbar navbar-fixed-top">
<div class="navbar-inner">
	<div class="container">
	<a class="brand" href="#"><?php echo $rowMod['mod_nom']?></a>
    <ul class="nav pull-right">
      <li><?php echo $btnAction ?></li>
      <li><a href="<?php echo $_SESSION['urlc'] ?>" class="btn"><span class="icon-plus"></span> NUEVO</a></li>
    </ul>
    </div>
</div>
</nav>
<?php echo gen_pageTit($_SESSION['MODSEL']) ?>
<?php sLog('g'); ?>
<div class="well">
	<fieldset class="form-horizontal">
    	<div class="control-group">
			<label class="control-label" for="form_ref">Módulo</label>
			<div class="controls">
		  <input name="form_mod" type="text" id="form_mod" placeholder="Módulo" value="<?php echo $det['mod_ref']; ?>" class="input-block-level"></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form_ref">Referencia</label>
			<div class="controls">
		  <input name="form_ref" type="text" id="form_ref" placeholder="Referencia del módulo" value="<?php echo $detRef ?>" class="input-block-level" required></div>
		</div>
        <div class="control-group">
			<label class="control-label" for="form_ref">Valor</label>
			<div class="controls">
		  <input name="form_val" type="text" id="form_val" placeholder="Valor" value="<?php echo $det['typ_val']; ?>" class="input-block-level" required></div>
		</div>
        <div class="control-group">
			<label class="control-label" for="form_ref">Icono</label>
			<div class="controls">
		  <input name="form_nom" type="text" id="form_icon" placeholder="Nombre del Módulo" value="<?php echo $det['typ_icon']; ?>" class="input-block-level" ></div>
		</div>
                          
	</fieldset>
</div>
</form>
</div>
</body>
</html>