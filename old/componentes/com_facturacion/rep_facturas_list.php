<?php include('../_config.php'); ?>
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


$query_RS_list_fact = "SELECT * FROM tbl_factura_cab";
$RS_list_fact = mysql_query($query_RS_list_fact) or die(mysql_error());
$row_RS_list_fact = mysql_fetch_assoc($RS_list_fact);
$totalRows_RS_list_fact = mysql_num_rows($RS_list_fact);
?><?php include(RAIZ."/frames/_head.php"); ?>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<script type="text/javascript">
	$(function() {		
		$("#mytable").tablesorter({sortList:[[1,1]], widgets: ['zebra']});
	});
	</script>
</head>

<body>
<div id="head_sec">
<a href="#" class="link">LISTA FACTURAS</a></div>
<table id="mytable" class="tablesorter">
<thead>
	<tr>
    	<th width="50"></th>
	  	<th width="40">NUM</th>
    	<th width="130">Fecha</th>
        <th>Cliente</th>
        <th width="50">Valor</th>
		<th>Empleado</th>
        <th>Estado</th>
	</tr>
</thead>
<tbody>
  <?php do { ?>
    <tr>
      <td align="center">        <a href="factura_detail.php?fac_num=<?php echo $row_RS_list_fact['fac_num']; ?>&id_pac=<?php echo $row_RS_list_fact['cli_cod']; ?>" rel="shadowbox[detail]"><img src="img_est/img_taskbar/zoom.png" /></a>          <a href="factura_print.php?fac_num=<?php echo $row_RS_list_fact['fac_num']; ?>" rel="shadowbox[print]"><img src="img_est/img_taskbar/print_16.png" width="16" height="16" /></a></td>
      <td><?php echo $row_RS_list_fact['fac_num']; ?></td>
      <td><?php echo $row_RS_list_fact['fac_fec']; ?></td>
      <td><?php echo detCliPer($row_RS_list_fact['cli_cod']); ?></td>
      <td align="right"><?php echo valor_factura($row_RS_list_fact['fac_num'], $row_RS_list_fact['fac_cic_id']); ?></td>
      <td><?php echo detalle_cliente($row_RS_list_fact['cli_cod']); ?></td>
      <td>&nbsp;</td>
    </tr>
    <?php } while ($row_RS_list_fact = mysql_fetch_assoc($RS_list_fact)); ?>
</tbody>
</table>
</body>
</html>
<?php
mysql_free_result($RS_list_fact);
?>
