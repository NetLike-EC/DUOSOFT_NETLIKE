<?php require('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL'] = 'MOD';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_modules';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
if($row_RSpg['TR']>0){
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RSlist = "SELECT * FROM tbl_modules ORDER BY mod_cod DESC ".$pages->limit;
$RSlist = mysql_query($query_RSlist) or die(mysql_error());
$row_RSlist = mysql_fetch_assoc($RSlist);
$totalRows_RSlist = mysql_num_rows($RSlist);
}
include(RAIZf.'_head.php');
?>
<body>
<?php include(RAIZf.'_fra_top_min.php') ?>
<div class="container">
<div class="page-header">
	<h1><?php echo $rowMod['mod_nom'] ?> <small><?php echo $rowMod['mod_des'] ?></small>
    <div class="btn-group pull-right">
    <a href="form.php" class="btn btn-primary" rel="shadowbox;options={relOnClose:true}"><span class="glyphicon glyphicon-plus"></span> Create New</a>
	</div>
    </h1>
</div>
<?php fnc_log();
if($totalRows_RSlist>0){ ?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-lg-6"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-lg-6"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>
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
	$modCod=$row_RSlist['mod_cod'];
	$modNom=$row_RSlist['mod_nom'];
	$modRef=$row_RSlist['mod_ref'];
	$modDes=$row_RSlist['mod_des'];
	$status=$row_RSlist['mod_stat'];
	$status=fnc_status($modCod,$status,'fncts.php','STAT');
	?>
	  <tr>
        <td><?php echo $modCod ?></td>
		<td><?php echo $status ?></td>
        <td><?php echo $modRef ?></td>
        <td><a href="form.php?id=<?php echo $modCod ?>" rel="shadowbox[CAT];options={relOnClose:true}"><?php echo $modNom ?></a></td>
        <td><?php echo $modDes ?></td>
        <td><div class="btn-group">
          <a href="form.php?id=<?php echo $modCod ?>" rel="shadowbox[CATb];options={relOnClose:true}" class="btn btn-xs btn-primary">
            <span class="glyphicon glyphicon-edit"></span> Edit</a>
          <a href="fncts.php?id=<?php echo $modCod ?>&action=DEL" class="btn btn-xs btn-danger">
            <span class="glyphicon glyphicon-trash"></span> Del</a></div>
        </td>
	    </tr>
	  <?php } while ($row_RSlist = mysql_fetch_assoc($RSlist)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</body>
</html>