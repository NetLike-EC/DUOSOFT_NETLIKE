<?php include('../../init.php');
loginN();

$term = trim(strip_tags($_GET['term']));
$qstring = sprintf("SELECT CONCAT(tbl_personas.per_nom,' ',tbl_personas.per_ape) AS nom, tbl_personas.per_doc, tbl_clientes.cli_stat FROM tbl_clientes INNER JOIN tbl_personas ON tbl_clientes.per_id=tbl_personas.per_id WHERE tbl_personas.per_nom LIKE '%".$term."%' OR tbl_personas.per_doc LIKE '%".$term."%' AND tbl_clientes.cli_stat=%s",
GetSQLValueString('1','text'));
$result = mysql_query($qstring);

while ($row = mysql_fetch_array($result,MYSQL_ASSOC)){
	$datos=[{"value":"Some Name","id":1},{"value":"Some Othername","id":2}];
	$row['value']=htmlentities(stripslashes($row['value']));
	$row['id']=(int)$row['id'];
}
echo json_encode($datos[]);
?>