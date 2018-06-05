<script type="text/javascript" src="webcam.js"></script>
<script language="JavaScript">
	webcam.set_api_url( 'uploadfile.php?idpac=<?php echo $_GET['idpac']; ?>' );
	webcam.set_quality( 90 ); // JPEG quality (1 - 100)
	webcam.set_shutter_sound( true ); // play shutter click sound
</script>
<script language="JavaScript">
webcam.set_hook( 'onComplete', 'my_completion_handler' );
	function do_upload() {
		// upload to server
		document.getElementById('upload_results').innerHTML = '<h2>Cargando...</h2>';
		webcam.upload();
	}
	function my_completion_handler(msg) {
		// extract URL out of PHP output
		if (msg.match(/(http\:\/\/\S+)/)) {
			var image_url = RegExp.$1;
			// show JPEG image in page
			document.getElementById('upload_results').innerHTML = 
				'<h2>FOTO GUARDADA!</h2>' + 
				'<img src="' + image_url + '">';
				// reset camera for another shot
			webcam.reset();
		}
		else alert("PHP Error: " + msg);
	}
</script>
<link href="../styles/style.css" rel="stylesheet" type="text/css" />
<h1>CAPTURAR IMAGEN</h1>
<div id="imagecapture_container">
	<div id="capture_main" class="capture_cont">
	<form>
    <div id="btns_capture">
        <input type="button" class="btn_webcam" value="Config" onClick="webcam.configure()">
        <input type="button" class="btn_webcam" value="Resetear" onClick="webcam.reset()">
		<input type="button" class="btn_webcam" value="Capturar" onClick="webcam.freeze()" style="background:#333;">
        <input type="button" class="btn_webcam" value="Subir Foto" onClick="do_upload()" style="background:#333;">
    </div>
    <div id="webcam_capture"><script language="JavaScript">document.write( webcam.get_html(320, 240) );</script></div>
	</form>
	</div>
	<div id="capture_result" class="capture_cont">
		<div id="upload_results"></div>
	</div>
</div>