<?php //Verifica si existen los parametros
$id=fnc_verifiparam('ids', $_GET['ids'], $_POST['ids']);
$dVid = detRow('tbl_mod_videos','md5(vid_id)',$id); //fnc_vid($id);
if ($dVid){
	$acc=md5('UPDv');
	$vid_id=$dVid['vid_id'];
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> UPDATE</button>';
}else{
	$acc=md5('INSv');
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc"><i class="fa fa-plus fa-lg" aria-hidden="true"></i> SAVE</button>';
}
$qRSd = sprintf("SELECT item_id as sID, item_cod as sVAL FROM tbl_items WHERE item_status<>0 ORDER BY item_id DESC");
$RSd = mysql_query($qRSd) or die(mysql_error());
?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" class="form-horizontal">
	<input name="acc" type="hidden" id="action" value="<?php echo $acc ?>">
	<input name="form" type="hidden" id="form" value="<?php echo md5('form_video') ?>">
	<input name="ids" type="hidden" id="ids" value="<?php echo $id ?>" />
	<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
	<div class="btn-group pull-right">
	<?php echo $btnAcc ?>
	<a href="<?php echo $urlc ?>" class="btn btn-default"><i class="fa fa-file-o" aria-hidden="true"></i> NEW</a>
	</div>
	<div class="container">
		<div class="page-header"><h1><span class="label label-primary"><?php echo $vid_id ?></span> <?php echo $dVid['vid_title'] ?></h1></div>
			<div class="row">
				<div class="col-md-6">
				<fieldset class="well well-sm">
				<div class="control-group">
					<label class="control-label" for="txt_cod">Title</label>
					<div class="controls">
					<input name="iTIT" type="text" id="iTIT" placeholder="Title for this Media" class="form-control input-block-level" value="<?php echo $dVid['vid_title'] ?>"></div>
				</div>

				<div class="control-group">
	<label class="control-label">Itemview</label>
	<div class="controls">
	  <?php echo genSelect("iIV",$RSd,$dVid['itemview'],'form-control input-block-level', 'required'); ?>
	</div>
	</div>
				<div class="control-group">
					<label class="control-label">Status</label>
				  <div class="controls">
					<label class="radio inline">
					<input type="radio" name="iSTAT" value="1" <?php if (!(strcmp(1, $dVid['vid_status']))) {echo 'checked="CHECKED"';} ?>>Active</label>
					<label class="radio inline">
					<input type="radio" name="iSTAT" value="0" <?php if (!(strcmp(0, $dVid['vid_status']))) {echo 'checked="CHECKED"';} ?>>Inactive</label>
				  </div>
				</div>
				</fieldset>
				</div>
				<div class="col-md-6">
				<fieldset class="well well-sm">
					<label>Code Embed for Video</label>
					  <textarea name="iCOD" rows="8" class="form-control input-block-level" id="code" placeholder="Code Embed Here"><?php echo $dVid['vid_code'] ?></textarea>
				</fieldset>
				</div>
			</div>
	</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$('#iIV').chosen();
});
</script>