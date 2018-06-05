<?php include('../../init.php');
loginN();
$_SESSION['MODSEL']='MENUSI';
$rowMod=detMod($_SESSION['MODSEL']);
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$det=detRow('tbl_menus_items','itemmenu_id',$id);
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
<input name="form" type="hidden" id="form" value="form_meni">
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
<div class="page-header"><?php echo genPageTit($id,$det['itemmenu_nom']) ?></div>
<?php sLog('g'); ?>
<div class="well">
	<fieldset class="form-horizontal">
    	<div class="control-group">
			<label class="control-label" for="menu_id">MENU</label>
			<div class="controls"><?php generarselect('menu_id',listMenus(),$det['menu_id'],'input-block-level','required'); ?></div>
		</div>
        <div class="control-group">
		  <label class="control-label" for="itemmenu_parent">Padre</label>
			<div class="controls"><?php generarselect('itemmenu_parent',listItemsVal(),$det['itemmenu_parent'],'input-block-level','required'); ?></div>
		</div>
        <div class="control-group">
			<label class="control-label" for="itemmenu_nom">Nombre</label>
			<div class="controls">
		  <input name="itemmenu_nom" type="text" id="itemmenu_nom" placeholder="Nombre del Menú" value="<?php echo $det['itemmenu_nom']; ?>" class="input-block-level" required></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="itemmenu_tit">Titulo</label>
			<div class="controls">
		  <input name="itemmenu_tit" type="text" id="itemmenu_tit" placeholder="Titulo" value="<?php echo $det['itemmenu_tit']; ?>" class="input-block-level" required></div>
		</div>
        <div class="control-group">
			<label class="control-label" for="itemmenu_link">Link</label>
			<div class="controls">
		  <input name="itemmenu_link" type="text" id="itemmenu_link" placeholder="Enlace al Archivo" value="<?php echo $det['itemmenu_link']; ?>" class="input-block-level"></div>
		</div>
        <div class="control-group">
			<label class="control-label" for="itemmenu_icon">Icono</label>
			<div class="controls">
		  <input name="itemmenu_icon" type="text" id="itemmenu_icon" placeholder="Icono" value="<?php echo $det['itemmenu_icon']; ?>" class="input-block-level"></div>
		</div>
        <div class="control-group">
			<label class="control-label" for="itemmenu_order">Orden</label>
			<div class="controls">
		  <input name="itemmenu_order" type="number" min="0" step="1" id="itemmenu_order" placeholder="Nombre del Menú" value="<?php echo $det['itemmenu_order']; ?>" class="input-block-level" required></div>
		</div>
	</fieldset>
</div>
</form>
</div>

<script type="text/javascript">
$(document).ready(function() {	
	$('#menu_id').chosen();
	$('#itemmenu_parent').chosen();
});
</script>

</body>
</html>