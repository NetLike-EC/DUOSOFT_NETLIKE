<?php include_once('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$detCli=detRow('tbl_clientes','cli_cod',$id);
if($detCli){
	$detPer=detRow('tbl_personas','per_id',$detCli['per_id']);
	$action='UPD';
}else{ $action='INS'; }
include(RAIZf.'_head.php');?>
<div>
<fieldset>
	<input name="form" type="hidden" id="form" value="form_cli">
	<input name="action" type="hidden" id="action" value="<?php echo $action; ?>" />
	<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
</fieldset>
<div class="row-fluid">
	<div class="well well-small">
    <fieldset class="form-horizontal">
    <div class="control-group">
    	<label class="control-label">ID</label>
    	<div class="controls">
      	<span class="label"><?php echo $detCli['cli_cod']; ?></span>
    	</div>
  	</div>
    <div class="control-group">
    	<label class="control-label">* Nombres</label>
    	<div class="controls">
        <input name="form_nom" type="text" class="input-block-level" id="form_nom" value="<?php echo $detPer['per_nom']; ?>" size="35" required/>
    </div>
  	</div>
    <div class="control-group">
    	<label class="control-label">* Apellidos</label>
    	<div class="controls">
        <input name="form_ape" type="text" class="input-block-level" id="form_ape" value="<?php echo $detPer['per_ape']; ?>" size="35" required/>
    </div>
  	</div>
    <div class="control-group">
    	<label class="control-label">* RUC / Cedula</label>
    	<div class="controls">
      	<input name="form_doc" type="text" class="input-block-level" id="form_doc" value="<?php echo $detPer['per_doc']; ?>" size="35" required/>
    	</div>
  	</div>
    <div class="control-group">
    	<label class="control-label">* Direccion</label>
    	<div class="controls">
        <input name="form_dir" type="text" class="input-block-level" id="form_dir" value="<?php echo $detPer['per_dir']; ?>" size="35" required/>
    </div>
  	</div>
    <div class="control-group">
    	<label class="control-label">* Telefono</label>
    	<div class="controls">
        <input name="form_tel" type="text" class="input-block-level" id="form_tel" value="<?php echo $detPer['per_tel']; ?>" size="35" required/>
    </div>
  	</div>
    <div class="control-group">
                <label class="control-label">Tipo</label>
                <div class="controls">
                <?php echo generarselect("typ_cod",listatipos("TIPCLI"),$detCli['typ_cod'],'input-block-level', 'required'); ?>
                </div>
            </div>
    </fieldset>
    </div>
</div>
</div>
<script type="text/javascript">
var webNPa="fnc_newCli.php";
$(document).ready(function() {
	$('#SaveCli').on( "click", function() {
		var parametros = {
            form: $('#form').val(),
			action: $('#action').val(),
			id: $('#id').val(),
            form_nom: $('#form_nom').val(),
			form_ape: $('#form_ape').val(),
			form_doc: $('#form_doc').val(),
			form_dir: $('#form_dir').val(),
			form_tel: $('#form_tel').val(),
			typ_cod: $('#typ_cod').val()
    	};
		if((parametros['form_nom'])&&(parametros['form_ape'])&&(parametros['form_doc'])){
			var post = $.post(webNPa, parametros, siRespuesta, 'json');
			post.error(siError);
		}else alert('Campos Obligatorios (*)');
	});
	
	function siRespuesta(r){
 		var rHtml
		if(r.accion['est']=='TRUE'){
        // Crear HTML con las respuestas del servidor
			rHtml = r.accion['msg'];
			document.getElementById('btnCloseP').click();
			gritterShow(rHtml,'Creado Correctamenne');
			conSESreload();
			$("#busCli").val('');
			$("#busCli").focus();	
			clearCliDet();
							
		}else{
			rHtml = r.accion['msg'];
			alert(rHtml);
		}
        //$('#respuesta').html(rHtml);   // Mostrar la respuesta del servidor en el div con el id "respuesta"
    }
 
    function siError(e){
        alert('Ocurrió un error al realizar la petición: '+e.statusText);
    }
	//Vacia los Detalles del Cliente Seleccionado
	function clearCliDet(){
		$("#cliCOD").html(null);
		$("#cli_cod").val(null);
		$("#cliRUC").html(null);
		$("#cliNOM").html(null);
		$("#cliDIR").html(null);
		$("#cliTEL").html(null);
	}
	
});
</script>