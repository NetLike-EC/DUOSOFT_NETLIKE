<?php require('../../init.php');
fnc_accessnorm();
mysql_select_db($db_conn_wa, $conn);
$detContact=dataContact($id);
$detMail=dataContMail($detContact['idMail']);
//echo 'detContat:'.$detContact['idData'].'<br>';
if($detContact){
	if($detContact['status']=='1'){
		$query_RSupd = "UPDATE tbl_contact_data SET status='0' WHERE idData='".$id."'";
		mysql_query($query_RSupd) or die(mysql_error());
	}

	//echo '*If Detcontact';
$query_RS_datos = "SELECT * FROM tbl_contact_msg WHERE idMail='".$detMail['idMail']."' ORDER BY idMsg DESC";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
$row_RS_datos = mysql_fetch_assoc($RS_datos);
$totalRows_RS_datos = mysql_num_rows($RS_datos);
//echo $query_RS_datos.'<hr/>';
//echo $totalRows_RS_datos;
} else 	echo 'ELSE Detcontact';
$messFrom=$detContact['from'];
if($messFrom=='facebook') $messFrom='<abbr title="Facebook"><img src="'.$RAIZ0.'images/struct/icons/FaceBook_32x32.png'.'" style="max-width:16px; max-height:16px;"></abbr>';
	else if($messFrom=='web') $messFrom='<abbr title="Website"><img src="'.$RAIZ0.'images/struct/icons/Web-32.png'.'" style="max-width:16px; max-height:16px;"></abbr>';
	else $messFrom='';
include(RAIZf.'_head.php');
?>
<body class="cero">
<div class="container">
<div class="page-header"><h1><?php echo $messFrom ?> Contact Detaills  N° <?php echo $detContact['idData'] ?> <small><?php echo $detContact['date'] ?></small></h1></div>
<div class="row">
	<div class="col-md-5">
    <div class="well">
    <table class="table table-bordered table-condensed table-striped">
    <tr>
		<td><strong>Name</strong></td>
		<td><strong><?php echo $detContact['name'] ?></strong></td>
	</tr>
    <?php if($detContact['company']){ ?>
	<tr>
		<td>Company</td>
		<td><?php echo $detContact['company'] ?></td>
	</tr>
    <?php } ?>
	<?php if($detContact['country']){ ?>
	<tr>
		<td>Country</td>
		<td><?php echo $detContact['country'] ?></td>
	</tr>
    <?php } ?>
    <?php if($detContact['state']){ ?>
	<tr>
		<td>State</td>
		<td><?php echo $detContact['state'] ?></td>
	</tr>
    <?php } ?>
    <?php if($detContact['city']){ ?>
	<tr>
		<td>City</td>
		<td><?php echo $detContact['city'] ?></td>
	</tr>
    <?php } ?>
    <?php if($detContact['zip']){ ?>
	<tr>
		<td>ZIP</td>
		<td><?php echo $detContact['zip'] ?></td>
	</tr>
    <?php } ?>
    <?php if($detContact['address']){ ?>
	<tr>
		<td>Address</td>
		<td><?php echo $detContact['address'] ?></td>
	</tr>
    <?php } ?>
    <?php if($detContact['address']){ ?>
	<tr>
		<td>Phones</td>
		<td><?php echo $detContact['phone1'] ?> <small class="muted">/</small> <?php echo $detContact['phone2'] ?></td>
	</tr>
    <?php } ?>



</table>
	</div>
    </div>
	<div class="col-md-7">
    <legend class="text-center"><?php echo $detMail['mail']?></legend>
    <div>
    <?php if($totalRows_RS_datos>0){ ?>
	<div class="accordion" id="accordion001">
	<?php do{ ?>
<div class="accordion-group">
	<div class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion001" href="#collapse<?php echo $row_RS_datos['idMsg'] ?>">
		<strong>N° <?php echo $row_RS_datos['idMsg'] ?></strong> / <?php echo $row_RS_datos['date'] ?>
		</a>
	</div>
	<div id="collapse<?php echo $row_RS_datos['idMsg'] ?>" class="accordion-body collapse">
		<div class="accordion-inner">
        <div class="well">
        <?php echo $row_RS_datos['message'] ?>
        <div>
		</div>
	</div>
</div>
    <?php } while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
		mysql_free_result($RS_datos);?>
	</div>
    <?php }else{ echo '<div class="alert">No Contact Data</div>'; }
	?>
    </div>
    </div>
</div>
</div>
</body>
</html>