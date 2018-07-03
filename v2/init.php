<?php if (!isset($_SESSION)) session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

define( '_JEXEC', 1 );
include ("system/paths.php");
include (RAIZs."config.php");
include (RAIZs."fncts.php");
include (RAIZs."conn/conn.php");