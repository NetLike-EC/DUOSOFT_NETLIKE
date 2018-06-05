<?php include('../../init.php');
	$com_num = vParam('com_num',$_GET['com_num'],$_POST['com_num']);
	mysql_query("SET AUTOCOMMIT=0;");
	mysql_query("BEGIN;");

	//INS CABECERA FACTURA
		$aud=AUD('Generacion de Factura Compra');
		$qryInsCom=sprintf("INSERT INTO tbl_factura_com (com_num, fac_num, fac_obs, fac_fec, fac_est, aud_id) 
		VALUES (%s,%s,%s,%s,%s,%s)",
		GetSQLValueString($com_num,'int'),
		GetSQLValueString($fac_num,'int'),
		GetSQLValueString($fac_obs,'text'),
		GetSQLValueString($fac_fec,'text'),
		GetSQLValueString("1",'int'),
		GetSQLValueString($aud,'int'));
		mysql_query($qryInsCom)or($LOG.=mysql_error());
		$com_num=mysql_insert_id();
		//COMMIT OR ROLLBACK
		if(!(mysql_error())){
			mysql_query("COMMIT;")or(mysql_error());
			$LOG.="<h4>Factura Generada Correctamente</h4>";
			$_SESSION['stat_proc']='SAVED'; // Para Evitar Duplicar Registros
			$GoTo=$RAIZc."com_compras/form_fact.php?id=".$com_num;
		}else{
			mysql_query("ROLLBACK;")or(mysql_error());
			$LOG.="<h4>No se ha podido generar la factura de compra, <strong>intente nuevamente</strong></h4>";
			$GoTo=$RAIZc.'com_compras/form_fact.php';
		}

$LOG.=mysql_error();
$_SESSION['LOG']=$LOG;
if(mysql_error()) $_SESSION['LOGr']="e";
header(sprintf("Location: %s", $GoTo));
?>