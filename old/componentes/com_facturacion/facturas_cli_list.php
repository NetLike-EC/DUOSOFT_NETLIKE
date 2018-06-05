<?php session_start(); ?>
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

$cod_pac_RSconsultas_list = "-1";
if (isset($_SESSION['id_pac'])) {
  $cod_pac_RSconsultas_list = $_SESSION['id_pac'];
}
mysql_select_db($database_conn_servisoft, $conn_servisoft);
$query_RSconsultas_list = sprintf("SELECT tbl_factura_cab.fac_num, tbl_factura_cab.fac_fec, tbl_factura_cab.fac_tot FROM tbl_factura_cab INNER JOIN tbl_clientes ON tbl_factura_cab.cli_cod = tbl_clientes.cli_cod WHERE tbl_clientes.cli_cod= %s", GetSQLValueString($cod_pac_RSconsultas_list, "int"));
$RSconsultas_list = mysql_query($query_RSconsultas_list, $conn_servisoft) or die(mysql_error());
$row_RSconsultas_list = mysql_fetch_assoc($RSconsultas_list);
$totalRows_RSconsultas_list = mysql_num_rows($RSconsultas_list);
?>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(function() {		
	$("#mytable").tablesorter({sortList:[[1,0]], widgets: ['zebra']});
});
</script>
<link href="styles/style_v1.css" rel="stylesheet" type="text/css" />
<?php
if (@mysql_result(mysql_query($query_RSconsultas_list),'cons_num'))
{
?>


<table id="mytable" class="tablesorter">
<thead>
<tr>
	<th></th>
    <th>Factura</th>
    <th>Fecha</th>
    <th>Valor</th>
    <th></th>
</tr>
</thead>
<tbody> 
<?php do { ?>
  <tr>
  	<td><form action="factura_form.php" method="post">
        	<?php
			/*if ($row_RS_cons_res_list['con_num']>0)
				$tip_cons="update";
			else
				$tip_cons="insert";
			echo $tip_cons;*/
			$tip_cons="update";
			?>
    	    <input name="Enviar" type="submit" value="&raquo;" onclick="return confirm('Terminar la Edicion Actual?');"/>
    	    <input name="action_cons" type="hidden" id="action_cons" value="<?php echo $tip_cons; ?>" />
    	    <input name="id_pac" type="hidden" id="id_pac" value="<?php echo $_POST['id_pac']; ?>" />
   	      <input name="id_cons" type="hidden" id="id_cons" value="<?php echo $row_RSconsultas_list['con_num']; ?>" />
    	</form></td>
    <td><?php echo $row_RSconsultas_list['fac_num']; ?></td>
    <td><?php echo $row_RSconsultas_list['fac_fec']; ?></td>
    <td><?php echo $row_RSconsultas_list['fac_tot']; ?></td>
    <td><a href="consultas_reserva_list.php?con_num=<?php echo $row_RSconsultas_list['con_num']; ?>" rel="shadowbox">+</a></td>
  </tr>
<?php } while ($row_RSconsultas_list = mysql_fetch_assoc($RSconsultas_list)); ?>
</tbody>
</table>
<?php }else{ ?>
<table width="400" height="80">
	<tr>
		<td align="center" class="txt_values-sec">Cliente sin Compras Anteriores</td>
    </tr>
</table>
<?php } ?>
<?php
mysql_free_result($RSconsultas_list);
?>