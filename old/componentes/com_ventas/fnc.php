<?php require('../../init.php'); 
$ven_num=vParam('ven_num',$_GET['ven_num'],$_POST['ven_num'],FALSE);
$acc=vParam('acc',$_GET['acc'],$_POST['acc'],FALSE);
if($_SESSION['urlp']!=$_SESSION['urlc']) $insertGoTo=$_SESSION['urlp'];
else $insertGoTo='index.php';
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
if((isset($acc))&&($acc='AVEN')){
	if(verAnuVen($ven_num)){
		$qry_upd=sprintf('UPDATE tbl_venta_cab SET ven_stat=0 WHERE ven_num=%s',
			GetSQLValueString($ven_num,'int'));
		mysql_query($qry_upd) or (mysql_error());
		$query_com_det=sprintf('SELECT * FROM tbl_venta_det WHERE ven_num = %s',
		GetSQLValueString($ven_num,'int'));
		$RSdc = mysql_query($query_com_det);
		$row_RSdc = mysql_fetch_assoc($RSdc);
		$totalRows_RSdc = mysql_num_rows($RSdc);
		do{
			$det_id=$row_RSdc['inv_id'];
			$det_can=$row_RSdc['ven_can'];
			$query_upd_exis=sprintf('UPDATE tbl_inventario SET inv_sal=inv_sal-%s WHERE inv_id = %s',
			GetSQLValueString($det_can,'int'),
			GetSQLValueString($det_id,'int'));
			mysql_query($query_upd_exis);
		}while ($row_RSdc = mysql_fetch_assoc($RSdc));
		$qry_updFac=sprintf('UPDATE tbl_factura_ven SET fac_stat=0 WHERE ven_num=%s',
			GetSQLValueString($ven_num,'int'));
		mysql_query($qry_updFac) or (mysql_error());
		
		$acc_succ='<h4>Factura Anulada</h4>';
		$acc_fail='<h4>Error al Anular la Factura</h4>';
	}
}//END acc=ACOM

if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOG .= $acc_succ.'<h4>Proceso ejecutado Exitosamente</h4>';
}else{
	mysql_query("ROLLBACK;");
	$LOG .= $acc_fail.'<h4>No se ejecutó la solicitud</h4>';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysql_error();
$_SESSION['LOG']=$LOG; 
header(sprintf("Location: %s", $insertGoTo));
?>