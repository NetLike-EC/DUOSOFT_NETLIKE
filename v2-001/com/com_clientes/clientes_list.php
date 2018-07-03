<?php
$sbr=vParam('sBr', $_GET['sBr'], $_POST['sBr'],FALSE);
$qry=genCadSearchPac($sbr);
$RSpt = mysql_query($qry) or die(mysql_error());
$dRSpt = mysql_fetch_assoc($RSpt);
$totalRows_RSpt = mysql_num_rows($RSpt);
if ($totalRows_RSpt>0) {
$pages = new Paginator;
	$pages->items_total = $totalRows_RSpt;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSp = mysql_query($qry.$pages->limit) or die(mysql_error());
	$dRSp = mysql_fetch_assoc($RSp);
	$totalRows_RSp = mysql_num_rows($RSp);
?>
<?php if($sbr){ ?>
<div class="alert alert-info alert-dismissable" id="log">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Mostrando Su Busqueda: <strong>"<?php echo $sbr ?>"</strong>
</div>
<?php } ?>
<table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
    	<th></th>
		<th><abbr title="ID Referencia">ID</abbr></th>
    	<th>Nombres</th>
        <th>Apellidos</th>
		<th>Edad</th>
        <th>Detalle</th>
        <th>Contacto</th>
	</tr>
</thead>
<tbody> 
	<?php do{?>
	<?php
	$cod_pac=$dRSp['pac_cod'];
	$detPac=detRow('db_clientes','pac_cod',$dRSp['cod_pac']);//dPac($dRSp['cod_pac']);
	$typ_tsan=dTyp($detPac['pac_tipsan']);$typ_tsan=$typ_tsan['typ_val'];
	$typ_eciv=dTyp($detPac['pac_estciv']);$typ_eciv=$typ_eciv['typ_val'];
	$typ_sexo=dTyp($detPac['pac_sexo']);$typ_sexo=$typ_sexo['typ_val'];
	if($typ_sexo=='Masculino') $classsexo=' label-info';
	if($typ_sexo=='Femenino') $classsexo=' label-women';
	?>
    <tr>
    	<td>
        	<?php if ($dM['mod_ref']=="CLI"){ ?>
			<a href="form.php?id=<?php echo $cod_pac ?>" title="Modificar Paciente" class="btn btn-primary btn-xs">
           <i class="fa fa-user"></i> Detalle</a>
           <?php } ?>
           <?php if ($dM['mod_ref']=="CON"){ ?>
           <a href="<?php echo $RAIZc ?>com_consultas/form.php?idp=<?php echo $cod_pac?>" class="btn btn-primary btn-xs">
           <i class="fa fa-stethoscope fa-lg"></i> Consulta</a>
           <a href="<?php echo $RAIZc ?>com_calendar/reserva_form.php?idp=<?php echo $cod_pac?>" class="btn btn-default btn-xs fancybox.iframe fancyreload">
           <i class="fa fa-calendar-o"></i> Reserva</a>
           <?php } ?>
        </td>
		<td><?php echo $cod_pac ?></td>
		<td><?php echo strtoupper($dRSp['pac_nom'])?></td>
		<td><?php echo strtoupper($dRSp['pac_ape'])?></td>
        
		<td><?php echo edad($detPac['pac_fec']); ?></td>
        <td>
        <?php //echo "***".$typ_sexo ?>
        <small>
		<?php
		if ($typ_sexo) echo '<span class="label '.$classsexo.'">'.$typ_sexo.'</span> ';
		if ($typ_eciv) echo '<span class="badge">'.$typ_eciv.'</span> ';
		if ($typ_tsan) echo '<span class="badge">'.$typ_tsan.'</span> ';
		?>
		</small></td>
        <td><?php
		if ($detPac['pac_lugr']) echo '<abbr title="'.$detPac['pac_lugr'].'"><i class="fa fa-globe"></i></abbr> ';
		if ($detPac['pac_tel1']) echo '<abbr title="'.$detPac['pac_tel1'].'"><i class="fa fa-phone"></i></abbr> ';
		if ($detPac['pac_tel2']) echo '<abbr title="'.$detPac['pac_tel2'].'"><i class="fa fa-phone"></i></abbr> ';
		if ($detPac['pac_email']) echo '<abbr title="'.$detPac['pac_email'].'"><i class="fa fa-envelope"></i></abbr> ';
		?></td>
    </tr>
    <?php } while ($dRSp = mysql_fetch_assoc($RSp)); ?>
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
<?php mysql_free_result($RSp);?>
<?php }else{
	echo '<div class="alert alert-info"><h4>Sin Coincidencias de Busqueda</h4></div>';
} ?>