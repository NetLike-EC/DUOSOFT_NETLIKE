<?php
$query_pg = 'SELECT COUNT(*) AS TR FROM  tbl_menus_items';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
if($row_RSpg['TR']>0){
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RSd = 'SELECT * FROM  tbl_menus_items ORDER BY itemmenu_parent ASC, menu_id ASC, itemmenu_order ASC '.$pages->limit;
$RSd = mysql_query($query_RSd) or die(mysql_error());
$row_RSd = mysql_fetch_assoc($RSd);
$totalRows_RSd = mysql_num_rows($RSd);

$viewPaginator='
	<div class="pag_port_tit">
		<span class="pagination"><ul>'.$pages->display_pages().'</ul></span>
		<span class="pull-right">'.$pages->display_items_per_page().'</span>
	</div>';

}
?>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span8"><div class="page-title"><?php echo genPageTit(NULL,$rowMod['mod_nom'],$rowMod['mod_des'],NULL,NULL); ?></div></div>
    <div class="span4 text-right">
		<a href="#" class="btn blue big"><strong><?php echo fnc_TotMenuItems() ?></strong> Menus <i class="icon-user"></i></a>
		<a href="form_items.php" class="btn green big" rel="shadowbox;options={relOnClose:true}"><span class="icon-plus"></span> Nuevo</a>
    </div>

</div>
<?php sLOG('g');
if($totalRows_RSd>0){ ?>
<div class="well well-small"><?php echo $viewPaginator ?></div>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>MENU</th>
	<th>Padre</th>
    <th>Nombre</th>
    <th>Titulo</th>
    <th>Link</th>
    <th>Icon</th>
    <th>Orden</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$det_id=$row_RSd['itemmenu_id'];
	$det_menu=detRow('tbl_menus','menu_id',$row_RSd['menu_id']);
	$det_menu_nom=$det_menu['menu_nom'];
	$det_parent_id=$row_RSd['itemmenu_parent'];
	if($det_parent_id==0) $css_tr='info'; else unset($css_tr);
	$det_parent=detRow('tbl_menus_items','itemmenu_id',$det_parent_id);
	$det_parent_nom=$det_parent['itemmenu_nom'];
	$det_nom=$row_RSd['itemmenu_nom'];
	$det_tit=$row_RSd['itemmenu_tit'];
	$det_link=$row_RSd['itemmenu_link'];
	$det_icon=$row_RSd['itemmenu_icon'];
	$det_ord=$row_RSd['itemmenu_order'];
	$det_stat=$row_RSd['itemmenu_stat'];
	$status=fnc_status($det_id,$det_stat,'fncts.php','STATMI');
	?>
	  <tr class="<?php echo $css_tr ?>">
        <td><?php echo $det_id ?></td>
		<td><?php echo $status ?></td>
        <td><span class="label label-info"><?php echo $det_menu_nom ?></span></td>
		<td><?php echo $det_parent_nom ?></td>
        <td><?php echo $det_nom ?></td>
        <td><?php echo $det_tit ?></td>
        <td><?php echo $det_link ?></td>
        <td><?php echo $det_icon ?></td>
        <td><?php echo $det_ord ?></td>        
        <td><div class="btn-group">
          <a href="form_items.php?id=<?php echo $det_id ?>" rel="shadowbox[CATb];options={relOnClose:true}" class="btn blue mini">
            <span class="icon-edit"></span> Edit</a>
          <a href="fncts.php?id=<?php echo $det_id ?>&action=DELMI" class="btn red mini">
            <span class="icon-trash"></span> Del</a></div>
        </td>
	    </tr>
	  <?php } while ($row_RSd = mysql_fetch_assoc($RSd)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</html>