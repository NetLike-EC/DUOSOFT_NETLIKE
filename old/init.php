<?php if (!isset($_SESSION)) session_start();
$ses_id = session_id();
include ("system/base/configs.php");
include (RAIZ."Connections/conn.php");
include (RAIZs."base/fncts.php"); ?>