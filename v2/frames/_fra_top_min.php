<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo $RAIZc?>com_index/">CMS MERCOFRAMES</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="label label-danger">MF</span> Mercoframes Web<b class="caret"></b></a>
		<ul class="dropdown-menu">
            <li><a href="<?php echo $RAIZc?>com_inventario/invItem.php"><i class="fa fa-cube"></i> Products</a></li>
			<li><a href="<?php echo $RAIZc?>com_inventario/invCat.php"><i class="fa fa-cubes"></i> Categories</a></li>
            <li><a href="<?php echo $RAIZc?>com_inventario/invBrand.php"><i class="fa fa-tag"></i> Brands</a></li>
            <li><a href="<?php echo $RAIZc?>com_multimedia/"><span class="glyphicon glyphicon-asterisk"></span> Multimedia</a></li>
        	<li class="divider"></li>
        	<li><a href="<?php echo $RAIZc?>com_articles/"><span class="fa fa-files-o"></span> Content</a></li>
        	<li class="divider"></li>	
        	<li><a href="<?php echo $RAIZc?>com_mail/"><span class="fa fa-envelope-o"></span> Contact Center</a></li>
		</ul>
		</li>
        <li class="divider-vertical"></li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="label label-success">WA</span> Tienda Welch Allyn <b class="caret"></b></a>
		<ul class="dropdown-menu">
            <li><a href="<?php echo $RAIZc?>com_storewa/items_prod_gest.php?ms=1"><span class="glyphicon glyphicon-list"></span> Productos</a></li>
			<li><a href="<?php echo $RAIZc?>com_storewa/items_cat_gest.php?ms=3"><span class="glyphicon glyphicon-th-large"></span> Categorias</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $RAIZc?>com_articleswa/pages.php"><span class="glyphicon glyphicon-file"></span> Pages</a></li>
			<li><a href="<?php echo $RAIZc?>com_articleswa/categories.php"><span class="glyphicon glyphicon-th-large"></span> Categories</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $RAIZc?>com_mailwa/index_mess.php"><span class="glyphicon glyphicon-th-list"></span> Messages</a></li>
            <li><a href="<?php echo $RAIZc?>com_mailwa/all_data.php"><span class="glyphicon glyphicon-th"></span> All Data</a></li>
            <li><a href="<?php echo $RAIZc?>com_mailwa/"><span class="glyphicon glyphicon-envelope"></span> Mail List</a></li>
		</ul>
		</li>
    </ul>    
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="<?php echo $RAIZc?>com_modulos/">
            <span class="label label-info">SYS</span> Modulos</a></li>
            <li><a href="<?php echo $RAIZc?>com_types/">
            <span class="label label-info">SYS</span> Types</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $RAIZc?>com_mantdb/update_path_items.php" rel="shadowbox">
            <span class="label label-danger">MF</span> Update Path Items Cats</a></li>
			<li><a href="<?php echo $RAIZc?>com_mantdb/sitemap_generator.php" rel="shadowbox">
            <span class="label label-danger">MF</span> Sitemap XML Generator</a></li>
			<li><a href="<?php echo $RAIZc?>com_mantdb/verify_aliasurl.php" rel="shadowbox">
            <span class="label label-danger">MF</span> Generate Alias URL (Items)</a></li>
			<li><a href="<?php echo $RAIZc?>com_mantdb/verify_aliasurl_cat.php" rel="shadowbox">
            <span class="label label-danger">MF</span> Generate Alias URL (Category)</a></li>
            <li class="divider"></li>
			<li><a href="<?php echo $RAIZc?>com_mantdb/verify_aliasurlWA.php" rel="shadowbox">
            <span class="label label-success">WA</span> Generate Alias URL (Items WA)</a></li>
			<li><a href="<?php echo $RAIZc?>com_mantdb/verify_aliasurl_catWA.php" rel="shadowbox">
            <span class="label label-success">WA</span> Generate Alias URL (Category WA)</a></li>
		</ul>
		</li>
      <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Usuario <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="#">Cambiar Contraseña</a></li>
			<li class="divider"></li>
			<li><a href="<?php echo $RAIZ; ?>logout.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
		</ul>
		</li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>