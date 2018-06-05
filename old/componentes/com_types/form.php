<?php include('../../init.php');
loginN();
$_SESSION['MODSEL']='ATRIB';
$rowMod=detMod($_SESSION['MODSEL']);
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$det=detSRow('tbl_types','typ_cod',$id);
if ($det){ 
	$action="UPD";
	$btnAction='<button type="submit" class="btn green" onClick="return confirm('."'Are you sure Update?'".');"><span class="icon-hdd"></span> ACTUALIZAR</button>';
}else {
	$action="INS";
	$btnAction='<button type="submit" class="btn blue" onClick="return confirm('."'Are upu sure Insert?'".');"><span class="icon-hdd"></span> GUARDAR</button>';
}
include(RAIZf.'_head.php'); ?>
<body class="popup popup-nav">
<div class="container">
<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<fieldset>
<input name="action" type="hidden" id="action" value="<?php echo $action ?>">
<input name="form" type="hidden" id="form" value="form_mod">
<input name="id" type="hidden" id="id" value="<?php echo $id ?>" />
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
<div class="page-header"><?php echo genPageTit($id,$det['typ_nom']) ?></div>
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
		  <input name="form_ref" type="text" id="form_ref" placeholder="Referencia del módulo" value="<?php echo $det['typ_ref']; ?>" class="input-block-level" required></div>
		</div>
        <div class="control-group">
			<label class="control-label" for="form_ref">Nombre</label>
			<div class="controls">
		  <input name="form_nom" type="text" id="form_nom" placeholder="Nombre del Módulo" value="<?php echo $det['typ_nom']; ?>" class="input-block-level" required></div>
		</div>
        <div class="control-group">
			<label class="control-label" for="form_ref">Valor</label>
			<div class="controls">
		  <input name="form_val" type="number" id="form_val" placeholder="Valor" value="<?php echo $det['typ_val']; ?>" class="input-block-level"></div>
		</div>                  
	</fieldset>
</div>
</form>
</div>
</body>
</html>