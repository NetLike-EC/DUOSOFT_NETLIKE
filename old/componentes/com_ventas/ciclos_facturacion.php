<?php include('../../init.php');
loginN(); 
$mSel='mVenCic';
$_SESSION['MODSEL']="FACC";//Variable para identificar el MODULO en el que se encuentra
$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php'); ?>
<div class="page-container row-fluid">
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<div class="page-content">
		<?php include(RAIZm.'mod_portlet/index.php'); ?>
        <?php
$query_RS_list_comp = "SELECT * FROM tbl_factura_ciclosf ORDER BY faccic_id DESC";
$RS_list_comp = mysql_query($query_RS_list_comp) or die(mysql_error());
$row_RSlc = mysql_fetch_assoc($RS_list_comp);
$totalRows_RS_list_comp = mysql_num_rows($RS_list_comp);
?>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span8">
    	<h3 class="page-title"><?php echo $rowMod['mod_nom']?> <small><?php echo $rowMod['mod_des']?></small></h3>
	</div>
	<div class="span4 text-right">
		<!-- Button trigger modal -->
        <a class="btn big red" href="#myModal" role="button" data-toggle="modal"><i class="icon-remove"></i> Cerrar Ciclo</a>
	</div>
</div>
<?php 
fnc_log();
if ($totalRows_RS_list_comp>0){ ?>
<table id="mytable_facturas" class="table table-bordered table-hover table-condensed">
<thead>
	<tr>
	  	<th>ID</th>
    	<th>Inicio Secuencia</th>
        <th>Facturas Creadas</th>
        <th>Serie</th>
        <th>Observaciones</th>
        <th>Empleado Inicia</th>
		<th>Empleado Finaliza</th>
	</tr>
</thead>
<tbody>
	<?php
    $banFirst=TRUE;
	do {
	if($banFirst==TRUE) $trClass='info'; else $trClass=NULL;
	$detEmpI=detEmpPer($row_RSlc['emp_cod_ini']);
	$detPerI_nom=$detEmpI['per_nom'].' '.$detEmpI['per_ape'];
    $detEmpF=detEmpPer($row_RSlc['emp_cod_fin']);
	$detPerF_nom=$detEmpF['per_nom'].' '.$detEmpF['per_ape'];?>
    <tr class="<?php echo $trClass ?>">
      <td><?php echo $row_RSlc['faccic_id']; ?></td>
      <td><?php echo $row_RSlc['faccic_ini']; ?></td>
      <td><?php echo $row_RSlc['faccic_cont']; ?></td>
      <td><?php echo $row_RSlc['faccic_serie']; ?></td>
      <td><?php echo $row_RSlc['faccic_observ']; ?></td>
      <td><?php echo $detPerI_nom; ?></td>
      <td><?php echo $detPerF_nom ?></td>
    </tr>
    <?php $banFirst=FALSE;
	} while ($row_RSlc = mysql_fetch_assoc($RS_list_comp)); ?>
</tbody>
</table>
<?php }else{
	echo '<div class="alert alert-warning"><h4>No se ha encontrado ciclos</h4></div>';
	} ?>
</div>
<?php
mysql_free_result($RS_list_comp);
?>
</div>
</div>
<!-- Modal -->
    <?php include('_m_mod_ciclos.php') ?>
    <!-- /.modal -->
</body>
</html>