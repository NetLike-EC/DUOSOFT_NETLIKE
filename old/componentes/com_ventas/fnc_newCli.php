<?php include('../../init.php');
$form=vParam('form', $_GET['form'], $_POST['form']);
$action=vParam('action', $_GET['action'], $_POST['action']);
//$id=vParam('id', $_GET['id'], $_POST['id']);
//$action=vParam('action', $_GET['action'], $_POST['action']);
//IF MOD INVENTARIO PRODUCTS
//if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'INVP')){
	//$insertGoTo = $_SESSION['urlp'];
	
	if((isset($_POST['form']))&&($_POST['form']=='form_cli')){
		if((isset($action))&&($action=='INS')){
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
			
		}
		if((isset($action))&&($action=='UPD')){
			$tran_per=fnc_ins_per($_POST);
			$id_per=$tran_per['id'];
			$qryupd=sprintf('UPDATE tbl_clientes SET typ_cod=%s WHERE cli_cod=%s',
			GetSQLValueString($_POST['typ_cod'],'int'),
			GetSQLValueString($id, "int"));
			if (@mysql_query($qryupd)) $LOG.='<h4>Cliente Actualizado</h4>'.$_POST['cli_nom'].' '.$_POST['cli_ape'];
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
	}
	$LOG.=mysql_error();
$_SESSION['LOG']=$LOG;
if(!mysql_error()){
	$respuesta['accion']['est'] = 'TRUE';
	$respuesta['accion']['msg'] = 'Carga Correcta';

}else{
	$respuesta['accion']['est'] = 'FALSE';
	$respuesta['accion']['msg'] = 'Error al Cargar. '.mysql_error();

}
echo json_encode($respuesta);	// Enviar la respuesta al cliente en formato JSON
?>