<?php 
//Verifica si existen los parametros
$id=fnc_verifiparam('ids', $_GET['ids'], $_POST['ids']);
$dCat=detRow('tbl_items_type','typID',$id);
if ($dCat){
	$acc=md5("UPDcat");
	$dCat_img=vImg('images/types/',$dCat['typImg']);
	$btnAcc='<button type="submit" class="btn btn-success" id="vAcc">UPDATE</button>';
}else{
	$acc=md5("INScat");
	$btnAcc='<button type="submit" class="btn btn-primary" id="vAcc">SAVE</button>';
}
$btnNew='<a href="invCatForm.php" class="btn btn-default">ADD NEW</a>';
?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" class="form-horizontal">
<fieldset>
    <input name="acc" type="hidden" value="<?php echo md5('MIGC') ?>">
    <input name="ids" type="hidden" value="<?php echo $id?>" />
    <input name="url" type="hidden" value="<?php echo $urlc ?>"/>
</fieldset>

<div class="container">
	<div class="page-header">
        <span class="label label-default pull-left">Category Items</span>
        <h2><span class="label label-primary"><?php echo $dCat['typID'] ?></span> <?php echo $dCat['typNom'] ?></h2>
    </div>
    
    <?php sLOG(''); ?>
    
    <div class="row">
    	<div class="col-sm-8">
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">ITEMS TO MIGRATE</h3>
				</div>
				<div class="panel-body">
				<div>
					<?php
					$qryLCR=sprintf('SELECT * FROM tbl_items_type WHERE typIDp=%s',
								   SSQL($dCat['typID'],'int'));
					$RSlcr=mysql_query($qryLCR) or die (mysql_error());
					$dRSlcr=mysql_fetch_assoc($RSlcr);
					$tRSlcr=mysql_num_rows($RSlcr);

					$qryLIR=sprintf('SELECT * FROM tbl_items_type_vs 
					RIGHT JOIN tbl_items ON tbl_items_type_vs.item_id = tbl_items.item_id
					WHERE tbl_items_type_vs.typID=%s',
								   SSQL($dCat['typID'],'int'));
					//echo $qryLIR;
					$RSlir=mysql_query($qryLIR) or die (mysql_error());
					$dRSlir=mysql_fetch_assoc($RSlir);
					$tRSlir=mysql_num_rows($RSlir);
					?>
					<div class="row">
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">List Subcategories</div>
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
								<?php }while($dRSlcr=mysql_fetch_assoc($RSlcr)); ?>
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
								<div class="panel-heading">List Items</div>
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
								<?php }while($dRSlir=mysql_fetch_assoc($RSlir)); ?>
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
				</div>
			</div>
			
			
    	</div>
    	<div class="col-sm-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Migrate To</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Category</label>
						<div class="col-sm-9">
							<?php
							$paramsN[]=array(
								array("cond"=>"AND","field"=>"typID","comp"=>"<>","val"=>$id)
							);
							$RS=detRowGSelNP('tbl_items_type','typID','typNom',$paramsN,TRUE,'typNom','ASC');
							genSelect('typIDp', $RS, NULL, 'form-control', 'required', 'idCP', NULL, TRUE, NULL, 'Select Category to Migrate');
							?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9 text-center">
							<button type="submit" class="btn btn-primary">MIGRAR</button>
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
	$('#idCP').chosen();
});
</script>