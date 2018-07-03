<?php 
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$det=detRow('tbl_items_type','md5(typID)',$ids);
if ($det){
	$acc=md5("UPDt");
	$img=vImg('data/img/cat/',$det['typImg']);
	//var_dump($img);
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc"><i class="fas fa-save"></i> UPDATE</button>';
}else{
	$acc=md5("INSt");
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc"><i class="fas fa-save"></i> SAVE</button>';
}
$btnNew='<a href="invCatForm.php" class="btn btn-default"><i class="far fa-file"></i> NEW</a>';
?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" class="form-horizontal">
<fieldset>
    <input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
    <input name="form" type="hidden" id="form" value="<?php echo md5('formTyp') ?>">
    <input name="ids" type="hidden" id="id" value="<?php echo $ids?>" />
    <input name="url" type="hidden" id="url" value="<?php echo $urlc ?>"/>
</fieldset>

	<?php echo genPageNavbar($dM['mod_cod']) ?>
	<div class="btn-group pull-right">
		<?php echo $btnAcc ?>
		<?php echo $btnNew ?>
	</div>
	<?php echo genPageHead(NULL,$det['typNom'],'h2', $det['typID']) ?>
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#formA" aria-controls="home" role="tab" data-toggle="tab">Data</a></li>
    <li role="presentation"><a href="#formB" aria-controls="profile" role="tab" data-toggle="tab">Description</a></li>
    <li role="presentation"><a href="#formC" aria-controls="messages" role="tab" data-toggle="tab">Other Information</a></li>
    <li role="presentation"><a href="#formD" aria-controls="messages" role="tab" data-toggle="tab">Operations</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content panel panel-default">
    <div role="tabpanel" class="tab-pane active panel-body" id="formA">
		<div class="row">
		<div class="col-md-5">
				<fieldset class="well well-sm text-center">
			<a href="<?php echo $img['n'] ?>" class="fancybox thumbnail"><img src="<?php echo $img['t'] ?>"/></a><br/>
			<label><input name="userfile" type="file" id="userfile"/></label>
			<input name="imagea" type="hidden" id="imagea" value="<?php echo $det['typImg'] ?>">
			</fieldset>
			</div>
		<div class="col-sm-7">
				<fieldset class="well well-sm form-horizontal">
					<div class="control-group">
						<label class="control-label" for="txt_cod">Name</label>
						<div class="controls">
						<input name="typNom" type="text" id="txt_nom" placeholder="descriptive name" class="form-control input-block-level" value="<?php echo $det['typNom'] ?>" required></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="txt_url">URL</label>
						<div class="controls">
						<input name="typUrl" type="text" id="txt_url" placeholder="Alias URL" class="form-control" value="<?php echo $det['typUrl'] ?>" required></div>
					</div>
					<div class="control-group">
					  <label class="control-label" for="typ_id">Type of View</label>
						<div class="controls">          
			  			<?php genSelect('typ_id', detRowGSel('tbl_types','typ_cod','typ_nom','typ_ref','InvTypeShow'), $det['typ_id'], 'form-control', 'required', NULL, NULL, TRUE, NULL, ""); ?>
						</div>
					</div>

					<div class="control-group">
					  <label class="control-label" for="txt_cod">Parent Category</label>
						<div class="controls">          
			  			<?php genSelect("typIDp",detRowGSel('tbl_items_type','typID','typNom','typEst','1'),$det['typIDp'],'form-control', 'required','idCP',NULL,TRUE,NULL,"") ?>
						</div>
					</div>
				</fieldset>
		</div>
		</div>
	</div>
    <div role="tabpanel" class="tab-pane panel-body" id="formB">
    	<textarea id="txt_des" name="typDes" class="form-control" rows="10" placeholder="Description of Category or LINK" ><?php echo $det['typDes']; ?></textarea>
    </div>
    <div role="tabpanel" class="tab-pane panel-body" id="formC">
    	<?php
		$qryLCR=sprintf('SELECT * FROM tbl_items_type WHERE typIDp=%s',
					   SSQL($det['typID'],'int'));
		$RSlcr=mysqli_query($conn,$qryLCR) or die (mysqli_error($conn));
		$dRSlcr=mysqli_fetch_assoc($RSlcr);
		$tRSlcr=mysqli_num_rows($RSlcr);
		
		$qryLIR=sprintf('SELECT * FROM tbl_items_type_vs 
		RIGHT JOIN tbl_items ON tbl_items_type_vs.item_id = tbl_items.item_id
		WHERE tbl_items_type_vs.typID=%s',
					   SSQL($det['typID'],'int'));
		$RSlir=mysqli_query($conn,$qryLIR) or die (mysqli_error($conn));
		$dRSlir=mysqli_fetch_assoc($RSlir);
		$tRSlir=mysqli_num_rows($RSlir);
		?>
    	<div class="row">
    		<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">List Subcategories <span class="badge"><?php echo $tRSlcr ?></span></div>
					<?php if($tRSlcr>0){ ?>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Estado</th>
						</tr>
					
					<?php do{ ?>
					<?php 
						if($dRSlcr['typEst']==1) $status='<label class="label label-info">Active</label>';
						else $status='<label class="label label-warning">Inactive</label>';
							  ?>
						<tr>
							<td><?php echo $dRSlcr['typID'] ?></td>
							<td><?php echo $dRSlcr['typNom'] ?></td>
							<td><?php echo $status ?></td>
						</tr>
					<?php }while($dRSlcr=mysqli_fetch_assoc($RSlcr)); ?>
					</table>
					<?php }else{ ?>
					<div class="panel-body">
						No data
					</div>
					<?php } ?>
				</div>
    		</div>
    		<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">List Items <span class="badge"><?php echo $tRSlir ?></span></div>
					<?php if($tRSlir>0){ ?>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>ID</th>
							<th>Code</th>
							<th>Name</th>
							<th>Status</th>
						</tr>
					
					<?php do{ ?>
					<?php 
						if($dRSlir['item_status']==1) $status='<label class="label label-info">Active</label>';
						else $status='<label class="label label-warning">Inactive</label>';
							  ?>
						<tr>
							<td><?php echo $dRSlir['item_id'] ?></td>
							<td><?php echo $dRSlir['item_cod'] ?></td>
							<td><?php echo $dRSlir['item_nom'] ?></td>
							<td><?php echo $status ?></td>
						</tr>
					<?php }while($dRSlir=mysqli_fetch_assoc($RSlir)); ?>
					</table>
					<?php }else{ ?>
					<div class="panel-body">
						No data
					</div>
					<?php } ?>
				</div>
    		</div>
    	</div>
    </div>
    <div role="tabpanel" class="tab-pane panel-body" id="formD">
    	<?php if($det){ ?>
    	<a href="invCatM.php?ids=<?php echo $ids ?>" class="btn btn-primary fancybox.iframe fancyTab fancyreload"><i class="fas fa-exchange-alt"></i> Migrate</a>
    	<a href="_fncts.php?ids=<?php echo $ids ?>&acc=<?php echo md5('DELc') ?>&url=invCat.php" class="btn btn-danger"><i class="fas fa-trash"></i> </i>Delete</a>
    	<?php } ?>
    </div>
  </div>
   
</form>
<script type="text/javascript">
$(document).on('ready', function(){			
	$('#idCP').chosen();
});
</script>