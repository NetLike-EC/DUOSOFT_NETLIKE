<?php include('../../init.php');
$dM=vLogin('PACIENTE');
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$id=vParam('id', $_GET['id'], $_POST['id']);
$vP=FALSE;
//$vD=TRUE;
$data=$_POST;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
if ((isset($data['mod'])) && ($data['mod'] == $dM['mod_ref'])){
	$LOGd.='<small>mod</small>';
	if ((isset($acc)) && ($acc == md5("INSp"))){
		$LOGd.='<small>acc. INS</small>';
		$qry=sprintf('INSERT INTO db_pacientes (cli_doc, cli_fec, pac_reg, cli_nom, cli_ape, cli_lugp, pac_lugr, pac_dir, pac_sect, pac_tel1 , pac_tel2, pac_email, pac_tipsan, pac_estciv, pac_hijos, pac_sexo, pac_raza, pac_ins, pac_pro, pac_emp, pac_ocu, cli_nompar, pac_telpar, pac_ocupar, cli_fecpar, pac_tipsanpar, publi, pac_obs, pac_tipst) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($data['cli_doc'], "text"),
		SSQL($data['cli_fec'], "date"), SSQL($sdate, "date"),
		SSQL(strtoupper($data['cli_nom']), "text"), SSQL(strtoupper($data['cli_ape']), "text"),
		SSQL($data['cli_lugp'], "text"), SSQL($data['pac_lugr'], "text"),
		SSQL($data['pac_dir'], "text"), SSQL($data['pac_sect'], "int"),
		SSQL($data['pac_tel1'], "text"), SSQL($data['pac_tel2'], "text"), 
		SSQL($data['pac_email'], "text"),
		SSQL($data['pac_tipsan'], "int"), SSQL($data['pac_estciv'], "int"), SSQL($data['pac_hijos'], "int"), 
		SSQL($data['pac_sexo'], "int"), SSQL($data['pac_raza'], "int"),
		SSQL($data['pac_ins'], "int"), SSQL($data['pac_pro'], "text"), 
		SSQL($data['pac_emp'], "text"), SSQL($data['pac_ocu'], "text"),
		SSQL($data['cli_nompar'], "text"), SSQL($data['pac_telpar'], "text"), SSQL($data['pac_ocupar'], "text"), SSQL($data['cli_fecpar'], "date"), SSQL($data['pac_tipsanpar'], "int"),
		SSQL($data['publi'], "text"), SSQL($data['pac_obs'], "text"), SSQL($data['pac_tipst'], "int"));
		//$LOGd.='<small>'.$qry.'</small>';
		if(@mysql_query($qry)){ $id = @mysql_insert_id();
			$LOG.='<p>Paciente Creado</p>';
			// Registro Historia Clinic
			$qryHc=sprintf('INSERT INTO db_paciente_hc (cli_id) VALUES (%s)',
			SSQL($id, "int"));
			if(@mysql_query($qryHc)){ $id_hc = @mysql_insert_id();
				$LOG.='<p>Historial Clinica Generada</p>';
				//Registro Obstetrico
				$qryGin=sprintf('INSERT INTO db_pacientes_gin (cli_id) VALUES (%s)',
				SSQL($id, "int"));
				if(@mysql_query($qryGin)){
					$vP=TRUE;
					$id_gin = @mysql_insert_id();
					$LOG.='<p>Registro Ginecologico Creado</p>';
				}else $LOG.='<p>Error al Insertar</p>'.mysql_error();
			}else $LOG.='<p>Error al Insertar</p>'.mysql_error();
		}else $LOG.='<p>Error al Insertar</p>'.mysql_error();
		$goTo.= '?id='.$id;
	}
	if ((isset($acc)) && ($acc == md5("UPDp"))){
		$LOGd.='<small>acc. UPD</small>';
		$qry=sprintf('UPDATE db_pacientes SET cli_doc=%s, cli_fec=%s, cli_nom=%s, cli_ape=%s, cli_lugp=%s, pac_lugr=%s, pac_dir=%s, pac_sect=%s, pac_tel1=%s, pac_tel2=%s, pac_email=%s, pac_tipsan=%s, pac_estciv=%s, pac_hijos=%s, pac_sexo=%s, pac_raza=%s, pac_ins=%s, pac_pro=%s, pac_emp=%s, pac_ocu=%s, cli_nompar=%s, pac_telpar=%s, pac_ocupar=%s, cli_fecpar=%s, pac_tipsanpar=%s, publi=%s, pac_obs=%s, pac_tipst=%s 
		WHERE cli_id=%s',
		SSQL($data['cli_doc'], "text"),
		SSQL($data['cli_fec'], "date"),
		SSQL(strtoupper($data['cli_nom']), "text"), SSQL(strtoupper($data['cli_ape']), "text"),
		SSQL($data['cli_lugp'], "text"), SSQL($data['pac_lugr'], "text"),
		SSQL($data['pac_dir'], "text"),
		SSQL($data['pac_sect'], "text"),
		SSQL($data['pac_tel1'], "text"), SSQL($data['pac_tel2'], "text"),
		SSQL($data['pac_email'], "text"),
		SSQL($data['pac_tipsan'], "int"),
		SSQL($data['pac_estciv'], "int"), SSQL($data['pac_hijos'], "int"),
		SSQL($data['pac_sexo'], "int"), SSQL($data['pac_raza'], "int"),
		SSQL($data['pac_ins'], "int"),
		SSQL($data['pac_pro'], "text"),
		SSQL($data['pac_emp'], "text"),
		SSQL($data['pac_ocu'], "text"),
		SSQL($data['cli_nompar'], "text"), SSQL($data['pac_telpar'], "text"), SSQL($data['pac_ocupar'], "text"),
		SSQL($data['cli_fecpar'], "date"), SSQL($data['pac_tipsanpar'], "int"),
		SSQL($data['publi'], "text"), SSQL($data['pac_obs'], "text"), SSQL($data['pac_tipst'], "int"),
		SSQL($id, "int"));
		$LOGd.='<small>'.$qry.'</small>';
		if (@mysql_query($qry)){
			$vP=TRUE;
			$LOG.='<p>Actualizado Correctamente </p>'.$data['cli_nom'].' '.$data['cli_ape'];
		}else $LOG.='<p>Error al Actualizar Paciente</p>'.mysql_error();
		$goTo.='?id='.$id;
	}
}
$LOG.=mysql_error();
if($vD==TRUE) $LOG.=$LOGd;
if((!mysql_error())&&($vP==TRUE)){
	$_SESSION['sBr']=$data['cli_nom'].' '.$data['cli_ape'];
	mysql_query("COMMIT;");
	$LOGt.='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZii.'Ok-48.png';
}else{
	mysql_query("ROLLBACK;");
	$LOGt.='Solicitud no Procesada';
	$LOG.=mysql_error();
	$LOGc='alert-danger';
	$LOGi=$RAIZii.'Cancel-48.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $goTo));
?>