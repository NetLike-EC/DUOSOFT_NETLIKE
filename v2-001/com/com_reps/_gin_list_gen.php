<?php 
$TR=totRowsTab('db_rep_eco','1','1');
?>
<?php if ($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	//echo $query_RS.' '.$pages->limit.'<br >';
	$qry='SELECT * FROM  `db_rep_eco` ORDER BY id DESC';
	$RS = mysql_query($qry.' '.$pages->limit) or die(mysql_error());
	$dRS = mysql_fetch_assoc($RS);


$classlast=TRUE;
$classtr;
?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-2">
        <span class="label label-primary">Resultados <strong><?php echo $TR ?></strong></span>
        </div>
        <div class="col-md-7">
			<ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
    	</div>
        <div class="col-md-3"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
    </div>
<div>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
        <th>Paciente</th>
		<th>Fecha Registro</th>
        <th>Fecha Ecografía</th>
        <th>Fetos</th>
        <th>Multimedia</th>
		<th>Responsable</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php $detP=detRow('db_clientes','pac_cod',$dRS['pac_cod']); ?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $dRS['id'] ?></td>
            <td><?php echo $detP['pac_nom'].' '.$detP['pac_ape'] ?></td>
			<td><?php echo $dRS['fechar'] ?></td>
            <td><?php echo $dRS['fechae'] ?></td>
			<td><?php echo totRowsTab('db_rep_obs_detalle','id_rep',$dRS['id']) ?></td>
            <td><?php echo totRowsTab('db_rep_obs_media','id_rep',$dRS['id']) ?></td>
            <td></td>
            <td><div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_reps/eco_print.php?id=<?php echo $dRS['id'] ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
            <i class="fa fa-print"></i> Imprimir</a>
            </div>
            </td>
        </tr>
        <?php } while ($dRS = mysql_fetch_assoc($RS));?>
        </tbody>
        </table>
    </div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>