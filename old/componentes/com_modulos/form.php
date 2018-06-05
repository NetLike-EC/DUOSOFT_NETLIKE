<?php include('../../init.php');
loginN();
$_SESSION['MODSEL']='MOD';
$rowMod=detMod($_SESSION['MODSEL']);
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$detMod=detRow('tbl_modules','mod_cod',$id);
if ($detMod){ 
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
<div class="page-header"><?php echo genPageTit($id,$detMod['mod_nom']) ?></div>
<?php sLOG('g'); ?>
<div class="well">
	<fieldset class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="mod_ref">Referencia</label>
			<div class="controls">
		  <input name="mod_ref" type="text" id="mod_ref" placeholder="Referencia del módulo" value="<?php echo $detMod['mod_ref']; ?>" class="input-block-level" required></div>
		</div>
        <div class="control-group">
			<label class="control-label" for="mod_ref">Name</label>
			<div class="controls">
		  <input name="mod_nom" type="text" id="mod_nom" placeholder="Nombre del módulo" value="<?php echo $detMod['mod_nom']; ?>" class="input-block-level" required></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="mod_des">Description</label>
			<div class="controls">
		  <input name="mod_des" type="text" id="mod_des" placeholder="Descripcion del módulo" value="<?php echo $detMod['mod_des']; ?>" class="input-block-level"></div>
		</div>
        <div class="form-group">
			<label class="control-label" for="mod_des">Status</label>
		  <div class="controls">
		  <p>
		    <label>
		      <input name="mod_stat" type="radio" id="mod_stat_0" value="1" checked="checked">
		      Activo</label>
		    <br>
		    <label>
		      <input type="radio" name="mod_stat" value="0" id="mod_stat_1">
		      Inactivo</label>
		    <br>
		    </p>
		  </div>
		</div>
                  
	</fieldset>
</div>
</form>
</div>
</body>
</html>