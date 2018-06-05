<?php require_once('../../Connections/conn.php'); ?>
<?php
session_start();
if($_SESSION['refresh']=='ok')
{
	$_SESSION['refresh']=null;
	$insertGoTo = 'pagos_pendientes.php';//REDIRECCION A LA MISMA PAGINA
	header(sprintf("Location: %s", $insertGoTo));
}
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

mysql_select_db($database, $conn);
$query_RS_cta_pend = "SELECT DISTINCT  tbl_pacientes.pac_cod, tbl_pacientes.pac_nom, tbl_pacientes.pac_ape, (SELECT  SUM(tbl_cta_por_cobrar.cta_valor-tbl_cta_por_cobrar.cta_abono) FROM tbl_cta_por_cobrar WHERE tbl_cta_por_cobrar.pac_cod=tbl_pacientes.pac_cod) AS Deuda FROM tbl_pacientes WHERE (SELECT  SUM(tbl_cta_por_cobrar.cta_valor-tbl_cta_por_cobrar.cta_abono)  FROM tbl_cta_por_cobrar WHERE tbl_cta_por_cobrar.pac_cod=tbl_pacientes.pac_cod)>0";
$RS_cta_pend = mysql_query($query_RS_cta_pend, $conn) or die(mysql_error());
$row_RS_cta_pend = mysql_fetch_assoc($RS_cta_pend);
$totalRows_RS_cta_pend = mysql_num_rows($RS_cta_pend);
?>
	<?php include('../../system/base/__libs.php'); ?>
    <?php include('../../system/base/__styles.php'); ?>
	<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
	<script type="text/javascript">
	$(function() {		
		$("#mytable").tablesorter({sortList:[[4,1]], widgets: ['zebra']});
	});
	</script>
<div id="head_sec"><a href="#" class="link">PAGOS PENDIENTES</a></div>
<?php if($totalRows_RS_cta_pend>0){ ?>
<table id="mytable" class="tablesorter">
<thead>
	<tr>
    	<th width="65"></th>
    	<th width="40">ID</th>
        <th>Apellidos</th>
        <th>Nombres</th>
		<th>Deuda</th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <tr>
    	<td align="center">
        <a href="pagos_form.php?id_pac=<?php echo $row_RS_cta_pend['pac_cod']; ?>"><img src="../../images/struct/img_taskbar/calculator.png" border="0" /></a>           </td>
		<td><?php echo $row_RS_cta_pend['pac_cod']; ?></td>
        <td><?php echo $row_RS_cta_pend['pac_ape']; ?></td>
		<td><?php echo $row_RS_cta_pend['pac_nom']; ?></td>
		<td><strong><?php echo $row_RS_cta_pend['Deuda']; ?></strong></td>
    </tr>
    <?php } while ($row_RS_cta_pend = mysql_fetch_assoc($RS_cta_pend)); ?>    
</tbody>
</table>
<?php }else{ ?>
<table width="100%" height="94%">
	<tr>
   	  <td align="center" class="titcat-work-box">No Se Encontraron Pagos Pendientes !!!</td>
    </tr>
</table>
<?php } ?>
<?php
mysql_free_result($RS_cta_pend);
?>