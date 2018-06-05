<div class="header navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="brand" href="<?php echo $RAIZc ?>com_index/index.php">BAZAR SONRISAS</a>
			<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse"><img src="<?php echo $RAIZa ?>img/menu-toggler.png" alt="" /></a>
				<!-- BEGIN TOP NAVIGATION MENU -->					
				<ul class="nav pull-right">
					<li class="dropdown user">
						<?php
                        $detUser=fnc_dataUser($_SESSION['MM_Username']);
						$detEmp=detEmpPer($detUser['emp_cod']);
						$detPer_name=$detEmp['per_nom'].' '.$detEmp['per_ape'];
						$detPer_img=fnc_image_exist('db/emp/',$detPer['per_img'],TRUE);
						?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="<?php echo $detPer_name ?>" src="<?php echo $detPer_img['norm'] ?>" style="max-width:29px; max-height:29px"/>
						<span class="username"><?php echo $detPer_name; ?></span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="icon-user"></i> Mi perfil</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $RAIZ ?>logout.php"><i class="icon-key"></i> Salir</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->	
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>