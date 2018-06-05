<?php include('../../init.php');
echo "<PRE>";
print_r($_SESSION[$ses_id]['compra']);
echo "</PRE>";
$anterior = $_SESSION[$ses_id]['compra'];
foreach ($anterior as $keyAgregar => $v) $lastid=$keyAgregar;
echo $contITM=$lastid+1;

?>