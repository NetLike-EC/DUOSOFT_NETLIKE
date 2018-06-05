<?php require_once('../../../init.php');
/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
$rutaimagepac="../../../images/db/pac/";
$filename="pac".$_GET['idpac']."_".date('YmdHis').'.jpg';
$filefinal = $rutaimagepac.$filename;
$result = file_put_contents( $filefinal, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}
$query_insert_temp='INSERT INTO tbl_images_clientes (pac_cod, img_path, img_status) VALUES ("'.$_GET['idpac'].'" ,"'.$filename.'", "'."1".'")';
		mysql_query($query_insert_temp)or die(mysql_error());
$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/'.$filefinal;
print "$url\n";
?>