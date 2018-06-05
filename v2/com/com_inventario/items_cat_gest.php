<?php include('../../init.php');
$_SESSION['MODSEL']="INVC";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$query_RS_list_cat = "SELECT * FROM tbl_prod_categorias";
$RS_list_cat = mysql_query($query_RS_list_cat) or die(mysql_error());
$row_RS_list_cat = mysql_fetch_assoc($RS_list_cat);
$totalRows_RS_list_cat = mysql_num_rows($RS_list_cat);
include(RAIZf."head.php");
include(RAIZf.'fraTop.php'); ?>
<div id="cont_head_btns">
	<div class="btn_menu"><a onClick="alert('Estadisticas')"><div><img src="images/23_24x24.png" /><br />Estadisticas</div></a></div>
	<div class="btn_menu"><a onClick="shadbox_open('items_cat_form.php', 'Nueva Categoria', '500', 'INSERT', '')"><div><img src="images/25_24x24.png" /><br />Nueva</div></a></div>
    <div style="clear:both;"></div>
</div>
<div id="log"><?php vLOG(); ?></div>
<div id="cont_inv">
    <?php if($totalRows_RS_list_cat>0){ ?>
<table class="tablesorter" id="itm_table">
<thead><tr>
	<th width="25">ID</th><th>Nombre</th><th>Descripcion</th><th width="50">Activo</th><th width="50">Tipos</th><th width="60">Accion</th>
</tr></thead>
<tbody>
	<?php do { ?>
	  <tr>
        <td align="center"><?php echo $row_RS_list_cat['cat_cod']; ?></td>
	    <td><strong><?php echo $row_RS_list_cat['cat_nom']; ?></strong></td>
	    <td><?php echo $row_RS_list_cat['cat_des']; ?></td>
	    <td align="center"><?php fnc_status($row_RS_list_cat['cat_cod'],$row_RS_list_cat['cat_stat']); ?></td>
		<td align="center">
		<?php 
		$query = "SELECT * FROM tbl_prod_tipos WHERE cat_cod=".$row_RS_list_cat['cat_cod'];
		$RS_cant_tip = mysql_query($query) or die(mysql_error());
		$totalRows_RS_can_tip = mysql_num_rows($RS_cant_tip);
		echo $totalRows_RS_can_tip;
		?>
        </td>
        <td align="center">
        <a onClick="shadbox_open('items_cat_form.php', 'Modificar', '500', 'UPDATE', '<?php echo $row_RS_list_cat['cat_cod']; ?>')">
        <img src="<?php echo $RAIZ; ?>images/struct/edit-16.png" width="16" height="16" /></a>&nbsp;
        <a onClick="cont_panel('_fncts.php?id_sel=<?php echo $row_RS_list_cat['cat_cod']; ?>&action=DELETE', false)"><img src="<?php echo $RAIZ; ?>images/struct/Empty-Trash_16x16.png" width="16" height="16" border="0" /></a>
        </td>
	    </tr>
	  <?php } while ($row_RS_list_cat = mysql_fetch_assoc($RS_list_cat)); ?>
</tbody>
</table>
<?php }else{ ?>
<div class="bord_gray_4cornes"><p class="infoa">No Existen Categorias Principales</p></div>
<?php } ?>
</div>
<?php
mysql_free_result($RS_list_cat);
?>