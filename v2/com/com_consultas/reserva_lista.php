<?php include('../../init.php');
$query_RSr = "SELECT * FROM db_consultas_reserva WHERE estado='1'";
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
<table id="myt_rescons" class="table table-bordered table-striped table-condensed">
<thead>
	<tr>
    	<th></th>
		<th>Codigo</th>
    	<th>Fecha</th>
      	<th>Paciente</th>
		<th>Empleado</th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <?php
    $detPac=detRow('db_clientes','pac_cod',$row_RSr['pac_cod']);
	$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
	?>
    <tr>
    	<td><a class="btn btn-default btn-xs" target="_parent" href="<?php echo $RAIZc ?>com_consultas/form.php?idp=<?php echo $row_RSr['pac_cod'] ?>&acc=NEW">Tratar Consulta <i class="fa fa-chevron-right"></i></a></td>
		<td align="center"><?php echo $row_RSr['id']; ?></td>
		<td><?php echo $row_RSr['fecha'] ?></td>
		<td><?php echo $detPac_nom ?></td>
		<td><?php echo $row_RSr['id_aud']; ?></td>
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