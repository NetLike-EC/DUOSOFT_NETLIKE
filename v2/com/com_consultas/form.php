<?php include('../../init.php');
$dM=vLogin('CONSULTA');
$tabS=$_SESSION['tab']['con'];
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$idp=vParam('idp', $_GET['idp'], $_POST['idp']);
$idc=vParam('idc', $_GET['idc'], $_POST['idc']);
$idr=vParam('idr', $_GET['idr'], $_POST['idr']);

$dRes=detRow('db_fullcalendar', 'id', $idr);
$dCon=detRow('db_consultas','con_num',$idc);

if($dRes) $acc='NEW';

if($dCon) $idp=$dCon['cli_id'];
$dPac=detRow('db_clientes','cli_id',$idp);

if($dPac){
	if($acc!='NEW'){
		if(!$dCon) $dCon=detRow('db_consultas','cli_id',$idp,'con_num','DESC');
		$idc=$dCon['con_num'];
	}
}
if($dRes){
	$estCon=3;//Reservada
}else{
	$estCon=$dCon['con_stat'];
}

if($dCon){
	$acc='UPD';
	$btn_action_form='<button type="submit" class="btn btn-success navbar-btn"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
}else{	
	$acc='INS';
	$btn_action_form='<button type="submit" class="btn btn-info navbar-btn"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR CONSULTA</button>';	
}
$dirimg=fncImgExist("data/db/pac/",lastImgPac($idp));
$stat=estCon($estCon);//Devuelve el estado de la Consulta en HTML
//$_SESSION['idp']=$dPac['cli_id'];//Guarda al paciente en una session para mantenerlo durante la navegacion

include(RAIZf.'head.php');
include(RAIZm.'mod_menu/menuMain.php');
?>
<?php if($dPac){ ?>
<form action="actions.php" method="post">
<fieldset>
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>" />
		<input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>" />
		<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>" />
        <input name="idr" type="hidden" id="idr" value="<?php echo $idr ?>" />
		<input name="cons_stat" type="hidden" id="cons_stat" value="<?php echo $dCon['con_stat']; ?>" />
		<input name="mod" type="hidden" id="mod" value="consForm" />
</fieldset>
<div class="container-fluid">


<!--NVBAR TOP-->
<nav class="navbar navbar-default cero">
<div class="container-fluid">
    <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-cons-est">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="#"><?php echo $dM['mod_nom'] ?> <span class="label label-info"><?php echo $idc ?></span> 
    <span class="label label-default">Visita <?php echo detNumConAct($idc,$idp) ?></span></a>
	</div>
    <div class="collapse navbar-collapse" id="navbar-cons-est">
		<ul class="nav navbar-nav">
		<li><div class="btn-group">
        <?php echo $status_cons ?>
		<button type="button" class="btn btn-default navbar-btn disabled">Estado</button>
		<?php echo $stat['inf'] ?>
    </div></li>
	</ul>
      
    <ul class="nav navbar-nav pull-right">
		<li><div class="btn-group">
			<?php echo $btn_action_form ?>
			<a href="<?php echo $urlcurrent ?>?idp=<?php echo $dPac['cli_id']; ?>&acc=NEW" class="btn btn-default navbar-btn">
            <i class="fa fa-file-o"></i> NUEVA</a>
		</div></li>
        </ul>
        
	</div>
</div>
</nav>
<?php include('_fra_con_dat.php') ?>
<?php sLOG('g') ?>
    <div class="row">
		<div class="col-md-7">
			<div class="row">
        	<div class="col-md-2 text-center"><a href="<?php echo $dirimg?>" class="fancybox">
            <img src="<?php echo $dirimg?>" class="img-thumbnail img-responsive imgPacCons"/>
            </a></div>
            <div class="col-md-10">
            <?php include('_fra_con_detpac.php') ?>
            </div>
        </div>
		</div>
		<div class="col-md-5">
			<?php include('_fra_histCons.php') ?>
		</div>
    </div>
	<div class="well well-sm">
	<div class="tabbable">
    <div class="row">
	<div class="col-md-2">
    <ul class="nav nav-pills nav-stacked">
			<li class="<?php if(!$tabS) echo 'active' ?>">
            	<a href="#cHC" data-toggle="tab" title="" onClick="setTab(this.title)">
            	<i class="fa fa-book fa-lg"></i> Historia Clinica</a></li>
            <li class="<?php if($tabS=='cCON') echo 'active' ?>">
            	<a href="#cCON" data-toggle="tab" title="cCON" onClick="setTab(this.title)">
            	<i class="fa fa-user-md fa-lg"></i> Consulta</a></li>
			<li class="<?php if($tabS=='cTRA') echo 'active' ?>">
            	<a href="#cTRA" data-toggle="tab" title="cTRA" onClick="setTab(this.title)">
            	<i class="fa fa-columns fa-lg"></i> Medicacion</a></li>            
            <li class="<?php if($tabS=='cTER') echo 'active' ?>">
            	<a href="#cTER" data-toggle="tab" title="cTER" onClick="setTab(this.title)">
            	<i class="fa fa-columns fa-lg"></i> Terapias</a></li>
            <li class="<?php if($tabS=='cEXA') echo 'active' ?>">
            	<a href="#cEXA" data-toggle="tab" title="cEXA" onClick="setTab(this.title)">
            	<i class="fa fa-list-alt fa-lg"></i> Exámenes</a></li>
            <li class="<?php if($tabS=='cCIR') echo 'active' ?>">
            	<a href="#cCIR" data-toggle="tab" title="cCIR" onClick="setTab(this.title)">
            	<i class="fa fa-medkit fa-lg"></i> Cirugías</a></li>
            <li class="<?php if($tabS=='cDOC') echo 'active' ?>">
            	<a href="#cDOC" data-toggle="tab" title="cDOC" onClick="setTab(this.title)">
            	<i class="fa fa-file-o fa-lg"></i> Documentos</a></li>
            <li class="<?php if($tabS=='cANT') echo 'active' ?>">
            	<a href="#cANT" data-toggle="tab" title="cANT" onClick="setTab(this.title)">
            	<i class="fa fa-history fa-lg"></i> Historia Anterior</a></li>
		</ul>
	</div>
    <div class="col-md-10">
        <div class="tab-content">
            <div class="tab-pane <?php if(!$tabS) echo 'active' ?>" id="cHC">
				<?php include('historia_det.php')?>
            </div>
            <div class="tab-pane <?php if($tabS=='cCON') echo 'active' ?>" id="cCON">
            	<?php include('consulta_det.php');?>
            </div>
            <div class="tab-pane <?php if($tabS=='cTRA') echo 'active' ?>" id="cTRA">
            	<?php if($dCon){ include(RAIZc.'com_tratamientos/tratamiento_con_list.php');
            	}else{ echo '<div class="alert alert-warning"><h4>Primero Guarde la Consulta</h4>'.$btn_action_form.'</div>'; }?>
			</div>
            <div class="tab-pane <?php if($tabS=='cTER') echo 'active' ?>" id="cTER">
            	<?php include(RAIZc.'com_fisioterapias/terapia_con_list.php')?>
            </div>
            <div class="tab-pane <?php if($tabS=='cEXA') echo 'active' ?>" id="cEXA">
            	<?php include(RAIZc.'com_examen/examenes_con_list.php')?>
			</div>
            <div class="tab-pane <?php if($tabS=='cCIR') echo 'active' ?>" id="cCIR">
            	<?php include(RAIZc.'com_cirugia/cirugias_con_list.php')?>
			</div>
            <div class="tab-pane <?php if($tabS=='cDOC') echo 'active' ?>" id="cDOC">
            	<?php include(RAIZc.'com_docs/documentos_con_list.php')?>
			</div>        
            <div class="tab-pane <?php if($tabS=='cANT') echo 'active' ?>" id="cANT">
            	<?php include('consulta_ant.php');?>
			</div>               
        </div>
	</div>

</div>
</div>
</div>
</div>
</form>
<?php }else{ ?>
<div class="alert alert-danger"><h4>Error Paciente No Existe</h4></div>
<?php } ?>
<script type="text/javascript" src="js/js_carga_list-cons-pac.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#con_diagd').chosen({});	
	var contlog = $("#log"); contlog.delay(3800).slideUp(200);
});
function setDB(campo, valor, cod, tbl){
	$.get( RAIZc+"com_comun/actionsJS.php", { campo: campo, valor: valor, cod: cod, tbl: tbl}, function( data ) {
		showLoading();
		$("#logF").show(100).text(data.inf).delay(3000).hide(200);
		hideLoading();
	}, "json" );
	}
function setTab(val){
	$.get( "setTabJS.php", { val: val}, function( data ) {});
}
</script>
<?php include(RAIZf."footer_clean.php");?>
