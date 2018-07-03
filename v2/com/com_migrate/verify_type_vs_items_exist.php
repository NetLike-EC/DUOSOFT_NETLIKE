<?php include('../../init.php');
include(RAIZf.'_head.php');
$qryi='SELECT * FROM tbl_items_type_vs';
$RSi=mysql_query($qryi);
$dRSi=mysql_fetch_assoc($RSi);
$trRSi=mysql_num_rows($RSi);
echo "Total Registros. ".$trRSi;
echo '<table class="table" id="tab_base">';
echo '<thead><tr><th>ID</th><th>item_id</th><th>typID</th><th>Estado</th></tr></thead><tbody>';
do{
	$css=NULL;
	$res=NULL;
	$dI=detRow('tbl_items','item_id',$dRSi['item_id']);
	$dC=detRow('tbl_items_type','typID',$dRSi['typID']);
	
	if(($dI)&&($dC)){
		$res.='Item Existe. '.$dI['item_cod'].'<br>';
		$res.='Categoria Existe. '.$dC['typNom'].'<br>';
	}else{
		$css='danger';
		if(!$dI) $res.='No Existe Item.';
		if(!$dC) $res.='No Existe Categoria.';
		$qryD=sprintf('DELETE FROM tbl_items_type_vs WHERE id=%s',
		GetSQLValueString($dRSi['id'],'int'));
		$res.=$qryD;
		if(mysql_query($qryD)){
			$res.='Registro Eliminado Correctamente. ID. '.$dRSi['id'];
		}else{
			$res.='Error al Eliminar Registro. '.mysql_error();
		}
	}
	echo '<tr class="'.$css.'">';
	echo "<td>".$dRSi['id'].'</td>';
	echo "<td>".$dRSi['item_id'].'</td>';
	echo "<td>".$dRSi['typID'].'</td>';
	echo "<td>".$res.'</td>';
	echo '</tr>';
}while($dRSi=mysql_fetch_assoc($RSi));
echo '</tbody></table>';
mysql_close($conn)
?>