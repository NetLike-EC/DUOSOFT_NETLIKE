<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav_taskb">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?php echo $dM[nom] ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="nav_taskb">
      <a href="<?php echo $RAIZc ?>com_clientes/form.php" class="btn btn-primary navbar-btn"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</a>
      
      <a href="<?php echo $RAIZc ?>com_clientes/" class="btn btn-primary navbar-btn navbar-right">Total Clientes <span class="badge"><?php echo $TR?></span></a>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>