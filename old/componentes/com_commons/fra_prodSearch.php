<script type="text/javascript" src="<?php echo $RAIZj ?>js_carga_prod.js"></script>
<div class="form-inline">
	<select name="BusSel" id="BusSel" class="span4">
        <option value="findCod" selected>Codigo</option>
		<option value="findNom">Nombre</option>
		<option value="findTip">Tipo / Categoria</option>
	</select>
	<input type="text" id="singleBirdRemote" class="span8" placeholder="Nombre del producto"/>
	<input type="hidden" name="idSel" disabled="disabled" id="idSel"/>
	<div id="loading"><div class="imgload"></div></div>
</div>