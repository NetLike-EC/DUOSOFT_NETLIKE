<?php include('../../init.php');
$query_RSr = "SELECT * FROM db_fullcalendarterapias WHERE est=1 ORDER BY id DESC";
$RSr = mysql_query($query_RSr) or die(mysql_error());
$row_RSr = mysql_fetch_assoc($RSr);
$totalRows_RSr = mysql_num_rows($RSr);
include(RAIZf.'head.php');
?>
<title>Lista Reserva Consultas</title>
<body class="cero">
<div class="container">
<div class="page-header">
	<h1>Reservas Consultas <small>Consultas Pendientes</small></h1>
</div>
<?php if ($totalRows_RSr>0){?>
<table id="mytable" class="table table-bordered table-striped table-condensed">
<thead>
	<tr>
    	<th></th>
		<th>Codigo</th>
    	<th>Fecha Hora Reserva</th>
      	<th>Paciente</th>
		<th>Auditoria</th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <?php
	$detcli_id=$row_RSr['cli_id'];
    $detPac=detRow('db_clientes','cli_id',$detcli_id);
	$detAud_inf=infAud($row_RSr['id_aud']);
	$detcli_nom=$detPac['cli_nom'].' '.$detPac['cli_ape'];
	$btnAcc=NULL;
	if($detPac){
		$btnAcc='<a class="btn btn-default btn-xs" target="_parent" href="'.$RAIZc.'com_consultas/form.php?idp='.$detcli_id.'">
		Tratar Consulta <i class="fa fa-chevron-right"></i></a>';
	}
	
	?>
    <tr>
    	<td><?php echo $btnAcc ?></td>
		<td><?php echo $row_RSr['id']; ?></td>
		<td><?php echo $row_RSr['fechai']?> <span class="badge"><?php echo $row_RSr['horai'] ?></span></td>
		<td><?php echo $detcli_nom ?></td>
		<td><?php echo $detAud_inf ?></td>
    </tr>
    <?php } while ($row_RSr = mysql_fetch_assoc($RSr)); ?>    
</tbody>
</table>
<?php
} else {
	echo '<div class="alert alert-block">
	<h4>No hay reservas pendientes!</h4>
	</div>';
} ?>
</div>
</body>
</html>
<?php mysql_free_result($RSr); ?>