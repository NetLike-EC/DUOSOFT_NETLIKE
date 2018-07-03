<?php
require_once('../../init.php');
include_once(RAIZf.'_head.php');
$dFI=vParam('FI', $_GET['FI'], $_POST['FI'],FALSE);
$dFF=vParam('FF', $_GET['FF'], $_POST['FF'],FALSE);
if(!$dFI)$dFI=$FI;
if(!$dFF)$dFF=$FF;
$qryPR=sprintf('SELECT * FROM tbl_contact_data WHERE date>=%s AND date<=%s',
GetSQLValueString($dFI,'date'),
GetSQLValueString($dFF,'date'));
$RSpr = mysql_query($qryPR) or die(mysql_error());
$dRSpr = mysql_fetch_assoc($RSpr);
$tRSpr = mysql_num_rows($RSpr);

$qryPRs=sprintf('SELECT tbl_types.typ_cod,tbl_types.typ_nom,tbl_types.typ_val,tbl_types.typ_icon,COUNT(tbl_contact_data.ContactKnow) AS cant FROM tbl_contact_data
LEFT JOIN tbl_types
ON tbl_contact_data.ContactKnow=tbl_types.typ_cod
WHERE tbl_contact_data.date>=%s AND tbl_contact_data.date<=%s
GROUP BY ContactKnow',
GetSQLValueString($dFI,'date'),
GetSQLValueString($dFF,'date'));
$RSprs = mysql_query($qryPRs) or die(mysql_error());
$dRSprs = mysql_fetch_assoc($RSprs);
$tRSprs = mysql_num_rows($RSprs);

$banSR=TRUE;

if(!$dFI||!$dFF){
	$banSR=FALSE;
	$logSR='Debe Seleccionar la FECHA INICIAL y la FECHA FINAL';
}else{
	if($dFI>$dFF){
		$banSR=FALSE;
		$logSR='FECHA INICIAL no puede ser Mayor a la FECHA FINAL';
	}else{
		if($tRSpr<=0){
			$banSR=FALSE;
			$logSR='Sin Resultados para Mostrar, seleccione otro rango de fechas';
		}
	}
}
if($banSR==TRUE){
	$GraphGen_name='graph-'.date('Ymd-His').'.jpg';
?>
<div class="well well-sm">
    <ul class="pagination" style="margin:2px;">
            <span class="label label-default">Total Resultados</span> <span class="label label-primary"><?php echo $tRSpr ?></span></ul>
    <div class="btn-group pull-right" role="group">
  <a class="btn btn-info btn-sm fancybox fancybox.iframe" href="rep_pacProc_pdf.php?selr=1&FI=<?php echo $dFI ?>&FF=<?php echo $dFF ?>"><i class="fa fa-print fa-lg"></i> Imprimir Reporte</a>
  <a class="btn btn-info btn-sm fancybox fancybox.iframe" href="rep_pacProc_pdf.php?selr=2&FI=<?php echo $dFI ?>&FF=<?php echo $dFF ?>"><i class="fa fa-print fa-lg"></i> Imprimir Listado</a>
</div>
</div>


<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Refered</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Client List</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
    
    <table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
		<th>ID</th>
        <th>Origen</th>
        <th>Cantidad</th>
	</tr>
</thead>
<tbody> 
	<?php $dataG;
		$contDataG=0;
	?>
	<?	do{ ?>
	<?	$dRSprs_tot+=$dRSprs['cant'];
	$dRSprs_icon='<i class="'.$dRSprs['typ_icon'].' fa-2x"></i>';
		if(!$det_typcod){ 
			$det_typval='No Determinado';
			$det_typicon='<i class="fa fa-question fa-2x"></i>';
		}
		$dataG[$contDataG]=array($dRSprs['typ_val'], $dRSprs['cant']);
		$contDataG++;
		
	?>
    <tr>
        <td><?php echo $dRSprs['typ_cod'] ?></td>
        <th><?php echo $dRSprs['typ_nom'] ?></th>
        <td><?php echo $dRSprs['cant'] ?></td>
    </tr>
    <?php } while ($dRSprs = mysql_fetch_assoc($RSprs)); ?>
    <tr class="info">
    	<th colspan="2">TOTAL</th>
        <th><?php echo $dRSprs_tot ?></th>
    </tr>
</tbody>
</table>
	<?php include('rep_pacProc_graph.php'); ?>
	<div class="panel panel-info">
	<div class="panel-heading">Grafico</div>
    <div class="panel-body text-center">
        <img src="res/<?php echo $graph_SetOutputFile ?>" class="">
    </div>
</div>

	</div>
    <div role="tabpanel" class="tab-pane" id="profile"><table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
		<th>ID</th>
        <th>Date Contact</th>
    	<th>Name</th>
        <th>Company</th>
		<th>Email</th>
        <th>Location</th>
        <th>Origen Referido</th>
	</tr>
</thead>
<tbody> 
	<?php do{?>
	<?php
	$dMail=detRow('tbl_contact_mail','idMail',$dRSpr['idMail']);
	$detRef=detRow('tbl_types','typ_cod',$dRSpr['ContactKnow']);
	?>
    <tr>
		<td><?php echo $dRSpr['idData']?></td>
        <td><?php echo $dRSpr['date']?></td>
		<td><?php echo $dRSpr['name']?></td>
		<td><?php echo $dRSpr['company']?></td>
        
		<td><?php echo $dMail['mail']?></td>
        <td>Location</td>
        <td>
		<?php echo $detRef['typ_nom'] ?></td>
    </tr>
    <?php } while ($dRSpr = mysql_fetch_assoc($RSpr)); ?>
</tbody>
</table></div>
  </div>
</div>
<?php mysql_free_result($RSpr);?>
<?php }else{
	echo '<div class="alert alert-info"><h4>'.$logSR.'</h4></div>';
} ?>