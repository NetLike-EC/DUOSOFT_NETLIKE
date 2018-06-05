<script type="text/javascript" src="../../js/js_carga_pac.js"></script>
<script type='text/javascript' src='../../js/jquery.autocomplete.min.js'></script>
<link rel="stylesheet" type="text/css" href="../../styles/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	var id_tip = $(".list_tip").attr("value");//VALUE del List Seleccionado
	$("#sBr").autocomplete(RAIZ+"com/com_pacientes/search_cli.php?idsearch="+id_tip, {
			width: 300,
			selectFirst: false
	});
	var sel_change = $("#list_tip");//Elemento list_tip asignado a una variable sel_change
	sel_change.change(function(){
		id_tip = sel_change.attr("value");
		$("#sBr").autocomplete("search_cli.php?idsearch="+id_tip, {
			width: 300,
			selectFirst: false
		});
	});
	$("#sBr").result(function(event, data, formatted) {
			if (data)
				$("#id").val(data[1]);
	});	
});
</script>
<link href="../../styles/style_v002.css" rel="stylesheet" type="text/css" />
<table class="bord_gray_4cornes" style="padding:3px;" align="center">
<tr>
	<td>
		<form autocomplete="off" action="<?php echo $_SESSION['../../DIRSEL']; ?>" method="post">
            <select name="list_tip" id="list_tip" class="list_tip">
				<option value="find_ape" selected="selected">Apellido Paciente</option>
				<option value="find_nom">Nombre Paciente</option>
				<option value="find_ciu">Ciudad</option>
				<option value="find_dir">Direccion</option>
				<option value="find_tel">Telefono</option>
            </select>
            <input type="text" name="sBr" id="sBr" />
            <input type="button" value="ok" class="btn_cons_cli"/>
            <input type="hidden" name="id" disabled="disabled" class="id_find_cli" id="id" size="3" border="0"/>
		</form>	</td>
	<td><div id="loading" align="center">
	<img src="../../images/struct/loading.gif" alt="Loading..." width="32" height="32" /></div></td>
  </tr>
</table>
<table align="center">
    <tr>
    	<td><div id="cont_cli"><span class="input_cont">Detalle Paciente</span></div></td>
    </tr>
</table>