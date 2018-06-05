<?php require_once('Connections/conn_servisoft.php'); ?>
<?php session_start(); ?>
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

$fac_num_sel_RS_emp_sel = "-1";
if (isset($_GET['fac_num'])) {
  $fac_num_sel_RS_emp_sel = $_GET['fac_num'];
}
mysql_select_db($database_conn_servisoft, $conn_servisoft);
$query_RS_emp_sel = sprintf("SELECT tbl_empleados.emp_nom, tbl_empleados.emp_ape FROM tbl_empleados INNER JOIN tbl_factura_cab ON tbl_empleados.emp_cod=tbl_factura_cab.emp_cod WHERE tbl_factura_cab.fac_num=%s", GetSQLValueString($fac_num_sel_RS_emp_sel, "int"));
$RS_emp_sel = mysql_query($query_RS_emp_sel, $conn_servisoft) or die(mysql_error());
$row_RS_emp_sel = mysql_fetch_assoc($RS_emp_sel);
$totalRows_RS_emp_sel = mysql_num_rows($RS_emp_sel);

$id_fac_num_RS_fac_cab = "-1";
if (isset($_GET['fac_num'])) {
  $id_fac_num_RS_fac_cab = $_GET['fac_num'];
}
mysql_select_db($database_conn_servisoft, $conn_servisoft);
$query_RS_fac_cab = sprintf("SELECT tbl_factura_cab.fac_num, tbl_factura_cab.fac_fec FROM tbl_factura_cab WHERE tbl_factura_cab.fac_num=%s", GetSQLValueString($id_fac_num_RS_fac_cab, "int"));
$RS_fac_cab = mysql_query($query_RS_fac_cab, $conn_servisoft) or die(mysql_error());
$row_RS_fac_cab = mysql_fetch_assoc($RS_fac_cab);
$totalRows_RS_fac_cab = mysql_num_rows($RS_fac_cab);

$id_fac_num_RS_fac_det = "-1";
if (isset($_GET['fac_num'])) {
  $id_fac_num_RS_fac_det = $_GET['fac_num'];
}
mysql_select_db($database_conn_servisoft, $conn_servisoft);
$query_RS_fac_det = sprintf("SELECT * FROM tbl_factura_det INNER JOIN tbl_inv_productos  ON tbl_factura_det.prod_cod=tbl_inv_productos.prod_id INNER JOIN tbl_inv_tipos ON tbl_inv_tipos.tip_cod=tbl_inv_productos.tip_cod INNER JOIN tbl_inv_marcas ON tbl_inv_marcas.mar_id=tbl_inv_productos.mar_id WHERE tbl_factura_det.fac_num=%s", GetSQLValueString($id_fac_num_RS_fac_det, "int"));
$RS_fac_det = mysql_query($query_RS_fac_det, $conn_servisoft) or die(mysql_error());
$row_RS_fac_det = mysql_fetch_assoc($RS_fac_det);
$totalRows_RS_fac_det = mysql_num_rows($RS_fac_det);

$fac_num_sel_RS_cli_sel = "-1";
if (isset($_GET['fac_num'])) {
  $fac_num_sel_RS_cli_sel = $_GET['fac_num'];
}
mysql_select_db($database_conn_servisoft, $conn_servisoft);
$query_RS_cli_sel = sprintf("SELECT tbl_clientes.cli_ruc, tbl_clientes.cli_nom, tbl_clientes.cli_ape, tbl_clientes.cli_dir, tbl_clientes.cli_tel FROM tbl_clientes INNER JOIN tbl_factura_cab ON tbl_clientes.cli_cod=tbl_factura_cab.cli_cod WHERE tbl_factura_cab.fac_num=%s", GetSQLValueString($fac_num_sel_RS_cli_sel, "int"));
$RS_cli_sel = mysql_query($query_RS_cli_sel, $conn_servisoft) or die(mysql_error());
$row_RS_cli_sel = mysql_fetch_assoc($RS_cli_sel);
$totalRows_RS_cli_sel = mysql_num_rows($RS_cli_sel);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Factura #: <?php echo $row_RS_fac_cab['fac_num']; ?> [ <?php echo $row_RS_fac_cab['fac_fec']; ?> ] </title>
<link href="styles/style_print.css" rel="stylesheet" type="text/css" />
<link href="styles/tab-sort_blue/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="cont_head" style="background-color:#FFFFFF;">
<table>
	<tr>
    	<td colspan="2" height="208" valign="top">
		<a href="#" onclick="window.print();return false;"><img src="img_est/img_taskbar/print_16.png" alt="" /></a>
		<?php echo $row_RS_fac_cab['fac_num']; ?> 
		</td>
    </tr>
    <tr>
    	<td width="550">
        <table width="100%">
  <tr>
                <td width="110">&nbsp;</td>
                <td class="txt_values"><?php echo $row_RS_cli_sel['cli_ruc']; ?></td>
          </tr>
            <tr>
                <td class="txt_name">&nbsp;</td>
                <td class="txt_values"><?php echo htmlentities($row_RS_cli_sel['cli_nom']); ?> <?php echo htmlentities($row_RS_cli_sel['cli_ape']); ?></td>
            </tr>
            <tr>
              <td class="txt_name">&nbsp;</td>
                <td class="txt_values-sec"><?php echo $row_RS_cli_sel['cli_dir']; ?></td>
          </tr>
        </table>
      </td>
        <td width="300">
			<table width="100%">
  <tr>
					<td width="100">&nbsp;</td>
                	<td class="txt_values-sec"><?php echo substr($row_RS_fac_cab['fac_fec'],0,10); ?></td>
           	  </tr>
                <tr>
              		<td class="txt_name">&nbsp;</td>
                	<td class="txt_values-sec"><?php echo $row_RS_cli_sel['cli_tel']; ?></td>
				</tr>
                <tr>
                    <td class="txt_name">&nbsp;</td>
                    <td class="txt_values-sec"><?php echo $row_RS_emp_sel['emp_nom']; ?> <?php echo $row_RS_emp_sel['emp_ape']; ?></td>
            	</tr>
            </table>
      </td>
    </tr>
</table>
<table>
	<tr>
    	<td height="325" valign="top">
        <table align="center" class="tablesorter">
          <thead>
			<tr>
                <th height="12"><!-- ID --></th>
                <th><!--Producto--></th>
                <th><!--Valor--></th>
                <th><!--Cantidad --></th>
                <th><!--Descuento--></th>
                <th><!--Subtotal --></th>
            </tr>
          </thead>
          <tbody>
            <?php do { ?>
            <tr>
              <td width="44" align="center"><?php echo $row_RS_fac_det['prod_id']; ?></td>
              <td width="406">&nbsp;&nbsp;<?php echo $row_RS_fac_det['mar_nom']; ?> <?php echo $row_RS_fac_det['tip_nom']; ?> <?php echo $row_RS_fac_det['prod_nom']; ?></td>
              <td width="80" align="center"><?php echo number_format($row_RS_fac_det['fac_prod_pre'],2,".",""); ?></td>
              <td width="74" align="center"><?php echo number_format($row_RS_fac_det['fac_prod_can'],0,"",""); ?></td>
              <td width="75" align="center"><!-- &nbsp; --></td>
              <td width="90" align="center"><?php 
			  $row_subtotal=$row_RS_fac_det['fac_prod_can']*$row_RS_fac_det['fac_prod_pre'];
			  echo number_format($row_subtotal,2,".",""); ?></td>
                <?php $subtotal+=$row_RS_fac_det['fac_prod_can']*$row_RS_fac_det['fac_prod_pre']; ?>
            </tr>
              <?php } while ($row_RS_fac_det = mysql_fetch_assoc($RS_fac_det)); ?>
          </tbody>
        </table>
        
        </td>
    </tr>
</table>
<table width="850">
	<tr>
   	  <td align="right">
        
        <table height="94">
<tr>
           	<td width="115"><!--Subtotal: --></td>
                    <td width="95"><?php echo number_format($subtotal,2,".",""); ?></td>
          </tr>
                <tr>
                	<td><!-- &nbsp; --></td>
                    <td>0</td>
                </tr>
          <tr>
                	<td><!--I.V.A: -->12</td>
                    <td><?php echo number_format($subtotal*$_SESSION['conf']['taxes']['iva_si'],2,".",""); ?></td>
          </tr>
                <tr>
                	<td><!--TOTAL: --></td>
                    <td class="txt_values"><?php echo number_format($subtotal+($subtotal*$_SESSION['conf']['taxes']['iva_si']),2,".",""); ?></td>
              </tr>
        </table>
        
      </td>
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
