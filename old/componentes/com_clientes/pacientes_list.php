<?php
if ($_GET['singleBirdRemote']){
	fnc_cadsearch($_GET['singleBirdRemote']);
	$query_RS_pacientes_list=fnc_gencad_search();
	$RS_pacientes_list = mysql_query($query_RS_pacientes_list) or die(mysql_error());
	$row_RS_pacientes_list = mysql_fetch_assoc($RS_pacientes_list);
	$totalRows_RS_pacientes_list = mysql_num_rows($RS_pacientes_list);
}
?>
<?php if ($totalRows_RS_pacientes_list>0) { ?>
<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert">×</button>
Su Busqueda: <strong><?php echo $_GET['singleBirdRemote'] ?></strong></div>
<table id="mytable_cli" class="table table-bordered table-hover table-condensed">
<thead>
	<tr>
    	<th></th>
		<th>COD</th>
    	<th>Apellidos</th>
        <th>Nombres</th>
		<th>Edad</th>
        <th>Trabajo</th>
        <th>Ciudad</th>
        <th>&nbsp;</th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <tr>
    	<td align="center">
        <a onclick="show_det_cli_list(<?php echo $row_RS_pacientes_list['cli_cod']; ?>)" title="Ver Detalle" class="btn btn-small"><i class="icon-search"></i></a>
        	<?php if ($_SESSION['MODSEL']=="CLI"){ ?>
    	   <a href="clientes_form.php?id_pac=<?php echo $row_RS_pacientes_list['cli_cod']; ?>" rel="shadowbox;options={relOnClose:true}" title="Modificar Paciente" class="btn btn-small"><i class="icon-user"></i></a>
           <?php } ?>
           
           <?php if ($_SESSION['MODSEL']=="STE"){ ?>
    	   <a href="<?php echo $urlcurrent ?>?idp=<?php echo $row_RS_pacientes_list['cli_cod']; ?>&amp;action=SELTEMP"><i class="icon-th"></i></a>
           <?php } ?>
                   
           <?php if ($_SESSION['MODSEL']=="PAG"){ ?>
           <a href="../com_pagos/pagos_form.php?id_pac=<?php echo $row_RS_pacientes_list['cli_cod']; ?>" rel="shadowbox" title="Pagos Pacientes"><img src="../../images/struct/img_taskbar/calculator.png" border="0" alt="Pagos"/></a>
           <?php } ?>
           
           <?php if ($_SESSION['MODSEL']=="FAC"){ ?>
           <a href="../com_facturacion/factura_form.php?id_pac=<?php echo $row_RS_pacientes_list['cli_cod']; ?>" rel="shadowbox" title="Facturas Pacientes"><img src="<?php echo $RAIZ; ?>images/struct/img_taskbar/application.png" border="0" alt="Pagos"/></a>
           <?php } ?>
        </td>
		<td><?php echo $row_RS_pacientes_list['cli_cod'];?>
        	<?php $detailpac=detCliPer($row_RS_pacientes_list['cli_cod']);?>
		</td>
		<td><?php echo $detailpac['cli_nom']; ?></td>
		<td><?php echo $detailpac['cli_ape']; ?></td>
        
		<td><em><?php echo edad($detailpac['pac_fec']); ?></em> &nbsp; <?php echo $row_RS_pacientes_list['pac_fec']; ?></td>
		<td><?php echo htmlentities($detailpac['pac_prof']); ?></td>
        <td><?php echo htmlentities($detailpac['pac_ciu']); ?></td>
        <td><a href="pacientes_detail_all.php?cli_sel_list=<?php echo $row_RS_pacientes_list['pac_cod']; ?>" rel="shadowbox[DETPAC];width=650" title="Detalles Paciente:  <?php echo $row_RS_pacientes_list['pac_cod']; ?>.  <?php echo $row_RS_pacientes_list['cli_nom']; ?> <?php echo $row_RS_pacientes_list['pac_ape']; ?>">+</a></td>
    </tr>
    <?php } while ($row_RS_pacientes_list = mysql_fetch_assoc($RS_pacientes_list)); ?>
</tbody>
</table>
<div>
</div>
<?php mysql_free_result($RS_pacientes_list);?>
<?php }else{ ?>
<div class="well well-small">Realice una Busqueda</div>
<?php } ?>