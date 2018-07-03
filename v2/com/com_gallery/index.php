<?php require('../../init.php');
fnc_accessnorm();
//$urlcurrent=basename($_SERVER['SCRIPT_FILENAME']);
$_SESSION['MODSEL'] = 'MGAL';
$rowMod=fnc_datamod($_SESSION['MODSEL']);

$param['stat']=vParam('paramStat',$_GET['paramStat'],$_POST['paramStat'],TRUE);
if($param['stat']!=NULL) $paramG['stat']=array('gall_stat','=',$param['stat']);
$paramSQL=getParamSQLA($paramG);

$qryPG = 'SELECT COUNT(*) AS TR FROM tbl_gallery WHERE 1=1 '.$paramSQL;
$RSpg = mysql_query($qryPG) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RSg = "SELECT * FROM tbl_gallery WHERE 1=1 ".$paramSQL." ORDER BY gall_id DESC ".$pages->limit;
$RSg = mysql_query($query_RSg) or die(mysql_error());
$row_RSg = mysql_fetch_assoc($RSg);
$totalRows_RSg = mysql_num_rows($RSg);
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<div class="container">
<div class="page-header">
<div class="row">
	<div class="col-sm-8"><?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?></div>
    <div class="col-sm-4 text-right"><a href="gall_form.php" class="btn btn-primary fancybox.iframe fancyTab"><span class="glyphicon glyphicon-plus"></span> New</a></div>
    
</div>
</div>
<?php sLOG('g'); ?>
<div class="well well-sm">
	<div class="row">
    	<div class="col-md-2"><span class="label label-default">Total Rows <?php echo $row_RSpg['TR'] ?></span></div>
		<div class="col-md-10">
			<form class="form-inline" method="post" action="<?php echo $urlc ?>">
				<span class="label label-default">Filters</span>
				<div class="form-group">
				<label>Status</label>
				<?php $lS=array('Enabled'=>'1', 'Disabled'=>'0');
				echo genSelectManual('paramStat', $lS, $param['stat'], 'form-control input-sm', NULL, NULL, NULL, TRUE, 'All', NULL) ?>
				</div>
				<button type="submit" class="btn btn-info btn-xs pull-right">Filter</button>
			</form>
   		</div>
    </div>
</div>
<div class="well well-sm">
	<div class="row">
		<div class="col-md-8"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-md-4 text-right"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>

<div>
    <?php if($totalRows_RSg>0){ ?>
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th>title</th>
    <th>Images</th>
    <th>View In</th>
    <th>Status</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$gallid=$row_RSg['gall_id'];
	$itemview=$row_RSg['itemview'];
	$dProd=detItem($itemview);
	$galltit=$row_RSg['gall_tit'];
	$gallspan=$row_RSg['gall_span'];
	$status=$row_RSg['gall_stat'];
    $numimg=totRowsTab('tbl_gallery_items','gall_id',$gallid);
	$btnStat=fncStat('_fncts.php',array("ids"=>$gallid, "val"=>$status,"acc"=>'ST'));
	$qRSgr=sprintf('SELECT * FROM tbl_gallery_ref WHERE idg=%s',
				  SSQL($gallid,'int'));
	$RSgr=mysql_query($qRSgr)or die(mysql_error());
	$dRSgr=mysql_fetch_assoc($RSgr);
	$tRSgr=mysql_num_rows($RSgr);
	$viewDet=NULL;
	if($tRSgr>0){
		do{
			$viewDet.='<div>';
			//DEFAULT DATA
			$datViewNom='<span class="label label-default disabled">N / D</span>';
			$datViewlinkN='('.$dRSgr['idr'].')';
			$datViewlinkV='<span class="label label-default btn-xs">'.$datViewlinkN.'</span>';
			$datViewEstV='<span class="label label-danger btn-xs" data-toggle="tooltip" data-placement="right" title="No Reference Available">
			<i class="fa fa-times fa-lg fa-fw"></i></span>';
			
			//DATA VIEW ACOORDING REF: ITEM - ART
			switch($dRSgr['ref']){
				case 'ITEM':
					$datView=detRow('tbl_items','item_id',$dRSgr['idr']);
					if($datView){
						$datViewNom='<span class="label label-default btn-xs disabled">ITEM</span>';
						$datViewlink=$RAIZ0.'p/cms/'.$datView['item_aliasurl'];
						$datViewlinkN=$datView['item_cod'].' ('.$dRSgr['idr'].')';
						$datViewlinkV='<a class="label label-default btn-xs" href="'.$datViewlink.'" target="_blank">'.$datViewlinkN.'</a>';
						$datViewEst=$datView['item_status'];
						if($datViewEst) $datViewEstV='<span class="label label-success btn-xs" data-toggle="tooltip" data-placement="right" title="Reference active">
						<i class="fa fa-check fa-lg fa-fw"></i></span>';
						else $datViewEstV='<span class="label label-warning btn-xs" data-toggle="tooltip" data-placement="right" title="Reference disable">
						<i class="fa fa-exclamation fa-lg fa-fw"></i></span>';
					}
					case 'ART':
					$datView=detRow('tbl_articles','art_id',$dRSgr['idr']);
					if($datView){
						$datViewNom='<span class="label label-default btn-xs disabled">ART</span>';
						$datViewlink=$RAIZ0.'a/'.$datView['art_url'];
						$datViewlinkN=$datView['title'].' ('.$dRSgr['idr'].')';
						$datViewlinkV='<a class="label label-default btn-xs" href="'.$datViewlink.'" target="_blank">'.$datViewlinkN.'</a>';
						$datViewEst=$datView['status'];
						if($datViewEst) $datViewEstV='<span class="label label-success btn-xs" data-toggle="tooltip" data-placement="right" title="Reference active">
						<i class="fa fa-check fa-lg fa-fw"></i></span>';
						else $datViewEstV='<span class="label label-warning btn-xs" data-toggle="tooltip" data-placement="right" title="Reference disable">
						<i class="fa fa-exclamation fa-lg fa-fw"></i></span>';
					}
				break;
				
			}
			
			//if($dRSgr['ref'])
			//$viewDet=
			$viewDet.=$datViewNom.$datViewEstV.$datViewlinkV;
			$viewDet.='</div>';
		}while($dRSgr=mysql_fetch_assoc($RSgr));
	}
	?>
	<tr>
        <td align="center"><a href="gall_form.php?id=<?php echo $gallid ?>" class="fancybox.iframe fancyTab gallI"><?php echo $gallid ?></a></td>
        <td><?php echo $galltit ?></td>
        <td style="text-align:center"><?php echo $numimg ?></td>
        <td><?php echo $viewDet ?></td>
        <td class="text-center"><?php echo $btnStat ?></td>
        <td class="text-center">
        <div class="btn-group">
        <a href="gall_form.php?id=<?php echo $gallid ?>" class="btn btn-primary btn-xs fancybox.iframe fancyTab" rel="gallB"><i class="fa fa-pencil-square-o"></i> Edit</a>
        <a href="_fncts.php?ids=<?php echo md5($gallid) ?>&acc=<?php echo md5('DELGALL') ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Del</a>
        </div>
        </td>
	    </tr>
	  <?php } while ($row_RSg = mysql_fetch_assoc($RSg)); ?>
</tbody>
</table>
<?php }else{ echo '<div class="alert"><h4>Not Found Galls !</h4></div>'; } ?>
</div>

<div class="well well-sm">
	<div class="row">
    	<div class="col-md-8"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-md-4 text-right"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>

</div>
<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<?php include(RAIZf.'_foot.php') ?>