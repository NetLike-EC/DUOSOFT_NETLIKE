<?php require('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL'] = 'ARTPWA';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
mysql_select_db($db_conn_wa, $conn);
$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_articles';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
if($row_RSpg['TR']>0){
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RS = "SELECT * FROM tbl_articles ORDER BY art_id DESC ".$pages->limit;
$RS = mysql_query($query_RS) or die(mysql_error());
$row_RS = mysql_fetch_assoc($RS);
$totalRows_RS = mysql_num_rows($RS);
}
include(RAIZf.'_head.php');
?>
<body>
<?php include(RAIZf.'_fra_top_min.php') ?>
<div class="container">
<div class="page-header">
	<div class="row">
	<div class="col-md-8"><?php echo genPageTit($wp2,$rowMod['mod_nom'],$rowMod['mod_des']); ?></div>
    <div class="col-md-4"><a href="page_form.php" class="btn btn-primary btn-block" rel="shadowbox;options={relOnClose:true}"><span class="glyphicon glyphicon-plus"></span> Create New</a></div>
    </div>
</div>
<?php fnc_log(); ?>
<?php if($totalRows_RS>0){ ?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-8"><ul class="pagination cero"><?php echo $pages->display_pages() ?></ul></div>
        <div class="col-md-4"><?php echo $pages->display_items_per_page() ?></div>
    </div>
</div>
<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
	<th></th>
    <th>title</th>
    <th>Category</th>
    <th>Image</th>
    <th>Date</th>
    <th>Hits</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$artid=$row_RS['art_id'];
	$artcat=$row_RS['cat_id'];
	$detcat=fnc_dataartc($artcat);
	$title=$row_RS['title'];
	$image=$row_RS['image'];
	$artimg=fnc_image_exist($RAIZ0,'welchallyn/img/db/articles/',$image);
	$artimgt=fnc_image_exist($RAIZ0,'welchallyn/img/db/articles/t_',$image);
	
	$vimage=$row_RS['view_image'];
	$create=$row_RS['dcreate'];
	if($update) $update='<abbr title="'.$update.'"><small class="muted">Update</small></abbr>';
	$hits=$row_RS['hits'];
	$status=$row_RS['status'];
	$status=fnc_status($artid,$row_RS['status'],'_fncts.php','STAT');
	$seotit=$row_RS['seo_title'];
	$seomd=$row_RS['seo_metades'];
	if($seotit) $seotit='<abbr title="'.$seotit.'" class="label label-default">Tit</abbr>';
	if($seomd) $seomd='<abbr title="'.$seomd.'" class="label label-default">Mdes</abbr>';
	
	?>
	  <tr>
        <td><?php echo $artid ?></td>
        <td><?php echo $status ?></td>
        <td><a href="page_form.php?id=<?php echo $artid?>" rel="shadowbox[PAG];options={relOnClose:true}"><?php echo $title ?></a></td>
        <td><small><?php echo $detcat['cat_nom'] ?></small></td>
        <td><a href="<?php echo $artimg ?>" rel="shadowbox[Pictures]" title="<?php echo $title ?>">
         <img src="<?php echo $artimgt ?>" class="img-rounded img-mini"/></a></td>
		<td><small><small><?php echo $create?></small></small></td>
        <td><?php echo $hits ?></td>
        <td><div class="btn-group">
        <a href="page_form.php?id=<?php echo $artid ?>" rel="shadowbox[FILES];options={relOnClose:true}" class="btn btn-primary btn-xs">
        <i class="glyphicon glyphicon-edit"></i> Edit</a>
        <a href="_fncts.php?id=<?php echo $artid ?>&action=DEL" class="btn btn-danger btn-xs" onClick="return aconfirm('DEL')">
        <i class="glyphicon glyphicon-trash"></i> Del</a></div>
        </td>
	    </tr>
	  <?php } while ($row_RS = mysql_fetch_assoc($RS)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</body>
</html>