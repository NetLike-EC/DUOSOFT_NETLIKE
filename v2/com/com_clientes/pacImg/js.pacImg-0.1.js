// JavaScript Documentvar http = getXMLHTTPRequest();
//
//	PACIENTE CAPTURE
//
$(document).ready(function() {
	$('.loadFramePacImg').click(function () {
        var urlL = $(this).attr('rel');
		var id = $(this).attr('data-id');
        $('#divLIP').load(urlL,{id:id}); //$('#iframe').reload();
		//$( "#objectID" ).load( "test.php", { "choices[]": [ "Jon", "Susan" ] } );
    });
});
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


//
//	PACIENTE UPLOAD
//

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
      	var url = "pacImgUplSubmit.php";
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