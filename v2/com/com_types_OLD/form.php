<?php include('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL']='TYP';
$rowMod=detRow('tbl_modules','mod_ref',$_SESSION['MODSEL']);
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$det=detRow('tbl_types','typ_cod',$id);
if ($det){ 
	$acc="UPD";
	$btnAction='<button type="submit" class="btn btn-success navbar-btn pull-right" onClick="return confirm('."'Are you sure Update?'".');"><span class="icon-hdd"></span> ACTUALIZAR</button>';
}else {
	$acc="INS";
	$btnAction='<button type="submit" class="btn btn-primary navbar-btn pull-right" onClick="return confirm('."'Are upu sure Insert?'".');"><span class="icon-hdd"></span> GUARDAR</button>';
}
$btnNew='<a href="'.$_SESSION['urlc'].'" class="btn btn-default navbar-btn pull-right"><i class="fa fa-file-o"></i> NEW</a>';
include(RAIZf.'_head.php'); ?>
<body class="cero">
<form enctype="multipart/form-data" method="post" action="fncts.php">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">TYPES MANAGEMENT</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<?php echo $btnNew ?>
		<?php echo $btnAction ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
<fieldset>
<input name="acc" type="hidden" id="action" value="<?php echo $acc ?>">
<input name="form" type="hidden" id="form" value="form_mod">
<input name="id" type="hidden" id="id" value="<?php echo $id ?>" />
</fieldset>
<div class="page-header">
	<h1><span class="label label-primary"><?php echo $id ?></span> <?php echo $det['typ_nom'] ?></h1>
</div>
<?php sLog('g'); ?>
<div class="well">
	<fieldset class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="form_ref">Referencia</label>
			<div class="col-sm-10">
		  <input name="form_ref" type="text" id="form_ref" value="<?php echo $det['typ_ref']; ?>" class="form-control" required></div>
		</div>
        <div class="form-group">
			<label class="col-sm-2 control-label" for="form_ref">Nombre</label>
			<div class="col-sm-10">
		  <input name="form_nom" type="text" id="form_nom" value="<?php echo $det['typ_nom']; ?>" class="form-control" required></div>
		</div>
        <div class="form-group">
			<label class="col-sm-2 control-label" for="form_ref">Valor</label>
			<div class="col-sm-10">
		  <input name="form_val" type="text" id="form_val" value="<?php echo $det['typ_val']; ?>" class="form-control"></div>
		</div>
        <div class="form-group">
			<label class="col-sm-2 control-label" for="form_mod">Módulo</label>
			<div class="col-sm-10">
			<input id="form_mod" name="form_mod" type="text" value="<?php echo $det['mod_ref']; ?>" class="form-control">
            </div>
		</div>
	</fieldset>
</div>
</div>
</form>
</body>
</html>