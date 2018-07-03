<?php
$TR=totRowsTabP('tbl_types');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qRS = 'SELECT * FROM tbl_types ORDER BY typ_cod DESC '.$pages->limit;
	$RS = mysqli_query($conn,$qRS) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
}
$btnNew='<a href="form.php" class="btn btn-primary pull-right"><i class="fa fa-plus fa-lg"></i> New</a>';
?>

<div class="page-header">
	<?php echo genPageTit(null,$dM['mod_nom'],$dM['mod_des'],$btnNew); ?>
</div>

<?php if($tRS>0){ ?>
<?php include(RAIZf.'paginator.php') ?>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Módulo</th>
    <th>Ref</th>
    <th>Nombre</th>
    <th>Valor</th>
    <th>icon</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do { ?>
	<?php $id=$dRS['typ_cod'];
	$ids=md5($id);
	$btnStat=fncStat('_fncts.php',array("ids"=>$ids, "val"=>$dRS['typ_stat'],"acc"=>md5('STt'),"url"=>$urlc));
	?>
	  <tr>
        <td><a href="form.php?ids=<?php echo $ids ?>"><?php echo $id ?></a></td>
		<td><?php echo $btnStat ?></td>
        <td><?php echo $dRS['mod_ref'] ?></td>
        <td><?php echo $dRS['typ_ref'] ?></td>        
        <td><?php echo $dRS['typ_nom'] ?></td>
        <td><?php echo $dRS['typ_val'] ?></td>
        <td><?php echo $dRS['typ_icon'] ?></td>
        <td class="text-center"><div class="btn-group">
          <a href="form.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-xs mini fancybox.iframe fancyreload">
            <i class="fa fa-pencil-square-o"></i> Edit</a>
          <a href="fncts.php?ids=<?php echo $ids ?>&acc=<?php echo md5('DELt') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
            <i class="fa fa-trash"></i> Del</a></div>
        </td>
	    </tr>
	  <?php } while ($dRS = mysqli_fetch_assoc($RS)) ?>
</tbody>
</table>
</div>
<?php }else{ ?>
<div class="alert alert-warning"><h4>Not Found Items !</h4></div>
<?php } ?>