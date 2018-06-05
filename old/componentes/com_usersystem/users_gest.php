<?php include('../_config.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
  $_SESSION['MODSEL']="USER";
  $_SESSION['DIRSEL']="users_gest.php";
}
loginL("1");
?>
<?php include(RAIZ."/frames/_head.php"); ?>
<script type="text/javascript" src="<?php echo $RAIZ; ?>js/js_events.js"></script>
<script type="text/javascript">cont_panel('users_list.php', false)</script>
<?php $rowMod=detMod($_SESSION['MODSEL']); ?>
<body>
<?php include(RAIZ.'/frames/_fra_top.php'); ?>
<div id="generalcont">
    <div id="headcont"><?php include(RAIZ.'/frames/_fra_top_min.php'); ?></div>
    <div id="middlecont">
        <div id="head_sec"><a href="#"><?php echo strtoupper($rowMod['mod_des']); ?></a></div>
        <div id="middle_find"></div>
        <div id="middle_list"><div id="div_cont">-</div></div>
    </div>
    <div id="bottomcont"><?php include(RAIZ.'frames/_fra_bottom.php'); ?></div>
</div>
<?php include(RAIZ.'modulos/taskbar/_taskbar_usersystem.php'); ?>
</body>
</html>