<?php include('../../init.php');
$query_RS_clientes_search = "SELECT * FROM tbl_inv_productos INNER JOIN tbl_inv_tipos ON tbl_inv_productos.tip_cod=tbl_inv_tipos.tip_cod INNER JOIN tbl_inv_marcas ON tbl_inv_productos.mar_id=tbl_inv_marcas.mar_id WHERE tbl_inv_productos.prod_stat='1'";
$RS_clientes_search = mysql_query($query_RS_clientes_search) or die(mysql_error());
$row_RS_clientes_search = mysql_fetch_assoc($RS_clientes_search);
$totalRows_RS_clientes_search = mysql_num_rows($RS_clientes_search);

$q = strtolower($_GET["q"]);
if (!$q) return;
do{
	$find_cad=$row_RS_clientes_search['mar_nom'].' '.$row_RS_clientes_search['tip_nom'].' '.$row_RS_clientes_search['prod_nom'];
$items [$find_cad]=$row_RS_clientes_search['prod_id'];
} while ($row_RS_clientes_search = mysql_fetch_assoc($RS_clientes_search));

foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		echo "$key|$value\n";
	}
}
mysql_free_result($RS_clientes_search);
?>