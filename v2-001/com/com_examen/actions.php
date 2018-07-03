<?php require_once('../../init.php');
$GoTo=$_SESSION['urlp'];
$id=vParam('id',$_GET['id'],$_POST['id']);
$ide=vParam('ide',$_GET['ide'],$_POST['ide']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
if(($acc)&&($acc=='DEL')){
	$detExa=detRow('db_examenes','id_exa',$ide);
	$idp=$detExa['pac_cod'];
	$qryDEL=SPRINTF('DELETE FROM db_examenes WHERE id_exa=%s',
	SSQL($ide,'int'));
	if(@mysql_query($qryDEL)){
		$LOG.="<p>Eliminado Correctamente</p>";
	}else{
		$LOG.='<p>No se pudo Eliminar</p>';
		$LOG.=mysql_error();
	}
	$GoTo='gest.php?id='.$idp;
}
$_SESSION['LOG']['m']=$LOG;
header("Location: ".$GoTo.'?id='.$id);
?>


