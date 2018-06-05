<?php include('../../init.php');
vLogin();
$id=vParam('id',$_GET['id'],$_POST['id']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$form=vParam('form',$_GET['form'],$_POST['form']);
$url=vParam('url',$_GET['url'],$_POST['url']);
$goTo=$url;

$det=$_POST;	
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if(($form)&&($form=='formUsrPerm')){
	if(($acc)&&($acc=='UPD')){
		//Query 2
		$qryELIM = sprintf('DELETE FROM tbl_menu_usuario WHERE usr_id=%s', SSQL($id, 'int'));
		if(mysql_query($qryELIM)){
			$vPM=TRUE;
			foreach($det['CMP'] as $valMen){
				$qryIM= sprintf('INSERT INTO tbl_menu_usuario (usr_id, men_id) VALUES (%s, %s)',
				SSQL($id,'int'),
				SSQL($valMen,'int'));
				if(!mysql_query($qryIM)){
					$LOG.= '<h4>Error al Crear Permisos</h4>'.mysql_error();
					$vPM=FALSE;
					break;
				}
			}
			if($vPM){
				$LOG.='<h4>Permisos Actualizados Correctamente</h4>';
				$vP=TRUE;
			} else $vP=FALSE;
		}else{
			$LOG.= '<h4>Error al Eliminar Permisos Anteriores.</h4>'.mysql_error();
		}
	}
$goTo.='?id='.$id;
}

if(($acc)&&($acc=='CLEAN')){
		
}

$LOG.=mysql_error();
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
	$LOG.='EJECUTADO.';
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
	$LOG.='NO SE REALIZA.';
}		

mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit		
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;

header(sprintf("Location: %s", $goTo));
?>