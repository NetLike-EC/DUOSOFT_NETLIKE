<?php
	include('../_config.php');
	require_once(RAIZ.'Connections/conn.php');
?>
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



$maxRows_RS_users_list = 10;
$pageNum_RS_users_list = 0;
if (isset($_GET['pageNum_RS_users_list'])) {
  $pageNum_RS_users_list = $_GET['pageNum_RS_users_list'];
}
$startRow_RS_users_list = $pageNum_RS_users_list * $maxRows_RS_users_list;

mysql_select_db($database, $conn);
$query_RS_users_list = "SELECT * FROM tbl_user_system";
$query_limit_RS_users_list = sprintf("%s LIMIT %d, %d", $query_RS_users_list, $startRow_RS_users_list, $maxRows_RS_users_list);
$RS_users_list = mysql_query($query_limit_RS_users_list, $conn) or die(mysql_error());
$row_RS_users_list = mysql_fetch_assoc($RS_users_list);

if (isset($_GET['totalRows_RS_users_list'])) {
  $totalRows_RS_users_list = $_GET['totalRows_RS_users_list'];
} else {
  $all_RS_users_list = mysql_query($query_RS_users_list);
  $totalRows_RS_users_list = mysql_num_rows($all_RS_users_list);
}
$totalPages_RS_users_list = ceil($totalRows_RS_users_list/$maxRows_RS_users_list)-1;

$queryString_RS_users_list = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_users_list") == false && 
        stristr($param, "totalRows_RS_users_list") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_users_list = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_users_list = sprintf("&totalRows_RS_users_list=%d%s", $totalRows_RS_users_list, $queryString_RS_users_list);
?>
<?php if ($totalRows_RS_users_list>0) { ?>
<table id="mytable" class="tablesorter">
<thead>
	<tr>
    	<th width="65"></th>
		<th>ID</th>
    	<th width="80">username</th>
        <th>Nombres</th>
		<th>Level</th>
        <th>Activo</th>
        <th>Accion</th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
	<?php $dataemp=detEmpPer($row_RS_users_list['emp_cod']); ?>
    <tr>
    	<td align="center">
        <a onclick="show_det_cli_list(<?php echo $row_RS_users_list['pac_cod']; ?>)" title="Ver Detalle"><img src="../../images/struct/img_taskbar/zoom.png" /></a>
        	<?php if ($_SESSION['MODSEL']=="PAC"){ ?>
    	   <a href="clientes_form.php?id_pac=<?php echo $row_RS_users_list['pac_cod']; ?>&amp;action_form=UPDATE" rel="shadowbox;options={relOnClose:true}" title="Modificar Paciente"><img src="../../images/struct/img_taskbar/add_user.png" border="0" alt="Reserva"/></a>
           <?php } ?>
           
           <?php if ($_SESSION['MODSEL']=="CON"){ ?>
           <a href="../com_consultas/consultas_reserva_form.php?id_pac=<?php echo $row_RS_users_list['pac_cod']; ?>" rel="shadowbox;width=660;height=350" title="Nueva Reserva"><img src="../../images/struct/img_taskbar/book_addresses.png" border="0" alt="Reserva"/></a>
           <?php } ?>
           
            <?php if ($_SESSION['MODSEL']=="POL"){ ?>
           <a href="../com_polizas/polizas_pac.php?id_pac=<?php echo $row_RS_users_list['pac_cod']; ?>" rel="shadowbox;width=660;height=350" title="Polizas Paciente"><img src="../../images/struct/img_taskbar/clipboard_16.png" border="0" alt="Polizas"/></a>
           <?php } ?>
                   
           <?php if ($_SESSION['MODSEL']=="PAG"){ ?>
           <a href="../com_pagos/pagos_form.php?id_pac=<?php echo $row_RS_users_list['pac_cod']; ?>" rel="shadowbox" title="Pagos Pacientes"><img src="../../images/struct/img_taskbar/calculator.png" border="0" alt="Pagos"/></a>
           <?php } ?>
           
           <?php if ($_SESSION['MODSEL']=="FAC"){ ?>
           <a href="../com_factura/factura_form.php?id_pac=<?php echo $row_RS_users_list['pac_cod']; ?>" rel="shadowbox;width=600;height=400" title="Facturas Pacientes"><img src="../../images/struct/img_taskbar/calculator.png" border="0" alt="Pagos"/></a>
           <?php } ?>
        </td>
		<td><?php echo $row_RS_users_list['user_id']; ?></td>
		<td><?php echo $row_RS_users_list['user_username']; ?></td>
		<td><?php echo $dataemp['emp_nom'].' '.$dataemp['emp_ape'];?></td>
        
		<td align="center"><b><?php echo $row_RS_users_list['user_level']; ?></b></td>
		<td><?php echo fnc_status($row_RS_users_list['user_id'], $row_RS_users_list['user_status'] ); ?></td>
        <td align="center">
        <a onClick="shadbox_open('items_prod_form.php', 'Modificar', '600', 'UPDATE', '<?php echo $row_RS_list_prod['prod_id']; ?>')">
        <img src="<?php echo $RAIZ; ?>images/struct/edit-16.png" width="16" height="16" /></a>&nbsp;
        <a onClick="cont_panel('_fncts.php?id_sel=<?php echo $row_RS_list_prod['prod_id']; ?>&action=DELETE', false)"><img src="<?php echo $RAIZ; ?>images/struct/Empty-Trash_16x16.png" width="16" height="16" border="0" /></a>        </td>
    </tr>
    <?php } while ($row_RS_users_list = mysql_fetch_assoc($RS_users_list)); ?>    
</tbody>
</table>
<div>

<div align="center" style="float:right;">
  <table border="0">
    <tr>
      <td><?php if ($pageNum_RS_users_list > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_RS_users_list=%d%s", $currentPage, 0, $queryString_RS_users_list); ?>"><img src="../../images/struct/paginator/First.gif" /></a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_RS_users_list > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_RS_users_list=%d%s", $currentPage, max(0, $pageNum_RS_users_list - 1), $queryString_RS_users_list); ?>"><img src="../../images/struct/paginator/Previous.gif" /></a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_RS_users_list < $totalPages_RS_users_list) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_RS_users_list=%d%s", $currentPage, min($totalPages_RS_users_list, $pageNum_RS_users_list + 1), $queryString_RS_users_list); ?>"><img src="../../images/struct/paginator/Next.gif" /></a>
      <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_RS_users_list < $totalPages_RS_users_list) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_RS_users_list=%d%s", $currentPage, $totalPages_RS_users_list, $queryString_RS_users_list); ?>"><img src="../../images/struct/paginator/Last.gif" /></a>
      <?php } // Show if not last page ?></td>
    </tr>
  </table>
</div>

<div align="center" style="float:left;"> Registros <?php echo ($startRow_RS_users_list + 1) ?> a <?php echo min($startRow_RS_users_list + $maxRows_RS_users_list, $totalRows_RS_users_list) ?> de <?php echo $totalRows_RS_users_list ?> </div>

</div>
<?php }else{ ?>
<div class="bord_gray_4cornes"><p class="infoa">Realice una Busqueda</p></div>
<?php } ?>
<?php
mysql_free_result($RS_users_list);
?>