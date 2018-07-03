<?php require_once('init.php');
$logoutGoTo = $RAIZ."index.php";
$LOG='<h4>Username / Password is Wrong</h4>Try Again';
$_SESSION['LOG']=$LOG;
$_SESSION['LOGr']='error';
header(sprintf('Location: %s',$logoutGoTo));
?>