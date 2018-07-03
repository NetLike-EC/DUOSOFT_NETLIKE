<?php
$TR = totRowsTab('db_componentes',1,1);
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$query_RSc = "SELECT * FROM db_componentes ORDER BY mod_cod DESC ".$pages->limit;
	$RSc = mysqli_query($conn,$query_RSc) or die(mysqli_error($conn));
	$dRSc = mysqli_fetch_assoc($RSc);
	$trRSc = mysqli_num_rows($RSc);
}
$btnNew='<a href="form.php" class="btn btn-primary">'.$cfg[i]['new'].$cfg[b]['new'].'</a>';
?>
<div class="container">
<?php echo genPageHeader($dM[id],'header','h1',NULL,NULL,$btnNew)?>
<?php sLOG('g');
if($trRSc>0){ ?>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th><?php echo $cfg[com_mod][t_id] ?></th>
    <th></th>
    <th><?php echo $cfg[com_mod][t_ref] ?></th>
    <th><?php echo $cfg[com_mod][t_name] ?></th>
    <th><?php echo $cfg[com_mod][t_des] ?></th>
	<th><?php echo $cfg[com_mod][t_ico] ?></th>
    <th></th>
</tr></thead>
<tbody>
	<?php do { ?>
	<?php 
	$id=$dRSc['mod_cod'];
	$ids=md5($id);
	$btnStat=fncStat('_fnc.php',array("ids"=>$ids, "val"=>$dRSc['mod_stat'],"acc"=>md5(STATm),"url"=>$urlc));
	$LinkE=genLink('form.php',$id,NULL,array("ids"=>$ids));
	$btnE=genLink('form.php',$cfg[i][edit].$cfg[b][edit],'btn btn-primary btn-xs',array("ids"=>$ids));
	$btnD=genLink('_fnc.php',$cfg[i][del].$cfg[b][del],'btn btn-danger btn-xs',array("ids"=>$ids,'acc'=>md5(DELm),'url'=>$urlc));
	?>
	  <tr>
        <td><?php echo $LinkE ?></td>
		<td><?php echo $btnStat ?></td>
        <td><?php echo $dRSc['mod_ref'] ?></td>
        <td><?php echo $dRSc['mod_nom'] ?></td>
        <td><?php echo $dRSc['mod_des'] ?></td>
		<td><i class="<?php echo $dRSc['mod_icon'] ?>"></i></td>
        <td class="text-center">
			<div class="btn-group"><?php echo $btnE.$btnD ?></div>
        </td>
	    </tr>
	  <?php } while ($dRSc = mysqli_fetch_assoc($RSc)); ?>
</tbody>
</table>
</div>
<?php include(RAIZf.'paginator.php')?>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>