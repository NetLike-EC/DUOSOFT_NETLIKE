<?php 
$qry=sprintf('SELECT * FROM db_cirugias WHERE con_num=%s OR pac_cod=%s ORDER BY id_cir DESC',
SSQL($idc,'int'),
SSQL($idp,'int'));
$RSe=mysql_query($qry);
$row_RSe=mysql_fetch_assoc($RSe);
$tr_RSe=mysql_num_rows($RSe);
?>
<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-medkit fa-lg"></i> CIRUGIAS
    <a href="<?php echo $RAIZc ?>com_cirugia/cirugia_form.php?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>&action=NEW" class="btn btn-default btn-xs fancybox fancybox.iframe fancyreload"> NUEVO <i class="fa fa-plus-circle fa-lg"></i> </a>
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
        <th colspan="2">Cirugia Realizada</th>
        <th style="width:30%">Protocolo</th>
        <th>Evolucion</th>
        <th>Multimedia</th>
        <th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php
	$detProt=$row_RSe['protocolo'];
	$contDetProt=strlen($detProt);
	if($contDetProt>200){
		$detProt=substr($detProt,0,200).' ...';
	}
    $typexam=dTyp($row_RSe['typ_cod']);
	$typexam=$typexam['typ_val'];
	if($classlast==TRUE){ $classlast=FALSE; $classtr='class="warning"'; }else{$classtr='';}?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $row_RSe['id_cir'] ?></td>
			<td><?php echo $row_RSe['diagnostico'] ?></td>
            <td><?php echo $row_RSe['fechar'] ?></td>
            <td><?php echo $row_RSe['cirugiar'] ?></td>
            <td><?php echo $detProt ?></td>
            <td><?php echo $row_RSe['evolucion'] ?></td>
            <td><?php echo totRowsTab('db_cirugias_media','id_cir',$row_RSe['id_cir']) ?></td>
            <td>
            <div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_cirugia/cirugia_form.php?idr=<?php echo $row_RSe['id_cir'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload">
            <i class="fa fa-pencil-square-o"></i> Modificar</a>
            <a href="<?php echo $RAIZc; ?>com_cirugia/actions.php?idr=<?php echo $row_RSe['id_cir'] ?>&acc=<?php echo md5("DELRF") ?>" class="btn btn-danger btn-xs fancybox fancybox.iframe fancyclose">
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