<?php require_once('../../init.php');
$id=fnc_verifiparam('id',$_GET['id'],$_POST['id']);
$detvid=fnc_vid($id);
include(RAIZf.'_head.php');
?>
<body class="cero">
<div class="container">
<div class="navbar">
  <div class="navbar-inner">
    <a class="navbar-brand" href="#">Video Player</a>
    <ul class="nav">
      <li class="active"><a href="#">ID: <strong><?php echo $detvid['vid_id'] ?></strong></a></li>
      <li><a href="#">title: <strong><?php echo $detvid['vid_title'] ?></a></li>
    </ul>
  </div>
</div>
<div class="well"><?php echo $detvid['vid_code'];?></div>
<div class="well"><pre><?php echo htmlspecialchars($detvid['vid_code']);?></pre></div>
</div>
<script type="text/javascript" src="http://cdn.sublimevideo.net/js/msmhzft7.js"></script>
</body>
</html>