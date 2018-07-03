<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$action=fnc_verifiparam('action', $_GET['action'], $_POST['action']);
$insertGoTo=$_SESSION['urlp'];
	if((isset($_POST['form']))&&($_POST['form']=='form_mod')){
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_modules SET mod_ref=%s, mod_nom=%s, mod_des=%s, mod_stat=%s WHERE mod_cod=%s',
			GetSQLValueString($_POST['mod_ref'],'text'),
			GetSQLValueString($_POST['mod_nom'],'text'),
			GetSQLValueString($_POST['mod_des'],'text'),
			GetSQLValueString($_POST['mod_stat'],'int'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO tbl_modules (mod_ref, mod_nom, mod_des, mod_stat) 
			VALUES (%s,%s,%s,%s)',
			GetSQLValueString($_POST['mod_ref'],'text'),
			GetSQLValueString($_POST['mod_nom'],'text'),
			GetSQLValueString($_POST['mod_des'],'text'),
			GetSQLValueString($_POST['mod_stat'],'int'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$insertGoTo.='?id='.$id;
	}
	if((isset($action))&&($action=='DEL')){
		$qry=sprintf('DELETE FROM tbl_modules WHERE mod_cod=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if((isset($action))&&($action=='STAT')){
		$qry=sprintf('UPDATE tbl_modules SET mod_stat=%s WHERE mod_cod=%s',
			GetSQLValueString($stat,'int'),
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>Articulo: ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
$LOG.=mysql_error();
$_SESSION['LOG']=$LOG;
if((mysql_error())||(isset($LOGe))) $_SESSION['LOGr']="danger"; else $_SESSION['LOGr']="success";
$insertGoTo=urlr($insertGoTo);
header(sprintf("Location: %s", $insertGoTo));
?>