<?php
$query_RS_list_comp = "SELECT * FROM tbl_compra_cab ORDER BY com_num DESC";
$RS_list_comp = mysql_query($query_RS_list_comp) or die(mysql_error());
$row_RSlc = mysql_fetch_assoc($RS_list_comp);
$totalRows_RS_list_comp = mysql_num_rows($RS_list_comp);
?>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span8">
    	<h3 class="page-title"><?php echo $rowMod['mod_nom']?> <small><?php echo $rowMod['mod_des']?></small></h3>
	</div>
	<div class="span4 text-right">
		<a class="btn big red disabled">
        <strong><?php echo $totalRows_RS_list_comp ?></strong> Compras <i class="icon-shopping-cart"></i></a>
		<a class="btn big red" href="compra_form.php">
        <strong><?php echo $btn2_tot ?></strong> <i class="icon-plus"></i> Nuevo</a>
	</div>
</div>
<?php 
fnc_log();
if ($totalRows_RS_list_comp>0){ ?>
<table id="mytable_facturas" class="table table-bordered table-hover table-condensed">
<thead>
	<tr>
    	<th></th>
	  	<th width="40">ID</th>
    	<th>Fecha</th>
        <th>Proveedor</th>
        <th>Proced</th>
        <th>Valor</th>
		<th>Empleado</th>
        <th>Estado</th>
        <th>Facturado</th>
	</tr>
</thead>
<tbody>
	<?php do {
	$detProv=detProvPer($row_RSlc['prov_id']);
	$detProv_nom=$detProv['per_nom'].' '.$detProv['per_ape'];
	//Procedencia Compra
	$detCom_proc=$row_RSlc['com_proc'];
	if($detCom_proc=='LOC') $detCom_procv='Local';
	else if ($detCom_proc=='IMP') $detCom_procv='Importado '.$row_RSlc['com_imp'].'%';
	else $detCom_procv='N/D';
	//Estado Compra
	if($row_RSlc['com_stat']=='1'){
		$comEst='<span class="label label-info">Activa</span>';
		
		if(verAnuCom($row_RSlc['com_num'])){
			$btnAnu='<a class="btn red mini" href="fnc.php?acc=ACOM&com_num='.$row_RSlc['com_num'].'">Anular</a>';
		}else{
			$btnAnu='<a class="btn mini disabled">No se puede Anular</a>'; 
		}
	
		$detFacCom=verifyFactCom($row_RSlc['com_num']);
		if($detFacCom){
			$btnFac='<div class="btn-group">
			<span class="btn blue mini">Factura</span>
			<a href="form_fact.php?id='.$detFacCom['id'].'" class="fancybox fancybox.iframe btn green mini">'.$detFacCom['fac_num'].'</a></div>';
		}else{
			$btnFac='<span class="btn red mini">NO</span>
			<a href="form_fact.php" class="fancybox fancybox.iframe btn blue mini">Crear Factura</a>';
		}
		
	}else if ($row_RSlc['com_stat']=='0'){
		$comEst='<span class="label label-danger">Anulada</span>';
		$btnAnu='<a class="btn mini disabled">Anulada</a>';
		$btnFac='';
	}else{
		$comEst='<span class="label">ERROR</span>';
		$btnAnu='<span class="label">ERROR</span>';
		$btnFac='<span class="label">ERROR</span>';
	}
	
	if($row_RSlc['com_stat']=='1'){
		
	}else{ }
	
	$detAud=detAud($row_RSlc['aud_id']);
	$detAud_nom=$detAud['per_nom']." ".$detAud['per_ape'];
	
	
	
	?>
    <tr>
      <td align="center">
        <a href="compra_detail.php?com_num=<?php echo $row_RSlc['com_num']; ?>" class="btn mini blue"><i class="icon-eye-open"></i></a>
        <a href="<?php echo $RAIZc; ?>com_reportes/com_compra_detalle.php?com_num=<?php echo $row_RSlc['com_num']; ?>" rel="shadowbox[print]" class="btn mini yellow"><i class="icon-print"></i> Imprimir</a>
        </td>
      <td><?php echo $row_RSlc['com_num']; ?></td>
      <td><span class="label"><?php echo $detAud['aud_dat']; ?></span>
        <span class="label"><?php echo $row_RSlc['fac_com_fec']; ?></span></td>
      <td><?php echo $detProv_nom; ?></td>
      <td><?php echo $detCom_procv; ?></td>
      <td align="right"><?php echo valor_factura_compra($row_RSlc['com_num']); ?></td>
      <td><?php echo $detAud_nom; ?></td>
      <td><?php echo $comEst ?>
      <?php echo $btnAnu ?>
      </td>
      <td><?php echo $btnFac ?></td>
    </tr>
    <?php } while ($row_RSlc = mysql_fetch_assoc($RS_list_comp)); ?>
</tbody>
</table>
<?php }else{
	echo '<div class="alert alert-error">No se han realizado Compras</div>';
	} ?>
</div>

<?php
mysql_free_result($RS_list_comp);
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