<?php include_once('../../init.php'); ?>
<style type="text/css">
.catalog-head {font-size:10px !important;}
.catalog-top {font-size:10px !important;}
.catalog-cont {font-size:10px !important;}
.catalog-cont .tabCont{}
.catalog-cont .tabCont .tabCont-td{background-color:#ddd}
.tabContDet > .tcd-img{ text-align:center; background-color:#fff}
.tabContDet > .tcd-tit{ text-align:center; background-color:#fff; font-size:13px; font-weight:bold; padding:10px;}
.tabContDet > .tcd-stit{ text-align:center; background-color:#eee; font-size:9px; padding:10px;}
.contProd{ background-color:#ccc;}
.contProd-img{text-align:center; background-color:#FFF; display:table}
.contProd-tit{text-align:center;background-color:#efefef; font-weight:bold; font-size:12px; display:block}
.contProd-stit{text-align:center;background-color:#eeeeee; font-size:8px; display:block}
.contProd-det{ background-color:#ddd}
.catalog .catalog-foot {}
.label{color: #fff;background-color: #999;}
.labelP{color: #fff;background-color: #999;}
.labelT{color: #000;font-weight: bold;background-color: #fff;}
.img-mini{height:140px;}
</style>
<?php
$contParam=0;
$idMar=vParam('idMar',$_GET['idMar'],$_POST['idMar']);
$idTip=vParam('idTip',$_GET['idTip'],$_POST['idTip']);
$idEnv=vParam('idCol',$_GET['idCol'],$_POST['idCol']);

$p1=vParam('p1',$_GET['p1'],$_POST['p1']);
$p2=vParam('p2',$_GET['p2'],$_POST['p2']);
$p3=vParam('p3',$_GET['p3'],$_POST['p3']);
$stock=vParam('stock',$_GET['stock'],$_POST['stock']);

if($idMar){
	$listParam[$contParam][0]='mar_id';
	$listParam[$contParam][1]=$idMar;
	$listParam[$contParam][2]='idMar';
	$contParam++;
}
if($idTip){
	$listParam[$contParam][0]='tip_cod';
	$listParam[$contParam][1]=$idTip;
	$listParam[$contParam][2]='idTip';
	$contParam++;
}
if($idEnv){
	$listParam[$contParam][0]='id_atr_env';
	$contParam++;
}
//Parametros Opcionales Solo para URL, no para consulta
$contParamO=0;
if($stock){ $contParamO++;
	$listParamO[$contParamO][0]=NULL;
	$listParamO[$contParamO][1]=$stock;
	$listParamO[$contParamO][2]='stock';
}
if($p1){ $contParamO++;
	$listParamO[$contParamO][0]=NULL;
	$listParamO[$contParamO][1]=$p1;
	$listParamO[$contParamO][2]='p1';
}
if($p2){ $contParamO++;
	$listParamO[$contParamO][0]=NULL;
	$listParamO[$contParamO][1]=$p2;
	$listParamO[$contParamO][2]='p2';
}
if($p3){ $contParamO++;
	$listParamO[$contParamO][0]=NULL;
	$listParamO[$contParamO][1]=$p3;
	$listParamO[$contParamO][2]='p3';
}



$query_RSc = "SELECT
  tbl_inv_productos.prod_id,
  tbl_inv_productos.mar_id,
  tbl_inv_productos.tip_cod,
  tbl_inv_productos.id_atr_env,
  tbl_inv_productos.prod_img,
  SUM(inv_can-inv_sal) as stock_inventario 
FROM
  tbl_inventario,
  tbl_compra_det,
  tbl_inv_productos
WHERE
  inv_can>inv_sal AND 
  tbl_inventario.comdet_id=tbl_compra_det.id AND
  tbl_compra_det.prod_id=tbl_inv_productos.prod_id AND
  tbl_inv_productos.prod_stat=1 ";
if(($idMar)||($idTip)||($idEnv)||($idMat)||($idTam)){
	$totParam=count($listParam);
	if ($totParam>0){
		$query_RSc.= "AND tbl_inv_productos.prod_stat='1' AND ";
		$paramsPrint.="?print=TRUE&";
		for($i=0;$i<$totParam;$i++){
			if(isset($listParam[$i][0])){$query_RSc.=$listParam[$i][0].'='.$listParam[$i][1];}
			$paramsPrint.=$listParam[$i][2]."=".$listParam[$i][1];
			if ($i+1<=$totParam-1){
				$query_RSc.=" AND ";
				$paramsPrint.="&";
			}
		}
	}
}
$query_RSc.= " GROUP BY
  tbl_compra_det.prod_id ORDER BY tbl_inv_productos.tip_cod DESC";
$RSc = mysql_query($query_RSc) or die(mysql_error());
$row_RSc = mysql_fetch_assoc($RSc);
$row_RScv=$row_RSc;
$totalRows_RSc = mysql_num_rows($RSc);
//echo $query_RSc;
//Añade Params Optional a URL
$totParamO=count($listParamO);
	if ($totParamO>0){
		if ($totParam<=0) $paramsPrint.="?print=TRUE&";
		else $paramsPrint.="&";
		for($j=0;$j<=$totParamO;$j++){
			$paramsPrint.=$listParamO[$j][2]."=".$listParamO[$j][1];
			$paramsPrint.="&";
		}
	}
?>

<?php
if($totalRows_RSc>0){
if($viewContPanel){ ?>
<div class="row-fluid">
	<a href="_c_catalog_print.php<?php echo $paramsPrint ?>" rel="shadowbox" class="btn blue span6"><i class="icon-print"></i> Imprimir</a>
    <a href="index.php<?php echo $paramsPrint ?>" class="btn blue span6"><i class="icon-edit"></i> Modificar</a>
</div>

<div class="well">
	<table class="table">
    <thead>
    <tr>
    	<th>ID</th>
        <th>COD</th>
        <th>Nombre</th>
        <?php if($stock=='si'){ ?><th>Cantidad</th> <?php } ?>
        <?php if($p1=='p1'){ ?><th>Precio 1</th> <?php } ?>
        <?php if($p2=='p2'){ ?><th>Precio 2</th> <?php } ?>
        <?php if($p3=='p3'){ ?><th>Precio 3</th> <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php do{
	$detProd=detInvProd($row_RSc['prod_id']);
	if($stock=='si'){ $vstock=stock_existente_producto($row_RSc['prod_id']); }
	
	?>
    <tr>
    	<td><?php echo $row_RSc['prod_id'] ?></td>
        <td><?php echo $detProd['prod_cod'] ?></td>
        <td><?php echo $detProd['prod_nom'] ?></td>
        <?php if($stock=='si'){ ?><th><?php echo $vstock ?></th><?php } ?>
        <?php if($p1=='p1'){ ?><th><?php echo valInvUCom($row_RSc['prod_id'],1) ?></th><?php } ?>
        <?php if($p2=='p2'){ ?><th><?php echo valInvUCom($row_RSc['prod_id'],2) ?></th><?php } ?>
        <?php if($p3=='p3'){ ?><th><?php echo valInvUCom($row_RSc['prod_id'],3) ?></th><?php } ?>
    </tr>
    <?php }while($row_RSc = mysql_fetch_assoc($RSc)); ?>
    </tbody>
    </table>
</div>

<?php }else{ ?>
<div class="catalog-cont">
    <table class="table tabCont" cellspacing="4" cellpadding="4">
	<?php
    $contProdView=0;
	$contProdViewTot=0;
	do{
		$detProd=detInvProd($row_RSc['prod_id']);
		if($stock=='si'){ $vstock=stock_existente_producto($row_RSc['prod_id']); }
		$detMar=detInvMar($row_RSc['mar_id']);
		$detTip=detInvTip($row_RSc['tip_cod']);
		$detCat=detInvCat($detTip['cat_cod']);
		//$pimage=fnc_image_exist('db/prod/',$row_RSc['prod_img'],TRUE);
		if($row_RSc['prod_img'])
			$viewImage='<img src="'.RAIZidb.'prod/'.$row_RSc['prod_img'].'" class="img-mini"/>';
		else
			$viewImage='<img src="'.RAIZi.'struct/no_image.jpg" class="img-mini"/>';
		if ($contProdView==0){
			echo '<tr>';
		}
		$contProdViewTot++;
		$contProdView++;

	?>
    <td class="tabCont-td">
			<table class="tabContDet" cellpadding="0" cellspacing="0">
			<tr>
            	<td colspan="2" class="tcd-img"><?php echo $viewImage ?></td>
			</tr>
            <tr>
                <td colspan="2" class="tcd-tit"><?php echo $detProd['prod_nom'] ?></td>
			</tr>
            <tr>
                <td colspan="2" class="tcd-stit"><?php echo $detTip['tip_nom'] ?> / <?php echo $detCat['cat_nom'] ?></td>
            </tr>
            <tr>
				<td style="padding:0px 6px 0px 2px; border-right:1px solid #CCC">
                <span class="label labelP"> COD </span><span class="label labelT"> <?php echo $row_RSc['prod_cod'] ?> </span><br>
                <span class="label labelP"> MAR </span><span class="label labelT"> <?php echo $detMar['mar_nom'] ?> </span>
                 <?php if($stock=='si'){ ?><br><span class="label labelP"> Stock </span><span class="label labelT"> <?php echo $vstock?> </span><?php } ?>
                
                </td>
				<td style="padding-left:4px;">
				<?php if($p1=='p1'){ ?><span class="label labelP"> P1 </span><span class="label labelT"> <?php echo valInvUCom($row_RSc['prod_id'],1) ?> </span><br><?php } ?>
				<?php if($p2=='p2'){ ?><span class="label labelP"> P2 </span><span class="label labelT"> <?php echo valInvUCom($row_RSc['prod_id'],2) ?> </span><br><?php } ?>
				<?php if($p3=='p3'){ ?><span class="label labelP"> PVP </span><span class="label labelT"> <?php echo valInvUCom($row_RSc['prod_id'],3) ?> </span><?php } ?>
                </td>
			</tr>
			</table>
    </td>
    <?php
    	if (($contProdView==2)||($totalRows_RSc==$contProdViewTot)){
			echo '</tr>';
			$contProdView=0;
		}
	}while ($row_RSc = mysql_fetch_assoc($RSc)); ?>
    </table>
</div>
<?php }}else{ ?>
<div class="alert"><h3>No hay coincidencias de resultados</h3>
<a href="index.php<?php echo $paramsPrint ?>" class="btn blue"><i class="icon-edit"></i> Modificar Consulta</a>
.
</div>
<?php } ?>