<?php
include('../../_confs.php');
require_once(RAIZ.'Connections/conn_merco.php');
$varbeg=0;
$query_RS_cat0 = "SELECT * FROM tbl_items_cats ORDER BY cat_id_parent ASC";
$RS_cat0 = mysql_query($query_RS_cat0) or die(mysql_error());
$row_RS_cat0 = mysql_fetch_assoc($RS_cat0);
$totalRows_RS_cat0 = mysql_num_rows($RS_cat0);
echo $_SERVER['PHP_SELF'];
$list; ?>
<div>
<?php do { ?>
  <div>
  <?php 
  		if(!($list[$row_RS_cat0['cat_id']])){
  			echo $row_RS_cat0['cat_id']; 
        }
	?>
    </div>
  <?php $list[$row_RS_cat0['cat_id']]=$row_RS_cat0['cat_id']; ?>
  <div>
  <?php
	$varsel=$row_RS_cat0['cat_id'];
	$contlev="-";
	do{
	
	$query_RS_0 = "SELECT * FROM tbl_items_cats where cat_id_parent=".$varsel;
	$RS_0 = mysql_query($query_RS_0) or die(mysql_error());
	$row_RS_0 = mysql_fetch_assoc($RS_0);
	$totalRows_RS_0 = mysql_num_rows($RS_0);
	$varsel=$row_RS_0['cat_id'];
	if($totalRows_RS_0>0){
		do{
			if(!($list[$row_RS_0['cat_id']])){
				echo "<div>".$contlev.$row_RS_0['cat_id']."</div>"; 
			}
			$list[$row_RS_0['cat_id']]=$row_RS_0['cat_id'];
		} while ($row_RS_0 = mysql_fetch_assoc($RS_0));
	}
	
	}while($totalRows_RS_0>0);
  ?>
  </div>
  <?php } while ($row_RS_cat0 = mysql_fetch_assoc($RS_cat0)); ?>
</div>
..
<?php
mysql_free_result($RS_cat0);
?>

<!-- Ejemplo4.php --> 
<html> 
<head> 
   <title>Ejemplo de PHP</title> 
</head> 
<body> 
<?php 
   $a = 8; 
   $b = 3; 
   echo $a + $b,"<br>"; 
   echo $a - $b,"<br>"; 
   echo $a * $b,"<br>"; 
   echo $a / $b,"<br>"; 
   $a++; 
   echo $a,"<br>"; 
   $b--; 
   echo $b,"<br>"; 
?> 
</body> 
</html>

<!-- Ejemplo5.php --> 
<html> 
<head> 
   <title>Ejemplo de PHP</title> 
</head> 
<body> 
<?php 
   $a = 8; 
   $b = 3; 
   $c = 3; 
   echo $a == $b,"<br>"; 
   echo $a != $b,"<br>"; 
   echo $a < $b,"<br>"; 
   echo $a > $b,"<br>"; 
   echo $a >= $c,"<br>"; 
   echo $b <= $c,"<br>"; 
?> 
</body> 
</html>