<?php $id=vParam('id',$_GET['id'],$_POST['id']);
$detFac=detRow('tbl_factura_com','id',$id);

$query_RSl = sprintf('SELECT tbl_compra_cab.com_num as sID, CONCAT(tbl_compra_cab.com_num," (",tbl_auditoria.aud_dat,")") as sVAL
FROM tbl_compra_cab
INNER JOIN tbl_auditoria ON tbl_compra_cab.aud_id=tbl_auditoria.aud_id
WHERE NOT EXISTS ( SELECT * FROM tbl_factura_com WHERE tbl_compra_cab.com_num = tbl_factura_com.com_num )
AND com_stat =1',
GetSQLValueString('1','int'));
$RSl = mysql_query($query_RSl) or die(mysql_error());
$TR_RSl=mysql_num_rows($RSl);
if($detFac){
	$action='UPDfacCom';
	$btnAct='<button type="submit" class="btn btn-block green" disabled>FACTURA GENERADA</button>';
	$detFac_fec=$detFac['fac_fec'];
}else{
	$action='INSfacCom';
	$btnAct='<button type="submit" class="btn btn-block blue">GENERAR FACTURA</button>';
	$detFac_fec=$sdate;
}
?>
<div class="container-fluid">
<h3 class="page-title">GENERAR FACTURA COMPRA <small>Selecciona una Compra y Generar Factura</small></h3>
<?php fnc_log();?>
<div class="well">
<form action="actionsFac.php" class="form-horizontal" method="post">
	<input type="hidden" name="form" value="formFacCom">
    <input type="hidden" name="action" value="<?php echo $action ?>">
    <div class="control-group">
    <label for="com_num" class="control-label">Compra</label>
    <div class="controls">
      <?php if($action=='UPDfacCom'){
		  	echo '<input type="text" name="fac_num" class="input-block-level" value="'.$detFac['com_num'].'" disabled>';;
		}else{ ?>
	  <?php echo generarselect('com_num',$RSl,$detFac['com_num'],'input-block-level','required');
	  }?>
    </div>
  </div>
  	<div class="control-group">
    <label class="control-label">Numero Factura</label>
    <div class="controls">
      <input type="text" name="fac_num" class="input-block-level" value="<?php echo $detFac['fac_num'] ?>" required>      
    </div>
  </div>
  	<div class="control-group">
    <label class="control-label">Fecha Factura</label>
    <div class="controls">
      <input type="date" name="fac_fec" class="input-block-level" value="<?php echo $detFac_fec; ?>" required>      
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Observaciones</label>
    <div class="controls">
      <input type="text" name="fac_obs" class="input-block-level" value="<?php echo $detFac['fac_obs'] ?>">      
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <?php echo $btnAct  ?>     
    </div>
  </div>
</form>
</div>
</div>