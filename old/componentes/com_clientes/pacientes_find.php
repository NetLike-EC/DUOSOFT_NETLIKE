<script type="text/javascript" src="../../js/js_carga_pac.js"></script>
<script type='text/javascript' src='../../js/jquery.autocomplete.min.js'></script>
<link rel="stylesheet" type="text/css" href="../../styles/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	var id_tip = $(".list_tip").attr("value");//VALUE del List Seleccionado
	$("#singleBirdRemote").autocomplete("<?php echo $RAIZ; ?>componentes/com_clientes/search_cli.php?idsearch="+id_tip, { width: 300, selectFirst: false });
	var sel_change = $("#list_tip");//Elemento list_tip asignado a una variable sel_change
	sel_change.change(function(){
		id_tip = sel_change.attr("value");
		$("#singleBirdRemote").autocomplete("<?php echo $RAIZ; ?>componentes/com_clientes/search_cli.php?idsearch="+id_tip, { width: 300, selectFirst: false });
	});
	$("#singleBirdRemote").result(function(event, data, formatted) { if (data) $("#id").val(data[1]); });	
});
</script>



<div class="row-fluid">
	<div class="span7">
    <div>
	<form autocomplete="off" action="<?php echo $_SESSION['../com_clientes/DIRSEL']; ?>" method="get" class="form-inline" style="margin:0;">
            <select name="list_tip" id="list_tip" class="list_tip">
				<option value="find_ape" selected="selected">Apellido Paciente</option>
				<option value="find_nom">Nombre Paciente</option>
				<option value="find_ciu">Ciudad</option>
				<option value="find_dir">Direccion</option>
				<option value="find_tel">Telefono</option>
            </select>
            <input type="text" name="singleBirdRemote" id="singleBirdRemote" />
            <input type="button" value="Buscar" class="btn_cons_cli btn btn-info"/>
            <input type="hidden" name="id" disabled="disabled" class="id_find_cli" id="id" size="3" border="0"/>
            <span><img src="<?php echo $RAIZ ?>images/struct/loading.gif" width="16" height="16" alt="Loading..." id="loading" /></span>
		</form>
    </div>
    </div>
    <div id="cont_cli" class="span5"></div>
</div>