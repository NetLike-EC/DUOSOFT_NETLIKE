<?php
$query_RSc = "SELECT tbl_inv_productos.prod_id, tbl_inv_productos.mar_id, tbl_inv_productos.tip_cod, tbl_inv_productos.prod_img, SUM(inv_can-inv_sal) as stock_inventario FROM tbl_inventario 
INNER JOIN tbl_inv_productos ON tbl_inventario.prod_id=tbl_inv_productos.prod_id 
WHERE inv_can>inv_sal GROUP BY tbl_inventario.prod_id ORDER BY tbl_inv_productos.prod_id DESC
";
$RSc = mysql_query($query_RSc) or die(mysql_error());
$row_RSc = mysql_fetch_assoc($RSc);
$totalRows_RSc = mysql_num_rows($RSc);
if($totalRows_RSc>0){
	
$pages = new Paginator;
	$pages->items_total = $totalRows_RSc;
	$pages->mid_range = 8;
	$pages->paginate();
	$RScp = mysql_query($query_RSc.' '.$pages->limit) or die(mysql_error());
	$row_RScp = mysql_fetch_assoc($RScp);
	$totalRows_RScp = mysql_num_rows($RScp);
	$viewPaginator='
	<div class="pag_port_tit">
		<span class="pagination"><ul>'.$pages->display_pages().'</ul></span>
		<span class="pull-right">'.$pages->display_items_per_page().'</span>
	</div>';
?>
<div class="well well-small"><?php echo $viewPaginator ?></div>
<table class="table table-bordered table-condensed table-striped table-advance">
    <thead>
    <tr>
    	<th>ID</th>
        <th></th>
        <th>COD</th>
        <th>Nombre</th>
        <th>Tipo</th>
        <th>Marca</th>
        <th>Valor</th>
        <th>Precios</th>
        <th>Kardex</th>
        <th>Cant.</th>
    </tr>
    </thead>
    <tbody>
    <?php do{
	
	$row_RScp_id=$row_RScp['prod_id'];
	
	$detProdTip=detInvTip($row_RScp['tip_cod']);
	$detProdCat=detInvCat($detProdTip['cat_cod']);
	$detProdMar=detInvMar($row_RScp['mar_id']);	
	
	$detProd=detInvProd($row_RScp_id);
	$vstock=stock_existente_producto($row_RScp_id);
	$totExis=$totExis+$vstock;
	$viewImage=fnc_image_exist('db/prod/',$row_RScp['prod_img'],TRUE);
	$viewImage='<a class="fancybox-button" data-rel="fancybox-button" href="'.$viewImage['norm'].'" title="'.$detProd['prod_cod'].$detProd['prod_nom'].'">
	<img src="'.$viewImage['thumb'].'" class="img-mini img-rounded"/></a>';
	$vPrices=$vPricesD=NULL;
	$valorInventario;
	$P1=$detProd['pri_1'];
	$P2=$detProd['pri_2'];
	$P3=$detProd['pri_3'];
	if((isset($P1))||(isset($P2))||(isset($P3))){
	$vPrices.='<div class="btn-group row-fluid" style="margin:0px">';
	$vPricesD.='<div class="btn-group row-fluid" style="margin:0px">';
	if($P1){
		$vPrices.='<a class="btn mini black disabled">P1</a><a class="btn mini">'.$P1.'%</a>';
		$vPricesD.='<a class="btn mini black disabled">P1</a><a class="btn mini">'.valInvUCom($row_RScp_id,1).'</a>';
	}
	if($P2){
		$vPrices.='<a class="btn mini black disabled">P2</a><a class="btn mini">'.$P2.'%</a>';
		$vPricesD.='<a class="btn mini black disabled">P2</a><a class="btn mini">'.valInvUCom($row_RScp_id,2).'</a>';
	}
	if($P3){
		$vPrices.='<a class="btn mini black disabled">P3</a><a class="btn mini">'.$P3.'%</a>';
		$vPricesD.='<a class="btn mini black disabled">P3</a><a class="btn mini">'.valInvUCom($row_RScp_id,3).'</a>';
	}
	$vPrices.='</div>';
	$vPricesD.='</div>';
	}else{ 
		$vPrices='<a class="btn red mini disabled"><i class="icon-warning-sign"></i> Sin Precios</a>';
	}
	$prodLink_cod='<a href="inv_form_prod.php?id='.$row_RScp_id.'">'.$row_RScp_id.'</a>';
	$prodLink_nom='<a href="inv_form_prod.php?id='.$row_RScp_id.'">'.$detProd['prod_nom'].'</a>';
	?>
    <tr>
    	<td><?php echo $prodLink_cod ?></td>
        <td class="text-center"><?php echo $viewImage ?></td>
        <td><?php echo $detProd['prod_cod'] ?></td>
        <td><?php echo $prodLink_nom ?></td>
        <td><?php echo $detProdTip['tip_nom'] ?><span class="muted"> / <small><?php echo $detProdCat['cat_nom'] ?></small></span></td>
        <td><?php echo $detProdMar['mar_nom'] ?></td>
        <td></td>
        <td><?php echo $vPrices ?>
        <?php echo $vPricesD ?></td>
        <td><a class="btn" href="<?php echo $RAIZc ?>com_inventario/kardex.php?id=<?php echo $row_RScp_id ?>">Kardex</a></td>
        <th><?php echo $vstock ?></th>
    </tr>
    <?php }while($row_RScp = mysql_fetch_assoc($RScp)); ?>
    <tr>
    <td colspan="3"></td>
    <td><h4 class="text-center">Total Existencias</h4></td>
    <td><h4 class="text-center"><?php echo $totExis ?></h4></td>
    </tr>
    </tbody>
    </table>

<?php
}else{ echo '<div class="alert"><h4>Sin Existencia en Inventario</h4>Necesita Ingresar Compras</div>'; }
mysql_free_result($RScp); ?>