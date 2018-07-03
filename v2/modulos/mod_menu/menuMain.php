<?php $id_user = $_SESSION['dU']['usr_id']; ?>
<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="container-fluid">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainMenu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $RAIZc ?>com_index/"><?php echo $cfg[wTit] ?></a>
    </div>
    <div class="collapse navbar-collapse" id="mainMenu">
		<?php echo genMenu('MAINMENU','nav navbar-nav',TRUE) ?>
		<ul class="nav navbar-nav navbar-right">
			<li><a><div id="logF"></div></a></li>
			<li><a href="#"><div id="loading"><img src="<?php echo $RAIZa ?>images/struct/loader.gif"/></div></a></li>
			<?php echo genMenu('CONFIGUSER',NULL,FALSE) ?>
			<?php echo genMenu('MUSER',NULL,FALSE) ?>
		</ul>
	</div>
</div>
</nav>