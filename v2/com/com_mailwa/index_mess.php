<?php require('../../init.php');
fnc_accessnorm();
$_SESSION['MODSEL'] = 'MESS';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
mysql_select_db($db_conn_wa, $conn);
$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_contact_data';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);
if($row_RSpg['TR']>0){ 
$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();

$query_RSlist = "SELECT * FROM tbl_contact_data ORDER BY idData DESC ".$pages->limit;
$RSm = mysql_query($query_RSlist) or die(mysql_error());
$row_RSlist = mysql_fetch_assoc($RSm);
$totalRows_RSlist = mysql_num_rows($RSm);
}

include(RAIZf.'_head.php');?>
<body>
<?php include(RAIZf.'_fra_top_min.php') ?>
<div class="container">
<div class="page-header">
	<?php echo genPageTit($wp2,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
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
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>N°</th>
    <th></th>
	<th>Date</th>
    <th>Name</th>
    <th>Mail</th>
    <th>By</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$messId=$row_RSlist['idData'];
	$messIdm=$row_RSlist['idMail'];
	$messName=$row_RSlist['name'];
	$messComp=$row_RSlist['company'];
	$messDate=$row_RSlist['date'];
	$messFrom=$row_RSlist['from'];
	$messStat=$row_RSlist['status'];
	$detMail=dataContMail($messIdm);
	if($messFrom=='facebook') $messFrom='<abbr title="Facebook"><img src="'.$RAIZ0.'images/struct/icons/FaceBook_32x32.png'.'" style="max-width:16px; max-height:16px;"></abbr>';
	else if($messFrom=='web') $messFrom='<abbr title="Website"><img src="'.$RAIZ0.'images/struct/icons/Web-32.png'.'" style="max-width:16px; max-height:16px;"></abbr>';
	else $messFromr='';
	if($messStat==1) $messStat='<abbr title="NEW"><i class="glyphicon glyphicon-star"></i></abbr>';
	else $messStat='';
	?>
	  <tr>
        <td><?php echo $messId?></td>
        <td><?php echo $messStat ?></td>
        <td><small><?php echo $messDate ?></small></td>
        <td><a href="#"><abbr title="<?php echo $messComp?>"><?php echo $messName?></abbr></a></td>
        <td><a href="#" rel="shadowbox"><small><?php echo $detMail['mail']?></small></a></td>
        <td><?php echo $messFrom?></td>
        <td><a href="mess_data.php?id=<?php echo $messId?>" rel="shadowbox[view];options={relOnClose:true}" class="btn btn-sm">
        <i class="glyphicon glyphicon-eye-open"></i></a></td>
	    </tr>
	  <?php } while ($row_RSlist = mysql_fetch_assoc($RSm)); ?>
</tbody>
</table>
<?php }else{ echo '<div class="alert"><h4>Not Found Records !</h4></div>'; } ?>
</div>

</div>
</body>
</html>