<?php
require_once('../../init.php');
include_once(RAIZf.'headPrint.php') ?>
<div>
    <?php
$dFI=vParam('FI', $_GET['FI'], $_POST['FI'],FALSE);
$dFF=vParam('FF', $_GET['FF'], $_POST['FF'],FALSE);
$qryPR=sprintf('SELECT * FROM tbl_contact_data WHERE date>=%s AND date<=%s',
GetSQLValueString($dFI,'date'),
GetSQLValueString($dFF,'date'));

$RSpr = mysql_query($qryPR) or die(mysql_error());
$row_RSpr = mysql_fetch_assoc($RSpr);
$tr_RSpr = mysql_num_rows($RSpr);

$qryPRs=sprintf('SELECT tbl_types.typ_cod,tbl_types.typ_nom,tbl_types.typ_val,tbl_types.typ_icon,COUNT(tbl_contact_data.ContactKnow) AS cant 
FROM tbl_contact_data
LEFT JOIN tbl_types
ON tbl_contact_data.ContactKnow=tbl_types.typ_cod
WHERE tbl_contact_data.date>=%s AND tbl_contact_data.date<=%s
GROUP BY ContactKnow',
GetSQLValueString($dFI,'date'),
GetSQLValueString($dFF,'date'));

$RSprs = mysql_query($qryPRs) or die(mysql_error());
$row_RSprs = mysql_fetch_assoc($RSprs);
$tr_RSprs = mysql_num_rows($RSprs);

$banSR=TRUE;

if(!$dFI||!$dFF){
	$banSR=FALSE;
	$logSR='Debe Seleccionar la FECHA INICIAL y la FECHA FINAL';
}else{
	if($dFI>$dFF){
		$banSR=FALSE;
		$logSR='FECHA INICIAL no puede ser Mayor a la FECHA FINAL';
	}else{
		if($tr_RSpr<=0){
			$banSR=FALSE;
			$logSR='Sin Resultados para Mostrar, seleccione otro rango de fechas';
		}
	}
}


if($banSR==TRUE){
	$GraphGen_name='graph-'.date('Ymd-His').'.jpg';
	$setTitle="REPORT - Source new contacts";
	include_once(RAIZf.'fra_print_header_gen.php')
?>

<div style="margin-top:10px;">
    
    <div class="panel panel-default">
    	<div class="panel-heading" style="text-align:center">From <strong><?php echo $dFI ?></strong> to <strong><?php echo $dFF ?></strong></div>        
    </div>
    
    <div class="panel panel-info">
    	<div class="panel-heading">DATA</div>
        <div class="panel-body">
        <table style="width:100%;" border="1" bordercolor="#ccc" cellspacing="0" cellpadding="4">
	<tr>
        <th style="width:75%; background:#666; color:#fff; padding-left:10px;">Source</th>
        <th style="width:25%; background:#666; color:#fff; text-align:center;">Quantity</th>
	</tr>
	<?php
    	$dataG;
		$contDataG=0;
		$sumVals=0;
		do{
		$det_typcod=$row_RSprs['typ_cod'];
		$det_typval=$row_RSprs['typ_val'];
		$det_typicon='<i class="'.$row_RSprs['typ_icon'].' fa-2x"></i>';
		$det_typcant=$row_RSprs['cant'];
		if(!$det_typcod){ 
			$det_typval='No Determinado';
			$det_typicon='<i class="fa fa-question fa-2x"></i>';
		}
		$dataG[$contDataG]=array($det_typval, $det_typcant);
		$contDataG++;
		$sumVals+=$det_typcant;
		
	?>
    <tr>
        <td style="padding-left:20px;"><?php echo $det_typval ?></td>
        <td style="text-align:center"><?php echo $det_typcant ?></td>
    </tr>
    <?php } while ($row_RSprs = mysql_fetch_assoc($RSprs)); ?>
    <tr>
        <td style="padding-left:20px; color:#999; background:#ddd;">No Defined</td>
        <td style="text-align:center; color:#999; background:#ddd;"><?php echo $tr_RSpr-$sumVals ?></td>
    </tr>
    <tr>
        <th style="width:75%; background:#666; color:#fff; padding-left:10px;">TOTAL NEW Contacts</th>
        <th style="width:25%; background:#666; color:#fff; text-align:center;"><?php echo $tr_RSpr ?></th>
	</tr>
</table>
        </div>
    </div>

	<div class="panel panel-info">
    	<div class="panel-heading">GRAPHIC</div>
        <div class="panel-body">
        <?php include('rep_pacProc_graph.php'); ?>
	<div style="text-align:center; padding:10px;">
        <img style="width:94%" src="res/<?php echo $graph_SetOutputFile ?>">
    </div>
        </div>
    </div>
    
    <div class="panel panel-default">
    	<div class="panel-heading">Comments</div>
        <div class="panel-body" style="padding:15px;">
        	<table style="width:100%">
            	<tr>
                <th style="width:50%">Generated</th>
                <td><?php echo $sdatet ?></td>
                </tr>
                <tr>
                <th style="width:50%">By</th>
                <td><?php echo $_SESSION['MM_Username'] ?></td>
                </tr>
            </table>
        </div>
    </div>
    
</div>

<?php mysql_free_result($RSpr);?>
<?php }else{
	echo '<div class="alert alert-info"><h4>'.$logSR.'</h4></div>';
} ?>
    
    
</div>