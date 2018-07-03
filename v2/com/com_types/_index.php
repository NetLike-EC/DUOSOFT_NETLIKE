<?php $rTyp=vParam('ref',$_GET['ref'],$_POST['ref']);
if($rTyp){
	$param['typ']=array('typ_ref','=',$rTyp);
	$uTyp='&ref='.$rTyp;//Parametro para URL
}
$paramSQL=getParamSQLA($param);
$TR=totRowsTabP('tbl_types',$paramSQL);
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qry = 'SELECT * FROM tbl_types WHERE 1=1 '.$paramSQL.' ORDER BY typ_cod DESC '.$pages->limit;
	$RSl = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRSl = mysqli_fetch_assoc($RSl);
	$tRSl = mysqli_num_rows($RSl);
}
$btnNew='<a href="form.php?'.$uTyp.'" class="btn btn-primary fancybox.iframe fancyreload">'.$cfg[i]['new'].$cfg[b]['new'].'</a>';
?>
<?php echo genPageHeader($dM['mod_cod'],'header',NULL,NULL,NULL,$btnNew) ?>
<div class="well well-sm">
<form class="form-inline">
	<span class="label label-default"><?php echo $cfg[t][filters] ?></span> 
    <label class="control-label"><?php echo $cfg[t][reference] ?></label>
	<?php genSelect('typ_cod', detRowGSel('tbl_types','typ_ref','DISTINCT (typ_ref)','1','1'), $rTyp, 'form-control', 'required', NULL, 'Seleccione', TRUE,NULL,'Todos')?>
</form>
</div>
<? if($tRSl>0){?>
<div>
<?php sLOG('g'); ?>

<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Módulo</th>
    <th>Nombre</th>
    <th>Ref</th>
    <th>Valor</th>
    <th>Aux</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do { ?>
	<?php 
		$id=$dRSl['typ_cod'];
		$ids=md5($id);
		$btnStat=fncStat('_fnc.php',array("ids"=>$ids, "val"=>$dRSl['typ_stat'],"acc"=>md5('STt'),'ref'=>$rTyp,"url"=>$urlc));
	?>
		<tr>
			<td><a href="form.php?ids=<?php echo $ids ?>" class="btn btn-link btn-xs fancybox.iframe fancyreload"><?php echo $id ?></a></td>
			<td><?php echo $btnStat ?></td>
			<td><?php echo $dRSl['mod_ref'] ?></td>
			<td><?php echo $dRSl['typ_nom'] ?></td>
			<td><?php echo $dRSl['typ_ref'] ?></td>
			<td><?php echo $dRSl['typ_val'] ?></td>
			<td><?php echo $dRSl['typ_aux'] ?></td>
			<td><div class="btn-group">
			  <a href="form.php?ids=<?php echo $ids ?>" class="btn btn-info btn-xs fancybox.iframe fancyreload"><?php echo $cfg[i][edit].$cfg[b][edit] ?></a>
			  <a href="_fnc.php?ids=<?php echo $ids ?>&acc=<?php echo md5('DELt') ?>&url=<?php echo $urlc.$uTyp ?>" class="btn btn-danger btn-xs vAccL">
				<?php echo $cfg[i][del].$cfg[b][del] ?></a></div>
			</td>
	    </tr>
	  <?php } while ($dRSl = mysqli_fetch_assoc($RSl)); ?>
</tbody>
</table>
</div>
	<?php include(RAIZf.'paginator.php') ?>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
<script type="text/javascript">
	$("#typ_cod").change(function(){
	window.location.href = "?ref="+$("#typ_cod").val();
    //alert("The text has been changed.");
});
</script>