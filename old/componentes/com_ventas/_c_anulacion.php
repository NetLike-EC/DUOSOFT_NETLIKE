<?php
$query_RS_list_comp = "SELECT * FROM tbl_compra_cab WHERE com_est='1' ORDER BY com_num DESC";
$RS_list_comp = mysql_query($query_RS_list_comp) or die(mysql_error());
$row_RSlc = mysql_fetch_assoc($RS_list_comp);
$totalRows_RS_list_comp = mysql_num_rows($RS_list_comp);

$query_RS_list_compA = "SELECT * FROM tbl_compra_cab WHERE com_est='0' ORDER BY com_num DESC";
$RS_list_compA = mysql_query($query_RS_list_compA) or die(mysql_error());
$row_RSlcA = mysql_fetch_assoc($RS_list_compA);
$totalRows_RS_list_compA = mysql_num_rows($RS_list_compA);
?>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span8">
    	<h3 class="page-title"><?php echo $rowMod['mod_nom']?> <small><?php echo $rowMod['mod_des']?></small></h3>
	</div>
	<div class="span4 text-right">
		<a class="btn big red disabled">
        <strong><?php echo $totalRows_RS_list_comp ?></strong> Compras <i class="icon-shopping-cart"></i></a>
	</div>
</div>
<?php fnc_log(); ?>

<div class="tabbable tabbable-custom">
											<ul class="nav nav-tabs">
												<li class="active"><a href="#tab_1_1" data-toggle="tab">
                                                Compras Activas <span class="badge badge-info"><?php echo $totalRows_RS_list_comp ?></span></i>
                                                </a></li>
												<li><a href="#tab_1_2" data-toggle="tab">
                                                Compras Anuladas <span class="badge badge-important"><?php echo $totalRows_RS_list_compA ?></span></a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1_1">
												<div>
<?php if ($totalRows_RS_list_comp>0){ ?>
<table id="mytable_facturas" class="table table-bordered table-hover table-condensed table-advance">
<thead>
	<tr>
    	<th></th>
	  	<th width="40">ID</th>
    	<th># Compra</th>
        <th>Fecha</th>
        <th>Proveedor</th>
        <th>Proced./Aranc.</th>
        <th>Valor</th>
		<th>Empleado</th>
        <th></th>
	</tr>
</thead>
<tbody>
	<?php do {
	$detProv=detProvPer($row_RSlc['prov_cod']);
	$detEMP=detEmpPer($row_RSlc['emp_cod']);
	$detCom_proc=$row_RSlc['com_proc'];
	if($detCom_proc=='LOC') $detCom_procv='Local';
	else if ($detCom_proc=='IMP') $detCom_procv='Importado '.$row_RSlc['com_imp'].'%';
	else $detCom_procv='N/D';
	if(verAnuCom($row_RSlc['com_num'])) $btnAnu='<a class="btn red mini" href="fnc.php?acc=ACOM&com_num='.$row_RSlc['com_num'].'">Anular</a>';
	else $btnAnu='<a class="btn mini disabled">No se puede Anular</a>';
	?>
    <tr>
      <td align="center">
        <a href="compra_detail.php?com_num=<?php echo $row_RSlc['com_num']; ?>" class="btn mini blue"><i class="icon-eye-open"></i></a>
        </td>
      <td><?php echo $row_RSlc['com_num']; ?></td>
      <td><?php echo $row_RSlc['fac_com_num']; ?></td>
      <td><span class="label"><?php echo $row_RSlc['com_fec_ing']; ?></span></td>
      <td><?php echo $detProv['prov_nom']; ?></td>
      <td><?php echo $detCom_procv; ?></td>
      <td align="right"><?php echo valor_factura_compra($row_RSlc['com_num']); ?></td>
      <td><?php echo $detEMP['emp_nom']." ".$detEMP['emp_ape']; ?></td>
      <td><?php echo $btnAnu ?></td>
    </tr>
    <?php } while ($row_RSlc = mysql_fetch_assoc($RS_list_comp)); ?>
</tbody>
</table>
<?php }else{
	echo '<div class="alert alert-error">No hay compras Activas</div>';
	} ?>
</div>
												</div>
												<div class="tab-pane" id="tab_1_2">
												<div>
<?php if ($totalRows_RS_list_compA>0){ ?>
<table id="mytable_facturas" class="table table-bordered table-hover table-condensed table-advance">
<thead>
	<tr>
    	<th></th>
	  	<th width="40">ID</th>
    	<th># Compra</th>
        <th>Fecha</th>
        <th>Proveedor</th>
        <th>Proced./Aranc.</th>
        <th>Valor</th>
		<th>Empleado</th>
        <th>Estado</th>
	</tr>
</thead>
<tbody>
	<?php do {
	$detProv=detProvPer($row_RSlcA['prov_cod']);
	$detEMP=detEmpPer($row_RSlcA['emp_cod']);
	$detCom_proc=$row_RSlcA['com_proc'];
	if($detCom_proc=='LOC') $detCom_procv='Local';
	else if ($detCom_proc=='IMP') $detCom_procv='Importado '.$row_RSlcA['com_imp'].'%';
	else $detCom_procv='N/D';
	?>
    <tr>
      <td align="center">
        <a href="compra_detail.php?com_num=<?php echo $row_RSlcA['com_num']; ?>" class="btn mini blue"><i class="icon-eye-open"></i></a>
        </td>
      <td><?php echo $row_RSlcA['com_num']; ?></td>
      <td><?php echo $row_RSlcA['fac_com_num']; ?></td>
      <td><span class="label"><?php echo $row_RSlcA['com_fec_ing']; ?></span></td>
      <td><?php echo $detProv['prov_nom']; ?></td>
      <td><?php echo $detCom_procv; ?></td>
      <td align="right"><?php echo valor_factura_compra($row_RSlcA['com_num']); ?></td>
      <td><?php echo $detEMP['emp_nom']." ".$detEMP['emp_ape']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <?php } while ($row_RSlcA = mysql_fetch_assoc($RS_list_compA)); ?>
</tbody>
</table>
<?php }else{
	echo '<div class="alert alert-error">No hay compras anuladas</div>';
	} ?>
</div>
												</div>
											</div>
										</div>

</div>

<?php
mysql_free_result($RS_list_comp);
?>