<?php
//Verifica si existen los parametros
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$detF=detRow('tbl_mod_attach','att_id',$id);
if ($detF){
	$acc=md5("UPDfile");
	if($detF['is_external']=='0') $file_link=$RAIZ0.'docs/'.$detF['att_link'];
	else $file_link=$detF['att_link'];
	$btnlink;
	if (verificar_url($file_link)) $btnlink='<a class="btn btn-info btn-sm disabled"><i class="glyphicon glyphicon-ok-sign glyphicon glyphicon-white"></i> Correct</a>';
	else $btnlink='<a class="btn btn-danger btn-sm disabled"><i class="glyphicon glyphicon-remove-sign glyphicon glyphicon-white"></i> Broken</a>';
	$btnAcc='<button id="vAcc" type="button" class="btn btn-success navbar-btn"><i class="fa fa-floppy-o"></i> UPDATE</button>';
}else{
	$acc=md5("INSfile");
	$btnAcc='<button id="vAcc" type="button" class="btn btn-primary navbar-btn"><i class="fa fa-floppy-o"></i> INSERT</button>';
}
$btnNew='<a href="file_form.php" class="btn btn-default navbar-btn"><i class="fa fa-plus"></i> NEW</a>';
$cssBody='cero'; ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Home</a></li>
    <li><a href="<?php echo $RAIZc ?>com_multimedia">Multimedia</a></li>
    <li><a href="<?php echo $RAIZc ?>com_files">Files</a></li>
    <li class="active">Form File</li>
</ul>
<form enctype="multipart/form-data" method="post" action="_fncts.php" class="form-horizontal">
<fieldset>
<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
<input name="form" type="hidden" id="form" value="<?php echo md5('formFile') ?>">
<input name="id" type="hidden" id="id" value="<?php echo $id ?>" />
<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
<input name="fileorig" type="hidden" id="fileorig" value="<?php echo $detF['att_link'] ?>">
<input name="external" type="hidden" id="external" value="<?php echo $detF['is_external']?>">
</fieldset>
<div class="container">
	<div class="page-header">
    	<span class="label label-default pull-left"><?php echo $rowMod['mod_nom']?></span>
    	<div class="btn-group pull-right">
			<?php echo $btnAcc ?>
			<?php echo $btnNew ?>
		</div>
    	<h1><span class="label label-info"><?php echo $detF['att_id'] ?></span> <?php echo $detF['att_title'] ?></h1>
    </div>
	<?php sLOG('g') ?>    
    <div class="row">
            <div class="col-md-7">
            <fieldset class="well well-sm">
            <div class="form-group">
                <label class="control-label col-sm-4" for="txt_cod">Title</label>
                <div class="col-sm-8">
                <input name="title" type="text" id="title" placeholder="Title for file" class="form-control" value="<?php echo $detF['att_title'] ?>"></div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="chosTypI">Multiple Items View</label>
                <div class="col-sm-8">
				<?php echo generarselect("valSelI[]",detRowGSel('tbl_items','item_id','item_cod','item_status','1',' ORDER BY item_id DESC'),detRowSel('tbl_mod_attach_item','item_id','att_id',$id),'form-control', 'multiple', 'chosTypI','Select One or Multiple',FALSE); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="chosTyp">Multiple Categories View</label>
                <div class="col-sm-8">
                <?php echo generarselect("valSelC[]",detRowGSel('tbl_items_type','typID','typNom','typEst','1','ORDER BY sVAL ASC'),detRowSel('tbl_mod_attach_cat','typID','att_id',$id),'form-control', 'multiple', 'chosTyp','Select One or Multiple',FALSE); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="chosBrand">Multiple Brands View</label>
                <div class="col-sm-8">
                <?php echo generarselect("valSelB[]",detRowGSel('tbl_items_brands','id','name','status','1'),detRowSel('tbl_mod_attach_brand','b_id','att_id',$id),'form-control', 'multiple', 'chosBrand','Select One or Multiple',FALSE); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-4">Status</label>
              <div class="col-sm-8">
                <label class="radio inline">
                <input type="radio" name="status" value="1" <?php if ((!(strcmp(1, $detF['att_status'])))||($acc=='INS')) {echo ' checked ';} ?>>Active</label>
                <label class="radio inline">
                <input type="radio" name="status" value="0" <?php if (!(strcmp(0, $detF['att_status']))) {echo ' checked ';} ?>>Inactive</label>
              </div>
            </div>
            </fieldset>
            </div>
            <div class="col-md-5">
            <div class="panel panel-primary">
            	<div class="panel-heading"><i class="fa fa-file fa-lg"></i> File location</div>
                <div class="panel-body">
					<fieldset class="well well-sm">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="file">Actual File</label>
                        <div class="col-sm-8">
                        <?php if($file_link){ ?>
                        <a href="<?php echo $file_link ?>" rel="shadowbox"><abbr title="<?php echo $file_link ?>">File Link</abbr></a>
                         <?php echo $btnlink; ?>
                         	<?php if($detF['is_external']==1){ ?><span class="label label-success">External</span>
                            <?php }else if($detF['is_external']==0){ ?><span class="label label-success">Uploaded</span>
                            <?php }else{ ?><span class="label label-warning">Not Defined</span>
                            <?php }?>
                         
                         <?php }else{ ?>
                         <span class="label label-default">NONE</span>
						 <?php } ?>
                        </div>
                    </div>
                    </fieldset>
                    <div role="tabpanel">
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="<?php if ((!(strcmp(0, $detF['is_external'])))||($acc=='INS')) {echo 'active';} ?>"><a href="#upl" aria-controls="upl" role="tab" data-toggle="tab">File Upload</a></li>
                        <li role="presentation" class="<?php if (!(strcmp(1, $detF['is_external']))) {echo 'active';} ?>"><a href="#ext" aria-controls="ext" role="tab" data-toggle="tab">Link External</a></li>
                      </ul>
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane <?php if ((!(strcmp(0, $detF['is_external'])))||($acc=='INS')) {echo 'active';} ?>" id="upl">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="file">File Upload</label>
                                <div class="col-sm-8"><input name="file" type="file" id="file" class="col-md-10"/></div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane <?php if (!(strcmp(1, $detF['is_external']))) {echo 'active';} ?>" id="ext">
                        	<div class="form-group">
                                <label class="control-label col-sm-4" for="txt_cod">Link</label>
                                <div class="col-sm-8">
                                <input name="link" type="text" id="link" placeholder="New link here" class="form-control input-block-level"></div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            
            </div>
            
            </div>
	</div>
</div>
</form>
<script type="text/javascript">
$(document).on('ready', function(){			
	$('#chosTypI').chosen();
	$('#chosTyp').chosen();
	$('#chosBrand').chosen();
});
</script>
</body>
</html>