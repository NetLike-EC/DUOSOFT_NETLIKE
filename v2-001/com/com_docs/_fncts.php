<?php include('../../init.php');
$action=vParam('action',$_GET['action'],$_POST['action']);
$id=vParam('id',$_GET['id'],$_POST['id']);
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$idd=vParam('idd',$_GET['idd'],$_POST['idd']);
$detdoc=fnc_datadoc($idd);
if($idd) {$idp=$detdoc['pac_cod']; $idc=$detdoc['con_num'];}
$urlreturn=$_SESSION['urlp'];

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion



if ((isset($_POST['form'])) && ($_POST['form'] == 'fdocs')){
	if($action=='INS'){	
	$qryinsd=sprintf('INSERT INTO db_documentos (pac_cod,con_num,nombre,contenido,fecha)
	VALUES (%s,%s,%s,%s,%s)',
	SSQL($_POST['idp'], "int"),
	SSQL($_POST['idc'], "int"),
	SSQL($_POST['nombre'], "text"),
	SSQL($_POST['contenido'], "text"),
	SSQL($_POST['fecha'], "date"));
	if(@mysql_query($qryinsd)){ $idd = @mysql_insert_id();
		$LOG.='<h4>Documento Creado</h4> Numero. <strong>'.$idd.'</strong>';
	}else $LOG.='Error al Insertar';
	$urlreturn.='?idd='.$idd;
	}
	if($action=='UPD'){	
	$qryupd=sprintf('UPDATE db_documentos SET fecha=%s,nombre=%s,contenido=%s WHERE id_doc=%s',
	SSQL($_POST['fecha'], "date"),
	SSQL($_POST['nombre'], "text"),
	SSQL($_POST['contenido'], "text"),
	SSQL($idd, "int"));
	if(@mysql_query($qryupd)) $LOG.='<h4>Documento Actualizado</h4>';
	else $LOG.='<h4>Error al Actualizar</h4>';
	$urlreturn.='?idd='.$idd;
	}
	
	//Multiple Cats Review
		$valSel=$_POST['valSel'];
		$contMultVals=count($valSel);
		//Eliminar MultiCats anteriores
		$qryDelMC=sprintf('DELETE FROM db_documentos_diag_vs WHERE id_doc=%s',
			SSQL($idd, "int"));
		@mysql_query($qryDelMC)or($LOG.=mysql_error());
		//Inserta las MultiCats seleccionadas
		for($i=0;$i<$contMultVals;$i++){
			$qryinsMC=sprintf('INSERT INTO db_documentos_diag_vs (id_doc,id_diag) VALUES (%s,%s)',
				SSQL($idd, "int"),
				SSQL($valSel[$i], "int"));
			@mysql_query($qryinsMC)or($LOG.=mysql_error());
		}

}
if ((isset($action)) && ($action == 'DELDF')){
	$qrydel=sprintf('DELETE FROM db_documentos WHERE id_doc=%s',
	SSQL($idd, "int"));
	if(@mysql_query($qrydel)){
		$LOG.='<h4>Eliminado Documento</h4>';
	}else{
		$LOG.='<h4>Error al Eliminar</h4>';
		$LOG.=mysql_error();
	}
	$accjs=TRUE;
}
//VERIFY COMMIT
$LOG.=mysql_error();
if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOGt='Operación Ejecutada Exitosamente';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;


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