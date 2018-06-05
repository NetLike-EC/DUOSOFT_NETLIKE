<fieldset>
<div class="well well-sm">
	<div class="row">
		<div class="col-sm-6">
		<div class="form-group">
			<label class="control-label">Motivo de Consulta</label>
			<textarea name="dcon_mot" rows="5" class="form-control" id="dcon_mot" onKeyUp="setDB(this.name,this.value,'<?php echo $idc ?>','con')"><?php echo $dCon['dcon_mot'] ?></textarea>
        </div>
        <div class="form-group">
        	<label class="control-label">Motivo 1</label>
            <textarea name="dcon_mot1" rows="5" class="form-control" id="dcon_mot1" onKeyUp="setDB(this.name,this.value,'<?php echo $idc ?>','con')"><?php echo $dCon['dcon_mot1'] ?></textarea>
        </div>
		</div>
        <div class="col-sm-6">
		<div class="form-group">
			<label class="control-label">Motivo 2</label>
			<textarea name="dcon_mot2" rows="5" class="form-control" id="dcon_mot2" onKeyUp="setDB(this.name,this.value,'<?php echo $idc ?>','con')"><?php echo $dCon['dcon_mot2'] ?></textarea>
        </div>
        <div class="form-group">
        	<label class="control-label">Motivo 3</label>
            <textarea name="dcon_mot3" rows="5" class="form-control" id="dcon_mot3" onKeyUp="setDB(this.name,this.value,'<?php echo $idc ?>','con')"><?php echo $dCon['dcon_mot3'] ?></textarea>
        </div>
		</div>            
	</div>
</div>
</fieldset>