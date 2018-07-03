<?php include('../../init.php');
include(RAIZs.'conn/conn_mimito.php');
include(RAIZf.'_head.php');?>
<?php //BEGIN ARGO
mysql_select_db($db_conn_mimito, $conn_mimito);
$qryMim=sprintf('SELECT frames.id AS i_id, frames.codigo AS i_cod, frames.date AS i_date, frames.habilitado AS i_stat, frames.size AS i_size, category.name AS c_name, material.mat_name AS m_nom 
FROM frames 
LEFT JOIN category ON frames.categoria=category.id 
LEFT JOIN material ON frames.mat_id=material.mat_id 
WHERE frames.habilitado=1');
$RSSia=mysql_query($qryMim,$conn_mimito);
$dRSSia=mysql_fetch_assoc($RSSia);
?>
<body class="cero">
<div class="container">
<h2>MIGRATE MIMITO --> MERCOFRAMES</h2>
<table class="table table-bordered" id="tab_base">
	<thead>
    <tr>
    	<th>ID (Mimito)</th>
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
		GetSQLValueString($dRSSia['i_cod'],'text'));
		$RSmf=mysql_query($qryMf,$conn);
		$dRSmf=mysql_fetch_assoc($RSmf);
		

		//$detProd=detRow('tbl_items','item_cod',$dRSSia['prod_cod']);
		if(!$dRSmf){
			$LOG='<span class="label label-success">No Existe Inserto</span>';
			$dRSSia_des=$dRSSia['c_name'].'<br>'.$dRSSia['m_nom'].'<br>'.$dRSSia['i_size'];
			$dRSSia_img=$dRSSia['i_cod'].'.jpg';
			$qryINS=sprintf('INSERT INTO tbl_items (item_cod,brand_id,item_aliasurl,item_nom,item_ref,item_des,item_date,item_img,item_hits,item_status) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			GetSQLValueString($dRSSia['i_cod'],'text'),
			GetSQLValueString('12','int'),
			GetSQLValueString($dRSSia['i_cod'],'text'),
			GetSQLValueString($dRSSia['i_cod'],'text'),
			GetSQLValueString($dRSSia['i_cod'],'text'),
			GetSQLValueString($dRSSia_des,'text'),
			GetSQLValueString($dRSSia['i_date'],'date'),
			GetSQLValueString($dRSSia_img,'text'),
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
			$LOG='<span class="label label-default">Si Existe, OMITE</span>';
		}
	?>
    <tr>
    	<td><?php echo $dRSSia['i_id'] ?></td>
        <td><?php echo $dRSSia['i_cod'] ?></td>
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
	//mysql_query("COMMIT;",$conn);
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