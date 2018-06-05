<?php include('../_config.php');?>
<?php require_once(RAIZ.'/Connections/conn.php'); ?>
<?php
$emp_ses_username_RS_user_detail = "-1";
if (isset($_SESSION['MM_Username'])) {
  $emp_ses_username_RS_user_detail = $_SESSION['MM_Username'];
}
$query_RS_user_detail = "SELECT * FROM tbl_user_system WHERE user_username='".$emp_ses_username_RS_user_detail."'";
$RS_user_detail = mysql_query($query_RS_user_detail) or die(mysql_error());
$row_RS_user_detail = mysql_fetch_assoc($RS_user_detail);
$totalRows_RS_user_detail = mysql_num_rows($RS_user_detail);
$dataemp=detEmpPer($row_RS_user_detail['emp_cod']);
?>
<table align="center" background="<?php echo $RAIZ; ?>images/struct/est_shadbox/bg_black_50_a.png">
<tr>
	<td><!--Contenidos Head-->
		<table align="right">
        	<tr>
            	<td align="left" class="text_sec_blue_min2">Username:</td>
                <td align="left" class="text_sec_gray_min"><strong><?php echo $row_RS_user_detail['user_username']; ?></strong></td>
			</tr>
            <tr>
            	<td align="left" class="text_sec_blue_min2">Nombres:</td>
                <td align="left" class="text_sec_gray_min"><?php echo $dataemp['emp_nom'].' '.$dataemp['emp_ape']; ?> <?php echo $row_RS_user_detail['emp_ape']; ?></td>
			</tr>
            <tr>
            	<td align="left" class="text_sec_blue_min2">Acceso:</td>
                <td align="left" class="text_sec_gray_min"><?php echo $_SESSION['data_access']; ?></td>
			</tr>
	</table>
    </td>
    <!--Foto Usuario-->
    <td>
    	<a href="<?php fnc_image_exist($pathimag_db_emp,$row_RS_user_detail['emp_img']) ; ?>" rel="shadowbox">
        <img src="<?php fnc_image_exist($pathimag_db_emp,$row_RS_user_detail['emp_img']) ; ?>" height="65" />
        </a>
	</td>
</tr>
</table>
<?php
mysql_free_result($RS_user_detail);
?>