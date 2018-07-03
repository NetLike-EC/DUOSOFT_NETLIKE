<?php require('../../init.php');
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Home</a></li>
   	<li><a href="<?php echo $RAIZc ?>com_reportes">REPORTES</a></li>
    <li class="active">MIGRATE TO mercoframesusa.com</li>
</ul>
<div class="container">
	<div class="page-header text-center">
		<h1>EXPORT Report to <span class="label label-default">mercoframesusa.com</span></h1>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-info">
				<div class="panel-heading">REPORT TO EXCEL</div>
				<div class="panel-body">
					<form action="rep_prods-mercousaParam.php" method="post">
						<fieldset class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-2">Brands</label>
								<div class="col-sm-10">
									<?php genSelect('valSel[]', detRowGSel('tbl_items_brands','id','name','status','1'), NULL, 'form-control', 'multiple', 'chosBrandA', 'Select One or Multiple', FALSE) ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-info btn-block">Obtain Excel</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-success">
				<div class="panel-heading">REPORT TO CSV</div>
				<div class="panel-body">
					<form action="rep_prods-mercousaParamCSV.php" method="post">
						<fieldset class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-2">Brands</label>
								<div class="col-sm-10">
									<?php genSelect('valSel[]', detRowGSel('tbl_items_brands','id','name','status','1'), NULL, 'form-control', 'multiple', 'chosBrandB', 'Select One or Multiple', FALSE) ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-success btn-block">Obtain CSV</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).on('ready', function(){			
	$('#chosBrandA').chosen();
	$('#chosBrandB').chosen();
});
</script>