<?php require_once('../../Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$emp_ses_username_RS_user_detail = "-1";
if (isset($_SESSION['MM_Username'])) {
  $emp_ses_username_RS_user_detail = $_SESSION['MM_Username'];
}
$query_RS_user_detail = sprintf("SELECT * FROM tbl_user_system WHERE user_username=%s", GetSQLValueString($emp_ses_username_RS_user_detail, "text"));
$RS_user_detail = mysql_query($query_RS_user_detail) or die(mysql_error());
$row_RS_user_detail = mysql_fetch_assoc($RS_user_detail);
$totalRows_RS_user_detail = mysql_num_rows($RS_user_detail);

?>
<table align="center" style="background:url(<?php echo $RAIZ; ?>images/struct/est_shadbox/bg_black_50_a.png);">
                           	  <tr>
                                    	<td><!--Contenidos Head-->
                                        <?php //echo '*'.$_SESSION['MM_UserID'].$_SESSION['MM_Username']; ?>
                                        	<table align="right">
                                            	<tr>
                                                	<td align="left" class="text_sec_blue_min2">User:</td>
                                                  <td align="left" class="text_sec_gray_min"><strong><?php echo $row_RS_user_detail['user_username']; ?>*</strong></td>
                                                </tr>
                                                <tr>
                                                	<td align="left" class="text_sec_blue_min2">Name:</td>
                                                  <td align="left" class="text_sec_gray_min"><?php echo $row_RS_user_detail['user_name']; ?></td>
                                                </tr>
                                                <tr>
                                                	<td align="left" class="text_sec_blue_min2">Access:</td>
                                                  <td align="left" class="text_sec_gray_min"><?php echo $_SESSION['Acceso']; ?></td>
                                                </tr>
                                                
                                </table>                                </td>
                                        <!--Foto Usuario-->
                              <td><a href="<?php fnc_image_exist($pathimag_db_emp,$row_RS_user_detail['emp_img']) ; ?>" rel="shadowbox">
                <img src="<?php fnc_image_exist($pathimag_db_emp,$row_RS_user_detail['emp_img']) ; ?>" height="65" alt="User Photo"/></a>
                                        </td>
                                  </tr>
                                </table>
<?php
mysql_free_result($RS_user_detail);
?>
