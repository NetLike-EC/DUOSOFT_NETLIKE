<?php require_once('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$ids=vParam('ids',$_GET['ids'],$_POST['ids']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
if(($_POST['form'])&&($_POST['form']=='hispac')){
	$fecha=$_POST['hfecha'];
	$peso=$_POST['hpeso'];
	$pa=$_POST['hpa'];
	$talla=$_POST['htalla'];
	$imc=$_POST['himc'];
	if(($acc)&&($acc=='INS')){
		$qryIns = sprintf("INSERT INTO `db_signos`
		(`pac_cod`,`fecha`,`peso`,`pa`,`talla`,`imc`) VALUES (%s,%s,%s,%s,%s,%s)",
			SSQL($id, "int"),
			SSQL($sdate, "date"),
			SSQL($peso, "text"),
			SSQL($pa, "text"),
			SSQL($talla, "text"),
			SSQL($imc, "text")
		);
		if(@mysql_query($qryIns)){
			$LOG.='<p>Signos Registrados Correctamente</p>';
		}else{
			$LOG.='<p>Error al Registrar Signos</p>';
			$LOG.=mysql_error();
		}
	}
	if(($acc)&&($acc=='UPD')){
		$qryUpd= sprintf("UPDATE `db_signos` SET peso=%s, talla=%s, pa=%s, imc=%s WHERE id=%s",
			SSQL($peso, "text"),
			SSQL($talla, "text"),
			SSQL($pa, "text"),
			SSQL($imc, "text"),
			SSQL($ids, "int")
		);
		if(@mysql_query($qryUpd)){
			$LOG.='<p>Signos Actualizados</p>';
		}else{
			$LOG.='<p>Error al Actualizar Signos</p>';
			$LOG.=mysql_error();
		}
	}
}
if(($_GET['action'])&&($_GET['action']=='DEL')){
	$idh=$_GET['idh'];
	$id=$_GET['id'];
	$qryDEL='DELETE FROM `db_signos` WHERE id='.$idh;
	if(@mysql_query($qryDEL)) $LOG.="Eliminado Correctamente:: ID = ".$idh;
	else $LOG.='<b>No se pudo Eliminar</b>';
}
$_SESSION['LOG']['t']='Gestión de Signos Vitales';
$_SESSION['LOG']['m']=$LOG;
header("Location: ".$_SESSION['urlp'].'?id='.$id);
?>


