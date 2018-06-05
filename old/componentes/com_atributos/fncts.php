<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$insertGoTo=$_SESSION['urlp'];
	if((isset($_POST['form']))&&($_POST['form']=='form_mod')){
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_types SET typ_ref=%s, typ_nom=%s WHERE typ_cod=%s',			
			GetSQLValueString($_POST['form_ref'],'text'),
			GetSQLValueString($_POST['form_nom'],'text'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO tbl_types (mod_ref, typ_ref, typ_nom, typ_stat) 
			VALUES (%s,%s,%s,%s)',
			GetSQLValueString('ATRIB','text'),
			GetSQLValueString($_POST['form_ref'],'text'),
			GetSQLValueString($_POST['form_nom'],'text'),
			GetSQLValueString('1','int'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$insertGoTo.='?id='.$id;
	}
	if((isset($action))&&($action=='DEL')){
		$qry=sprintf('DELETE FROM tbl_types WHERE typ_cod=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if((isset($action))&&($action=='STAT')){
		$qry=sprintf('UPDATE tbl_types SET typ_stat=%s WHERE typ_cod=%s',
			GetSQLValueString($stat,'int'),
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
$LOG.=mysql_error();
$_SESSION['LOG']['t']='Atributos';
$_SESSION['LOG']['m']=$LOG;
if((mysql_error())||(isset($LOGe))) $_SESSION['LOGr']="danger"; else $_SESSION['LOGr']="success";
$insertGoTo=urlr($insertGoTo);
header(sprintf("Location: %s", $insertGoTo));
?>