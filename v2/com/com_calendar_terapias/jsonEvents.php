<?php include('../../init.php');
$qryJson=sprintf("SELECT db_fullcalendar_sesiones.id,cli_nom,cli_ape,obs,fechai,horai,fechaf,horaf,db_fullcalendar_sesiones.est,cli_id FROM db_fullcalendar_sesiones
LEFT JOIN db_terapias ON db_fullcalendar_sesiones.id_ter=db_terapias.id 
LEFT JOIN db_clientes ON db_terapias.idp=db_clientes.cli_id 
WHERE fechai>=%s AND fechaf<=%s AND db_fullcalendar_sesiones.est<>0",
SSQL($_GET['start'],'date'),
SSQL($_GET['end'],'date'));
$RSjson = mysql_query($qryJson) or die(mysql_error());
while($row = mysql_fetch_array($RSjson)){
	$det_tit=NULL;
	$fstart=NULL;
	$fend=NULL;
	$color=NULL;

	if($row['cli_id']){
		$det_tit.=$row['cli_nom'].' '.$row['cli_ape'];
	}else{
		$det_tit=$row['obs'];
	}
	
	if($row['typ_cod']) $det_tit.=' / '.$row['typ_val'];
	//Date Start
	$fstart.=$row['fechai'];
	if($row['horai']){
		$fstart.='T'.$row['horai'].$row['zona'];
	}
	//Date End
	$fend.=$row['fechaf'];
	if($row['horaf']){
		$fend.='T'.$row['horaf'].$row['zona'];
	}
	$end=$row['fechaf'];

	if($row['fechai']<$sdate){//COLORES BAJOS --> PASADO
		if($row['est']==2){//Atendido
			$color='#9cba8e';
		}else if($row['est']==1){//Pendiente
			$color='#bbb';
		}
	}else{//COLORES ALTOS --> PRESENTE/FUTURO
		if($row['est']==2){//Atendido
			$color='#009900';
		}else if($row['est']==1){//Pendiente
			if($row['cli_id']){
				$color='#084c8d';
			}else{
				$color='#5174b3';
			}
		}
	}

/*
	if($row['cli_id']){
		$color='#2e4174';
	}else{
		$color='#73b9e6';
	}
	
	if($row['fechai']<$sdate){
		if($row['est']==2){
			$color="#CCCC99";
		}else{
			$color="#ccc";
		}
	}else{
		if($row['est']==2){
			$color="#73b9e6";
		}else{
			$color="#2e4174";
		}
	}
*/
	$datos[] = array(
		'id' => $row['id'],
		'title' => $det_tit,
		'start' => $fstart,
		'end' => $fend,
		'color' => $color,
		//'url' => "#"//$row['url']
	);
}
echo json_encode($datos);