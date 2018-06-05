<div class="container-fluid">
	<!-- BEGIN PAGE HEADER-->
	<div class="row-fluid">
		<div class="span12">
			<h3 class="page-title"><?php echo $rowMod['mod_nom'] ?> <small><?php echo $rowMod['mod_des'] ?></small></h3>
			<ul class="breadcrumb">
				<li><i class="icon-home"></i><a href="<?php echo $RAIZc ?>com_index/">Inicio</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Generación de Catálogos</a>
                	<i class="icon-angle-right"></i>
                </li>
			</ul>
		</div>
	</div>
	<!-- END PAGE HEADER-->
	<form class="form-horizontal" action="catalog.php" method="get">
    <div class="form-actions">
    	<button type="submit" class="btn red btn-block">Generar Catálogo PDF</button>
	</div>
    <div class="row-fluid">
    	<div class="span6">
    		<div class="well well-small">
            <fieldset class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">Tipo</label>
                    <div class="controls"><?php generarselect('idTip',listInvTip(),$idTip,NULL,NULL); ?></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Marca</label>
                    <div class="controls"><?php generarselect('idMar',listInvMar(),$idMar,NULL,NULL); ?></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Color</label>
                    <div class="controls"><?php generarselect('idCol',listAtr("COL"),$idCol,NULL,NULL); ?></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Material</label>
                    <div class="controls"><?php generarselect('idMat',listAtr("MAT"),$idMat,NULL,NULL); ?></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tamaño</label>
                    <div class="controls"><?php generarselect('idTam',listAtr("TAM"),$idTam,NULL,NULL); ?></div>
                </div>
            </fieldset>
    </div>
    	</div>
        <div class="span6">
        	<div class="well well-small">
			<fieldset class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">Precios</label>
                    <div class="controls">
                    <label class="checkbox inline">
  <input name="p1" type="checkbox" id="inlineCheckbox1" value="p1"> 1
</label>
<label class="checkbox inline">
  <input name="p2" type="checkbox" id="inlineCheckbox2" value="p2"> 2
</label>
<label class="checkbox inline">
  <input name="p3" type="checkbox" id="inlineCheckbox3" value="p3"> 3
</label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Cantidades</label>
                    <div class="controls">
                    	<label class="checkbox">
  <input name="stock" type="checkbox" id="stock" value="si"> Mostrar existentencias en catálogo
</label>
                    </div>
                </div>
                
                
            </fieldset>
            </div>
        </div>
    </div>
	
    </form>
    <?php if ($totalRows_RS_datos>0){ ?>
    <div>
    	<table class="table table-bordered table-condensed table-striped">
        	<tr>
            	<td>ID</td>
                <td>Codigo</td>
            </tr>
            <?php do{ ?>
            <tr>
            	<td><?php echo $row_RS_datos['prod_id'] ?></td>
                <td><?php echo $row_RS_datos['prod_nom'] ?></td>
            </tr>
            <?php } while ($row_RS_datos = mysql_fetch_assoc($RS_datos)); ?>
        </table>
    </div>
    <?php } ?>    
</div>