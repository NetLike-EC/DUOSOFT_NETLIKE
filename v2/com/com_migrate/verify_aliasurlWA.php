<?php include('../../init.php');
fnc_accessnorm();
mysql_select_db($db_conn_wa, $conn);
$query_RSitems = "SELECT * FROM tbl_wa_items ORDER BY item_id DESC";
$RSitems = mysql_query($query_RSitems) or die(mysql_error());
$row_RSitems = mysql_fetch_assoc($RSitems);
$totalRows_RSitems = mysql_num_rows($RSitems);
include(RAIZf.'_head.php');
?>
<body class="cero">
<div class="container">
<div class="page-header">
	<h1><a class="btn" onClick="location.reload()"><i class="icon-refresh"></i></a> Generate ALIAS Url WA</h1>
</div>
<table class="table" id="itm_table">
	<thead><tr>
    	<th>ID</th>
        <th>Code</th>
        <th>Actual</th>
        <th>Generate</th>
    </tr>
    </thead>
    <tbody>
	<?php do { ?>
	<tr>
    	<td><?php echo $row_RSitems['item_id']; ?></td>
        <td><abbr title="<?php echo $row_RSitems['item_nom']; ?>"><i class="icon-question-sign"></i></abbr></td>
        <td>
		<?php
        if($row_RSitems['item_aliasurl']) echo $row_RSitems['item_aliasurl'];
        else echo '<span class="label label-important">Pending Generate</span>'; ?>
		</td>
    	<td>
		<?php
        if(!($row_RSitems['item_aliasurl'])){
			$genalias=generate_aliasurl($row_RSitems['item_nom']);
			$genalias=$row_RSitems['item_id'].'-'.$genalias;
			$stat_alias_upd=aliasurl_upd_itemWA($row_RSitems['item_id'],$genalias);
			if($stat_alias_upd=='TRUE'){
				echo '<span class="label label-success">OK <i class="icon-ok-sign"></i></span> '.$genalias;
			}else echo '<abbr title="'.$stat_alias_upd.'"><span class="label label-important"><i class="icon-remove-sign icon-white"></i> No Update</span></abbr> '.$genalias;
		}
		?>
	</td></tr>
	<?php } while ($row_RSitems = mysql_fetch_assoc($RSitems)); ?>
    </tbody>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($RSitems);
?>