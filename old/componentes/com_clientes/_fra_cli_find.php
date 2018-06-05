<script type="text/javascript" src="../../js/js_carga_pac.js"></script>
<script type="text/javascript">
$().ready(function() {
	$("#singleBirdRemote").autocomplete("<?php echo $RAIZc; ?>com_clientes/search_cli.php", { width: 300, selectFirst: false });
	$("#singleBirdRemote").result(function(event, data, formatted) { if (data) $("#id").val(data[1]); });	
});
</script>
<div class="row-fluid">
	<div class="span7">
    <div>
	<form autocomplete="off" action="<?php echo $_SESSION['../com_clientes/DIRSEL']; ?>" method="get" class="form-inline" style="margin:0;">
            <input type="text" name="singleBirdRemote" id="singleBirdRemote" />
            <input type="button" value="Buscar" class="btn_cons_cli btn btn-info"/>
            <input type="hidden" name="id" disabled="disabled" class="id_find_cli" id="id" size="3" border="0"/>
            <span><img src="<?php echo $RAIZ ?>images/struct/loading.gif" width="16" height="16" alt="Loading..." id="loading" /></span>
		</form>
    </div>
    </div>
    <div id="cont_cli" class="span5"></div>
</div>