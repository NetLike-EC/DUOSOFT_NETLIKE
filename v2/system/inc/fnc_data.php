<?php

//ULTIMA IMAGEN DE UN PACIENTE
function lastImgTab($tab,$field,$param,$fieldOrd=NULL,$sOrd='DESC'){
	$dPI=detRow($tab,$field,$param,$fieldOrd,$sOrd);
	if($dPI){
		$dMed=detRow('db_media','id_med',$dPI['id_med']);
	}
	return $dMed['file'];
}

function lastImgPac($param){
	$dPI=detRow('db_clientes_media','cod_pac',$param,'id','DESC');
	if($dPI){
		$dMed=detRow('db_media','id_med',$dPI['id_med']);
	}
	return $dMed['file'];
}

//Generar QRY para busqueda de pacientes

function genCadSearchPac($term){

if ($term){
	$cadBus=fnc_cutblanck($term);
	$cadBusT=explode(" ",$cadBus);
  	$cadBusN=count($cadBusT);
	//echo $cadBusN;
	if($cadBusN>1){
	$qry=sprintf('SELECT *, MATCH (db_clientes_nom.cli_nom, db_clientes_nom.cli_ape) AGAINST (%s) AS Score FROM db_clientes_nom
INNER JOIN db_clientes ON db_clientes.cli_id=db_clientes_nom.cli_id
WHERE MATCH (db_clientes_nom.cli_nom, db_clientes_nom.cli_ape) AGAINST (%s)
ORDER BY Score DESC ',
	SSQL($cadBus,'text'),
	SSQL($cadBus,'text'));
	}else{
		$qry=sprintf('SELECT * FROM db_clientes_nom
INNER JOIN db_clientes ON db_clientes.cli_id=db_clientes_nom.cli_id
WHERE db_clientes.cli_nom LIKE %s OR db_clientes.cli_ape LIKE %s ',
	SSQL('%'.$cadBus.'%','text'),
	SSQL('%'.$cadBus.'%','text'));
	}
}else{
	$qry=sprintf('SELECT * FROM db_clientes ORDER BY cli_id DESC ');
}
return $qry;
}

function genPageNavbar($MOD, $tit=NULL, $des='',$icon=NULL,$css='navbar-fixed-top'){
	$banMod=FALSE;
	if($MOD){
		$rowMod=detMod($MOD);
		if($rowMod){$banMod=TRUE;}
	}
	if ($banMod==FALSE){
		$rowMod['mod_nom']=$tit;
		$rowMod['mod_des']=$des;
		$rowMod['mod_icon']=$icon;
	}
	$returnTit;
	$returnTit.='<nav class="navbar navbar-default">';
	$returnTit.='<div class="container-fluid">';
	$returnTit.='<div class="navbar-header">';
    $returnTit.='<a class="navbar-brand" href="#">'.$rowMod['mod_nom'];
	$returnTit.=' <small class="label label-default">'.$rowMod['mod_des'].'</small></a>';
	$returnTit.='</div>';
    $returnTit.='</div></nav>';
	return $returnTit;
}

function sendMail_MC_Test($data){
  $EST=FALSE;
	date_default_timezone_set('America/New_York');
	$mail = new PHPMailer(true);
	$mail->IsSMTP();//telling the class to use SMTP
	try {
		//data:{subject:$("#stSub"), mail:$("#stMail"), msg:$("#stCon")},
		$mail->Host = 'ssl://smtp.gmail.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->Username = 'marketing@mercoframes.net';
		$mail->Password = 'Mkt$1801';
		/*************** MAIL TO ADMIN ****************/
		$mail->AddAddress('webmaster@mercoframes.net', 'Webmaster MERCOFRAMES');
		$mail->SetFrom('webmaster@mercoframes.net', 'Mercoframes Optical Corp');
		$mail->AddReplyTo('webmaster@mercoframes.net', 'Webmaster MERCOFRAMES');
		$mail->Subject = $data['subject'];
		//$mail->AltBody = $data['altbody'];
		$mail->MsgHTML($data['msg']);
		$mail->Send();
		/*************** MAIL TO TESTER *****************/
		if($data['mail']){
			$LOG.='<h4><i class="fa fa-life-ring fa-lg"></i>  To Admin and '.$data['mail'].'</h4>';
			$mail->ClearAddresses();
			$mail->AddAddress($data['mail']);
			$mail->SetFrom('webmaster@mercoframes.net', 'Mercoframes Optical Corp');
			$mail->AddReplyTo($data['reply']);
			$mail->AddReplyTo('webmaster@mercoframes.net', 'Webmaster MERCOFRAMES');
			$mail->Subject = $data['subject'];
			$mail->MsgHTML($data['msg']);
			$mail->Send();
		}
		$LOG.='<h4><i class="fa fa-life-ring fa-lg"></i>  Your Mail Test was sent sucessfully.</h4>';
		$EST=TRUE;
	} catch (phpmailerException $e) {
	  $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  $e->getMessage(); //Boring error messages from anything else!
	}
	$ret['EST']=$EST;
	$ret['RES']=$LOG.$e;
	return ($ret);
}

function fnc_numitems_cats($param1){
	$query_RS_datos = "SELECT * FROM tbl_items WHERE cat_id=".$param1;
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$totalRows_RS_datos = mysql_num_rows($RS_datos); 
	return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}
function fnc_numsucats($param1){
	$query_RS_datos = "SELECT * FROM tbl_items_cats WHERE cat_id_parent=".$param1;
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}

function fnc_numitems_catsWA($param1){
	$query_RS_datos = "SELECT * FROM tbl_wa_items_multicats WHERE cat_id=".$param1;
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$totalRows_RS_datos = mysql_num_rows($RS_datos); 
	return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}
function fnc_numsucatsWA($param1){
	$query_RS_datos = "SELECT * FROM tbl_wa_items_cats WHERE cat_id_parent=".$param1;
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}

function dataContact($param1){ $query_RS_datos = "SELECT * FROM tbl_contact_data WHERE idData='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

function dataContMail($param1){ $query_RS_datos = "SELECT * FROM tbl_contact_mail WHERE idMail='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Detail Mail Exception
function dataContMailE($param1){ $query_RS_datos = sprintf("SELECT * FROM tbl_contact_mail_exception WHERE idMail=%s",
GetSQLValueString($param1,'int')); $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

function dataContMsg($param1){ $query_RS_datos = "SELECT * FROM tbl_contact_msg WHERE idMsg='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

function fnc_datamod($param1){
	Global $conn;
	$qry = sprintf("SELECT * FROM tbl_modules WHERE mod_ref=%s",
							 SSQL($param1,'text'));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS); 
	return ($row_RS); mysqli_free_result($RS);
}

//Datos Modulo 
function detMod($param1){ Global $conn;
	$qry = sprintf("SELECT * FROM db_componentes WHERE mod_cod=%s",
				   SSQL($param1,'int'));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$row_RS = mysqli_fetch_assoc($RS);
	$totalRows_RS = mysqli_num_rows($RS);
	return ($row_RS);
	mysqli_free_result($RS);
}

//Detalle Item : with tables related
function detItem($p1){ $qry=sprintf('SELECT tbl_items.item_id AS i_id, tbl_items.item_aliasurl AS i_url, tbl_items.item_cod AS i_cod, tbl_items.item_nom AS i_nom, tbl_items.item_ref AS i_ref, tbl_items.item_des AS i_des, tbl_items.item_date AS i_date, tbl_items.item_img AS i_img, tbl_items.item_hits AS i_hit, tbl_items.item_status AS i_stat, tbl_items_brands.id as b_id, tbl_items_brands.url AS b_url, tbl_items_brands.name AS b_nom, tbl_items_brands.img as b_img, tbl_items_type.typID AS c_id, tbl_items_type.typNom AS c_nom, tbl_items_type.typUrl AS c_url 
FROM `tbl_items` 
LEFT JOIN tbl_items_brands ON tbl_items.brand_id=tbl_items_brands.id
LEFT JOIN tbl_items_type_vs ON tbl_items.item_id=tbl_items_type_vs.item_id 
LEFT JOIN tbl_items_type ON tbl_items_type_vs.typID=tbl_items_type.typID 
WHERE tbl_items.item_id=%s LIMIT 1',
GetSQLValueString($p1,'int'));
$RS = mysql_query($qry) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
mysql_free_result($RS);
return($dRS);}

function fnc_cats($param1){ $query_RS_datos = "SELECT * FROM tbl_items_cats WHERE cat_id='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

function fnc_catsWA($param1){ $query_RS_datos = "SELECT * FROM tbl_wa_items_cats WHERE cat_id='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

function fnc_item($param1){ $query_RS_datos = "SELECT * FROM tbl_items WHERE item_id='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

function fnc_itemWA($param1){ $query_RS_datos = "SELECT * FROM tbl_wa_items WHERE item_id='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Data Multimedia Media(Swf and other)
function fnc_media($param1){ $query_RS_datos = "SELECT * FROM tbl_mod_media WHERE med_id='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Data Gallery
function fnc_gallery($param1){ $query_RS_datos = "SELECT * FROM tbl_gallery WHERE gall_id='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Data VID
function fnc_vid($param1){ $query_RS_datos = "SELECT * FROM tbl_mod_videos WHERE vid_id='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Article
function fnc_dataart($param1){ $query_RS_datos = "SELECT * FROM tbl_articles WHERE art_id='".$param1."' LIMIT 1"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Article Category
function fnc_dataartc($param1){ $query_RS_datos = "SELECT * FROM tbl_articles_cat WHERE cat_id='".$param1."' LIMIT 1"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

///////////////////////////////////////// LISTAS ////////////////////////////////////////////

function listCatsItems($param1){
	$query_RS_datos = sprintf('SELECT cat_id as sID FROM tbl_wa_items_multicats WHERE item_id=%s',
	GetSQLValueString($param1,'int'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	if($totalRows_RS_datos>0){
		$x=0;
		do{
			$listCats[$x]=$row_RS_datos['sID'];
			$x++;
		} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	}
	mysql_free_result($RS_datos);
	return ($listCats);
}

//LISTADO DE PRODUCTOS
function listItems(){
$query_RS_datos = sprintf("SELECT item_id as sID, CONCAT(item_id,' - ',item_cod) as sVAL FROM tbl_items WHERE item_status='1' ORDER BY item_id DESC");
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos); mysql_free_result($RS_datos);
}


//LISTADO DE CATEGORIAS PRODUCTO
function listCats(){
$query_RS_datos = sprintf("SELECT cat_id as sID, CONCAT(cat_id,' - ',cat_nom)as sVAL FROM tbl_items_cats WHERE cat_status=%s ORDER BY cat_id DESC", GetSQLValueString('1','int'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos); mysql_free_result($RS_datos);
}
//LISTADO DE CATEGORIAS PRODUCTO WELCHALLYN
function listCatsWa(){
$query_RS_datos = sprintf("SELECT cat_id as sID, CONCAT(cat_id,' - ',cat_nom)as sVAL FROM tbl_wa_items_cats WHERE cat_status=%s ORDER BY cat_id DESC", GetSQLValueString('1','int'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos); mysql_free_result($RS_datos);
}
//LISTADO DE CATEGORIAS DE ARTICULOS
function listArtCats(){
$query_RS_datos = sprintf("SELECT cat_id as sID, cat_nom as sVAL FROM tbl_articles_cat WHERE cat_status=%s ORDER BY cat_id DESC", GetSQLValueString('1','int'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos); mysql_free_result($RS_datos);
}

?>