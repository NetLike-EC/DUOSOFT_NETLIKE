<?php include('../../init.php');
	$val=$_GET['idsearch'];
$query_RS_clientes_search = "SELECT * FROM tbl_productos INNER JOIN tbl_prod_tipos ON tbl_productos.tip_cod=tbl_prod_tipos.tip_cod INNER JOIN tbl_marcas ON tbl_productos.mar_id=tbl_marcas.mar_id WHERE tbl_productos.prod_stat='1'";
$RS_clientes_search = mysql_query($query_RS_clientes_search) or die(mysql_error());
$row_RS_clientes_search = mysql_fetch_assoc($RS_clientes_search);
$totalRows_RS_clientes_search = mysql_num_rows($RS_clientes_search);

$q = strtolower($_GET["q"]);
if (!$q) return;
do{
if($val=='find_nom')
	$find_cad=$row_RS_clientes_search['mar_nom'].' '.$row_RS_clientes_search['tip_nom'].' '.$row_RS_clientes_search['prod_nom'];
if($val=='find_cod')
	$find_cad='[ '.$row_RS_clientes_search['prod_id'].' ] '.$row_RS_clientes_search['mar_nom'].' '.$row_RS_clientes_search['tip_nom'].' '.$row_RS_clientes_search['prod_nom'];


$items [$find_cad]=$row_RS_clientes_search['prod_id'];
} while ($row_RS_clientes_search = mysql_fetch_assoc($RS_clientes_search));

foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		echo "$key|$value\n";
	}
}
mysql_free_result($RS_clientes_search);
?>