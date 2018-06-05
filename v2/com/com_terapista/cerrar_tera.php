<?php include('../../init.php');

$id_tera=vParam('id_tera',$_GET['id_tera'],$_POST['id_tera']);
$id_user = $_SESSION['dU']['usr_id'];

$accjs=FALSE;
$vP=TRUE;

//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
	
//actualizar la terapia a atendidas
		
		$qry=sprintf('UPDATE db_fullcalendar_sesiones SET id_usu=%s, obs=%s, est=%s WHERE id_ter=%s AND est=1',				
		SSQL($id_user,'int'),
		SSQL('Sesiones cerradas por que ya no se presenta el paciente','text'),
		SSQL('2','int'),
		SSQL($id_tera,'int'));
		if(mysql_query($qry)){
			$LOG.='<h4>Sesión Actualizada Correctamente</h4>';			
				$qry1=sprintf('UPDATE db_terapias SET est=%s WHERE id=%s',						
				SSQL('2','int'),
				SSQL($id_tera,'int'));
					if(mysql_query($qry1)){					
					}else{
					$LOG.='<h4>Error al Actualizar terapia</h4>'.mysql_error();
					$vP=FALSE;
					}			
		}else{
		$LOG.='<h4>Error al Actualizar Sesión</h4>'.mysql_error();
		$vP=FALSE;
		}
	
$goTo.='?id='.$id;

if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
	$accjs=TRUE;
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Solicitud no Procesada';
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}

mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;

if($accjs==TRUE){
	include(RAIZf.'head.php'); ?>
	<body class="cero">
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	parent.location.reload();
	</script>
    <?php unset($_SESSION['LOG']);
	unset($_SESSION['LOG']['m']);?>
    </body>
<?php }else{
	header(sprintf("Location: %s", $goTo));
}
?>

