<?php require('../../../init.php');
$css['body']='cero';
include(RAIZf.'head.php') ?>
<script type="text/javascript" src="webcam.js"></script>
<script language="JavaScript">
webcam.set_api_url( 'uploadfile.php?idpac=<?php echo $_GET['idpac']; ?>' );
webcam.set_quality( 90 ); // JPEG quality (1 - 100)
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
<div class="navbar navbar-default navbar-static-top">

	<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">CAPTURAR</a>
  </div>

	<!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
		<li><a class="btn" onClick="webcam.reset()"><span class="glyphicon glyphicon-ban-circle"></span> Reset</a></li>
        <li><a class="btn" onClick="webcam.freeze()"><span class="glyphicon glyphicon-camera"></span> Capturar</a></li>
        <li><a class="btn" onClick="do_upload()"><span class="glyphicon glyphicon-hdd"></span> Guardar</a></li>
        <li><a class="btn" onClick="webcam.configure()"><span class="glyphicon glyphicon-wrench"></span> </a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</div>
<div class="row-fluid">
	<div class="span6">
    <div class="well well-sm">
    	<div><script language="JavaScript">document.write(webcam.get_html(400,300));</script></div>
    </div>
    </div>

    <div class="span6">
    <div class="well well-sm">
		<div id="upload_results"></div>
	</div>
    </div>
</div>