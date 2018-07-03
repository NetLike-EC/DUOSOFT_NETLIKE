<?php $ms=$_GET['ms']; $claseact=' class="active"' ?>
<div class="navbar navbar-static-top">
	<div class="navbar-inner">
    <div class="container">
		<a class="brand" href="#"><?php echo strtoupper($rowMod['mod_nom']); ?> <small><strong class="muted">(INVENTARIOS)</strong></small></a>
        <a class="brand pull-right" href="#"></a>
        <ul class="nav">
			<li class="divider-vertical"></li>
			<li<?php if($ms=='3') echo $claseact ?>><a href="items_prod_gest.php?ms=3"><div>Articulos</div></a></li>
			<li class="divider-vertical"></li>
			<li<?php if($ms=='2') echo $claseact ?>><a href="items_tip_gest.php?ms=2"><div>Tipos</div></a></li>
			<li class="divider-vertical"></li>
			<li<?php if($ms=='1') echo $claseact ?>><a href="items_cat_gest.php?ms=1"><div>Categorias</div></a></li>
			<li class="divider-vertical"></li>
			<li<?php if($ms=='4') echo $claseact ?>><a href="items_mar_gest.php?ms=4"><div>Marcas</div></a></li>
			<li class="divider-vertical"></li>
		</ul>
        </div>
	</div>
</div>