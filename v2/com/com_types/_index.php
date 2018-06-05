<?php
$rTyp=vParam('ref',$_GET['ref'],$_POST['ref']);

if($rTyp){
	$pTyp=' AND typ_ref="'.$rTyp.'"';//Parametro para SQL
	$uTyp='&ref='.$rTyp;//Parametro para URL
}

$qry='SELECT * FROM db_types WHERE 1=1 '.$pTyp.' ORDER BY typ_cod DESC';
$RSt=mysql_query($qry);
$trRSt=mysql_num_rows($RSt);

$qryLT='SELECT DISTINCT(typ_ref) AS sVAL, typ_ref AS sID FROM db_types';
$RSlt=mysql_query($qryLT);


?>
<div class="well well-sm">
<a href="form.php?<?php echo $uTyp ?>" class="btn btn-primary btn-xs pull-right fancybox.iframe fancyreload"><span class="fa fa-plus"></span> Nuevo Tipo</a>
<form class="form-inline">
	<span class="label label-default">Filtros</span> 
    <label class="control-label">Referencia</label>
	<?php genSelect('typ_cod',$RSlt,$rTyp,' form-control input-sm', NULL, NULL, 'Todos'); ?>
</form>
</div>
<? if($trRSt>0){
$pages = new Paginator;
$pages->items_total = $trRSt;
$pages->mid_range = 8;
$pages->paginate();
$query_RSlist = 'SELECT * FROM db_types ORDER BY typ_cod DESC '.$pages->limit;
$RSlist = mysql_query($qry) or die(mysql_error());
$row_RSlist = mysql_fetch_assoc($RSlist);
$totalRows_RSlist = mysql_num_rows($RSlist);

?>
<div>

<?php sLOG('g');
?>
<div class="well well-sm">

<div class="row">
		<div class="col-sm-8"><ul class="pagination cero"><?php echo $pages->display_pages() ?></ul></div>
		<div class="col-sm-4"><?php echo $pages->display_items_per_page() ?></div>
	</div>

</div>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Módulo</th>
    <th>Ref</th>
    <th>Nombre</th>
    <th>Valor</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$row_cod=$row_RSlist['typ_cod'];
	$row_mref=$row_RSlist['mod_ref'];
	$row_ref=$row_RSlist['typ_ref'];
	$row_nom=$row_RSlist['typ_nom'];
	$row_val=$row_RSlist['typ_val'];
	$row_stat=$row_RSlist['typ_stat'];
	//$status=fnc_status($row_cod,$row_stat,'fncts.php','STAT');
	?>
	  <tr>
        <td><?php echo $row_cod ?></td>
		<td><?php echo $status ?></td>
        <td><?php echo $row_mref ?></td>
        <td><?php echo $row_ref ?></td>        
        <td><?php echo $row_nom ?></td>
        <td><?php echo $row_val ?></td>
        <td><div class="btn-group">
          <a href="form.php?id=<?php echo $row_cod ?>" class="btn btn-info btn-xs">
            <span class="icon-edit"></span> Edit</a>
          <a href="fncts.php?id=<?php echo $row_cod ?>&acc=DEL&url=<?php echo $urlc.$uTyp ?>" class="btn btn-danger btn-xs">
            <span class="icon-trash"></span> Del</a></div>
        </td>
	    </tr>
	  <?php } while ($row_RSlist = mysql_fetch_assoc($RSlist)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
<script type="text/javascript">
	$("#typ_cod").change(function(){
	window.location.href = "?ref="+$("#typ_cod").val();
    //alert("The text has been changed.");
});
</script>