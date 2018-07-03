<?php
defined('_JEXEC') or die('Restricted access');//comprueba si la constante esta definida
$hostname_conn = "p:localhost";
$database_conn = "duosoft_netlike";
$username_conn = "root";
$password_conn = "root2018NL";
//var_dump($conn);
//echo '<hr>';
if(!$conn){
	$conn = mysqli_connect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysqli_select_db($conn,$database_conn);
	mysqli_query($conn,"SET NAMES 'utf8'");
	//cLOG('Successfully connection');
}//else cLOG('Existent Connection');
//var_dump($conn);
//echo '<hr>';
?>