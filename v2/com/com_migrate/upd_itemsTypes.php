<?php include('../../init.php');
$token=vParam('token',$_GET['token'],$_POST['token']);
$nI=vParam('nI',$_GET['nI'],$_POST['nI']);
$nF=vParam('nF',$_GET['nF'],$_POST['nF']);
$idC=vParam('idC',$_GET['idC'],$_POST['idC']);
$vDO=vParam('vDO',$_GET['vDO'],$_POST['vDO']);
$qryLP=sprintf('SELECT item_id as sID, item_id as sVAL FROM tbl_items WHERE item_status=1 ORDER BY item_id DESC');
$RSlpi=mysql_query($qryLP);
$RSlpf=mysql_query($qryLP);
$cssBody='cero';
include(RAIZf.'_head.php'); ?>
<div class="container-fluid">
<h1 class=""><small class="label label-info">DB</small> update CATEGORY in ITEMS (tbl_items)</h1>
<div class="well">
<form class="form-inline" method="get" action="<?php echo $urlc ?>">
	<label class="control-label">TOKEN</label>
    <input name="token" value="<?php echo $token ?>" class="form-control input-sm" required/>
    <label class="control-label">PROD DESDE</label>
    <?php echo generarselect('nI', $RSlpi, $nI, 'form-control','required'); ?>
    <label class="control-label">PROD HASTA</label>
    <?php echo generarselect('nF', $RSlpf, $nF, 'form-control','required'); ?>
    <label class="control-label">CATEGORIA</label>
    <?php echo generarselect('idC', detRowGSel('tbl_items_type','typID','typNom','typEst','1','ORDER BY typNom ASC'), $idC, 'form-control','required'); ?>
    <label class="control-label">Delete Olds?</label>
    <input type="checkbox" name="vDO" value="1">
    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-chevron-right fa-lg"></i> ACTUALIZAR</button>
</form>
</div>
</div>
<div class="container">
<?php
if($_GET['token']=='db2015..'){
	if(($nF)&&($nI)){
		if($nF>=$nI){
			if($idC){
				//$vDO=TRUE;
				$contR=0;
				echo '<ul>';
				for ($x = $nI; $x <= $nF; $x++) {
					if($vDO==TRUE){
						$qryD=sprintf('DELETE FROM tbl_items_type_vs WHERE item_id=%s',
						GetSQLValueString($x,'int'));
						if(mysql_query($qryD)){ $LOG='Delete Old Cats';
						}else{ $LOG='Error while delete Old Cats. '.mysql_error(); }
					}
					$qry=sprintf('INSERT INTO tbl_items_type_vs (item_id, typID) VALUES (%s,%s)',
					GetSQLValueString($x,'int'),
					GetSQLValueString($idC,'int'));
					if(mysql_query($qry)){
						$idI=mysql_insert_id();
						echo "<li>SUCCESS INSERT. ID: ".$idI.'. Item: '.$x.'<br>'.$LOG.'</li>'; 
					}else{
						echo "<li>Error. ".mysql_error()."<br>".$LOG."</li>";
					}
					$contR++;
				}//End for
				echo '</ul>';
				echo "<h4>Registros Generados. ".$contR."</h4>";
			}else $LOGe= '<h4>Categoria no seleccionada, Campo Obligatorio</h4>';
		}else $LOGe= '<h4>PROD HASTA debe ser mayor que PROD DESDE</h4>';
	}else $LOGe= '<h4>Valores Obligatorios PROD DESDE y PROD HASTA</h4>';
}else $LOGe= '<h4>Invalid Token</h4>';
?>
<?php if($LOGe){ ?>
<div class="alert alert-danger"><?php echo $LOGe ?></div>
<?php } ?>
</div>
<script>
$(document).on('ready', function(){			
	$( "#nI" ).chosen();
	$( "#nF" ).chosen();
	$( "#idC" ).chosen();
});
</script>
<?php include(RAIZf.'_foot.php');?>