<?php require_once('../../init.php');
$query_RS_clientes_search = "SELECT * FROM tbl_clientes";
$RS_clientes_search = mysql_query($query_RS_clientes_search, $conn) or die(mysql_error());
$row_RS_clientes_search = mysql_fetch_assoc($RS_clientes_search);
$totalRows_RS_clientes_search = mysql_num_rows($RS_clientes_search);

$q = strtolower($_GET["q"]);
if (!$q) return;
do{
	$find_cad=$row_RS_clientes_search['cli_nom'].' '.$row_RS_clientes_search['cli_ape'];
	$items [$find_cad]=$row_RS_clientes_search['cli_cod'];
} while ($row_RS_clientes_search = mysql_fetch_assoc($RS_clientes_search));
foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) echo "$key|$value\n";
}
?>