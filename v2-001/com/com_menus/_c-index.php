<?php
$TR=totRowsTab('tbl_menus','1','1');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->items = 50;
	$pages->paginate();
	$query_RSm = 'SELECT * FROM tbl_menus ORDER BY id DESC '.$pages->limit;
	$RSm = mysql_query($query_RSm) or die(mysql_error());
	$dRSm = mysql_fetch_assoc($RSm);
	$totalRows_RSm = mysql_num_rows($RSm);
}
?>
<div class="container">
<div class="btn-group pull-right">
    	<a href="index_items.php" class="btn btn-default"><span class="fa fa-eye"></span> Gestionar Items</a>
        <a href="form.php" class="btn btn-primary fancybox.iframe fancyreload"><span class="fa fa-plus fa-lg"></span> Nuevo</a>
    </div>
<?php echo genPageHead($dC['mod_cod'])?>

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
    <th>Items</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$det_id=$dRSm['id'];
	$det_nom=$dRSm['nom'];
	$det_ref=$dRSm['ref'];
	$det_stat=$dRSm['stat'];
	$btnStat=fncStat('_fncts.php',array("id"=>$det_id, "val"=>$det_stat,"acc"=>'STMC',"url"=>$_SESSION['urlc']));
	$totI=totRowsTab('tbl_menus_items','men_idc',$det_id);
	
	?>
	  <tr>
        <td><?php echo $det_id ?></td>
		<td><?php echo $btnStat ?></td>
        <td><?php echo $det_nom ?></td>
        <td><?php echo $det_ref ?></td>
        <td><?php echo $totI ?></td>
        <td><div class="btn-group">
          <a href="form.php?id=<?php echo $det_id ?>" class="btn btn-primary btn-xs fancybox.iframe fancyreload">
            <span class="fa fa-edit fa-lg"></span> Editar</a>
          <a href="fncts.php?id=<?php echo $det_id ?>&action=DELMC" class="btn btn-danger btn-xs">
            <span class="fa fa-trash fa-lg"></span> Eliminar</a></div>
        </td>
	    </tr>
	  <?php } while ($dRSm = mysql_fetch_assoc($RSm)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</html>