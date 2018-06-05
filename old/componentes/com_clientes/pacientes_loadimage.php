<?php include('../_config.php'); ?>
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

$colname_RS_imgpac = "-1";
if (isset($_GET['idpac'])) {
  $colname_RS_imgpac = $_GET['idpac'];
}
mysql_select_db($database, $conn);
$query_RS_imgpac = sprintf("SELECT * FROM tbl_images_clientes WHERE pac_cod = %s ORDER BY ima_pac_cod DESC LIMIT 16", GetSQLValueString($colname_RS_imgpac, "int"));
$RS_imgpac = mysql_query($query_RS_imgpac, $conn) or die(mysql_error());
$row_RS_imgpac = mysql_fetch_assoc($RS_imgpac);
$totalRows_RS_imgpac = mysql_num_rows($RS_imgpac);
?>
<?php include(RAIZ.'frames/_head.php'); ?>
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var http = getXMLHTTPRequest();
function getXMLHTTPRequest() {
      	try {xmlHttpRequest = new XMLHttpRequest();}
      	catch(error1) {
        	try { xmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP");}
          catch(error2) {
      	    try { xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");}
      	    catch(error3){ xmlHttpRequest = false; }
          }
        }
        return xmlHttpRequest;
      }
      function useHttpResponse() {
      	if (http.readyState == 4) {
        	if (http.status == 200) {
          	divResult.innerHTML = http.responseText;
          	dataForm.reset();
          	imageForm.reset();
          	window.uploadedImage.document.body.innerHTML = "";
          	window.uploadedImage.imagePath = null;
        	}
      	}
      }
function deleteimg_history(codimg){
	if (confirm("Esta seguro que desea eliminar la imagen")){
		var url="clientes_hystorydeleteimg.php";
        var parameters = "codimg=" + codimg;
      	http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.setRequestHeader("Content-length", parameters);
        http.setRequestHeader("Connection", "close");
      	http.send(parameters);
		location.reload()

	}						
}
$(document).ready(function() {
    $('li').click(function () {
        var url = $(this).attr('rel');
        $('#iframe').attr('src', url);
        //$('#iframe').reload();
    });
	
});
</script>
<div id="uploadimagecontainer">
	<div id="containerupload"><iframe src="" width="100%" height="400px" frameborder="0" scrolling="yes" id="iframe"></iframe></div>
	<div id="uploadbtn">
		<ul>
			<li class="btn_pic" rel="image_capture/image_capture.php?idpac=<?php echo $_GET['idpac']; ?>">CAPTURAR</li>
            <li class="btn_up" rel="image_upload/image_upload.php?idpac=<?php echo $_GET['idpac']; ?>">SUBIR</li>
            <li class="btn_rel" onclick="location.reload();">RECARGAR</li>
			<li class="btn_exit" onclick="parent.Shadowbox.close();">SALIR</li>

</ul>
    </div>
    <div id="imageshistory">
    <h2><img src="images/reload_12.png" width="12" height="12" onclick="location.reload();"/> Historial de Imagenes</h2>
    <ul>
      <?php do { ?>
        <li><table style="border-right:1px solid #999;" cellspacing="2" cellpadding="0">
        <tr><td colspan="2" align="center"><img src="../../images/db/pac/<?php echo $row_RS_imgpac['img_path']; ?>" style="max-width:50px; max-height:35px;"/>
        </td></tr>
        <tr>
          <td align="center"><a href="../../images/db/pac/<?php echo $row_RS_imgpac['img_path']; ?>" rel="shadowbox[history]"><img src="images/zoom_12.png" width="12" height="12" /></a></td>
        <td align="center"><a onclick="deleteimg_history(<?php echo $row_RS_imgpac['ima_pac_cod']; ?>);"><img src="images/delete_12.png" width="12" height="12" /></a></td></tr>
        </table></li>
        <?php } while ($row_RS_imgpac = mysql_fetch_assoc($RS_imgpac)); ?>
    </ul>
    </div>
</div>
<?php
mysql_free_result($RS_imgpac);
?>