<?php require_once('../../init.php');?>
<div>
<?php 
$detalle = $_SESSION[$ses_id]['compra'];
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
	foreach ($_SESSION[$ses_id]['compra'] as $keyAgregar => $v) {
		$subtotLin=0;
		$subtotLin=$v["can"]*$v["pre"];
		$sumsubtot+=$subtotLin;
		
		$detProd=detInvProd($v['id']);
		$detTip=detInvTip($detProd['tip_cod']);
		$detCat=detInvCat($detTip['cat_cod']);
		$detTipCat=$detTip['tip_nom'].' / '.$detCat['cat_nom'];
		$detMar=detInvMar($detProd['mar_id']);
		?>
	<tr class="TrNiv" id="<?php echo $keyAgregar; ?>">
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
	$fac_sub=$sumsubtot;
	$fac_iva=$sumsubtot*.12;
	$fac_tot=number_format($sumsubtot+$sumsubtot*.12,2);
	?>
   	<tr><td colspan="8"></td></tr>
    <tr class="info">
        <td colspan="4" style="text-align:right"><strong>TOTAL BRUTO</strong></td>
        <td colspan="4"><?php echo $fac_sub ?></td>
	</tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="2" style="text-align:right"><em class="label"><strong>I.V.A.</strong> (Local)</em></td>
        <td colspan="2"><?php echo $fac_iva ?></td>
	</tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="2" style="text-align:right"><em class="label"><strong>TOTAL NETO</strong> (Local)</em></td>
        <td colspan="2"><?php echo $fac_tot ?></td>
	</tr>
    
   	<tr><td colspan="8"></td></tr>
	
	
</table>
<?php }else{ ?>
	<div class="alert alert-error"><h4>No Hay productos a Ingresar</h4></div>
<?php }	?>
</div>