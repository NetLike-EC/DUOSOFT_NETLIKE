<div class="row">
	<div class="col-sm-6">
<?php
	$qryGR=sprintf('SELECT id, idg, idr, ref 
	FROM tbl_gallery_ref 
	WHERE md5(idr)=%s AND ref=%s',
				SSQL($ids,'text'),
			  	SSQL('ITEM','text'));
	$RSgr=mysqli_query($conn,$qryGR)or die (mysqli_error($conn));
	$dRSgr=mysqli_fetch_assoc($RSgr);
	$tRSgr=mysqli_num_rows($RSgr);
?>
<div>
<?php if($tRSgr>0){ ?>
<?php do{ ?>
<?php $detG=detRow('tbl_gallery','gall_id',$dRSgr['idg']);
$qryGI=sprintf('SELECT * FROM tbl_gallery_items WHERE gall_id=%s',
			  SSQL($detG['gall_id'],'int'));
$RSgi=mysqli_query($conn,$qryGI) or die (mysqli_error($conn));
$dRSgi=mysqli_fetch_assoc($RSgi);
$tRSgi=mysqli_num_rows($RSgi);
?>
	<div class="panel panel-info" id="G-<?php echo $dRSgr['id'] ?>">
		<div class="panel-heading">
		<fieldset class="form-inline">
		<span class="badge"> <?php echo $detG['gall_id'] ?></span> 
		<span class="label label-default">Title</span> 
		<input type="text" class="form-control input-sm setDB" value="<?php echo $detG['gall_tit'] ?>" data-tbl="GallTit" data-id="<?php echo $detG['gall_id'] ?>">
			<div class="btn-group pull-right">
				<button class="btn btn-default btn-xs btn-acc-ulGI" value="<?php echo $dRSgr['id'] ?>" type="button"><i class="fa fa-chain-broken" aria-hidden="true"></i> Unlink</button>
				<!--<a href="" class="btn btn-default btn-xs"><i class="fa fa-trash"></i> Delete gallery and images</a>-->
			</div>
		</fieldset>
		</div>
		<?php if($tRSgi>0){ ?>
		<div class="table-responsive">
		<table class="table table-condensed table-bordered table-hover">
			<tr>
				<td>ID</td>
				<td>Properties</td>
				<td>Image</td>
				<td></td>
			</tr>
			<div class="row">
			<?php do{
				$picG=vImg('data/img/item/',$dRSgi['img_path'],TRUE);
				$idImg=$dRSgi['img_id'];
				$idImgS=md5($dRSgi['img_id']);
			?>
			<tr id="<?php echo $idImg ?>">
				<td><?php echo $idImg ?></td>
				<td>
					<div><span class="label label-default">Filename</span>
					<?php echo $dRSgi['img_path'] ?></div>
					<br>
					<div><span class="label label-default">Name</span>
					<input type="text" class="form-control input-sm setDB" value="<?php echo $dRSgi['img_tit'] ?>" data-tbl="GallItemTit" data-id="<?php echo $idImg ?>">
					</div>
				</td>
				<td><a href="<?php echo $picG['n'] ?>" class="thumbnail fancybox" title="<?php echo $dRSgi['img_tit'] ?>" rel="gall" style="margin: 0">
				<img src="<?php echo $picG['t'] ?>">
				</a></td>
				<td>
				
				<div class="btn-group">
					<button type="button" class="js-copy-btn btn btn-default btn-xs" data-title="<?php echo $picG['n'] ?>"><i class="fa fa-clipboard fa-lg"></i> Copy url</button>
					<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu">
						<li><a class="js-copy-btn" data-title="<?php echo $picG['t'] ?>"><i class="fa fa-clipboard fa-lg"></i> Copy Thumb url</a></li>
						<li><a class="js-copy-btn" data-title="<img src='<?php echo $picG['n'] ?>' class='img-thumbnail'>">
							<i class="fa fa-code fa-lg" aria-hidden="true"></i> Embed img</a>
						</li>
						<li><a class="js-copy-btn" data-title="<img src='<?php echo $picG['n'] ?>' class='img-thumbnail'>">
							<i class="fa fa-code fa-lg" aria-hidden="true"></i> Embed img-thumb</a>
						</li>
						<li><a class="js-copy-btn" data-title="<a href='<?php echo $picG['n'] ?>' class='thumbnail fancybox' title='<?php echo $dRSgi['img_tit'] ?>'><img src='<?php echo $picG['t'] ?>'></a>">
							<i class="fa fa-code fa-lg" aria-hidden="true"></i> Embed a>img</a>
						</li>
						<li role="separator" class="divider"></li>
						<li><a onClick="removeTableRow('<?php echo $idImg ?>')" class="btn btn-default btn-xs"><span class="fa fa-trash fa-lg"></span> Delete</a></li>
					</ul>
				</div>
			</tr>
			<?php }while($dRSgi=mysqli_fetch_assoc($RSgi)); ?>
			</div>
		</table>
		</div>
		<?php }else{ ?>
		<div class="panel-body">No images in this Gallery</div>
		<?php } ?>
	</div>	
<?php }while($dRSgr=mysqli_fetch_assoc($RSgr)); ?>
<?php } ?>
</div>
</div>
   	<div class="col-sm-6">
    	<div class="panel panel-success">
			<div class="panel-heading">UPLOADER</div>
    	<div class="panel-body">
			<fieldset class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">Gallery</label>
					<div class="col-sm-8">
					<?php genSelect('gallSel', detRowGSel('tbl_gallery_ref','idg','idg','idr',$ids,' AND ref="ITEM"'), NULL, 'form-control', NULL, NULL, 'Select', TRUE, 0, 'New Gallery') ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>
							<input type="checkbox" value="TRUE" name="FU_ofn"> Title of files are Filename ?
							</label>
						</div>
					</div>
				</div>
			</fieldset>
    	<div id="uploader"><p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p></div>
        </div>
		</div>
    </div>
</div>


<!-- Load Queue widget CSS and jQuery -->
<link rel="stylesheet" type="text/css" href="<?php echo $RAIZa ?>plugins/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" />
<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
<!--<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>-->
<script type="text/javascript" src="<?php echo $RAIZa ?>js/browserplus-min.js"></script>
<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	$(".input-iign").keyup(function(){ alert($(this).attr('data-rel')); });
	$(".btn-acc-ulGI").click(function(){ unlinkGallItem($(this).val()); });
	$(".js-copy-btn").click(function(){ copyTextToClipboard($(this).attr('data-title')); });
	$(".setDB").keyup(function(){ setDB($(this).val(),$(this).attr('data-tbl'),$(this).attr('data-id')); });
});

	// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").pluploadQueue({
		// General settings
		//runtimes : 'gears,flash,silverlight,browserplus,html5',
		runtimes : 'gears,browserplus,html5',
		url : 'upload.php',
		max_file_size : '10mb',
		chunk_size : '1mb',
		unique_names : true,
		// Resize images on clientside if we can
		resize : {width : 1280, height : 720, quality : 90},
		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		],
		//flash_swf_url : '<?php echo $RAIZ ?>js/plupload/js/Moxie.swf',
		silverlight_xap_url : '<?php echo $RAIZa ?>plugins/plupload/js/Moxie.xap'
	});

	// Client side form validation
	$('form').submit(function(e) {
        var uploader = $('#uploader').pluploadQueue();

        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });
                
            uploader.start();
        } else {
            $('form')[0].submit();
			//alert('You must queue at least one file.');
        }

        return false;
    });
});
	
function removeTableRow(trId){
	//alert(trId);
	var url='accJS.php';
	$.ajax({
  		method: "POST",
  		url: url,
		dataType: "json",
  		data: { ids: trId, acc: "DelImg" }
	})
	.done(function( msg ) {
		//alert(msg);
		showLoading();
		$("#logF").show(100).text(msg.log).delay(3000).hide(200);
		
		if(msg.est==true){
			$('#' + trId).remove();
			//alert("ok");
		}else{
			$('#' + trId).addClass('warning');
			//alert("no");
		}
		hideLoading();	
		//alert( "Data Saved: " + msg.log );
	})
	.fail(function( jqXHR, textStatus, errorThrown ) {
		$('#' + trId).addClass('warning');
     	$("#logF").show(100).text("La solicitud a fallado: " +  textStatus).delay(3000).hide(200);
	});
}

function unlinkGallItem(ids){
	var url='accJS.php';
	$.ajax({
		method: "POST",
		url: url,
		dataType: "json",
		data: { ids: ids, acc: "UNLINKGALLITEM" }
	})
	.done(function( msg ) {
		showLoading();
		$("#logF").show(100).text(msg.log).delay(3000).hide(200);
		if(msg.est==true){ $('#G-' + ids).remove();
		}else{ $('#G-' + ids).addClass('warning');
		}
		hideLoading();
	})
	.fail(function( jqXHR, textStatus, errorThrown ) {
		$('#G-' + ids).addClass('warning');
		$("#logF").show(100).text("La solicitud a fallado: " +  textStatus).delay(3000).hide(200);
	});
}

function setDB(valor, tbl, id){
	var url='accJS.php';
	$.ajax({
		method: "POST",
		url: url,
		dataType: "json",
		data: {ids:id, val:valor, tbl:tbl, acc:"setDB"}
	})
	.done(function( msg ) {
		showLoading();
		$("#logF").show(100).text(msg.log).delay(3000).hide(200);
		hideLoading();
	})
	.fail(function( jqXHR, textStatus, errorThrown ) {
		$("#logF").show(100).text("La solicitud a fallado: " +  textStatus).delay(3000).hide(200);
	});
	}
</script>