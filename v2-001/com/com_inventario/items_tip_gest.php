<?php include('../../init.php');
$_SESSION['MODSEL']="INVT";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$query_RS_list_tip = "SELECT * FROM tbl_prod_tipos";
$RS_list_tip = mysql_query($query_RS_list_tip) or die(mysql_error());
$row_RS_list_tip = mysql_fetch_assoc($RS_list_tip);
$totalRows_RS_list_tip = mysql_num_rows($RS_list_tip);
include(RAIZf."head.php");
include(RAIZf.'fraTop.php'); ?>
<div id="cont_head_btns">
	<div class="btn_menu"><a onClick="alert('Estadisticas')"><div><img src="images/23_24x24.png" /><br />Estadisticas</div></a></div>
	<div class="btn_menu"><a onClick="shadbox_open('items_tip_form.php', 'Nuevo Tipo', '500', 'INSERT', '')"><div><img src="images/25_24x24.png" /><br />Nueva</div></a></div>
    <div style="clear:both;"></div>
</div>
<div id="log"><?php vLOG(); ?></div>
<div id="cont_inv">
<?php if($totalRows_RS_list_tip>0){ ?>
<table class="tablesorter" id="itm_table">
<thead>
	<tr>
        <th width="25">ID</th><th>Nombre</th><th>Descripcion</th><th width="75">Categoria</th><th width="50">Activo</th><th width="60">Accion</th>
	</tr>
</thead>
<tbody>
	<?php do { ?>
	  <tr>
        <td align="center"><?php echo $row_RS_list_tip['tip_cod']; ?></td>
	    <td><strong><?php echo $row_RS_list_tip['tip_nom']; ?></strong></td>
	    <td><?php echo $row_RS_list_tip['tip_des']; ?></td>
	    <td align="center">
		<?php 
		$query = "SELECT cat_nom FROM tbl_prod_categorias WHERE cat_cod=".$row_RS_list_tip['cat_cod'];
		$RS_cat_rel = mysql_query($query) or die(mysql_error());
		$row_RS_cat_rel = mysql_fetch_assoc($RS_cat_rel);
		$totalRows_RS_cat_rel = mysql_num_rows($RS_cat_rel);
		echo $row_RS_cat_rel['cat_nom'];
		?>
        </td>
        <td align="center"><?php fnc_status($row_RS_list_tip['tip_cod'],$row_RS_list_tip['tip_stat']); ?></td>
        <td align="center">
        <a onClick="shadbox_open('items_tip_form.php', 'Modificar', '500', 'UPDATE', '<?php echo $row_RS_list_tip['tip_cod']; ?>')">
        <img src="<?php echo $RAIZ; ?>images/struct/edit-16.png" width="16" height="16" /></a>&nbsp;
        <a onClick="cont_panel('_fncts.php?id_sel=<?php echo $row_RS_list_tip['tip_cod'];?>&action=DELETE', false)"><img src="<?php echo $RAIZ; ?>images/struct/Empty-Trash_16x16.png" width="16" height="16" border="0" /></a>
        </td>
	    </tr>
	  <?php } while ($row_RS_list_tip = mysql_fetch_assoc($RS_list_tip)); ?>
</tbody>
</table>
<?php }else{ ?>
<div class="bord_gray_4cornes"><p class="infoa">No Existen Tipos de Productos</p></div>
<?php } ?>
</div>
<?php
mysql_free_result($RS_list_tip);
?>