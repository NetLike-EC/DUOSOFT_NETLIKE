<?php require('../../init.php'); 
$com_num=vParam('com_num',$_GET['com_num'],$_POST['com_num'],FALSE);
$acc=vParam('acc',$_GET['acc'],$_POST['acc'],FALSE);

if($_SESSION['urlp']!=$_SESSION['urlc']) $insertGoTo=$_SESSION['urlp'];
else $insertGoTo='index.php';

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
if((isset($acc))&&($acc='ACOM')){
	
	if(verAnuCom($com_num)){
		$qry_upd=sprintf('UPDATE tbl_compra_cab SET com_stat=0 WHERE com_num=%s',
			GetSQLValueString($com_num,'int'));
		mysql_query($qry_upd) or (mysql_error());
		
		$query_com_det=sprintf('SELECT * FROM tbl_compra_det WHERE com_num = %s',
		GetSQLValueString($com_num,'int'));
		$RSdc = mysql_query($query_com_det);
		$row_RSdc = mysql_fetch_assoc($RSdc);
		$totalRows_RSdc = mysql_num_rows($RSdc);
		do{
			$comdet_id=$row_RSdc['inv_id'];
			$query_upd_exis=sprintf('UPDATE tbl_inventario SET inv_can = 0 WHERE inv_id = %s',
				GetSQLValueString($comdet_id,'int'));
			mysql_query($query_upd_exis);
		}while ($row_RSdc = mysql_fetch_assoc($RSdc));
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