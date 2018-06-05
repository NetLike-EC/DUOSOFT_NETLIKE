<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$insertGoTo=$_SESSION['urlp'];
	//ACCIONES form_men (MENUS CONTENEDORES)
	if((isset($_POST['form']))&&($_POST['form']=='form_men')){
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_menus SET menu_nom=%s, menu_ref=%s WHERE menu_id=%s',			
			GetSQLValueString($_POST['menu_nom'],'text'),
			GetSQLValueString($_POST['menu_ref'],'text'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO tbl_menus (menu_nom, menu_ref, menu_stat) 
			VALUES (%s,%s,%s)',
			GetSQLValueString($_POST['menu_nom'],'text'),
			GetSQLValueString($_POST['menu_ref'],'text'),
			GetSQLValueString('1','int'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$insertGoTo.='?id='.$id;
	}
	if((isset($_POST['form']))&&($_POST['form']=='form_meni')){
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_menus_items SET menu_id=%s, itemmenu_parent=%s, itemmenu_nom=%s, itemmenu_tit=%s, itemmenu_link=%s, itemmenu_icon=%s, itemmenu_order=%s 
			WHERE itemmenu_id=%s',			
			GetSQLValueString($_POST['menu_id'],'int'),
			GetSQLValueString($_POST['itemmenu_parent'],'int'),
			GetSQLValueString($_POST['itemmenu_nom'],'text'),
			GetSQLValueString($_POST['itemmenu_tit'],'text'),
			GetSQLValueString($_POST['itemmenu_link'],'text'),
			GetSQLValueString($_POST['itemmenu_icon'],'text'),
			GetSQLValueString($_POST['itemmenu_order'],'int'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO tbl_menus_items (menu_id, itemmenu_parent, itemmenu_nom, itemmenu_tit, itemmenu_link, itemmenu_icon, itemmenu_order,itemmenu_stat) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s)',
			GetSQLValueString($_POST['menu_id'],'int'),
			GetSQLValueString($_POST['itemmenu_parent'],'int'),
			GetSQLValueString($_POST['itemmenu_nom'],'text'),
			GetSQLValueString($_POST['itemmenu_tit'],'text'),
			GetSQLValueString($_POST['itemmenu_link'],'text'),
			GetSQLValueString($_POST['itemmenu_icon'],'text'),
			GetSQLValueString($_POST['itemmenu_order'],'int'),
			GetSQLValueString('1','int'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$insertGoTo.='?id='.$id;
	}
	//ACCIONES GET
	if((isset($action))&&($action=='DELM')){
		$qry=sprintf('DELETE FROM tbl_menus WHERE menu_id=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if((isset($action))&&($action=='STATM')){
		$qry=sprintf('UPDATE tbl_menus SET menu_stat=%s WHERE menu_id=%s',
			GetSQLValueString($stat,'int'),
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
	if((isset($action))&&($action=='DELMI')){
		$qry=sprintf('DELETE FROM tbl_menus_items WHERE itemmenu_id=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if((isset($action))&&($action=='STATMI')){
		$qry=sprintf('UPDATE tbl_menus_items SET itemmenu_stat=%s WHERE itemmenu_id=%s',
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