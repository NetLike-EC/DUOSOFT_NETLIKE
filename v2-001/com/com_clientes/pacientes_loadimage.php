<?php include('../../init.php');
$id=vParam('idpac', $_GET['idpac'], $_POST['idpac']);
$dPac=detRow('db_clientes','pac_cod',$id);
$qRSip = sprintf("SELECT * FROM db_clientes_media WHERE cod_pac = %s ORDER BY id DESC LIMIT 16", SSQL($id, "int"));
$RSip = mysql_query($qRSip) or die(mysql_error());
$dRSip = mysql_fetch_assoc($RSip);
$tRSip = mysql_num_rows($RSip);
include(RAIZf.'head.php'); ?>
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
function deleteimg_history(id){
	if (confirm("Esta seguro que desea eliminar la imagen")){
		var url="pacientes_hystorydeleteimg.php";
        var parameters = "id=" + id;
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
        $('#iframe').attr('src', url); //$('#iframe').reload();
    });
});
</script>
<body class="cero">
<div class="navbar navbar-fixed-top navbar-inverse">

<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">HISTORIAL CAPTURA PACIENTE</a>
  </div>

<!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
    	<li class="active"><a href="#"><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></a></li>
		<li rel="image_capture/image_capture.php?idpac=<?php echo $id ?>"><a><i class="icon-camera icon-white"></i> CAPTURAR</a></li>
        <li onclick="location.reload();"><a><i class="icon-refresh icon-white"></i> RECARGAR</a></li>
        <li onclick="parent.$.fancybox.close();"><a>SALIR</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->

</div>
<div class="container-fluid">
	<div class="row">
    	<div class="col-sm-9">
        	<iframe src="" width="100%" height="380px" frameborder="0" scrolling="no" id="iframe"></iframe>
        </div>
        <div class="col-sm-3">
        
        	<?php if($tRSip>0){ ?>
            <div class="panel panel-info">
            	<div class="panel-heading"><a onclick="location.reload()" class="btn btn-info btn-xs pull-right"><i class="fa fa-refresh fa-lg"></i></a> Historial de Images</div>
                <div class="panel-body">
                
                <div class="row">
                  <?php do { ?>
                    <?php $dMed=detRow('db_media','id_med',$dRSip['id_med']);
                    $dMed_img=fncImgExist("data/db/pac/",$dMed['file']); ?>
                        <div class="col-sm-6 col-md-12">
                        <div class="thumbnail">
                        <a href="<?php echo $dMed_img ?>" class="fancybox"><img src="<?php echo $dMed_img ?>"/></a>
                        <a onclick="deleteimg_history(<?php echo $dRSip['cod_pac'] ?>)" class="btn btn-default btn-xs btn-block"><i class="fa fa-trash"></i> Eliminar</a>
                        </div>
                        </div>
                    <?php } while ($dRSip = mysql_fetch_assoc($RSip)); ?>
                </div>
                
                </div>
            </div>
    		
			<?php }else{ echo '<div class="alert alert-info"><h4><a onclick="location.reload()" class="btn btn-info btn-xs"><i class="fa fa-refresh"></i></a> Sin Historial</h4></div>'; }?>
        
        </div>
    </div>
	
    

</div>
</body>
</html>
<?php mysql_free_result($RSip) ?>