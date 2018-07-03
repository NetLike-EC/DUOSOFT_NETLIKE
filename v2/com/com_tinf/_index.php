<?php
$est=vParam('est',$_GET['est'],$_POST['est']);

switch($est){
	case "1":
		$param=$param=' WHERE status=1';
		break;
	case "0":
		$param=$param=' WHERE status=0';
		break;
	default:
		break;
}
if($est) $param=' WHERE status='.$est;


$query_RSd=sprintf('SELECT * FROM db_tratamiento_infertilidad '.$param.' ORDER BY id_ti DESC');
//echo $query_RSd;
$RSt = mysql_query($query_RSd) or die(mysql_error());
$row_RSt = mysql_fetch_assoc($RSt);
$totalRows_RSt = mysql_num_rows($RSt); ?>

<div class="well well-sm">
<fieldset class="form-inline">
		<span class="label label-primary">Resultados <?php echo $totalRows_RSt?></span> 
        <span class="label label-default">Filtros</span>
        <div class="form-group">
            <label for="typ_cod">Estado</label>
            <?php //genSelect('typ_cod',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TIPEXAM'),$idTyp,' form-control input-sm', NULL, NULL, 'Todos'); ?>
            <select name="est" id="est" class="form-control input-sm">
            	<option value="">Todos</option>
                <option value="1" <?php if($est=='1') echo 'selected="selected"' ?>>ACTIVOS</option>
                <option value="0" <?php if($est=='0') echo 'selected="selected"' ?>>INACTIVOS</option>
            </select>
          </div>
        </fieldset>
</div>

<? if ($totalRows_RSt>0) {
$pages = new Paginator;
	$pages->items_total = $totalRows_RSt;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSd = mysql_query($query_RSd.' '.$pages->limit) or die(mysql_error());
	$row_RSd = mysql_fetch_assoc($RSd);
	$totalRows_RSd = mysql_num_rows($RSd);
?>
<table id="mytable" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
    	<th>ID</th>
		<th><abbr title="Fecha Registro">Fecha</abbr></th>
        <th><abbr title="Fecha Inicio">Inicio</abbr></th>
		<th><abbr title="Fecha Fin">Finaliza</abbr></th>
    	<th>Nombres</th>
        <th>Apellidos</th>
        <th>Tipo Tratamiento</th>
        <th>Donante</th>
        <th>Estado</th>
        <th></th>
	</tr>
</thead>
<tbody> 
	<?php do{?>
	<?php
	$detPac=detRow('db_clientes','cli_id',$row_RSd['cli_id']);
	$detTT=detRow('db_types','typ_cod',$row_RSd['typ_cod']);
	if($row_RSd['status']==1) $btnStatTI='<span class="label label-success">Activo</a>';
	else $btnStatTI='<span class="label label-warning">Finalizado</a>';
	?>
    <tr>
    	<td><?php echo $row_RSd['id_ti'] ?></td>
			<td><?php echo $row_RSd['date'] ?></td>
            <td><?php echo $row_RSd['datei'] ?></td>
            <td><?php echo $row_RSd['datef'] ?></td>
			<td><?php echo strtoupper($detPac['cli_nom'])?></td>
			<td><?php echo strtoupper($detPac['cli_ape'])?></td>
            <td><?php echo $detTT['typ_val'] ?></td>
            <td><?php echo $row_RSd['donante'] ?></td>
            <td><?php echo $btnStatTI ?></td>
            <td>
            <a class="btn btn-info btn-xs fancyreload fancybox.iframe" href="form.php?id=<?php echo $row_RSd['id_ti'];?>">
        	<i class="fa fa-edit fa-lg"></i> Editar</a>
            
            <a class="btn btn-default btn-xs" href="gest.php?id=<?php echo $row_RSd['cli_id'];?>">
        	<i class="fa fa-history"></i> Historial</a>
            </td>
    	</tr>
    <?php } while ($row_RSd = mysql_fetch_assoc($RSd)); ?>
</tbody>
</table>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-8">
			<ul class="pagination" style="margin:2px;"><?php echo $pages->display_pages(); ?></ul>
    	</div>
        <div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
    </div>
<?php mysql_free_result($RSd);?>
<?php }else{
	echo '<div class="alert alert-warning"><h4>Sin Coincidencias de Busqueda</h4></div>';
} ?>
<script type="text/javascript">
	$("#est").change(function(){
	window.location.href = "?est="+$("#est").val();
    //alert("The text has been changed.");
});
</script>