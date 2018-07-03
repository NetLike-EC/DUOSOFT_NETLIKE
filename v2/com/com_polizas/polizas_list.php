<?php require_once('../../Connections/conn.php');

$maxRows_RS_pacientes_list = 50;
$pageNum_RS_pacientes_list = 0;
if (isset($_GET['pageNum_RS_pacientes_list'])) {
  $pageNum_RS_pacientes_list = $_GET['pageNum_RS_pacientes_list'];
}
$startRow_RS_pacientes_list = $pageNum_RS_pacientes_list * $maxRows_RS_pacientes_list;

$colname_RS_pacientes_list = "-1";
if (isset($_POST['sBr'])) {
  $colname_RS_pacientes_list = $_POST['sBr'];
}

$query_RS_pacientes_list = sprintf("SELECT * FROM db_clientes WHERE cli_nom LIKE %s or cli_ape LIKE %s or CONCAT(cli_nom,' ', cli_ape) LIKE %s", SSQL("%" . $colname_RS_pacientes_list . "%", "text"),SSQL("%" . $colname_RS_pacientes_list . "%", "text"),SSQL("%" . $colname_RS_pacientes_list . "%", "text"));
$query_limit_RS_pacientes_list = sprintf("%s LIMIT %d, %d", $query_RS_pacientes_list, $startRow_RS_pacientes_list, $maxRows_RS_pacientes_list);
$RS_pacientes_list = mysql_query($query_limit_RS_pacientes_list) or die(mysql_error());
$row_RS_pacientes_list = mysql_fetch_assoc($RS_pacientes_list);

if (isset($_GET['totalRows_RS_pacientes_list'])) {
  $totalRows_RS_pacientes_list = $_GET['totalRows_RS_pacientes_list'];
} else {
  $all_RS_pacientes_list = mysql_query($query_RS_pacientes_list);
  $totalRows_RS_pacientes_list = mysql_num_rows($all_RS_pacientes_list);
}
$totalPages_RS_pacientes_list = ceil($totalRows_RS_pacientes_list/$maxRows_RS_pacientes_list)-1;
?>
	<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
	<script type="text/javascript">
	$(function() {		
		$("#mytable").tablesorter({sortList:[[2,0],[3,0]], widgets: ['zebra']});
	});
	</script>
<?php unset($_POST['sBr']); ?>
<?php if ($totalRows_RS_pacientes_list>0) { ?>
<table id="mytable" class="tablesorter">
<thead>
	<tr>
    	<th width="65"></th>
		<th>COD</th>
    	<th>Apellidos</th>
        <th>Nombres</th>
		<th>Edad</th>
        <th>Trabajo</th>
        <th>Ciudad</th>
        <th>&nbsp;</th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <tr>
    	<td align="center">
        <a onclick="show_det_cli_list(<?php echo $row_RS_pacientes_list['cli_id']; ?>)" title="Ver Detalle"><img src="../../images/struct/img_taskbar/zoom.png" /></a>
        	<?php if ($_SESSION['MODSEL']=="PAC"){ ?>
    	   <a href="../com_pacientes/form.php?idp=<?php echo $row_RS_pacientes_list['cli_id']; ?>&amp;action_form=Actualizar" rel="shadowbox;options={relOnClose:true}" title="Modificar Paciente"><img src="../../images/struct/img_taskbar/add_user.png" border="0" alt="Reserva"/></a>
           <?php } ?>
           
           <?php if ($_SESSION['MODSEL']=="CON"){ ?>
           <a href="../com_consultas/consultas_reserva_form.php?idp=<?php echo $row_RS_pacientes_list['cli_id']; ?>" rel="shadowbox;width=660;height=350" title="Nueva Reserva"><img src="../../images/struct/img_taskbar/book_addresses.png" border="0" alt="Reserva"/></a>
           <?php } ?>
           
            <?php if ($_SESSION['MODSEL']=="POL"){ ?>
           <a href="polizas_pac.php?idp=<?php echo $row_RS_pacientes_list['cli_id']; ?>" rel="shadowbox;width=660;height=350" title="Nueva Reserva"><img src="../../images/struct/img_taskbar/book_addresses.png" border="0" alt="Reserva"/></a>
           <?php } ?>
           
           <?php if ($_SESSION['MODSEL']=="PAG"){ ?>
           <a href="../com_pagos/pagos_form.php?idp=<?php echo $row_RS_pacientes_list['cli_id']; ?>" rel="shadowbox" title="Pagos Pacientes"><img src="../../images/struct/img_taskbar/calculator.png" border="0" alt="Pagos"/></a>
           <?php } ?>
           
           <?php if ($_SESSION['MODSEL']=="FAC"){ ?>
           <a href="../com_factura/factura_form.php?idp=<?php echo $row_RS_pacientes_list['cli_id']; ?>" rel="shadowbox" title="Facturas Pacientes"><img src="../../images/struct/img_taskbar/calculator.png" border="0" alt="Pagos"/></a>
           <?php } ?>
           </td>
		<td><?php echo $row_RS_pacientes_list['cli_id']; ?></td>
		<td><?php echo $row_RS_pacientes_list['cli_ape']; ?></td>
		<td><?php echo $row_RS_pacientes_list['cli_nom']; ?></td>
        
		<td><em><?php echo edad($row_RS_pacientes_list['cli_fec']); ?></em> &nbsp; <?php echo $row_RS_pacientes_list['cli_fec']; ?></td>
		<td><?php echo htmlentities($row_RS_pacientes_list['pac_prof']); ?></td>
        <td><?php echo htmlentities($row_RS_pacientes_list['pac_ciu']); ?></td>
        <td><a href="../com_pacientes/pacientes_detail_all.php?cli_sel_list=<?php echo $row_RS_pacientes_list['cli_id']; ?>" rel="shadowbox[DETPAC];width=650" title="Detalles Paciente:  <?php echo $row_RS_pacientes_list['cli_id']; ?>.  <?php echo $row_RS_pacientes_list['cli_nom']; ?> <?php echo $row_RS_pacientes_list['cli_ape']; ?>">+</a></td>
    </tr>
    <?php } while ($row_RS_pacientes_list = mysql_fetch_assoc($RS_pacientes_list)); ?>    
</tbody>
</table>
Total: <?php echo $totalRows_RS_pacientes_list; ?>
<?php }else{ ?>
<table id="mytable" class="tablesorter">
<thead>
	<tr>
    	<th width="65"></th>
		<th>COD</th>
    	<th>Apellidos</th>
        <th>Nombres</th>
		<th>Edad</th>
        <th>Trabajo</th>
        <th>Ciudad</th>
        <th>&nbsp;</th>
	</tr>
</thead>
</table>
<?php } ?>
<?php
mysql_free_result($RS_pacientes_list);
?>