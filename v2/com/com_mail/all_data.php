<?php require('../../init.php');
fnc_accessnorm();

$_SESSION['MODSEL'] = 'MESS';
$rowMod=fnc_datamod($_SESSION['MODSEL']);

$query_pg = 'SELECT COUNT(*) AS TR FROM tbl_contact_mail INNER JOIN tbl_contact_data ON tbl_contact_mail.idMail=tbl_contact_data.idMail';
$RSpg = mysql_query($query_pg) or die(mysql_error());
$row_RSpg = mysql_fetch_assoc($RSpg);

$pages = new Paginator;
$pages->items_total = $row_RSpg['TR'];
$pages->mid_range = 8;
$pages->paginate();

$query_RSlist = "SELECT * FROM tbl_contact_mail INNER JOIN tbl_contact_data ON tbl_contact_mail.idMail=tbl_contact_data.idMail ORDER BY idData DESC ".$pages->limit;
$RSm = mysql_query($query_RSlist) or die(mysql_error());
$row_RSlist = mysql_fetch_assoc($RSm);
$totalRows_RSlist = mysql_num_rows($RSm);

include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<div class="container">
<div class="page-header"><?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?></div>
<?php fnc_log(); ?>
<div class="well well-sm">
    <div class="row">
		<div class="col-md-7"><ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul></div>
        <div class="col-md-2">
        	<div class="pull-right"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    	</div>
        <div class="col-md-3">
        	<?php if($totalRows_RSlist>0){ ?>
			<a href="rep_excel.php" class="btn btn-success btn-block"><span class="glyphicon glyphicon-cloud-download"></span> Download EXCEL</a>
			<?php } ?>
		</div>
	</div>
</div>
<div>
	<?php if($totalRows_RSlist>0){ ?>
<div class="table-responsive">
<table class="table" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th>WEBSITE</th>
	<th>FECHA</th>
    <th>EMAIL</th>
    <th>NOMBRE</th>
    <th>BIRTHDAY</th>
    <th>COUNTRY</th>
    <th>STATE</th>
    <th>CITY</th>
    <th>ZIP</th>
    <th>PHONE</th>
    <th>MESSAGE</th>
    <th>IP</th>
</tr></thead>
<tbody>
	<?php do {	
	$mailTest=$row_RSlist['test'];
	$mailBanned=$row_RSlist['banned'];
	if((!$mailTest)&&(!$mailBanned)){
	$dataId=$row_RSlist['idData'];
	$dataFrom=$row_RSlist['from'];
	$dataDate=$row_RSlist['date'];
	$dataMail=$row_RSlist['mail'];
	$dataName=$row_RSlist['name'];
	$dataBirthday=$row_RSlist['birthday'];
	$dataCountry=$row_RSlist['country'];
	$dataState=$row_RSlist['state'];
	$dataCity=$row_RSlist['city'];
	$dataZip=$row_RSlist['zip'];
	$dataPhone1=$row_RSlist['phone1'];
	$dataPhone2=$row_RSlist['phone2'];
	$dataMess=$row_RSlist['msg'];
	$dataIp=$row_RSlist['ip'];
	
	if($dataFrom=='facebook') $dataFrom='<abbr title="Facebook"><img src="'.$RAIZ0.'images/struct/icons/FaceBook_32x32.png'.'" style="max-width:16px; max-height:16px;"></abbr>';
	else if($dataFrom=='web') $dataFrom='<abbr title="Website"><img src="'.$RAIZ0.'images/struct/icons/Web-32.png'.'" style="max-width:16px; max-height:16px;"></abbr>';
	else $dataFrom='';
	?>
	  <tr>
        <td><?php echo $dataId?></td>
        <td align="center"><?php echo $dataFrom?></td>
        <td><small><?php echo $dataDate?></small></td>
        <td><a href="#"><small><?php echo $dataMail?></small></a></td>
        <td><a href="#"><?php echo $dataName?></a></td>
        <td><?php echo $dataBirthday?></td>
        <td><?php echo $dataCountry?></td>
        <td><?php echo $dataState?></td>
        <td><?php echo $dataCity?></td>
        <td><?php echo $dataZip?></td>
        <td>
        	<span class="label label-primary"><?php echo $dataPhone1; ?></span>
			<span class="label label-primary"><?php echo $dataPhone2; ?></span>
		</td>
        <td><?php echo $dataMess?></td>
        <td><?php echo $dataIp?></td>
	  </tr>
	  <?php }
      } while ($row_RSlist = mysql_fetch_assoc($RSm)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert"><h4>Not Found Records !</h4></div>'; } ?>
</div>
</div>
<?php include(RAIZf.'_foot.php'); ?>