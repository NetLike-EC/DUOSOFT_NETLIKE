<?php require_once('init.php');
$logoutGoTo = $RAIZ.'index.php';
$LOG='<h4>Insufficient permissions</h4>Try again';
$_SESSION['LOG']=$LOG;
$_SESSION['LOGr']='error';
header(sprintf('Location: %s',$logoutGoTo));
?>
