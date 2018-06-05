<?php include('../../init.php');
$_SESSION['MODSEL']="INV";
$_SESSION['DIRSEL']="items_gest.php";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
include(RAIZf."head.php");
include(RAIZf.'fraTop.php'); ?>
<div class="container">
	<div class="page-header"><h1><?php echo strtoupper($rowMod['mod_des']); ?></h1></div>
	<div class="row-fluid">
		<ul class="thumbnails">
		<li class="span4">
			<div class="thumbnail">
            <a href="items_prod_gest.php"><img src="images/11_128x128.png" alt="" width="128" height="128" /></a>
			<div class="caption"><a href="items_prod_gest.php" class="btn btn-large btn-block btn-primary">Productos</a></div>
			</div>
		</li>
		<li class="span4">
			<div class="thumbnail">
            <a href="items_tip_gest.php"><img src="images/31_128x128.png" alt="" width="128" height="128" /></a>
			<div class="caption"><a href="items_tip_gest.php" class="btn btn-large btn-block btn-primary">Tipos</a></div>
			</div>
		</li>
		<li class="span4">
			<div class="thumbnail">
            <a href="items_cat_gest.php"><img src="images/12_128x128.png" alt="" width="128" height="128" /></a>
			<div class="caption"><a href="items_cat_gest.php" class="btn btn-large btn-block btn-primary">Categorias</a></div>
			</div>
		</li>
		</ul>
	</div>
    <div><?php include(RAIZf.'fraBot.php'); ?></div>
</div>
<?php include(RAIZm.'taskbar/_taskbar_items.php'); ?>
</body>
</html>