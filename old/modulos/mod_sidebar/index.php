<?php
if (($mSel=='')||($mSel=='0')) $mSel=NULL;
function fnc_verifyMenuAct($idParent,$mAct,$mSel=NULL){
	$banAct;
	if ($mAct==$mSel) $banAct='active';
	$query_RS_datos = sprintf("SELECT * FROM tbl_menus_items WHERE itemmenu_parent=%s AND itemmenu_stat=1",
	GetSQLValueString($idParent,'int'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	if ($totalRows_RS_datos>0){
	do{
		if($row_RS_datos['itemmenu_nom']==$mSel) $banAct='active';
	} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	}
	mysql_free_result($RS_datos);
	return $banAct;
}
?>
<div class="page-sidebar nav-collapse collapse">
	<ul>
		<li>
			<div class="sidebar-toggler hidden-phone"></div>
		</li>
		<li></li>
<?php //Bucle para elementos padre
	$query_RS_datos1 = sprintf("SELECT * FROM tbl_menus_items WHERE menu_id=%s AND itemmenu_parent=%s AND itemmenu_stat=1 ORDER BY itemmenu_order ASC",
		GetSQLValueString('1','int'),
		GetSQLValueString('0','int'));
	$RS_datos1 = mysql_query($query_RS_datos1) or die(mysql_error());
	$row_RS_datos1 = mysql_fetch_assoc($RS_datos1);
	$totalRows_RS_datos1 = mysql_num_rows($RS_datos1);
	do {//DO-WHILE MENUS PADRES	
		$query_RS_datos2 = sprintf("SELECT * FROM tbl_menus_items WHERE itemmenu_parent=%s AND itemmenu_stat=1 ORDER BY itemmenu_order ASC",
		GetSQLValueString($row_RS_datos1['itemmenu_id'],'int'));
		$RS_datos2 = mysql_query($query_RS_datos2) or die(mysql_error());
		$row_RS_datos2 = mysql_fetch_assoc($RS_datos2);
		$totalRows_RS_datos2 = mysql_num_rows($RS_datos2);
		$classAct=fnc_verifyMenuAct($row_RS_datos1['itemmenu_id'],$row_RS_datos1['itemmenu_nom'],$mSel);
        if($row_RS_datos1['itemmenu_link']) $menulink=$RAIZc.$row_RS_datos1['itemmenu_link'];
		else $menulink="javascript:;";

		$arrow;
		if($totalRows_RS_datos2>0){
			$arrow='<span class="arrow"></span>';
			$limenuclass="has-sub";
		} 
		if($classAct=='active'){
			$span_act='<span class="selected"></span>';
			$arrow='<span class="arrow open"></span>';
		}
		
	?>
		<li class="<?php echo $limenuclass.' '.$classAct ?>">
        <a href="<?php echo $menulink ?>">
			<i class="<?php echo $row_RS_datos1["itemmenu_icon"] ?>"></i>
			<span class="title"><?php echo $row_RS_datos1["itemmenu_tit"] ?></span>
            <?php echo $span_act;
			echo $arrow ?>
        </a>
       	<?php echo $amenu;
		
	if ($totalRows_RS_datos2>0){ ?>
    <ul class="sub">
		<?php do {
		$classAct2="";
		if($mSel==$row_RS_datos2["itemmenu_nom"]) $classAct2='active';
		
		if($row_RS_datos2['itemmenu_link']){
    	$amenuSub='<a href="'.$RAIZc.$row_RS_datos2['itemmenu_link'].'">'.$row_RS_datos2['itemmenu_tit'].'</a>';
    	}else{
    	$amenuSub='<a href="javascript:;">'.$row_RS_datos2['itemmenu_tit'].'</a>';
		}
		?>
    	<li class="<?php echo $classAct2 ?>">
			<?php echo $amenuSub ?>
    	</li>
    	<?php } while ($row_RS_datos2 = mysql_fetch_assoc($RS_datos2)); mysql_free_result($RS_datos2)?>
	</ul>
    </li>
	<?php }
	} while ($row_RS_datos1 = mysql_fetch_assoc($RS_datos1)); mysql_free_result($RS_datos1)?>
	</ul>
</div>