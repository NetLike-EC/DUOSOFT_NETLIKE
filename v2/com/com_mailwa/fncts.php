<?php include('../../init.php');
mysql_select_db($db_conn_wa, $conn);
$_SESSION['LOG']=NULL;
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$action=fnc_verifiparam('action', $_GET['action'], $_POST['action']);
$insertGoTo=$_SESSION['urlp'];
//BEG MOD ARTICLES PAGES
if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'MLSE')){
	if((isset($_POST['form']))&&($_POST['form']=='form_maile')){
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_contact_mail_exception SET mail=%s, WHERE idMail=%s',
			GetSQLValueString($_POST['mail'],'text'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry)){ $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;}
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO tbl_contact_mail_exception (mail) 
			VALUES (%s)',
			GetSQLValueString($_POST['mail'],'text'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$LOG.=mysql_error();
		$insertGoTo.='?id='.$id;
	}
	if((isset($action))&&($action=='DEL')){
		$qry=sprintf('DELETE FROM tbl_contact_mail_exception WHERE idMail=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
}//END MOD ARTICLES PAGES

if((isset($action))&&($action=='mailTest')){
	$qry=sprintf('UPDATE tbl_contact_mail SET test=%s WHERE idMail=%s',
		GetSQLValueString($_GET['stat'],'int'),
		GetSQLValueString($id,'int'));
	if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente</h4>ID. ".$id;
	else $LOG.='<h4>No se pudo Actualizar</h4>';
}
if((isset($action))&&($action=='mailBanned')){
	$qry=sprintf('UPDATE tbl_contact_mail SET banned=%s WHERE idMail=%s',
		GetSQLValueString($_GET['stat'],'int'),
		GetSQLValueString($id,'int'));
	if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente</h4>ID. ".$id;
	else $LOG.='<h4>No se pudo Actualizar</h4>';
}

$LOG.=mysql_error();
$_SESSION['LOG']=$LOG;
if((mysql_error())||(isset($LOGe))) $_SESSION['LOGr']="danger"; else $_SESSION['LOGr']="success";
$insertGoTo=urlr($insertGoTo);
header(sprintf("Location: %s", $insertGoTo));
?>