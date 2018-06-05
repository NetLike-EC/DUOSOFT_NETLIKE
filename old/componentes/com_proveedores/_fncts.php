<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$_SESSION['LOG']=NULL;
$insertGoTo = $_SESSION['urlp'];

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if ((isset($_POST['mod'])) && ($_POST['mod'] == 'PROV')){
	if ((isset($action)) && ($action == "INS")){
		$tran_prov=fnc_ins_per($_POST);
		$id_per=$tran_prov['id'];
		$qryins = sprintf("INSERT INTO tbl_proveedores (per_id, prov_fec, prov_stat) VALUES (%s, %s, %s)",
			GetSQLValueString($id_per, "int"),
			GetSQLValueString($sdate, "date"),
			GetSQLValueString('1', "int"));
			if (@mysql_query($qryins)){ $idinsert = @mysql_insert_id();
			$LOG.='<h4>Creado Correctamente</h4>ID. '.$idinsert.'. '.$_POST['form_nom'].' '.$_POST['form_ape'];
		}else $LOG.='<h4>Esta Persona ya se encuentra registrada</h4>Intente Otra Vez, con un numero de cedula distinto. ';
		$insertGoTo .= '?id='.$idinsert;
	}
	if ((isset($action)) && ($action == "UPD")){
		$tran_prov=fnc_ins_per($_POST);
		$id_per=$tran_prov['id'];
		$qryupd=sprintf('UPDATE tbl_proveedores SET per_id=%s WHERE prov_id=%s',
		GetSQLValueString($id_per,'int'),
		GetSQLValueString($id, "int"));
		if (@mysql_query($qryupd))
			$LOG.='<h4>Cliente Actualizado</h4>';
		else $LOG.='<h4>Error al Actualizar</h4>';
		
		$insertGoTo .= '?id='.$id;
	}
}
if ((isset($action)) && ($action == "STAT")){
	$qry=sprintf('UPDATE tbl_proveedores SET prov_stat=%s WHERE prov_id=%s',
	GetSQLValueString($stat,'int'),
	GetSQLValueString($id,'int'));
	if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
	else $LOG.='<h4>Error al Actualizar Status</h4>'.mysql_error();
		
	$insertGoTo .= '?id='.$id;
}

$LOG.=$tran_prov['log'];

if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOG.='<p>Operación Ejecutada Exitosamente</p>';
}else{
	mysql_query("ROLLBACK;");
	$LOG.='<p>Fallo del Sistema, intente de nuevo</p>';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysql_error();	
$_SESSION['LOG']=$LOG;
if(mysql_error()) $_SESSION['LOGr']="E";
header(sprintf("Location: %s", $insertGoTo));
?>