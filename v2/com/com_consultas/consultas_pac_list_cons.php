<?php include('../../init.php');
$qry = sprintf("SELECT * FROM db_consultas WHERE cli_id= %s ORDER BY con_num DESC", 
SSQL($_REQUEST['idp'], "int"));
$RSlcp = mysql_query($qry) or die(mysql_error());
$dRSlcp = mysql_fetch_assoc($RSlcp);
$tRSlcp = mysql_num_rows($RSlcp);
if ($tRSlcp>0){?>
<table class="table table-bordered table-condensed cero">
<thead>
<tr>
	<th>Historial</th>
    <th>Visita - Consulta</th>
    <th>Fecha</th>
    <th>Diagnostico</th>
</tr>
</thead>
<tbody>
<?php $contVis=$tRSlcp; ?>
<?php do { ?>
<?php
$detDiagCH=detRow('db_diagnosticos','id_diag',$dRSlcp['con_diagd']);
$detDiagCH_nom=$detDiagCH['nombre'];
?>
	<tr>
  		<td><a href="<?php echo $RAIZc ?>com_consultas/form.php?idc=<?php echo $dRSlcp['con_num'] ?>" class="btn btn-default btn-xs btn-block">
        <i class="fa fa-eye fa-lg"></i> Ver
        </a></td>
		<td class="text-center"><span class="label label-primary"><?php echo $contVis ?></span> <span class="label label-default"><?php echo $dRSlcp['con_num']?></span></td>
		<td><?php echo $dRSlcp['con_fec']; ?></td>
		<td><?php echo $detDiagCH_nom ?></td>
	</tr>
<?php $contVis--; ?>
<?php } while ($dRSlcp = mysql_fetch_assoc($RSlcp)); ?>
</tbody>
</table>
<?php }else{
	echo'<div class="alert alert-warning mcero"><h4>Paciente sin Antecedentes</h4></div>';
} ?>
<?php
mysql_free_result($RSlcp);
?>