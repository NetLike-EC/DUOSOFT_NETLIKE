<?php
$query_RSp = "SELECT * FROM tbl_proveedores ORDER BY prov_cod DESC";
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
		<a class="btn big green" href="proveedor_form.php">
        <strong><?php echo $btn2_tot ?></strong> <i class="icon-plus"></i> Nuevo</a>
	</div>
</div>
<?php 
if ($totalRows_RSp>0){ ?>
<table id="mytable_facturas" class="table table-bordered table-hover table-condensed">
<thead>
	<tr>
	  	<th>ID</th>
    	<th>Nombre</th>
        <th>RUC</th>
        <th>Facturas</th>
        <th>Contacto</th>
        <th></th>
	</tr>
</thead>
<tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_RSp['prov_cod']; ?></td>
      <td><?php echo $row_RSp['prov_nom']; ?></td>
      <td><?php echo $row_RSp['prov_ruc']; ?></td>
      <td>Numero</td>
      <td>Contacto</td>
      <td>
      	<div class="btn-group">
        <a href="proveedor_form.php?id=<?php echo $row_RSp['prov_cod']; ?>" class="btn mini blue"><i class="icon-edit"></i> Editar</a>
        <a href="<?php echo $RAIZc?>com_compras/proveedor_form.php?id=<?php echo $row_RSp['prov_cod']; ?>" class="btn mini red"><i class="icon-trash"></i> Eliminar</a>
        </div>
        </td>
    </tr>
    <?php } while ($row_RSp = mysql_fetch_assoc($RSp)); ?>
</tbody>
</table>
<?php }else{
	echo '<div class="alert alert-error">No se han realizado Compras</div>';
	} ?>
</div>

<?php
mysql_free_result($RSp);
?>