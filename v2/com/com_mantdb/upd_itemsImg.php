<?php include('../../init.php');
set_time_limit(600);
$token=vParam('token',$_GET['token'],$_POST['token']);
$idB=vParam('idB',$_GET['idB'],$_POST['idB']);

$cssBody='cero';
include(RAIZf.'_head.php'); ?>
<div class="container-fluid">
<h1 class=""><small class="label label-info">DB</small> update IMAGES items - only rows with NULL item_img field</h1>
<div class="well">
<form class="form-inline" method="get" action="<?php echo $urlc ?>">
	<label class="control-label">TOKEN</label>
    <input name="token" value="<?php echo $token ?>" class="form-control input-sm" required/>
    <label class="control-label">BRAND</label>
    <?php echo generarselect('idB', detRowGSel('tbl_items_brands','id','name','status','1','ORDER BY id ASC'), $idB, 'form-control','required'); ?>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-chevron-right fa-lg"></i> ACTUALIZAR</button>
</form>
</div>
</div>
<div class="container">///
<?php
if($_GET['token']=='db2017..'){
	$qLP=sprintf('SELECT * FROM tbl_items WHERE brand_id=%s and item_status=1 ORDER BY item_id ASC',
				SSQL($idB,'int'));
	echo "QRY. $qLP<br>";
	$RSlp=mysql_query($qLP) or die (mysql_error());
	$dRSlp=mysql_fetch_assoc($RSlp);
	$tRSlp=mysql_num_rows($RSlp);
	echo "Total Rows. $tRSlp<br>";
	if($tRSlp>0){
		do{
			echo "<hr>";
			echo "ItemID. $dRSlp[item_id] | ItemCod. $dRSlp[item_cod] | ItemImg. $dRSlp[item_img] <br>";
			if(!$dRSlp['item_img']){
				echo "No Image<br>";
				$contImg_NoImg++;//CUENTA CUANTOS NO TIENEN IMAGEN
				$nomFileImg=$dRSlp['item_cod'].'.jpg';
				$detImg=vImg('images/items/',$nomFileImg,FALSE);
				if($detImg[s]){
					$qUPD=sprintf('UPDATE tbl_items SET item_img=%s WHERE item_id=%s LIMIT 1',
								 SSQL($nomFileImg,'text'),
								 SSQL($dRSlp[item_id],'int'));
					if(@mysql_query($qUPD)){
						$contImg_Update++;//CUENTA CUANTOS SE VA A CARGAR NUEVA IMAGEN
						echo "Update Image $nomFileImg<br>";
					}else{
						$contImg_UpdateError++;//CUENTA CUANTOS SE VA A CARGAR NUEVA IMAGEN ERROR DATABASE
						echo "Error update database";
					}
				}else{
					$contImg_NewImgNo++;
					echo 'No File Exist<br>';
				}
			}else{
				echo "Si Image<br>";
				$contImg_Exist++;////CUENTA CUANTOS YA TIENEN
				$nomFileImg=$dRSlp['item_img'];
				$detImg=vImg('images/items/',$nomFileImg,FALSE);
				if($detImg[s]==TRUE){
					echo "File Exists -> $nomFileImg -> $detImg[n]" ;
					//Verifico THUMB
					$nomFileImgT='t_'.$dRSlp['item_img'];
					$detImgT=vImg('images/items/',$nomFileImgT,FALSE);
					if($detImgT[s]==FALSE){
						fnc_genthumb(RAIZ0.'images/items/', $nomFileImg, "t_", 220, 220);
						$contThumbGen++;
						echo 'ThumbGenerado';
					}
					
					
				}else{
					echo "File No Exists -> $nomFileImg -> $detImg[n]";
				}
			}
		}while($dRSlp=mysql_fetch_assoc($RSlp));
	}else{
		$LOGe= '<h4>No Items Found</h4>';
	}
}else $LOGe= '<h4>Invalid Token</h4>';
?>
<div class="container">
	<p>ITEMS CON IMAGEN. <?php echo $contImg_Exist ?></p>
	<p>ITEMS SIN IMAGEN. <?php echo $contImg_NoImg ?></p>
	<p>ITEMS ACTUALIZADA IMAGEN. <?php echo $contImg_Update ?></p>
	<p>ITEMS NUEVA IMAGEN NO EXISTE. <?php echo $contImg_NewImgNo ?></p>
	<hr>
	<p>THUMBS GENERADOS. <?php echo $contThumbGen ?></p>
</div>
<?php if($LOGe){ ?>
<div class="alert alert-danger"><?php echo $LOGe ?></div>

<?php } ?>
***
</div>
<script>
$(document).on('ready', function(){			
	$( "#nI" ).chosen();
	$( "#nF" ).chosen();
	$( "#idC" ).chosen();
});
</script>
<?php include(RAIZf.'_foot.php');?>