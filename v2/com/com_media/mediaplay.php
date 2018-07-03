<?php require_once('../../init.php');
$id=fnc_verifiparam('id',$_GET['id'],$_POST['id']);
$detvid=fnc_media($id);
include(RAIZf.'_head.php');
?>
<body class="cero">
<div class="container">
<div class="navbar">
  <div class="navbar-inner">
    <a class="brand" href="#">Media Player</a>
    <ul class="nav">
      <li class="active"><a href="#">ID: <strong><?php echo $detvid['med_id'] ?></strong></a></li>
      <li><a href="#">title: <strong><?php echo $detvid['med_title'] ?></a></li>
    </ul>
  </div>
</div>
<div class="well"><?php echo $detvid['med_code'];?></div>
<div class="well"><pre><?php echo htmlspecialchars($detvid['med_code']);?></pre></div>
</div>
</body>
</html>