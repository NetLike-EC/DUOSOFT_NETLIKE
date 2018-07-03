<?php require('../../../init.php');
include(RAIZf.'head.php'); ?>
<script type="text/javascript">
// JavaScript Document
      var loadingHtml = "Loading..."; // this could be an animated image
      var imageLoadingHtml = "Image loading...";
    	var http = getXMLHTTPRequest();
      //----------------------------------------------------------------
    	function uploadImage() {
        var uploadedImageFrame = window.uploadedImage;
    	  uploadedImageFrame.document.body.innerHTML = loadingHtml;
    	  // VALIDATE FILE
        var imagePath = uploadedImageFrame.imagePath;
        if(imagePath == null){ imageForm.oldImageToDelete.value = "";
		} else { imageForm.oldImageToDelete.value = imagePath; }
        imageForm.submit();
      }
      //----------------------------------------------------------------
      function showImageUploadStatus() {
        var uploadedImageFrame = window.uploadedImage;
        if(uploadedImageFrame.document.body.innerHTML == loadingHtml){ divResult.innerHTML = imageLoadingHtml;
        } else { var imagePath = uploadedImageFrame.imagePath;
          if(imagePath == null){ divResult.innerHTML = "No uploaded image in this form.";
          } else { divResult.innerHTML = "Loaded image: " + imagePath; }
        }
      }
      //----------------------------------------------------------------
      function getXMLHTTPRequest() {
      	try { xmlHttpRequest = new XMLHttpRequest();
      	} catch(error1) {
        	try {xmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP");
          } catch(error2) {
      	    try { xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
      	    } catch(error3) {
      		    xmlHttpRequest = false;
      	    }
          }
        } return xmlHttpRequest;
      }
      //----------------------------------------------------------------
      function sendData() {
      	var url = "submitForm.php";
        var parameters = "imageDescription=" + dataForm.imageDescription.value;
		var parameters;
        var imagePath = window.uploadedImage.imagePath;
        if(imagePath != null){ parameters += "&uploadedImagePath=" + imagePath; }
      	http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.setRequestHeader("Content-length", parameters.length);
        http.setRequestHeader("Connection", "close");
      	http.onreadystatechange = useHttpResponse;
      	http.send(parameters);
      }
      //----------------------------------------------------------------
      function submitFormIfNotImageLoading(maxLoadingTime, checkingIntervalTime) {
        if(window.uploadedImage.document.body.innerHTML == loadingHtml) {
          if(maxLoadingTime <= 0) {
            divResult.innerHTML = "The image loading has timed up. " + "Por favor , try again when the image is loaded.";
          } else {
            divResult.innerHTML = imageLoadingHtml;
            maxLoadingTime = maxLoadingTime - checkingIntervalTime;
            var recursiveCall = "submitFormIfNotImageLoading(" + maxLoadingTime + ", " + checkingIntervalTime + ")";
            setTimeout(recursiveCall, checkingIntervalTime);
          }
        } else { sendData(); }
      }
    	//----------------------------------------------------------------
      function submitForm() {
        var maxLoadingTime = 3000; // milliseconds
        var checkingIntervalTime = 500; // milliseconds
        submitFormIfNotImageLoading(maxLoadingTime, checkingIntervalTime);
      }
      //----------------------------------------------------------------
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
</script>

<h1>SUBIR IMAGEN <?php echo $_GET['idpac']; ?></h1>
<div id="imagecapture_container">
	<div id="capture_main" class="capture_cont" align="center">
    	<h2>Cargar una Imagen</h2>
        <div style="padding:0 5px;">
        <form id="dataForm" name="dataForm">
      <input name="imageDescription" type="hidden" id="imageDescription" value="<?php echo $_GET['idpac']; ?>" 
            size="30"/>
    </form>
      <form id="imageForm" name="imageForm" enctype="multipart/form-data"
          action="uploadImage.php" method="POST" target="uploadedImage">
          <input name="idpac" type="hidden" value="<?php echo $_GET['idpac']; ?>" />
      <!-- Next field limits the maximum size of the selected file to 2MB.
           If exceded the size, an error will be sent with the file. -->
      <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
      <input name="imageToUpload" id="imageToUpload" type="file"
            onchange="uploadImage();" size="30" value=""/>
      <input name="oldImageToDelete" type="hidden" disabled="disabled" id="oldImageToDelete"
            size="50" />
    </form>
    <form>
    <input type="button" onclick="submitForm();" value="GUARDAR" style="background:#036; color:#FFF; padding:4px; margin:4px; border:1px solid #333; font-weight:bold;"/>
    </form>
    </div>
	<div id="divResult"></div>
	</div>
	<div id="capture_result" class="capture_cont">
        <iframe id="uploadedImage" name="uploadedImage" src="" style="width:320px; height:280px" frameborder="0" marginheight="0" marginwidth="0" scrolling="auto"></iframe>
    </div>
</div>