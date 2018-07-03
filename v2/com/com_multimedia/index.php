<?php require('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('MULTIM');
include(RAIZf.'_head.php'); ?>
<body>
<?php include(RAIZf.'_fra_top_min.php') ?>
<div class="container">
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>/com_index/">Home</a></li>
    <li class="active">Multimedia</li>
</ul>
<div class="page-header">
<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
</div>
<?php fnc_log(); ?>

	<div class="row">
    	<div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_files/">
            <i class="fa fa-file-o fa-4x"></i><h4>File</h4></a>
        </div>
    	<div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_gallery/">
            <i class="fa fa-picture-o fa-4x"></i><h4>Gallery</h4></a>
        </div>
		<div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_videos/">
            <i class="fa fa-video-camera fa-4x"></i><h4>Video</h4></a>
        </div>
        <div class="col-sm-3">
        	<a class="btn btn-default btn-block" href="<?php echo $RAIZc?>com_media/">
            <i class="fa fa-asterisk fa-4x"></i><h4>Media</h4></a>
        </div>
    </div>
</div>
</body>
</html>