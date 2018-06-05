<?php include('../../init.php');
$ven_num = vParam('ven_num',$_GET['ven_num'],$_POST['ven_num']);
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

	if(($_POST['form'])&&($_POST['form']=='formFacVen')){
	//INS CABECERA FACTURA
		$aud=AUD('Generacion de Factura Venta');
		$num_cic=fnc_numIniCic();

		$num_fac=fnc_numMaxFac();
		$qryInsCom=sprintf("INSERT INTO tbl_factura_ven (fac_num, faccic_id, ven_num, aud_id, fac_obs, fac_stat) 
		VALUES (%s,%s,%s,%s,%s,%s)",
		GetSQLValueString($num_fac,'int'),
		GetSQLValueString($num_cic['id'],'int'),
		GetSQLValueString($ven_num,'int'),
		GetSQLValueString($aud,'int'),
		GetSQLValueString($_POST['fac_obs'],'text'),
		GetSQLValueString("1",'int'));
		mysql_query($qryInsCom)or($LOG.=mysql_error());
		$fac_num=mysql_insert_id();
		//COMMIT OR ROLLBACK
		if(!(mysql_error())){
			mysql_query("COMMIT;")or(mysql_error());
			$LOG.="<h4>Factura Generada Correctamente</h4>";
			$_SESSION['stat_proc']='SAVED'; // Para Evitar Duplicar Registros
			$GoTo=$RAIZc."com_ventas/form_fact.php?id=".$ven_num;
		}else{
			mysql_query("ROLLBACK;")or(mysql_error());
			$LOG.="<h4>No se ha podido generar la factura de venta, <strong>intente nuevamente</strong></h4>";
			$GoTo=$RAIZc.'com_ventas/form_fact.php';
		}
	}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysql_error();
$_SESSION['LOG']=$LOG;
if(mysql_error()) $_SESSION['LOGr']="e";
header(sprintf("Location: %s", $GoTo));
?>