<script type="text/javascript" src="webcam.js"></script>
<script language="JavaScript">
webcam.set_api_url( 'pacImgCapUpl.php?id=<?php echo $id ?>' );
webcam.set_quality( 100 ); // JPEG quality (1 - 100)
webcam.set_shutter_sound( true ); // play shutter click sound
webcam.set_hook( 'onComplete', 'my_completion_handler' );
function do_upload() {// upload to server
	document.getElementById('upload_results').innerHTML = '<strong>Cargando...</strong>';
	webcam.upload();
}
function my_completion_handler(msg) { // extract URL out of PHP output
	if (msg.match(/(http\:\/\/\S+)/)) {
		var image_url = RegExp.$1;
		// show JPEG image in page
		document.getElementById('upload_results').innerHTML = 
			'<strong>FOTO GUARDADA!</strong>' + 
			'<img src="' + image_url + '" class="img-polaroid">';
		webcam.reset(); // reset camera for another shot
	} else alert("PHP Error: " + msg);
}
</script>
<div class="btn-group">
<a class="btn btn-default btn-sm" onClick="webcam.reset()"><span class="glyphicon glyphicon-ban-circle"></span> Reset</a>
<a class="btn btn-default btn-sm" onClick="webcam.freeze()"><span class="glyphicon glyphicon-camera"></span> Capturar</a>
<a class="btn btn-default btn-sm" onClick="do_upload()"><span class="glyphicon glyphicon-hdd"></span> Guardar</a>
<a class="btn btn-default btn-sm" onClick="webcam.configure()"><span class="glyphicon glyphicon-wrench"></span> </a>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
    <div class="well well-sm">
		<div id="upload_results"></div>
	</div>
    </div>
    <div class="col-sm-6">
    <div class="well well-sm">
    	<div><script language="JavaScript">document.write(webcam.get_html(600,400));</script></div>
    </div>
    </div>
</div>