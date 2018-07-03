<?php require('../../init.php');
fnc_accessnorm();
$urlcurrent=basename($_SERVER['SCRIPT_FILENAME']);
$_SESSION['MODSEL'] = 'MMED';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_mod_media';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
$totalRows_RSpg = mysql_num_rows($RSpg);
if($row_RSpg['TR']>0){
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RSlist = "SELECT * FROM tbl_mod_media ORDER BY med_id DESC ".$pages->limit;
$RSlist = mysql_query($query_RSlist) or die(mysql_error());
$row_RSlist = mysql_fetch_assoc($RSlist);
$totalRows_RSlist = mysql_num_rows($RSlist);
}
include(RAIZf.'_head.php'); ?>
<body>
<?php include(RAIZf.'_fra_top_min.php') ?>
<div class="container">
<div class="page-header">
<div class="row">
	<div class="col-md-8"><?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?></div>
    <div class="col-md-4"><a href="media_form.php" class="btn btn-primary btn-block" rel="shadowbox;options={relOnClose:true}"><span class="glyphicon glyphicon-plus"></span> Create New</a></div>
</div>
</div>
<?php fnc_log(); ?>
<?php if($totalRows_RSlist>0){ ?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-8"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-md-4"><?php echo $pages->display_items_per_page(); ?></div>
    </div>
</div>
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th>title</th>
    <th>Embed Code</th>
    <th>View</th>
    <th>Item View</th>
    <th>Active</th>
    <th width="125px"></th>
</tr></thead>
<tbody>
	<?php do {
	$vidid=$row_RSlist['med_id'];
	$itemview=$row_RSlist['itemview'];
	$detprod=fnc_item($itemview);
	$vidtit=$row_RSlist['med_tit'];
	$vidcode=$row_RSlist['med_code'];
	$status=$row_RSlist['med_status'];
	?>
	  <tr>
        <td align="center"><a href="video_form.php?id=<?php echo $vidid ?>&action=UPDATE" rel="shadowbox;options={relOnClose:true}"><?php echo $vidid ?></a></td>
        <td><?php echo $vidtit?></td>
        <td><pre><small><?php echo htmlspecialchars($vidcode);?></small></pre></td>
        <td><?php if($vidcode){?>
        	<a href="mediaplay.php?id=<?php echo $vidid ?>" class="btn btn-sm btn-inverse" rel="shadowbox">
            <i class="glyphicon glyphicon-eye-open glyphicon glyphicon-white"></i></a>
        <?php }?></td>
        <td><small><strong class="muted"><?php echo $itemview ?> : </strong> <a href="<?php echo $RAIZ0 ?>prods.php?iditem=<?php echo $itemview ?>" rel="shadowbox;width=800px"><?php echo $detprod['item_cod']; ?></a> 
        </small></td>
        <td align="center"><?php 
		if ($status=="1"){ ?>
          <a href="<?php echo '_fncts.php?id='.$vidid.'&stat=0&url='.$urlcurrent ?>" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i></a>
		<?php }
		if (($status=="0")||($status!="1")){ ?>
	      <a href="<?php echo '_fncts.php?id='.$vidid.'&stat=1&url='.$urlcurrent ?>" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
		<?php } ?>
		</td>
        <td align="center"><div class="btn-group">
        <a href="media_form.php?id=<?php echo $vidid ?>&action=UPDATE" rel="shadowbox[FILES];options={relOnClose:true}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> Edit</a>
        <a href="_fncts.php?id=<?php echo $vidid ?>&action=DELETE&url=<?php echo $urlcurrent ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Del</a>
        </div>
        </td>
	    </tr>
	  <?php } while ($row_RSlist = mysql_fetch_assoc($RSlist)); ?>
</tbody>
</table>
<?php }else{ echo '<div class="alert"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</body>
</html>