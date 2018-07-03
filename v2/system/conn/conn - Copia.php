<?php
if(!$conn){
	$host_conn = "localhost";
	$db_conn_merco = "merco_web";
	$db_conn_wa = "merco_webwa";
	$user_conn = "merco_web0";
	$pass_conn = "N-A1oQd%y!TqnfK&)=";
	$conn = mysql_connect($host_conn, $user_conn, $pass_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db($db_conn_merco, $conn);
	mysql_query("SET NAMES 'utf8'");
}
?>