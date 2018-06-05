<?php
include('../../init.php');
echo "INICIO";
$val=$_GET['idsearch'];

$query_RS_lp = "SELECT * FROM tbl_inv_productos INNER JOIN tbl_inv_tipos ON tbl_inv_productos.tip_cod=tbl_inv_tipos.tip_cod INNER JOIN tbl_inv_marcas ON tbl_inv_productos.mar_id=tbl_inv_marcas.mar_id WHERE tbl_inv_productos.prod_stat='1'";
$RS_lp = mysql_query($query_RS_lp) or die(mysql_error());
$row_RS_lp = mysql_fetch_assoc($RS_lp);
$totalRows_RS_lp = mysql_num_rows($RS_lp);

/*

$q = strtolower($_GET["q"]);
if (!$q) return;
do{
//if($val=='find_nom')
	$find_cad=$row_RS_lp['mar_nom'].' '.$row_RS_lp['tip_nom'].' '.$row_RS_lp['prod_nom'];
//if($val=='find_id')
	//$find_cad='[ '.$row_RS_lp['prod_id'].' ] '.$row_RS_lp['mar_nom'].' '.$row_RS_lp['tip_nom'].' '.$row_RS_lp['prod_nom'];
//if($val=='find_cod')
	//$find_cad='[ '.$row_RS_lp['prod_cod'].' ] '.$row_RS_lp['mar_nom'].' '.$row_RS_lp['tip_nom'].' '.$row_RS_lp['prod_nom'];


$items [$find_cad]=$row_RS_lp['prod_id'];
} while ($row_RS_lp = mysql_fetch_assoc($RS_lp));

foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		echo "$key|$value\n";
		echo "OKA";
	}
}

mysql_free_result($RS_lp);
echo mysql_error();
*/
$cont=0;
do{
	$datos[$cont]=$row_RS_lp['prod_nom'];
	$cont++;
} while ($row_RS_lp = mysql_fetch_assoc($RS_lp));
echo json_encode($datos);
?>