<div>
	<div id="menucontainer" style="display:table; margin-left:auto; margin-right:auto;">    
    <!-- menu system -->
    <ul id="MenuBar1" class="MenuBarHorizontal">
	<?php //Bucle para elementos padre
    $query_RS_datos1 = "SELECT * FROM tbl_menus_items WHERE menu_id=1 AND itemmenu_parent=0";
	$RS_datos1 = mysql_query($query_RS_datos1) or die(mysql_error());
	$row_RS_datos1 = mysql_fetch_assoc($RS_datos1);
	$totalRows_RS_datos1 = mysql_num_rows($RS_datos1);
	do {
		$query_RS_datos2 = "SELECT * FROM tbl_menus_items WHERE itemmenu_parent='".$row_RS_datos1['itemmenu_id']."'";
		$RS_datos2 = mysql_query($query_RS_datos2) or die(mysql_error());
		$row_RS_datos2 = mysql_fetch_assoc($RS_datos2);
		$totalRows_RS_datos2 = mysql_num_rows($RS_datos2);
		if($totalRows_RS_datos2>0) $classmenu="MenuBarItemSubmenu"; else $classmenu="-"; 
	?>
		<li>
       	<?php if($row_RS_datos1['itemmenu_link']){?>
        <a class="<?php $classmenu?>" href="<?php echo $RAIZ.$row_RS_datos1['itemmenu_link']; ?>"><?php echo $row_RS_datos1['itemmenu_nom']; ?></a>
        <?php }else{ ?>
        <a class="<?php $classmenu?>" href="#"><?php echo $row_RS_datos1['itemmenu_nom']; ?></a>
        <?php } ?>
	<?php
	if ($totalRows_RS_datos2>0){ ?>
    <ul>
	<?php do {?>
    <li>
	<?php if($row_RS_datos2['itemmenu_link']){?>
    <a href="<?php echo $RAIZ.$row_RS_datos2['itemmenu_link']; ?>"><?php echo $row_RS_datos2['itemmenu_nom'] ?></a>
    <?php }else{ ?>
    <a href="#"><?php echo $row_RS_datos2['itemmenu_nom'] ?></a>
    <?php } ?>
    </li>
    <?php } while ($row_RS_datos2 = mysql_fetch_assoc($RS_datos2)); mysql_free_result($RS_datos2)?></ul></li>
	<?php } } while ($row_RS_datos1 = mysql_fetch_assoc($RS_datos1)); mysql_free_result($RS_datos1)?>
    	<li><a href="<?php echo $RAIZ; ?>logout.php">Salir</a></li>
	</ul>
    </div>
</div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"<?php echo $RAIZ; ?>SpryAssets/SpryMenuBarDownHover.gif", imgRight:"<?php echo $RAIZ; ?>SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>