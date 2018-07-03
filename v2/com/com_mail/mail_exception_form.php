<?php include('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL']='MLSE';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$action=fnc_verifiparam('action', $_GET['action'], $_POST['action']);
$detMailE=dataContMailE($id);
if ($detMailE){ 
	$action="UPD";
	$btnAction='<button type="submit" class="btn btn-success navbar-btn" onClick="return confirm('."'Are you sure Update?'".');"><span class="glyphicon glyphicon-floppy-save"></span> UPDATE</button>';
}else {
	$action="INS";
	$btnAction='<button type="submit" class="btn btn-primary navbar-btn" onClick="return confirm('."'Are upu sure Insert?'".');"><span class="glyphicon glyphicon-floppy-save"></span> SAVE</button>';
}
include(RAIZf.'_head.php'); ?>
<body class="cero-m">
<div class="container">
<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<div class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<a class="navbar-brand" href="#"><?php echo $rowMod['mod_nom']?></a>
	</div>
			<input name="action" type="hidden" id="action" value="<?php echo $action ?>">
			<input name="form" type="hidden" id="form" value="<?php echo md5(formMailE) ?>">
			<input name="id" type="hidden" id="id" value="<?php echo $id ?>" />
    <ul class="nav navbar-nav navbar-right">
      <li><?php echo $btnAction ?></li>
      <li><a href="<?php echo $_SESSION['urlc'] ?>"><span class="glyphicon glyphicon-file"></span> ADD NEW</a></li>
    </ul>
    
</div>
	<div class="page-header">
    	<h1><span class="label label-default"><?php echo $id ?></span> <?php echo $detMailE['mail'] ?></h1>
    </div>
	<?php fnc_log(); ?>
<div class="well well-sm">
	<fieldset class="form-horizontal">
		<div class="form-group">
			<label class="col-lg-3 control-label" for="mail">Mail Exception</label>
			<div class="col-lg-9">
		  <input name="mail" type="mail" id="mail" placeholder="Name for Category" value="<?php echo $detMailE['mail']; ?>" class="form-control" required></div>
		</div>
	</fieldset>
</div>
</form>
</div>
</body>
</html>