<?php require('../../init.php');
$qry='SELECT * FROM db_terapiastrata ORDER BY nom_trat ASC';
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$trat=array();
$trat['0']['valor']='';
$trat['0']['nombre']='- Seleccion Tratamiento -';
$cont=1;
do{
	$trat[$cont]['valor']=$dRS['id_trat'];
	$trat[$cont]['nombre']=$dRS['nom_trat'];
	$cont++;
}while($dRS=mysql_fetch_assoc($RS));
mysql_free_result($RS);
echo json_encode($trat);
?>