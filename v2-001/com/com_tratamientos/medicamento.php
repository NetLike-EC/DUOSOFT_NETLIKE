<?php require_once('../../init.php');
$query = sprintf('SELECT * FROM db_medicamentos WHERE id_form=%s',
SSQL($_REQUEST['term'],'text'));
$RSjson = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($RSjson);
$datos[] = array(
	'id' => $row['id_form'],
	'generico' => $row['generico'],
	'comercial' => $row['comercial'],
	'presentacion' => $row['presentacion'],
	'cantidad' => $row['cantidad'],
	'descripcion' => $row['descripcion'],
);
echo json_encode($datos);
?>