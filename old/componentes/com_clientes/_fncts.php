<?php include('../../init.php');
$id=vParam('id_cli', $_GET['id_cli'], $_POST['id_cli']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$_SESSION['LOG']=NULL;
$insertGoTo = $_SESSION['urlp'];

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if ((isset($_POST['mod'])) && ($_POST['mod'] == 'CLI')){
	if ((isset($action)) && ($action == "INS")){
		$tran_per=fnc_ins_per($_POST);
		$id_per=$tran_per['id'];
		$qryins = sprintf("INSERT INTO tbl_clientes (per_id, cli_fec, typ_cod, cli_stat) VALUES (%s, %s, %s, %s)",
			GetSQLValueString($id_per, "int"),
			GetSQLValueString($sdate, "date"),
			GetSQLValueString($_POST['typ_cod'],'int'),
			GetSQLValueString('1', "int"));
		if (@mysql_query($qryins)){ $idinsert = @mysql_insert_id();
		$LOG.='<h4>Creado Correctamente</h4>ID. '.$idinsert.'. '.$_POST['form_nom'].' '.$_POST['form_ape'];
		}else $LOG.='<h4>Error al Crear</h4>';
		$insertGoTo .= '?id='.$idinsert;
	}
	if ((isset($action)) && ($action == "UPD")){
		$tran_per=fnc_ins_per($_POST);
		$id_per=$tran_per['id'];
		$qryupd=sprintf('UPDATE tbl_clientes SET typ_cod=%s WHERE cli_cod=%s',
		GetSQLValueString($_POST['typ_cod'],'int'),
		GetSQLValueString($id, "int"));
		if (@mysql_query($qryupd))
			$LOG.='<h4>Cliente Actualizado</h4>'.$_POST['cli_nom'].' '.$_POST['cli_ape'];
		else
			$LOG.='<h4>Error al Actualizar</h4>';
		$insertGoTo .= '?id='.$id;
	}
	$LOG.=$tran_per['log'];

	if(!mysql_error()){
		mysql_query("COMMIT;");
		$LOG.='Operación Ejecutada Exitosamente';
	}else{
		mysql_query("ROLLBACK;");
		$LOG.='Fallo del Sistema, intente de nuevo';
	}
	mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
	$LOG.=mysql_error();	
	$_SESSION['LOG']=$LOG;
	if(mysql_error()) $_SESSION['LOGr']="E";
	header(sprintf("Location: %s", $insertGoTo));
}
?>