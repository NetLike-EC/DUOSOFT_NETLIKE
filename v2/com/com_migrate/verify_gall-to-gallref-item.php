<?php include('../../init.php');
include(RAIZf.'_head.php');
/*SELECCIONAR tbl_gallery
SACAR LOS itemview
INSERTAR EN tbl_gallery_ref
*/
$qryi='SELECT * FROM tbl_gallery';
$RSi=mysql_query($qryi);
$dRSi=mysql_fetch_assoc($RSi);
$trRSi=mysql_num_rows($RSi); ?>
<div class="container">
<h1>Migrate tbl_gallery (itemview) to table tbl_gallery_ref</h1>
<h2><?php echo "Total Registros. ".$trRSi; ?></h2>

<?php $contExistente=0;$contRegistrados=0;$contError=0;
do{
	$idg=$dRSi['gall_id'];//Obtengo el GALL ID desde tbl_gallery
	$idr=$dRSi['itemview'];//Obtengo el ITEM ID desde tbl_gallery
	//BUSCO EN GALLERY REF SI NO EXISTE EL ITEM
	$qrySGI=sprintf('SELECT COUNT(*) as TR from tbl_gallery_ref WHERE idg=%s AND idr=%s AND ref=%s',
				   SSQL($idg,'int'),
				   SSQL($idr,'int'),
				   SSQL('ITEM','text'));
	$RSsgi=mysql_query($qrySGI);
	$dRSi=mysql_fetch_assoc($RSsgi);
	$tRSi=$dRSi['TR'];
	//echo '<br>- '.$qrySGI;
	//echo ' [TR] - '.$tRSi;
	
	if($tRSi>0){
		$contExistente++;
	}else{
		$qryIR=sprintf('INSERT INTO tbl_gallery_ref (idg, idr, ref) VALUES (%s,%s,%s)',
				  SSQL($idg,'int'),
				  SSQL($idr,'int'),
				  SSQL('ITEM','text'));
		if(mysql_query($qryIR)) $contRegistrados++;
		else $contError++;
	}
}while($dRSi=mysql_fetch_assoc($RSi));
mysql_close($conn)
?>
<table class="table table-bordered">
	<thead>
	<tr>
		<th>Registros Creados</th>
		<th>Registros Existentes</th>
		<th>Registros Erroneos</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $contRegistrados; ?></td>
			<td><?php echo $contExistente; ?></td>
			<td><?php echo $contError; ?></td>
		</tr>
	</tbody>
</table>
</div>