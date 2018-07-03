<?php include('../../../init.php');
$qryJson=sprintf("SELECT * FROM db_fullcalendar 
LEFT JOIN db_clientes ON db_fullcalendar.cli_id=db_clientes.cli_id 
LEFT JOIN db_types ON db_fullcalendar.typ_cod=db_types.typ_cod 
WHERE fechai>=%s AND fechaf<=%s ",
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
		$color='#2e4174';
	}else{
		$det_tit=$row['obs'];
		$color='#73b9e6';
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
	
	if($row['fechai']<$sdate){
		$color="#ccc";
	}
	
	
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