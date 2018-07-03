<?php
function myfunction($value,$key){
	return trim($key,' ');
}
$a=array("ama ","blu ","red ");
$val=array_walk($a,"myfunction",'$val');
var_dump($val);
?>