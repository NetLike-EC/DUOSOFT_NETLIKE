<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$action=fnc_verifiparam('action', $_GET['action'], $_POST['action']);
$insertGoTo=fnc_verifiparam('url', $_GET['url'], $_POST['url']);
$title=$_POST['title'];
$itemview=$_POST['itemview'];
$code=$_POST['code'];
$status=$_POST['status'];

//IF MOD FILES
if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'MMED')){
	if((isset($_POST['form']))&&($_POST['form']=='form_media')){
		if((isset($action))&&($action=='UPDATE')){
			$qry=sprintf('UPDATE tbl_mod_media SET itemview=%s, med_tit=%s, med_code=%s, med_status=%s',
				GetSQLValueString($itemview,'int'),
				GetSQLValueString($title,'text'),
				GetSQLValueString($code,'text'),
				GetSQLValueString($status,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>id. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INSERT')){
			$qry=sprintf('INSERT INTO tbl_mod_media (itemview, med_tit, med_code, med_status) VALUES (%s,%s,%s,%s)',
				GetSQLValueString($itemview,'int'),
				GetSQLValueString($title,'text'),
				GetSQLValueString($code,'text'),
				GetSQLValueString($status,'int'));
			if(@mysql_query($qry)){
				$id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id; $action="UPDATE";
			}else $LOG.='<b>Error al Grabar</b><br />';
		}
		$LOG.=mysql_error();
		$insertGoTo.='?id='.$id.'&action='.$action;
	}
	if((isset($action))&&($action=='DELETE')){
		$qry='DELETE FROM tbl_mod_media WHERE med_id='.$id;
		if(@mysql_query($qry)) $LOG.='<h4>Eliminado Correctamente</h4>id. '.$id;
		else $LOG.='<h4>Error. No se pudo Eliminar</h4>';
	}
	if(isset($_GET['stat'])){
		$qry='UPDATE tbl_mod_media SET med_status="'.$stat.'" WHERE med_id='.$id;
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>id. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
	$LOG.=mysql_error();
}//END IF MOD INVENTARIO CATS
$_SESSION['LOG']=$LOG;
if((mysql_error())||(isset($LOGe))) $_SESSION['LOGr']="e";
header(sprintf("Location: %s", $insertGoTo));
?>