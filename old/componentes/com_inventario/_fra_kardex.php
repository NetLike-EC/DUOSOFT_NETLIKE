<?php
$id=vParam('id', $_GET['id'], $_POST['id']);
$detProd=detRow('tbl_inv_productos','prod_id',$id);
$detProd_cod=$detProd['prod_cod'];
$detProd_nom=$detProd['prod_nom'];
$detProd_img=$detProd['prod_img'];
$viewImage=fnc_image_exist('db/prod/',$detProd_img,TRUE);
$viewImage='<a class="fancybox-button" data-rel="fancybox-button" href="'.$viewImage['norm'].'">
<img src="'.$viewImage['thumb'].'" class="img-sm img-rounded"/></a>';

$detProdTip=detRow('tbl_inv_tipos','tip_cod',$detProd['tip_cod']);
$detProdCat=detRow('tbl_inv_categorias','cat_cod',$detProdTip['cat_cod']);
$detProdMar=detRow('tbl_inv_marcas','mar_id',$detProd['mar_id']);


$query_RSi = sprintf("SELECT * FROM tbl_inventario WHERE prod_id=%s",
GetSQLValueString($id,'int'));
$RSi = mysql_query($query_RSi) or die(mysql_error());
$row_RSi = mysql_fetch_assoc($RSi);
$totalRows_RSi = mysql_num_rows($RSi);
if($totalRows_RSi>0){
$pages = new Paginator;
	$pages->items_total = $totalRows_RSi;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSip = mysql_query($query_RSi.' '.$pages->limit) or die(mysql_error());
	$row_RSip = mysql_fetch_assoc($RSip);
	$totalRows_RSip = mysql_num_rows($RSip);
	$viewPaginator='
	<div class="pag_port_tit">
		<span class="pagination"><ul>'.$pages->display_pages().'</ul></span>
		<span class="pull-right">'.$pages->display_items_per_page().'</span>
	</div>';
?>
<table class="table table-bordered">
    	<tr>
        	<td rowspan="2">
            	<?php echo $viewImage?>
            </td>
            <td><strong><?php echo $detProd_nom?></strong> <span class="label">Codigo</span> <strong><?php echo $detProd_cod?></strong></td>
            <td rowspan="2">Mas Info</td>
        </tr>
        <tr>
        	<td>
			<table class="table table-condensed" style="margin:0">
                <tr>
                	<td><span class="label">Marca</span> <?php echo $detProdMar['mar_nom']?></td>
                    <td><span class="label">Tipo</span> <?php echo $detProdTip['tip_nom']?></td>
                    <td><span class="label">Categoria</span> <?php echo $detProdCat['cat_nom']?></td>
                </tr>
            </table>
			 
            </td>
        </tr>
    </table>
<table class="table table-bordered table-condensed table-striped table-advance">
    <thead>
    <tr>
    	<th>ID</th>
        <th>Fecha</th>
        <th>N. Compra</th>
        <th>Cantidad Ingresada</th>
        <th>Valor Neto</th>
        <th>Subtotal</th>
        <th>Cantidad Sale</th>
        <th>Existencia</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    <?php do{
	
	$row_RSip_id=$row_RSip['inv_id'];
	$row_RSip_prod=$row_RSip['prod_id'];
	$row_RSip_val=$row_RSip['inv_val'];
	$row_RSip_can=$row_RSip['inv_can'];
	$sumCC+=$row_RSip_can;
	$row_RSip_sal=$row_RSip['inv_sal'];
	$row_RSip_est=$row_RSip['inv_est'];
	$sumC+=($row_RSip_can*$row_RSip_val);
	
	$detCD=detRow('tbl_compra_det','inv_id',$row_RSip['inv_id']);
	$detC=detRow('tbl_compra_cab','com_num',$detCD['com_num']);
	$detA=detAud($detC['aud_id']);
	
	
	if($row_RSip_est==1){
		$val_est='<span class="label label-primary">Activo</span>';
	}else if($row_RSip_est==0){
		$val_est='<span class="label label-warning">Anulado</span>';
	}else{
		$val_est='<span class="label label-danger">Error Contacte con desarrollador</span>';
	}
	$vstock=stock_existente_producto($row_RSip_prod);
	$sExis+=($row_RSip_can-$row_RSip_sal)*$row_RSip_val;
	$detInvING=detRow('tbl_compra_det','inv_id',$row_RSip_id);
	$qryinvSAL=sprintf('SELECT * FROM tbl_venta_cab 
	INNER JOIN tbl_venta_det ON tbl_venta_cab.ven_num=tbl_venta_det.ven_num 
	WHERE inv_id=%s',
	GetSQLValueString($row_RSip_id,'int'));
	$RSis=mysql_query($qryinvSAL) or die(mysql_error());
	$row_RSis=mysql_fetch_assoc($RSis);
	$trRSis=mysql_num_rows($RSis);
	?>
    <tr>
    	<td><?php echo $row_RSip_id ?></td>
        <td><?php echo $detA['aud_dat'] ?></td>
        <td><?php echo $detC['com_num'] ?></td>
        <td><?php echo $row_RSip_can ?></td>
        <td><?php echo $row_RSip_val ?></td>
        <td><?php echo $row_RSip_can*$row_RSip_val ?></td>
        <td><?php echo $row_RSip_sal ?>
        <?php if($trRSis>0){ ?>
        <table class="table table-bordered table-condensed">
        	<tr>
            <th>Fecha</th>
            <th>N. Venta</th>
            <th>Salida</th>
            <th>Valor U Neto</th>
            <th>Subtotal</th>
            </tr>
			<?php do{
			$row_RSis_ven_num=$row_RSis['ven_num'];
			$row_RSis_ven_can=$row_RSis['ven_can'];
			$sumCV+=$row_RSis_ven_can;
			$row_RSis_ven_pre=$row_RSis['ven_pre'];
			$row_RSis_ven_aud=$row_RSis['aud_id'];
			$sumV+=$row_RSis_ven_pre*$row_RSis_ven_can;
			$detAud=detRow('tbl_auditoria','aud_id',$row_RSis_ven_aud);
			?>
            <tr>
            <td><?php echo $detAud['aud_dat'] ?></td>
            <td><?php echo $row_RSis_ven_num ?></td>
            <td><?php echo $row_RSis_ven_can ?></td>
            <td><?php echo $row_RSis_ven_pre ?></td>
            <td><?php echo ($row_RSis_ven_pre*$row_RSis_ven_can) ?></td>
            </tr>
            <?php }while($row_RSis=mysql_fetch_assoc($RSis)); ?>
        </table>
        <?php } ?>
        </td>
        <td><?php echo $row_RSip_can-$row_RSip_sal ?></td>
        
        <td><?php echo $val_est ?></td>
    </tr>
    <?php }while($row_RSip = mysql_fetch_assoc($RSip)); ?>
    <tr class="text-center">
    <td colspan="3"><h3>Total Existencias <?php echo $vstock ?><br>
    Valor Inventario. <?php echo $sExis ?></h3></td>
    <td colspan="3"><h4>Total Compras <strong><?php echo $sumC ?></strong><br>(<?php echo $sumCC?> unidades)</h4></td>
    <td colspan="3"><h4>Total Ventas <strong><?php echo $sumV ?></strong><br>(<?php echo $sumCV?> unidades)</h4></td>
    </tr>
    <tr>
    	<td colspan="3"><h4>Ganacia <strong><?php if(($sumV-$sumC)>=0) echo $sumV-$sumC ?></strong></h4></td>
    </tr>
    </tbody>
    </table>
<div class="well well-small"><?php echo $viewPaginator ?></div>
<?php
}else{ echo '<div class="alert"><h4>Sin Existencia en Inventario</h4>Necesita Ingresar Compras</div>'; }
mysql_free_result($RSip); ?>