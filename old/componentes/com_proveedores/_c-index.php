<?php
$query_RSp = "SELECT * FROM tbl_proveedores ORDER BY prov_id DESC";
$RSp = mysql_query($query_RSp) or die(mysql_error());
$row_RSp = mysql_fetch_assoc($RSp);
$totalRows_RSp = mysql_num_rows($RSp);
?>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span8">
    	<h3 class="page-title"><?php echo $rowMod['mod_nom']?> <small><?php echo $rowMod['mod_des']?></small></h3>
	</div>
	<div class="span4 text-right">
		<a class="btn big green disabled">
        <strong><?php echo $totalRows_RSp ?></strong> Proveedores <i class="icon-shopping-cart"></i></a>
		<a class="btn big green" href="form.php">
        <strong><?php echo $btn2_tot ?></strong> <i class="icon-plus"></i> Nuevo</a>
	</div>
</div>
<?php 
fnc_log();
if ($totalRows_RSp>0){ ?>
<table id="mytable_facturas" class="table table-bordered table-hover table-condensed">
<thead>
	<tr>
	  	<th>ID</th>
        <th></th>
        <th>RUC</th>
    	<th>Proveedor</th>        
        <th>Facturas</th>
        <th>Contacto</th>
        <th>Teléfono</th>
        <th></th>
	</tr>
</thead>
<tbody>
  <?php do {
  $detPer=detPer($row_RSp['per_id']);
  $status=fnc_status($row_RSp['prov_id'],$row_RSp['prov_stat'],'_fncts.php','STAT');?>
    <tr>
      <td><?php echo $row_RSp['prov_id']; ?></td>
      <td><?php echo $status ?></td>
      <td><?php echo $detPer['per_doc']; ?></td>
      <td><?php echo $detPer['per_nom'].' '.$detPer['per_ape']; ?></td>      
      <td>Numero</td>
      <td><?php echo $detPer['per_cont_nom']; ?></td>
      <td><span class="label btn-info"><?php echo $detPer['per_cont_tel']; ?></span></td>
      <td style="text-align:center">
      	<div class="btn-group">
        <a href="form.php?id=<?php echo $row_RSp['prov_id']; ?>" class="btn mini blue"><i class="icon-edit"></i> Editar</a>
        </div>
        </td>
    </tr>
    <?php } while ($row_RSp = mysql_fetch_assoc($RSp)); ?>
</tbody>
</table>
<?php }else{
	echo '<div class="alert alert-error">No se han registrado Proveedores</div>';
	} ?>
</div>
<?php
mysql_free_result($RSp);
?>