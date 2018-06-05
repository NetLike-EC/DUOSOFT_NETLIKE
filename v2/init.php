<?php if (!isset($_SESSION)) session_start();
include ("system/paths.php");
include (RAIZs."config.php");
include (RAIZs."conn/conn.php");
include (RAIZs."fncts.php");
//$detUser=detRow('tbl_usuario','usr_id',$_SESSION['MM_UserID']);
//$detEmp=dataEmp($detUser['emp_cod']);
//$detEmp_fullname=$detEmp['emp_nom'].' '.$detEmp['emp_ape'];
?>