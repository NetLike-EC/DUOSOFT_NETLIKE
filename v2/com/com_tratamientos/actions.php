<?php require('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$action=vParam('action',$_GET['action'],$_POST['action']);
$urlreturn=$_SESSION['urlp'];

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if(($action)&&($action=='DEL')){
	$LOG=NULL;
	$id=$_GET['id'];
	$qryDEL=sprintf('DELETE FROM db_medicamentos WHERE id_form=%s',
	SSQL($id,'int'));
	if(@mysql_query($qryDEL)) $LOG.="<p>Medicamento Eliminado</p>";
	else $LOG.='<p>No se pudo Eliminar</p>';
	$urlreturn.='?id='.$id;
}
if(($_POST['form'])&&($_POST['form']=='fmed')){
	if($action=='INS'){
		$insertSQL = sprintf("INSERT INTO db_medicamentos
		(generico, comercial, presentacion, cantidad, descripcion, estado) VALUES (%s,%s,%s,%s,%s,%s)",
		SSQL($generico, "text"),
		SSQL($comercial, "text"),
		SSQL($presentacion, "text"),
		SSQL($cantidad, "int"),
		SSQL($descripcion, "text"),
		SSQL("1", "text"));
		if(mysql_query($insertSQL)){
			$LOG.='<p>Medicamento Creado</p>';
		}else{
			$LOG.= '<p>Error al Crear Medicamento</p>';
		}
	}
	if($action=='UPD'){
		$updSQL = sprintf("UPDATE db_medicamentos SET generico=%s, comercial=%s, presentacion=%s, cantidad=%s, descripcion=%s WHERE id_form=%s",
		SSQL($generico, "text"),
		SSQL($comercial, "text"),
		SSQL($presentacion, "text"),
		SSQL($cantidad, "int"),
		SSQL($descripcion, "text"),
		SSQL($id, "int"));
	if(mysql_query($updSQL)) $LOG.='<p>Medicamento Actualizado</p>';
	else $LOG.= '<h4>Error al Actualizar Medicamento</h4>';
	}
}
$LOG.=mysql_error();
if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $urlreturn));
?>