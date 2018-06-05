<?php require_once('Connections/conn_servisoft.php'); ?>
<?php 
session_start(); 
if ($_GET['id_pac']!=null)
	$_SESSION['id_pac']=$_GET['id_pac'];
?>
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

$id_emp_sel_RS_emp_sel = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $id_emp_sel_RS_emp_sel = $_SESSION['MM_UserId'];
}
mysql_select_db($database);
$query_RS_emp_sel = sprintf("SELECT * FROM tbl_empleados WHERE tbl_empleados.emp_cod=%s", GetSQLValueString($id_emp_sel_RS_emp_sel, "int"));
$RS_emp_sel = mysql_query($query_RS_emp_sel, $conn_servisoft) or die(mysql_error());
$row_RS_emp_sel = mysql_fetch_assoc($RS_emp_sel);
$totalRows_RS_emp_sel = mysql_num_rows($RS_emp_sel);

$id_fac_num_RS_fac_cab = "-1";
if (isset($_GET['fac_num'])) {
  $id_fac_num_RS_fac_cab = $_GET['fac_num'];
}
mysql_select_db($database);
$query_RS_fac_cab = sprintf("SELECT * FROM tbl_factura_cab WHERE tbl_factura_cab.fac_num=%s", GetSQLValueString($id_fac_num_RS_fac_cab, "int"));
$RS_fac_cab = mysql_query($query_RS_fac_cab, $conn_servisoft) or die(mysql_error());
$row_RS_fac_cab = mysql_fetch_assoc($RS_fac_cab);
$totalRows_RS_fac_cab = mysql_num_rows($RS_fac_cab);

$id_fac_num_RS_fac_det = "-1";
if (isset($_GET['fac_num'])) {
  $id_fac_num_RS_fac_det = $_GET['fac_num'];
}
mysql_select_db($database);
$query_RS_fac_det = sprintf("SELECT * FROM tbl_factura_det INNER JOIN tbl_inv_productos  ON tbl_factura_det.prod_cod=tbl_inv_productos.prod_id INNER JOIN tbl_inv_tipos ON tbl_inv_tipos.tip_cod=tbl_inv_productos.tip_cod INNER JOIN tbl_inv_marcas ON tbl_inv_marcas.mar_id=tbl_inv_productos.mar_id WHERE tbl_factura_det.fac_num=%s", GetSQLValueString($id_fac_num_RS_fac_det, "int"));
$RS_fac_det = mysql_query($query_RS_fac_det, $conn_servisoft) or die(mysql_error());
$row_RS_fac_det = mysql_fetch_assoc($RS_fac_det);
$totalRows_RS_fac_det = mysql_num_rows($RS_fac_det);

$id_cli_sel_RS_cli_sel = "-1";
if (isset($_SESSION['id_pac'])) {
  $id_cli_sel_RS_cli_sel = $_SESSION['id_pac'];
}
mysql_select_db($database);
$query_RS_cli_sel = sprintf("SELECT * FROM tbl_clientes WHERE tbl_clientes.cli_cod=%s", GetSQLValueString($id_cli_sel_RS_cli_sel, "int"));
$RS_cli_sel = mysql_query($query_RS_cli_sel, $conn_servisoft) or die(mysql_error());
$row_RS_cli_sel = mysql_fetch_assoc($RS_cli_sel);
$totalRows_RS_cli_sel = mysql_num_rows($RS_cli_sel);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Factura #: <?php echo $row_RS_fac_cab['fac_num']; ?> [ <?php echo $row_RS_fac_cab['fac_fec']; ?> ] </title>
<?php include('_styles.php'); ?>
</head>

<body>

<div id="head_sec"><a href="#" class="link">FACTURA # <?php echo $row_RS_fac_cab['fac_num']; ?></a></div>
<div id="cont_head" style="background-color:#FFFFFF;">
<table align="center" class="bord_gray_4cornes">
	<tr>
    	<td class="txt_name">Cliente: </td>
        <td class="txt_values"><?php echo htmlentities($row_RS_cli_sel['cli_nom']); ?> <?php echo htmlentities($row_RS_cli_sel['cli_ape']); ?></td>
    </tr>
	<tr>
    	<td class="txt_name">RUC: </td>
        <td class="txt_values"><?php echo $row_RS_cli_sel['cli_ruc']; ?></td>
    </tr>
    <tr>
   	  <td class="txt_name">Fecha: </td>
        <td class="txt_values-sec"><?php echo $row_RS_fac_cab['fac_fec']; ?></td>
    </tr>
    <tr>
    	<td class="txt_name">Responsable:</td>
        <td class="txt_values-sec"><?php echo $row_RS_emp_sel['emp_nom']; ?> <?php echo $row_RS_emp_sel['emp_ape']; ?></td>
    </tr>
</table>
<table align="center">
	<tr>
    	<td>
        
        <table align="center" class="tablesorter">
          <thead>
			<tr>
              <th>Factura</th>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Valor</th>
                <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php do { ?>
            <tr>
                <td><?php echo $row_RS_fac_det['fac_num']; ?></td>
              <td><?php echo $row_RS_fac_det['prod_id']; ?></td>
              <td><?php echo $row_RS_fac_det['mar_nom']; ?> <?php echo $row_RS_fac_det['tip_nom']; ?> <?php echo $row_RS_fac_det['prod_nom']; ?></td>
              <td><?php echo $row_RS_fac_det['fac_prod_can']; ?></td>
              <td><?php echo $row_RS_fac_det['fac_prod_pre']; ?></td>
              <td><?php echo $row_RS_fac_det['fac_prod_can']*$row_RS_fac_det['fac_prod_pre']; ?></td>
                <?php $subtotal+=$row_RS_fac_det['fac_prod_can']*$row_RS_fac_det['fac_prod_pre']; ?>
                </tr>
              <?php } while ($row_RS_fac_det = mysql_fetch_assoc($RS_fac_det)); ?>
          </tbody>
        </table>
        
        </td>
    </tr>
    <tr>
    	<td><!-- PIE FACTURA -->
        	<table width="100%">
            	<tr>
                	<td width="80%"><a href="factura_print.php?fac_num=<?php echo $row_RS_fac_cab['fac_num']; ?>"><img src="img_est/img_taskbar/print_16.png" width="16" height="16" /></a></td>
                  <td width="20%">
                    
                    <table class="bord_gray_2cornes" >
                      <tr>
                        <td>Subtotal:</td>
                                <td><?php echo $subtotal; ?></td>
                            </tr>
                      <tr>
                        <td>I.V.A:</td>
                                <td><?php echo $subtotal*$_SESSION['conf']['taxes']['iva_si']; ?></td>
                            </tr>
                      <tr>
                        <td>TOTAL:</td>
                                <td><?php echo $subtotal+($subtotal*$_SESSION['conf']['taxes']['iva_si']); ?></td>
                            </tr>
                    </table>
                  </td>
                </tr>
            </table>
      </td>
    </tr>
</table>
<?php //include('_fra_print.php'); ?>
<table class="bord_gray_4cornes" align="center">
    <tr>
    	<td class="log"><?php echo $LOG; ?></td>
    </tr>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($RS_emp_sel);

mysql_free_result($RS_fac_cab);

mysql_free_result($RS_fac_det);

mysql_free_result($RS_cli_sel);
?>
