<?php include('../../init.php');
fnc_accessnorm();
$datenow=$sdate;
$baseurl=$RAIZ0;
$TL=0;//Total Links Generados

$cf=array("a" => "always", "h" => "hourly", "d" => "daily", "w" => "weekly", "m" => "monthly", "y" => "yearly", "n" => "never");
//[a] always - [h] hourly - [d] daily - [w] weekly - [m] monthly - [y] yearly - [n] never
$pr=array("0.0", "0.1", "0.2", "0.3", "0.4", "0.5", "0.6", "0.7", "0.8", "0.9", "1.0");
//Priority: 
include(RAIZf.'_head.php');
?>
<div class="container">
	<div class="page-header">
    	<h1><a class="btn" onClick="location.reload()"><i class="icon-refresh"></i></a> Sitemap Generate XML</h1>
	</div>
    <p class="lead">Process Generation !</p>
<?php $buffer;
$buffer.='<?xml version="1.0" encoding="utf-8"?>';
$buffer.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$buffer.=returnchildxml($baseurl,$datenow,$cf["d"],$pr[10]);//[HOME] http://www.mercoframes.net/
$TL++;
/********************************************************************************************************/
/********************************************************************************************************/
//Sitemap Articles Categories
$query_RS = "SELECT cat_id, cat_url, cat_fec FROM tbl_articles_cat WHERE cat_status = 1 ORDER BY cat_id DESC";
$RS = mysql_query($query_RS) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$totalRows_RS = mysql_num_rows($RS);
echo '<h2>Blog Articles Categories</h2>';
echo '<ul>';
do{
	$baseurl=$RAIZ0.'data/'.$dRS['cat_url'];
	$dateupd=$dRS['cat_fec'];
	if ((!($dateupd))||($dateupd==NULL)||($dateupd=='0000-00-00')) $dateupd=$datenow;
	echo '<li>'.$dRS['cat_id'].' <a href="'.$baseurl.'" target="_black">'.$baseurl.'</a> '.$dateupd.'</li>';
	$buffer.=returnchildxml($baseurl,$dateupd,$cf["w"],$pr[9]);//[PAGES]
	$TL++;
}while($dRS = mysql_fetch_assoc($RS));
echo '</ul>';
mysql_free_result($RS);
/********************************************************************************************************/
/********************************************************************************************************/
//Sitemap Articles Pages
$query_RS = "SELECT art_id, art_url, cat_id, dupdate, dcreate FROM tbl_articles WHERE status = 1 ORDER BY art_id DESC";
$RS = mysql_query($query_RS) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$totalRows_RS = mysql_num_rows($RS);
echo '<h2>Blog Articles Pages</h2>';
echo '<ul>';
do{
	//$detCatArt=fnc_dataartc($dRS['cat_id']);
	$baseurl=$RAIZ0.'a/'.$dRS['art_url'];
	$dateupd=$dRS['dupdate'];
	if ((!($dateupd))||($dateupd==NULL)||($dateupd=='0000-00-00')) $dateupd=$datenow;
	echo '<li>'.$dRS['art_id'].' <a href="'.$baseurl.'" target="_black">'.$baseurl.'</a> '.$dateupd.'</li>';
	$buffer.=returnchildxml($baseurl,$dateupd,$cf["w"],$pr[9]);//[PAGES]
	$TL++;
}while($dRS = mysql_fetch_assoc($RS));
echo '</ul>';
mysql_free_result($RS);
/********************************************************************************************************/
/********************************************************************************************************/
//Sitemap ITEMS BRANDS
$query_RS = "SELECT id, url, date FROM tbl_items_brands WHERE status=1 ORDER BY id DESC";
$RS = mysql_query($query_RS) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$totalRows_RS = mysql_num_rows($RS);
echo '<h2>Inventory ITEMS BRANDS</h2>';
echo '<ul>';
do{
	$LOGsm=NULL;
	$baseurl=$RAIZ0."brand/";
	$dateupdate=$dRS["date"];
	if(!($dateupdate)||($dateupdate==NULL)||($dateupdate=='0000-00-00')) $dateupdate=$datenow;
	if($dRS["url"]){
		$baseurl=$baseurl.$dRS["url"];
		$buffer.=returnchildxml($baseurl,$dateupdate,$cf["w"],$pr[5]);//CATS
		$TL++;
	}else $LOGsm='<span class="label label-important"> No Alias for URL </span> ';
	echo '<li>'.$LOGsm.$dRS["id"].' - <a href="'.$baseurl.'" target="_blank">'.$baseurl.'</a> '.$dateupdate.'</li>';

}while($dRS = mysql_fetch_assoc($RS));
echo '</ul>';
mysql_free_result($RS);
/********************************************************************************************************/
/********************************************************************************************************/
//Sitemap ITEMS Categories
$query_RS = "SELECT typID, typNom, typUrl, typDes, typDate FROM tbl_items_type WHERE typEst = 1 ORDER BY typIDp DESC";
$RS = mysql_query($query_RS) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$totalRows_RS = mysql_num_rows($RS);
echo '<h2>Inventory ITEMS CATEGORY</h2>';
echo '<ul>';
do{
	$LOGsm=NULL;
	$baseurl=$RAIZ0."c/";
	$dateupdate=$dRS["typDate"];
	if(!($dateupdate)||($dateupdate==NULL)||($dateupdate=='0000-00-00')) $dateupdate=$datenow;
		if($dRS["typID"]==1){
			$buffer.=returnchildxml($baseurl,$dateupdate,$cf["w"],$pr[9]);//CATS BASE
			$TL++;
		}else{
			if($dRS["typUrl"]){
				$baseurl=$baseurl.$dRS["typUrl"];
				$buffer.=returnchildxml($baseurl,$dateupdate,$cf["w"],$pr[5]);//CATS
				$TL++;
			}else $LOGsm='<span class="label label-danger"> No Alias for URL </span> ';
		}
		echo '<li>'.$LOGsm.$dRS["typID"].' - <a href="'.$baseurl.'" target="_blank">'.$baseurl.'</a> '.$dateupdate.'</li>';
}while($dRS = mysql_fetch_assoc($RS));
echo '</ul>';
mysql_free_result($RS);
/********************************************************************************************************/
/********************************************************************************************************/
//Sitemap Items
$query_RS = "SELECT item_id, item_aliasurl, item_lastupdate FROM tbl_items WHERE item_status = 1 ORDER BY item_id DESC";
$RS = mysql_query($query_RS) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$totalRows_RS = mysql_num_rows($RS);
echo '<h2>Inventory ITEMS</h2>';
echo '<ul>';
do{
	$LOGsm=NULL;
	$baseurl=$RAIZ0."p/";
	$dateupdate=$dRS["item_lastupdate"];
	if(!($dateupdate)||($dateupdate==NULL)||($dateupdate=='0000-00-00')) $dateupdate=$datenow;

	$detCP=detRow('tbl_items_type_vs','item_id',$dRS["item_id"]);
	$detC=detRow('tbl_items_type','typID',$detCP["typID"]);

		if($dRS["item_aliasurl"]){
			if(!$detC['typUrl']) $detC['typUrl']='NULL';
			$baseurl=$baseurl.$detC['typUrl'].'/'.$dRS["item_aliasurl"];
			$buffer.=returnchildxml($baseurl,$dateupdate,$cf["m"],$pr[8]);//ITEMS
			$TL++;
			echo '<li>'.$LOGsm.$dRS["item_id"].' - <a href="'.$baseurl.'" target="_blank">'.$baseurl.'</a> '.$dateupdate.'</li>';
		}else $LOGsm='<span class="label label-important"> No Alias for URL </span> ';

}while($dRS = mysql_fetch_assoc($RS));
echo '</ul>';
mysql_free_result($RS);
/********************************************************************************************************/
/********************************************************************************************************/
//Sitemap Other
echo '<h4>Other Principal Links</h4>';
echo '<ul>';
echo '<li>New Arrival</li>';
$buffer.=returnchildxml($RAIZ0."LatestReleases/",$datenow,$cf["m"],$pr[10]);//Contact Us
$TL++;
echo '<li>Contact Us</li>';
$buffer.=returnchildxml($RAIZ0."contact/",$datenow,$cf["m"],$pr[9]);//Contact Us
$TL++;
echo '<li>Support</li>';
$buffer.=returnchildxml($RAIZ0."support/",$datenow,$cf["m"],$pr[7]);//SITEMAP
$TL++;
echo '<li>Leasing</li>';
$buffer.=returnchildxml($RAIZ0."leasing/",$datenow,$cf["m"],$pr[7]);//SITEMAP
$TL++;
echo '</ul>';

$buffer.='</urlset>';

?>
<p class="lead">End Process!</p>
<?php
       $name_file="sitemap.xml";
	   $full_file=RAIZ0."sitemap.xml";
       $file=fopen($full_file,"w+");
       if (fwrite ($file,$buffer))
		   echo '<div class="alert alert-success"><a class="btn btn-primary btn-lg pull-left">Total Link Generados <strong>'.$TL.'</strong></a><h3>File Save Success !</h3>
		   <a href="'.$RAIZ0.$name_file.'" target="_blank" class="btn btn-primary btn-lg pull-right">View File</a></div>';
	   else echo '<div class="alert alert-error"><h4>Error!</h4>Do not save the File</div>';
       fclose($file);
?>
</div>
</body>
</html>