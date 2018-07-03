<?php require('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL'] = 'ARTCWA';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
mysql_select_db($db_conn_wa, $conn);
$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_articles_cat WHERE cat_id>1';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
if($row_RSpg['TR']>0){
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RSlist = "SELECT * FROM tbl_articles_cat WHERE cat_id>1 ORDER BY cat_id DESC ".$pages->limit;
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
	<div class="row">
	<div class="col-md-8"><?php echo genPageTit($wp2,$rowMod['mod_nom'],$rowMod['mod_des']); ?></div>
    <div class="col-md-4"><a href="cat_form.php" class="btn btn-primary btn-block" rel="shadowbox;options={relOnClose:true}"><span class="glyphicon glyphicon-plus"></span> Create New</a></div>
    </div>
</div>
<?php fnc_log();
if($totalRows_RSlist>0){ ?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-lg-8"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-lg-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Name</th>
    <th>Description</th>
    <th>URL</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$catid=$row_RSlist['cat_id'];
	$catnom=$row_RSlist['cat_nom'];
	$catdes=$row_RSlist['cat_des'];
	$caturl=$row_RSlist['cat_url'];
	$status=$row_RSlist['cat_status'];
	$status=fnc_status($catid,$status,'_fncts.php','STAT');
	?>
	  <tr>
        <td><?php echo $catid ?></td>
		<td><?php echo $status ?></td>
        <td><a href="cat_form.php?id=<?php echo $catid ?>" rel="shadowbox[CAT];options={relOnClose:true}"><?php echo $catnom ?></a></td>
        <td><?php echo $catdes ?></td>
        <td><?php echo $caturl ?></td>
        <td><div class="btn-group">
        <a href="cat_form.php?id=<?php echo $catid ?>" rel="shadowbox[CATb];options={relOnClose:true}" class="btn btn-xs btn-primary">
        <span class="glyphicon glyphicon-edit"></span> Edit</a>
        <a href="_fncts.php?id=<?php echo $catid ?>&action=DEL" class="btn btn-xs btn-danger">
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