<?php 
$TR=totRowsTab('db_cirugias','1','1');
?>
<div>
<?php if ($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qry='SELECT * FROM db_cirugias ORDER BY id_cir DESC';
	$RS = mysql_query($qry.' '.$pages->limit) or die(mysql_error());
	$dRS = mysql_fetch_assoc($RS);
	
$classlast=TRUE;
$classtr;
?>
<div>

    <div class="well well-sm">
	<span class="label label-primary">Resultados. <?php echo $TR ?></span>
    </div>
    
    
    <table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Paciente</th>
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
    $dPac=detRow('db_clientes','pac_cod',$dRS['pac_cod']);
	$detProt=$dRS['protocolo'];
	$contDetProt=strlen($detProt);
	if($contDetProt>200){
		$detProt=substr($detProt,0,200).' ...';
	}
	$typexam=dTyp($dRS['typ_cod']);
	$typexam=$typexam['typ_val'];
	if($classlast==TRUE){ $classlast=FALSE; $classtr='class="warning"'; }else{$classtr='';}?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $dRS['id_cir'] ?></td>
			<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
            <td><?php echo $dRS['diagnostico'] ?></td>
            <td><?php echo $dRS['fechar'] ?></td>
            <td><?php echo $dRS['cirugiar'] ?></td>
            <td><?php echo $detProt ?></td>
            <td><?php echo $dRS['evolucion'] ?></td>
            <td><?php echo totRowsTab('db_cirugias_media','id_cir',$dRS['id_cir']) ?></td>
            <td>
            <div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_cirugia/cirugia_form.php?idr=<?php echo $dRS['id_cir'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload">
            <i class="fa fa-pencil-square-o"></i> Editar</a>
            <a class="btn btn-default btn-xs" href="gest.php?id=<?php echo $dRS['pac_cod'];?>">
        	<i class="fa fa-history"></i> Historial</a>
            </div>
            </td>
        </tr>
        <?php } while ($dRS = mysql_fetch_assoc($RS));?>
        </tbody>
        </table>
        
	<div class="well well-sm">
    <div class="row">
    <div class="col-md-8">
    <ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
    </div>
    <div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
    </div>
        
    </div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  
  </div>