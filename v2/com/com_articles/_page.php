<?php
$TR=totRowsTab('tbl_articles');
if($TR>0){
	$idC=vParam('idC',$_GET['idC'],$_POST['idC']);
	if($idC) $param['idc']=array('cat_id','=',$idC);
	$paramSQL=getParamSQLA($param);
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$query_RS = sprintf("SELECT * FROM tbl_articles WHERE 1=1 ".$paramSQL." ORDER BY art_id DESC %s",
	SSQL($pages->limit,''));
	$RS = mysqli_query($conn,$query_RS) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
}
$btnNew='<a href="pageForm.php" class="btn btn-primary">'.$cfg[i]['new'].$cfg[b]['new'].'</a>';
?>
<?php echo genPageHeader($dM[id],'header',NULL,NULL,NULL,$btnNew) ?>
<div class="well well-sm">
	<form action="<?php echo $urlc ?>" class="form-inline" method="post">
		<span class="label label-default"><?php echo $cfg[t][filters] ?></span> 
		<input type="hidden" name="view" value="<?php echo $view?>"/>
		<label><?php echo $cfg[t][category] ?></label>
		<?php echo genSelect('idC', detRowGSel('tbl_articles_cat','cat_id','cat_nom','cat_status','1','ORDER BY cat_nom ASC'), $idC, 'form-control input-sm') ?>
	</form>
</div>
<?php if($tRS>0){ ?>

	
	<form method="post" action="_fncts.php">
    <input type="hidden" name="acc" value="<?php echo md5('BLOGP') ?>">
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered" id="itm_table">
		<thead>
			<tr>
			<th>ID</th>
			<th></th>
			<th><small>Status</small></th>
			<th><small>Featured</small></th>
			<th>title</th>
			<th>URL</th>
			<th>Category</th>
			<th>Image</th>
			<th>Date</th>
			<th>Hits</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
			<?php do {
			$id=$dRS['art_id'];
			$ids=md5($id);
			$detcat=detRow('tbl_articles_cat','cat_id',$dRS['cat_id']);
			$title=$dRS['title'];
			$image=$dRS['image'];
			$artimg=fnc_image_exist($RAIZ0,'data/img/blog/',$image);
			$artimgt=fnc_image_exist($RAIZ0,'data/img/blog/t_',$image);

			$vimage=$dRS['view_image'];
			$create=$dRS['dcreate'];
			if($update) $update='<abbr title="'.$update.'"><small class="muted">Update</small></abbr>';
			$hits=$dRS['hits'];
			$btnStat=fncStat('_fncts.php',array("ids"=>$ids, "val"=>$dRS['status'],"acc"=>md5(STATa),"url"=>$urlc));
			$btnFeat=fncStat('_fncts.php',array("ids"=>$ids, "val"=>$dRS['featured'],"acc"=>md5(FEATa),"url"=>$urlc));

			$seotit=$dRS['seo_title'];
			$seomd=$dRS['seo_metades'];
			if($seotit) $seotit='<abbr title="'.$seotit.'" class="label label-default">Tit</abbr>';
			if($seomd) $seomd='<abbr title="'.$seomd.'" class="label label-default">Mdes</abbr>';
			$btnDel='<a href="_fncts.php?ids='.$ids.'&acc='.md5(DELa).'&url='.$urlc.'" class="btn btn-danger btn-xs vAccL">'.$cfg[i][del].$cfg[b][del].'</a>';
			$btnEdit='<a href="pageForm.php?ids='.$ids.'" class="btn btn-primary btn-xs">'.$cfg[i][edit].$cfg[b][edit].'</a>';
			?>
			  <tr>
				<td><a href="pageForm.php?ids=<?php echo $ids?>"><?php echo $id ?></a></td>
				<td><input type="checkbox" class="cblis" name="lis[]" value="<?php echo $ids ?>"></td>
				<td><?php echo $btnStat ?></td>
				<td><?php echo $btnFeat ?></td>
				<td><?php echo $title ?></td>
				<td><?php echo $dRS['art_url'] ?></td>
				<td><small><?php echo $detcat['cat_nom'] ?></small></td>
				<td><a href="<?php echo $artimg ?>" class="fancybox" title="<?php echo $title ?>">
				 <img src="<?php echo $artimgt ?>" class="img-rounded img-mini"/></a></td>
				<td><small><small><?php echo $create?></small></small></td>
				<td><?php echo $hits ?></td>
				<td class="text-center">
					<div class="btn-group">
						<?php echo $btnEdit.$btnDel; ?>
					</div>
				</td>
				</tr>
			  <?php } while ($dRS = mysqli_fetch_assoc($RS)); ?>
		</tbody>
	</table>
	</div>
	<?php include(RAIZf.'multiselect.php') ?>
	</form>
	<?php include(RAIZf.'paginator.php') ?>
	<script type="text/javascript">
	$(document).ready(function(){ $("#checkallcb").change(function(){ $(".cblis").prop('checked', $(this).prop("checked")); }); });
    </script>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
<script type="text/javascript">
	$("#idC").change(function(){
	window.location.href = "?idC="+$("#idC").val();
});
</script>