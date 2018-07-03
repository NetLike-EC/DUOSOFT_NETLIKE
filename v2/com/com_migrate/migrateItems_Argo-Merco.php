<?php include('../../init.php');
include(RAIZs.'conn/conn_argo.php');
include(RAIZf.'_head.php');?>
<?php //BEGIN ARGO
mysql_select_db($db_conn_argo, $conn_argo);
$qryArgo=sprintf('SELECT * FROM tbl_prods WHERE prod_status=1');
$RSSia=mysql_query($qryArgo,$conn_argo);
$dRSSia=mysql_fetch_assoc($RSSia);
?>
<body class="cero">
<div class="container">
<h2>MIGRATE ARGO EQUIPMENT --> MERCOFRAMES</h2>
<table class="table table-bordered" id="tab_base">
	<thead>
    <tr>
    	<th>ID (Argo)</th>
        <th>COD</th>
        <th>ID Ref (Mercof)</th>
        <th>Result</th>
        <th>Query</th>
    </tr>
    </thead>
    <tbody>
    <?php
    mysql_query("SET AUTOCOMMIT=0;",$conn);
	mysql_query("BEGIN;",$conn);
	$vP=TRUE;
	do{
		$LOG=NULL;
		//mysql_select_db($db_conn, $conn);
		$qryMf=sprintf('SELECT * FROM tbl_items WHERE item_cod=%s',
		GetSQLValueString($dRSSia['prod_cod'],'text'));
		$RSmf=mysql_query($qryMf,$conn);
		$dRSmf=mysql_fetch_assoc($RSmf);
		
		$qryMfa=sprintf('SELECT * FROM tbl_items WHERE item_aliasurl=%s',
		GetSQLValueString($dRSSia['prod_aliasurl'],'text'));
		$RSmfa=mysql_query($qryMfa,$conn);
		$dRSmfa=mysql_fetch_assoc($RSmfa);
		//$detProd=detRow('tbl_items','item_cod',$dRSSia['prod_cod']);
		if((!$dRSmf)&&(!$dRSmfa)){
			$LOG='<span class="label label-success">No Existe Inserto</span>';
			$qryINS=sprintf('INSERT INTO tbl_items (item_cod,brand_id,item_aliasurl,item_nom,item_ref,item_des,item_date,item_img,item_hits,item_status) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			GetSQLValueString($dRSSia['prod_cod'],'text'),
			GetSQLValueString('2','int'),
			GetSQLValueString($dRSSia['prod_aliasurl'],'text'),
			GetSQLValueString($dRSSia['prod_nom'],'text'),
			GetSQLValueString($dRSSia['prod_cod'],'text'),
			GetSQLValueString($dRSSia['prod_des'],'text'),
			GetSQLValueString($sdate,'date'),
			GetSQLValueString($dRSSia['prod_img'],'text'),
			GetSQLValueString('1','int'),
			GetSQLValueString('1','int'));
			if(mysql_query($qryINS,$conn)){
				$idI=mysql_insert_id($conn);
				$LOG.='<h4>Registro Creado Correctamente. ID. '.$idI.'</h4>';
			}else{
				$LOG.='<h4>Error al crear Registro. '.mysql_error($conn).'</h4>'.$qryINS;
				$vP=FALSE;
			}
		}else{
			$idI=$dRSmf['item_id'];
			if($dRSmf) $idI=$dRSmf['item_id'];
			if($dRSmfa) $idI=$dRSmfa['item_id'];
			$LOG='<span class="label label-default">Si Existe, OMITE</span>';
		}
	?>
    <tr>
    	<td><?php echo $dRSSia['prod_id'] ?></td>
        <td><?php echo $dRSSia['prod_cod'] ?></td>
        <td><?php echo $idI ?></td>
        <td><?php echo $LOG ?></td>
        <td><?php //echo '<small class="text-muted">'.$qryUPD.'</small>' ?></td>
    </tr>
    <?php }while($dRSSia=mysql_fetch_assoc($RSSia)); ?>
    </tbody>
</table>
<?php

if((!mysql_error($conn))&&($vP==TRUE)){
	mysql_query("COMMIT;",$conn);
	$rLOG['t']='Operación Exitosa';
	$rLOG['c']='alert-success';
	$rLOG['i']='48/success.png';
	$rLOG['m']='Todo Correcto';
}else{
	mysql_query("ROLLBACK;",$conn);
	$rLOG['t']='Solicitud no Procesada';
	$rLOG['c']='alert-danger';
	$rLOG['i']='48/cancel.png';
	$rLOG['m']='Error durante el Proceso';
}
$_SESSION['LOG']=$rLOG;
mysql_query("SET AUTOCOMMIT=1;",$conn); //Habilita el autocommit
echo $rLOG['m'];
?>
<hr>
<?php sLOG('a'); ?>
</div>
</body>
</html>