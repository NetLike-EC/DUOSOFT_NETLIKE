<?php $ids=fnc_verifiparam('ids', $_GET['ids'], $_POST['ids']);
$det = detRow('tbl_items_brands','md5(id)',$ids);
if ($det){
	$acc=md5('UPDb');
	$dID=$det['id'];
	$dNom=$det['name'];
	$dDes=$det['data'];
	$dUrl=$det['url'];
	$dImg=vImg('data/img/brand/',$det['img']);
	
	$item_stat=$det['status'];
	if ($item_stat=='1') $classStat['enable']='btn-info active';
	else if ($item_stat=='0') $classStat['disable']='btn-danger active';
	
	$btnAcc='<button id="vAcc" class="btn btn-success" type="button"><i class="fas fa-save"></i> UPDATE</button>';
}else {
	$acc=md5('INSb');
	$btnAcc='<button id="vAcc" class="btn btn-primary" type="button"><i class="fas fa-save"></i> INSERT</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default"><i class="far fa-file"></i> NEW</a>';
?>
<form enctype="multipart/form-data" method="post" action="_fncts.php">
    <fieldset>
        <input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
        <input name="form" type="hidden" id="form" value="<?php echo md5('formBrand') ?>">
        <input name="ids" type="hidden" id="ids" value="<?php echo $ids ?>" />
        <input name="url" type="hidden" id="url" value="<?php echo $urlc ?>"/>
    </fieldset>
	
	<?php echo genPageNavbar($dM['mod_cod']) ?>
	<div class="btn-group pull-right">
		<?php echo $btnAcc ?>
		<?php echo $btnNew ?>
	</div>
	<?php echo genPageHead(NULL,$dNom,'h2', $dID) ?>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#gen" data-toggle="tab">General</a></li>
      <li><a href="#des" data-toggle="tab">Description</a></li>
    </ul>
	<!-- Tab panes -->
    <div class="tab-content well well-sm">
      <div class="tab-pane active" id="gen"><div class="row">
            <div class="col-md-7">
                    <fieldset class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="iNom">Name</label>
                        <div class="col-sm-9">
                        	<input name="iNom" type="text" id="iNom" placeholder="descriptive name" class="form-control" value="<?php echo $dNom ?>">
						</div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="iUrl">Alias URL</label>
                        <div class="col-sm-9">
							<input name="iUrl" type="text" id="iUrl" placeholder="Alias URL" class="form-control" value="<?php echo $dUrl ?>">
						</div>
                    </div>
						<div class="form-group">
                <label class="col-sm-3 control-label">Status</label>
                <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-info btn-xs <?php if($item_stat=='1') echo ' active '; ?>">
                <input type="radio" name="iStat" id="option1" value="1" <?php if($item_stat=='1') echo ' checked '; ?>> Enable
                </label>
                <label class="btn btn-info btn-xs <?php if($item_stat=='0') echo ' active '; ?>">
                <input type="radio" name="iStat" id="option2" value="0" <?php if($item_stat=='0') echo ' checked '; ?>> Disable
                </label>
                </div>
                </div>
                </div>
                    </fieldset>
                    </div>
            <div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading">Image</div>
					<div class="panel-body text-center">
                    <fieldset>
                        <a href="<?php echo $dImg['n'] ?>" class="fancybox"><img src="<?php echo $dImg['t'] ?>" class="img-thumbnail"/></a><br/>
                        <label><input name="userfile" type="file" id="userfile"/></label>
                        <input name="imagea" type="hidden" id="imagea" value="<?php echo $dImg['f'] ?>">
						
						<div class="checkbox">
						<label>
						  <input type="checkbox" <?php if($det[vimg]==1) echo 'checked' ?>> View image in website
						</label>
					  </div>
						
                    </fieldset>
                    </div>
				</div>
                
                    </div>
        </div></div>
      	<div class="tab-pane" id="des">
      		<textarea id="iDes" name="iDes" class="tmcem" rows="20" style="height:300px;"><?php echo $dDes ?></textarea>
		</div>
    </div>
</form>