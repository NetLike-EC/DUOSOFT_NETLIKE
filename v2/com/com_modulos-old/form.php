<?php include('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL']='MOD';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$action=fnc_verifiparam('action', $_GET['action'], $_POST['action']);
$detMod=detMod($id);
if ($detMod){ 
	$action="UPD";
	$btnAction='<button type="submit" class="btn btn-success navbar-btn" onClick="return confirm('."'Are you sure Update?'".');"><span class="glyphicon glyphicon-floppy-save"></span> UPDATE</button>';
}else {
	$action="INS";
	$btnAction='<button type="submit" class="btn btn-primary navbar-btn" onClick="return confirm('."'Are upu sure Insert?'".');"><span class="glyphicon glyphicon-floppy-save"></span> SAVE</button>';
}
include(RAIZf.'_head.php'); ?>
<body>
<div class="container">
<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<div class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<a class="navbar-brand" href="#"><?php echo $rowMod['mod_nom']?></a>
	</div>
			<input name="action" type="hidden" id="action" value="<?php echo $action ?>">
			<input name="form" type="hidden" id="form" value="form_mod">
			<input name="id" type="hidden" id="id" value="<?php echo $id ?>" />
    <ul class="nav navbar-nav navbar-right">
      <li><?php echo $btnAction ?></li>
      <li><a href="<?php echo $_SESSION['urlc'] ?>"><span class="glyphicon glyphicon-file"></span> ADD NEW</a></li>
    </ul>
    
</div>
	<div class="page-header">
    	<h1><span class="label label-default"><?php echo $id ?></span> <?php echo $detMod['mod_nom'] ?></h1>
    </div>
	<?php fnc_log(); ?>
<div class="well well-sm">
	<fieldset class="form-horizontal">
		<div class="form-group">
			<label class="col-lg-3 control-label" for="mod_ref">Referencia</label>
			<div class="col-lg-9">
		  <input name="mod_ref" type="text" id="mod_ref" placeholder="Name for Category" value="<?php echo $detMod['mod_ref']; ?>" class="form-control" required></div>
		</div>
        <div class="form-group">
			<label class="col-lg-3 control-label" for="mod_ref">Name</label>
			<div class="col-lg-9">
		  <input name="mod_nom" type="text" id="mod_nom" placeholder="Name for Category" value="<?php echo $detMod['mod_nom']; ?>" class="form-control" required></div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label" for="mod_des">Description</label>
			<div class="col-lg-9">
		  <input name="mod_des" type="text" id="mod_des" placeholder="Short description" value="<?php echo $detMod['mod_des']; ?>" class="form-control"></div>
		</div>
        <div class="form-group">
			<label class="col-lg-3 control-label" for="mod_des">Description</label>
		  <div class="col-lg-9">
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