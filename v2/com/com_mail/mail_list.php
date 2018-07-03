<?php require('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('MLST');
$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_contact_mail';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
if($row_RSpg['TR']>0){ 
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();
$query_RSlist = "SELECT * FROM tbl_contact_mail ORDER BY idMail DESC ".$pages->limit;
$RSm = mysql_query($query_RSlist) or die(mysql_error());
$row_RSlist = mysql_fetch_assoc($RSm);
$totalRows_RSlist = mysql_num_rows($RSm);
}
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<div class="container">
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index/">Home</a></li>
   	<li><a href="<?php echo $RAIZc ?>com_mail/">Contact Center</a></li>
    <li class="active">List Mails</li>
</ul>

<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
<?php sLOG(); ?>
    <?php if($totalRows_RSlist>0){ ?>
    <div>
<div class="well well-sm">
    <div><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
	<?php echo '<div class="pull-right">'.$pages->display_items_per_page()."</div>"; ?></div>
</div>
<div class="well well-sm">
	<div>
    <form action="rep_excel-maillist.php" method="post">
    <fieldset class="form-inline">
    <div class="form-group">
    <label>Start Date</label>
    <input type="date" name="fecI" value="<?php echo $sdate ?>" class="form-control input-sm"/>
    </div>
    <div class="form-group">
    <label>End Date</label>
    <input type="date" name="fecF" value="<?php echo $sdate ?>" class="form-control input-sm"/>
    </div>
    <div class="form-group">
    <label class="checkbox-inline">
    <input type="checkbox" name="selAll" value="1"/>
    All Date
    </label>
    <label class="checkbox-inline">
    <input type="checkbox" name="isTest" value="1"/>
    Include Test
    </label>
    <label class="checkbox-inline">
    <input type="checkbox" name="isBan" value="1"/>
    Include Banned
    </label>
    <label class="checkbox-inline">
    <input type="checkbox" name="isBad" value="1"/>
    Include Wrong
    </label>
    </div>
    
    
    <button class="btn btn-success btn-sm pull-right"><i class="fa fa-download" aria-hidden="true"></i> Download Excel</button>
    </fieldset>
    </form>
    </div>
</div>
</div>

<table class="table table-hover table-condensed table-bordered table-striped" id="itm_table">
<thead>
<tr>
	<th>N°</th>
	<th>Date</th>
    <th>Email</th>
    <th></th>
    <th>Test</th>
    <th>Banned</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$mailId=$row_RSlist['idMail'];
	$dD=detRow('tbl_contact_data','idMail',$mailId);
	
	$mailDir=$row_RSlist['mail'];
	$estMailDir = '<i class="fa fa-check-circle fa-lg fa-fw"></i>'; 
	if (!filter_var($mailDir, FILTER_VALIDATE_EMAIL)) $estMailDir = '<i class="fa fa-times-circle fa-lg fa-fw text-danger"></i>';
	$mailTest=$row_RSlist['test'];
	$mailBanned=$row_RSlist['banned'];
	$mailTest=fnc_status($mailId,$mailTest,'fncts.php',md5(mailCTest));
	$mailBanned=fnc_status($mailId,$mailBanned,'fncts.php',md5(mailCBann));
	?>
	<tr>
		<td><?php echo $mailId; ?></td>
        <td><?php echo $dD['date'] ?></td>
		<td><?php echo $mailDir ?></td>
        <td><?php echo $estMailDir ?></td>
        <td><?php echo $mailTest; ?></td>
        <td><?php echo $mailBanned; ?></td>
        <td><a href="contact_data.php?id_mail=<?php echo $mailId?>" rel="shadowbox[edititm];options={relOnClose:true}" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-user"></i> Ver datos</a>
        </td>
	</tr>
	  <?php } while ($row_RSlist = mysql_fetch_assoc($RSm)); ?>
</tbody>
</table>
<?php }else{ echo '<div class="alert alert-info"><h4>Not Found Mails !</h4></div>'; } ?>
</div>
<?php include(RAIZf.'_foot.php') ?>