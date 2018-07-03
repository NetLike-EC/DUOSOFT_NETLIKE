<?php require_once('../../init.php');
$idPac=vParam('idp',$_GET['idp'],$_POST['idp'],FALSE);
$acc=vParam('acc',$_GET['acc'],$_POST['acc'],FALSE);
$id=vParam('id',$_GET['id'],$_POST['id'],FALSE);
$resFec=$_POST['formFec'];// Obtiene Fecha tipo: dd/mm/yyyy
$resHor=$_POST['formHor'];// Obtiene Hora tipo  00:00
$resFin=$resFec.' '.$resHor; //Hora y Fecha de Reserva

if($acc=='INS'){
	$id_aud=AUD();
	// GUARDA LA RESERVA
	$qryInsRes=sprintf("INSERT INTO db_consultas_reserva (pac_cod, fecha, id_aud, estado) 
	VALUES (%s,%s,%s,%s)",
	SSQL($idPac,'int'),
	SSQL($resFin,'text'),
	SSQL($id_aud,'text'),
	SSQL('1','int'));
	$LOG.=$qryInsRes;
	if(@mysql_query($qryInsRes)){
		$LOG.= '<h4>Reserva Generada Correctamente</h4>';
	}else{
		$LOG.= '<h4>No se pugo Guardar la Reserva</h4>';
		$LOG.=mysql_error();
	}	
}
if($acc=='anu'){
	$qryUpd=sprintf('UPDATE db_consultas_reserva SET estado=%s WHERE id=%s',
	SSQL('0','text'),
	SSQL($id,'int'));
	if(@mysql_query($qryUpd)){
		$LOG.= '<h4>Reserva Eliminar Correctamente</h4>';
	}else{
		$LOG.= '<h4>Error Eliminar Reserva</h4>';
		$LOG.=mysql_error();
	}	
}

$insertGoTo = 'reserva_form.php?idp='.$idp;
$_SESSION['LOG']['m']=$LOG;
header(sprintf("Location: %s", $insertGoTo));
?>