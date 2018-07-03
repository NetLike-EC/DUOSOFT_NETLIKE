<?php 
$view=vParam('view',$_GET['view'],$_POST['view']);
if ($view=='TRASH'){
	$param[0]=array('typEst','<>','1');
	$vTrash=TRUE;
}else{
	$param[0]=array('typEst','=','1');
}
$TR=totRowsTab('tbl_items_type','typEst',$param[0][2],$param[0][1]);
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qryRS = sprintf("SELECT * FROM tbl_items_type WHERE %s ORDER BY typID DESC %s",
		SSQL($param[0][0].$param[0][1].$param[0][2],''),
		SSQL($pages->limit,''));
	$RS = mysqli_query($conn,$qryRS) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
} 
$btnNew=genLink('invCatForm.php',$cfg[i]['new'].$cfg[b]['new'],'btn btn-primary btn-sm');

if($vTrash){
	$btnSecc=genLink($urlc,$cfg[i][all].$cfg[b][all],'btn btn-default btn-sm');
	$idfTrash=' <span class="label label-warning">'.$cfg[i][trash].$cfg[b][trash].'</span> ';
}else $btnSecc=genLink($urlc,$cfg[i][trash].$cfg[b][trash],'btn btn-warning btn-sm',array('view'=>'TRASH'));
$ms=2;
include('fra_top.php') ?>
<div class="container">
	<?php echo genPageHeader($dM['id'],'header','h2',NULL,$idfTrash,$btnNew.$btnSecc) ?>
<?php if($tRS>0){ ?>
    <table class="table table-hover table-condensed table-bordered" id="tab_base">
    <thead><tr>
        <th>ID</th>
		<th><?php echo $cfg[com_invC][t_est] ?>*</th>
        <th><?php echo $cfg[com_invC][t_name] ?></th>
        <th><?php echo $cfg[com_invC][t_par] ?></th>
        <th><?php echo $cfg[com_invC][t_url] ?></th>
        <th><?php echo $cfg[com_invC][t_typ] ?></th>
        <th><?php echo $cfg[com_invC][t_img] ?></th>
        <th><?php echo $cfg[com_invC][t_numi] ?></th>
        <th><?php echo $cfg[com_invC][t_numc] ?></th>
        <th><?php echo $cfg[com_invC][t_hit] ?></th>
        <th></th>
    </tr></thead>
    <tbody>
        <?php do { ?>
        <?php
		$btnDel=null;
		$detID=$dRS['typID'];
        $detTypp=detRow('tbl_items_type','typID',$dRS['typIDp']);
        $detShow=detRow('tbl_types','typ_cod',$dRS['typ_id']);
		$detImg=vImg('data/img/cat/',$dRS['typImg'],TRUE,$pthumb='t_');
        $TRitems=totRowsTab('tbl_items_type_vs','typID',$dRS['typID']);
        $TRscats=totRowsTab('tbl_items_type','typIDp',$dRS['typID']);
        $btnStat=fncStat('_fncts.php',array('ids'=>md5($detID), 'val'=>$dRS['typEst'],'acc'=>md5('STc'),"url"=>$urlc));
		if($vTrash) $btnDel='<a href="_fncts.php?ids='.md5($detID).'&acc='.md5(DELc).'&url='.$urlc.'" class="btn btn-danger btn-xs vAccL"><i class="fas fa-trash"></i> Del</a>';
		$btnEdit='<a href="invCatForm.php?ids='.md5($detID).'" class="btn btn-primary btn-xs"><i class="far fa-edit"></i> Edit</a>';
		if($detID==0){ $btnDel=null; $btnStat=null; }
		?>
          <tr>
            <td class="text-center"><a href="invCatForm.php?ids=<?php echo md5($detID) ?>"><?php echo $detID ?></a></td>
			<td class="text-center"><?php echo $btnStat ?></td>
            <td><?php echo $dRS['typNom'] ?></td>
            <td><?php echo $detTypp['typNom'] ?></td>
            <td><?php echo $dRS['typUrl'] ?></td>
            <td><?php echo $detShow['typ_nom'] ?></td>
            <td><a href="<?php echo $detImg[n]?>" class="fancybox thumbnail cero" title="<?php echo $dRS['typNom'] ?>">
             <img src="<?php echo  $detImg[t]?>" class="img-mini"/></a></td>
            <td><?php echo $TRitems?></td>
            <td><?php echo $TRscats?></td>
            <td><?php echo $dRS['typHits']?></td>
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
    <?php mysqli_free_result($RS)?>
<?php }else{ ?>
    <div class="alert alert-warning"><h2>Not Found Items !</h2><?php echo $btnNew ?></div>
<?php } ?>
</div>