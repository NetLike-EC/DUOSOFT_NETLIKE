<?php
$query_RS_lv = "SELECT * FROM tbl_venta_cab ORDER BY ven_num DESC";
$RS_lv = mysql_query($query_RS_lv) or die(mysql_error());
$row_RSlv = mysql_fetch_assoc($RS_lv);
$totalRows_RS_lv = mysql_num_rows($RS_lv);
?>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span8">
    	<h3 class="page-title"><?php echo $rowMod['mod_nom']?> <small><?php echo $rowMod['mod_des']?></small></h3>
	</div>
	<div class="span4 text-right">
		<a class="btn big blue disabled"><?php echo $totalRows_RS_lv ?> Registros</a>
		<a class="btn big blue" href="egreso.php">
        <strong><?php echo $btn2_tot ?></strong> <i class="icon-plus"></i> Nuevo</a>
	</div>
</div>
<?php 
fnc_log();
if ($totalRows_RS_lv>0){ ?>
<table id="mytable_facturas" class="table table-bordered table-hover table-condensed">
<thead>
	<tr>
    	<th></th>
        <th>ID</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Valor</th>
		<th>Empleado</th>
        <th>Estado</th>
        <th>Facturado</th>
	</tr>
</thead>
<tbody>
	<?php do {
	$detAud=detAud($row_RSlv['aud_id']);
	$detAud_nom=$detAud['per_nom']." ".$detAud['per_ape'];
	$detAud_fec=$detAud['aud_dat'];
	
	$detCli=detCliPer($row_RSlv['cli_cod']);
	$detCli_nom=$detCli['per_nom'].' '.$detCli['per_ape'];
	
	$detFac=detRow('tbl_factura_ven','ven_num',$row_RSlv['ven_num']);
	
	unset($btnAcEst,$infFacVen);
	if($row_RSlv['ven_stat']=='1'){
		$comEst='<span class="label label-info">Activa</span>';
		$btnAcEst='<a class="btn red mini" href="fnc.php?acc=AVEN&ven_num='.$row_RSlv['ven_num'].'">Anular</a>';
		//Verifica Factura Venta
		if($detFac){
			$infFacVen='<a href="form_fact.php?fac_num='.$detFac['fac_num'].'" class="fancybox fancybox.iframe btn mini green">'.$detFac['fac_num'].'</a>';
		}else{
			$infFacVen='<span class="label">NO</span> ';
			$infFacVen.=' <a href="form_fact.php?id='.$row_RSlv['ven_num'].'" class="fancybox fancybox.iframe btn mini blue">Facturar</a>';
		}
		
	}else if ($row_RSlv['ven_stat']=='0'){
		$comEst='<span class="label label-danger">Anulada</span>';
		//Verifica Factura Venta
		if($detFac){
			if($detFac['fac_stat']=='0'){ $statFacVen='<span class="label">Anulada</span>'; }else{ $statFacVen=''; }
			$infFacVen='<span class="label">'.$detFac['fac_num'].'</span> ';
			$infFacVen.=$statFacVen;
		}else{
			$infFacVen='<span class="label">NO</span>';
		}
	}else{
		$comEst='<span class="label">N/D</span>';
	}
	?>
    <tr>
      <td class="text-center">
        <a href="venta_detail.php?id=<?php echo $row_RSlv['ven_num']; ?>" class="btn mini blue"><i class="icon-eye-open"></i></a>
        <a href="<?php echo $RAIZc; ?>com_reportes/com_compra_detalle.php?com_num=<?php echo $row_RSlv['com_num']; ?>" rel="shadowbox[print]" class="btn mini yellow"><i class="icon-print"></i> Imprimir</a>
        </td>
      <td><?php echo $row_RSlv['ven_num']; ?></td>
      <td><span class="label"><?php echo $detAud_fec; ?></span></td>
      <td><?php echo $detCli_nom; ?></td>
      <td><?php echo valor_factura($row_RSlv['ven_num']); ?></td>
      <td><small><?php echo $detAud_nom ?></small></td>
      <td><?php echo $comEst;?> 
      <?php echo $btnAcEst ?></td>
      <td><?php echo $infFacVen ?></td>
    </tr>
    <?php } while ($row_RSlv = mysql_fetch_assoc($RS_lv)); ?>
</tbody>
</table>
<?php }else{
	echo '<div class="alert alert-warning"><h4>No se han realizado Ventas</h4></div>';
	} ?>
</div>

<?php
mysql_free_result($RS_lv);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.fancybox').fancybox({
		afterClose: function(){
		location.reload();
		}
	});
});
</script>