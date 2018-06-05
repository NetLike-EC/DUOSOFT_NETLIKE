<div class="container-fluid">
	<h3 class="page-title"><?php echo $rowMod['mod_des']; ?></h3>
	<div id="dashboard">
		<!-- BEGIN DASHBOARD STATS -->
		<div class="row-fluid">
			<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
				<div class="dashboard-stat blue">
					<div class="visual"><i class="icon-columns"></i></div>
					<div class="details">
						<div class="number"><?php echo fnc_TotInvProd(); ?></div>
						<div class="desc">Productos</div>
					</div>
					<a class="more" href="inv_gest_prod.php">Ver mas <i class="m-icon-swapright m-icon-white"></i></a>
				</div>
			</div>
			<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
				<div class="dashboard-stat green">
					<div class="visual"><i class="icon-th"></i></div>
					<div class="details">
						<div class="number"><?php echo fnc_TotInvTip(); ?></div>
						<div class="desc">Tipos</div>
					</div>
					<a class="more" href="inv_gest_tip.php">Ver mas <i class="m-icon-swapright m-icon-white"></i></a>						
				</div>
			</div>
			<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
				<div class="dashboard-stat purple">
					<div class="visual"><i class="icon-th-large"></i></div>
					<div class="details">
						<div class="number"><?php echo fnc_TotInvCat(); ?></div>
						<div class="desc">Categorias</div>
					</div>
					<a class="more" href="inv_gest_cat.php">Ver mas <i class="m-icon-swapright m-icon-white"></i></a>						
				</div>
			</div>
			<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
				<div class="dashboard-stat yellow">
					<div class="visual"><i class="icon-tags"></i></div>
					<div class="details">
						<div class="number"><?php echo fnc_TotInvMar(); ?></div>
						<div class="desc">Marcas</div>
					</div>
					<a class="more" href="inv_gest_mar.php">Ver mas <i class="m-icon-swapright m-icon-white"></i></a>						
				</div>
			</div>
		</div>
		<!-- END DASHBOARD STATS -->
    </div>
</div>