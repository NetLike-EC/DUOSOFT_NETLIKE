<?php require_once('../../Connections/conn.php'); ?>
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

$colname_RS_cli_detalle = "-1";
if (isset($_GET['cli_sel_list'])) {
  $colname_RS_cli_detalle = $_GET['cli_sel_list'];
}
mysql_select_db($database, $conn);
$query_RS_cli_detalle = sprintf("SELECT * FROM tbl_clientes WHERE cli_cod = %s", GetSQLValueString($colname_RS_cli_detalle, "int"));
$RS_cli_detalle = mysql_query($query_RS_cli_detalle, $conn) or die(mysql_error());
$row_RS_cli_detalle = mysql_fetch_assoc($RS_cli_detalle);
$totalRows_RS_cli_detalle = mysql_num_rows($RS_cli_detalle);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>
<?php include('../../system/base/__libs.php'); ?>
<?php include('../../system/base/__styles.php'); ?>
<body bgcolor="#FFFFFF">
<table align="center">
	<tr>
    	<td>OCn FOto<?php echo $row_RS_cli_detalle['cli_cod']; ?></td>
  </tr>
  <tr>
  	<td align="center"><a href="<?php echo $row_RS_cli_detalle['../../pac_image']; ?>" rel="shadowbox"><img src="<?php echo $row_RS_cli_detalle['../../pac_image']; ?>" width="110" height="110"/></a></td>
  </tr>
</table>
<table class="bord_gray_4cornes" align="center">
	<tr>
    <td rowspan="4">-</td>
   	  <td>Nombre:</td>
        <td><?php echo $row_RS_cli_detalle['cli_nom']; ?> <?php echo $row_RS_cli_detalle['cli_ape']; ?></td>
  </tr>
    <tr>
   	  <td>Dirección:</td>
        <td><?php echo $row_RS_cli_detalle['cli_dir']; ?></td>
  </tr>
    <tr>
   	  <td>Teléfono:</td>
        <td><?php echo $row_RS_cli_detalle['pac_tel1']; ?> :: <?php echo $row_RS_cli_detalle['pac_tel2']; ?></td>
  </tr>
    <tr>
   	  <td>Trabajo:</td>
        <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RS_cli_detalle);
?>