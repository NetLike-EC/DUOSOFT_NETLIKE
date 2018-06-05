<?php include('../../init.php');

$id=vParam('id_ses',$_GET['id_ses'],$_POST['id_ses']);
$estado=vParam('estado',$_GET['estado'],$_POST['estado']);
$obs=vParam('obs',$_GET['obs'],$_POST['obs']);
$id_tera=vParam('id_tera',$_GET['id_tera'],$_POST['id_tera']);
$id_user = $_SESSION['dU']['usr_id'];
$accjs=FALSE;
$vP=TRUE;

//ver el numero de sesiones que tiene la terapia
$detP=detRow('db_terapias','id',$id_tera);
$num_sesiones=$detP['num_ses'];

$qryConLst=sprintf('SELECT * FROM clinic_freimo.db_fullcalendar_sesiones
where id_ter=%s AND est =2',
SSQL($id_tera,'int'));
$RSt=mysql_query($qryConLst);
$row_RSt=mysql_fetch_assoc($RSt);
$tr_RSt=mysql_num_rows($RSt)+1;

//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
	
//actualizar calendar de sesiones	
		
		if(($estado==NULL)||($id==NULL)){
			
		}else{
		$qry=sprintf('UPDATE db_fullcalendar_sesiones SET id_usu=%s, obs=%s, est=%s WHERE id=%s',
			
		SSQL($id_user,'int'),
		SSQL($obs,'text'),
		SSQL($estado,'int'),
		SSQL($id,'int'));
		if(mysql_query($qry)){
			$LOG.='<h4>Sesión Actualizada Correctamente</h4>';
			if($tr_RSt==$num_sesiones){
				$qry1=sprintf('UPDATE db_terapias SET est=%s WHERE id=%s',						
				SSQL('2','int'),
				SSQL($id_tera,'int'));
					if(mysql_query($qry1)){					
					}else{
					$LOG.='<h4>Error al Actualizar Sesión</h4>'.mysql_error();
					$vP=FALSE;
					}
			}
		}else{
		$LOG.='<h4>Error al Actualizar Sesión</h4>'.mysql_error();
		$vP=FALSE;
		}
	
//$goTo.='?id='.$id;

}

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
	//header(sprintf("Location: %s", $goTo));
}
?>

