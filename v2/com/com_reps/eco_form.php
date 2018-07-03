<?php require('../../init.php');
$_SESSION['tab']['con']='cECO';
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$idr=vParam('idr',$_GET['idr'],$_POST['idr']);
$detRep=detRow('db_rep_eco','id',$idr);
$idD=$idr;//IDd para pasar al setDB en jquery
if(!$detRep){
	$action='INS';
	$btnAcc='<button type="submit" class="btn btn-large btn-info"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
	$detRep_hall=detRepEco_hall();
}else{
	$action='UPD';
	$btnAcc='<button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> ACTUALIZAR</button>';
	$idr=$detRep['id'];
	$idp=$detRep['cli_id'];
	$idc=$detRep['con_num'];
	$detRep_hall=$detRep['eco_hall'];
}
$detPac=detRow('db_clientes','cli_id',$idp);
$detcli_nom=$detPac['cli_nom'].' '.$detPac['cli_ape'];
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
	<input name="form" type="hidden" id="form" value="repEco">
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
      <a class="navbar-brand" href="#"><i class="fa fa-stethoscope fa-lg"></i> ECO. GINECOLOGICA 
      <span class="label label-info"><?php echo $idr ?></span></a>
    </div>
	<div class="collapse navbar-collapse" id="navbar-collapse-2">
    <ul class="nav navbar-nav">
		<li class="active"><a><?php echo $detcli_nom ?></a></li>
        <li><a>Consulta <span class="label label-info"><?php echo $idc ?></span></a></li>
        <li><a><?php echo $detRep['fechar'] ?></a></li>
	</ul>
	<div class="navbar-right btn-group navbar-btn">
		<?php echo $btnAcc?>
        <?php if($idr){ ?>
		<a href="<?php echo $RAIZc ?>com_reps/eco_print.php?id=<?php echo $idr ?>" class="btn btn-info"><i class="fa fa-print"></i></a>
        <?php } ?>
		<a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-></a>
		</li>
	</div>
    <ul class="nav navbar-nav navbar-right">
		<li><a id="logF"></a></li>
        <li><a href="#"><div id="loading"><img src="<?php echo $RAIZi ?>struct/loading6.gif"/></div></a></li>
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
				<input name="userfile" type="file" class="upload" id="userfile" onChange="uploadFile()" accept="text/plain"/>
				</div>
            </div>
            <div class="col-xs-4">
            <div class="form-group">
            <label class="col-sm-4 control-label">Fecha</label>
            <div class="col-sm-8"><input name="fechae" type="date" class="form-control input-sm" id="fechae" placeholder="" value="<?php echo $detRep['fechae'] ?>"></div>
            </div>
            </div>
            <div class="col-xs-4">
            <div class="form-group">
            <label class="col-sm-4 control-label">Tipo</label>
            <div class="col-sm-8">
            <?php genSelect('tipo',detRowGSel('db_types','typ_cod','typ_val','typ_ref','reco_tip'),$detRep['tipo'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$idD.')"'); ?>
            </div>
            </div>
            </div>
            </div>
            </fieldset>
            
            

<div>

<div style="margin-bottom:10px;">
            <div class="row">
            <div class="col-xs-6">
                <div class="panel panel-primary cero">
                <div class="panel-heading"><h3 class="panel-title">HALLAZGOS</h3></div>
                <div class="panel-body">
                <textarea name="eco_hall" class="tmceDB" id="eco_hall" data-id="<?php echo $idD ?>"><?php echo $detRep_hall ?></textarea>
                </div>
                </div>
            </div>
            <div class="col-xs-6">
            <div class="panel panel-primary cero">
                <div class="panel-heading"><h3 class="panel-title">OTROS HALLAZGOS</h3></div>
                <div class="panel-body">
                	<textarea name="eco_ohall" class="tmceDB" id="eco_ohall" data-id="<?php echo $idD ?>"><?php echo $detRep['eco_ohall']  ?></textarea>
                </div>
                </div>
            </div>
            </div>
            </div>
<div style="margin-bottom:10px;">
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title">UTERO</h3></div>
            <div class="panel-body">
                <fieldset class="form-horizontal form-min">
                <div class="form-group">
                <div class="col-xs-12">
                <textarea name="rec_utero" class="tmceDB" id="rec_utero" data-id="<?php echo $idD ?>"><?php echo $detRep['rec_utero'] ?></textarea>
                </div>
                </div>
                </fieldset>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title">OVARIO DERECHO</h3></div>
            <div class="panel-body">
                <fieldset class="form-horizontal form-min">
                <div class="form-group">
                <div class="col-xs-12">
                <textarea name="rec_ovder" class="tmceDB" id="rec_ovder" data-id="<?php echo $idD ?>"><?php echo $detRep['rec_ovder'] ?></textarea>
                </div>
                </div>
                <div class="form-group">
                <label class="col-xs-4 control-label">Descripción</label>
                <div class="col-xs-8">
                <textarea name="obs_ovder" class="form-control" onKeyUp="setDB(this.name,this.value,'<?php echo $idD ?>')"><?php echo $detRep['obs_ovder'] ?></textarea>
                </div>
                </div>
                </fieldset>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title">OVARIO IZQUIERDO</h3></div>
            <div class="panel-body">
                <fieldset class="form-horizontal form-min">
                <div class="form-group">
                <div class="col-xs-12">
                <textarea name="rec_ovizq" class="tmceDB" id="rec_ovizq" data-id="<?php echo $idD ?>"><?php echo $detRep['rec_ovizq'] ?></textarea>
                </div>
                </div>
                <div class="form-group">
                <label class="col-xs-4 control-label">Descripción</label>
                <div class="col-xs-8">
                <textarea name="obs_ovizq" class="form-control" onKeyUp="setDB(this.name,this.value,'<?php echo $idD ?>')"><?php echo $detRep['obs_ovizq'] ?></textarea>
                </div>
                </div>
                </fieldset>
            </div>
            </div>
        </div>
    </div>
</div> 
<div style="margin-bottom:10px;">
            <div class="panel panel-primary">
                <div class="panel-heading"><h3 class="panel-title">DIAGNOSTICO</h3></div>
                <div class="panel-body">
				<fieldset class="form-horizontal form-min">
                <textarea name="eco_diag" class="tmceDB" id="eco_diag" data-id="<?php echo $idD ?>" rows="4"><?php echo $detRep['eco_diag'] ?></textarea>
                </fieldset>
                </div>
                </div>
            </div> 

</div>
            
            
        </div>
        <div class="col-sm-3 col-md-3">
        	<div class="well well-sm">
            	<legend>Imagenes</legend>
                <?php if($detRep){
				$qryM=sprintf('SELECT * FROM db_rep_eco_media WHERE id_eco=%s',
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
                <a href="actions.php?idr=<?php echo $idr ?>&id=<?php echo $row_RSm['id'] ?>&acc=<?php echo md5('DELREI') ?>" class="btn btn-danger btn-xs btn-block">
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
	$.get( "jsactions.php", { campo: campo, valor: valor, cod: cod, tbl: 'repEco'}, function( data ) {
		showLoading();
		hideLoading();
		$("#logF").slideDown(200).text(data.inf).delay(4000).slideUp(200);
	}, "json" );
}	
</script>
</body>
</html>