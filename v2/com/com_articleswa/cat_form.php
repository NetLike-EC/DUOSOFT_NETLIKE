<?php include('../../init.php');
fnc_accessnorm();
mysql_select_db($db_conn_wa, $conn);
$_SESSION['MODSEL']='ARTCWA';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$action=fnc_verifiparam('action', $_GET['action'], $_POST['action']);
$detCat=fnc_dataartc($id);
if ($detCat){
	$action="UPD";
	$titForm=$detCat['cat_nom'];
	$btnAction='<button type="submit" class="btn btn-success navbar-btn" onClick="return confirm('."'Are you sure Update?'".');"><span class="glyphicon glyphicon-floppy-save"></span> UPDATE</button>';
}else {
	$action="INS";
	$titForm='NEW';
	$btnAction='<button type="submit" class="btn btn-primary navbar-btn" onClick="return confirm('."'Are upu sure Insert?'".');"><span class="glyphicon glyphicon-floppy-save"></span> SAVE</button>';
}
include(RAIZf.'_head.php'); ?>
<body class="cero-m">
<div class="container">
<form enctype="multipart/form-data" method="post" action="_fncts.php" class="form-horizontal">
<div class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<a class="navbar-brand" href="#"><?php echo $rowMod['mod_nom']?></a>
	</div>
			<input name="action" type="hidden" id="action" value="<?php echo $action ?>">
			<input name="form" type="hidden" id="form" value="form_catpage">
			<input name="id" type="hidden" id="id" value="<?php echo $id ?>" />
    <ul class="nav navbar-nav navbar-right">
      <li><?php echo $btnAction ?></li>
      <li><a href="<?php echo $_SESSION['urlc'] ?>"><span class="glyphicon glyphicon-file"></span> ADD NEW</a></li>
    </ul>
    
</div>
	<div class="page-header">
    	<h1><span class="label label-default"><?php echo $id ?></span> <?php echo $titForm ?></h1>
    </div>
	<?php fnc_log(); ?>
<div class="well well-sm">
	<fieldset class="form-horizontal">
		<div class="form-group">
			<label class="col-lg-3 control-label" for="cat_nom">Name</label>
			<div class="col-lg-9">
				<input name="cat_nom" type="text" id="cat_nom" placeholder="Name for Category" value="<?php echo $detCat['cat_nom']; ?>" class="form-control" required></div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label" for="cat_des">Description</label>
			<div class="col-lg-9">
				<input name="cat_des" type="text" id="cat_des" placeholder="Short description" value="<?php echo $detCat['cat_des']; ?>" class="form-control"></div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label" for="cat_url">URL</label>
			<div class="col-lg-9">
				<input name="cat_url" type="text" id="cat_url" placeholder="Friendly URL for category pages" value="<?php echo $detCat['cat_url']; ?>" class="form-control" required></div>
		</div>            
	</fieldset>
</div>
</form>
</div>
</body>
</html>