<?php
$id=vParam('id',$_GET['id'],$_POST['id']);
$detVenta=detRow('tbl_venta_cab','ven_num',$id);
$detUser=fnc_dataUser($_SESSION['MM_Username']);
$detEmp=detEmpPer($detUser['emp_cod']);
$detEmp_name=$detEmp['per_nom'].' '.$detEmp['per_ape'];
						
$query_RS_det = sprintf("SELECT * FROM tbl_venta_det WHERE tbl_venta_det.ven_num=%s", GetSQLValueString($id, "int"));
$RS_det = mysql_query($query_RS_det) or die(mysql_error());
$row_RS_det = mysql_fetch_assoc($RS_det);
$totalRows_RS_det = mysql_num_rows($RS_det);
?>
<div class="container-fluid">
<h3 class="page-title"><?php echo $rowMod['mod_nom']?> <small><?php echo $rowMod['mod_des']?></small></h3>

<ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="<?php echo $RAIZc ?>com_index/index.php">Inicio</a> 
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <i class="icon-table"></i>
            <a href="<?php echo $RAIZc ?>com_ventas/index.php">Listado Ventas</a> 
            <span class="icon-angle-right"></span>
        </li>
        <li class="muted">Venta #: <?php echo $detVenta['id']; ?></li>
    </ul>
<?php echo sLOG(); ?>
<?php
$detFac=detRow('tbl_factura_ven','ven_num',$id);
if($detFac){ ?>
<div class="well well-sm">
	<div class="btn-group">
    	<a class="btn">Factura</a>
        <a class="btn blue"><?php echo $detFac['fac_num'] ?></a>
        <a class="fancybox fancybox.iframe btn blue" href="print_fac.php?id=<?php echo $detFac['id'] ?>"><i class="icon-print"></i> Imprimir</a>
    </div>
</div>
<?php } ?>



<div class="portlet box blue">
	<div class="portlet-title">
	<h4><i class="icon-shopping-cart"></i> Detalle de la Venta 
    <span class="label label-info">N° <?php echo $detVenta['ven_num']; ?></span>
    <span class="label label-info"><?php echo $detVenta['com_fec_ing']; ?></span> 
    <span class="label label-info"><?php echo $detEmp_name; ?></span>
    </h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
								</div>
							</div>
	<div class="portlet-body">
		<table class="table table-striped table-bordered table-advance">
          <thead>
			<tr>
                <th>ID</th>
                <th><i class="icon-tags"></i> Marca</th>
                <th><i class="icon-th"></i> Tipo</th>
                <th><i class="icon-columns"></i> Producto</th>
                <th>Cantidad</th>
                <th>Valor</th>
                <th><i class="icon-shopping-cart"></i> Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php do {
			$inv_id=$row_RS_det['inv_id'];
			$detInv=detRow('tbl_inventario','inv_id',$inv_id);
			//$detProd=detRow('tbl_inv_productos','prod_id',$detInv['prod_id']);
			
			$detProd=detProdAll($detInv['prod_id']);
			$linePre=number_format($row_RS_det['ven_pre'],5,'.','');
			$lineCan=$row_RS_det['ven_can'];
			$lineSubt=$lineCan*$linePre;
			$lineSubt=number_format($lineSubt,5,'.','');
			$linePre=number_format($linePre,5);
			$subtotal=$subtotal+$lineSubt;
			?>
            <tr>
                <td><?php echo $row_RS_det['prod_id']; ?></td>
                <td><?php echo $detProd['mar_nom']; ?></td>
                <td><?php echo $detProd['tip_nom']; ?></td>
                <td><?php echo $detProd['prod_nom']; ?></td>
                <td><?php echo $lineCan; ?></td>
                <td><?php echo $linePre; ?></td>
                <td><?php echo $lineSubt; ?></td>
			</tr>
              <?php } while ($row_RS_det = mysql_fetch_assoc($RS_det)); ?>
          </tbody>
        </table>
        <?php
        $com_subtotal=number_format($subtotal,2,'.','');
		$com_iva=$com_subtotal*$_SESSION['conf']['taxes']['iva_si'];
		$com_iva=number_format($com_iva,2,'.','');
		$com_total=$com_subtotal+$com_iva;
		$com_total=number_format($com_total,2,'.','');
		
		?>
		<table class="table table-striped table-bordered table-advance">
            	<tr>
                	<td><h4><span class="label label-info">Subtotal</span> <?php echo $com_subtotal; ?></h4></td>
                    <td><h4><span class="label label-info">I.V.A.</span> <?php echo $com_iva ?></h4></td>
                    <td><h4><span class="label label-important">TOTAL</span> <?php echo $com_total ?></strong></h4></td>
                </tr>
                
                
          </table>
    </div>
</div>
</div>
<?php mysql_free_result($RS_det); ?>