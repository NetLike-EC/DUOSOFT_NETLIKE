<?php
$query_RSm='SELECT * FROM tbl_inv_marcas ORDER BY mar_id DESC';
$RSmt = mysql_query($query_RSm) or die(mysql_error());
$row_RSmt = mysql_fetch_assoc($RSmt);
$totalRows_RSmt = mysql_num_rows($RSmt);

if ($totalRows_RSmt>0) {
$pages = new Paginator;
	$pages->items_total = $totalRows_RSmt;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSm = mysql_query($query_RSm.' '.$pages->limit) or die(mysql_error());
	$row_RSm = mysql_fetch_assoc($RSm);
	$totalRows_RSm = mysql_num_rows($RSm);
	$viewPaginator='
	<div class="pag_port_tit">
		<span class="pagination"><ul>'.$pages->display_pages().'</ul></span>
		<span class="pull-right">'.$pages->display_items_per_page().'</span>
	</div>';
}
$ms='mimar';?>
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
<?php if($totalRows_RSm>0){ ?>
<table class="table table-bordered table-condensed table-hover">
<thead>
	<tr>
		<th width="30">ID</th>
        <th width="50">Activo</th>
		<th>Marca</th>
		<th>Accion</th>
	</tr>
</thead>
<tbody>
<?php do {
$status=fnc_status($row_RSm['mar_id'],$row_RSm['mar_stat'],'_fncts.php');
?>
<tr>
	<td><?php echo $row_RSm['mar_id']; ?></td>
    <td><?php echo $status; ?></td>
	<td><a href="inv_form_mar.php?id=<?php echo $row_RSm['mar_id']; ?>"><?php echo $row_RSm['mar_nom']; ?></a></td>
	<td>
		<div class="btn-group">
		<a href="inv_form_mar.php?id=<?php echo $row_RSm['mar_id']; ?>" class="btn mini blue">
		<i class="icon-edit"></i> Editar</a>
		<a href="_fncts.php?id=<?php echo $row_RSm['mar_id']; ?>&action=DELETE" class="btn mini red" onClick="return aconfirm('DEL')"><i class="icon-trash"></i> Eliminar</a>
        </div>
	</td>
</tr>
<?php } while ($row_RSm = mysql_fetch_assoc($RSm)); ?>
</tbody>
</table>
<div class="well"><?php echo $viewPaginator ?></div>
<?php mysql_free_result($RSm)?>
<?php }else{ echo '<div class="alert alert-error"><h4>No Existen Marcas</h4></div>'; } ?>
</div>
</div>
</div>