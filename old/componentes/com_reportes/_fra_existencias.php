<style type="text/css"> 
.cssPrintTable *{font-size:9px !important; font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;}
.cssPrintTable .table{
width:100%;
display: table;
border-spacing: 0px;
border-color: gray;
border-style:solid;

border: 1px solid #ddd;
border-collapse: separate;
}
.cssPrintTable .table th, .table td{
padding: 2px;
line-height: 20px;
text-align: left;
vertical-align: top;
border-top: 1px solid #ddd;
border-left: 1px solid #ddd;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
   //aquí meteremos las instrucciones que modifiquen el DOM
	
});
function togleClassPrint(acc){
	if(acc=='add') $(".contPrint").addClass("cssPrintTable");
	if(acc=='rem') $(".contPrint").removeClass("cssPrintTable");
}
</script>
<div class="contPrint">
	<h3 class="page-title">Inventario <small><?php echo $sdate?></small></h3>
	<?php $query_RSc = "SELECT tbl_inv_productos.prod_id, tbl_inv_productos.mar_id, tbl_inv_productos.tip_cod, tbl_inv_productos.prod_img, SUM(inv_can-inv_sal) as stock_inventario FROM tbl_inventario 
INNER JOIN tbl_inv_productos ON tbl_inventario.prod_id=tbl_inv_productos.prod_id 
WHERE inv_can>inv_sal GROUP BY tbl_inventario.prod_id ORDER BY tbl_inv_productos.tip_cod DESC
";
$RSc = mysql_query($query_RSc) or die(mysql_error());
$row_RSc = mysql_fetch_assoc($RSc);
$totalRows_RSc = mysql_num_rows($RSc); ?>
<?php if($totalRows_RSc>0){ ?>
<table class="table table-bordered">
    <thead>
    <tr>
    	<th rowspan="2">ID</th>
        <th rowspan="2">COD</th>
        <th rowspan="2">Nombre</th>
        <th rowspan="2">Tipo</th>
        <th rowspan="2">Marca</th>
        <th rowspan="2">Cant</th>
        <th rowspan="2">Valor</th>
        <th rowspan="2">SubT</th>
        <th colspan="2">P1</th>
        <th colspan="2">P2</th>
        <th colspan="2">P3</th>
    </tr>
    <tr>
    	<th>%</th>
        <th>$</th>
        <th>%</th>
        <th>$</th>
        <th>%</th>
        <th>$</th>
    </tr>
    </thead>
    <tbody>
    <?php do{
	$detProdTip=detInvTip($row_RSc['tip_cod']);
	$detProdCat=detInvCat($detProdTip['cat_cod']);
	$detProdMar=detInvMar($row_RSc['mar_id']);	
	$detProd=detInvProd($row_RSc['prod_id']);
	
	$detProd_valInv=valInvUCom($row_RSc['prod_id'],0);
	
	$vstock=stock_existente_producto($row_RSc['prod_id']);
	$totExis=$totExis+$vstock;
	$vPrices=$vPricesD=NULL;
	$valorInventario;
	$P1=$detProd['pri_1'];
	$P2=$detProd['pri_2'];
	$P3=$detProd['pri_3'];
	unset($vP1,$vP2,$vP3,$pP1,$pP2,$pP3);
	if($P1){
		$pP1='<span>'.$P1.'</a> ';
		$vP1=' <span>'.valInvUCom($row_RSc['prod_id'],1).'</span>';
	}
	if($P2){
		$pP2='<span>'.$P2.'</a> ';
		$vP2=' <span>'.valInvUCom($row_RSc['prod_id'],2).'</span>';
	}
	if($P3){
		$pP3='<span>'.$P3.'</a>';
		$vP3=' <span>'.valInvUCom($row_RSc['prod_id'],3).'</span>';
	}
	?>
    <tr>
    	<td><?php echo $row_RSc['prod_id'] ?></td>
        <td><?php echo $detProd['prod_cod'] ?></td>
        <td><?php echo $detProd['prod_nom'] ?></td>
        <td><?php echo $detProdTip['tip_nom'] ?> / <?php echo $detProdCat['cat_nom'] ?></td>
        <td><?php echo $detProdMar['mar_nom'] ?></td>
        <td><?php echo $vstock ?></td>
        <td><?php echo $detProd_valInv ?></td>
        <td><?php echo $vstock*$detProd_valInv;	$valInvTot+=$vstock*$detProd_valInv; ?></td>
        <td><?php echo $pP1?></td>
        <td><?php echo $vP1?></td>
        <td><?php echo $vP2?></td>
        <td><?php echo $pP2?></td>
        <td><?php echo $vP3?></td>
        <td><?php echo $pP3?></td>
    </tr>
    <?php }while($row_RSc = mysql_fetch_assoc($RSc)); ?>
    </tbody>
    </table>
<table class="table table-condensed table-bordered">
<tr>
    <td><h4 class="text-center">Total Existencias</h4></td>
    <td><h4 class="text-center"><?php echo $totExis ?></h4></td>
    </tr>
<tr>
	<td><h4 class="text-center">Valoracion</h4></td>
    <td><h4 class="text-center"><?php echo $valInvTot ?></h4></td>
</tr>
</table>
<?php
}else{ echo '<div class="alert"><h4>Sin Existencia en Inventario</h4>Necesita Ingresar Compras</div>'; }
mysql_free_result($RSc); ?>
</div>