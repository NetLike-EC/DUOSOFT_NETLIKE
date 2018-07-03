<?php include('../../init.php');
$token=vParam('token',$_GET['token'],$_POST['token']);
$idB=vParam('idB',$_GET['idB'],$_POST['idB']);
$detB=detRow('tbl_items_brands','id',$idB);
$cssBody='cero';
include(RAIZf.'_head.php');?>
<div class="container">
<h1 class=""><small class="label label-info">DB</small> Create ITEMS (tbl_items) in STORE (st_item)</h1>
<div class="well">
<form class="form-inline" method="get" action="<?php echo $urlc ?>">
	<label class="control-label">TOKEN</label>
    <input name="token" value="<?php echo $token ?>" class="form-control"/>
    <label class="control-label">BRAND</label>
    <?php echo generarselect('idB', detRowGSel('tbl_items_brands','id','name','status','1','ORDER BY name ASC'), $idB, 'form-control'); ?>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-chevron-right fa-lg"></i> MIGRAR</button>
</form>
</div>
<?php if($token=='db2015..'){
	//SELECT ITEMS TO STORE
	$qrySI=sprintf('SELECT * FROM tbl_items WHERE brand_id=%s AND item_status=1 ORDER BY item_id ASC',
	GetSQLValueString($idB,'int'));
	$RSib=mysql_query($qrySI);
	$dRSib=mysql_fetch_assoc($RSib);
	$trRSib=mysql_num_rows($RSib);
?>
<div>
<?php if($trRSib>0){ ?>
<div class="well well-sm">
<span class="label label-default">Total Rows <?php echo $trRSib ?></span>
<span class="label label-primary">Brand <strong><?php echo $detB['name'] ?></strong></span>
</div>

<table class="table table-bordered">
	<thead>
    <tr>
    	<th>ID</th>
        <th>COD</th>
        <th>NOM</th>
        <th>URL</th>
        <th>LOG</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $vP=TRUE;
	//echo $vP;
	//mysql_query("SET AUTOCOMMIT=0;");
	//mysql_query("BEGIN;");
	?>
	<?php do{ ?>
    <?php $LOGr=NULL;
    $detIS=detRow('st_item','itemr_id',$dRSib['item_id']);
	if($detIS){
		$LOGr.='Existe en Store. ';
	}else{
		$idA=AUD();
		$qryINS=sprintf('INSERT INTO st_item (itemr_id, item_sku, item_fec, aud_id) VALUES (%s,%s,%s,%s)',
		GetSQLValueString($dRSib['item_id'],'int'),
		GetSQLValueString($dRSib['item_cod'],'text'),
		GetSQLValueString($sdate,'date'),
		GetSQLValueString($idA,'int'));
		if(mysql_query($qryINS)){
			$idIS=mysql_insert_id();
			$LOGr.=' Item Store Creado. '.$idIS.' - ';
			$qryINSD=sprintf('INSERT INTO st_item_des (item_id, item_nom, item_url) VALUES (%s,%s,%s)',
			GetSQLValueString($idIS,'int'),
			GetSQLValueString($dRSib['item_nom'],'text'),
			GetSQLValueString($dRSib['item_aliasurl'],'text'));
			if(mysql_query($qryINSD)){
				$LOGr.=' Detalle Creado.';
			}else{
				$vP=FALSE;
				$LOGr.=' Detalle NO Creado.'.mysql_error();
				$LOGr.=mysql_error();
			}
		}else{
			$vP=FALSE;
			$LOGr.=mysql_error();
			$LOGr.=' Item NO Creado.';
		}
	}
	?>
    <tr>
    	<td><?php echo $dRSib['item_id']?></td>
        <td><?php echo $dRSib['item_cod']?></td>
        <td><?php echo $dRSib['item_nom']?></td>
        <td><?php echo $dRSib['item_aliasurl']?></td>
        <td><?php echo $LOGr ?></td>
    </tr>
    <?php }while($dRSib=mysql_fetch_assoc($RSib)); ?>
    </tbody>
</table>
<?php

//echo '<hr>vP. '.$vP.'<hr>';

if(mysql_error()){
	//echo 'MySQL error. '.mysql_error();
}else{
	//echo 'No Error';
}

if((!mysql_error())&&($vP==TRUE)){
	//echo "TRUE";
	//mysql_query("COMMIT;");
	$rLOG['t']='Operación Exitosa';
	$rLOG['c']='alert-success';
}else{
	echo "FALSE";
	//mysql_query("ROLLBACK;");
	$rLOG['t']='Solicitud no Procesada';
	$rLOG['c']='alert-danger';
}
//$_SESSION['LOG']=$rLOG;
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
//sLOG('a');
?>
<div class="alert <?php echo $rLOG['c']?>">
    <h4><?php echo $rLOG['t'] ?></h4>
    <p><?php echo $rLOG['m'] ?></p>
</div>
<?php }else $LOG.='<h4>No Items Found in this brand</h4>';?>
</div>
<?php }else $LOG.='<h4>Invalid Token</h4>'; ?>

<div class="alert alert-warning">
<?php echo $LOG ?>
</div>
</div>
<script>
$(document).on('ready', function(){			
	$( "#idB" ).chosen();
});
</script>
<?php include(RAIZf.'_foot.php');?>