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

/**********************************************************************/
//FUNCIONES PARA OBSTETRICIA
if ((isset($_POST['form'])) && ($_POST['form'] == 'obsdet')){
	if($action=='INS'){	
	$qryINS=sprintf('INSERT INTO db_obstetrico (cli_id, obs_fec, obs_fec_um, obs_fecf)
	VALUES (%s,%s,%s,%s)',
	SSQL($idp, "int"),
	SSQL($_POST['obs_fec'], "date"),
	SSQL($_POST['obs_fec_um'], "date"),
	SSQL($_POST['obs_fecf'], "date"));
	if(@mysql_query($qryINS)){
		$id = @mysql_insert_id();
		$LOG.='<h4>Seguimiento Obstétrico Creado</h4> Numero. <strong>'.$id.'</strong>';
	}else $LOG.='<h4>Error al Insertar</h4>Intente Nuevamente';
	$urlreturn.='?ido='.$id;
	}
	
	if($action=='UPD'){	
	$qryinst=sprintf('UPDATE db_obstetrico SET obs_fec=%s, obs_fec_um=%s, obs_fecf=%s WHERE obs_id=%s',
	SSQL($_POST['obs_fec'], "date"),
	SSQL($_POST['obs_fec_um'], "date"),
	SSQL($_POST['obs_fecf'], "date"),
	SSQL($ido,'int'));
	if(@mysql_query($qryinst)){
		$LOG.='<h4>Seguimiento Actualizado</h4>';
		$_SESSION['LOG']['t']='OPERACIÓN EXITOSA';	
		$_SESSION['LOG']['c']='info';
		$_SESSION['LOG']['i']=$RAIZa.$_SESSION['conf']['i']['ok'];
	}else $LOG.='Error al Actualizar';
	$urlreturn.='?ido='.$ido;
	}
	
	if($action=='INSD'){	
		$qryins=sprintf('INSERT INTO db_obstetrico_detalle (obs_id, obs_det, obs_fec)
		VALUES (%s,%s,%s)',
		SSQL($ido, 'int'),
		SSQL($_POST['obs_det'], 'text'),
		SSQL($_POST['obs_fec'], 'date'));
		if(@mysql_query($qryins)){
			$LOG.='<h4>Visita Guardada</h4>';
			$_SESSION['LOG']['t']='OPERACIÓN EXITOSA';	
			$_SESSION['LOG']['c']='info';
			$_SESSION['LOG']['i']=$RAIZa.$_SESSION['conf']['i']['ok'];
		} else $LOG.='<h4>Error al Insertar<h4>';
		$urlreturn='?ido='.$ido;
	}
	
}




/************************************************************************************/
//FUNCIONES DE ELIMINACION GENERAL
/************************************************************************************/

//Eliminación de OBSTETRICO (cab)
if ((isset($action)) && ($action == 'DELOF')){
	$qrydelD=sprintf('DELETE FROM db_obstetrico_detalle WHERE obs_id=%s',
	SSQL($ido, "int"));
	if(@mysql_query($qrydelD)){
		$LOG.='<p>Eliminado Detalles Seguimiento</p>';
		$qrydel=sprintf('DELETE FROM db_obstetrico WHERE obs_id=%s',
		SSQL($ido, "int"));
		if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Seguimiento</p>';
		else $LOG.='<p>Error al Eliminar Seguimiento</p>';
	}else $LOG.='<p>Error al Eliminar Detalles</p>';
	echo '<script type="text/javascript">parent.Shadowbox.close();</script>';
}
//Eliminación de OBSTETRICO Detalle
if ((isset($action)) && ($action == 'DELOD')){
	$qrydel=sprintf('DELETE FROM db_obstetrico_detalle WHERE id=%s',
	SSQL($idod, "int"));
	if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Registro de Seguimiento</p>';
	$urlreturn.='?ido='.$ido;
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