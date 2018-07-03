<?php require('../../init.php');
$vP=TRUE;
//$css['body']="cero";
$cssBody='cero';
include(RAIZf.'_head.php');
// Test CVS
require_once RAIZs.'base/inc/phpExcelReader/reader.php';
// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();
// Set output Encoding.
$data->setOutputEncoding('CP1251');
/***
* if you want you can change 'iconv' to mb_convert_encoding:
* $data->setUTFEncoder('mb');
***/
/***
* By default rows & cols indeces start with 1
* For change initial index use:
* $data->setRowColOffset(0);
***/
/***
*  Some function for formatting output.
* $data->setDefaultFormat('%.2f');
* setDefaultFormat - set format for columns with unknown formatting
*
* $data->setColumnFormat(4, '%.3f');
* setColumnFormat - set format for column (apply only to number fields)
***/
$data->read('res/wa-all-01.xls');
/*
 $data->sheets[0]['numRows'] - count rows
 $data->sheets[0]['numCols'] - count columns
 $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column
 $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
     $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
        if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
    $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
    $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
    $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
*/
error_reporting(E_ALL ^ E_NOTICE); 
$msgAstx='<p class="lead">* NO RETURNS OR EXCHANGES * FINAL SALE *</p>';
?>
<?php
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
?>
<div class="container">
<h1>Migrate Excel to CMS mercoframes.com <small><span class="label label-default">v.0.5</span></small></h1>

<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>Num</th>
			<th>Cod</th>
			<th>Name</th>
			<th>Price</th>
			<th>Category</th>
			<th>Large Description</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
<?php
$contI=1;//contador de items tratados
$val_brand=26;//Brand Welch Allyn = 26 (tbl_items_brand)
//echo 'antes del FOR';
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
	$val['cod']=$data->sheets[0]['cells'][$i][1];
	$val['nom']=$data->sheets[0]['cells'][$i][2];
	$val_nom=$val['nom'];
	$val['price']=$data->sheets[0]['cells'][$i][3];
	$val['cat']=$data->sheets[0]['cells'][$i][4];
	$val['des']=$data->sheets[0]['cells'][$i][2];
	
	

	if(($val['price'])&&($val['price']>0)){
		
		//Category
		$dC=detRow('tbl_items_type','typNom',$val['cat']);
		if($dC){
			$LOG.='<span class="label label-info">TYPE EXISTS</span>';
			$dC_id=$dC['typID'];
		}else{
			$LOG.='<span class="label label-success">TYPE CREATE</span>';
			$dC_nom=$val['cat'];
			$dC_url=genUrlFriendly($val['cat']);
			$qCat=sprintf('INSERT INTO tbl_items_type (typIDp, typNom, typUrl, typDate, typ_id, typHits, typEst) 
			VALUES (%s,%s,%s,%s,%s,%s,%s)',
						 SSQL(1,'int'),
						 SSQL($dC_nom,'text'),
						 SSQL($dC_url,'text'),
						 SSQL($sdate,'date'),
						 SSQL(2,'int'),
						 SSQL(1,'int'),
						 SSQL(1,'int'));
			if(mysql_query($qCat)){
				$dC_id=mysql_insert_id();
				$LOG.='<p>Categoria creada. '.$dC_id.'</p>';
			}else{
				$vP=FALSE;
				$LOG.='<p>Error al crear categoria</p>';
				break;
			}
		}
		//
		
		$val_price=number_format($val['price'],2,'.','');
		$val_codLD=substr($val['cod'], -1);
		if($val_codLD=='*'){
			$val_cod=substr($val['cod'], 0, -1);//Elimino el ultimo caracter (*)
			$val_des=$data->sheets[0]['cells'][$i][2].$msgAstx;
		}else{
			$val_cod=$val['cod'];
			$val_des=$data->sheets[0]['cells'][$i][2];
		}
		$val_url=genUrlFriendly($val_cod);
		
		
		//VERIFICACIONES EN BASE DE DATOS
		$dP=detRow('tbl_items','item_cod',$val_cod);
		
		
		
		if($dP){
			$contIU++;
			$dI_id=$dP['item_id'];
			//$LOG.='<span class="label label-danger">'.$val_url.'</span>';
			
			//$LOG.='<span class="label label-default">UPDATE</span>';
			$qry=sprintf('UPDATE tbl_items SET item_lastupdate=%s, item_price=%s, item_status=%s, item_statusMU=%s
			WHERE item_id=%s',
				SSQL($sdate,'date'),
				SSQL($val['price'],'text'),
				SSQL(1,'int'),
				SSQL(1,'int'),
				SSQL($dP['item_id'],'int')
			);
			//$LOG.=$qry;
			if(mysql_query($qry)){
				$LOG.='<span class="label label-primary">UPDATE tbl_items</span>';
			}else{
				$vP=FALSE;
				$LOG.='<span class="label label-danger">ERROR UPDATE tbl_items</span>'.mysql_error();
				break;
			}
		}
		else{
			$contII++;
			$dIurlV=detRow('tbl_items','item_aliasurl',$val_url);
			if($dIurlV) $val_url.='-1';
			
			//$LOG.='<span class="label label-default">NEW</span>';
			$qry=sprintf('INSERT INTO tbl_items (item_cod, item_ref, brand_id, item_aliasurl, item_nom, item_des, item_date, item_price, item_hits, item_status, item_statusMU) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
				SSQL($val_cod,'text'),
				SSQL($val_cod,'text'),
				SSQL($val_brand,'int'),
				SSQL($val_url,'text'),
				SSQL($val_nom,'text'),
				SSQL($val_des,'text'),
				SSQL($sdate,'date'),
				SSQL($val_price,'text'),
				SSQL(1,'int'),
				SSQL(1,'int'),
				SSQL(1,'int')
			);
			//$LOG.=$qry;
			if(mysql_query($qry)){
				$LOG.='<span class="label label-success">INSERT tbl_items</span>';
				$dI_id=mysql_insert_id();
			}else{
				$vP=FALSE;
				$LOG.='<span class="label label-danger">ERROR INSERT tbl_items</span>'.mysql_error();
				break;
			}
		}
		
		//$LOG.='<hr>';
		//CATEGORIZACION
		
		$paramsN[]=array(
					array("cond"=>"AND","field"=>"item_id","comp"=>"=","val"=>$dI_id),
					array("cond"=>"AND","field"=>"typID","comp"=>'=',"val"=>$dC_id)
		);
		$detIT=detRowNP('tbl_items_type_vs',$paramsN);
		unset($paramsN);
		//var_dump($detIT);
		if($detIT){
			$LOG.='<span class="label label-default">Item_vs_type existente</span>';
		}else{
			$qryIC=sprintf('INSERT INTO tbl_items_type_vs (item_id, typID) VALUES (%s, %s)',
					  SSQL($dI_id,'int'),
					  SSQL($dC_id,'int'));
			//$LOG.=$qryIC.'<br>';
			if(mysql_query($qryIC)){
				$LOG.='<p>Item_vs_type = created</p>';
			}else{
				$vP=FALSE;
				$LOG.='<p>Error Item_vs_type</p>'.mysql_error();
				break;
			}
		}
		
		
		/*for ($j = 1; $j <= $data->sheets[0]['numCols']-1; $j++) {
			echo "<td>".$data->sheets[0]['cells'][$i][$j]."</td>";
		}*/
		?>
		<tr>
		<td><?php echo $contI ?></td>
		<td><?php echo $val_cod ?></td>
		<td><?php echo $val['nom'] ?></td>
		<td><?php echo $val_price ?></td>
		<td><?php echo $val['cat'].$LOGcat ?></td>
		<td><?php echo $val_des ?></td>
		<td><?php echo $LOG ?></td>
		</tr>
		<?php $contI++;
	}else{
		$contNVP++;
	}
	unset($LOG);
}
//echo 'Termina el FOR';
//print_r($data);
//print_r($data->formatRecords);
?>
	</tbody>
</table>
<hr>
  <span class="label label-info"><?php echo 'Actualizados '.$contIU ?></span> 
 <span class="label label-success"><?php echo 'Insertados '.$contII ?></span> 
 <span class="label label-warning"><?php echo 'Omitidos '.$contNVP ?></span> 
</div>
<?php
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	//mysql_query("ROLLBACK;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi='48/success.png';
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Solicitud no Procesada';
	$LOGc='alert-danger';
	$LOGi='48/cancel.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
?>
<?php sLOG('a'); ?>