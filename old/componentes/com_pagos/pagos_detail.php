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
$id_pag_sel_RS_det_pag = "-1";
echo 'sdsd1 '.$_GET['id_pag'];
if (isset($_GET['id_pag'])) {
  $id_pag_sel_RS_det_pag = $_GET['id_pag'];
}

mysql_select_db($database, $conn);
$query_RS_det_pag = sprintf("SELECT * FROM tbl_pagopac_cab INNER JOIN tbl_pagopac_det ON tbl_pagopac_cab.pag_num=tbl_pagopac_det.pag_num INNER JOIN tbl_pacientes ON tbl_pagopac_cab.pac_cod=tbl_pacientes.pac_cod WHERE tbl_pagopac_cab.pag_num=%s", GetSQLValueString($id_pag_sel_RS_det_pag, "int"));
$RS_det_pag = mysql_query($query_RS_det_pag, $conn) or die(mysql_error());
$row_RS_det_pag = mysql_fetch_assoc($RS_det_pag);
$totalRows_RS_det_pag = mysql_num_rows($RS_det_pag);
echo "ok";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<?php include('../../system/base/__libs.php'); ?>
<?php include('../../system/base/__styles.php'); ?>
	<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
	<script type="text/javascript">
	$(function() {		
		$("#mytable").tablesorter({sortList:[[2,0],[3,0]], widgets: ['zebra']});
	});
	</script>
</head>
<body>
<div id="head_sec"><a href="#" class="link">Pago #: <?php echo $row_RS_det_pag['pag_num']; ?></a></div>
<div id="cont_head">
<table width="100%">
<tr>
	<td colspan="2">
    	<table>
       	<tr>
            <td class="txt_name">Fecha:</td>
            <td class="txt_values-sec"><?php echo $row_RS_det_pag['pag_fech']; ?></td>
            <td width="10">&nbsp;</td>
            <td class="txt_name">Empleado:</td>
            <td class="txt_values-sec">
			<?php echo "pagos";?>
			<?php
			mysql_select_db($database, $conn);
			$SQL_det_emp="SELECT tbl_empleados.emp_nom, tbl_empleados.emp_ape FROM tbl_empleados WHERE emp_cod=".$row_RS_det_pag['emp_cod'];
			$RS_det_emp = mysql_query($SQL_det_emp, $conn) or die(mysql_error());
			$row_RS_det_emp = mysql_fetch_assoc($RS_det_emp);
			//$totalRows_RS_det_pag = mysql_num_rows($RS_det_pag);
			echo $row_RS_det_emp["emp_nom"].' '.$row_RS_det_emp["emp_ape"];
			?>
            </td>
		</tr>
        </table>
    </td>
</tr>
<tr>
   	<td class="txt_name">Paciente:</td>
    <td class="txt_values-big"><?php echo $row_RS_det_pag['pac_nom']; ?> <?php echo $row_RS_det_pag['pac_ape']; ?></td>
</tr>
<tr>
	<td class="txt_name">Valor Pago:</td>
    <td class="txt_values"><?php echo $row_RS_det_pag['pag_val']; ?></td>
</tr>
</table>
<table id="mytable" class="tablesorter">
<thead>
	<tr>
    	<th width="75">Consulta</th>
        <th width="75"># Cuenta</th>
        <th>Detalle</th>
        <th>Abono</th>
        <th width="40">ID</th>
    </tr>
</thead>
<tbody>
   	<?php do { ?>
   	  <tr>
   	    <td align="center"><?php echo $row_RS_det_pag['con_num']; ?></td>
   	    <td align="center"><?php echo $row_RS_det_pag['num_cta']; ?></td>
   	    <td><?php echo $row_RS_det_pag['detalle']; ?></td>
   	    <td><?php echo $row_RS_det_pag['abono']; ?></td>
   	    <td><?php echo $row_RS_det_pag['sec_pag']; ?></td>
 	    </tr>
   	  <?php } while ($row_RS_det_pag = mysql_fetch_assoc($RS_det_pag)); ?>
</tbody>
</table>
</div>
<table align="center" class="bord_gray_4cornes">
	<tr>
    	<td><?php echo $LOG; ?></td>
    </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RS_det_pag);
?>
