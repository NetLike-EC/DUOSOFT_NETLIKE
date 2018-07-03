<?php include('../../init.php');
$_SESSION['LOG']=NULL;//INICIALIZA SESSION LOG
$id=vParam('id',$_GET['id'],$_POST['id']); //ID STANDAR
$idp=vParam('idp',$_GET['idp'],$_POST['idp']); //ID PACIENTE
$idc=vParam('idc',$_GET['idc'],$_POST['idc']); //ID CONSULTA
//Variables para funciones de TRATAMIENTOS
$idt=vParam('idt',$_GET['idt'],$_POST['idt']);
$idtd=vParam('idtd',$_GET['idtd'],$_POST['idtd']);

$ide=vParam('ide',$_GET['ide'],$_POST['ide']);
$idr=vParam('idr',$_GET['idr'],$_POST['idr']);
//Variables para funcion de Obstetricia
$ido=vParam('ido',$_GET['ido'],$_POST['ido']);

//VARIABLE ACCION Y REDIRECCION
$action=vParam('action',$_GET['action'],$_POST['action']);
$urlreturn=$_SESSION['urlp'];
/**********************************************************************/
//FUNCIONES PARA TRATAMIENTOS
if ((isset($_POST['form'])) && ($_POST['form'] == 'tratdet')){
	if($action=='INS'){	
	$qryinst=sprintf('INSERT INTO db_tratamientos (con_num, pac_cod, fecha, fechap, diagnostico, obs)
	VALUES (%s,%s,%s,%s,%s,%s)',
	GetSQLValueString($_POST['idc'], "int"),
	GetSQLValueString($_POST['idp'], "int"),
	GetSQLValueString($_POST['fecha'], "date"),
	GetSQLValueString($_POST['fechap'], "date"),
	GetSQLValueString($_POST['diagnostico'], "text"),
	GetSQLValueString($_POST['obs'], "text"));
	if(@mysql_query($qryinst)){ $idt = @mysql_insert_id();
		$LOG.='<h4>Tratamiento Creado</h4> Numero. <strong>'.$idt.'</strong>';
	}else $LOG.='Error al Insertar';
	$urlreturn.='?idt='.$idt;
	}
	
	if($action=='UPD'){	
	$qryinst=sprintf('UPDATE db_tratamientos SET diagnostico=%s, fechap=%s, obs=%s WHERE tid=%s',
	GetSQLValueString($_POST['diagnostico'], "text"),
	GetSQLValueString($_POST['fechap'], "date"),
	GetSQLValueString($_POST['obs'], "text"),
	GetSQLValueString($_POST['idt'], "int"));
	if(@mysql_query($qryinst)){ $idt = $_POST['idt'];
		$LOG.='<p>Tratamiento Actualizado</p>';
	}else $LOG.='<p>Error al Actualizar</p>';
	$urlreturn.='?idt='.$idt;
	}
	
	if($action=='INSD'){	
	$qryins=sprintf('INSERT INTO db_tratamientos_detalle (tid, id_form, generico, comercial, presentacion, cantidad, descripcion)
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
	GetSQLValueString($_POST['trat_id'], "int"),
	GetSQLValueString($_POST['id_form'], "int"),
	GetSQLValueString($_POST['generico'], "text"),
	GetSQLValueString($_POST['comercial'], "text"),
	GetSQLValueString($_POST['presentacion'], "text"),
	GetSQLValueString($_POST['cantidad'], "int"),
	GetSQLValueString($_POST['descripcion'], "text"));
	if(@mysql_query($qryins)) $LOG.='<p>Medicamento Guardado</p>';
	else $LOG.='<p>Error al Guardar Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.$_POST['trat_id'];
	}
	
	if($action=='UPDD'){	
	$qryUpd=sprintf('UPDATE db_tratamientos_detalle SET generico=%s, comercial=%s, presentacion=%s, cantidad=%s, descripcion=%s WHERE id=%s',
	GetSQLValueString($_POST['generico'], "text"),
	GetSQLValueString($_POST['comercial'], "text"),
	GetSQLValueString($_POST['presentacion'], "text"),
	GetSQLValueString($_POST['cantidad'], "int"),
	GetSQLValueString($_POST['descripcion'], "text"),
	GetSQLValueString($idtd, "int"));
	if(@mysql_query($qryUpd)) $LOG.='<p>Medicamento Guardado</p>';
	else $LOG.='<p>Error al Guardar Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.$_POST['trat_id'];
	}
	
}
/**********************************************************************/
//FUNCIONES PARA OBSTETRICIA
if ((isset($_POST['form'])) && ($_POST['form'] == 'obsdet')){
	if($action=='INS'){	
	$qryINS=sprintf('INSERT INTO db_obstetrico (pac_cod, obs_fec, obs_fec_um, obs_fecf)
	VALUES (%s,%s,%s,%s)',
	GetSQLValueString($idp, "int"),
	GetSQLValueString($_POST['obs_fec'], "date"),
	GetSQLValueString($_POST['obs_fec_um'], "date"),
	GetSQLValueString($_POST['obs_fecf'], "date"));
	if(@mysql_query($qryINS)){
		$id = @mysql_insert_id();
		$LOG.='<h4>Seguimiento Obstétrico Creado</h4> Numero. <strong>'.$id.'</strong>';
	}else $LOG.='<h4>Error al Insertar</h4>Intente Nuevamente';
	$urlreturn.='?ido='.$id;
	}
	
	if($action=='UPD'){	
	$qryinst=sprintf('UPDATE db_obstetrico SET obs_fec=%s, obs_fec_um=%s, obs_fecf=%s WHERE obs_id=%s',
	GetSQLValueString($_POST['obs_fec'], "date"),
	GetSQLValueString($_POST['obs_fec_um'], "date"),
	GetSQLValueString($_POST['obs_fecf'], "date"),
	GetSQLValueString($ido,'int'));
	if(@mysql_query($qryinst)){
		$LOG.='<h4>Seguimiento Actualizado</h4>';
		$_SESSION['LOG']['t']='OPERACIÓN EXITOSA';	
		$_SESSION['LOG']['c']='info';
		$_SESSION['LOG']['i']=$RAIZii.'Ok-48.png';
	}else $LOG.='Error al Actualizar';
	$urlreturn.='?ido='.$ido;
	}
	
	if($action=='INSD'){	
		$qryins=sprintf('INSERT INTO db_obstetrico_detalle (obs_id, obs_det, obs_fec)
		VALUES (%s,%s,%s)',
		GetSQLValueString($ido, 'int'),
		GetSQLValueString($_POST['obs_det'], 'text'),
		GetSQLValueString($_POST['obs_fec'], 'date'));
		if(@mysql_query($qryins)){
			$LOG.='<h4>Visita Guardada</h4>';
			$_SESSION['LOG']['t']='OPERACIÓN EXITOSA';	
			$_SESSION['LOG']['c']='info';
			$_SESSION['LOG']['i']=$RAIZii.'Ok-48.png';
		} else $LOG.='<h4>Error al Insertar<h4>';
		$urlreturn='?ido='.$ido;
	}
	
}

//FUNCIONES PARA EXAMENES
if ((isset($_POST['form'])) && ($_POST['form'] == 'fexamen')){
	
	if(($_FILES['efile']['name'])){
	$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZ.'media/db/exam/';
	$param_file['pre']='exa';
	$upl=uploadfile($param_file, $_FILES['efile']);
	if($upl['EST']==TRUE){
	//INS MEDIA
	$qryIns = sprintf("INSERT INTO db_media (file, des, estado) VALUES (%s,%s,%s)",
	GetSQLValueString($upl['FILE'], "text"),
	GetSQLValueString($dfile, "text"),
	GetSQLValueString("1", "int"));
	$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
	$insID=mysql_insert_id();
	//INS REP OBS MEDIA
	$qryIns = sprintf("INSERT INTO db_examenes_media (id_exa, id_med) VALUES (%s,%s)",
	GetSQLValueString($ide, "int"),
	GetSQLValueString($insID, "int"));
	$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
	$insID=mysql_insert_id();
	//fnc_genthumb($param_file['pat'], $aux_grab[2], "t_", 250, 200);
	}
	}
	
	
	
	if($action=='INS'){	
	$qryinst=sprintf('INSERT INTO db_examenes (pac_cod,con_num,fecha,fechae,typ_cod,descripcion,resultado)
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
	GetSQLValueString($_POST['idp'], "int"),
	GetSQLValueString($_POST['idc'], "int"),
	GetSQLValueString($sdate, "date"),
	GetSQLValueString($_POST['fechae'], "date"),
	GetSQLValueString($_POST['typ_cod'], "int"),
	GetSQLValueString($_POST['descripcion'], "text"),
	GetSQLValueString($_POST['resultado'], "text"));
	if(@mysql_query($qryinst)){ $ide = @mysql_insert_id();
		$LOG.='<p>Examen Creado</p>';
	}else $LOG.='Error al Insertar';
	$urlreturn.='?ide='.$ide;
	}
	if($action=='UPD'){	
	$qryupd=sprintf('UPDATE db_examenes SET fechae=%s,typ_cod=%s,descripcion=%s,resultado=%s WHERE id_exa=%s',
	GetSQLValueString($_POST['fechae'], "date"),
	GetSQLValueString($_POST['typ_cod'], "int"),
	GetSQLValueString($_POST['descripcion'], "text"),
	GetSQLValueString($_POST['resultado'], "text"),
	GetSQLValueString($_POST['ide'], "int"));
	if(@mysql_query($qryupd)) $LOG.='<p>Examen Actualizado</p>';
	else $LOG.='Error al Actualizar';
	$urlreturn.='?ide='.$ide;
	}
	
}


/************************************************************************************/
//FUNCIONES DE ELIMINACION GENERAL
/************************************************************************************/

//Eliminación de TRATAMIENTO (cab)
if ((isset($action)) && ($action == 'DELTF')){
	$accjs=TRUE;
	$qrydelD=sprintf('DELETE FROM db_tratamientos_detalle WHERE tid=%s',
	GetSQLValueString($idt, "int"));
	if(@mysql_query($qrydelD)){
		$LOG.='<p>Eliminados Medicamentos Tratamiento</p>';
		$qrydel=sprintf('DELETE FROM db_tratamientos WHERE tid=%s',
		GetSQLValueString($idt, "int"));
		if(@mysql_query($qrydel)){
			$LOG.='<p>Eliminado Tratamiento</p>';
		}else{
			$LOG.=mysql_error();
		}
	}else{
		$LOG.=mysql_error();
	}
}
//Eliminación de TRATAMIENTO Detalle
if ((isset($action)) && ($action == 'DELTD')){
	$qrydel=sprintf('DELETE FROM db_tratamientos_detalle WHERE id=%s',
	GetSQLValueString($idtd, "int"));
	if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.$idt;
}

//Eliminación de OBSTETRICO (cab)
if ((isset($action)) && ($action == 'DELOF')){
	$qrydelD=sprintf('DELETE FROM db_obstetrico_detalle WHERE obs_id=%s',
	GetSQLValueString($ido, "int"));
	if(@mysql_query($qrydelD)){
		$LOG.='<p>Eliminado Detalles Seguimiento</p>';
		$qrydel=sprintf('DELETE FROM db_obstetrico WHERE obs_id=%s',
		GetSQLValueString($ido, "int"));
		if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Seguimiento</p>';
		else $LOG.='<p>Error al Eliminar Seguimiento</p>';
	}else $LOG.='<p>Error al Eliminar Detalles</p>';
	echo '<script type="text/javascript">parent.Shadowbox.close();</script>';
}
//Eliminación de OBSTETRICO Detalle
if ((isset($action)) && ($action == 'DELOD')){
	$qrydel=sprintf('DELETE FROM db_obstetrico_detalle WHERE id=%s',
	GetSQLValueString($idod, "int"));
	if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Registro de Seguimiento</p>';
	$urlreturn.='?ido='.$ido;
}


if ((isset($action)) && ($action == 'DELEF')){
	$qrydelM=sprintf('DELETE FROM db_examenes_media WHERE id_exa=%s',
	GetSQLValueString($ide, "int"));
	if(@mysql_query($qrydelM)){
		$LOG.='<p>Eliminado Multimedia Examen</p>';
		$qrydel=sprintf('DELETE FROM db_examenes WHERE id_exa=%s',
		GetSQLValueString($ide, "int"));
		if(@mysql_query($qrydel)){
			$LOG.='<p>Eliminado Examen</p>';
		}else{
			$LOG.=mysql_error();
		}
	}else{
		$LOG.=mysql_error();
	}
	$accjs=TRUE;
}

if((isset($action))&&($action=='delEimg')){
	$qrydelei=sprintf('DELETE FROM db_examenes_media WHERE id=%s',
	GetSQLValueString($id,'int'));
	if(@mysql_query($qrydelei)) $LOG.='<h4>Archivo Eliminado</h4>Se ha eliminado correctamente imagen. ID: <strong>'.$id.'</strong>';
	else $LOG.='<b>No se pudo Eliminar</b><br />';
	$urlreturn.='?ide='.$ide;
}
if((isset($action))&&($action=='delRimg')){
	$qrydelei=sprintf('DELETE FROM db_cirugias_media WHERE id=%s',
	GetSQLValueString($id,'int'));
	if(@mysql_query($qrydelei)) $LOG.='<h4>Archivo Eliminado</h4>Se ha eliminado correctamente el archivo. ID: <strong>'.$id.'</strong>';
	else $LOG.='<b>No se pudo Eliminar</b><br />';
	$urlreturn.='?idr='.$idr;
}

$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;

if($accjs==TRUE){
	include(RAIZf.'head.php'); ?>
	<body class="cero">
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	parent.location.reload();
	</script>
    </body>
<?php }else{
	header(sprintf("Location: %s", $urlreturn));
}
?>