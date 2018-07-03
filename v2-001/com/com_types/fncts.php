<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$id=vParam('id', $_GET['id'], $_POST['id']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$url=vParam('url', $_GET['url'], $_POST['url']);
$ref=vParam('ref', $_GET['ref'], $_POST['ref']);
$goTo=$url;
	if((isset($_POST['form']))&&($_POST['form']=='form_mod')){
		if((isset($acc))&&($acc=='UPD')){
			$qry=sprintf('UPDATE db_types SET mod_cod=%s, typ_ref=%s, typ_icon=%s, typ_val=%s WHERE typ_cod=%s',			
			SSQL($_POST['form_mod'],'text'),
			SSQL($_POST['form_ref'],'text'),
			SSQL($_POST['form_icon'],'text'),
			SSQL($_POST['form_val'],'text'),
			SSQL($id,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($acc))&&($acc=='INS')){
			$qry=sprintf('INSERT INTO db_types (mod_cod, typ_ref, typ_icon, typ_val, typ_stat) 
			VALUES (%s,%s,%s,%s,%s)',
			SSQL($_POST['form_mod'],'text'),
			SSQL($_POST['form_ref'],'text'),
			SSQL($_POST['form_icon'],'text'),
			SSQL($_POST['form_val'],'text'),
			SSQL('1','int'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$goTo.='?id='.$id;
	}
	if((isset($acc))&&($acc=='DEL')){
		$qry=sprintf('DELETE FROM db_types WHERE typ_cod=%s',
			SSQL($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
		$goTo.='?ref='.$ref;
	}
	if((isset($acc))&&($acc=='STAT')){
		$qry=sprintf('UPDATE db_types SET typ_stat=%s WHERE typ_cod=%s',
			SSQL($stat,'int'),
			SSQL($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
$LOG.=mysql_error();
$_SESSION['LOG']['t']='Atributos';
$_SESSION['LOG']['m']=$LOG;
if((mysql_error())||(isset($LOGe))) $_SESSION['LOGr']="danger"; else $_SESSION['LOGr']="success";
$goTo=urlr($goTo);
header(sprintf("Location: %s", $goTo));
?>