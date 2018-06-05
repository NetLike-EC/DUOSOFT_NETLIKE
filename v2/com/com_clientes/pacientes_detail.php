<?php include('../../init.php');
$idcli=vParam('cli_sel_find', $_GET['cli_sel_find'], $_POST['cli_sel_find']);
$datapac=dPac($idcli);
$_SESSION['idp']=null; //REVISAR
$_SESSION['idp']=$datapac['pac_cod']; //REVISAR
$detPacFin_name=$datapac['pac_nom'].' '.$datapac['pac_ape'];
$_SESSION['sBr']=$detPacFin_name;
$dirimg=fncImgExist("images/db/pac/",lastImgPac($datapac['pac_cod']));
$detPacFin_img='<img src="'.$dirimg.'" class="img-thumbnail" style="max-width:70px; max-height:70px;"/>';
$detPacFin_ced=$datapac['pac_ced'];

$btnActionFind;
if($_SESSION['MODSEL']=="CON"){
	$btnActionFind.='<a href="form.php?idp='.$idcli.'" class="btn btn-primary btn-xs"><i class="fa fa-stethoscope fa-lg"></i> Consulta</a>';
	$btnActionFind.='<a href="'.$RAIZc.'com_calendar/reserva_form.php?idp='.$idcli.'" class="btn btn-default btn-xs  fancybox.iframe fancyreload"><i class="fa fa-calendar-o"></i> Reserva</a>';
}else if($_SESSION['MODSEL']=="PAC"){
	$btnActionFind='<a href="form.php?id='.$idcli.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-user"></i> Ficha</a>';
}else if($_SESSION['MODSEL']=="PAG"){
	$btnActionFind='<a onclick="load_pagos('."'".$datapac['pac_cod']."'".')" class="btn"><i class="icon-th"></i></a>';
}else if($_SESSION['MODSEL']=="FAC"){
	$btnActionFind='<a onclick="load_factura('."'".$datapac['pac_cod']."'".')" class="btn"><i class="icon-th-list"></i></a>';
}

$detPacFin_edad=edad($datapac['pac_fec']);

?>
<div class="well well-sm" style="font-size:0.8em; padding:5px; margin:0px; background-color:#FFF;">
<div class="row">
	<div class="col-md-3 text-center"><?php echo $detPacFin_img ?></div>
    <div class="col-md-2 text-center"><?php echo $btnActionFind?></div>
	<div class="col-md-7">
	<table class="table table-condensed table-bordered" style="margin:0px;">
    	<tr><td><?php echo $detPacFin_name ?></td></tr>
        <tr><td><?php echo $detPacFin_ced ?></td></tr>
        <tr><td><?php echo $detPacFin_edad ?></td></tr>
    </table>
    </div>
</div>
</div>