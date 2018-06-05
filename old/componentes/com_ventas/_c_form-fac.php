<?php $id=vParam('id',$_GET['id'],$_POST['id']);
$fac_num=vParam('fac_num',$_GET['fac_num'],$_POST['fac_num']);
if(!$fac_num){ $detFac=detRow('tbl_factura_ven','ven_num',$id);}
else{$detFac=detRow('tbl_factura_ven','fac_num',$fac_num);}
$num_fac=fnc_numMaxFac();
if($detFac){
	$id=$detFac['ven_num'];
	$detVen=detRow('tbl_venta_cab','ven_num',$detFac['ven_num']);
	$detAud=detAUD($detFac['aud_id']);
	$action='UPDfacVen';
	$btnAct='<button type="submit" class="btn btn-block green" disabled>FACTURA GENERADA</button>';
	$detFac_fec=$detFac['fac_fec'];
}else{
	$action='INSfacVen';
	$btnAct='<button type="submit" class="btn btn-block blue">GENERAR FACTURA</button>';
	$detFac_fec=$sdate;
}
?>
<div class="container-fluid">
<h3 class="page-title">GENERAR FACTURA VENTA <small>Selecciona una Venta y Generar Factura</small></h3>
<?php fnc_log();?>
<div class="well">
<form action="actionsFac.php" class="form-horizontal" method="post">
	<input type="hidden" name="form" value="formFacVen">
    <input type="hidden" name="action" value="<?php echo $action ?>">
    <input type="hidden" name="ven_num" value="<?php echo $id ?>">
    
    <div class="control-group">
    <label class="control-label">Venta Numero</label>
    <div class="controls">
      <span class="label"><?php echo $id ?></span>      
    </div>
  </div>
  	<div class="control-group">
    <label class="control-label">Numero Factura</label>
    <div class="controls">
      <span class="label"><?php echo $num_fac ?></span>
    </div>
  </div>
  	<div class="control-group">
    <label class="control-label">Fecha Factura</label>
    <div class="controls">
      <input type="datetime" class="input-block-level" value="<?php echo $detAud['aud_dat']; ?>" disabled>      
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