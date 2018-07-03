<?php include('../../init.php');
fnc_accessnorm();
$query_RScats = "SELECT * FROM tbl_items_cats ORDER BY cat_id DESC";
$RScats = mysql_query($query_RScats) or die(mysql_error());
$row_RScats = mysql_fetch_assoc($RScats);
$totalRows_RScats = mysql_num_rows($RScats);
include(RAIZf.'_head.php');
?>
<body class="cero">
<div class="container">
<div class="page-header">
	<h1><a class="btn" onClick="location.reload()"><i class="icon-refresh"></i></a> Generate ALIAS Url (Category)</h1>
</div>
<table class="table" id="itm_table">
	<thead><tr>
    	<th>ID</th>
        <th>Name</th>
        <th>Actual</th>
        <th>Generate</th>
    </tr>
    </thead>
    <tbody>
	<?php
	do {
	?>
	<tr>
    	<td><?php echo $row_RScats['cat_id']; ?></td>
        <td><abbr title="<?php echo $row_RScats['cat_nom']; ?>"><i class="icon-question-sign"></i></abbr></td>
        <td>
		<?php
        if($row_RScats['cat_aliasurl']) echo $row_RScats['cat_aliasurl'];
        else echo '<span class="label label-important">Pending Generate</span>'; ?>
		</td>
    	<td>
		<?php
        if(!($row_RScats['cat_aliasurl'])){
			$tryes=3;
			for($x=1;$x<=$tryes;$x++){
				$genalias=generate_aliasurl($row_RScats['cat_nom']);
				if($x>0){
					$alias_lastc=substr($genalias, -1);
					if (is_numeric($alias_lastc)){
						$alias_lastc++;
						$genalias=substr_replace($genalias, $alias_lastc,-1); 
					}else $genalias.='1'; 
				}
				if($stat_alias_upd=='TRUE') break;
			}
			$stat_alias_upd=aliasurl_upd_cat($row_RScats['cat_id'],$genalias);
			if($stat_alias_upd=='TRUE'){
				echo '<span class="label label-success">OK <i class="icon-ok-sign"></i></span> '.$genalias;
			}else echo '<abbr title="'.$stat_alias_upd.'"><span class="label label-important"><i class="icon-remove-sign icon-white"></i> No Update, Try Again !</span></abbr> '.$genalias;
		}
		?>
	</td></tr>
	<?php } while ($row_RScats = mysql_fetch_assoc($RScats)); ?>
    </tbody>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($RScats);
?>