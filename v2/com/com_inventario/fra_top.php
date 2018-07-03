<div class="navbar navbar-default navbar-static-top cero">
	<div class="navbar-header">
		<a class="navbar-brand" href="#"><?php echo $dM[nom] ?></a>
	</div>     
	<ul class="nav navbar-nav">
		<li class="<?php if($ms=='1') echo 'active' ?>"><a href="invItem.php"><i class="fa fa-cube"></i> <?php echo $cfg[com_inv][top_item] ?></a></li>
		<li class="<?php if($ms=='2') echo 'active' ?>"><a href="invCat.php"><i class="fa fa-cubes"></i> <?php echo $cfg[com_inv][top_cat] ?></a></li>
		<li class="<?php if($ms=='3') echo 'active' ?>"><a href="invBrand.php"><i class="fa fa-tag"></i> <?php echo $cfg[com_inv][top_brand] ?></a></li>
	</ul>
</div>