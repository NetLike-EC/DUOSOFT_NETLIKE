<?php $TR=totRowsTabP('db_mail_campaign');
if($TR>0){ 
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qry = "SELECT * FROM db_mail_campaign ORDER BY id DESC ".$pages->limit;
	$RSm = mysql_query($qry) or die(mysql_error());
	$dRSl = mysql_fetch_assoc($RSm);
	$totalRows_RSl = mysql_num_rows($RSm);
}
?>
<div>
<?php if($TR>0){ ?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-3"><span class="label label-default">Total Rows <?php echo $TR ?></span></div>
    	<div class="col-md-7"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-md-2"><?php echo '<div class="pull-right">'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>
<table class="table table-hover table-condensed table-bordered table-striped" id="deftab">
<thead><tr>
    <th>Date</th>
    <th>Name</th>
    <th>Subject</th>
    <th>Reply</th>
    <th>Status</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do{ ?>
    <?php
	
	
	?>
	<tr>
		<td><span class="label label-default"><?php echo $dRSl['date'] ?></span></td>
		<td><?php echo $dRSl['nom'] ?></td>
        <td><?php echo $dRSl['subject'] ?></td>
        <td><small><?php echo $dRSl['reply'] ?></small></td>
        <td></td>
        <td>
			<div class="btn-group">
				<a href="campaignForm.php?id=<?php echo md5($dRSl['id'])?>" class="btn btn-primary btn-xs"><i class="fa fa-edit fa-lg"></i> Edit</a>
				<a href="fncts.php?id=<?php echo md5($dRSl['id'])?>&acc=<?php echo md5(DELmc) ?>" class="btn btn-danger btn-xs vAccL"><i class="fa fa-trash fa-lg"></i></a>
				<a href="fncts.php?id=<?php echo md5($dRSl['id'])?>&acc=<?php echo md5(CLONmc)?>" class="btn btn-default btn-xs"><i class="fa fa-clone fa-lg"></i> Clon</a>
			</div>
        </td>
	</tr>
	  <?php } while ($dRSl = mysql_fetch_assoc($RSm)); ?>
</tbody>
</table>
<?php }else{ echo '<div class="alert alert-info"><h4>Not Found Mails !</h4></div>'; } ?>
</div>