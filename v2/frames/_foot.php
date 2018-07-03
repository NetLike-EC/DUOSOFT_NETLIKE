<?php include(RAIZf.'_fra_bottom.php');
/*
if($conn){
	echo '<div class="text-center text-muted"><small>Conexion Cerrada</small></div>';
	mysqli_close($conn);
}
*/
?>
<hr>
<div class="text-center text-muted">
	<small>
		<div><?php echo var_dump($_SESSION['dU']) ?></div>
		<div>Persistent Connection</div>
	</small>
</div>
</body>
</html>