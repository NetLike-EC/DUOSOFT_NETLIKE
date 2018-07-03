<?php 
$qryConLst=sprintf('SELECT * FROM db_terapias
inner join tbl_usuario on db_terapias.id_usu = tbl_usuario.usr_id
inner join db_empleados on tbl_usuario.emp_cod=db_empleados.emp_cod
inner join db_clientes on db_clientes.cli_id=db_terapias.id_pac WHERE est=%s',
SSQL('1','int'));
$RSt=mysql_query($qryConLst) or die (mysql_error());
$row_RSt=mysql_fetch_assoc($RSt);
$tr_RSt=mysql_num_rows($RSt);
?>
<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-columns fa-lg"></i> Terapias  
  </div>
  <div class="panel-body">
    <?php if ($tr_RSt>0){?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th style="width:10%">Inicio Terapia</th>
        <th style="width:10%">Hora Inicio</th>
        <th style="width:10%">Hora Fin</th>		
        <th>Terapista</th>
        <th>Paciente</th>
        <th>Estado</th>
        <th>N. Sesiones</th>
		<th style="width:20%">Detalle Tratamiento</th>
		
	</tr>
	</thead>    
    <tbody>
	<?php do{ ?>
    <?php 		
		$detSes=detRow('db_fullcalendar_sesiones','id_ter',$row_RSt['id']);		
		if ($row_RSt['est']==1){
			$estado='Pendiente';
		}
		if($row_RSt['est']==2){
			$estado='Atendido';
		}
	?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $detSes['fechai'] ?></td>
            <td><?php echo $detSes['horai'] ?></td>
            <td><?php echo $detSes['horaf'] ?></td>			
            <td><?php echo $row_RSt['emp_nom'].' '.$row_RSt['emp_ape'] ?></td>
            <td><?php echo $row_RSt['cli_nom'].' '.$row_RSt['cli_ape'] ?></td>
            <td><?php echo $estado ?></td>
            <td><?php echo $row_RSt['num_ses'] ?></td>			                     
            <td><div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_terapista/form.php?idt=<?php echo $row_RSt['id'] ?>&idp=<?php echo $row_RSt['idp'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload">
            <i class="fa fa-pencil-square-o"></i>Atender</a>                              
            </div>
            </td>
        </tr>
        <?php } while ($row_RSt = mysql_fetch_assoc($RSt));?>
        </tbody>
        </table>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSt ?></div>
</div>
<?php mysql_free_result($RSt); ?>