<!-- Load Queue widget CSS and jQuery -->
<link rel="stylesheet" type="text/css" href="<?php echo $RAIZa ?>plugins/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" />
<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").pluploadQueue({
		// General settings
		//runtimes : 'gears,flash,silverlight,browserplus,html5',
		runtimes : 'gears,browserplus,html5',
		url : '_pageFormGallU.php',
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
    var url='_fncts.php';
	$.ajax({
		type:"POST",
		url:url,
		data:"idpic="+trId+"&acc=DELPIC",
		success: function(){
			$('#' + trId).remove();
		}
	});
	//jQuery.ajax( url ,POST[] )
}
</script>


<div class="row">
	<div class="col-sm-6">
<?php
	$qryGR=sprintf('SELECT idg, idr, ref FROM tbl_gallery_ref WHERE idr=%s AND ref=%s',
				SSQL($id,'int'),
			  	SSQL('ART','text'));
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
	<div class="panel panel-info">
		<div class="panel-heading"><span class="badge"> <?php echo $detG['gall_id'] ?></span> 
		<span class="label label-default">Title</span> <?php echo $detG['gall_tit'] ?></div>
		<?php if($tRSgi>0){ ?>
		<div class="table-responsive">
		<table class="table table-condensed table-bordered table-hover">
			<tr>
				<td>ID</td>
				<td>File</td>
				<td>Image</td>
				<td></td>
			</tr>
			<div class="row">
			<?php do{
				$picG=vImg('data/img/blog',$dRSgi['img_path'],TRUE);
			?>
			<tr id="<?php echo $dRSgi['img_id'] ?>">
				<td><?php echo $dRSgi['img_id'] ?></td>
				<td><?php echo $dRSgi['img_path'] ?></td>
				<td><a href="<?php echo $picG['n'] ?>" class="thumbnail" rel="shadowbox[gall]" style="margin: 0">
				<img src="<?php echo $picG['t'] ?>">
				</a></td>
				<td>
				<button value="<?php echo $picG['n'] ?>" class="js-copy-btn btn btn-default btn-xs" type="button"><i class="fa fa-clipboard"></i> Copy</button>
				<a onClick="removeTableRow(<?php echo $dRSgi['img_id'] ?>)" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span> Delete</a></td>
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
					<?php genSelect('gallSel', detRowGSel('tbl_gallery_ref','idg','idg','idr',$id,' AND ref="ART"'), NULL, 'form-control', NULL, NULL, 'Select', TRUE, 0, 'New Gallery') ?>
					</div>
				</div>
			</fieldset>
    	<div id="uploader"><p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p></div>
        </div>
		</div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(".js-copy-btn").click(function(){
		copyTextToClipboard($(this).val());
		/*
		var $btn = $(this).button('loading');
		var parametros = {
            subject: $('#stSub').val(),
            mail: $('#stMail').val(),
			reply:$("#stRep").val(),
			msg:$("#stCon").val()
    	};
		
		$.post("jsonSendTest.php", parametros, siRespuesta, 'json');
		$btn.button('reset');
		*/
    });
});

function copyTextToClipboard(text) {
  var textArea = document.createElement("textarea");

  //
  // *** This styling is an extra step which is likely not required. ***
  //
  // Why is it here? To ensure:
  // 1. the element is able to have focus and selection.
  // 2. if element was to flash render it has minimal visual impact.
  // 3. less flakyness with selection and copying which **might** occur if
  //    the textarea element is not visible.
  //
  // The likelihood is the element won't even render, not even a flash,
  // so some of these are just precautions. However in IE the element
  // is visible whilst the popup box asking the user for permission for
  // the web page to copy to the clipboard.
  //

  // Place in top-left corner of screen regardless of scroll position.
  textArea.style.position = 'fixed';
  textArea.style.top = 0;
  textArea.style.left = 0;

  // Ensure it has a small width and height. Setting to 1px / 1em
  // doesn't work as this gives a negative w/h on some browsers.
  textArea.style.width = '2em';
  textArea.style.height = '2em';

  // We don't need padding, reducing the size if it does flash render.
  textArea.style.padding = 0;

  // Clean up any borders.
  textArea.style.border = 'none';
  textArea.style.outline = 'none';
  textArea.style.boxShadow = 'none';

  // Avoid flash of white box if rendered for any reason.
  textArea.style.background = 'transparent';


  textArea.value = text;

  document.body.appendChild(textArea);

  textArea.select();

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
  } catch (err) {
    console.log('Oops, unable to copy');
  }

  document.body.removeChild(textArea);
}
</script>