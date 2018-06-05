<?php include('../../init.php');
$bus=vParam('bus',$_GET['bus'],$_POST['bus']);

if($bus=='findCod'){
$query_RS_lp = sprintf('SELECT * FROM tbl_inv_productos INNER JOIN tbl_inv_tipos ON tbl_inv_productos.tip_cod=tbl_inv_tipos.tip_cod INNER JOIN tbl_inv_marcas ON tbl_inv_productos.mar_id=tbl_inv_marcas.mar_id WHERE tbl_inv_productos.prod_stat="1" AND tbl_inv_productos.prod_cod =%s',
GetSQLValueString($_REQUEST['term'],'text'));
$RS_lp = mysql_query($query_RS_lp) or die(mysql_error());
$row_RS_lp=mysql_fetch_assoc($RS_lp);
$tr_RS_lp=mysql_num_rows($RS_lp);
//while($row_RS_lp = mysql_fetch_array($RS_lp)){
	$code=$row_RS_lp['prod_id'];
	$value=$row_RS_lp['prod_cod'].' ( '.$row_RS_lp['prod_nom'].' )';
	$label=$row_RS_lp['prod_cod'].' ( '.$row_RS_lp['prod_nom'].' )';
if($tr_RS_lp){	
	$datos[]= array(
		'code' => $code,
		'value' => $value,
		'label' => $label,
		'acc' => 'true'
	);
}else{
	$datos[]= array(
		'code' => 'Nada',
		'value' => 'Nada',
		'label' => 'Sin Resultados',
		'acc' => 'false'
	);
}
//}

}else if($bus=='findTip'){
$query_RS_lp = 'SELECT * FROM tbl_inv_productos INNER JOIN tbl_inv_tipos ON tbl_inv_productos.tip_cod=tbl_inv_tipos.tip_cod INNER JOIN tbl_inv_marcas ON tbl_inv_productos.mar_id=tbl_inv_marcas.mar_id WHERE tbl_inv_productos.prod_stat="1" AND tbl_inv_productos.prod_nom LIKE "%'.$_REQUEST['term'].'%" OR tbl_inv_productos.prod_cod LIKE "%'.$_REQUEST['term'].'%"';
$RS_lp = mysql_query($query_RS_lp) or die(mysql_error());
while($row_RS_lp = mysql_fetch_array($RS_lp)){
	$code=$row_RS_lp['prod_id'];
	$value=$row_RS_lp['tip_nom'].' ( '.$row_RS_lp['prod_nom'].' ) ';
	$label=$row_RS_lp['tip_nom'].' ( '.$row_RS_lp['prod_nom'].' ) ';
	$datos[] = array(
					'code' => $code,
					'value' => $value,
					'label' => $label
	);
}

}else{
$query_RS_lp = 'SELECT * FROM tbl_inv_productos INNER JOIN tbl_inv_tipos ON tbl_inv_productos.tip_cod=tbl_inv_tipos.tip_cod INNER JOIN tbl_inv_marcas ON tbl_inv_productos.mar_id=tbl_inv_marcas.mar_id WHERE tbl_inv_productos.prod_stat="1" AND tbl_inv_productos.prod_nom LIKE "%'.$_REQUEST['term'].'%" OR tbl_inv_productos.prod_cod LIKE "%'.$_REQUEST['term'].'%"';
$RS_lp = mysql_query($query_RS_lp) or die(mysql_error());
while($row_RS_lp = mysql_fetch_array($RS_lp)){
	$code=$row_RS_lp['prod_id'];
	$value=$row_RS_lp['prod_nom'];
	$label=$row_RS_lp['prod_nom'];
	$datos[] = array(
					'code' => $code,
					'value' => $value,
					'label' => $label
	);
}
}

echo json_encode($datos);
?>