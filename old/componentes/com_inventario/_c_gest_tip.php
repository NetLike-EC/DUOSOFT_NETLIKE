<?php
$query_RSl='SELECT * FROM tbl_inv_tipos ORDER BY tip_cod DESC';
$RSlt = mysql_query($query_RSl) or die(mysql_error());
$row_RSlt = mysql_fetch_assoc($RSlt);
$totalRows_RSlt = mysql_num_rows($RSlt);
if ($totalRows_RSlt>0) {
$pages = new Paginator;
	$pages->items_total = $totalRows_RSlt;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSl = mysql_query($query_RSl.' '.$pages->limit) or die(mysql_error());
	$row_RSl = mysql_fetch_assoc($RSl);
	$totalRows_RSl = mysql_num_rows($RSl);
	$viewPaginator='
	<div class="pag_port_tit">
		<span class="pagination"><ul>'.$pages->display_pages().'</ul></span>
		<span class="pull-right">'.$pages->display_items_per_page().'</span>
	</div>';
}
$ms='mitip';?>
<div class="container-fluid">
<?php include('_fra_top.php');
sLOG('g');?>
<div class="portlet box <?php echo $iColor ?>">
<div class="portlet-title">
	<div class="row-fluid">
    	<div class="span4"><h4><i class="<?php echo $btn1_ico ?>"></i> Listado</h4></div>
        <div class="span8"><?php echo $viewPaginator ?></div>
    </div>
</div>
<div class="portlet-body">
<?php if($totalRows_RSl>0){ ?>
<table class="table table-bordered table-condensed table-hover" id="itm_table">
<thead>
	<tr>
        <th>ID</th>
        <th>Activo</th>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Categoria</th>
        <th></th>
	</tr>
</thead>
<tbody>
	<?php do {
	$detTipCat=detInvCat($RSlt['cat_cod']);
	?>
	<tr>
		<td><?php echo $row_RSl['tip_cod']; ?></td>
		<td><?php echo fnc_status($row_RSl['tip_cod'],$row_RSl['tip_stat'],'_fncts.php'); ?></td>
		<td><a href="inv_form_tip.php?id=<?php echo $row_RSl['tip_cod']; ?>"><?php echo $row_RSl['tip_nom']; ?></a></td>
		<td><?php echo $row_RSl['tip_des']; ?></td>
		<td><?php echo $detTipCat['cat_nom']?></td>
		<td align="center">
		<div class="btn-group list">
			<a href="inv_form_tip.php?id=<?php echo $row_RSl['tip_cod']; ?>" class="btn mini blue"><i class="icon-edit"></i> Editar</a>
			<a href="_fncts.php?id=<?php echo $row_RSl['tip_cod'];?>&action=DELETE" class="btn mini red" onClick="return aconfirm('DEL')">
			<i class="icon-trash"></i> Eliminar</a>
		</div>
		</td>
	</tr>
	  <?php } while ($row_RSl = mysql_fetch_assoc($RSl)); ?>
</tbody>
</table>
<div class="well"><?php echo $viewPaginator ?></div>
<?php mysql_free_result($RSl); ?>
<?php }else{ echo '<div class="alert alert-error"><h4>No Existen Tipos de Productos</h4></div>';
} ?>
</div>
</div>
</div>