<?php include('../_config.php'); ?>
<?php require_once(RAIZ.'Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

	$val=$_GET['idsearch'];
?>
<?php
$query_RS_clientes_search = "SELECT * FROM tbl_items INNER JOIN tbl_items_cats ON tbl_items.cat_id=tbl_items_cats.cat_id WHERE tbl_items.item_status='1'";
$RS_clientes_search = mysql_query($query_RS_clientes_search) or die(mysql_error());
$row_RS_clientes_search = mysql_fetch_assoc($RS_clientes_search);
$totalRows_RS_clientes_search = mysql_num_rows($RS_clientes_search);
?>
<?php
$q = strtolower($_GET["q"]);
if (!$q) return;
do{
if($val=='find_nom')
	$find_cad=$row_RS_clientes_search['item_nom'].' ['.$row_RS_clientes_search['cat_nom'].']';
if($val=='find_cod')
	$find_cad='[ '.$row_RS_clientes_search['item_id'].' ] '.$row_RS_clientes_search['mar_nom'].' '.$row_RS_clientes_search['item_cod'].' - '.$row_RS_clientes_search['item_nom'];


$items [$find_cad]=$row_RS_clientes_search['item_id'];
} while ($row_RS_clientes_search = mysql_fetch_assoc($RS_clientes_search));

foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		echo "$key|$value\n";
	}
}
mysql_free_result($RS_clientes_search);
?>