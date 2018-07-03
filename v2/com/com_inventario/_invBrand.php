<?php
$view=vParam('view',$_GET['view'],$_POST['view']);
if ($view=='TRASH'){
	$param[0]=array('status','<>','1');
	$vTrash=TRUE;
}else{
	$param[0]=array('status','=','1');
}
$TR=totRowsTab('tbl_items_brands','status',$param[0][2],$param[0][1]);//Total Rows -> Brands
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qryRS = sprintf("SELECT * FROM tbl_items_brands WHERE %s ORDER BY id DESC %s",
					 SSQL($param[0][0].$param[0][1].$param[0][2],''),
					 SSQL($pages->limit,''));
	$RS = mysqli_query($conn,$qryRS) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
}
$btnNew=genLink('invItemForm.php',$cfg[i]['new'].$cfg[b]['new'],'btn btn-primary btn-sm');
if($vTrash){
	$btnSecc=genLink($urlc,$cfg[i][all].$cfg[b][all],'btn btn-default btn-sm');
	$idfTrash=' <span class="label label-warning">'.$cfg[i][trash].$cfg[b][trash].'</span> ';
}else $btnSecc=genLink($urlc,$cfg[i][trash].$cfg[b][trash],'btn btn-warning btn-sm',array('view'=>'TRASH'));
$ms=3;
include('fra_top.php') ?>
<div class="container">
	<?php echo genPageHeader($dM['id'],'header','h2',NULL,$idfTrash,$btnNew.$btnSecc); ?>
<?php if($tRS>0){ ?>
    <table class="table table-hover table-condensed table-bordered" id="itm_table">
    <thead><tr>
        <th>ID</th>
        <th><?php echo $cfg[com_invB][t_est] ?></th>
        <th><?php echo $cfg[com_invB][t_name] ?></th>
        <th><?php echo $cfg[com_invB][t_url] ?></th>
        <th><?php echo $cfg[com_invB][t_img] ?></th>
        <th><?php echo $cfg[com_invB][t_numi] ?></th>
        <th><?php echo $cfg[com_invB][t_hits] ?></th>
        <th></th>
    </tr></thead>
    <tbody>
        <?php do {
        $btnDel=NULL;
		$detID=$dRS['id'];
		$detUrl=$dRS['url'];
		$detImg=vImg('data/img/brand',$dRS['img'],TRUE,$pthumb='t_');
        $detStat=$dRS['status'];
        $TRitem=totRowsTab('tbl_items','brand_id',$detID);
        $btnStat=fncStat('_fncts.php',array('ids'=>md5($detID), 'val'=>$detStat, 'acc'=>md5(STb), 'url'=>$urlc));
		if($vTrash) $btnDel='<a href="_fncts.php?ids='.md5($detID).'&acc='.md5(DELb).'&url='.$urlc.'" class="btn btn-danger btn-xs vAccL"><i class="fas fa-trash"></i> Del</a>';
		$btnEdit='<a href="invBrandForm.php?ids='.md5($detID).'" class="btn btn-primary btn-xs fancybox.iframe fancyreload"><i class="far fa-edit"></i> Edit</a>';
        ?>
          <tr>
            <td class="text-center">
				<a href="invBrandForm.php?ids=<?php echo md5($detID) ?>" class="fancybox.iframe fancyreload"><?php echo $detID ?></a>
			</td>
            <td class="text-center"><?php echo $btnStat ?></td>
            <td><?php echo $dRS['name'] ?></td>
            <td><?php echo $detUrl ?>
            <td><a href="<?php echo $detImg[n] ?>" class="thumbnail fancybox cero" title="<?php echo $dRS['name'] ?>">
             <img src="<?php echo $detImg[t] ?>" class="img-rounded img-mini"/></a></td>
            <td><?php echo $TRitem ?></td>
            <td><?php echo $dRS['hits']?></td>
            <td class="text-right">
            <div class="btn-group">
            	<?php echo $btnEdit ?>
				<?php echo $btnDel ?>
            </div>
            </td>
            </tr>
          <?php } while ($dRS = mysqli_fetch_assoc($RS)); ?>
    </tbody>
    </table>
    <?php include(RAIZf.'paginator.php') ?>
<?php mysqli_free_result($RS); ?>
<?php }else{ ?>
	<div class="alert alert-info"><h2>Not Found Items !</h2></div>
<?php } ?>
</div>