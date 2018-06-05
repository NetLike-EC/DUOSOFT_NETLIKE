<?php include('../../init.php');
loginN(); 
$_SESSION['MODSEL']="INVP";
$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php');?>
<div class="page-container row-fluid">
	<!-- BEGIN SIDEBAR -->
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<!-- END SIDEBAR -->
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<?php include(RAIZm.'mod_portlet/index.php'); ?>
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE -->
		<!-- Button to trigger modal -->

 
<!-- Modal -->
<a href="#myModal" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
<div id="myModal" class="modal hide fade modalReload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Modal header</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>
<script type="text/javascript">
$('.modalReload').on('hidden', function () {
  alert('cerrado');
})
</script>
		<!-- END PAGE -->
       </div>
</div>

</body>
<?php include(RAIZf.'_foot.php'); ?>