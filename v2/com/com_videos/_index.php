<?php $query_pg = 'SELECT COUNT(*) AS TR FROM tbl_mod_videos';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RSlv = "SELECT vid_id as vID, itemview as vIV, vid_title as vTIT, vid_code as vCOD, vid_status as vSTAT FROM tbl_mod_videos ORDER BY vid_id DESC ".$pages->limit;
$RSlv = mysql_query($query_RSlv) or die(mysql_error());
$dRSlv = mysql_fetch_assoc($RSlv);
$tRSlv = mysql_num_rows($RSlv);
?>
<div>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-8"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>       
        <div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>
<div>
    <?php if($tRSlv>0){ ?>
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th>title</th>
    <!--<th>Embed Code</th>-->
    <th>View</th>
    <th>Item View</th>
    <th>Active</th>
    <th width="125px"></th>
</tr></thead>
<tbody>
	<?php do {
	$vidID=$dRSlv['vID'];
	$detIV=detRow('tbl_items','item_id',$dRSlv['vIV']);
	$btnStat=fncStat('_fncts.php',array("ids"=>md5($vidID), "val"=>$dRSlv['vSTAT'],"acc"=>md5('STATVID'),"url"=>$urlc));
	?>
	  <tr>
        <td><?php echo $vidID ?></td>
        <td><?php echo $dRSlv['vTIT']?></td>
        <!--<td><pre><small><?php //echo htmlspecialchars($vidCOD);?></small></pre></td>-->
        <td><a href="videoplay.php?id=<?php echo $vidID ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
            <i class="fa fa-video-camera" aria-hidden="true"></i></a>
        </td>
		  <td><span class="label label-default"><?php echo $detIV['item_id'] ?></span> <small><a href="<?php echo $RAIZ0 ?>p/cms/<?php echo $detIV['item_aliasurl'] ?>" target="_blank"><?php echo $detIV['item_cod'] ?></a> 
        </small></td>
        <td class="text-center"><?php echo $btnStat ?></td>
        <td><div class="btn-group">
        	<a href="videoForm.php?ids=<?php echo md5($vidID) ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit fa-lg"></i> Edit</a>
        	<a href="_fncts.php?ids=<?php echo md5($vidID) ?>&acc=<?php echo md5('DELVID') ?>&url=<?php echo urlc ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-lg"></i> Del</a>
        </div>
        </td>
	    </tr>
	  <?php } while ($dRSlv = mysql_fetch_assoc($RSlv)); ?>
</tbody>
</table>
<?php }else{ echo '<div class="alert"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</div>