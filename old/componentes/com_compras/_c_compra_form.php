<div class="container-fluid">
<form id="form_compra_cab" name="form_compra_cab" method="post" action="_fnc_compra_agre.php">
<h3 class="page-header"><?php echo $rowMod['mod_nom'] ?> <small><?php echo $rowMod['mod_des'] ?></small>
<div class="btn-group pull-right">
<input type="button" name="btn_action" id="btn_action" value="GRABAR" onclick="validaForm()" class="btn red">
<a role="button" class="btn" id="btn_addProd">Crear Producto</a>
<a href="<?php echo $RAIZc?>com_compras/" class="btn black"><i class="icon-remove"></i> Cancelar</a>
</div>
</h3>
<div class="portlet box red" style="margin-bottom:0px;">
	<div class="portlet-title">
            <div class="row-fluid">
				<div class="span6"><h4>Ingreso de Mercaderia</h4></div>
                <div class="span6 text-right"><span class="label label-important">Fecha. <?php echo date("Y-m-d"); ?></span></div>
            </div>
            </div>
	<div class="portlet-body">
		<div class="row-fluid">
           	<div class="span4 form-inline">
				<div class="control-group">
				<label><input type="radio" name="com_proc" value="LOC" id="importacion_0" checked>Local <?php echo $_SESSION['conf']['taxes']['iva'] ?>%</label>
				<label><input type="radio" name="com_proc" value="IMP" id="importacion_1">Importación
                <input name="com_imp" type="number" class="input-small" id="com_imp" placeholder="% aranceles"></label>
                
				</div>
		  		<div class="control-group" style="padding:12px 0px;">
					<?php include(RAIZc.'com_commons/fra_prodSearch.php'); ?>
				</div>
          	</div>
            <div class="span4 form-horizontal">
						<div class="control-group">
                        	<label class="control-label" id="required">* Proveedor</label>
                            <div class="controls">
							<?php generarselect('prov_id',listProveedores(),"",'input-medium',''); ?>
                            
                            </div>
                        </div>
                        <div class="control-group">
                        	<label class="control-label" id="required">* Tipo Pago</label>
                            <div class="controls">
                            <select name="tip_pag" id="tip_pag" class="input-medium">
                            <option value="">Seleccione Tipo Pago:</option>
                            <option value="1">Contado</option>
                            <option value="2">Cheque</option>
                            <option value="3">Credito</option>
							</select>
                            </div>
                        </div>
                    </div>
            <div class="span4">
                        <div class="control-group">
                        	Observaciones
                        	  <label class="control-label"></label>
                            <div class="controls">
                            	<textarea class="input-block-level"></textarea>
                                
                            </div>
                        </div>
                    </div>
            
        </div>
    </div>
</div>
</form>
<?php fnc_log(); ?>
<div>
	<div id="loading"><div class="imgload"></div></div>
	<div id="contSESSION"><?php include('_fra_list_session.php')?></div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {	
	$('#prov_id').chosen();
	$('#tip_pag').chosen();
});

function validaForm(){
	if(($('#prov_id').val())&&($('#tip_pag').val())){
		if(confirm('Desea Grabar?')){
			$( "#form_compra_cab" ).submit();
		}
	}else{
		alert('Campos con * Obligatorios');
	}		
}
</script>
<?php include('_m_mod-com.php'); ?>
<?php include('_m_mod-prod.php'); ?>