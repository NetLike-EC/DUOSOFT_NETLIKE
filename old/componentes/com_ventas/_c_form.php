<script type="text/javascript" src="<?php echo $RAIZj ?>js_carga_pac.js"></script>
<?php sLOG('g');
$num_cic=fnc_numIniCic();
$num_fac=fnc_numMaxFac();
?>
<div class="container-fluid">
<form id="form_compra_cab" name="form_compra_cab" method="post" action="fnc_agregar.php">
<h3 class="page-header"><?php echo $rowMod['mod_nom'] ?> <small><?php echo $rowMod['mod_des'] ?></small>
<div class="btn-group pull-right">
<input type="submit" name="btn_action" id="btn_action" value="GRABAR" onclick="return confirm('Desea Grabar?');" class="btn blue">
<a href="<?php echo $RAIZc?>com_ventas/" class="btn black"><i class="icon-remove"></i> Cancelar</a>
</div>
</h3>
<div class="portlet box blue" style="margin-bottom:0px;">
	<div class="portlet-title">
	<div class="row-fluid">
		<div class="span6">
		<h4>FACTURACION de Mercaderia</h4></div>
		<div class="span6 text-right">
        <div class="btn-group">
        <div class="btn black">Factura Numero</div>
        <div class="btn"><strong><?php echo $num_fac?></strong></div>
        <div class="btn black">FECHA</div>
        <div class="btn"><strong><?php echo date("Y-m-d"); ?></strong></div>
        </div>
        </div>
	</div>
	</div>
	<div class="portlet-body">   
	<div class="row-fluid">
		<div class="span8">
        <h4>Datos Cliente <input name="busCli" class="input input-large" id="busCli" type="text" placeholder="Buscar Cliente" autofocus required/>
        <span class="label" id="cliCOD"></span>
        <input name="cli_cod" type="hidden" id="cli_cod">
        <a class="btn mini blue pull-right" id="btn_editCli"><i class="icon-edit"></i> Editar Seleccionado</a><a class="btn mini green pull-right" id="btn_addCli"><i class="icon-edit"></i> Nuevo Cliente</a></h4>
		<table class="table table-condensed" style="margin:0px;">
            <tr>
            <td><span class="label">Ced/RUC</span></td><td><div id="cliRUC"></div></td>
            <td><span class="label">Nombre</span></td><td><div id="cliNOM"></div></td>
            </tr>
            <tr>
            <td><span class="label">Direccion</span></td><td><div id="cliDIR"></div></td>
            <td><span class="label">Telefono</span></td><td><div id="cliTEL"></div></td>
            </tr>
        </table>
		</div>
        <div class="span4">
		<fieldset class="form-horizontal">
		<div class="control-group">
			<label class="control-label">Tipo Pago</label>
			<div class="controls">
				<select name="tip_pag" id="tip_pag" class="input-medium" required>
				<option value="">Seleccione Tipo Pago:</option>
				<option value="1">Contado</option>
				<option value="2">Cheque</option>
				<option value="3">Credito</option>
				</select>
			</div>
			</div>
		<div class="control-group">
			<label class="control-label">Vendedor</label>
			<div class="controls">
				<?php 
					$detUser=fnc_dataUser($_SESSION['MM_Username']);
					$detEmp=detEmpPer($detUser['emp_cod']);
					$detEmp_name=$detEmp['per_nom'].' '.$detEmp['per_ape']; ?>
				 <div class="btn"><strong><?php echo $detEmp_name;?></strong></div>
			</div>
			</div>
		</fieldset>
		</div>
    </div>
    </div>
</div>
</form>

<div class="well well-small">
	<?php include(RAIZc.'com_commons/fra_prodSearch.php'); ?>
</div>

<div>
	<div id="loading"><div class="imgload"></div></div>
	<div id="contSESSION"><?php include('_fra_list_session.php')?></div>
</div>

</div>

<?php
	$fec_max_com=date("d/m/Y");
	$fec_min_com="01/01/".date("Y");	
?>
<?php include('_m_mod-com.php'); ?>
<?php include('_m_mod-cli.php'); ?>
<script type="text/javascript">
var webNPc="form_newCli.php";
$(document).ready(function() {
	$( "#btn_addCli" ).on( "click", function() {
		$('#Modal_cli').modal({
		keyboard: false,
		remote:webNPc
		});
	});
	$( "#btn_editCli" ).on( "click", function() {
		var idCli=$("#cli_cod").val();
		if(idCli){
			$('#Modal_cli').modal({
			keyboard: false,
			remote:webNPc+"?id="+idCli
			});
		}else alert('Debe seleccionar un Cliente');
		/*
		
		*/
	});
});
</script>