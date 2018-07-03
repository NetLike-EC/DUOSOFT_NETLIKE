<?php include('../../init.php');
include(RAIZs.'conn/conn_hans.php');
include(RAIZf.'_head.php');?>
<?php //BEGIN HANS
mysql_select_db($db_conn_hans, $conn_hans);
$qryHans=sprintf('SELECT * FROM tbl_items WHERE item_status=1');
$RSSia=mysql_query($qryHans,$conn_hans);
$dRSSia=mysql_fetch_assoc($RSSia);
?>
<body class="cero">
<div class="container">
<h2>MIGRATE HANSHEISS --> MERCOFRAMES</h2>
<table class="table table-bordered" id="tab_base">
	<thead>
    <tr>
    	<th>ID (Hans)</th>
        <th>COD (Hans)</th>
        <th>ID Ref (Mercof)</th>
        <th>COD Ref (Mercof)</th>
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
		GetSQLValueString($dRSSia['codigo'],'text'));
		$RSmf=mysql_query($qryMf,$conn);
		$dRSmf=mysql_fetch_assoc($RSmf);
		
		$qryMfa=sprintf('SELECT * FROM tbl_items WHERE item_aliasurl=%s',
		GetSQLValueString($dRSSia['alias'],'text'));
		$RSmfa=mysql_query($qryMfa,$conn);
		$dRSmfa=mysql_fetch_assoc($RSmfa);
		//$detProd=detRow('tbl_items','item_cod',$dRSSia['prod_cod']);
		if((!$dRSmf)&&(!$dRSmfa)){
			$LOG='<span class="label label-success">No Existe Inserto</span>';
			$qryINS=sprintf('INSERT INTO tbl_items (item_cod,brand_id,item_aliasurl,item_nom,item_ref,item_des,item_date,item_img,item_hits,item_status) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			GetSQLValueString($dRSSia['codigo'],'text'),
			GetSQLValueString('5','int'),//5, Hansheiss, 2 Argo
			GetSQLValueString($dRSSia['alias'],'text'),
			GetSQLValueString($dRSSia['title'],'text'),
			GetSQLValueString($dRSSia['codigo'],'text'),
			GetSQLValueString($dRSSia['descripcion'],'text'),
			GetSQLValueString($sdate,'date'),
			GetSQLValueString($dRSSia['image'],'text'),
			GetSQLValueString('1','int'),
			GetSQLValueString('1','int'));
			$LOG.=$qryINS;
			
			if(mysql_query($qryINS,$conn)){
				$idI=mysql_insert_id($conn);
				$codI=$dRSSia['codigo'];
				$LOG.='<h4>Registro Creado Correctamente. ID. '.$idI.'</h4>';
			}else{
				$LOG.='<h4>Error al crear Registro. '.mysql_error($conn).'</h4>'.$qryINS;
				$vP=FALSE;
			}
		}else{
			if($dRSmf){
				$idI=$dRSmf['item_id'];
				$codI=$dRSmf['item_cod'];
			}
			if($dRSmfa){
				$idI=$dRSmfa['item_id'];
				$codI=$dRSmfa['item_cod'];
			}
			$LOG='<span class="label label-default">Si Existe, OMITE</span>';
		}
	?>
    <tr>
    	<td><?php echo $dRSSia['id'] ?></td>
        <td><?php echo $dRSSia['codigo'] ?></td>
        <td><?php echo $idI ?></td>
        <td><?php echo $codI ?></td>
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