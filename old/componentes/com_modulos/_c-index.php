<?php
$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_modules';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
if($row_RSpg['TR']>0){
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RSlist = "SELECT * FROM tbl_modules ORDER BY mod_cod DESC ".$pages->limit;
$RSlist = mysql_query($query_RSlist) or die(mysql_error());
$row_RSlist = mysql_fetch_assoc($RSlist);
$totalRows_RSlist = mysql_num_rows($RSlist);

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
		<a href="#" class="btn blue big"><strong><?php echo fnc_TotMod() ?></strong> Modulos <i class="icon-user"></i></a>
		<a href="form.php" class="btn green big" rel="shadowbox;options={relOnClose:true}"><span class="icon-plus"></span> Nuevo</a>
    </div>

</div>

<?php fnc_log();
if($totalRows_RSlist>0){ ?>
<div class="well well-small"><?php echo $viewPaginator ?></div>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Ref</th>
    <th>Name</th>
    <th>Description</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$modCod=$row_RSlist['mod_cod'];
	$modNom=$row_RSlist['mod_nom'];
	$modRef=$row_RSlist['mod_ref'];
	$modDes=$row_RSlist['mod_des'];
	$status=$row_RSlist['mod_stat'];
	$status=fnc_status($modCod,$status,'fncts.php','STAT');
	?>
	  <tr>
        <td><?php echo $modCod ?></td>
		<td><?php echo $status ?></td>
        <td><?php echo $modRef ?></td>
        <td><a href="form.php?id=<?php echo $modCod ?>" rel="shadowbox[CAT];options={relOnClose:true}"><?php echo $modNom ?></a></td>
        <td><?php echo $modDes ?></td>
        <td><div class="btn-group">
          <a href="form.php?id=<?php echo $modCod ?>" rel="shadowbox[CATb];options={relOnClose:true}" class="btn blue mini">
            <span class="icon-edit"></span> Edit</a>
          <a href="fncts.php?id=<?php echo $modCod ?>&action=DEL" class="btn red mini">
            <span class="icon-trash"></span> Del</a></div>
        </td>
	    </tr>
	  <?php } while ($row_RSlist = mysql_fetch_assoc($RSlist)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</html>