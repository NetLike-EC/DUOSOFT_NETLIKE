<?php $detCic=detCicloFacLast(); ?>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">    	<form class="form-horizontal" id="form1" name="form1" method="post" action="fncts-ciclo-fac.php">
    		<input name="form" type="hidden" id="form" value="form_cf">
        	<input name="action" type="hidden" id="action" value="CIERRE">
        	<input name="id" type="hidden" id="id" value="<?php echo $detCic['faccic_id']; ?>">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><strong>CICLOS FACTURACION</strong></h4>
    </div>
            <div class="modal-body">			
				<div class="panel panel-danger">
					<div class="panel-heading"><legend>Cerrar Ciclo Actual</legend></div>
					<div class="panel-body">
                    	<div class="row-fluid">
                        	<div class="span5">							
							<div class="control-group">
							<label class="control-label">ID</label>
							<div class="controls">
							<input name="txt_fac_id" type="text" id="txt_fac_id" value="<?php echo $detCic['faccic_id']; ?>" class="input-mini" readonly/>
							</div>
							</div>
                        	</div>
                        	<div class="span7">
							<div class="control-group">
							<label class="control-label">Factura Inicio</label>
							<div class="controls">
							<input name="txt_fac_ini" type="text" id="txt_fac_ini" value="<?php echo $detCic['aud_id_ini']; ?>" class="input-mini" readonly/>
							</div>
							</div>
                        	</div>
                        </div>
                        <div class="row-fluid">
                        	<div class="span5">
							<div class="control-group">
							<label class="control-label">Facturas Creadas</label>
							<div class="controls">
							<input name="txt_fac_num" type="text" id="txt_fac_num" value="<?php echo $detCic['faccic_cont']; ?>" class="input-mini" readonly/>
							</div>
							</div>
                        	</div>
                        	<div class="span7">
                        	</div>
                        </div>
						<div class="control-group">
							<label class="control-label">Observaciones</label>
							<div class="controls">
							<textarea name="txt_fac_obs" type="text" id="txt_fac_obs" rows="3" class=""></textarea>
							</div>
						</div>							
					</div> 						
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading"><legend>Nuevo Ciclo</legend></div>
					<div class="panel-body">
						<div class="control-group">
							<label class="control-label">Factura Inicial</label>
							<div class="controls">
							<input name="txt_fac_ini" type="number" id="txt_fac_ini" class="" required/>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Serie Facturacion</label>
							<div class="controls">
							<input name="txt_fac_ser" type="text" id="txt_fac_ser" class="" required/>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Responsable</label>
							<div class="controls">
							<input name="txt_fac_res" type="text" id="txt_fac_res" value="<?php echo $detPer['per_nom'].' '.$detPer['per_ape']; ?>" class="" readonly/>
							</div>
						</div>
					</div> 						
				</div>
			</div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Guardar cambios</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            </div>
        </form>
    </div>