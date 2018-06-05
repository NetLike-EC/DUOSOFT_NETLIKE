<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$url=vParam('url', $_GET['url'], $_POST['url']);
$goTo=$url;
$det=$_POST;
//echo 'BEGIN<br>';
//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
	if((isset($det['form']))&&($det['form']=='form_mod')){
		//echo 'FORM<br>';
		if((isset($acc))&&($acc=='UPD')){
			//echo 'UPD<br>';
			$qry=sprintf('UPDATE db_componentes SET mod_ref=%s, mod_nom=%s, mod_des=%s, mod_icon=%s, mod_stat=%s WHERE mod_cod=%s',
			SSQL($det['mod_ref'],'text'),
			SSQL($det['mod_nom'],'text'),
			SSQL($det['mod_des'],'text'),
			SSQL($det['mod_icon'],'text'),
			SSQL($det['mod_stat'],'int'),
			SSQL($id,'int'));
			if(@mysql_query($qry)){
				$vP=TRUE;
				$LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($acc))&&($acc=='INS')){
			$qry=sprintf('INSERT INTO db_componentes (mod_ref, mod_nom, mod_des, mod_icon, mod_stat) 
			VALUES (%s,%s,%s,%s,%s)',
			SSQL($det['mod_ref'],'text'),
			SSQL($det['mod_nom'],'text'),
			SSQL($det['mod_des'],'text'),
			SSQL($det['mod_icon'],'text'),
			SSQL($det['mod_stat'],'int'));
			if(@mysql_query($qry)){ 
				$vP=TRUE;
				$id=@mysql_insert_id();
				$LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$goTo.='?id='.$id;
	}
	if((isset($acc))&&($acc=='DEL')){
		$qry=sprintf('DELETE FROM db_componentes WHERE mod_cod=%s',
			SSQL($id,'int'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		}else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if((isset($acc))&&($acc=='STAT')){
		$qry=sprintf('UPDATE db_componentes SET mod_stat=%s WHERE mod_cod=%s',
			SSQL($stat,'int'),
			SSQL($id,'int'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.="<h4>Status Actualizado</h4>Articulo: ".$id;
		}else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
$LOG.=mysql_error();
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Solicitud no Procesada';
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;

$goTo=urlr($goTo);
header(sprintf("Location: %s", $goTo));
?>