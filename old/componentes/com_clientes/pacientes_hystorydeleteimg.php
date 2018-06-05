<?php require_once('../../Connections/conn.php'); ?>
<?php $codimage=$_POST['codimg'];
$qry='DELETE FROM tbl_images_clientes WHERE ima_pac_cod="'.$codimage.'"';
if(@mysql_query($qry)) $LOG.="Eliminado Correctamente :: ID = ".$codimage;
?>
