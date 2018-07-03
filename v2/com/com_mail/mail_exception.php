<?php require('../../init.php');
fnc_accessnorm();

$_SESSION['MODSEL'] = 'MLSE';
$rowMod=fnc_datamod($_SESSION['MODSEL']);

$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_contact_mail_exception';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
if($row_RSpg['TR']>0){ 
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();

$query_RSlist = "SELECT * FROM tbl_contact_mail_exception ORDER BY idMail DESC ".$pages->limit;
$RSm = mysql_query($query_RSlist) or die(mysql_error());
$row_RSlist = mysql_fetch_assoc($RSm);
$totalRows_RSlist = mysql_num_rows($RSm);
}

include(RAIZf.'_head.php');?>
<body>
<?php include(RAIZf.'_fra_top_min.php') ?>
<div class="container">
<div class="page-header">
	<h1><?php echo $rowMod['mod_nom']?> <small><?php echo $rowMod['mod_des']?></small>
    <div class="btn btn-group pull-right">
    	<a class="btn btn-info" href="mail_exception_form.php" rel="shadowbox;options={relOnClose:true}"><span class="glyphicon glyphicon-plus"></span> New Mail Exception</a>
    </div>
    </h1>
</div>
<?php fnc_log(); ?>
<div>
    <?php if($totalRows_RSlist>0){ ?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-8"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-md-4"><?php echo '<div class="pull-right">'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>
<table class="table table-hover table-condensed table-bordered table-striped" id="itm_table">
<thead><tr>
	<th>N°</th>
    <th>Dirección</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$mailId=$row_RSlist['idMail'];
	$mailDir=$row_RSlist['mail'];
	?>
	<tr>
		<td><?php echo $mailId; ?></td>
		<td><?php echo $mailDir; ?></td>
        <td align="center" width="150px">
        <a href="fncts.php?id=<?php echo $mailId?>&action=<?php md5(DELme) ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
        </td>
	</tr>
	  <?php } while ($row_RSlist = mysql_fetch_assoc($RSm)); ?>
</tbody>
</table>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Mails !</h4></div>'; } ?>
</div>
</div>
</body>
</html>