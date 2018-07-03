<?php include('../../init.php');
fnc_accessnorm();

$_SESSION['MODSEL']='';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$id=fnc_verifiparam('id_mail', $_GET['id_mail'], $_POST['id_mail']);
include(RAIZf.'_head.php');

$data=detRow('tbl_contact_data','idMail',$id);
$dMail=detRow('tbl_contact_mail','idMail',$data['idMail']);
//$query_cd = 'SELECT * FROM tbl_contact_data WHERE idMail = "'.$id.'"';
//$RScd = mysql_query($query_cd) or die(mysql_error());
//$data = mysql_fetch_assoc($RScd);
?>

<body class="cero-m">
<div class="container">
	<div class="page-header">
    	<h1>Información de contacto</h1>
		<h2><span class="label label-info"><?php echo $data['name']; ?></span></h2>
		<h3><?php echo $dMail['mail'] ?></h3>
    </div>
	
    <div>
    	<table class="table table-condensed table-striped table-bordered" id="itm_table">
			<thead>
                <tr>
                    <th>Date</th>
                    <!--<th>Birthday</th>
                    <th>Company</th>-->
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Zip</th>
                    <th>Message</th>
                    <!--<th>From</th>
                    <th>Ip</th>-->
                </tr>
            </thead>
			<tbody>
                <tr>
					<td width="100px"><?php echo $data['date']; ?></td>
                    <!--<td><?php echo $data['birthday']; ?></td>
                    <td><?php echo $data['company']; ?></td>-->
                    <td>
                    	<span class="label label-primary"><?php echo $data['phone1']; ?></span>
                    	<span class="label label-primary"><?php echo $data['phone2']; ?></span>
                    </td>
                    <td><?php echo $data['address']; ?></td>
                    <td><?php echo $data['country']; ?></td>
                    <td><?php echo $data['state']; ?></td>
                    <td><?php echo $data['city']; ?></td>
                    <td><?php echo $data['zip']; ?></td>
                    <td><?php echo $data['message']; ?></td>
                    <!--<td><?php echo $data['from']; ?></td>
                    <td><?php echo $data['ip']; ?></td>-->
                </tr>
        	</tbody>
        </table>
    </div>
</div>
</body>
</html>

