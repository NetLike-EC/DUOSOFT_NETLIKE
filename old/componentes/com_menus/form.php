<?php include('../../init.php');
loginN();
$_SESSION['MODSEL']='MENUS';
$rowMod=detMod($_SESSION['MODSEL']);
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$det=detRow('tbl_menus','menu_id',$id);
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
<input name="form" type="hidden" id="form" value="form_men">
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
<div class="page-header"><?php echo genPageTit($id,$det['menu_nom']) ?></div>
<?php sLog('g'); ?>
<div class="well">
	<fieldset class="form-horizontal">
    	<div class="control-group">
			<label class="control-label" for="menu_nom">Nombre</label>
			<div class="controls">
		  <input name="menu_nom" type="text" id="menu_nom" placeholder="Nombre del Menú" value="<?php echo $det['menu_nom']; ?>" class="input-block-level"></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="menu_ref">Referencia</label>
			<div class="controls">
		  <input name="menu_ref" type="text" id="menu_ref" placeholder="Referencia del menú" value="<?php echo $det['menu_ref']; ?>" class="input-block-level"></div>
		</div>
	</fieldset>
</div>
</form>
</div>
</body>
</html>