<?php 
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$detC=detRow('db_mail_campaign','MD5(id)',$id);
if($detC){ 
	$acc=md5(UPDmc);
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> UPDATE</button>';
}else{
	$acc=md5(INScm);
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> INSERT</button>';
}
$btnNew='<a href="campaignForm.php" class="btn btn-default"><i class="fa fa-plus fa-lg"></i> NEW</a>';
$btnClon='<a href="fncts.php?id='.$id.'&acc='.md5(CLONmc).'" class="btn btn-default"><i class="fa fa-clone fa-lg"></i> CLONE</a>';
$btnOut='<a href="campaign.php" class="btn btn-default"><i class="fa fa-times fa-lg"></i> CLOSE</a>';
?>
<form action="fncts.php" method="post" enctype="multipart/form-data">
	<fieldset>
	<input type="hidden" name="form" value="<?php echo md5(formMC) ?>"/>
	<input type="hidden" name="id" value="<?php echo $id ?>"/>
	<input type="hidden" name="acc" value="<?php echo $acc ?>"/>
	<input type="hidden" name="url" value="<?php echo $urlc ?>"/>
	</fieldset>
	<div class="page-header">
    	<div class="btn-group pull-right">
        	<?php echo $btnAcc ?>
            <?php echo $btnNew ?>
            <?php echo $btnClon ?>
            <?php echo $btnOut ?>
        </div>
    	<span class="label label-default pull-left"><?php echo $rowMod['mod_nom'] ?></span>
        <h2><span class="label label-primary"><?php echo $detC['id'] ?></span> 
		<?php echo $detC['nom'] ?></h2>
    </div>
	<div>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Main Data</a></li>
		<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Images Resources</a></li>
		<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Mail HTML</a></li>
		<li role="presentation"><a href="#test" aria-controls="test" role="tab" data-toggle="tab">Send Test</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content well well-sm" style="background:#FFF">
	<div role="tabpanel" class="tab-pane active" id="home">
	<div class="row">
		<div class="col-sm-8">
		<fieldset class="form-horizontal">
		<div class="form-group">
			<label class="control-label col-sm-4">Date</label>
			<div class="col-sm-8">
				<input class="form-control" value="<?php echo $detC['date'] ?>" disabled/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4">Name</label>
			<div class="col-sm-8">
				<input class="form-control" name="iNom" value="<?php echo $detC['nom'] ?>" required/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4">Subject</label>
			<div class="col-sm-8">
				<input class="form-control" name="iSub" id="stSub" value="<?php echo $detC['subject'] ?>" required/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4">Reply To</label>
			<div class="col-sm-8">
				<input class="form-control" name="iRep" id="stRep" value="<?php echo $detC['reply'] ?>"/>
			</div>
		</div>
	</fieldset>
		</div>
		<div class="col-sm-4"></div>
	</div>

	</div>
	<div role="tabpanel" class="tab-pane" id="profile">
		<div><?php include('campaign_form_gall.php')?></div>
	</div>
	<div role="tabpanel" class="tab-pane" id="messages">
	<textarea name="iCon" class="form-control tmcef" id="stCon"><?php echo $detC['content'] ?></textarea>
	</div>
	<div role="tabpanel" class="tab-pane" id="test">
		<div><?php include('campaign_form_sendtest.php')?></div>
	</div>
	</div>
	</div>
</form>
<script type="text/javascript">
//Init tinymce
tinymce.init({
    selector: "textarea.tmcef",
	body_class: "contProdDes",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor code"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: " preview media | forecolor backcolor emoticons | code",
	image_advtab: true,
	convert_urls: false,
	extended_valid_elements : "i[class],strong/b",
	invalid_elements : "",
	valid_elements : '*[*]',
	content_css : "http://www.mercoframes.net/assets/css/bootstrap-yeti.min.css, http://www.mercoframes.net/assets/css/cssb_201505.css, http://www.mercoframes.net/assets/css/font-awesome.min.css",
	height : "480"
});
</script>