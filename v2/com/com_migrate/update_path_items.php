<?php require_once('../../init.php');
fnc_accessnorm();
$query_RS_items_list = "SELECT * FROM tbl_items";
$RS_items_list = mysql_query($query_RS_items_list) or die(mysql_error());
$row_RS_items_list = mysql_fetch_assoc($RS_items_list);
$totalRows_RS_items_list = mysql_num_rows($RS_items_list);
include(RAIZf.'_head.php');
?>
<body class="cero">
<div class="page-header">
	<h1><a class="btn"><i class="icon-refresh"></i></a> UPDATE Items Path</h1>
</div>
<table>
	<?php do { ?>
	<tr><td>
		<?php echo catsitempath_upd($row_RS_items_list['cat_id'], $row_RS_items_list['item_id']); ?>
	</td></tr>
	<?php } while ($row_RS_items_list = mysql_fetch_assoc($RS_items_list)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($RS_items_list);
?>