<?php include('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$accjs=FALSE;
$vP=TRUE;

$det=$_POST;
//recibimos las variables de fecha de inicio y el numero de sessiones
$fechai=$_POST['fechai'];
$min_terapia=$_POST['min'];

//calcular el tiempo que va a durar las terapias
$horaf=strtotime ('+'.$min_terapia.'mins',strtotime($horai));
$horaf=date('H:i:s',$horaf);

//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

if(($det['form'])&&($det['form']=='AGE')){
$goTo='form.php';
	if($acc==md5('INS')){
		$qry=sprintf('INSERT INTO db_terapias (id_pac, id_con, num_ses, id_usu, est) VALUES (%s,%s,%s,%s,%s)',
		SSQL($idp,'int'),
		SSQL($idc,'int'),
		SSQL($det['numSes'],'int'),
		SSQL($det['idu'],'int'),
		SSQL('1','int'));
		if(mysql_query($qry)){
			$id=mysql_insert_id();
			$LOG.='<h4>Terapia Creada Correctamente</h4>';
			
			$resTrat=insTratTer($id,$det);
			$vP=$resTrat['RES'];
			$LOG=$resTrat['LOG'];
			
		}else{
			$LOG.='<h4>Error al Crear Terapia</h4>'.mysql_error();
			$vP=FALSE;
		}
//grabamos las sesiones	
	$x=0;
	do {
		$numDia=date('w',strtotime($fechai));	
		if(($numDia==6)||($numDia==0)){
		}else{	
			$x++;				
			//grabamos las sesiones en la base de datos				
			if(!$est) $est=1;
			$id_aud=AUD(NULL,'Creación Reserva');
			$qryIns=sprintf('INSERT INTO db_fullcalendar_sesiones (fechai,fechaf,horai,horaf,id_ter,est)
			VALUES(%s,%s,%s,%s,%s,%s)',
			SSQL($fechai,'date'),
			SSQL($fechai,'date'),
			SSQL($horai,'text'),
			SSQL($horaf,'text'),					
			SSQL($id,'int'),			
			SSQL($est,'int'));
			if(mysql_query($qryIns)){
				$LOG.='<p>EVENTO CREADO</p>';
				$vP=TRUE;
				$ids=mysql_insert_id();
			}else{
				$LOG.='<p>ERROR AL CREAR EVENTO</p>';
				$LOG.=mysql_error();
			}									
		}
		$nuevafecha= date("Y-m-d", strtotime("$fechai +1 days"));
		$fechai = $nuevafecha; 
	} while ($x < $det['numSes']);
	}
	
//actualizar calendar de terapias	
	if($acc==md5('UPD')){		
	
	//consultamos si la terapia ya fue atendida y no puede borrar
	$qryCon=sprintf('SELECT * FROM db_terapias
	where id=%s and est=%s',
	SSQL($id,'int'),
	SSQL('2','int'));
	$RSt=mysql_query($qryCon);
	$row_RSt=mysql_fetch_assoc($RSt);
	$tr_RSt=mysql_num_rows($RSt);
	
	if($tr_RSt>0){
		$LOG.='<p>La Terapia ya esta atendida no puede borrar</p>';
		$accjs=TRUE;
	}else{	
		
		$qry=sprintf('UPDATE db_terapias SET id_pac=%s, id_con=%s, num_ses=%s, id_usu=%s, est=%s WHERE id=%s',
		SSQL($idp,'int'),
		SSQL($idc,'int'),
		SSQL($det['numSes'],'int'),
		SSQL($det['idu'],'int'),
		SSQL('1','int'),
		SSQL($id,'int'));
		if(mysql_query($qry)){
			$LOG.='<h4>Terapia Actualizada Correctamente</h4>';
			$resTrat=insTratTer($id,$det);
			$vP=$resTrat['RES'];
			$LOG=$resTrat['LOG'];
			
			////borramos las sesiones de la terapia
			$qryDelSe=sprintf('DELETE FROM db_fullcalendar_sesiones WHERE id_ter=%s',
					SSQL($id,'int'));				
					if(mysql_query($qryDelSe)){
						$LOG.='<p>Sesiones Anuladas Correctamente</p>';
						$vP=TRUE;																																				
					}else{
					$LOG.='<p>ERROR Anular Sesiones</p>';
					$LOG.=mysql_error();
					}
			
		}else{
			$LOG.='<h4>Error al Actualizar Terapia</h4>'.mysql_error();
			$vP=FALSE;
		}
		
//grabamos las sesiones	
	$x=0;
	do {
		$numDia=date('w',strtotime($fechai));	
		if(($numDia==6)||($numDia==0)){
		}else{	
			$x++;				
			//grabamos las sesiones en la base de datos				
			if(!$est) $est=1;
			$id_aud=AUD(NULL,'Creación Reserva');
			$qryIns=sprintf('INSERT INTO db_fullcalendar_sesiones (fechai,fechaf,horai,horaf,id_ter,est)
			VALUES(%s,%s,%s,%s,%s,%s)',
			SSQL($fechai,'date'),
			SSQL($fechai,'date'),
			SSQL($horai,'text'),
			SSQL($horaf,'text'),					
			SSQL($id,'int'),			
			SSQL($est,'int'));
			if(mysql_query($qryIns)){
				$LOG.='<p>EVENTO CREADO</p>';
				$vP=TRUE;
				$ids=mysql_insert_id();
			}else{
				$LOG.='<p>ERROR AL CREAR EVENTO</p>';
				$LOG.=mysql_error();
			}									
		}
		$nuevafecha= date("Y-m-d", strtotime("$fechai +1 days"));
		$fechai = $nuevafecha; 
	} while ($x < $det['numSes']);
	
		
		/*
		$detRes=detRow('db_fullcalendarterapias','id',$id);
		$id_aud=AUD($detRes['id_aud'],'Actualización Reserva');
		$qryUpd=sprintf('UPDATE db_fullcalendarterapias SET fechai=%s, fechaf=%s, horai=%s, horaf=%s, cli_id=%s, idculta=%s, id_trat=%s, id_terapista=%s ,est=%s, id_aud=%s, detalle=%s, observaciones=%s 
		WHERE id=%s',
		SSQL($fechai,'date'),
		SSQL($fechai,'date'),
		SSQL($horai,'text'),
		SSQL($horaf,'text'),
		SSQL($cli_id,'int'),
		SSQL($idculta,'int'),
		SSQL($id_tratamiento,'int'),
		SSQL($id_terapista,'int'),
		SSQL($est,'text'),
		SSQL($id_aud,'int'),
		SSQL($detalle,'text'),
		SSQL($observaciones,'text'),
		SSQL($id,'int'));
		if(mysql_query($qryUpd)){
			$LOG.='<p>EVENTO ACTUALIZADO</p>';
			$vP=TRUE;
		}else{
			$LOG.='<p>ERROR AL ACTUALIZAR EVENTO</p>';
			$LOG.=mysql_error();
		}
		$goTo.='?id='.$id;
		*/
	}
	
$goTo.='?id='.$id;
}//END form
}



///Elimiar registros
if($acc=='DELEF'){
	//consultamos si ya tiene alguna consulta atendida y no puede borrar
	$qryCon=sprintf('SELECT * FROM clinic_freimo.db_fullcalendar_sesiones
	where id_ter=%s and est=%s',
	SSQL($id,'int'),
	SSQL('2','int'));
	$RSt=mysql_query($qryCon);
	$row_RSt=mysql_fetch_assoc($RSt);
	$tr_RSt=mysql_num_rows($RSt);
	
	if($tr_RSt>0){
		$LOG.='<p>La Terapia ya tiene sesiones atendidas no puede borrar</p>';
		$accjs=TRUE;
	}else{						
	$accjs=TRUE;
	$qryDel=sprintf('DELETE FROM db_terapias_vs_tratamientos WHERE id_ter=%s',
	SSQL($id,'int'));
	if(mysql_query($qryDel)){
		$LOG.='<p>Terapia Anulada Correctamente</p>';
		$vP=TRUE;	
			$qryDelte=sprintf('DELETE FROM db_terapias WHERE id=%s',
			SSQL($id,'int'));			
			if(mysql_query($qryDelte)){
				$LOG.='<p>Terapia Anulada Correctamente</p>';
				$vP=TRUE;				
					$qryDelSe=sprintf('DELETE FROM db_fullcalendar_sesiones WHERE id_ter=%s',
					SSQL($id,'int'));				
					if(mysql_query($qryDelSe)){
						$LOG.='<p>Sesiones Anuladas Correctamente</p>';
						$vP=TRUE;																																				
					}else{
					$LOG.='<p>ERROR Anular Sesiones</p>';
					$LOG.=mysql_error();
			}								
			}else{
				$LOG.='<p>ERROR Anular Terapia</p>';
				$LOG.=mysql_error();
			}
		
	}else{
		$LOG.='<p>ERROR Anular Terapia</p>';
		$LOG.=mysql_error();
	}
	$goTo.='?id='.$id;
  }
}


if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Solicitud no Procesada';
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
    <?php unset($_SESSION['LOG']);
	unset($_SESSION['LOG']['m']);?>
    </body>
<?php }else{
	header(sprintf("Location: %s", $goTo));
}
?>

