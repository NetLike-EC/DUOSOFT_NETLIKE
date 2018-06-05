<?php require_once('../../init.php');
$fStart=vParam('fStart',$_GET['fStart'],$_POST['fStart']);
$fStartRep=date("Y-m-d H:i:s", strtotime($fStart));

$fEnd=vParam('fEnd',$_GET['fEnd'],$_POST['fEnd']);
$fEndRep=date("Y-m-d H:i:s", strtotime($fEnd." +23 hours + 59 mins + 59 secs"));

?>
<style type="text/css"> 
.cssPrintTable *{font-size:9px !important; font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;}
.cssPrintTable .table{
width:100%;
display: table;
border-spacing: 0px;
border-color: gray;
border-style:solid;

border: 1px solid #ddd;
border-collapse: separate;
}
.cssPrintTable .table th, .table td{
padding: 2px;
line-height: 20px;
text-align: left;
vertical-align: top;
border-top: 1px solid #ddd;
border-left: 1px solid #ddd;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
   //aquí meteremos las instrucciones que modifiquen el DOM
	
});
function togleClassPrint(acc){
	if(acc=='add') $(".contPrint").addClass("cssPrintTable");
	if(acc=='rem') $(".contPrint").removeClass("cssPrintTable");
}
</script>
<div class="contPrint">
	<h3 class="page-title">Reporte de Ventas <small>desde</small> <?php echo $fStart?> <small>hasta</small> <?php echo $fEnd?></small></h3>
	<?php $query_RSc = sprintf("SELECT * FROM tbl_venta_cab 
	LEFT JOIN tbl_auditoria ON tbl_venta_cab.aud_id=tbl_auditoria.aud_id
	WHERE aud_dat>=%s AND aud_dat<=%s AND ven_stat=1",
	GetSQLValueString($fStartRep,'text'),
	GetSQLValueString($fEndRep,'text'));
	//echo $query_RSc;
$RSc = mysql_query($query_RSc) or die(mysql_error());
$row_RSc = mysql_fetch_assoc($RSc);
$totalRows_RSc = mysql_num_rows($RSc); ?>
<?php if($totalRows_RSc>0){ ?>
<table class="table table-bordered">
    <thead>
    <tr>
    	<th>Venta</th>
        <th>Factura</th>
        <th>Cliente</th>
        <th>Valor</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    <?php do{?>
    <?php
	$detAud=detAUD($row_RSc['aud_id']);
    $detFac=detRow('tbl_factura_ven','ven_num',$row_RSc['ven_num']);
	$detCli=detCliPer($row_RSc['cli_cod']);
	$detCli_nom=$detCli['per_nom'].' '.$detCli['per_ape'];
	unset($valVen);
	$valVen=valor_factura($row_RSc['ven_num']);
	if($row_RSc['ven_stat']=='1'){
		$comEst='<span class="label label-info">Activa</span>';
		$valTotVen+=$valVen;
	}else if ($row_RSc['ven_stat']=='0'){ $comEst='<span class="label label-danger">Anulada</span>';
	}else{ $comEst='<span class="label">N/D</span>';}
	
	
	?>
    <tr>
    	<td><?php echo $detAud['aud_dat'] ?></td>
    	<td><?php echo $row_RSc['ven_num'] ?></td>
        <td><?php echo $detFac['fac_num'] ?></td>
        <td><?php echo $detCli_nom ?></td>
        <td><?php echo $valVen; ?></td>
        <td><?php echo $comEst ?></td>
    </tr>
    <?php }while($row_RSc = mysql_fetch_assoc($RSc)); ?>
    </tbody>
    </table>
<table class="table table-condensed table-bordered">
<tr>
    <td><h4 class="text-center">Total Ventas</h4></td>
    <td><h4 class="text-center"><?php echo $valTotVen ?></h4></td>
    </tr>
</table>
<?php
}else{ echo '<div class="alert"><h4>No se encontraron Resultados</h4></div>'; }
mysql_free_result($RSc); ?>
</div>