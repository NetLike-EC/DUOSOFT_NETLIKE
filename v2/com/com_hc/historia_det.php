<?php $qryHC=sprintf('SELECT * FROM db_paciente_hc WHERE pac_cod=%s',
GetSQLValueString($id_pac,'int'));
$RShc=mysql_query($qryHC);
$row_RShc=mysql_fetch_assoc($RShc);
$tr_RShc=mysql_num_rows($RShc);
$id_hc=$row_RShc['hc_id'];
?>
<fieldset>
<div class="well well-sm">
<div class="row">
	<div class="col-md-3">
    <div class="form-group">
    <label for="hc_antp">Antecedentes Personales</label>
    <textarea name="hc_antp" class="form-control" id="hc_antp" onKeyUp="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')"><?php echo $row_RShc['hc_antp'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_antf">Antecedentes Familiares</label>
    <textarea name="hc_antf" class="form-control" id="hc_antf" onKeyUp="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')"><?php echo $row_RShc['hc_antf'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_hab">Habitos</label>
    <textarea name="hc_hab" class="form-control" id="hc_hab" onKeyUp="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')"><?php echo $row_RShc['hc_hab'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_ale">Alergias</label>
    <textarea name="hc_ale" class="form-control" id="hc_ale" onKeyUp="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')"><?php echo $row_RShc['hc_ale'] ?></textarea>
  </div>
    </div>
</div>
</div>
<div class="well well-sm">
<div class="row">
	<div class="col-md-3">
    <div class="form-group">
    <label for="hc_cir_pre">Cirugias Previas</label>
    <textarea name="hc_cir_pre" class="form-control" id="hc_cir_pre" rows="4" onKeyUp="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')"><?php echo $row_RShc['hc_cir_pre'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_cau_inf">Causa Infertilidad</label>
    <textarea name="hc_cau_inf" class="form-control" id="hc_cau_inf" rows="4" onKeyUp="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')"><?php echo $row_RShc['hc_cau_inf'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_cic_ra">Ciclos Previos de TRA</label>
    <textarea name="hc_cic_ra" class="form-control" id="hc_cic_ra" rows="4" onKeyUp="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')"><?php echo $row_RShc['hc_cic_ra'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_obs">Observaciones</label>
    <textarea name="hc_obs" class="form-control" id="hc_obs" rows="4" onKeyUp="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')"><?php echo $row_RShc['hc_obs'] ?></textarea>
  </div>
    </div>
</div>
</div>
</fieldset>