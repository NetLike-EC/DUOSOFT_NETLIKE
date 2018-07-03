<?php
$TR=totRowsTab('tbl_menus','1','1');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->items = 50;
	$pages->paginate();
	$query_RSm = 'SELECT * FROM tbl_menus ORDER BY id DESC '.$pages->limit;
	$RSm = mysqli_query($conn,$query_RSm) or die(mysqli_error($conn));
	$dRSm = mysqli_fetch_assoc($RSm);
	$totalRows_RSm = mysqli_num_rows($RSm);
}
?>
<div class="container">
<div class="btn-group pull-right">
    	<a href="index_items.php" class="btn btn-default"><span class="fa fa-eye"></span> Gestionar Items</a>
        <a href="form.php" class="btn btn-primary fancybox.iframe fancyreload"><?php echo $cfg[i]['new'].$cfg[b]['new'] ?></a>
    </div>
<?php echo genPageHead($dM['mod_cod'])?>

<?php sLOG('g');
if($totalRows_RSm>0){ ?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-2"><span class="label label-default"><strong><?php echo $TR ?></strong> Resultados</span></div>
        <div class="col-md-6">
			<ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
    	</div>
        <div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Nombre</th>
    <th>Ref</th>
	<th>Section</th>
    <th>Items</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$det_id=$dRSm['id'];
	$id=$dRSm['id'];
	$ids=md5($id);
	$det_nom=$dRSm['nom'];
	$det_ref=$dRSm['ref'];
	$btnStat=fncStat('_fncts.php',array("id"=>$det_id, "val"=>$dRSm['stat'],"acc"=>md5('STmc'),"url"=>$_SESSION['urlc']));
	$totI=totRowsTab('tbl_menus_items','men_idc',$det_id);
	$btnEdit='<a href="form.php?ids='.$ids.'" class="btn btn-primary btn-xs fancybox.iframe fancyreload">'.$cfg[i][edit].$cfg[b][edit].'</a>';
	$btnDel='<a href="fncts.php?ids='.$ids.'&acc='.md5(DELc).'&url='.$urlc.'" class="btn btn-danger btn-xs vAccL">'.$cfg[i][del].$cfg[b][del].'</a>';
	?>
	  <tr>
        <td><?php echo $id ?></td>
		<td><?php echo $btnStat ?></td>
        <td><?php echo $det_nom ?></td>
        <td><?php echo $det_ref ?></td>
		<td><?php echo $dRSm['sec'] ?></td>
        <td><?php echo $totI ?></td>
        <td>
			<div class="btn-group">
				<?php echo $btnEdit ?>
				<?php echo $btnDel ?>
			</div>
        </td>
	    </tr>
	  <?php } while ($dRSm = mysqli_fetch_assoc($RSm)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</html>