<script type="text/javascript" src="js/js_carga_prod_items.js"></script>
<script type='text/javascript' src='<?php echo $RAIZj ?>jquery.autocomplete.min.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo $RAIZt ?>jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	var id_tip = $(".list_tip").attr("value");//VALUE del List Seleccionado
	$("#sBr").autocomplete("search_prod.php?idsearch="+id_tip, {
			width: 450,
			selectFirst: false
	});
	var sel_change = $("#list_tip");//Elemento list_tip asignado a una variable sel_change
	sel_change.change(function(){
		id_tip = sel_change.attr("value");
		$("#sBr").autocomplete("search_prod.php?idsearch="+id_tip, {
			width: 450,
			selectFirst: false
		});
	});
	$("#sBr").result(function(event, data, formatted) {
			if (data)
				$("#id1").val(data[1]);
	});	
});
</script>

<div class="row-fluid">
	<div class="span7">
		<div>
			<form autocomplete="off" action="<?php echo $urlcurrent ?>" method="get" class="form-inline" style="margin:0;">
			<select name="list_tip" id="list_tip" class="list_tip">
              <option value="find_nom">Nombre</option>
              <option value="find_cod">Codigo</option>
        </select>
			<input type="text" class="txt_name" id="sBr" size="35" />
            <input type="button" value="ok" class="btn_cons_cli btn btn-primary"/>
            <input type="hidden" name="id1" disabled="disabled" class="id_find_cli" id="id1" size="3" border="0"/>
			<span><img src="<?php echo $RAIZa ?>images/struct/loader.gif" id="loading" /></span>
			</form>
		</div>
	</div>
    <div id="cont_cli" class="span5"></div>
</div>

<!--
<table align="center">
<tr>
	<td align="center" class="bord_gray_4cornes" style="padding:3px;">
		<form autocomplete="off">
            <select name="list_tip" id="list_tip" class="list_tip">
              <option value="find_nom">Nombre</option>
              <option value="find_cod">Codigo</option>
        </select>
            <input type="text" class="txt_name" id="sBr" size="35" />
            <input type="button" value="ok" class="btn_cons_cli"/>
            <input type="hidden" name="id1" disabled="disabled" class="id_find_cli" id="id1" size="3" border="0"/>
		</form>	</td>
	<td width="32"><div id="loading" align="center">
	<img src="images/loading.gif" alt="Loading..." width="32" height="32" /></div></td>
    <td align="center"><span class="input_cont">Seleccione Producto</span></td>
  </tr>
</table>
-->