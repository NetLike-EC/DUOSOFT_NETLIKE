<?php
$sbr=vParam('sBr', $_GET['sBr'], $_POST['sBr'],FALSE);
$qry=genCadSearchPac($sbr);
$RSpt = mysqli_query($conn,$qry) or die(mysqli_error($conn));
$dRSpt = mysqli_fetch_assoc($RSpt);
$TR = mysqli_num_rows($RSpt);
if ($TR>0) {
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSp = mysqli_query($conn,$qry.$pages->limit) or die(mysqli_error($conn));
	$dRSp = mysqli_fetch_assoc($RSp);
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
		<th><abbr title="Historia Clinica">H.C.</abbr></th>
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
	$id=$dRSp['idc'];
	$ids=md5($id);
	$dPac=detRow('db_clientes','idc',$id);
	$btnAcc;
	//genLink($link,$txt,$css=NULL,$params=NULL)
	switch($dM[ref]){
		case 'CLI':
			$btnAcc=genLink('form.php','Ver','btn btn-default btn-xs',array("ids"=>$ids));;
		break;
		default:
		break;
	}
	?>
    <tr>
    	<td>
        	<?php echo $btnAcc ?>
        </td>
		<td><?php echo $id ?></td>
		<td><?php echo strtoupper($dRSp['cli_nom'])?></td>
		<td><?php echo strtoupper($dRSp['cli_ape'])?></td>
        
		<td><?php echo edad($dRSp['cli_fec']) ?></td>
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
		if ($dPac['pac_lugr']) echo '<abbr title="'.$dPac['pac_lugr'].'"><i class="fa fa-globe"></i></abbr> ';
		if ($dPac['pac_tel1']) echo '<abbr title="'.$dPac['pac_tel1'].'"><i class="fa fa-phone"></i></abbr> ';
		if ($dPac['pac_tel2']) echo '<abbr title="'.$dPac['pac_tel2'].'"><i class="fa fa-phone"></i></abbr> ';
		if ($dPac['pac_email']) echo '<abbr title="'.$dPac['pac_email'].'"><i class="fa fa-envelope"></i></abbr> ';
		?></td>
    </tr>
    <?php } while ($dRSp = mysqli_fetch_assoc($RSp)); ?>
</tbody>
</table>
<?php include(RAIZf.'paginator.php') ?>
<?php mysqli_free_result($RSp);?>
<?php }else{
	echo '<div class="alert alert-info"><h4>Sin Coincidencias de Busqueda</h4></div>';
} ?>