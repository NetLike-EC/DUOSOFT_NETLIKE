<?php
$id=vParam('id', $_GET['id'], $_POST['id']);
if ($_GET['singleBirdRemote']){
	fnc_cadsearch($_GET['singleBirdRemote']);
	$query_RS_listCli=fnc_gencad_search();
	$RS_listCli = mysql_query($query_RS_listCli) or die(mysql_error());
	$row_RS_listCli = mysql_fetch_assoc($RS_listCli);
	$totalRows_RS_listCli = mysql_num_rows($RS_listCli);
}
if ($totalRows_RS_listCli>0) { ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert"></button>
Su Busqueda: <strong><?php echo $_GET['singleBirdRemote'] ?></strong></div>
<table id="mytable_cli" class="table table-bordered table-hover table-condensed">
<thead>
	<tr>
    	<th></th>
		<th>COD</th>
        <th>DOC</th>
        <th>Nombres</th>
        <th>Tipo</th>
        <th>Contacto</th>
        <th>&nbsp;</th>
	</tr>
</thead>
<tbody> 
	<?php do {
		if ($_SESSION['MODSEL']=="CLI"){
			$btn_action='<a href="'.$RAIZc.'com_clientes/clientes_form.php?id='.$row_RS_listCli['cli_cod'].'" class="btn mini blue"><i class="icon-user"></i> Editar</a>';
		}else if ($_SESSION['MODSEL']=="STE"){
			$btn_action='<a href="'.$urlcurrent.'?idp='.$row_RS_listCli['cli_cod'].'&amp;action=SELTEMP"><i class="icon-th"></i></a>';
		}else if ($_SESSION['MODSEL']=="PAG"){
			$btn_action='<a href="../com_pagos/pagos_form.php?id_pac='.$row_RS_listCli['cli_cod'].'" rel="shadowbox" title="Pagos clientes"><img src="../../images/struct/img_taskbar/calculator.png" border="0" alt="Pagos"/></a>';
		}else if ($_SESSION['MODSEL']=="FAC"){
			$btn_action='<a href="../com_facturacion/factura_form.php?id_pac='.$row_RS_listCli['cli_cod'].'" rel="shadowbox" title="Facturas clientes"><img src="<?php echo $RAIZ; ?>images/struct/img_taskbar/application.png" border="0" alt="Pagos"/></a>';
		}
		$dataCli=detCliPer($row_RS_listCli['cli_cod']);
		$detTypCli=detRow('tbl_types','typ_cod',$dataCli['typ_cod']);
		$detTypCli_nom=$detTypCli['typ_nom'];
	?>
	<tr>
		<td>
        <div class="btn-group">
			<a onclick="show_det_cli_list(<?php echo $row_RS_listCli['cli_cod']; ?>)" title="Ver Detalle" class="btn black mini"><i class="icon-search"></i></a>
			<?php echo $btn_action; ?>
		</div>
		</td>
		<td><?php echo $row_RS_listCli['cli_cod'];?></td>
        <td><?php echo $dataCli['per_doc'];?></td>
        <td><?php echo $dataCli['per_nom'].' '.$dataCli['per_ape']; ?></td>       
		<td><?php echo $detTypCli_nom ?></td>
        <td><span class="label btn-info"><?php echo $dataCli['per_tel'];?></span></td>
        <td><a href="clientes_detail_all.php?cli_sel_list=<?php echo $row_RS_listCli['pac_cod']; ?>" rel="shadowbox[DETPAC];width=650" title="Detalles Paciente:  <?php echo $row_RS_listCli['pac_cod']; ?>.  <?php echo $row_RS_listCli['cli_nom']; ?> <?php echo $row_RS_listCli['pac_ape']; ?>">+</a></td>
    </tr>
    <?php } while ($row_RS_listCli = mysql_fetch_assoc($RS_listCli)); ?>
</tbody>
</table>
<div>
</div>
<?php mysql_free_result($RS_listCli);?>
<?php }else{ ?>
<div class="alert"><h4>Realice una Busqueda</h4></div>
<?php } ?>