<?php 
$qry=sprintf('SELECT * FROM db_cirugias WHERE con_num=%s OR pac_cod=%s ORDER BY id_cir DESC',
GetSQLValueString($id_cons,'int'),
GetSQLValueString($id_pac,'int'));
$RSe=mysql_query($qry);
$row_RSe=mysql_fetch_assoc($RSe);
$tr_RSe=mysql_num_rows($RSe);
?>
<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-medkit fa-lg"></i> CIRUGIAS
    <a href="<?php echo $RAIZc ?>com_hc/cirugia_form.php?idp=<?php echo $id_pac ?>&idc=<?php echo $id_cons ?>&action=NEW" class="btn btn-default btn-xs fancybox fancybox.iframe fancyreload"> NUEVO <i class="fa fa-plus-circle fa-lg"></i> </a>
  </div>
  <div class="panel-body">
  
  <?php if ($tr_RSe>0){
$classlast=TRUE;
$classtr;
?>
<div>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Diagnostico</th>
		<th colspan="2">Cirugia Propuesta</th>
        <th colspan="2">Cirugia Realizada</th>
        <th>Protocolo</th>
        <th>Evolucion</th>
        <th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php
    $typexam=fnc_datatyp($row_RSe['typ_cod']);
	$typexam=$typexam['typ_val'];
	if($classlast==TRUE){ $classlast=FALSE; $classtr='class="warning"'; }else{$classtr='';}?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $row_RSe['id_cir'] ?></td>
			<td><?php echo $row_RSe['diagnostico'] ?></td>
			<td><?php if($row_RSe['fechap']){ ?><abbr title="<?php echo $row_RSe['fechap'] ?>"><i class="fa fa-calendar"></i></abbr><?php } ?></td>
            <td><?php echo $row_RSe['cirugiap'] ?></td>
            <td><?php if($row_RSe['fechar']){ ?><abbr title="<?php echo $row_RSe['fechar'] ?>"><i class="fa fa-calendar"></i></abbr><?php } ?></td>
            <td><?php echo $row_RSe['cirugiar'] ?></td>
            <td><abbr title="<?php echo $row_RSe['protocolo'] ?>"><i class="fa fa-table"></i></abbr></td>
            <td><?php echo $row_RSe['evolucion'] ?></td>
            <td>
            <div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_hc/cirugia_form.php?idr=<?php echo $row_RSe['id_cir'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload">
            <i class="fa fa-pencil-square-o"></i> Modificar</a>
            <a href="<?php echo $RAIZc; ?>com_hc/cirugia_form.php?idr=<?php echo $row_RSe['id_cir'] ?>&action=DELRF" class="btn btn-danger btn-xs fancybox fancybox.iframe fancyclose">
            <i class="fa fa-trash-o"></i> Eliminar</a>
            </div>
            </td>
        </tr>
        <?php } while ($row_RSe = mysql_fetch_assoc($RSe));?>
        </tbody>
        </table>
    </div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSe ?></div>
</div>