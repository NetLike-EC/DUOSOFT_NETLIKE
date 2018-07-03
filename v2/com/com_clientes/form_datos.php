<div class="row">
			<div class="col-sm-6">
	<fieldset class="form-horizontal well well-sm">
		<div class="form-group"><label class="col-md-3 control-label" for="cli_lugp">Procedencia</label>
			<div class="col-md-9"><input name="cli_lugp" id="cli_lugp" type="text" value="<?php echo $dPac['cli_lugp']; ?>" class="form-control" placeholder="Lugar de Procedencia" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label" for="pac_lugr">Residencia</label>
			<div class="col-md-9"><input name="pac_lugr" id="pac_lugr" type="text" value="<?php echo $dPac['pac_lugr']; ?>" class="form-control" placeholder="Lugar de Residencia" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
		</div>
        <div class="form-group"><label class="col-md-3 control-label" for="pac_dir">Dirección</label>
			<div class="col-md-9"><input name="pac_dir" id="pac_dir" type="text" value="<?php echo $dPac['pac_dir']; ?>" class="form-control" placeholder="Dirección" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label" for="pac_sect">Sector</label>
			<div class="col-md-9"><?php //echo listatipos("pac_sect","SECTOR",$dPac['pac_sect'],'form-control','onChange="setDB(this.name,this.value,'.$id.','."'pac'".')"'); ?></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label" for="pac_tel1">Telefono 1</label>
			<div class="col-md-9"><input name="pac_tel1" id="pac_tel1" type="text" value="<?php echo $dPac['pac_tel1']; ?>" class="form-control" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
		</div>
        <div class="form-group"><label class="col-md-3 control-label" for="pac_tel2">Telefono 2</label>
			<div class="col-md-9"><input name="pac_tel2" id="pac_tel2" type="text" value="<?php echo $dPac['pac_tel2']; ?>" class="form-control" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label" for="pac_email">E-Mail</label>
			<div class="col-md-9"><input name="pac_email" id="pac_email" type="email" placeholder="nombre@mail.com" value="<?php echo $dPac['pac_email']; ?>" class="form-control" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
		</div>
        <div class="form-group"><label class="col-md-3 control-label" for="pac_ins">Instrucción</label>
			<div class="col-md-9"><?php //echo listatipos('pac_ins',"INST",$dPac['pac_ins'],'form-control','onChange="setDB(this.name,this.value,'.$id.','."'pac'".')"'); ?></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label" for="pac_pro">Profesión</label>
			<div class="col-md-9"><input name="pac_pro" type="text" value="<?php echo $dPac['pac_pro']; ?>" class="form-control" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
		</div>
		<div class="form-group"><label class="col-md-3 control-label" for="pac_emp">Empresa</label>
			<div class="col-md-9"><?php //echo listatipos("pac_emp","EMPTRB",$dPac['pac_emp'],'form-control','onChange="setDB(this.name,this.value,'.$id.','."'pac'".')"'); ?></div>
		</div>
        <div class="form-group"><label class="col-md-3 control-label" for="pac_ocu">Ocupación</label>
			<div class="col-md-9"><input name="pac_ocu" type="text" value="<?php echo $dPac['pac_ocu']; ?>" class="form-control" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
		</div>
	</fieldset>
    </div>
			<div class="col-sm-6">
	<fieldset class="form-horizontal well well-sm">
	<div class="form-group"><label class="col-md-4 control-label" for="cli_nompar">Nombre Contacto</label>
		<div class="col-md-8"><input name="cli_nompar" id="cli_nompar" type="text" value="<?php echo $dPac['cli_nompar']; ?>" class="form-control" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
	</div>
	
    <div class="form-group"><label class="col-md-4 control-label" for="pac_telpar">Teléfono Contacto</label>
		<div class="col-md-8"><input name="pac_telpar" id="pac_telpar" type="text" value="<?php echo $dPac['pac_telpar']; ?>" class="form-control" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"/></div>
	</div>
	</fieldset>
    <fieldset class="form-horizontal well well-sm">
    <div class="form-group"><label class="col-md-4 control-label" for="publi">Publicidad</label>
		<div class="col-md-8"><?php //echo listatipos("publi","PUBLI",$dPac['publi'],'form-control','onChange="setDB(this.name,this.value,'.$id.','."'pac'".')"'); ?></div>
	</div>
    <div class="form-group"><label class="col-md-4 control-label" for="pac_obs">Observaciones</label>
		<div class="col-md-8">
        	<textarea name="pac_obs" rows="9" class="form-control" id="pac_obs" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')"><?php echo $dPac['pac_obs'] ?></textarea>
        </div>
	</div>
	</fieldset>
    </div>
</div>