<?php include('../../init.php');
//var_dump($_REQUEST);
$idr=vParam('ids', $_GET['ids'], $_POST['ids']);
$dPac=detRow('db_clientes','md5(cli_id)',$idr);
//echo '<hr>';
//var_dump($dPac);
$_SESSION['id_pac']=$dPac['cli_id']; //REVISAR
$detPacFin_name=$dPac['cli_nom'].' '.$dPac['cli_ape'];
$_SESSION['sBr']=$detPacFin_name;
$dImg=vImg("data/db/pac/",lastImgPac($dPac['cli_id']));
$dcli_doc=$dPac['cli_doc'];
$btnAcc.='<a href="'.$RAIZc.'com_pacientes/form.php?id='.$idr.'" class="btn btn-primary btn-xs btn-block"><i class="fa fa-stethoscope fa-lg"></i> Consulta</a>';
$btnAcc.='<a href="'.$RAIZc.'com_consultas/form.php?idp='.$idr.'" class="btn btn-primary btn-xs btn-block"><i class="fa fa-user"></i> Ficha</a>';
$detPacFin_edad=edad($dPac['cli_fec']);
?>
<div class="panel panel-default" style="font-size:10px">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4 text-center">
				<a href="<?php echo $dImg['n'] ?>" class="thumbnail fancybox" style="margin-bottom: 0">
					<img src="<?php echo $dImg['t'] ?>">
				</a>
			</div>
			<div class="col-md-2 text-center" style="padding-left: 4px; padding-right: 4px;"><?php echo $btnAcc?></div>
			<div class="col-md-6">
			<table class="table table-condensed table-bordered" style="margin:0px;">
				<tr><td><?php echo $detPacFin_name ?></td></tr>
				<?php if($dcli_doc){ ?>
					<tr><td><?php echo $dcli_doc ?></td></tr>
				<?php } ?>
				<tr><td><?php echo $dPac['cli_fec'] ?></td></tr>
				<tr><td><?php echo $detPacFin_edad ?></td></tr>
			</table>
			</div>
		</div>
	</div>
</div>