<?php include('../../init.php');
$val=$_GET['idsearch'];
$query_RScli = "SELECT * FROM db_pacientes";
$RScli = mysql_query($query_RScli) or die(mysql_error());
$row_RScli = mysql_fetch_assoc($RScli);
$totalRows_RScli = mysql_num_rows($RScli);
$q = strtolower($_GET["q"]);
if (!$q) return;
do{
	if($val=='find_nom') $find_cad=$row_RScli['cli_nom'].' '.$row_RScli['cli_ape'];
	if($val=='find_ape') $find_cad=$row_RScli['cli_ape'].' '.$row_RScli['cli_nom'];
	if($val=='find_dir') $find_cad=$row_RScli['pac_dir'].' - '.$row_RScli['cli_nom'].' '.$row_RScli['cli_ape'];
	if($val=='find_tel') $find_cad=$row_RScli['pac_tel1'].' - '.$row_RScli['pac_tel2'].' _ '.$row_RScli['cli_nom'].' '.$row_RScli['cli_ape'];
	if($val=='find_ciu') $find_cad=$row_RScli['pac_ciu'].' - '.$row_RScli['cli_nom'].' '.$row_RScli['cli_ape'];
	$items [$find_cad]=$row_RScli['cli_id'];
} while ($row_RScli = mysql_fetch_assoc($RScli));
foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) echo "$key|$value\n";
}
?>