<fieldset>
<div class="well well-sm">
	<h4><i class="fa fa-user-md fa-lg"></i> Motivo de la Consulta</h4>
	<div class="form-group">
    <textarea name="dcon_mot" rows="15" class="form-control" id="dcon_mot" onKeyUp="setDB(this.name,this.value,'<?php echo $id_cons ?>','con')"><?php echo $detCon['dcon_mot'] ?></textarea>
	</div>
</div>
</fieldset>