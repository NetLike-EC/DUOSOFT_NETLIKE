<?php require('../../init.php');
$_SESSION['tab']['con']='cROB';
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$idr=vParam('idr',$_GET['idr'],$_POST['idr']);
$detRep=detRow('db_rep_obs','id',$idr);
if($action=='DELTF'){ header(sprintf("Location: %s", 'actions.php?idr='.$idr.'&action=DELTF')); }
if(!$detRep){
	$action='INS';
	$btnAcc='<button type="submit" class="btn btn-info navbar-btn"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
}else{
	$action='UPD';
	$btnAcc='<button type="submit" class="btn btn-success navbar-btn"><i class="fa fa-refresh"></i> ACTUALIZAR</button>';
	$idr=$detRep['id'];
	$idp=$detRep['pac_cod'];
	$idc=$detRep['con_num'];
	if(!$detRep['num_fet']) $detRep['num_fet']=totRowsTab('db_rep_obs_detalle','id_rep',$idr);
}
$detPac=detRow('db_clientes','pac_cod',$idp);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
$detCon=detRow('db_consultas','con_num',$idc);
include(RAIZf.'head.php');
?>
<body>
<?php sLOG('g'); ?>
<form method="post" action="actions.php" style="margin-bottom:0px;" id="formRep" enctype="multipart/form-data">
<fieldset>
	<input name="idr" type="hidden" id="idr" value="<?php echo $idr ?>">
    <input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
	<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
	<input name="acc" type="hidden" id="acc" value="<? echo md5($action)?>">
	<input name="form" type="hidden" id="form" value="repObs">
</fieldset>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-stethoscope fa-lg"></i> ECO. OBSTETRICA 
      <span class="label label-info"><?php echo $idr ?></span></a>
    </div>
	<div class="collapse navbar-collapse" id="navbar-collapse-2">
	
    <ul class="nav navbar-nav">
		<li class="active"><a><?php echo $detPac_nom ?></a></li>
        <li><a>Consulta <span class="label label-info"><?php echo $idc ?></span></a></li>
        <li><a><?php echo $detRep['fechar'] ?></a></li>
	</ul>
    
    
        <ul class="nav navbar-nav navbar-right">
        <li><a><div id="logF"></div></a></li>
		<li><a href="#"><div id="loading"><img src="<?php echo $RAIZia ?>images/struct/loader.gif"/></div></a></li>
        <li><div class="btn-group">
			<?php echo $btnAcc ?>
        
            <?php if($idr){ ?>
		<a href="<?php echo $RAIZc ?>com_reps/obs_print.php?id=<?php echo $idr ?>" class="btn btn-info navbar-btn"><i class="fa fa-print"></i></a>
        <?php } ?>
            <a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default navbar-btn"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-></a>
		</div></li>
        <li>
        
        </li>
        
        </ul>
        
        
        
        
	</div>
    </div>
</nav>
<div class="container-fluid">
<div class="">
	<div class="row">
    	<div class="col-sm-9 col-md-9">
            <fieldset class="form-horizontal form-min well well-sm" style="margin-bottom:10px;">
            <div class="row">
            <div class="col-xs-4">
				<div class="fileUpload btn btn-primary btn-sm btn-block">
				<span><i class="fa fa-cloud-upload fa-lg"></i> Cargar Datos</span>
				<input name="userfile" type="file" class="upload" id="userfile" onChange="uploadFile()" accept="text/plain" />
				</div>
            </div>
            <div class="col-xs-4">
            <div class="form-group">
            <label class="col-sm-4 control-label" for="fechae">Fecha</label>
            <div class="col-sm-8"><input name="fechae" type="date" class="form-control input-sm" id="fechae" placeholder="" value="<?php echo $detRep['fechae'] ?>"></div>
            </div>
            </div>
            <div class="col-xs-4">
            <div class="form-group">
            <label class="col-sm-4 control-label" for="fum">F.U.M.</label>
            <div class="col-sm-8"><input name="fum" type="date" class="form-control input-sm" id="fum" value="<?php echo $detRep['fum'] ?>"></div>
            </div>
            </div>
            </div>
            </fieldset>
            <div style="margin-bottom:10px;">
            <div class="row">
                <div class="col-xs-5">
                    <div class="">
                        
                    </div>
                </div>
                <div class="col-xs-7">
                    <div class="">
                        
                    </div>
                </div>
            </div>
            </div>
            
            <!-- Nav tabs -->
<?php

$qryRepDets=sprintf('SELECT * FROM db_rep_obs_detalle WHERE id_rep=%s',
SSQL($idr,'int'));
$RSrepD=mysql_query($qryRepDets) or (mysql_error());
$row_RSrepD=mysql_fetch_assoc($RSrepD);
$TR_RSrepD=mysql_num_rows($RSrepD);
?>          
<?php if($detRep){ ?>
<div id="panelFeto">
<ul class="nav nav-tabs">
  <?php for($p=1;$p<=$TR_RSrepD;$p++){ ?>
  <li class="<?php if($p==1) echo "active" ?>"><a href="#<?php echo $p ?>" data-toggle="tab"><abbr title="<?php echo $row_RSrepD['id'] ?>">FETO <?php echo $p ?></abbr></a></li>
  <?php } ?>
  <li><a href="actions.php?idr=<?php echo $idr ?>&acc=<?php echo md5('addFet') ?>"><i class="fa fa-plus"></i></a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
	<?php $contPanel=1; ?>
	<?php do{ ?>
    <?php $idD=$row_RSrepD['id']; ?>
  <div class="tab-pane <?php if($contPanel==1) echo "active" ?>" id="<?php echo $contPanel; ?>">
    	<div style="margin-bottom:10px;">
            <div class="row">
            	<div class="col-sm-6">
                
                <div class="panel panel-info">
                <div class="panel-body">
				<fieldset class="form-horizontal form-min">
                        <div class="form-group">
                            <label class="col-xs-4 control-label">FPP-FUM</label>
                            <div class="col-xs-8">
                            <input name="fpp_fum" type="date" class="form-control input-sm" id="fpp_fum" onKeyUp="setDB(this.name,this.value,'<?php echo $idD ?>')" value="<?php echo $row_RSrepD['fpp_fum'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-4 control-label">FPP-GA</label>
                            <div class="col-xs-8">
                            <input name="fpp_ga" type="date" class="form-control input-sm" id="fpp_ga" value="<?php echo $row_RSrepD['fpp_ga'] ?>" onKeyUp="setDB(this.name,this.value,'<?php echo $idD ?>')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-4 control-label">EG.x FUM</label>
                            <div class="col-xs-8">
                            <input name="eg_fum" type="text" class="form-control input-sm" id="eg_fum" value="<?php echo $row_RSrepD['eg_fum'] ?>" onKeyUp="setDB(this.name,this.value,'<?php echo $idD ?>')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-4 control-label">EG.x US</label>
                            <div class="col-xs-8">
                            <input name="eg_us" type="text" class="form-control input-sm" id="eg_us" value="<?php echo $row_RSrepD['eg_us'] ?>" onKeyUp="setDB(this.name,this.value,'<?php echo $idD ?>')">
                            </div>
                        </div>
                        </fieldset>
                </div>
                </div>
                
                
                </div>
                <div class="col-sm-6">
                
                <div class="panel panel-info">
                <div class="panel-body">
				<fieldset class="form-horizontal form-min">
                        <div class="form-group">
                            <label class="col-xs-4 control-label">Peso Fetal Aprx</label>
                            <div class="col-xs-8">
                            <input name="pes_fet" type="text" class="form-control input-sm" id="pes_fet" value="<?php echo $row_RSrepD['pes_fet'] ?>" onKeyUp="setDB(this.name,this.value,'<?php echo $idD ?>')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-4 control-label">N° Fetos</label>
                            <div class="col-xs-8">
                            <input name="num_fet" type="number" class="form-control input-sm" id="num_fet" value="<?php echo $row_RSrepD['num_fet'] ?>" onKeyUp="setDB(this.name,this.value,'<?php echo $idD ?>')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-4 control-label">Posición</label>
                            <div class="col-xs-8">
                            <?php genSelect('posicion',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_pos'),$row_RSrepD['posicion'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-4 control-label">Presentación</label>
                            <div class="col-xs-8">
                            <?php genSelect('presentacion',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_pres'),$row_RSrepD['presentacion'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                            </div>
                        </div>
                        </fieldset>
                </div>
                </div>
                
                
                </div>
            </div>
            <div class="row">
            <div class="col-xs-6">
                <div class="panel panel-info cero">
                <div class="panel-heading"><h3 class="panel-title">Valoración BioMétrica</h3></div>
                <div class="panel-body">
				<textarea name="val_bio" class="tmceDB form-control" id="val_bio" data-id="<?php echo $idD ?>"><?php echo $row_RSrepD['val_bio'] ?></textarea>
                </div>
                </div>
            </div>
            <div class="col-xs-6">
            <div class="panel panel-info cero">
                <div class="panel-heading"><h3 class="panel-title">Valoración BioFísica</h3></div>
                <div class="panel-body">
                <fieldset class="form-horizontal form-min">
                    <div class="form-group">
                        <label class="col-xs-6 control-label">Liquido Amiotico</label>
                        <div class="col-xs-6">
                        <?php genSelect('liq_ami',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_liq_ami'),$row_RSrepD['liq_ami'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-6 control-label">Placenta</label>
                        <div class="col-xs-6">
                        <?php genSelect('placenta',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_plac'),$row_RSrepD['placenta'],'form-control input-sm','onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                            <label class="col-xs-6 control-label">Grado</label>
						<div class="col-xs-6">
						<input name="grado" type="text" class="form-control input-sm" id="fcf" value="<?php echo $row_RSrepD['grado']  ?>" onKeyUp="setDB(this.name,this.value,<?php echo $idD ?>)">
                        </div>
                        </div>
                    
                    <div class="form-group">
                            <label class="col-xs-6 control-label">FCF</label>
						<div class="col-xs-6">
						<input name="fcf" type="text" class="form-control input-sm" id="fcf" value="<?php echo $row_RSrepD['fcf']  ?>" onKeyUp="setDB(this.name,this.value,<?php echo $idD ?>)">
                        </div>
                        </div>
                </fieldset>
                </div>
                </div>
            </div>
            </div>
            </div>
        <div class="panel panel-info" style="margin-bottom:10px;">
                <div class="panel-heading">
                  <h3 class="panel-title">Valoración Anatómica 
                  <span class="label label-primary">N : Normal</span> 
                  <span class="label label-primary">A : Anormal</span> 
                  <span class="label label-primary">NV : No Valorable</span> 
                  </h3></div>
                <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                    <fieldset class="form-horizontal form-min">
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="S.N.C.">S.N.C.</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_snc',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_snc'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Cerebelo">Cerebelo</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_cerebelo',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_cerebelo'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Ventrículo Lateral">Ventrículo Lat.</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_vent_lat',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_vent_lat'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Estómago">Estómago</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_estomago',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_estomago'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                </fieldset>
                    </div>
                    <div class="col-xs-4">
                    <fieldset class="form-horizontal form-min">
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Pared Abdominal">Pared Abdom.</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_par_abd',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_par_abd'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="4 Cámaras Cardiacas">4 Cam.Card.</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_4camcar',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_4camcar'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Estómago">Vejiga</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_vejiga',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_vejiga'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Estómago">Riñones</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_rin',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_rin'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                </fieldset>
                    </div>
                    <div class="col-xs-4">
                    <fieldset class="form-horizontal form-min">
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Columna">Columna</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_col',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_col'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Cordón Umbilical">Cord. Umbilical</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_cor_umb',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_cor_umb'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Extremidades">Extremidades</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_ext',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va'),$row_RSrepD['va_ext'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-7 control-label"><abbr title="Sexo">Sexo</abbr></label>
                        <div class="col-xs-5">
                        <?php genSelect('va_sex',detRowGSel('db_types','typ_cod','typ_val','typ_ref','robs_va_sexo'),$row_RSrepD['va_sex'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
                        </div>
                    </div>
                </fieldset>
                    </div>
                </div>
                </div>
                </div>
		<div style="margin-bottom:10px;">
            <div class="row">
            <div class="col-xs-6">
                <div class="panel panel-info cero">
                <div class="panel-heading"><h3 class="panel-title">COCIENTE</h3></div>
                <div class="panel-body">
                <textarea name="cocientes" class="tmceDB form-control" id="cocientes" data-id="<?php $idD ?>"><?php echo $row_RSrepD['cocientes']  ?></textarea>
                </div>
                </div>
            </div>
            <div class="col-xs-6">
            <div class="panel panel-info cero">
                <div class="panel-heading"><h3 class="panel-title">CONCLUSIÓN</h3></div>
                <div class="panel-body">
                	<textarea name="obs" class="form-control" id="obs" onKeyUp="setDB(this.name,this.value,'<?php echo $idD ?>')" rows="6"><?php echo $row_RSrepD['obs'] ?></textarea>
                </div>
                </div>
            </div>
            </div>
            </div>
  
  </div>
  <?php $contPanel++; ?>
  <?php }while($row_RSrepD = mysql_fetch_assoc($RSrepD)); ?>
</div>
</div>
<?php }else{ ?>
<div class="alert alert-warning">PARA EDITAR LOS DETALLES DEL REPORTE, PRIMERO DEBE GUARDARLO</div>
<?php } ?>
        </div>
        <div class="col-sm-3 col-md-3">
        	<div class="well well-sm">
            	<legend>Imagenes</legend>
                <?php if($detRep){
				$qryM=sprintf('SELECT * FROM db_rep_obs_media WHERE id_rep=%s',
				SSQL($idr,'int'));
				$RSm=mysql_query($qryM)or(mysql_error());
				$row_RSm=mysql_fetch_assoc($RSm);
				$TR_RSm=mysql_num_rows($RSm);
				
				?>
                <!--FORMULARIO CARGA IMAGENES -->
                <input name="userfileimg[]" id="userfileimg" type="file" onChange="uploadImage();" class="form-control" accept="image/gif, image/jpeg, image/png, image/bmp" multiple/>
                <?php if($TR_RSm>0){ ?>
                <div>
                <?php do{
				$detMedia=detRow('db_media','id_med',$row_RSm['id_med']);
				$detMedia_img=$RAIZidb.'ecografo/'.$detMedia['file'];
				$detMedia_imgt=$RAIZidb.'ecografo/t_'.$detMedia['file'];
				?>
                <div class="thumbnail">
                <a href="<?php echo $detMedia_img ?>" rel="repObs_media" class="fancybox">
				<img src="<?php echo $detMedia_imgt ?>">
                </a>
                <a href="actions.php?idr=<?php echo $idr ?>&id=<?php echo $row_RSm['id'] ?>&acc=<?php echo md5('DELROI') ?>" class="btn btn-danger btn-xs btn-block">
                <i class="fa fa-trash-o"></i> Eliminar</a>
                </div>
                <?php }while($row_RSm = mysql_fetch_assoc($RSm)); ?>
                </div>
                <?php }else{ ?>
                <div class="alert alert-info">Sin Imagenes</div>
                <?php } ?>
                <?php }else{ ?>
              <div class="alert alert-warning">Primero debe cargar los Datos</div>
				<?php } ?>
            </div>
        </div>
    </div>
</div>
</div>
</form>
<script type="text/javascript">
function uploadFile() {
	formRep.submit();
}
function uploadImage() {
	formRep.submit();
}

function setDB(campo, valor, cod){
	//alert(campo+"-"+valor);
	$.get( "jsactions.php", { campo: campo, valor: valor, cod: cod, tbl: 'repObs'}, function( data ) {
		showLoading();
		hideLoading();
		$("#logF").slideDown(200).text(data.inf).delay(3800).slideUp(200);
	}, "json" );
}	
</script>
</body>
</html>