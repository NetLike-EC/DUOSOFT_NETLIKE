<?php
$query_RS_lf = "SELECT * FROM tbl_factura_ven
INNER JOIN tbl_venta_cab ON tbl_factura_ven.ven_num=tbl_venta_cab.ven_num 
ORDER BY tbl_factura_ven.ven_num DESC";
$RS_lf = mysql_query($query_RS_lf) or die(mysql_error());
$row_RSlv = mysql_fetch_assoc($RS_lf);
$totalRows_RS_lf = mysql_num_rows($RS_lf);
?>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span8">
    	<h3 class="page-title"><?php echo $rowMod['mod_nom']?> <small><?php echo $rowMod['mod_des']?></small></h3>
	</div>
	<div class="span4 text-right">
		<a class="btn big blue disabled"><?php echo $totalRows_RS_lf ?> Registros</a>
		<a class="btn big blue" href="form.php">
        <strong><?php echo $btn2_tot ?></strong> <i class="icon-plus"></i> Nuevo</a>
	</div>
</div>
<?php 
fnc_log();
if ($totalRows_RS_lf>0){ ?>
<table id="mytable_facturas" class="table table-bordered table-hover table-condensed">
<thead>
	<tr>
    	<th></th>
        <th>ID</th>
        <th>Factura</th>
        <th>Venta</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Valor</th>
		<th>Empleado</th>
        <th>Estado</th>
        <th></th>
	</tr>
</thead>
<tbody>
	<?php do {
	$detAud=detAud($row_RSlv['aud_id']);
	$detAud_nom=$detAud['per_nom']." ".$detAud['per_ape'];
	$detAud_fec=$detAud['aud_dat'];
	
	$detCli=detCliPer($row_RSlv['cli_cod']);
	$detCli=detPer($detCli['per_id']);
	$detCli_nom=$detCli['per_nom'].' '.$detCli['per_ape'];
	unset($btnAnu);
	if($row_RSlv['fac_stat']=='1'){
		$comEst='<span class="label label-info">Activa</span>';
		$btnAnu='<a class="btn mini red">Anular</a>';
	}else if ($row_RSlv['fac_stat']=='0'){
		$comEst='<span class="label label-danger">Anulada</span>';
	}else{
		$comEst='<span class="label">N/D</span>';
	}
	?>
    <tr>
      <td>
        <a href="venta_detail.php?id=<?php echo $row_RSlv['ven_num']; ?>" class="btn mini blue"><i class="icon-eye-open"></i></a>
        <a href="<?php echo $RAIZc; ?>com_reportes/com_compra_detalle.php?com_num=<?php echo $row_RSlv['com_num']; ?>" rel="shadowbox[print]" class="btn mini yellow"><i class="icon-print"></i> Imprimir</a>
        </td>
      <td><?php echo $row_RSlv['id']; ?></td>
      <td><?php echo $row_RSlv['fac_num']; ?></td>
      <td><?php echo $row_RSlv['ven_num']; ?></td>
      <td><span class="label"><?php echo $detAud_fec; ?></span></td>
      <td><?php echo $detCli_nom; ?></td>
      <td><?php echo valor_factura($row_RSlv['ven_num']); ?></td>
      <td><small><?php echo $detAud_nom ?></small></td>
      <td><?php echo $comEst ?></td>
      <td><?php echo $btnAnu ?></td>
    </tr>
    <?php } while ($row_RSlv = mysql_fetch_assoc($RS_lf)); ?>
</tbody>
</table>
<?php }else{
	echo '<div class="alert alert-warning"><h4>No se han realizado Ventas</h4></div>';
	} ?>
</div>

<?php
mysql_free_result($RS_lf);
?>