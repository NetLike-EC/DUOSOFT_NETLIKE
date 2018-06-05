<?php include('../../init.php');
//FUNCIONES FORMULARIO CONSULTAS
//PARAMETROS
$idp=vParam('idp', $_GET['idp'], $_POST['idp']);//Id que viene de AJAX
$idc=vParam('idc', $_GET['idc'], $_POST['idc']);//Id que viene de AJAX
$idr=vParam('idr', $_GET['idr'], $_POST['idr']);//Id que viene de AJAX
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);//Id que viene de AJAX
$mod=vParam('mod', $_GET['mod'], $_POST['mod'],FALSE);//mod
//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
if ((isset($mod))&&($mod=='consForm')){
	if ($_POST['acc']=="INS"){
		$idAud=AUD(NULL,'Creación Consulta');
		$qryins=sprintf('INSERT INTO db_consultas (pac_cod, con_fec, con_typ, con_diagd, con_val, tip_pag, dcon_mot, id_aud, con_stat) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($idp, "int"),
		SSQL($sdate, "date"),
		SSQL($con_typ, "int"),
		SSQL($con_diagd, "int"),
		SSQL($con_val, "double"),
		SSQL($tip_pag, "text"),
		SSQL($dcon_mot, "text"),
		SSQL($idAud, "int"),
		SSQL('1', "text"));
		if (mysql_query($qryins)){
			$idc=mysql_insert_id();
			$LOG.= "<p>Consulta Grabada Correctamente</p>";
			//$LOG.=verifyHC($idp,$_POST);
			//$LOG.=verifyGIN($idp,$_POST);
			//Elimino Reserva
			//$LOG.=verifyRES($idp);
			
			if($idr){
				$LOG.=verifyRESid($idr);
			}else{
				$LOG.=verifyREShis($idp);
			}
		}else{
			$LOG.= "<p>Error al Grabar Consulta</p>";
		}
	}
	if ($_POST['acc']=="UPD"){
		$detCon=detRow('db_consultas','con_num',$idc);
		$idAud=AUD($detCon['id_aud'],'Actualización Consulta');
		$qryupd=sprintf('UPDATE db_consultas SET con_upd=%s, con_typ=%s, con_diagd=%s, con_val=%s, tip_pag=%s, dcon_mot=%s, id_aud=%s, con_stat=%s WHERE con_num=%s',
		SSQL($sdate, "date"),
		SSQL($con_typ, "int"),
		SSQL($con_diagd, "int"),
		SSQL($con_val, "double"),
		SSQL($tip_pag, "text"),
		SSQL($dcon_mot, "text"),
		SSQL($idAud, "int"),
		SSQL("1", "text"),
		SSQL($idc, "int"));
		if(mysql_query($qryupd)){
			$LOG.= '<p>Consulta Guardada Correctamente.</p>';
			//$LOG.=verifyHC($idp,$_POST);
			//$LOG.=verifyGIN($idp,$_POST);
			if($idr) $LOG.=verifyRESid($idr);
		}else{
			$LOG.= '<p>ERROR al Actualizar Consulta</p>';
		}
	}
}

/*****************************/
$LOG.=mysql_error();
if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOGt='Operación Ejecutada Exitosamente';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
	$insertGoTo = 'form.php?idc='.$idc;
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Fallo del Sistema, intente de nuevo';
	$LOGc='alert-danger';
	$insertGoTo = 'form.php?idc='.$idc.'&idp='.$idp;
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];

}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $insertGoTo));

?>