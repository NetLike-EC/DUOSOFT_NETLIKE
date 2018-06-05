<?php
# Type="MYSQL"
# HTTP="true"
$hostname_conn = "localhost";
$database_conn = "duosoft_netlike";
$username_conn = "root";
$password_conn = "rootroot";
//$password_conn = "root";
$conn_freimo = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_conn);
mysql_query("SET NAMES 'utf8'");
?>