<?php 
$qryConLst=sprintf('SELECT * FROM clinic_freimo.db_terapias
inner join tbl_usuario on db_terapias.id_usu = tbl_usuario.usr_id
inner join db_empleados on tbl_usuario.emp_cod=db_empleados.emp_cod WHERE id_pac=%s OR id_con=%s',
SSQL($idp,'int'),
SSQL($idc,'int'));
$RSt=mysql_query($qryConLst) or die (mysql_error());
$row_RSt=mysql_fetch_assoc($RSt);
$tr_RSt=mysql_num_rows($RSt);
?>

<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-columns fa-lg"></i> FISIOTERAPIAS
                     
    <a href="<?php echo $RAIZc ?>com_calendar_terapias/form.php?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default btn-xs fancybox.iframe fancyreload"> <i class="fa fa-plus-circle fa-lg"></i> NUEVO </a>
                                    
  </div>
  <div class="panel-body">
    <?php if ($tr_RSt>0){?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th style="width:20%">inicio Terapia</th>		
        <th>Terapista</th>
        <th>Estado</th>
        <th>N. Sesiones</th>
		<th style="width:20%">Detalle Tratamiento</th>
		<th></th>
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
            <td><?php echo $row_RSt['emp_nom'].' '.$row_RSt['emp_ape'] ?></td>
            <td><?php echo $estado ?></td>
            <td><?php echo $row_RSt['num_ses'] ?></td>			                     
            <td><div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_fisioterapias/ver_sesiones.php?idt=<?php echo $row_RSt['id'] ?>&idp=<?php echo $row_RSt['idp'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload">
            <i class="fa fa-pencil-square-o"></i> Ver</a>
            <a href="<?php echo $RAIZc ?>com_calendar_terapias/form.php?id=<?php echo $row_RSt['id'] ?>&idc=<?php echo $idc ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload">
            <i class="fa fa-pencil-square-o"></i> Modificar</a>
            <a class="btn btn-default btn-danger btn-xs fancybox.iframe fancyreload" href="<?php echo $RAIZc ?>com_calendar_terapias/actions.php?id=<?php echo $row_RSt['id'] ?>&acc=DELEF">
            <i class="fa fa-pencil-square-o"></i> Eliminar</a>                       
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