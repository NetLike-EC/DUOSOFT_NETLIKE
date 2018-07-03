<?php 
$qry=sprintf('SELECT * FROM db_tratamiento_infertilidad WHERE con_num=%s OR cli_id=%s ORDER BY id_ti DESC',
SSQL($idc,'int'),
SSQL($idp,'int'));
$RSti=mysql_query($qry);
$row_RSti=mysql_fetch_assoc($RSti);
$tr_RSti=mysql_num_rows($RSti);
?>

<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-list-alt fa-lg"></i> TRATAMIENTOS INFERTILIDAD
    <a href="<?php echo $RAIZc ?>com_tinf/form.php?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default btn-xs fancybox.iframe fancyreload"> NUEVO <i class="fa fa-plus-circle fa-lg"></i> </a>
  </div>
  <div class="panel-body">
  
  <?php if ($tr_RSti>0){
$classlast=TRUE;
$classtr;
?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Fecha</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Tipo Tratamiento</th>
        <th>Donante</th>
        <th>Estado</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php
	$detTT=detRow('db_types','typ_cod',$row_RSti['typ_cod']);
	if($row_RSti['status']==1) $btnStatTI='<span class="label label-success">Activo</a>';
	else $btnStatTI='<span class="label label-warning">Finalizado</a>';
	
	if($classlast==TRUE){ $classlast=FALSE; $classtr='class="warning"'; }else{$classtr='';}?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $row_RSti['id_ti'] ?></td>
			<td><?php echo $row_RSti['date'] ?></td>
            <td><?php echo $row_RSti['datei'] ?></td>
            <td><?php echo $row_RSti['datef'] ?></td>
            <td><?php echo $detTT['typ_val'] ?></td>
            <td><?php echo $row_RSti['donante'] ?></td>
            <td><?php echo $btnStatTI ?></td>
            <td>
            <div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_tinf/form.php?id=<?php echo $row_RSti['id_ti'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload"><i class="fa fa-pencil-square-o"></i> Modificar</a>
            <a href="<?php echo $RAIZc; ?>com_tinf/form.php?id=<?php echo $row_RSti['id_ti'] ?>&action=DELEF" class="btn btn-default btn-danger btn-xs fancybox.iframe fancyclose"><i class="fa fa-trash-o"></i> Eliminar</a>
            </div>
            </td>
        </tr>
        <?php } while ($row_RSti = mysql_fetch_assoc($RSti));?>
        </tbody>
        </table>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSti ?></div>
</div>