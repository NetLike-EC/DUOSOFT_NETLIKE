<?php include('../../init.php');
$urlr=vParam('urlr', $_GET['urlr'], $_POST['urlr']);
$urlr=urlReturn($urlr,'index.php');
$action=vParam('action', $_GET['action'], $_POST['action']);
$id=vParam('id', $_GET['id'], $_POST['id']);
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if ((isset($_POST['mod'])) && ($_POST['mod'] ==md5(fCLI))){
	if ((isset($action)) && ($action == md5(INSc))){
		$idAud=AUD(NULL,'Creación Paciente');
		$qryins=sprintf('INSERT INTO db_clientes (pac_ced, pac_fec, pac_nom, pac_ape, pac_lugp, pac_lugr, pac_dir, pac_sect, pac_tel1 , pac_tel2, pac_email, pac_tipsan, pac_estciv, pac_hijos, pac_sexo, pac_ins, pac_pro, pac_emp, pac_ocu, pac_nompar, pac_telpar, pac_ocupar, pac_fecpar, pac_tipsanpar, publi, pac_obs, pac_tipst, isnew, pac_fecr, id_aud) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($_POST['pac_ced'], "text"),
		SSQL($_POST['pac_fec'], "date"),
		SSQL($_POST['pac_nom'], "text"),
		SSQL($_POST['pac_ape'], "text"),
		SSQL($_POST['pac_lugp'], "text"),
		SSQL($_POST['pac_lugr'], "text"),
		SSQL($_POST['pac_dir'], "text"),
		SSQL($_POST['pac_sect'], "int"),
		SSQL($_POST['pac_tel1'], "text"),
		SSQL($_POST['pac_tel2'], "text"),
		SSQL($_POST['pac_email'], "text"),
		SSQL($_POST['pac_tipsan'], "int"),
		SSQL($_POST['pac_estciv'], "int"),
		SSQL($_POST['pac_hijos'], "int"),
		SSQL($_POST['pac_sexo'], "int"),
		SSQL($_POST['pac_ins'], "int"),
		SSQL($_POST['pac_pro'], "text"),
		SSQL($_POST['pac_emp'], "text"),
		SSQL($_POST['pac_ocu'], "text"),
		SSQL($_POST['pac_nompar'], "text"),
		SSQL($_POST['pac_telpar'], "text"),
		SSQL($_POST['pac_ocupar'], "text"),
		SSQL($_POST['pac_fecpar'], "date"),
		SSQL($_POST['pac_tipsanpar'], "int"),
		SSQL($_POST['publi'], "text"),
		SSQL($_POST['pac_obs'], "text"),
		SSQL($_POST['pac_tipst'], "int"),
		SSQL($_POST['isNew'], "int"),
		SSQL($sdate, "date"),
		SSQL($idAud,"int"));
		if(@mysql_query($qryins)){ $id = @mysql_insert_id();
			$LOG.='<p>Paciente Creado</p>';
			// Registro Historia Clinic
			$qryInsHc=sprintf('INSERT INTO db_clientes_hc (pac_cod) VALUES (%s)',
			SSQL($id, "int"));
			if(@mysql_query($qryInsHc)){ $id_hc = @mysql_insert_id();
				$LOG.='<p>Historial Clinica Generada</p>';
				//Registro Obstetrico
				$qryInsGin=sprintf('INSERT INTO db_ginecologia (pac_cod) VALUES (%s)',
				SSQL($id, "int"));
				if(@mysql_query($qryInsGin)){ $id_gin = @mysql_insert_id();
					$LOG.='<p>Registro Ginecologico Creado</p>';
				}else{
					$LOG.='<p>Error al Insertar</p>';
					$LOG.=mysql_error();
				}
			}else{ 
				$LOG.='<p>Error al Insertar</p>';
				$LOG.=mysql_error();
			}
		}else{
			$LOG.='<p>Error al Insertar</p>';
			$LOG.=mysql_error();
		}
		$urlr.= '?id='.$id;
	}
	if ((isset($action)) && ($action == md5(UPDc))){
		$detPac=detRow('db_clientes','pac_cod',$id);
		$idAud=AUD($detPac['id_aud'],'Actualización Paciente');
		
		$qryupd=sprintf('UPDATE db_clientes SET pac_ced=%s, pac_fec=%s, pac_nom=%s, pac_ape=%s, pac_lugp=%s, pac_lugr=%s, pac_dir=%s, pac_sect=%s, pac_tel1=%s, pac_tel2=%s, pac_email=%s, pac_tipsan=%s, pac_estciv=%s, pac_hijos=%s, pac_sexo=%s, pac_ins=%s, pac_pro=%s, pac_emp=%s, pac_ocu=%s, pac_nompar=%s, pac_telpar=%s, pac_ocupar=%s, pac_fecpar=%s, pac_tipsanpar=%s, publi=%s, pac_obs=%s, pac_tipst=%s, isnew=%s, id_aud=%s 
		WHERE pac_cod=%s',
		SSQL($_POST['pac_ced'], "text"),
		SSQL($_POST['pac_fec'], "date"),
		SSQL($_POST['pac_nom'], "text"),
		SSQL($_POST['pac_ape'], "text"),
		SSQL($_POST['pac_lugp'], "text"),
		SSQL($_POST['pac_lugr'], "text"),
		SSQL($_POST['pac_dir'], "text"),
		SSQL($_POST['pac_sect'], "text"),
		SSQL($_POST['pac_tel1'], "text"),
		SSQL($_POST['pac_tel2'], "text"),
		SSQL($_POST['pac_email'], "text"),
		SSQL($_POST['pac_tipsan'], "int"),
		SSQL($_POST['pac_estciv'], "int"),
		SSQL($_POST['pac_hijos'], "int"),
		SSQL($_POST['pac_sexo'], "int"),
		SSQL($_POST['pac_ins'], "int"),
		SSQL($_POST['pac_pro'], "text"),
		SSQL($_POST['pac_emp'], "text"),
		SSQL($_POST['pac_ocu'], "text"),
		SSQL($_POST['pac_nompar'], "text"),
		SSQL($_POST['pac_telpar'], "text"),
		SSQL($_POST['pac_ocupar'], "text"),
		SSQL($_POST['pac_fecpar'], "date"),
		SSQL($_POST['pac_tipsanpar'], "int"),
		SSQL($_POST['publi'], "text"),
		SSQL($_POST['pac_obs'], "text"),
		SSQL($_POST['pac_tipst'], "int"),
		SSQL($_POST['isNew'], "int"),
		SSQL($idAud,"int"),
		SSQL($id, "int"));
		if (@mysql_query($qryupd)) $LOG.='<h4>Actualizado Correctamente </h4>'.$_POST['pac_nom'].' '.$_POST['pac_ape'];
		else{
			$LOG.='<h4>Error al Actualizar Paciente</h4>';
			$LOG.=mysql_error();
		}
		$urlr.='?id='.$id;
	}
}

if(($vP==TRUE)&&(!mysql_error())){
	$_SESSION['sBr']=$_POST['pac_nom'].' '.$_POST['pac_ape'];
	mysql_query("COMMIT;");
	$LOGt.='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt.='Solicitud no Procesada';
	$LOG.=mysql_error();
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysql_error();
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $urlr));
?>