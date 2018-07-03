<?php include('../../init.php');
$_SESSION['MODSEL']="INVM";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$query_RS_list_mar = "SELECT * FROM tbl_marcas";
$RS_list_mar = mysql_query($query_RS_list_mar) or die(mysql_error());
$row_RS_list_mar = mysql_fetch_assoc($RS_list_mar);
$totalRows_RS_list_mar = mysql_num_rows($RS_list_mar);
include(RAIZf."head.php");
include(RAIZf.'fraTop.php'); ?>
<div id="cont_head_btns">
    <div class="btn_menu"><a onClick="alert('Estadisticas')"><div><img src="images/23_24x24.png" /><br />Estadisticas</div></a></div>
	<div class="btn_menu"><a onClick="shadbox_open('items_mar_form.php', 'Nueva Marca', '500', 'INSERT', '')"><div><img src="images/25_24x24.png" /><br />Nueva</div></a></div>
    <div style="clear:both;"></div>
</div>
<div id="log"><?php vLOG(); ?></div>
<div id="cont_inv">
<?php if($totalRows_RS_list_mar>0){ ?>
<table class="tablesorter" id="itm_table">
<thead>
	<tr>
        <th width="25">ID</th><th>Marca</th><th width="50">Activo</th><th width="60">Accion</th>
	</tr>
</thead>
<tbody>
	<?php do { ?>
	  <tr>
        <td align="center"><?php echo $row_RS_list_mar['mar_id']; ?></td>
        <td><strong><?php echo $row_RS_list_mar['mar_nom']; ?></strong></td>
        <td align="center">
		<?php fnc_status($row_RS_list_mar['mar_id'],$row_RS_list_mar['mar_stat']); ?></td>
        <td align="center">
        <a onClick="shadbox_open('items_mar_form.php', 'Modificar', '600', 'UPDATE', '<?php echo $row_RS_list_mar['mar_id']; ?>')">
        <img src="<?php echo $RAIZ; ?>images/struct/edit-16.png" width="16" height="16" /></a>&nbsp;
        <a onClick="cont_panel('_fncts.php?id_sel=<?php echo $row_RS_list_mar['mar_id']; ?>&action=DELETE', false)"><img src="<?php echo $RAIZ; ?>images/struct/Empty-Trash_16x16.png" width="16" height="16" border="0" /></a>        </td>
	    </tr>
	  <?php } while ($row_RS_list_mar = mysql_fetch_assoc($RS_list_mar)); ?>
</tbody>
</table>
<?php }else{ ?>
<div class="bord_gray_4cornes"><p class="infoa">No Existen Marcas</p></div>
<?php } ?>
</div>
<?php
mysql_free_result($RS_list_mar);
?>