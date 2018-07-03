<?php
$idB=vParam('idB',$_GET['idB'],$_POST['idB'],TRUE);
$bus=vParam('bus',$_GET['bus'],$_POST['bus']);
$busNom=vParam('busNom',$_GET['busNom'],$_POST['busNom']);
$view=vParam('view',$_GET['view'],$_POST['view']);

if($bus) $param['cod']=array('item_cod','LIKE','%'.$bus.'%');
if($busNom) $param['nom']=array('item_nom','LIKE','%'.$busNom.'%');
if($idB) $param['brand']=array('brand_id','=',$idB);
if ($view=='TRASH'){
	$param['stat']=array('item_status','<>','1');
	$vTrash=TRUE;
}else $param['stat']=array('item_status','=','1');

$paramSQL=getParamSQLA($param);
$TRi=totRowsTabP('tbl_items',$paramSQL);
if($TRi>0){
	$pages = new Paginator;
	$pages->items_total = $TRi;
	$pages->mid_range = 10;
	$pages->paginate();
	$qryRSlp = 'SELECT * FROM tbl_items WHERE 1=1 '.$paramSQL.' ORDER BY item_id DESC '.$pages->limit;
	$RSlp = mysqli_query($conn,$qryRSlp) or die(mysqli_error($conn));
	$dRSlp = mysqli_fetch_assoc($RSlp);
	$tRSlp = mysqli_num_rows($RSlp);
}
if($tRSlp<=100) $vImg=TRUE;
$btnNew=genLink('invItemForm.php',$cfg[i]['new'].$cfg[b]['new'],'btn btn-primary btn-sm');
if($vTrash){
	$btnSecc=genLink($urlc,$cfg[i][all].$cfg[b][all],'btn btn-default btn-sm');
	$idfTrash=' <span class="label label-warning">'.$cfg[i][trash].$cfg[b][trash].'</span> ';
}else $btnSecc=genLink($urlc,$cfg[i][trash].$cfg[b][trash],'btn btn-warning btn-sm',array('view'=>'TRASH'));
$ms=1;
include('fra_top.php') ?>
<div class="container-fluid">
	<?php echo genPageHeader($dM['id'],'header','h2',NULL,$idfTrash,$btnNew.$btnSecc); ?>
	<div class="well well-sm">
    <form action="<?php echo $urlc ?>" class="form-inline" method="post">
        	<span class="label label-default"><?php echo $cfg[t][filters] ?></span> 
			<input type="hidden" name="view" value="<?php echo $view?>"/>
            <label><?php echo $cfg[com_invI][t_code] ?></label>
            <input type="text" class="form-control input-sm" name="bus" value="<?php echo $bus ?>">
			<label><?php echo $cfg[com_invI][t_name] ?></label>
            <input type="text" class="form-control input-md" name="busNom" value="<?php echo $busNom ?>">
            <label><?php echo $cfg[com_invI][t_brand] ?></label>
            <?php echo genSelect('idB', detRowGSel('tbl_items_brands','id','name','status','1','ORDER BY name ASC'), $idB, 'form-control input-sm ',NULL,NULL,NULL,TRUE,NULL,$cfg[t][sel]); ?>
            <button type="submit" class="btn btn-success btn-xs"><?php echo $cfg[b][filter] ?></button>
        </form>
    </div>
	<?php if($tRSlp>0){ ?>
    <form method="post" action="_fncts.php">
    <input type="hidden" name="acc" value="<?php echo md5('PRODMULT') ?>">
    <table class="table table-hover table-condensed table-bordered" id="deftab">
    <thead>
        <tr>
			<th></th>
			<th>ID</th>
            <th><?php echo $cfg[com_invI][t_est] ?></th>
			<th><?php echo $cfg[com_invI][t_code] ?></th>
            <th><?php echo $cfg[com_invI][t_name] ?></th>
            <th>URL</th>
            <th><?php echo $cfg[com_invI][t_brand] ?></th>
            <th><?php echo $cfg[com_invI][t_cat] ?></th>
            <?php if($vImg){ echo '<th>'.$cfg[com_invI][t_img].'</th>'; } ?>
            <th><?php echo $cfg[com_invI][t_hit] ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php do { ?>
        <?php $detID=$dRSlp['item_id'];
		if($vImg) $Img=vImg('data/img/item/',$dRSlp['item_img'],TRUE,'_t');
		$dBrand=detRow('tbl_items_brands','id',$dRSlp['brand_id']);
        $btnStat=fncStat('_fncts.php',array("ids"=>md5($detID), "val"=>$dRSlp['item_status'],"acc"=>md5('STi'),"url"=>$urlc));
		/*Listado Types*/
		$qryLT=sprintf('SELECT tbl_items_type.typNom as name, tbl_items_type.typID as code 
		FROM tbl_items_type_vs 
		INNER JOIN tbl_items_type ON tbl_items_type_vs.typID=tbl_items_type.typID 
		WHERE tbl_items_type_vs.item_id=%s',
		SSQL($detID,'int'));
		$RSLT=mysqli_query($conn,$qryLT) or die (mysqli_error($conn));
		$dRSLT=mysqli_fetch_assoc($RSLT);
		$trRSLT=mysqli_num_rows($RSLT);
		$valTyp=NULL;
		if($trRSLT>0){
			do $valTyp.=' <a class="btn btn-default btn-xs btn-block fancybox fancybox.iframe fancyreload" href="invCatForm.php?ids='.$dRSLT['code'].'">'.$dRSLT['name'].'</a> '; while($dRSLT=mysqli_fetch_assoc($RSLT));
		}
		if($dRSlp['item_aliasurl']){
			$btnUrl='<button type="button" class="toolTipU btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="'.$dRSlp['item_aliasurl'].'">
            	<i class="fa fa-globe"></i>
            </button>';
		}else $btnUrl=NULL;
		$btnDel=null;
		if($vTrash) $btnDel='<a href="_fncts.php?ids='.md5($detID).'&acc='.md5('DELi').'&url='.$urlc.'" class="btn btn-danger btn-xs vAccL"><i class="fa fa-trash"></i> Del</a>';
		$btnEdit='<a href="invItemForm.php?ids='.md5($detID).'" class="btn btn-primary btn-xs"><i class="fa fa-edit fa-lg"></i> Edit</a>';
        ?>
		<tr>
			<td><input type="checkbox" class="cblis" name="lis[]" value="<?php echo $detID ?>"></td>
			<td><a href="invItemForm.php?ids=<?php echo md5($detID) ?>"><?php echo $detID ?></a></td>
			<td class="text-center"><?php echo $btnStat ?></td>
            <td><?php echo $dRSlp['item_cod'] ?></td>
            <td><small><?php echo $dRSlp['item_nom'] ?></small></td>
            <td><?php echo $btnUrl ?><br></td>
            <td><?php echo $dBrand['name'] ?></td>
            <td><?php echo $valTyp ?></td>
            <?php if($vImg){ ?>
            <td class="text-center">
             <a href="<?php echo $Img['n'] ?>" class="thumbnail fancybox cero" title="<?php echo $dRSlp['item_cod'] ?>">
             <img src="<?php echo $Img['t'] ?>" class="img-xs"/></a></td>
             <?php } ?>
             <td><?php echo $dRSlp['item_hits'] ?></td>
            <td align="center">
            <div class="btn-group">
            	<?php echo $btnEdit ?>
				<?php echo $btnDel ?>
            </div>
            </td>
            </tr>
          <?php } while ($dRSlp = mysqli_fetch_assoc($RSlp)); ?>
    </tbody>
    </table>
    <div class="well well-sm">
		<label><input type="checkbox" id="checkallcb"> Check all </label> <span class="label label-default">With selected</span> 
		<div class="btn-group">
			<?php if($statTrash==TRUE){ ?>
			<button class="btn btn-default btn-xs" name="accm" value="<?php echo md5('enable') ?>" type="submit" id="vAcc">Enable</button>
			<button class="btn btn-default btn-xs" name="accm" value="<?php echo md5('delete') ?>" type="submit" id="vAcc">Delete</button>
			<?php }else{ ?>
			<button class="btn btn-default btn-xs" name="accm" value="<?php echo md5('disable') ?>" type="submit" id="vAcc">Disable</button>
			<?php } ?>
		</div>
    </div>
	</form>
    <?php include(RAIZf.'paginator.php') ?>
    <script type="text/javascript">
	$(document).ready(function(){ $("#checkallcb").change(function(){ $(".cblis").prop('checked', $(this).prop("checked")); }); });
    </script>
<?php mysqli_free_result($RSlp); ?>
<?php }else{ ?>
	<div class="alert alert-info"><h2>Not found rows !</h2></div>
<?php } ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.toolTipU').tooltip();
});
</script>