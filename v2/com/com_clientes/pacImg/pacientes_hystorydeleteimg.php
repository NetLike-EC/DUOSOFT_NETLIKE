<?php require_once('../../init.php');
$id=$_REQUEST['id'];
$qry=sprintf('DELETE FROM db_pacientes_media WHERE id=%s',
SSQL($id,int));
if(@mysql_query($qry)) $LOG.="Eliminado Correctamente :: ID = ".$codimage;
?>