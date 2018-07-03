<?php require_once('../../init.php');
if($_GET['idp']==null) $_GET['idp']=$_POST['idp'];

$idp = "-1";
if (isset($_GET['idp'])) { $idp = $_GET['idp']; }
$detpac=dPac($idp);
$detpac_nom=$detpac['pac_nom'].' '.$detpac['pac_ape'];
$detpac_edad=edad($detpac['pac_fec']);
$detpac_img=fncImgExist("images/db/pac/",lastImgPac($detpac['pac_cod']));


$idp_sel_pen_RS_cta_deuda = "-1";
if (isset($_GET['idp'])) { $idp_sel_pen_RS_cta_deuda = $_GET['idp'];}
$query_RS_cta_deuda = sprintf("SELECT db_clientes.pac_cod,  (SELECT  SUM(tbl_cta_por_cobrar.cta_valor-tbl_cta_por_cobrar.cta_abono) FROM tbl_cta_por_cobrar WHERE tbl_cta_por_cobrar.pac_cod=db_clientes.pac_cod) AS Deuda FROM db_clientes WHERE db_clientes.pac_cod=%s", SSQL($idp_sel_pen_RS_cta_deuda, "int"));
$RS_cta_deuda = mysql_query($query_RS_cta_deuda) or die(mysql_error());
$row_RS_cta_deuda = mysql_fetch_assoc($RS_cta_deuda);
$totalRows_RS_cta_deuda = mysql_num_rows($RS_cta_deuda);

$idp_sel_RS_cta_pend = "-1";
if (isset($_GET['idp'])) { $idp_sel_RS_cta_pend = $_GET['idp']; }
$query_RS_cta_pend = sprintf("SELECT num_cta, con_num, cta_fecha, cta_detalle, cta_valor, cta_abono, cta_cantidad, (tbl_cta_por_cobrar.cta_valor-tbl_cta_por_cobrar.cta_abono) AS cta_saldo FROM tbl_cta_por_cobrar WHERE tbl_cta_por_cobrar.pac_cod=%s AND tbl_cta_por_cobrar.cta_abono<tbl_cta_por_cobrar.cta_valor", SSQL($idp_sel_RS_cta_pend, "int"));
$RS_cta_pend = mysql_query($query_RS_cta_pend) or die(mysql_error());
$row_RS_cta_pend = mysql_fetch_assoc($RS_cta_pend);
$totalRows_RS_cta_pend = mysql_num_rows($RS_cta_pend);

$idp_sel_RS_pag_realiz = "-1";
if (isset($_GET['idp'])) { $idp_sel_RS_pag_realiz = $_GET['idp']; }
$query_RS_pag_realiz = sprintf("SELECT tbl_pagopac_cab.pag_num, tbl_pagopac_cab.pag_fech, tbl_pagopac_cab.pag_val, tbl_pagopac_cab.emp_cod, tbl_pagopac_cab.pag_tip FROM tbl_pagopac_cab WHERE tbl_pagopac_cab.pac_cod=%s", SSQL($idp_sel_RS_pag_realiz, "int"));
$RS_pag_realiz = mysql_query($query_RS_pag_realiz) or die(mysql_error());
$row_RS_pag_realiz = mysql_fetch_assoc($RS_pag_realiz);
$totalRows_RS_pag_realiz = mysql_num_rows($RS_pag_realiz);
include(RAIZf.'head.php');
?>
<script type="text/javascript" src="../../js/js_process_pagos.js"></script>
<body>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
    <div class="container">
		<a class="brand" href="#">Pagos Pacientes</a>
        <ul class="nav">
			<li class="divider-vertical"></li>
			<li><img src="<?php echo $detpac_img ?>" class="img-polaroid" style="max-width:50px; max-height:25px;"/></li>
            <li><a><?php echo $detpac_nom ?></a></li>
			<li class="divider-vertical"></li>
			<li><a href="<?php echo RAIZb; ?>com/com_pacientes/pacientes_detail_all.php?idPac=<?php echo $detpac['pac_cod'] ?>" rel="shadowbox"><i class="icon-plus"></i></a></li>
			<li class="divider-vertical"></li>
			<li><a><span class="label label-important">Deuda Pendiente</span> <strong>$ <?php echo $row_RS_cta_deuda['Deuda']; ?></strong></a></li>
		</ul>
        </div>
	</div>
</div>
<div class="well well-sm">
<?php include('pagos_find.php'); ?>
</div>

<div class="well well-sm">
<div class="row-fluid">
	<div class="span6">
    <div class="alert"><strong>Pagos Pendientes</strong></div>
    <?php
	if($totalRows_RS_cta_pend>0){ ?>
    <table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
		<th>Consulta</th>
		<th>Cuenta</th>
		<th>Detalle</th>
		<th>Valor</th>
		<th>Abono</th>
		<th>Saldo</th>
		<th>Fecha</th>
        </tr>
	</thead>
	<tbody>
	<?php do { ?>
	<tr>
		<td><?php echo $row_RS_cta_pend['con_num']; ?></td>
		<td><?php echo $row_RS_cta_pend['num_cta']; ?></td>
		<td><?php echo $row_RS_cta_pend['cta_detalle']; ?></td>
		<td><?php echo $row_RS_cta_pend['cta_valor']; ?></td>
		<td><?php echo $row_RS_cta_pend['cta_abono']; ?></td>
		<td><?php echo $row_RS_cta_pend['cta_saldo']; ?></td>
		<td><?php echo $row_RS_cta_pend['cta_fecha']; ?></td>
	</tr>
	<?php } while ($row_RS_cta_pend = mysql_fetch_assoc($RS_cta_pend)); ?>
	</tbody>
	</table>
    <?php }else{
		echo '<div class="alert alert-success">No Existen pagos pendientes</div>';
	}
	?>
    </div>
    <div class="span6">
    <div class="alert"><strong>Pagos Realizados</strong></div>
    <?php
	if($totalRows_RS_pag_realiz>0){ ?>
    <table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th>Pago</th>
			<th>Fecha</th>
			<th>Valor</th>
			<th>Tipo</th>
			<th>Cobrador</th>
		</tr>
	</thead>
	<tbody>
	<?php do {
	$detcobrador=dataEmp($row_RS_pag_realiz['emp_cod']);
	?>
		<tr>
			<td><a href="pagos_detail.php?id_pag=<?php echo $row_RS_pag_realiz['pag_num']; ?>" rel="shadowbox;width=550"><?php echo $row_RS_pag_realiz['pag_num']; ?></a></td>
			<td><?php echo $row_RS_pag_realiz['pag_fech']; ?></td>
			<td><?php echo $row_RS_pag_realiz['pag_val']; ?></td>
			<td><?php echo $row_RS_pag_realiz['pag_tip']; ?></td>
			<td><?php echo $detcobrador['emp_nom'].' '.$detcobrador['emp_ape']; ?></td>
		</tr>
	<?php } while ($row_RS_pag_realiz = mysql_fetch_assoc($RS_pag_realiz)); ?>
	</tbody>
	</table>
    <?php }else{
		echo '<div class="alert alert-info">Aún no se han realizado pagos</div>';
	}
	?>
    </div>
</div>
</div>

<div class="alert"><?php echo $LOG; ?></div>

</body>
</html>
<?php
mysql_free_result($RS_cta_deuda);
mysql_free_result($RS_cta_pend);
mysql_free_result($RS_pag_realiz);
?>
