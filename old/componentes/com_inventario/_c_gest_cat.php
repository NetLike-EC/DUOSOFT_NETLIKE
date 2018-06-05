<?php
$query_RSc='SELECT * FROM tbl_inv_categorias ORDER BY cat_cod DESC';
$RSct = mysql_query($query_RSc) or die(mysql_error());
$row_RSct = mysql_fetch_assoc($RSct);
$totalRows_RSct = mysql_num_rows($RSct);

if ($totalRows_RSct>0) {
$pages = new Paginator;
	$pages->items_total = $totalRows_RSct;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSc = mysql_query($query_RSc.' '.$pages->limit) or die(mysql_error());
	$row_RSc = mysql_fetch_assoc($RSc);
	$totalRows_RSc = mysql_num_rows($RSc);
	$viewPaginator='
	<div class="pag_port_tit">
		<span class="pagination"><ul>'.$pages->display_pages().'</ul></span>
		<span class="pull-right">'.$pages->display_items_per_page().'</span>
	</div>';
}
$ms='micat';?>
<div class="container-fluid">
<?php include('_fra_top.php'); 
sLOG('g'); ?>
<div class="portlet box <?php echo $iColor ?>">
<div class="portlet-title">
	<div class="row-fluid">
    	<div class="span4"><h4><i class="<?php echo $btn1_ico ?>"></i> Listado</h4></div>
        <div class="span8"><?php echo $viewPaginator ?></div>
    </div>
</div>
<div class="portlet-body">
<?php if($totalRows_RSc>0){ ?>
<table class="table table-bordered table-condensed table-hover" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th>Activo</th>
    <th>Nombre</th>
    <th>Descripcion</th>
    <th>Tipos</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
		$query = "SELECT * FROM tbl_inv_tipos WHERE cat_cod=".$row_RSc['cat_cod'];
		$RS_cant_tip = mysql_query($query) or die(mysql_error());
		$totalRows_RS_can_tip = mysql_num_rows($RS_cant_tip);
		mysql_free_result($RS_cant_tip);
	?>
	  <tr>
        <td><?php echo $row_RSc['cat_cod']; ?></td>
        <td><?php echo fnc_status($row_RSc['cat_cod'],$row_RSc['cat_stat'],'_fncts.php'); ?></td>
	    <td><a href="inv_form_cat.php?id=<?php echo $row_RSc['cat_cod']; ?>"><?php echo $row_RSc['cat_nom']; ?></a></td>
	    <td><?php echo $row_RSc['cat_des']; ?></td>
		<td><?php echo $totalRows_RS_can_tip; ?></td>
        <td>
        <div class="btn-group list">
        <a href="inv_form_cat.php?id=<?php echo $row_RSc['cat_cod']; ?>"class="btn mini blue"><i class="icon-edit"></i> Editar</a>
        <a href="_fncts.php?id=<?php echo $row_RSc['cat_cod']; ?>&action=DELETE" class="btn mini red" onClick="return aconfirm('DEL')"><i class="icon-trash"></i> Eliminar</a>
        </div>
        </td>
	    </tr>
	  <?php } while ($row_RSc = mysql_fetch_assoc($RSc)); ?>
</tbody>
</table>
<div class="well"><?php echo $viewPaginator ?></div>
<?php mysql_free_result($RSc);?>
<?php }else{ echo '<div class="alert alert-error"><h4>No Existen Categorias Principales</h4></div>';
} ?>
</div>
</div>
</div>