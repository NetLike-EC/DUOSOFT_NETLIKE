<?php 
$TR=totRowsTab('tbl_articles_cat');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qry = "SELECT * FROM tbl_articles_cat WHERE cat_id>1 ORDER BY cat_id DESC ".$pages->limit;
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
}
$btnNew=genLink('catForm.php',$cfg[i]['new'].$cfg[b]['new'],$css='btn btn-primary') ?>
<?php echo genPageHeader($dM[id],'header','h1',NULL,NULL,$btnNew); ?>
<?php if($tRS>0){ ?>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th><?php echo $cfg[com_men][t_id] ?></th>
    <th></th>
    <th><?php echo $cfg[com_men][t_name] ?></th>
	<th><?php echo $cfg[com_men][t_par] ?></th>
    <th><?php echo $cfg[com_men][t_des] ?></th>
    <th><?php echo $cfg[com_men][t_ico] ?></th>
    <th><?php echo $cfg[com_men][t_url] ?></th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$id=$dRS['cat_id'];
	$ids=md5($id);
	$idp=$dRS['cat_idp'];
	$detCP=null;
	if($idp) $detCP=detRow('tbl_articles_cat','cat_id',$idp);
	$btnStat=fncStat('_fncts.php',array("ids"=>md5($id), "val"=>$dRS['cat_status'],"acc"=>md5('STATac'),"url"=>$urlc));
	$btnEdit='<a href="catForm.php?ids='.$ids.'" class="btn btn-xs btn-primary">'.$cfg[i][edit].$cfg[b][edit].'</a>';
	$btnDel='<a href="_fncts.php?ids='.$ids.'&acc='.md5('DELac').'&url='.$urlc.'" class="btn btn-xs btn-danger vAccL">'.$cfg[i][del].$cfg[b][del].'</a>';
	?>
	  <tr>
        <td><a href="catForm.php?ids=<?php echo $ids ?>"><?php echo $id ?></a></td>
		<td><?php echo $btnStat ?></td>
        <td><?php echo $dRS['cat_nom'] ?></td>
		<td><?php echo $detCP['cat_nom'] ?></td>
        <td><?php echo $dRS['cat_des'] ?></td>
        <td><?php echo $dRS['cat_icon'] ?></td>
        <td><?php echo $dRS['cat_url'] ?></td>
        <td class="text-center">
			<div class="btn-group"><?php echo $btnEdit.$btnDel ?></div>
        </td>
	    </tr>
	  <?php } while ($dRS = mysqli_fetch_assoc($RS)); ?>
</tbody>
</table>
</div>
<?php include(RAIZf.'paginator.php') ?>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>