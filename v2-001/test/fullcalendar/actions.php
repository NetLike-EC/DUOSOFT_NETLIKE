<?php include('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$goTo=$_SESSION['urlp'];
//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

if(($form)&&($form=='AGE')){
	if($acc==md5('INS')){
		$qryIns=sprintf('INSERT INTO db_fullcalendar (fechai,fechaf,horai,horaf,pac_cod,typ_cod,obs)
		VALUES(%s,%s,%s,%s,%s,%s,%s)',
		SSQL($fechai,'date'),
		SSQL($fechaf,'date'),
		SSQL($horai,'text'),
		SSQL($horaf,'text'),
		SSQL($pac_cod,'int'),
		SSQL($typ_cod,'int'),
		SSQL($obs,'text'));
		if(mysql_query($qryIns)){
			$LOG.='<p>EVENTO CREADO</p>';
			$vP=TRUE;
			$id=mysql_insert_id();
		}else{
			$LOG.='<p>ERROR AL CREAR EVENTO</p>';
			$LOG.=mysql_error();
		}
		$goTo.='?id='.$id;
	}
	if($acc==md5('UPD')){
		$qryUpd=sprintf('UPDATE db_fullcalendar SET fechai=%s, fechaf=%s, horai=%s, horaf=%s, pac_cod=%s, typ_cod=%s, obs=%s 
		WHERE id=%s',
		SSQL($fechai,'date'),
		SSQL($fechaf,'date'),
		SSQL($horai,'text'),
		SSQL($horaf,'text'),
		SSQL($pac_cod,'int'),
		SSQL($typ_cod,'int'),
		SSQL($obs,'text'),
		SSQL($id,'int'));
		if(mysql_query($qryUpd)){
			$LOG.='<p>EVENTO ACTUALIZADO</p>';
			$vP=TRUE;
		}else{
			$LOG.='<p>ERROR AL ACTUALIZAR EVENTO</p>';
			$LOG.=mysql_error();
		}
		$goTo.='?id='.$id;
	}
}
/*
if($acc==md5('DELE')){
	$qryDel=sprintf('DELETE FROM db_fullcalendar ');
}
*/
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
		$("#alert").slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
		parent.location.reload();
	</script>
    </body>
<?php }else{
	header(sprintf("Location: %s", $goTo));
}

?>