<?php require('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL'] = 'MLST';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
mysql_select_db($db_conn_wa, $conn);
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

include(RAIZf.'_head.php');?>
<body>
<?php include(RAIZf.'_fra_top_min.php') ?>
<div class="container">
<div class="page-header"><?php echo genPageTit($wp2,$rowMod['mod_nom'],$rowMod['mod_des']); ?></div>
<?php fnc_log(); ?>
<div>
    <?php if($totalRows_RSlist>0){ ?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-8"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-md-4"><?php echo '<div class="pull-right">'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
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
<table class="table table-hover table-condensed table-bordered table-striped" id="itm_table">
<thead><tr>
	<th>N°</th>
    <th>Date</th>
    <th>Dirección</th>
    <th>Test</th>
    <th>Banned</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$mailId=$row_RSlist['idMail'];
	$dD=detRow('tbl_contact_data','idMail',$mailId);
	$mailDir=$row_RSlist['mail'];
	$mailTest=fnc_status($mailId,$row_RSlist['test'],'fncts.php','mailTest');
	$mailBanned=fnc_status($mailId,$row_RSlist['banned'],'fncts.php','mailBanned');
	?>
	<tr>
		<td><?php echo $mailId; ?></td>
        <td><?php echo $dD['date'] ?></td>
		<td><?php echo $mailDir; ?></td>
        <td><?php echo $mailTest; ?></td>
        <td><?php echo $mailBanned; ?></td>
        <td><a href="contact_data.php?id_mail=<?php echo $mailId?>" rel="shadowbox[edititm];options={relOnClose:true}" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-user"></i> Ver datos</a>
        </td>
	</tr>
	  <?php } while ($row_RSlist = mysql_fetch_assoc($RSm)); ?>
</tbody>
</table>
<?php }else{ echo '<div class="alert"><h4>Not Found Mails !</h4></div>'; } ?>
</div>
</div>
</body>
</html>