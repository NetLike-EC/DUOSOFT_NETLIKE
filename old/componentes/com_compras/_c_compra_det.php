<?php
$id_com=vParam('com_num',$_GET['com_num'],$_POST['com_num']);
$detCompra=fnc_dataCompra($id_com);

$detUser=fnc_dataUser($_SESSION['MM_Username']);
$detEmp=detEmpPer($detUser['emp_cod']);
$detEmp_name=$detEmp['per_nom'].' '.$detEmp['per_ape'];
						
$query_RS_com_det = sprintf("SELECT * FROM tbl_compra_det 
INNER JOIN tbl_inventario ON tbl_compra_det.inv_id=tbl_inventario.inv_id 
WHERE com_num=%s", GetSQLValueString($id_com, "int"));
$RS_com_det = mysql_query($query_RS_com_det) or die(mysql_error());
$row_RS_com_det = mysql_fetch_assoc($RS_com_det);
$totalRows_RS_com_det = mysql_num_rows($RS_com_det);
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
            <a href="<?php echo $RAIZc ?>com_compras/index.php">Listado Compras</a> 
            <span class="icon-angle-right"></span>
        </li>
        <li class="muted">Compra #: <?php echo $detCompra['com_num']; ?></li>
    </ul>
<?php echo fnc_log(); ?>
<div class="portlet box red">
	<div class="portlet-title">
	<h4><i class="icon-shopping-cart"></i> Detalle de la Compra 
    <span class="label label-important">N° <?php echo $detCompra['com_num']; ?></span>
    <span class="label label-important"><?php echo $detCompra['com_fec_ing']; ?></span> 
    <span class="label label-important"><?php echo $detEmp_name; ?></span>
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
			$detProd=detProdAll($row_RS_com_det['prod_id']);
			$linePre=number_format($row_RS_com_det['inv_val'],5,'.','');
			$lineCan=$row_RS_com_det['inv_can'];
			$lineSubt=$lineCan*$linePre;
			$lineSubt=number_format($lineSubt,5,'.','');
			$linePre=number_format($linePre,5);
			$subtotal=$subtotal+$lineSubt;
			?>
            <tr>
                <td><?php echo $row_RS_com_det['prod_id']; ?></td>
                <td><?php echo $detProd['mar_nom']; ?></td>
                <td><?php echo $detProd['tip_nom']; ?></td>
                <td><?php echo $detProd['prod_nom']; ?></td>
                <td><?php echo $row_RS_com_det['inv_can']; ?></td>
                <td><?php echo $row_RS_com_det['inv_val']; ?></td>
                <td><?php echo $lineSubt; ?></td>
			</tr>
              <?php } while ($row_RS_com_det = mysql_fetch_assoc($RS_com_det)); ?>
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
<?php mysql_free_result($RS_com_det); ?>