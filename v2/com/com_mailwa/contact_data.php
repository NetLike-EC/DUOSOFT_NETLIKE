<?php include('../../init.php');
fnc_accessnorm();
mysql_select_db($db_conn_wa, $conn);
$_SESSION['MODSEL']='';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$id=fnc_verifiparam('id_mail', $_GET['id_mail'], $_POST['id_mail']);
include(RAIZf.'_head.php');

$query_cd = 'SELECT * FROM tbl_contact_data WHERE idMail = "'.$id.'"';
$RScd = mysql_query($query_cd) or die(mysql_error());
$row_RScd = mysql_fetch_assoc($RScd);
?>

<body class="cero-m">
<div class="container">
	<div class="page-header">
    	<h1><span class="label label-info"><?php echo $row_RScd['name']; ?></span><div class="pull-right"> Información de contacto</div></h1>
    </div>
    <div>
    	<table class="table table-condensed table-striped table-bordered" id="itm_table">
			<thead>
                <tr>
                    <th>Date</th>
                    <th>Birthday</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Zip</th>
                    <th>Message</th>
                    <th>From</th>
                    <th>Ip</th>
                </tr>
            </thead>
			<tbody>
                <tr>
					<td width="100px"><?php echo $row_RScd['date']; ?></td>
                    <td><?php echo $row_RScd['birthday']; ?></td>
                    <td><?php echo $row_RScd['company']; ?></td>
                    <td>
                    	<span class="label label-primary"><?php echo $row_RScd['phone1']; ?></span>
                    	<span class="label label-primary"><?php echo $row_RScd['phone2']; ?></span>
                    </td>
                    <td><?php echo $row_RScd['address']; ?></td>
                    <td><?php echo $row_RScd['country']; ?></td>
                    <td><?php echo $row_RScd['state']; ?></td>
                    <td><?php echo $row_RScd['city']; ?></td>
                    <td><?php echo $row_RScd['zip']; ?></td>
                    <td><?php echo $row_RScd['message']; ?></td>
                    <td><?php echo $row_RScd['from']; ?></td>
                    <td><?php echo $row_RScd['ip']; ?></td>
                </tr>
        	</tbody>
        </table>
    </div>
</div>
</body>
</html>

