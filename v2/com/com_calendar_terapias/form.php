<?php include('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$fechaini=$_SESSION['dct']["fecha_ini"];
$horaini=$_SESSION['dct']["hora_ini"];
unset($_SESSION['dct']["fecha_ini"]);
unset($_SESSION['dct']["hora_ini"]);
$dTrat=detRow('db_terapias','id',$id);
$detSes=detRow('db_fullcalendar_sesiones','id_ter',$id);
if($detSes['fechai']==NULL){
	$detSes['fechai']=$fechaini;
	$detSes['horai']=$horaini;	
}
if($dTrat){
	$idp=$dTrat['idp'];
	$acc='UPD';
	$btnAcc='<button class="btn btn-success navbar-btn">ACTUALIZAR TERAPIA</button>';
}else{
	$acc='INS';
	$btnAcc='<button class="btn btn-success navbar-btn">CREAR TERAPIA</button>';
}

$detP=detRow('db_clientes','pac_cod',$idp);
$qryLTT=sprintf('SELECT * FROM db_terapias_vs_tratamientos WHERE id_ter=%s',
SSQL($id,'int'));
$RSltt=mysql_query($qryLTT);
$dRSltt=mysql_fetch_assoc($RSltt);

$css['body']='cero';
include(RAIZf.'head.php');
?>
<?php sLOG('g') ?>
<form action="actions.php" method="post">
<fieldset>
    <input name="form" type="hidden" id="form" value="AGE">
	<input name="id" type="hidden" id="id" value="<?php echo $id?>">
    <input name="idp" type="hidden" id="idp" value="<?php echo $idp?>">
    <input name="idc" type="hidden" id="idc" value="<?php echo $idc?>">
	<input name="acc" type="hidden" id="acc" value="<?php echo md5($acc)?>">
</fieldset>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">FISIO TERAPIAS <span class="label label-default"><?php echo $id ?></span></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Paciente</a></li>
        <li><a href="#"><?php echo $detP['pac_nom'].' '.$detP['pac_ape'] ?></a></li>        
      </ul>

      <div class="navbar-right">
        <?php echo $btnAcc ?>
        
      </div>
    </div>
  </div>
</nav>
<div class="container-fluid">
	<div class="row">
    	<div class="col-sm-4">
        <fieldset class="well form-horizontal">
            <div class="form-group">
            <label for="fechai" class="control-label col-sm-4">Fecha</label>
            <div class="col-sm-8">
            <input name="fechai" type="date" class="form-control" id="fechai" value="<?php echo $detSes['fechai'] ?>" placeholder="Fecha Inicio" onclick="loadFancyBoxcalendario();">
            </div>
            </div>
            <div class="form-group">
            <label for="horai" class="col-sm-4 control-label">Hora</label>
            <div class="col-sm-8">
            <input name="horai" type="time" class="form-control" id="horai" value="<?php echo $detSes['horai'] ?>" placeholder="Hora Inicio" readonly>
            </div>
            </div>
            <div class="form-group">
            <label for="terapia" class="col-sm-4 control-label">Terapista</label>
            <div class="col-sm-8">     
            <?php
            $qryle='SELECT tbl_usuario.usr_id as sID, CONCAT_WS(" ",db_empleados.emp_nom,db_empleados.emp_ape) as sVAL FROM tbl_usuario 
			INNER JOIN db_empleados ON tbl_usuario.emp_cod= db_empleados.emp_cod 
			WHERE usr_est=1';
            $RSle=mysql_query($qryle);			
            genSelect('idu', $RSle, $dTrat['id_usu'], 'form-control', 'required', NULL, 'Seleccione',TRUE)
            ?>           				
            </div>
            </div>
            <div class="form-group">
            <label for="num_ses" class="col-sm-4 control-label">N. Sesiones</label>
            <div class="col-sm-8">
            <input name="numSes" type="number" class="form-control" id="numSes" placeholder="Cantidad" value="<?php echo $dTrat['num_ses'] ?>" required>
            </div>
            </div>                
            <div class="form-group">
            <label for="Tiempo" class="col-sm-4 control-label">Tiempo en minutos</label>
            <div class="col-sm-8">
            <input name="min" type="text" class="form-control" id="min" placeholder="Minutos" value="30" requiered>
            </div>
            </div>                                       
        </fieldset>
        </div>                        
        <div class="col-sm-8">
        	<fieldset class="">           	 
                <legend>Tratamientos <a id="addTrat" onClick="btnAdd()" class="btn btn-xs btn-info pull-right">Agregar Tratamiento <i class="fa fa-plus"></i></a></legend>
                <table class="table table-bordered" id="CLTt">
                	<tr>
                    	<td>Tratamiento</td>
                        <td>Descripcion</td>
                        <td></td>
                    </tr>
                	<?php $ifN=0; ?>
					
					<?php do{ ?>
                    <?php
                    $arrTN[$ifN]=$dRSltt['id_trat'];
					$arrTD[$ifN]=$dRSltt['des'];
					?>
                    <tr class="info LTt" id="LT<?php echo $ifN ?>">
                    	<td><select name="TN[]" id="TN<?php echo $ifN ?>" class="form-control"></select></td>
                        <td><input type="text" name="TO[]" id="TO<?php echo $ifN ?>" class="form-control" value="<?php echo $dRSltt['des'] ?>"/></td>
                        <td><a onClick="btnRem(<?php echo $ifN ?>)" class="btn btn-default btn-xs btn-block">X</a></td>
                    </tr>
                    <?php $ifN++ ?>
					<?php }while($dRSltt=mysql_fetch_assoc($RSltt)); ?>
                    <?php $cLT=count($arrTN); ?>
                </ul>
            </fieldset>                                                          
        </div>                
    </div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	var arrayTN=<?php echo json_encode($arrTN) ?>;
	var nST=<?php echo intval($cLT) ?>;
	console.log ('nST. '+nST);
	var cST=0;
	if(nST>0){
		do{
			console.log ('Elemento. '+cST+'. Valor. '+arrayTN[cST]);
			loadTrat(cST,arrayTN[cST]);
			cST++;
		}while(cST<nST);
	}else loadTrat(0,0);
});	
function loadTrat(id,sel){
	sel=sel||'0';
	var miSel=$('#TN'+id);
	$.post('js_loadTrat.php',
	function (data){
		miSel.empty();
		console.log('Inicia For');
		for(var i=0; i<data.length; i++){
			console.log('Cada iteracion. '+i);
			if(sel==data[i].valor) miSel.append('<option value="'+data[i].valor+'" selected>'+data[i].nombre+'</option>');
			else miSel.append('<option value="'+data[i].valor+'">'+data[i].nombre+'</option>');
		}
	},'json');
}
function btnAdd(id) {
	try {
		var contELE=$('.LTt').length;
		//contELE++;
		$('#CLTt').append($('<tr>').attr('class','info LTt').attr('id','LT'+contELE)
		.append($('<td>')
		.append($('<select>').attr('name','TN[]').attr('id','TN'+contELE).attr('class','form-control'))
		).append($('<td>').append($('<input>').attr('type','text').attr('name','TO[]').attr('id','TO'+contELE).attr('class','form-control')))
		.append($('<td>').append($('<a>').attr('onclick','btnRem('+contELE+')').attr('class','btn btn-default btn-xs btn-block').append('X')))
		);
		loadTrat(contELE,0);
	}catch(e) {
		alert(e);
	}
}
function btnRem(id) {
	try {
		if($('.LTt').length>1) $('#LT'+id).remove();
		else alert('Debe enviar al menos 1 tratamiento');
	}catch(e) {
		alert(e);
	}
}

function loadFancyBoxcalendario(urlAge){
	//alert("OK");
	$.fancybox({
		type: 'iframe',
		href: '../com_calendar_terapias/',
		title: 'Calendario',
		preload  : true,
		autoSize : false,
		width    : "100%",
		height   : "100%",
		beforeClose: function() {
			location.reload();					
   		}
	});
};

</script>
</body>
</html>