<?php require('../../init.php');
$idd=vParam('idd',$_GET['idd'],$_POST['idd']);
$detdoc=fnc_datadoc($idd);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container">
	<div class="well" style="background:#FFF">
	<?php echo $detdoc['contenido'] ?>
	</div>
</div>
</body>
</html>