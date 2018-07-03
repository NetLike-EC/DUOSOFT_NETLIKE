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
	SSQL($upl['FILE'], "text"),
	SSQL($dfile, "text"),
	SSQL("1", "int"));
	$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
	$insID=mysql_insert_id();
	//INS REP OBS MEDIA
	$qryIns = sprintf("INSERT INTO db_examenes_media (id_exa, id_med) VALUES (%s,%s)",
	SSQL($ide, "int"),
	SSQL($insID, "int"));
	$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
	$insID=mysql_insert_id();
	//fnc_genthumb($param_file['pat'], $aux_grab[2], "t_", 250, 200);
	}
	}
	
	
	
	if($action=='INS'){	
	$qryinst=sprintf('INSERT INTO db_examenes (cli_id,con_num,fecha,fechae,typ_cod,descripcion,resultado)
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
	SSQL($_POST['idp'], "int"),
	SSQL($_POST['idc'], "int"),
	SSQL($sdate, "date"),
	SSQL($_POST['fechae'], "date"),
	SSQL($_POST['typ_cod'], "int"),
	SSQL($_POST['descripcion'], "text"),
	SSQL($_POST['resultado'], "text"));
	if(@mysql_query($qryinst)){ $ide = @mysql_insert_id();
		$LOG.='<p>Examen Creado</p>';
	}else $LOG.='Error al Insertar';
	$urlreturn.='?ide='.$ide;
	}
	if($action=='UPD'){	
	$qryupd=sprintf('UPDATE db_examenes SET fechae=%s,typ_cod=%s,descripcion=%s,resultado=%s WHERE id_exa=%s',
	SSQL($_POST['fechae'], "date"),
	SSQL($_POST['typ_cod'], "int"),
	SSQL($_POST['descripcion'], "text"),
	SSQL($_POST['resultado'], "text"),
	SSQL($_POST['ide'], "int"));
	if(@mysql_query($qryupd)) $LOG.='<p>Examen Actualizado</p>';
	else $LOG.='Error al Actualizar';
	$urlreturn.='?ide='.$ide;
	}
	
}


/************************************************************************************/
//FUNCIONES DE ELIMINACION GENERAL
/************************************************************************************/
if ((isset($action)) && ($action == 'DELEF')){
	$qrydelM=sprintf('DELETE FROM db_examenes_media WHERE id_exa=%s',
	SSQL($ide, "int"));
	if(@mysql_query($qrydelM)){
		$LOG.='<p>Eliminado Multimedia Examen</p>';
		$qrydel=sprintf('DELETE FROM db_examenes WHERE id_exa=%s',
		SSQL($ide, "int"));
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
	SSQL($id,'int'));
	if(@mysql_query($qrydelei)) $LOG.='<h4>Archivo Eliminado</h4>Se ha eliminado correctamente imagen. ID: <strong>'.$id.'</strong>';
	else $LOG.='<b>No se pudo Eliminar</b><br />';
	$urlreturn.='?ide='.$ide;
}

$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;

if($accjs==TRUE){
	$css['body']='cero';
	include(RAIZf.'head.php'); ?>
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	parent.location.reload();
	</script>
    <?php include(RAIZf.'footer.php'); ?>
<?php }else{
	header(sprintf("Location: %s", $urlreturn));
}
?>