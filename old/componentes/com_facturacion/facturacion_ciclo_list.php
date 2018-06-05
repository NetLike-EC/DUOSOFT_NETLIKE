<?php require_once('Connections/conn_servisoft.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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

$maxRows_RS_fac_cic_lis = 50;
$pageNum_RS_fac_cic_lis = 0;
if (isset($_GET['pageNum_RS_fac_cic_lis'])) {
  $pageNum_RS_fac_cic_lis = $_GET['pageNum_RS_fac_cic_lis'];
}
$startRow_RS_fac_cic_lis = $pageNum_RS_fac_cic_lis * $maxRows_RS_fac_cic_lis;

mysql_select_db($database_conn_servisoft, $conn_servisoft);
$query_RS_fac_cic_lis = "SELECT * FROM tbl_factura_ciclosf ORDER BY fac_cic_id DESC";
$query_limit_RS_fac_cic_lis = sprintf("%s LIMIT %d, %d", $query_RS_fac_cic_lis, $startRow_RS_fac_cic_lis, $maxRows_RS_fac_cic_lis);
$RS_fac_cic_lis = mysql_query($query_limit_RS_fac_cic_lis, $conn_servisoft) or die(mysql_error());
$row_RS_fac_cic_lis = mysql_fetch_assoc($RS_fac_cic_lis);

if (isset($_GET['totalRows_RS_fac_cic_lis'])) {
  $totalRows_RS_fac_cic_lis = $_GET['totalRows_RS_fac_cic_lis'];
} else {
  $all_RS_fac_cic_lis = mysql_query($query_RS_fac_cic_lis);
  $totalRows_RS_fac_cic_lis = mysql_num_rows($all_RS_fac_cic_lis);
}
$totalPages_RS_fac_cic_lis = ceil($totalRows_RS_fac_cic_lis/$maxRows_RS_fac_cic_lis)-1;
?>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<script type="text/javascript">
	$(function() {		
		$("#mytable").tablesorter({sortList:[[0,1]], widgets: ['zebra']});
	});
	</script>
<?php include('_fncts.php'); ?>
<!--<a href="factura_form.php?action_cons=insert&&ver=1" rel="shadowbox[A];options={relOnClose:true}" title="Facturacion" target="_top">-</a>-->
<table id="mytable" class="tablesorter">
<thead>
	<tr>
		<th width="30">ID</th>
    	<th width="120">Inicio Secuencia</th>
        <th width="120">Facturas Creadas</th>
        <th width="120">Serie</th>
        <th>Observaciones</th>
		<th width="125">Empleado Inicia</th>
        <th width="125">Empleado Finaliza</th>
	</tr>
</thead>
<tbody> 
	<?php
	$status_init=0;
	?>
	<?php do { ?>
    <?php if ($status_init==0) {?>
    <tr style="font-weight:bold; font-size:12px;">
	<?php $status_init=1;
	}else{ ?>
    <tr>
    <?php }	?>
		<td><?php echo $row_RS_fac_cic_lis['fac_cic_id']; ?></td>
		<td><?php echo $row_RS_fac_cic_lis['fac_cic_ini']; ?></td>
		<td><?php echo $row_RS_fac_cic_lis['fac_cic_cont']; ?></td>
        <td><?php echo $row_RS_fac_cic_lis['fac_cic_serie']; ?></td>
        <td><?php echo $row_RS_fac_cic_lis['fac_cic_observ']; ?></td>
		<td><?php echo detalle_empleado($row_RS_fac_cic_lis['fac_cic_emp_cod_ini']); ?></td>
		<td><?php 
		if ($row_RS_fac_cic_lis['fac_cic_emp_cod_fin']=="")
			echo "<strong>-</strong>";
		else
			echo detalle_empleado($row_RS_fac_cic_lis['fac_cic_emp_cod_fin']); ?></td>
    </tr>
    <?php } while ($row_RS_fac_cic_lis = mysql_fetch_assoc($RS_fac_cic_lis)); ?>    
</tbody>
</table>
<?php
mysql_free_result($RS_fac_cic_lis);
?>