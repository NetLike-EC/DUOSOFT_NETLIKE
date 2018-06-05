<?php include('../../init.php');

$query_RS_lp = 'SELECT *, CONCAT(tbl_personas.per_nom," ",tbl_personas.per_ape) as cliNom FROM tbl_clientes INNER JOIN tbl_personas ON tbl_clientes.per_id=tbl_personas.per_id WHERE CONCAT(tbl_personas.per_nom," ",tbl_personas.per_ape) LIKE "%'.$_REQUEST['term'].'%"';
$RS_lp = mysql_query($query_RS_lp) or die(mysql_error());

while($row_RS_lp = mysql_fetch_array($RS_lp)){
	$datos[] = array(
					'code' => $row_RS_lp['cli_cod'],
					'value' => $row_RS_lp['cliNom'],
					'label' => $row_RS_lp['cliNom'],
					'ruc' => $row_RS_lp['per_doc'],
					'dir' => $row_RS_lp['per_dir'],
					'tel' => $row_RS_lp['per_tel']
	);
}
echo json_encode($datos);
?>