<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/js_carga_prod_items.js"></script>
<script type="text/javascript">
$().ready(function() {
	var id_tip = $(".list_tip").attr("value");//VALUE del List Seleccionado
	$("#singleBirdRemote").autocomplete("search_prod.php?idsearch="+id_tip, {
			width: 700,
			selectFirst: false
	});
	var sel_change = $("#list_tip");//Elemento list_tip asignado a una variable sel_change
	sel_change.change(function(){
		id_tip = sel_change.attr("value");
		$("#singleBirdRemote").autocomplete("search_prod.php?idsearch="+id_tip, {
			width: 700,
			selectFirst: false
		});
	});
	$("#singleBirdRemote").result(function(event, data, formatted) {
			if (data)
				$("#id1").val(data[1]);
	});	
});
</script>
<div>
	<form autocomplete="off" class="form-inline" style="margin:0px;">
		<div class="form-group">
			<select name="list_tip" id="list_tip" class="list_tip form-control">
				<option value="find_nom">Nombre</option>
				<option value="find_cod">Codigo</option>
			</select>
		</div>
		<div class="form-group">
			<input type="text" class="txt_name form-control" id="singleBirdRemote" size="35" />
		</div>
		<div class="form-group">
			<input name="btn_cons" type="button" class="btn btn-primary" id="btn_cons" value="ok"/>
			<input type="hidden" name="id1" disabled="disabled" class="id_find_cli" id="id1" size="3" border="0"/>
		</div>
	</form>
</div>