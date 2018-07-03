<?php require('../../init.php');
vLOGIN();
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$val=vParam('val', $_GET['val'], $_POST['val']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$dat=$_POST;
$vP=FALSE;
$vD=FALSE;
mysqli_query($conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query($conn,"BEGIN;"); //Inicia la transaccion
if(($dat['form'])&&($dat['form']==md5('formUsr'))){
	if(($dat['acc'])&&($dat['acc']==md5('INSu'))){
		$idAud=AUD(NULL,'Creación Usuario');
		$qry=sprintf('INSERT INTO tbl_user_system (user_username, user_password, user_password_hint, user_name, user_email, user_level, user_theme, user_lang, user_status, id_aud) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
					 SSQL($dat['inpUserName'],'text'),
					 SSQL(md5($dat['formPassNew1']),'text'),
					 SSQL($dat['inpPassHint'],'text'),
					 SSQL($dat['inpName'],'text'),
					 SSQL($dat['inpEmail'],'text'),
					 SSQL($dat['inpLev'],'int'),
					 SSQL($dat['inpTheme'],'text'),
					 SSQL($dat['inpLang'],'text'),
					 SSQL('1','int'),
					 SSQL($idAud,'int'));
		$LOGd.=$qry;
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$id=mysqli_insert_id($conn);
			$ids=md5($id);
			$LOG.=$cfg[p]['ins-true'];
		}else $LOG.=$cfg[p]['ins-false'].mysqli_error($conn);
	}
	if(($dat['acc'])&&($dat['acc']==md5('UPDu'))){
		$dU=detRow('tbl_user_system','md5(user_id)',$ids);
		$idA=AUD($dU['id_aud'],'Actualización Usuario');
		$qry=sprintf('UPDATE tbl_user_system SET user_username=%s, user_name=%s, user_email=%s, user_level=%s, user_theme=%s, user_lang=%s WHERE md5(user_id)=%s LIMIT 1',
							SSQL($dat['inpUserName'],'text'),
							SSQL($dat['inpName'],'text'),
							SSQL($dat['inpEmail'],'text'),
							SSQL($dat['inpLev'],'int'),
							SSQL($dat['inpTheme'],'text'),
							SSQL($dat['inpLang'],'text'),
							SSQL($ids,'text'));
		$LOGd.=$qry;
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['upd-true'];
		}else $LOG.=$cfg[p]['upd-false'].mysqli_error($conn);
		
		//UPDATE PASSWORD
		if(($dat['formPassNew1'])&&($dat['formPassNew2'])){
			$vP=FALSE;
			if($dat['formPassNew1']==$dat['formPassNew2']){
				$idA=AUD($dU['id_aud'],'Actualización Contraseña');
				$qry=sprintf('UPDATE tbl_user_system SET user_password=%s, user_password_hint=%s WHERE md5(user_id)=%s',
				SSQL(md5($dat['formPassNew1']),'text'),
				SSQL($dat['inpPassHint'],'text'),
				SSQL($ids,'text'));
				$LOGd.=$qry;
				if(mysqli_query($conn,$qry)){
					$LOG.='<p>Contraseña Actualizada Correctamente</p>';
					$vP=TRUE;
				}else{
					$vP=FALSE;
					$LOG.='<p>Error Actualizar Contraseña</p>'.mysqli_error($conn);
				}
			}else $LOG.='<p>CONTRASEÑA NO SE PUDO ACTUALIZAR, no coinciden</p>';
		}//else $LOG.='<p>CONTRASEÑA VACIA</p>';
	}
	$goTo.='?ids='.$ids;
}//END USER

////////////////////////////////////////////////

if(($dat['form'])&&($dat['form']=='formPass')){
$goTo=$RAIZc.'com_usersystem/changePass.php';
//Valid Token
$datUsu=detRow('tbl_usuario','usr_id',$_SESSION['MM_UserID']);
if($datUsu){
	//Usuario Valido
	$datUsu_passAnt=$datUsu['usr_contrasena'];
	if($datUsu_passAnt==md5($dat['formPassAnt'])){
		//Contraseña Anterior Correcta
		if($datUsu_passAnt!=md5($dat['formPassNew1'])){
			//Contraseña Nueva Difente a la Original
			if($dat['formPassNew1']==$dat['formPassNew2']){
				//Contraseñas Nuevas Coincidentes
				//Actualizo Contraseña
				$passNew=md5($dat['formPassNew1']);
				$id_aud=AUD($datUsu['id_aud'],'Cambio Password Usuario');
				$qry=sprintf('UPDATE tbl_usuario SET usr_contrasena=%s, id_aud=%s WHERE usr_id=%s',
				SSQL($passNew,'text'),
				SSQL($id_aud,'int'),
				SSQL($_SESSION['MM_UserID'],'int'));
				if(mysqli_query($conn,$qry)){
					//Contraseña Modificada
					$vP=TRUE;
					$LOG.='<h4>Contraseña Modificada Correctamente</h4>';
				}else{
					//Error al modificar contraseña
					$LOG.=mysqli_error($conn);
					$LOG.='<h4>No se pudo modificar contraseña</h4>';
				}
			}else{
				//Contraseñas no Coinciden
				$LOG.='<h4>LAS CONTRASEÑAS NUEVAS NO COINCIDEN</h4>Intente otra vez';
			}
		}else{
			//Contraseña Anterior Incorrecta
			$LOG.='<h4>LA NUEVA CONTRASEÑA ES IGUAL A LA ANTERIOR</h4>Ingrese una nueva clave';
		}

	}else{
		//Contraseña Anterior Incorrecta
		$LOG.='<h4>CONTRASEÑA ANTERIOR INCORRECTA</h4>Intente otra vez';
	}
}else{
	//Usuario No Existe
	$LOG.='<h4>USUARIO NO EXISTE EN EL SISTEMA</h4>';
}
}//END IF
	
if(($dat['form'])&&($dat['form']=='formPerfil')){
	$goTo=$RAIZc.'com_usersystem/user_perfil.php';

	$datUsu=detRow('tbl_usuario','usr_id',$_SESSION['MM_UserID']);
	$datEmp=detRow('db_empleados','emp_cod',$datUsu['emp_cod']);
	$id_aud=AUD($datUsu['id_aud'],'Actualización Usuario');
	//UPDATE tbl_usuarioa
	$qryUpdUsr=sprintf('UPDATE tbl_usuario SET usr_nombre=%s, usr_theme=%s, id_aud=%s WHERE usr_id=%s',
	SSQL($dat['usr_nombre'],'text'),
	SSQL($dat['user_theme'],'text'),
	SSQL($id_aud,'int'),
	SSQL($_SESSION['MM_UserID'],'int'));
	if(@mysqli_query($conn,$qryUpdUsr)){
		$LOG.='<p>Usuario Actualizado</p>';
		//UPDATE db_empleados
		$id_aud=AUD($datEmp['id_aud'],'Actualización Empleado');
		$qryUpdEmp=sprintf('UPDATE db_empleados SET typ_cod=%s, emp_ced=%s, emp_nom=%s, emp_ape=%s, emp_dir=%s, emp_tel=%s, emp_cel=%s, emp_mail=%s, id_aud=%s WHERE emp_cod=%s',
		SSQL($dat['typ_cod'],'int'),
		SSQL($dat['emp_ced'],'text'),
		SSQL($dat['emp_nom'],'text'),
		SSQL($dat['emp_ape'],'text'),
		SSQL($dat['emp_dir'],'text'),
		SSQL($dat['emp_tel'],'text'),
		SSQL($dat['emp_cel'],'text'),
		SSQL($dat['emp_mail'],'text'),
		SSQL($id_aud,'int'),
		SSQL($datUsu['emp_cod'],'text'));
		if(@mysqli_query($conn,$qryUpdEmp)){
			$LOG.='<p>Empleado Actualizado</p>';
			$vP=TRUE;
		}else{
			$LOG.='<p>No se pudo actualizar</p>';
			$LOG.=mysqli_error($conn);
		}
	}else{
		$LOG.='<p>No se pudo actualizar</p>';
		$LOG.=mysqli_error($conn);
	}
}
	//ACTUALIZAR STATUS EMPLEADO 1=ACTIVO, 0=INACTIVO
if((isset($dat['acc']))&&($dat['acc']==md5('STu'))){
	$qry=sprintf('UPDATE tbl_user_system SET user_status=%s WHERE md5(user_id)=%s',
	SSQL($dat['val'],'int'),
	SSQL($ids,'text'));
	if(@mysqli_query($conn,$qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['est-true'];
	}else $LOG.=$cfg[p]['est-false'].mysqli_error($conn);
}

if($vD) $LOG.=$LOGd;
if((!mysqli_error($conn))&&($vP==TRUE)){
	mysqli_query($conn,"COMMIT;");
	$LOGt=$cfg['p']['m-ok'];
	$LOGc=$cfg['p']['c-ok'];
	$LOGi=$RAIZa.$cfg['p']['i-ok'];	
}else{
	mysqli_query($conn,"ROLLBACK;");
	$LOGt=$cfg['p']['m-fail'];
	$LOGc=$cfg['p']['c-fail'];
	$LOGi=$RAIZa.$cfg['p']['i-fail'];
	//$_SESSION['form']=$dat;
}
mysqli_query($conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $goTo));
?>