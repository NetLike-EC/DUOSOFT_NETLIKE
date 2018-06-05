<?php require_once('../../init.php');
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);

$detPac=detRow('db_clientes','pac_cod',$idp);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];

$detRes=detRow2P('db_consultas_reserva','pac_cod',$idp,'estado','1',' AND ');
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container">
<div class="page-header"><h1>Reservar Consulta <small><?php echo $detPac_nom ?> 
<span class="label label-info"><?php echo $detPac['pac_cod']; ?></span></small></h1></div>
<?php sLOG('a') ?>
<!-- VERIFICACION RESERVA EXISTENTE PACIENTE -->
<?php if ($detRes){ ?>
<div class="alert alert-error"><h4>Paciente ya tiene una reserva!</h4></div>
<table class="table table-bordered">
<tr>
	<td>Res. ID:</td>
	<td><?php echo $detRes['id'] ?></td>
</tr>
<tr>
	<td>Fecha:</td>
	<td><?php echo $detRes['fecha'] ?></td>
</tr>
<tr>
	<td>Reservado por:</td>
	<td><?php echo $detRes['id_aud'] ?></td>
</tr>
<tr>
	<td colspan="2"><a class="btn btn-danger btn-block" href="action_res.php?id=<?php echo $detRes['id']; ?>&acc=anu"> Anular Reserva <i class="fa fa-exclamation-triangle"></i> </a></td>
</tr>
</table>
<?php }else{ ?>
<div id="cont_head">
<form action="action_res.php" method="post">
<input name="idp" type="hidden" id="idp" value="<?php echo $detPac['pac_cod']; ?>" />
<input name="acc" type="hidden" id="acc" value="INS" />
<fieldset class="form-horizontal">
<div class="form-group">
	<label for="" class="col-sm-4 control-label">Fecha Reserva</label>
    <div class="col-sm-8">
      <input name="formFec" type="date" size="10" maxlength="10" class="form-control" required/>
    </div>
</div>
<div class="form-group">
	<label for="" class="col-sm-4 control-label">Hora</label>
    <div class="col-sm-8">
      <input name="formHor" type="time" class="form-control" max="18:30" min="9:30" step="30" required/>
    </div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-info btn-block">Reservar</button>
	</div>
</div>
</fieldset>
</form>
</div>
<?php } ?>
</div>
</body>
</html>