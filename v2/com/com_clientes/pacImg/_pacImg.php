<?php 
$id=vParam('idp', $_GET['idp'], $_POST['idp']);
$dPac=detRow('db_pacientes','cli_id',$id);
if($dPac){
	$qRSip = sprintf("SELECT * FROM db_pacientes_media WHERE cod_pac = %s ORDER BY id DESC LIMIT 16", SSQL($id, "int"));
	$RSip = mysql_query($qRSip) or die(mysql_error());
	$dRSip = mysql_fetch_assoc($RSip);
	$tRSip = mysql_num_rows($RSip);
}
?>
<div class="navbar navbar-fixed-top navbar-inverse">

	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-capture">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">CAPTURA PACIENTE</a>
	</div>
	<?php if($dPac){ ?>
	<div class="collapse navbar-collapse" id="navbar-capture">
		<ul class="nav navbar-nav">
			<li class="active"><a href="#"><?php echo $dPac['cli_nom'].' '.$dPac['cli_ape'] ?></a></li>
			<li onclick="location.reload()"><a><i class="icon-camera icon-white"></i> CAPTURAR</a></li>
			<li class="loadFramePacImg" rel="pacImgUpl.php" data-id="<?php echo $id ?>"><a><i class="icon-camera icon-white"></i> CARGA</a></li>
			<li onclick="location.reload()"><a><i class="icon-refresh icon-white"></i> RECARGAR</a></li>
			<li onclick="parent.$.fancybox.close();"><a>SALIR</a></li>
		</ul>
	</div><!-- .navbar-collapse -->
	<?php } ?>
</div>
<div class="container-fluid">
	<?php if($dPac){ ?>
	<div class="row">
    	<div class="col-sm-10">
        	<div width="100%" height="450px" id="divLIP">
        		<?php include('pacImgCap.php') ?>
        	</div>
        </div>
        <div class="col-sm-2">
        
        	<?php if($tRSip>0){ ?>
            <div class="panel panel-info">
            	<div class="panel-heading"><a onclick="location.reload()" class="btn btn-info btn-xs pull-right"><i class="fa fa-refresh fa-lg"></i></a> Historial de Images</div>
                <div class="panel-body">
                
                <div class="row">
                  <?php do { ?>
                    <?php $dMed=detRow('db_media','id_med',$dRSip['id_med']);
                    $dMed_img=fncImgExist("data/db/pac/",$dMed['file']); ?>
                        <div class="col-sm-12 col-md-6">
                        <div class="thumbnail">
                        <a href="<?php echo $dMed_img ?>" class="fancybox"><img src="<?php echo $dMed_img ?>"/></a>
                        <a onclick="deleteimg_history(<?php echo $dRSip['id'] ?>)" class="btn btn-default btn-xs btn-block"><i class="fa fa-trash"></i> Eliminar</a>
                        </div>
                        </div>
                    <?php } while ($dRSip = mysql_fetch_assoc($RSip)); ?>
                </div>
                
                </div>
            </div>
    		
			<?php }else{ echo '<div class="alert alert-info"><h4><a onclick="location.reload()" class="btn btn-info btn-xs"><i class="fa fa-refresh"></i></a> Sin Historial</h4></div>'; }?>
        
        </div>
    </div>
    <?php mysql_free_result($RSip) ?>
	<?php }else{ ?>
	<div class="alert alert-warning"><h4>Paciente no seleccionado</h4></div>
	<?php } ?>
</div>