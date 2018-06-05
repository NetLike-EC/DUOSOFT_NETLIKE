<?php require_once('../../init.php');?>
<div>
<?php 
$detalle = $_SESSION[$ses_id]['venta'];
if($detalle){ ?>
	<table class="tablesorter table table-bordered table-condensed table-hover" id="mytable">
	<thead>
	<tr>
		<th>COD</th>
		<th>Nombre</th>
		<th>Tipo-Categoria</th>
		<th>Marca</th>
		<th>Cantidad</th>
		<th>Precio</th>
		<th>Subtotal</th>
		<th></th>
	</tr>
	</thead>
	<?php 
	$sumsubtot=0;
	foreach ($_SESSION[$ses_id]['venta'] as $keyAgregar => $v) {
		$subtotLin=0;
		$subtotLin=number_format($v["can"]*$v["pre"],2);
		$sumsubtot+=$subtotLin;
		
		$detProd=detInvProd($v['id']);
		$detTip=detInvTip($detProd['tip_cod']);
		$detCat=detInvCat($detTip['cat_cod']);
		$detTipCat=$detTip['tip_nom'].' / '.$detCat['cat_nom'];
		$detMar=detInvMar($detProd['mar_id']);
		
		?>
	<tr class="<?php if($subtotLin==0) echo "error" ?>" id="<?php echo $keyAgregar; ?>">
		<td align="center"><?php echo $v["id"]; ?></td>
		<td><strong><?php echo $detProd['prod_nom']; ?></strong></td>
		<td><?php echo $detTipCat ?></td>
		<td><?php echo $detMar['mar_nom']?></td>
		<td><?php echo $v["can"]; ?></td>
		<td><?php echo $v["pre"]; ?></td>
		<td><?php echo $subtotLin ?></td>
		<td><a onClick="remTabRow_Com(<?php echo $keyAgregar; ?>)" class="btn mini red"><i class="icon-remove"></i> Quitar</a></td>
	</tr>
	<?php }
	$fac_sub=number_format($sumsubtot,2);
	$fac_iva=number_format($sumsubtot*.12,2);
	$fac_tot=number_format($sumsubtot+$sumsubtot*.12,2);
	?>
   	<tr><td colspan="8"></td></tr>
    <tr class="warning">
        <td colspan="6"><h5 class="text-right">SUBTOTAL</h5></td>
        <td colspan="2"><h5><?php echo $fac_sub ?></h5></td>
	</tr>
    <tr class="warning">
        <td colspan="6"><h5 class="text-right">I.V.A.</h5></td>
        <td colspan="2"><h5><?php echo $fac_iva ?></h5></td>
	</tr>
    <tr class="info">
        <td colspan="6"><h5 class="text-right"><strong>TOTAL</strong></h5></td>
        <td colspan="2"><h4><strong><?php echo $fac_tot ?></strong></h4></td>
	</tr>	
</table>
<?php }else{ ?>
	<div class="alert alert-error">
	  <h4>No Hay productos a Vender</h4></div>
<?php }	?>
</div>