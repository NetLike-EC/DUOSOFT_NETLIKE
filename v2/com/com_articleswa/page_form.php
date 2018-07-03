<?php include('../../init.php');
fnc_accessnorm();
mysql_select_db($db_conn_wa, $conn);
$_SESSION['MODSEL']='ARTPWA';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$action=fnc_verifiparam('action', $_GET['action'], $_POST['action']);
$detart=fnc_dataart($id);
if ($detart){
	$action="UPD";
	$titForm=$detart['title'];
	$image=fnc_image_exist($RAIZ0,'welchallyn/img/db/articles/',$detart['image']);
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
			<input name="form" type="hidden" id="form" value="form_page">
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
<ul class="nav nav-tabs">
  <li class="active"><a href="#gen" data-toggle="tab">General</a></li>
  <li><a href="#txt" data-toggle="tab">Texts</a></li>
  <li><a href="#mul" data-toggle="tab">Multimedia</a></li>
  <li><a href="#doc" data-toggle="tab">Documents</a></li>
  <li><a href="#seo" data-toggle="tab">Seach Optimization</a></li>
  <li><a href="#inf" data-toggle="tab">Information</a></li>
</ul>

<div class="panel panel-default">
  <div class="panel-body">
    <div class="tab-content">
  <div class="tab-pane active" id="gen">
  <!-- BEG GENERAL DATA -->
  <div class="row"> 
	<div class="col-lg-5">
    	<div class="well well-sm text-center">
			<a href="<?php echo $image ?>" rel="shadowbox"><img src="<?php echo $image ?>" style="max-height:100px; max-width:200px;"class="img-polaroid"/></a><br/>
			<input name="userfile" type="file" id="userfile"/>
            <input name="imagea" type="hidden" id="imagea" value="<?php echo $detart['image'] ?>">
		</div>
	</div>
	<div class="col-lg-7">
		<div class="well well-sm">
		<fieldset class="form-horizontal">
				<div class="form-group">
                	<label class="col-lg-3 control-label" for="title">title</label>
					<div class="col-lg-9">
                  <input name="title" type="text" id="title" placeholder="Identificator for product" value="<?php echo $detart['title']; ?>" class="form-control" required></div>
				</div>
                <div class="form-group">
                	<label class="col-lg-3 control-label" for="art_url">URL</label>
					<div class="col-lg-9">
                  <input name="art_url" type="text" id="art_url" placeholder="URL Friendly" value="<?php echo $detart['art_url']; ?>" class="form-control"></div>
				</div>
                <div class="form-group">
                	<label class="col-lg-3 control-label"><abbr title="If check is ACTIVE else INACTIVE">Options</abbr></label>
					<div class="col-lg-9">
                  <label class="checkbox inline">
  <input name="view_title" type="checkbox" id="inlineCheckbox1" value="1" <?php if (!(strcmp('1', $detart['view_title']))) {echo 'checked="CHECKED"';} ?>>title</label>
<label class="checkbox inline">
  <input name="view_image" type="checkbox" id="inlineCheckbox2" value="1" <?php if (!(strcmp('1', $detart['view_image']))) {echo 'checked="CHECKED"';} ?>>Image</label>
  <label class="checkbox inline">
  <input name="status" type="checkbox" id="inlineCheckbox3" value="1" <?php if (!(strcmp('1', $detart['status']))) {echo 'checked="CHECKED"';} ?>>ACTIVE</label>
</div>
				</div>
                <div class="form-group">
                	<label class="col-lg-3 control-label" for="">Category</label>
					<div class="col-lg-9">
                    	<?php echo generarselect("cat_id",listArtCats(),$detart['cat_id'],'form-control', 'required'); ?>
                    </div>
				</div>
                </fieldset>
                </div>
	</div>
</div>
  <!-- END GENERAL DATA -->
  </div>
  <div class="tab-pane" id="txt">
  <!-- BEG TEXTS -->
  <div class="row">
		<div class="col-lg-4">
        <legend>Intro Text</legend>
        <textarea id="short_des" name="short_des" class="tmce input-block-level" rows="10" placeholder="SHORT DESCRIPTION" ><?php echo $detart['short_des']; ?></textarea></div>
        <div class="col-lg-8">
        <legend>Full Text</legend>
        <textarea id="long_des" name="long_des" class="tmce input-block-level" rows="10" placeholder="LONG DESCRIPTION" ><?php echo $detart['long_des']; ?></textarea></div>
  </div>
            
  
  <!-- END TEXTS -->
  </div>
  <div class="tab-pane" id="mul"><div class="alert alert-warning"><h4>Working, Coding ...</h4></div></div>
  <div class="tab-pane" id="doc"><div class="alert alert-warning"><h4>Working, Coding ...</h4></div></div>
  <div class="tab-pane" id="seo">
  	<fieldset>
            <legend>SEO Options</legend>
				<div class="form-group">
                	<label class="col-lg-4 control-label" for="seo_title">title PAGE</label>
					<div class="col-lg-8">
                  <input name="seo_title" type="text" id="seo_title" placeholder="TAG title for html for Best indexed Google" value="<?php echo $detart['seo_title']; ?>" class="form-control"></div>
			  </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label" for="seo_metades">Metadescription</label>
					<div class="col-lg-8">
                  <input name="seo_metades" type="text" id="seo_metades" placeholder="TAG Metadescription for Best indexed Google" value="<?php echo $detart['seo_metades']; ?>" class="form-control"></div>
			  </div>
                
            </fieldset>
  </div>
  <div class="tab-pane" id="inf">
	<fieldset>
            <legend>Information</legend>
				<div class="form-group">
                	<label class="col-lg-4 control-label"><abbr title="Visits Number">Hits</abbr></label>
					<div class="col-lg-8">
                  <input type="text" class="form-control" disabled value="<?php echo $detart['hits']; ?>"></div>
			  </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label">Date Create</label>
					<div class="col-lg-8">
                  <input type="text" class="form-control" disabled value="<?php echo $detart['dcreate']; ?>"></div>
			  </div>
              <div class="form-group">
                  <label class="col-lg-4 control-label">Date Update</label>
					<div class="col-lg-8">
                  <input type="text" class="form-control" disabled value="<?php echo $detart['dupdate']; ?>"></div>
			  </div>
            </fieldset>
  </div>
</div>
  </div>
</div>
</form>
</div>
</body>
</html>