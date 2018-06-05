<?php require_once('../../init.php');
$id=$_REQUEST['id'];
$qry=sprintf('DELETE FROM tbl_pacientes_media WHERE id=%s',
SSQL($idi,int));
if(@mysql_query($qry)) $LOG.="Eliminado Correctamente :: ID = ".$codimage;
?>