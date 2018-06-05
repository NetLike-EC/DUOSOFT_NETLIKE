<?php
if($dCon['con_fec']){
	$dCon_fec=date("d M Y",strtotime($dCon['con_fec']));
}else{
	$dCon_fec=date("d M Y");
}
?>
<nav class="navbar navbar-inverse" style="margin:0px">
<div class="container-fluid">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-cons-dat">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Fecha</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-cons-dat">
        <ul class="nav navbar-nav">
        	<li style="font-size:120%"><a><abbr title="Actualizada. <?php echo $dCon['con_upd']; ?>">
             <?php echo $dCon_fec ?></abbr></a></li>
		</ul>
		<div class="navbar-form navbar-left">
		<div class="form-group">
			<?php genSelect('con_typ',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TIPCON'),$dCon['con_typ'],'form-control input-sm', ' onChange="setDB(this.name,this.value,'.$idc.','."'con'".')"'); ?>
		</div>
        <div class="form-group">
        	<a href="<?php echo $RAIZc ?>com_comun/gest_diag.php" class="btn btn-default btn-xs fancybox fancybox.iframe fancyreload" onClick="ansclose=false;"><i class="fa fa-plus-square-o"></i> Diagnosticos</a>
        </div>
        <div class="form-group">
        	<?php genSelect('con_diagd',detRowGSel('db_diagnosticos','id_diag','nombre','estado','1'),$dCon['con_diagd'],'form-control',' onChange="setDB(this.name,this.value,'.$idc.','."'con'".')"');?>
        </div>
        <div class="form-group">
			<input name="con_val" type="text" value="<?php echo $dCon['con_val']; ?>" class="form-control input-sm" placeholder="Valor" onChange="setDB(this.name,this.value,'<?php echo $idc ?>','con')"/>
        </div>
        <div class="form-group">
        	<?php genSelect('tip_pag',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TIPPAG'),$dCon['tip_pag'],'form-control input-sm', ' onChange="setDB(this.name,this.value,'.$idc.','."'con'".')"'); ?>        </div>
        
		</div>
	</div>
</div>
</nav>