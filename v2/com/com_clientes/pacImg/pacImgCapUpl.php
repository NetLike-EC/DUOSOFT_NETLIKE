<?php require('../../../init.php');
$id=$_REQUEST['id'];
/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
$rutaimagepac="../../../data/db/pac/";
$filename="pac".$id."_".date('YmdHis').'.jpg';
$filefinal = $rutaimagepac.$filename;
$result = file_put_contents( $filefinal, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}
//INSERT MEDIA
$qry=sprintf('INSERT INTO db_media (file, des, estado) VALUES (%s, "PACIENTE IMAGEN", 1)',
SSQL($filename,'text'));
mysql_query($qry)or die(mysql_error());
$idm=mysql_insert_id();
//INSERT PACIENTE MEDIA
$qry=sprintf('INSERT INTO db_pacientes_media (cod_pac, id_med) VALUES (%s,%s)',
SSQL($id,'int'),
SSQL($idm,'int'));
mysql_query($qry)or die(mysql_error());
//
$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/'.$filefinal;
print "$url\n";
?>