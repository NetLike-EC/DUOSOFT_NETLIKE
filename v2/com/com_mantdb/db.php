<?php include('../../init.php');
include(RAIZf.'_head.php');
if($_GET['token']=='db2015..'){
$nI="2606";
$nF="2689";
$vDO=TRUE;
$contR=0;
echo '<ul>';
for ($x = $nI; $x <= $nF; $x++) {
    if($vDO==TRUE){
		$qryD=sprintf('DELETE FROM tbl_items_type_vs WHERE item_id=%s',
		GetSQLValueString($x,'int'));
		if(mysql_query($qryD)){ $LOG='Delete Old Cats';
		}else{ $LOG='Error while delete Old Cats. '.mysql_error(); }
	}
	
	$qry=sprintf('INSERT INTO tbl_items_type_vs (item_id, typID) VALUES (%s,%s)',
	GetSQLValueString($x,'int'),
	GetSQLValueString('136','int'));
	if(mysql_query($qry)){
		$idI=mysql_insert_id();
		echo "<li>SUCCESS INSERT. ID: ".$idI.'. Item: '.$x.'<br>'.$LOG.'</li>'; 
	}else{
		echo "<li>Error. ".mysql_error()."<br>".$LOG."</li>";
	}
	$contR++;
}
echo '</ul>';
echo "<h4>Registros Generados. ".$contR."</h4>";
}else{
	echo 'Token no Valido';
}
?>