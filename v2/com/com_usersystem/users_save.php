<?php require('../../init.php');

$action=vParam('action',$_GET['action'],$_POST['action']);
$urlreturn=$_SESSION['urlp'];

$id=$_POST['id_input'];
$nom_usu=$_POST['nom_usu'];
$con_usu=$_POST['con_pass'];

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if(($action)&&($action=='DEL')){
	$LOG=NULL;
	$id=$_GET['id'];	
	$qryDEL = sprintf("UPDATE tbl_usuario SET usr_eliminado=%s WHERE emp_cod=%s",
	SSQL('S', "text"),
	SSQL($id, "int"));			
	if(@mysql_query($qryDEL)) $LOG.="<p>Recurso Eliminado</p>";
	else $LOG.='<p>No se pudo Eliminar</p>';
	$urlreturn.='?id='.$id;
}
//estado usuarios 1=activo, 0=eliminado
if(($_POST['form'])&&($_POST['form']=='fmed')){
	
	if($action=='INS'){
		$insertSQL = sprintf("INSERT INTO tbl_usuario
		(emp_cod,usr_nombre,usr_contrasena) 
		VALUES (%s,%s,%s)",		
		SSQL($id, "int"),
		SSQL($nom_usu, "text"),
		SSQL(md5($con_usu), "text"));
		if(mysql_query($insertSQL)){
			$LOG.='<p>Usuario Creado</p>';
		}else{
			$LOG.= '<p>Error al Crear Usuario</p>';			
		}
	}

	if($action=='UPD'){
		$updSQL = sprintf("UPDATE tbl_usuario 
		SET usr_nombre=%s, usr_contrasena=%s, usr_eliminado=%s
		WHERE emp_cod=%s",	
		SSQL($nom_usu, "text"),
		SSQL(md5($con_usu), "text"),
		SSQL('N', "text"),		
		SSQL($id, "int"));
	if(mysql_query($updSQL)) $LOG.='<p>Usuario Actualizado</p>';
	else $LOG.= '<h4>Error al Actualizar Usuario</h4>';
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