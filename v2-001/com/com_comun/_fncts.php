<?php require('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$action=vParam('action',$_GET['action'],$_POST['action']);
$urlreturn=$_SESSION['urlp'];

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if(($action)&&($action=='DEL')){
	$LOG=NULL;
	$id=$_GET['id'];
	$num_diagcon=fnc_numdiagcon($id);
	if($num_diagcon>0){
		$LOG.='<p>No se pudo Eliminar</p>Existen Consultas relacionadas a este diagnostico';
	}else{
		$qryDEL=sprintf('DELETE FROM `db_diagnosticos` WHERE id_diag=%s',
		SSQL($id,'int'));
		if(@mysql_query($qryDEL)) $LOG.="<p>Diagnostico Eliminado Correctamente</p>";
		else $LOG.='<p>No se pudo Eliminar</p>';
	}
	$urlreturn.='?id='.$id;
}
if(($_POST['form'])&&($_POST['form']=='fdiag')){
	$codigo=$_POST['codigo'];
	$nombre=$_POST['nombre'];
	if($action=='INS'){
		$insertSQL = sprintf("INSERT INTO `db_diagnosticos`
		(`codigo`,`nombre`) VALUES (%s,%s)",
		SSQL($codigo, "text"),
		SSQL($nombre, "text"));
		if(mysql_query($insertSQL)){
			$LOG.='<p>Diagnostico Creado Correctamente</p>';
		}else{
			$LOG.= '<p>Error. No se pudo crear Diagnostico</p>';
		}
	}
	if($action=='UPD'){
		$updSQL = sprintf("UPDATE `db_diagnosticos` SET	`codigo`=%s,`nombre`=%s WHERE id_diag=%s",
		SSQL($codigo, "text"),
		SSQL($nombre, "text"),
		SSQL($id, "int"));
	if(mysql_query($updSQL)) $LOG.='<p>Diagnostico Actualizado Correctamente</p>';
	else $LOG.= '<p>Error. No se pudo actualizar Diagnostico</p>';
	}
}
if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOGt.='Operación Ejecutada Exitosamente';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt.='Fallo del Sistema, intente de nuevo';
	$LOG.=mysql_error();
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $urlreturn));
?>