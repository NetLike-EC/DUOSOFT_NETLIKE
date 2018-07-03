<?php include('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('MGAL');
//Verifica si existen los parametros
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$dG = detRow('tbl_gallery','gall_id',$id);
if ($dG){
	$acc='UPD';
	$gall_id=$dG['gall_id'];
	$gall_item=$dG['itemview'];
	$gall_tit=$dG['gall_tit'];
	$file_span=$dG['gall_span'];
	$file_stat=$dG['gall_stat'];
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc"><i class="fa fa-floppy-o"></i> UPDATE</button>';
}else {
	$acc="INS";
	$gall_id="000";
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc"><i class="fa fa-floppy-o"></i> INSERT</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default">ADD NEW</a>';
$cssBody='cero';
include(RAIZf.'_head.php'); ?>
<form action="_fncts.php" method="post" enctype="multipart/form-data" id="gallitem" class="form-horizontal">
	<fieldset>
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
		<input name="form" type="hidden" id="form" value="form_gall">
		<input name="id" type="hidden" id="id" value="<?php echo $id ?>" />
		<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
	</fieldset>
<div class="container-fluid">
<?php sLOG('g'); ?>    
	<div class="page-header">
    <div class="btn-group pull-right">
		<?php echo $btnAcc?>
		<?php echo $btnNew?>
	</div>
    <span class="label label-default pull-left"><?php echo $rowMod['mod_nom'] ?></span>
    <h1><span class="label label-info"><?php echo $gall_id ?></span> 
	<?php echo $gall_tit ?></h1></div>
	<div class="row">
		<div class="col-md-6">
		<fieldset class="well well-sm">
            <div class="form-group">
                <label class="control-label col-sm-4" for="title">Title</label>
                <div class="col-sm-8">
                <input name="title" type="text" id="title" placeholder="Title for this file" class="form-control input-block-level" value="<?php echo $gall_tit ?>"></div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="chosTypI">Multiple Items View</label>
                <div class="col-sm-8">
				<?php //detRowGSel
				/*$query_RS_datos = sprintf('SELECT item_id AS sID, item_cod as sVAL FROM tbl_items WHERE item_status=%s %s',
				SSQL($fieldID,''),
				SSQL($fieldVal,''),
				SSQL($table,''),
				SSQL($field,''),
				SSQL($param,'text'),
				SSQL($other,''));
				$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
				*/
				echo generarselect("valSelI[]",detRowGSel('tbl_items','item_id','item_cod','item_status','1'),
				detRowSel('tbl_gallery_ref','idr','idg',$id,' AND ref="ITEM"'),'form-control', 'multiple', 'chosI','Select One or Multiple',FALSE);
				//mysql_free_result($RS_datos); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="chosTyp">Multiple Articles View</label>
                <div class="col-sm-8">
                <?php echo generarselect("valSelA[]",detRowGSel('tbl_articles','art_id','title','status','1','ORDER BY sVAL ASC'),
				detRowSel('tbl_gallery_ref','idr','idg',$id,' AND ref="ART"'),'form-control', 'multiple', 'chosA','Select One or Multiple',FALSE); ?>
                </div>
            </div>
            
            <div class="form-group">
                	<label class="control-label col-sm-3">Status</label>
				  <div class="col-sm-9">
					<label class="radio inline">
                    <input type="radio" name="status" value="1" <?php if ((!(strcmp(1, $dG['gall_stat'])))||($acc=='INS')) {echo ' checked ';} ?>>Active</label>
					<label class="radio inline">
                    <input type="radio" name="status" value="0" <?php if (!(strcmp(0, $dG['gall_stat']))) {echo ' checked ';} ?>>Inactive</label>
				  </div>
                </div>
            </fieldset>
		
		</div>
		<div class="col-md-6">
		<div class="panel panel-default">
        	<div class="panel-heading">Pictures Gallery</div>
            <div class="panel-body">
            <fieldset>
        <?php if($id){ ?>
		<div class="well well-sm" style="background:#FFF">
			<div class="row">
              <div class="col-md-4">
                <input name="titimg" type="text" id="titimg" class="form-control" placeholder="Title image">
              </div>
              <div class="col-md-8">
                <input name="userfile" id="userfile" type="file" class="form-control"/>
              </div>
			</div>
        
            &nbsp;
		</div>
        <?php
		$query_RSgi = sprintf("SELECT * FROM tbl_gallery_items WHERE gall_id=%s ORDER BY img_id DESC", GetSQLValueString($id,'int'));
		$RSgi = mysql_query($query_RSgi) or die(mysql_error());
		$row_RSgi = mysql_fetch_assoc($RSgi);
		$totalRows_RSgi = mysql_num_rows($RSgi);
		if ($totalRows_RSgi>0){ ?>
        
		<div class="row"><!--BEG Thumbnail -->
        	<?php
            $contR=0;
			do{ ?>
        	<div class="col-sm-4">
			<div class="thumbnail">
            <a href="<?php echo $RAIZ0 ?>images/data/<?php echo $row_RSgi['img_path'] ?>" class="fancybox" rel="fancybox-thumb" title="<?php echo $row_RSgi['img_tit'] ?>">
			<img src="<?php echo $RAIZ0 ?>images/data/t_<?php echo $row_RSgi['img_path'] ?>" class="img-small" alt="...">
            <div class="text-center"><small><?php echo $row_RSgi['img_tit'] ?></small></div>
			</a>
            <div style="font-size:7px"><?php echo $RAIZ0 ?>images/data/<?php echo $row_RSgi['img_path'] ?></div>
            <a href="_fncts.php?id=<?php echo $id ?>&idimg=<?php echo $row_RSgi['img_id'] ?>&acc=DELIMG&url=<?php echo $_SESSION['urlc']?>" class="btn btn-xs btn-danger btn-block">
            <i class="glyphicon glyphicon-trash"></i> Delete</a>
			</div>
            </div>
            
            
            <?php
            $contR++;
			if($contR==3){
				$contR=0;
				echo '<div style="clear:both"></div>';
			}
			}while ($row_RSgi = mysql_fetch_assoc($RSgi)); ?>
        </div><!-- END Thumbnail -->
        <?php }else echo '<div class="alert alert-warning"><h4>No Pics Found</h4></div>';
		}else echo '<div class="alert alert-danger"><h4>To Upload image first save Gallery</h4></div>';
		?>
		</fieldset>
        	</div>
        </div>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
$(document).on('ready', function(){			
	$('#chosI').chosen();
	$('#chosA').chosen();
});
</script>
<?php include(RAIZf.'_foot.php'); ?>