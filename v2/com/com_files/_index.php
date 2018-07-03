<?php 
$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_mod_attach';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RSlf = "SELECT * FROM tbl_mod_attach ORDER BY att_id DESC ".$pages->limit;
$RSlf = mysql_query($query_RSlf) or die(mysql_error());
$dRSlf = mysql_fetch_assoc($RSlf);
$tRSlf = mysql_num_rows($RSlf);
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php');
sLOG('g');
?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Home</a></li>
    <li><a href="<?php echo $RAIZc ?>com_multimedia">Multimedia</a></li>
    <li class="active">Files</li>
</ul>
<div class="container">
<div class="page-header">
<a href="file_form.php" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> New</a>
<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
</div>
<div class="well well-sm">
	<div class="row">
    	<div class="col-md-8"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-md-4"><?php echo $pages->display_items_per_page(); ?></div>
    </div>
</div>
<div>
    <?php if($tRSlf>0){ ?>
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th>title</th>
    <th>Link</th>
    <th>Valid</th>
    <th>External</th>
    <th>Item View</th>
    <th>Active</th>
    <th width="125px"></th>
</tr></thead>
<tbody>
	<?php do {
	$detprod=fnc_item($dRSlf['itemview']);
	if($dRSlf['is_external']=='0') $dRSlf['att_link']=$RAIZ0.'docs/'.$dRSlf['att_link'];
	if (verificar_url($dRSlf['att_link'])) $btnlink='<a class="btn btn-info btn-xs disabled">Correct</a>';
	else $btnlink='<a class="btn btn-danger btn-xs disabled">Broken</a>';
	if($dRSlf['is_external']==1){
		$vLink='<a href="'.$dRSlf['att_link'].'" class="fancybox fancybox.iframe"><i class="fa fa-external-link"></i> External Link</a>';
	}else if($dRSlf['is_external']==0){
		$vLink='<a href="'.$dRSlf['att_link'].'" class="fancybox fancybox.iframe"><i class="fa fa-folder"></i> '.$dRSlf['att_link'].'</a>';
	}else{$vLink='<span class="labe label-danger">Error not defined</span>';}
	$btnStat=fncStat('_fncts.php',array("id"=>$dRSlf['att_id'], "val"=>$dRSlf['att_status'],"acc"=>md5('STfile'),"url"=>$urlc));
	$btnExt=fncStat('_fncts.php',array("id"=>$dRSlf['att_id'], "val"=>$dRSlf['is_external'],"acc"=>md5('EXfile'),"url"=>$urlc));
	$urlEdit='file_form.php?id='.$dRSlf['att_id'];
	?>
	  <tr>
        <td><a href="<?php echo $urlEdit ?>" class="fancyreload"><?php echo $dRSlf['att_id'] ?></a></td>
        <td><?php echo $dRSlf['att_title'] ?></td>
        <td><?php echo $vLink ?></td>
        <td><?php echo $btnlink ?></td>
		<td><?php echo $btnExt?></td>
        <td>
        <a href="<?php echo $RAIZ0 ?>p/file/<?php echo $dRSlf['item_aliasurl'] ?>" target="_blank">
        <i class="fa fa-external-link"></i> 
        <span class="label label-default"><?php echo $dRSlf['itemview'] ?></span> 
        <small><?php echo $detprod['item_cod'] ?></small>
        </a>
        </td>
        <td><?php echo $btnStat?></td>
        <td>
        <div class="btn-group">
        <a href="<?php echo $urlEdit ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</a>
        <a href="_fncts.php?id=<?php echo $dRSlf['att_id'] ?>&acc=<?php echo md5('DELfile') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Del</a>
        </div>
        </td>
	    </tr>
	  <?php } while ($dRSlf = mysql_fetch_assoc($RSlf)); ?>
</tbody>
</table>
<?php }else{ echo '<div class="alert"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</div>