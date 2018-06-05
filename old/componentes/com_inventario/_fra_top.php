<?php 
if($ms=='miart'){$cssActPro='active';
	$iColor='blue';
	$btn1_class='btn big disabled';
	$btn1_tot=fnc_TotInvProd();
	$btn1_tit=$rowMod['mod_nom'];
	$btn1_ico='icon-columns';
	$btn1_link='#';
	$btn2_link='inv_form_prod.php';
}else if($ms=='mitip'){$cssActTip='active';
	$iColor='green';
	$btn1_class='btn big disabled';
	$btn1_tot=fnc_TotInvTip();
	$btn1_tit=$rowMod['mod_nom'];
	$btn1_ico='icon-th';
	$btn1_link='#';
	$btn2_link='inv_form_tip.php';
}else if($ms=='micat'){$cssActCat='active';
	$iColor='purple';
	$btn1_class='btn big disabled';
	$btn1_tot=fnc_TotInvCat();
	$btn1_tit=$rowMod['mod_nom'];
	$btn1_ico='icon-th-large';
	$btn1_link='#';
	$btn2_link='inv_form_cat.php';
}else if($ms=='mimar'){$cssActMar='active';
	$iColor='yellow';
	$btn1_class='btn big disabled';
	$btn1_tot=fnc_TotInvMar();
	$btn1_tit=$rowMod['mod_nom'];
	$btn1_ico='icon-tags';
	$btn1_link='#';
	$btn2_link='inv_form_mar.php';
}
?>
<div class="row-fluid">
    	<div class="span8">
       <h3 class="page-title"><?php echo $rowMod['mod_nom'] ?> <small><?php echo $rowMod['mod_des'] ?></small></h3>
        </div>
        <div class="span4 text-right">        
			<a class="<?php echo $btn1_class.' '.$iColor ?>" href="<?php echo $btn1_link ?>"><strong><?php echo $btn1_tot ?></strong> <?php echo $btn1_tit ?> <i class="<?php echo $btn1_ico ?>"></i></a>
            <a class="btn big <?php echo $iColor ?>" href="<?php echo $btn2_link ?>"><strong><?php echo $btn2_tot ?></strong> <i class="icon-plus"></i> Nuevo</a>
        </div>
    </div>
<div class="tabbable tabbable-custom boxless">
<ul class="nav nav-tabs">
    <li><a href="index.php">Panel General</a></li>
	<li class="<?php echo $cssActPro?>">
    <a href="inv_gest_prod.php"><i class="icon-columns"></i> Productos</a></li>
	<li class="<?php echo $cssActTip?>">
    <a href="inv_gest_tip.php"><i class="icon-th"></i> Tipos</a></li>
	<li class="<?php echo $cssActCat?>">
    <a href="inv_gest_cat.php"><i class="icon-th-large"></i> Categorias</a></li>
	<li class="<?php echo $cssActMar?>">
    <a href="inv_gest_mar.php"><i class="icon-tags"></i> Marcas</a></li>
</ul>