<?php
$TR = totRowsTab('db_componentes',1,1);
if($TR>0){
$pages = new Paginator;
$pages->items_total = $TR;
$pages->mid_range = 8;
$pages->paginate();
$query_RSc = "SELECT * FROM db_componentes ORDER BY mod_cod DESC ".$pages->limit;
$RSc = mysql_query($query_RSc) or die(mysql_error());
$dRSc = mysql_fetch_assoc($RSc);
$trRSc = mysql_num_rows($RSc);
}
?>
<div class="container">

<div class="btn-group pull-right">
		<a href="form.php" class="btn btn-primary fancybox.iframe fancyreload"><span class="fa fa-plus"></span> Nuevo</a>
    </div>
<?php echo genPageHead($dC['mod_cod'])?>
<?php sLOG('g');
if($trRSc>0){ ?>
<?php include(RAIZf.'paginator.php')?>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Ref</th>
    <th>Name</th>
    <th>Description</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$modCod=$dRSc['mod_cod'];
	$modNom=$dRSc['mod_nom'];
	$modRef=$dRSc['mod_ref'];
	$modDes=$dRSc['mod_des'];
	$btnStat=fncStat('fncts.php',array("id"=>$dRSc['mod_cod'], "val"=>$dRSc['mod_stat'],"acc"=>'ST',"url"=>$_SESSION['urlc']));
	?>
	  <tr>
        <td><?php echo $modCod ?></td>
		<td><?php echo $btnStat ?></td>
        <td><?php echo $modRef ?></td>
        <td><a href="form.php?id=<?php echo $modCod ?>" class="fancybox.iframe fancyreload"><?php echo $modNom ?></a></td>
        <td><?php echo $modDes ?></td>
        <td><div class="btn-group">
          <a href="form.php?id=<?php echo $modCod ?>" class="btn btn-primary btn-xs fancybox.iframe fancyreload">
            <span class="fa fa-edit"></span> Edit</a>
          <a href="fncts.php?id=<?php echo $modCod ?>&action=DEL" class="btn btn-danger btn-xs">
            <span class="fa fa-trash"></span> Del</a></div>
        </td>
	    </tr>
	  <?php } while ($dRSc = mysql_fetch_assoc($RSc)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</html>