<?php
$query_RSlf = "SELECT * FROM tbl_factura_com 
INNER JOIN tbl_compra_cab ON tbl_factura_com.com_num=tbl_compra_cab.com_num 
ORDER BY tbl_factura_com.com_num DESC";
$RSlf = mysql_query($query_RSlf) or die(mysql_error());
$row_RSlf = mysql_fetch_assoc($RSlf);
$totalRows_RSlf = mysql_num_rows($RSlf);
?>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span8">
    	<h3 class="page-title"><?php echo $rowMod['mod_nom']?> <small><?php echo $rowMod['mod_des']?></small></h3>
	</div>
	<div class="span4 text-right">
		<a class="btn big red disabled"><?php echo $totalRows_RSlf ?> Registro</a>
		<a class="btn big red" href="compra_form.php">
        <strong><?php echo $btn2_tot ?></strong> <i class="icon-plus"></i> Nuevo</a>
	</div>
</div>
<?php 
fnc_log();
if ($totalRows_RSlf>0){ ?>
<table id="mytable_facturas" class="table table-bordered table-hover table-condensed">
<thead>
	<tr>
    	<th></th>
	  	<th>ID</th>
    	<th>Compra</th>
        <th>Factura</th>
        <th>Fecha</th>
		<th>Empleado</th>
        <th>Observaciones</th>
        <th>Estado</th>
	</tr>
</thead>
<tbody>
	<?php do {
	if($row_RSlf['fac_est']=='1') $comEst='<span class="label label-info">Activa</span>';
	else if ($row_RSlf['fac_est']=='0') $comEst='<span class="label label-danger">Anulada</span>';
	else $comEst='<span class="label">ERROR</span>';
	
	
	$detAud=detAud($row_RSlf['aud_id']);
	$detAud_nom=$detAud['per_nom']." ".$detAud['per_ape'];
	
	
	
	?>
    <tr>
      <td align="center">
        <a href="#" class="btn mini blue"><i class="icon-eye-open"></i></a>
        <a href="<?php echo $RAIZc; ?>com_reportes/com_compra_detalle.php?com_num=<?php echo $row_RSlf['com_num']; ?>" rel="shadowbox[print]" class="btn mini yellow"><i class="icon-print"></i></a>
        </td>
      <td><?php echo $row_RSlf['id']; ?></td>
      <td><?php echo $row_RSlf['com_num']; ?></td>
      <td><?php echo $row_RSlf['fac_num']; ?></td>
      <td><span class="label"><?php echo $detAud['aud_dat']; ?></span></td>
      <td><?php echo $detAud_nom; ?></td>
      <td><?php echo $row_RSlf['fac_obs']; ?></td>
      <td><?php echo $comEst ?></td>
    </tr>
    <?php } while ($row_RSlf = mysql_fetch_assoc($RSlf)); ?>
</tbody>
</table>
<?php }else{
	echo '<div class="alert alert-error">No se han realizado Compras</div>';
	} ?>
</div>

<?php
mysql_free_result($RSlf);
?>