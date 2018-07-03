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
	SSQL($_POST['idc'], "int"),
	SSQL($_POST['idp'], "int"),
	SSQL($_POST['fecha'], "date"),
	SSQL($_POST['fechap'], "date"),
	SSQL($_POST['diagnostico'], "text"),
	SSQL($_POST['obs'], "text"));
	if(@mysql_query($qryinst)){ $idt = @mysql_insert_id();
		$LOG.='<h4>Tratamiento Creado</h4> Numero. <strong>'.$idt.'</strong>';
	}else $LOG.='Error al Insertar';
	$urlreturn.='?idt='.$idt;
	}
	
	if($action=='UPD'){	
	$qryinst=sprintf('UPDATE db_tratamientos SET diagnostico=%s, fechap=%s, obs=%s WHERE tid=%s',
	SSQL($_POST['diagnostico'], "text"),
	SSQL($_POST['fechap'], "date"),
	SSQL($_POST['obs'], "text"),
	SSQL($_POST['idt'], "int"));
	if(@mysql_query($qryinst)){ $idt = $_POST['idt'];
		$LOG.='<p>Tratamiento Actualizado</p>';
	}else $LOG.='<p>Error al Actualizar</p>';
	$urlreturn.='?idt='.$idt;
	}
	
	if($action=='INSD'){	
	$qryins=sprintf('INSERT INTO db_tratamientos_detalle (tid, id_form, generico, comercial, presentacion, cantidad, descripcion)
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
	SSQL($_POST['trat_id'], "int"),
	SSQL($_POST['id_form'], "int"),
	SSQL($_POST['generico'], "text"),
	SSQL($_POST['comercial'], "text"),
	SSQL($_POST['presentacion'], "text"),
	SSQL($_POST['cantidad'], "int"),
	SSQL($_POST['descripcion'], "text"));
	if(@mysql_query($qryins)) $LOG.='<p>Medicamento Guardado</p>';
	else $LOG.='<p>Error al Guardar Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.$_POST['trat_id'];
	}
	
	if($action=='UPDD'){	
	$qryUpd=sprintf('UPDATE db_tratamientos_detalle SET generico=%s, comercial=%s, presentacion=%s, cantidad=%s, descripcion=%s WHERE id=%s',
	SSQL($_POST['generico'], "text"),
	SSQL($_POST['comercial'], "text"),
	SSQL($_POST['presentacion'], "text"),
	SSQL($_POST['cantidad'], "int"),
	SSQL($_POST['descripcion'], "text"),
	SSQL($idtd, "int"));
	if(@mysql_query($qryUpd)) $LOG.='<p>Medicamento Guardado</p>';
	else $LOG.='<p>Error al Guardar Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.$_POST['trat_id'];
	}
	
}


/************************************************************************************/
//FUNCIONES DE ELIMINACION GENERAL
/************************************************************************************/

//Eliminación de TRATAMIENTO (cab)
if ((isset($action)) && ($action == 'DELTF')){
	$accjs=TRUE;
	$qrydelD=sprintf('DELETE FROM db_tratamientos_detalle WHERE tid=%s',
	SSQL($idt, "int"));
	if(@mysql_query($qrydelD)){
		$LOG.='<p>Eliminados Medicamentos Tratamiento</p>';
		$qrydel=sprintf('DELETE FROM db_tratamientos WHERE tid=%s',
		SSQL($idt, "int"));
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
	SSQL($idtd, "int"));
	if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.$idt;
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