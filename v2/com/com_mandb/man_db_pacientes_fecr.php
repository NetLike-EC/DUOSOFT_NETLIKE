<?php include('../../init.php');
include(RAIZf.'head.php');

$qryLP="SELECT * FROM `db_clientes`";
//echo $qryLP;
$RSlp=mysql_query($qryLP);
$row_RSlp=mysql_fetch_assoc($RSlp);
$tr_RSlp=mysql_num_rows($RSlp);
?>
<body class="cero">
<div class="container">
<h2>Actualización Fecha Registro Paciente <small>Tomando Fecha primera Consulta</small></h2>
<?php
if($tr_RSlp>0){
	echo "<div class='alert alert-info'>Si hay registros: ".$tr_RSlp."</div>";
	echo '<table class="table table-bordered">';
	echo '<tr><td>Codigo</td>
	<td>Paciente</td>
	<td>Fecha Registro</td>
	<td>Fecha Primera Consulta</td>
	<td>Resultado</td></tr>';
	do{
		
		$detCon=detRow('db_consultas','pac_cod',$row_RSlp['pac_cod']);
		$detCon_num=$detCon['con_num'];
		$detCon_fec=$detCon['con_fec'];
		
		if($row_RSlp['pac_fecr']==NULL){
		
			$qryUPD=sprintf('UPDATE db_clientes SET pac_fecr=%s WHERE pac_cod=%s', 
			SSQL($detCon_fec,'date'),
			SSQL($row_RSlp['pac_cod'],'int'));
			if(mysql_query($qryUPD)){
				$LOG='<span class="label label-primary">SUCCESS UPDATE</span>';
			}else{
				$LOG='<span class="label label-danger">'.mysql_error().'</span>';
			}
		}else{
			$LOG='<span class="label label-primary">DATE EXISTING NO UPDATE</span>';
		}

		echo '<tr>';
		echo '<td>'.$row_RSlp['pac_cod'].'</td>';
		echo '<td>'.$row_RSlp['pac_nom'].' '.$row_RSlp['pac_ape'].'</td>';
		echo '<td>'.$row_RSlp['pac_fecr'].'</td>';
		echo '<td>'.$detCon_fec.'</td>';
		echo '<td>'.$LOG.'</td>';
		echo '</tr>';
	}while($row_RSlp=mysql_fetch_assoc($RSlp));
	echo '</table>';
	
}else{
	echo "<div class='alert alert-danger'>SIN REGISTROS</div>";
}
?>
</div>
</body>
</html>