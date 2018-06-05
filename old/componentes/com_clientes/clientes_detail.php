<?php include('../../init.php');
$idcli=vParam('cli_sel_find', $_GET['cli_sel_find'], $_POST['cli_sel_find']);
$datapac=detCliPer($idcli);
$_SESSION['id_cli']=null;
$_SESSION['id_cli']=$datapac['cli_cod'];
$_SESSION['singleBirdRemote']=$datapac['cli_nom'].' '.$datapac['cli_ape'];
?>
<div class="well well-small" style="font-size:0.8em; background:#FFF">
<table class="table table-bordered table-condensed" style="margin:0;">
	<tr>
    	<td rowspan="4" style="width:100px; text-align:center;">
			<div class="btn-group">
				<?php
                if($_SESSION['MODSEL']=="CON"){
					echo '<a onclick="load_consulta()" class="btn"><i class="icon-list"></i></a>';
				}else if($_SESSION['MODSEL']=="POL"){
					echo '<a onclick="load_polizas('."'".$datapac['pac_cod']."'".')"><i class="icon-list-alt"></i></a>';
				}else if($_SESSION['MODSEL']=="CLI"){
					echo '<a onclick="load_paciente()" class="btn"><i class="icon-user"></i></a>';
				}else if($_SESSION['MODSEL']=="PAG"){
					echo '<a onclick="load_pagos('."'".$datapac['pac_cod']."'".')" class="btn"><i class="icon-th"></i></a>';
				}else if($_SESSION['MODSEL']=="FAC"){
					echo '<a onclick="load_factura('."'".$datapac['pac_cod']."'".')" class="btn"><i class="icon-th-list"></i></a>';
				} ?>
		<a class="btn" href="#" onclick="$('#cont_cli').slideUp();"><i class="icon-remove"></i></a>
			</div>
        </td>
        <td><strong><?php echo $datapac['cli_nom']." ".$datapac['cli_ape']; ?></strong></td>
	</tr>
<?php
if ($datapac['cli_dir']) echo '<tr><td>'.$datapac['cli_dir'].'</td></tr>';
if ($datapac['cli_ciu']) echo '<tr><td>'.$datapac['cli_ciu'].'</td></tr>';
if (($datapac['cli_tel1']) || ($datapac['cli_tel2'])) echo '<tr><td>'.$datapac['cli_tel1'].". ".$datapac['cli_tel2'].'</td></tr>'; ?>
</table>
</div>