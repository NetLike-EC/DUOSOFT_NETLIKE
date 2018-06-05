<?php include('../../init.php');
$_SESSION['MODSEL']="INVP";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$query_RS_list_prod = "SELECT * FROM tbl_productos
LEFT JOIN tbl_prod_tipos ON tbl_productos.tip_cod=tbl_prod_tipos.tip_cod
LEFT JOIN tbl_prod_categorias ON tbl_prod_tipos.cat_cod=tbl_prod_categorias.cat_cod
LEFT JOIN tbl_marcas ON tbl_productos.mar_id=tbl_marcas.mar_id";
$RS_list_prod = mysql_query($query_RS_list_prod) or die(mysql_error());
$row_RS_list_prod = mysql_fetch_assoc($RS_list_prod);
$totalRows_RS_list_prod = mysql_num_rows($RS_list_prod);
include(RAIZf."head.php");
include(RAIZf.'fraTop.php'); ?>
<div class="container">
	<div class="row-fluid well well-sm">
    	<div class="span8"><?php include('productos_find_items.php'); ?></div>
        <div class="span4">
			<div class="pull-right">
            <a href="items_prod_form" rel="shadowbox" class="btn"><div><i class="icon-plus"></i><br />Nuevo</div></a>
            <a href="#" class="btn"><div><i class="icon-signal"></i><br />Estadísticas</div></a>
            </div>
        </div>
    </div>
<?php vLOG(); ?>
<div id="cont_inv">
<?php if($totalRows_RS_list_prod>0){ ?>
<table class="tablesorter" id="itm_table">
<thead>
	<tr>
        <th width="25">ID</th><th width="70">Marca</th><th width="75">Tipo</th><th>Descripcion</th><th width="70">Imagen</th><th width="50">Activo</th><th width="60">Accion</th>
	</tr>
</thead>
<tbody>
	<?php do { ?>
	  <tr>
        <td align="center"><?php echo $row_RS_list_prod['prod_id']; ?></td>
        <td><strong><?php echo $row_RS_list_prod['mar_nom']; ?></strong></td>
	    <td align="center">
		  <strong><?php echo $row_RS_list_prod['tip_nom']; ?></strong> </td>
        <td><a onClick="shadbox_open('items_prod_form.php', 'Modificar', '600', 'Modificar', '<?php echo $row_RS_list_prod['prod_id']; ?>')"><strong><?php echo $row_RS_list_prod['prod_nom']; ?></strong></a></td>
        <td align="center" style="padding:0px">
        
        <?php 
			if (isset($row_RS_list_prod['prod_img'])){ $file_find=RAIZ.'images/db/prod/'.$row_RS_list_prod['prod_img'];
			if (file_exists($file_find)){
		?>
        <a onClick="shadbox_pic(RAIZ+'images/db/prod/<?php echo $row_RS_list_prod['prod_img']; ?>', '<?php echo $row_RS_list_prod['mar_nom']; ?> <?php echo $row_RS_list_prod['tip_nom']; ?> <?php echo $row_RS_list_prod['prod_nom']; ?>')"><img src="<?php echo $RAIZ ?>images/db/prod/<?php echo $row_RS_list_prod['prod_img']; ?>" height="25" /></a>
        <?php } } ?>
        <td><?php fnc_status($row_RS_list_prod['prod_id'], $row_RS_list_prod['prod_stat'] ); ?></td>
        <td align="center">
        <a onClick="shadbox_open('items_prod_form.php', 'Modificar', '600', 'UPDATE', '<?php echo $row_RS_list_prod['prod_id']; ?>')">
        <img src="<?php echo $RAIZ; ?>images/struct/edit-16.png" width="16" height="16" /></a>&nbsp;
        <a onClick="cont_panel('_fncts.php?id_sel=<?php echo $row_RS_list_prod['prod_id']; ?>&action=DELETE', false)"><img src="<?php echo $RAIZ; ?>images/struct/Empty-Trash_16x16.png" width="16" height="16" border="0" /></a>        </td>
	    </tr>
	  <?php } while ($row_RS_list_prod = mysql_fetch_assoc($RS_list_prod)); ?>
</tbody>
</table>
<?php }else{ ?>
<div class="bord_gray_4cornes"><p class="infoa">No Existen Productos en Inventario</p></div>
<?php } ?>
</div>
</div>
</body>
<?php
mysql_free_result($RS_list_prod);
?>