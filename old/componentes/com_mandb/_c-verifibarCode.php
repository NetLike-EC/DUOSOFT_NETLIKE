<?php
$qry_vc='SELECT * FROM tbl_inv_productos WHERE prod_stat=1';
$RSvc=mysql_query($qry_vc)or(mysql_error());
$row_RSvc=mysql_fetch_assoc($RSvc);
$TR_Rsvc=mysql_num_rows($RSvc);
?>
<body class="cero">
<?php if($TR_Rsvc>0){ ?>
<div class="container-fluid">
<div class="page-header"><h1>tbl_inv_productos <small>Verificación de Codigo Generado</small></h1></div>
<div class="well well-small">
<table class="table">
<thead>
	<tr>
    <th>ID</th>
    <th>&nbsp;</th>
    <th>Producto</th>
    <th>Codigo</th>
    <th>BarCode</th>
    <th>Tipo / Categoria</th>
    <th>Marca</th>
    </tr>
</thead>
<tbody>
<?php do{ ?>
<?php
	$det_id=$row_RSvc['prod_id'];
	$det_cod=$row_RSvc['prod_cod'];
	$det_nom=$row_RSvc['prod_nom'];
	
	$detTip=detRow('tbl_inv_tipos','tip_cod',$row_RSvc['tip_cod']);
	$detTip_nom=$detTip['tip_nom'];
	$detCat=detRow('tbl_inv_categorias','cat_cod',$detTip['cat_cod']);
	$detCat_nom=$detCat['cat_nom'];
	$detMar=detRow('tbl_inv_marcas','mar_id',$row_RSvc['mar_id']);
	$detMar_nom=$detMar['mar_nom'];
	
	$detTipCat_nom='<small>'.$detTip_nom.' / '.$detCat_nom.'</small>';
	
	if(!$det_cod){
		$estCod='<span class="btn mini red">Codigo Generado</span>';
		$det_cod=$det_id.substr($detTip_nom, 0, 3);;
		$qry=sprintf('UPDATE tbl_inv_productos SET prod_cod=%s WHERE prod_id=%s',
		GetSQLValueString($det_cod,'text'),
		GetSQLValueString($det_id,'int'));
		if(@mysql_query($qry)){ $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;}
		else $LOG.='<h4>Error al Actualizar</h4>';
	}else $estCod='<span class="btn mini">Codigo Existente</span>';	
	createImagesIDBarCode($det_cod,NULL,RAIZidb.'barcode_prod/','.jpg');
	$det_imgbc='<img src="'.$RAIZidb.'barcode_prod/'.$det_cod.'.jpg" class="img-polaroid" />';
?>
<tr>
	<td><?php echo $det_id ?></td>
    <td><?php echo $estCod ?></td>
    <td><?php echo $det_nom ?></td>
    <td><?php echo $det_cod ?></td>
    <td><?php echo $det_imgbc ?></td>
    <td><?php echo $detTipCat_nom ?></td>
    <td><?php echo $detMar_nom ?></td>
</tr>
<?php }while($row_RSvc=mysql_fetch_assoc($RSvc)); ?>
</tbody>
</table>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>No hay productos activos para Verificar !</h4></div>';} ?>
</body>
</html>