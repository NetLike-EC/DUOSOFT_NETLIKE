<?php
$qryRSu = "SELECT * FROM tbl_user_system";
$RSu = mysqli_query($conn,$qryRSu) or die(mysqli_error($conn));
$dRSu = mysqli_fetch_assoc($RSu);
$tRSu = mysqli_num_rows($RSu);
?>
<?php if ($tRSu>0) { ?>
<table id="mytable" class="table table-bordered">
<thead>
	<tr>
		<th>ID</th>
    	<th>username</th>
        <th>Nombres</th>
		<th>Email</th>
        <th>Estado</th>
        <th>Permisos</th>
        <th></th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <?php
	$id=$dRSu['user_id'];
	$ids=md5($id);
	$btnStat=fncStat('actions.php',array("ids"=>$ids, "val"=>$dRSu['user_status'],"acc"=>md5('STAT'),"url"=>$urlc));?>
    <tr>
		<td><?php echo $id ?></td>
		<td><?php echo $dRSu['user_username'] ?></td>
		<td><?php echo $dRSu['user_name'] ?></td>
		<td><?php echo $dRSu['user_email'] ?></td>
        <td class="texgt-center"><?php echo $btnStat ?></td>
        <td class="text-center"><a href="menus_permiso.php?ids=<?php echo $ids ?>" class="btn btn-info btn-xs fancybox.iframe fancyreload">
        <i class="fa fa-edit fa-lg"></i> Permisos</a></td>
		<td class="text-center">
		<div class="btn-group">
        <a href="form.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit fa-lg"></i> Editar</a>
		<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-lg"></i> Eliminar</a>
        </div>
		</td>
    </tr>
    <?php } while ($dRSu = mysqli_fetch_assoc($RSu)); ?>    
</tbody>
</table>

<?php }else{ ?>
<div class="alert alert-warning"><h4>No Existen Usuarios</h4></div>
<?php }
mysqli_free_result($RSu);
?>