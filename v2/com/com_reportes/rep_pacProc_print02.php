<?php
require_once('../../init.php');
include_once(RAIZf.'headPrint.php') ?>
<div>
    <?php
$dFI=vParam('FI', $_GET['FI'], $_POST['FI'],FALSE);
$dFF=vParam('FF', $_GET['FF'], $_POST['FF'],FALSE);
$qryPR=sprintf('SELECT tbl_contact_data.name as NOM, tbl_contact_data.date as FEC, tbl_contact_data.message as MSG, 
tbl_types.typ_val as TIP, tbl_contact_mail.mail as MAIL
FROM tbl_contact_data 
INNER JOIN tbl_contact_mail ON tbl_contact_data.idMail=tbl_contact_mail.idMail 
INNER JOIN tbl_types ON tbl_contact_data.ContactKnow=tbl_types.typ_cod 
WHERE date>=%s AND date<=%s ORDER BY tbl_types.typ_val ASC',
GetSQLValueString($dFI,'date'),
GetSQLValueString($dFF,'date'));

$RSpr = mysql_query($qryPR) or die(mysql_error());
$dRSpr = mysql_fetch_assoc($RSpr);
$tr_RSpr = mysql_num_rows($RSpr);

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
	$setTitle="REPORT - Source Contacts";
	include_once(RAIZf.'fra_print_header_gen.php')
?>

<div style="margin-top:10px;">
    
    <div class="panel panel-default">
    	<div class="panel-heading" style="text-align:center">From <strong><?php echo $dFI ?></strong> to <strong><?php echo $dFF ?></strong></div>        
    </div>
    
    <div class="panel panel-info">
    	<div class="panel-heading">Data</div>
    </div>

<table style="font-size:10px" cellpadding="0" cellspacing="0" border="1" bordercolor="#ddd">
	<thead>
    <tr>
		<th width="80">Date</th>
        <th width="210">Name</th>
    	<th width="260">Email</th>
        <th width="130">Source</th>
	</tr>
    </thead>
    <tbody>
	<?php do{ ?>
    <tr style="font-size:10px">
        <td width="80"><?php echo $dRSpr['FEC'] ?></td>
		<td width="210"><?php echo $dRSpr['NOM'] ?></td>
		<td width="260"><?php echo $dRSpr['MAIL'] ?></td>
        <td width="130"><?php echo $dRSpr['TIP'] ?></td>
    </tr>
    <?php } while ($dRSpr = mysql_fetch_assoc($RSpr)); ?>
    </tbody>
</table>
    
    <div class="panel panel-default" style="margin-top:10px;">
    	<div class="panel-heading">Comments</div>
        <div class="panel-body" style="padding:5px;">
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