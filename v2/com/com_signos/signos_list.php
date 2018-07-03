<?php
$TR=totRowsTab('db_signos','1','1');
if ($TR>0) {
$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	//echo $query_RSd.' '.$pages->limit.'<br >';
	$query_RSd=sprintf('SELECT * FROM db_signos ORDER BY id DESC');
	$RSd = mysql_query($query_RSd.' '.$pages->limit) or die(mysql_error());
	$row_RSd = mysql_fetch_assoc($RSd);
	$totalRows_RSd = mysql_num_rows($RSd);
?>
<div class="well well-sm">
<span class="label label-primary"> Resultados <strong><?php echo $totalRows_RSt ?></strong></span>
</div>

<table id="mytable" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
    	<th>ID</th>
		<th>Fecha</th>
		<th><abbr title="Historia Clinica">H.C.</abbr></th>
    	<th>Apellidos</th>
        <th>Nombres</th>
        <th>Peso Kg.</th>
        <th>Talla cm.</th>
        <th>I.M.C.</th>
        <th>P.A.</th>
        <th></th>
	</tr>
</thead>
<tbody> 
	<?php do{?>
	<?php
	$detPac=detRow('db_clientes','cli_id',$row_RSd['cli_id']);
	$typ_tsan=dTyp($detPac['pac_tipsan']);$typ_tsan=$typ_tsan['typ_val'];
	$typ_eciv=dTyp($detPac['pac_estciv']);$typ_eciv=$typ_eciv['typ_val'];
	$typ_sexo=dTyp($detPac['pac_sexo']);$typ_sexo=$typ_sexo['typ_val'];
	if($typ_sexo=='Masculino') $classsexo=' label-info';
	if($typ_sexo=='Femenino') $classsexo=' label-important';
	$IMC=calcIMC($row_RSd['imc'],$row_RSd['peso'],$row_RSd['talla']);
	?>
    <tr>
    	<td><?php echo $row_RSd['id'];?></td>
   		<td><?php echo $row_RSd['fecha']; ?></td>
		<td><?php echo $row_RSd['cli_id'];?></td>
		<td><?php echo strtoupper($detPac['cli_nom'])?></td>
		<td><?php echo strtoupper($detPac['cli_ape'])?></td>
        <td><?php echo $row_RSd['peso']; ?></td>
        <td><?php echo $row_RSd['talla']; ?></td>
        <td><?php echo $IMC['val'].' '.$IMC['inf']; ?></td>
        <td><?php echo $row_RSd['pa']; ?></td>
        <td class="text-center">
        	<a class="btn btn-info btn-xs" href="form.php?id=<?php echo $row_RSd['cli_id'];?>">
        	<i class="fa fa-stethoscope fa-lg"></i> Registrar</a>
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