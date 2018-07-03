<?php 
$ids=fnc_verifiparam('ids', $_GET['ids'], $_POST['ids']);
$det=detRow('tbl_items','md5(item_id)',$ids);
if ($det){
	$acc=md5('UPDi');
	$id=$det['item_id'];
	$item_img=vImg('data/img/item/',$det['item_img']);
	$status=$det['item_status'];
	if ($status=='1') $classStat['enable']='btn-info active';
	else if ($status=='0') $classStat['disable']='btn-danger active';
	$btnAcc='<button id="vAcc" class="btn btn-success" type="button"><i class="fas fa-save"></i> UPDATE</button>';
	$btnClon='<a href="_fncts.php?ids='.md5($ids).'&acc='.md5('CLONI').'&url='.$urlc.'" class="btn btn-default"><i class="fa fa-files-o" aria-hidden="true"></i> CLONE</a>';
}else { 
	$acc=md5("INSi");
	$btnAcc='<button id="vAcc" class="btn btn-primary" type="button"><i class="fas fa-save"></i> INSERT</button>';
}
$btnNew='<a href="invItemForm.php" class="btn btn-default"><i class="far fa-file"></i> NEW</a>';
?>
<form enctype="multipart/form-data" method="post" action="_fncts.php">
    <fieldset>
        <input name="form" type="hidden" id="form" value="<?php echo md5('formProd') ?>" />
        <input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>" />
        <input name="ids" type="hidden" id="ids" value="<?php echo $ids ?>" />
        <input name="url" type="hidden" id="url" value="<?php echo $_SESSION['urlc']?>"/>
    </fieldset>
	
	<?php echo genPageNavbar($dM['mod_cod']) ?>
	<div class="btn-group pull-right">
		<?php echo $btnAcc ?>
		<?php echo $btnNew ?>
		<?php echo $btnClon ?>
	</div>
	<?php echo genPageHead(NULL,$det['item_nom'],'h2', $det['item_id']) ?>
	
<!-- Nav tabs -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#gen" data-toggle="tab">General</a></li>
      <li><a href="#des" data-toggle="tab">Description</a></li>
      <li><a href="#spec" data-toggle="tab">Specification</a></li>
      <li><a href="#pic" data-toggle="tab">Gallery</a></li>
      <li><a href="#store" data-toggle="tab">Store</a></li>
    </ul>
	<!-- Tab panes -->
    <div class="tab-content well">
		<div class="tab-pane active" id="gen">
		<div class="row">
    	<div class="col-lg-7">
        <fieldset class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="txt_cod">CODE</label>
                <div class="col-sm-9">
                <input name="txt_cod" type="text" id="txt_cod" placeholder="Identificator for product" class="form-control" value="<?php echo htmlspecialchars($det['item_cod']) ?>" required autofocus></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="txt_cod">Name</label>
                <div class="col-sm-9">
                <input name="txt_nom" type="text" id="txt_nom" placeholder="descriptive name for product" class="form-control" value="<?php echo htmlspecialchars($det['item_nom']) ?>" required></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="txt_alias">Alias URL</label>
                <div class="col-sm-9">
                <input name="txt_alias" type="text" id="txt_alias" placeholder="Alias URL Friendly" class="form-control input-sm " value="<?php echo $det['item_aliasurl']; ?>"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="txt_brand">Brand</label>
                <div class="col-sm-9">
                <?php echo genSelect('txt_brand', detRowGSel('tbl_items_brands','id','name','status','1'), $det['brand_id'], 'form-control input-sm '); ?> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="chosTyp">Categories Groups</label>
                <div class="col-sm-9">
                <?php echo genSelect("valSel[]",detRowGSel('tbl_items_type','typID','typNom','typEst','1'),detRowSel('tbl_items_type_vs','typID','item_id',$id),'form-control', 'multiple', 'chosTyp','Select One or Multiple',FALSE); ?> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="txt_cod">Ref # ID</label>
                <div class="col-sm-9">
                <input name="txt_ref" type="text" id="txt_ref" placeholder="CODE refer" class="form-control input-sm " value="<?php echo $det['item_ref']; ?>"></div>
                </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Status</label>
                <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-info btn-xs <?php if($status=='1') echo ' active '; ?>">
                <input type="radio" name="item_status" id="option1" value="1" <?php if($status=='1') echo ' checked '; ?>> Enable
                </label>
                <label class="btn btn-info btn-xs <?php if($status=='0') echo ' active '; ?>">
                <input type="radio" name="item_status" id="option2" value="0" <?php if($status=='0') echo ' checked '; ?>> Disable
                </label>
                </div>
                </div>
                </div>
		</fieldset>
		</div>
        <div class="col-lg-5">
        <div class="panel panel-default">
        	<div class="panel-heading">Image for Item</div>
            <div class="panel-body text-center">
            <fieldset class="form-horizontal">
                <div class="form-group">
                <a href="<?php echo $item_img['n'] ?>" class="fancybox">
                <img src="<?php echo $item_img['t'] ?>" class="img-thumbnail"/></a>
                <input name="userfile" type="file" id="userfile"/>
                <input name="imagea" type="hidden" id="imagea" value="<?php echo $det['item_img'] ?>">
                </div>
			</fieldset>
			</div>
        </div>
        
		</div>
    </div>
		</div>
      <div class="tab-pane" id="des">
      <textarea id="txt_des" name="txt_des" class="tmcef" ><?php echo $det['item_des'] ?></textarea>
      </div>
      
      <div class="tab-pane" id="spec">
      <textarea id="txt_spec" name="txt_spec" class="tmcef" ><?php echo $det['item_spec'] ?></textarea>
      </div>
      
		<div class="tab-pane" id="pic">
			<?php if ($id) include('_invItemFormGall.php');
			else echo $msgFS ?>
		</div>
		<div class="tab-pane" id="store">
			<?php if ($id) include('_invItemStore.php');
			else echo $msgFS ?>
		</div>
    </div>
    
	
	
    
</form>
<script type="text/javascript">
$(document).on('ready', function(){			
	$('#txt_brand').chosen();
	$('#chosTyp').chosen();
});
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
	content_css : "http://www.mercoframes.net/assets/css/bootstrap-yeti.min.css,http://www.mercoframes.net/assets/css/cssb_201505.css,http://www.mercoframes.net/assets/css/font-awesome.min.css",
	height : "480"
});
</script>