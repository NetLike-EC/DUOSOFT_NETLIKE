<ul id="MenuBar1" class="MenuBarHorizontal">
	<li><a href="<?php echo RAIZb; ?>componentes/com_index/index.php">Home</a></li>
	<li><a href="<?php echo RAIZb; ?>componentes/com_inventario/items_gest.php" class="MenuBarItemSubmenu">Items</a>
	  <ul>
        <li><a href="<?php echo RAIZb; ?>componentes/com_inventario/items_prod_gest.php">Products</a></li>
        <li><a href="<?php echo RAIZb; ?>componentes/com_inventario/items_cat_gest.php">Categories</a></li>
	  </ul>
	</li><li><a href="<?php echo RAIZb; ?>logout.php">Logout</a></li>
    <div style="clear:both;"></div>
</ul>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"<?php echo $RAIZ; ?>SpryAssets/SpryMenuBarDownHover.gif", imgRight:"<?php echo $RAIZ; ?>SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>