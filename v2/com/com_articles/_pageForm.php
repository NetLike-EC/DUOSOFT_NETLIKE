<?
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$det=detRow('tbl_articles', 'md5(art_id)',$ids);
if ($det){
	$id=$det['art_id'];
	$tit=getLangT('tbl_articles','title',$id,$_SESSION['lang']);
	$acc=md5("UPDp");
	$image=vImg('data/img/blog/',$det['image']);
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc">'.$cfg[i][upd].$cfg[b][upd].'</button>';
}else{
	$acc=md5("INSp");
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc">'.$cfg[i][ins].$cfg[b][ins].'</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default">'.$cfg[i]['new'].$cfg[b]['new'].'</a>';
?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" class="form-horizontal">
	<fieldset>
		<input name="form" type="hidden" value="<?php echo md5('formPage') ?>">
		<input name="ids" type="hidden" value="<?php echo $ids ?>" />
		<input name="acc" type="hidden" value="<?php echo $acc ?>">
		<input name="url" type="hidden" value="<?php echo $urlc ?>">
	</fieldset>
	<?php echo genPageHeader($dM[id],'navbar') ?>
	<?php echo genPageHeader(NULL,'header','h2',array('nom'=>$tit,'id'=>$id),NULL,$btnAcc.$btnNew) ?>
	<ul class="nav nav-tabs">
	  <li class="active"><a href="#gen" data-toggle="tab"><?php echo $cfg[com_artF][tab_gen]?></a></li>
	  <li><a href="#txt" data-toggle="tab"><?php echo $cfg[com_artF][tab_tex]?></a></li>
	  <li><a href="#mul" data-toggle="tab"><?php echo $cfg[com_artF][tab_mul]?></a></li>
	  <li><a href="#doc" data-toggle="tab"><?php echo $cfg[com_artF][tab_doc]?></a></li>
	  <li><a href="#seo" data-toggle="tab"><?php echo $cfg[com_artF][tab_seo]?></a></li>
	  <li><a href="#inf" data-toggle="tab"><?php echo $cfg[com_artF][tab_inf]?></a></li>
	</ul>
	<div class="panel panel-default">
	  <div class="panel-body">
		<div class="tab-content">
	  <div class="tab-pane active" id="gen">
	  <!-- BEG GENERAL DATA -->
	  <div class="row"> 
		<div class="col-lg-5">
			<div class="well well-sm text-center">
				<a href="<?php echo $image['n'] ?>" class="thumbnail fancybox"><img src="<?php echo $image['t'] ?>" class="img-md"/></a><br/>
				<input name="userfile" type="file" id="userfile"/>
				<input name="imagea" type="hidden" id="imagea" value="<?php echo $det['image'] ?>">
			</div>
		</div>
		<div class="col-lg-7">
			<div class="well well-sm">
			<fieldset class="form-horizontal">	
			
					<?php $contMenTit=genFormControlLang('col-sm-8','text','title',NULL,'form-control',NULL,$cfg[com_artF][i_tit],'col-sm-4','tbl_articles','title',$id);
					echo $contMenTit[log];
					echo $contMenTit[val];
					?>
					<div class="form-group">
						<label class="col-lg-3 control-label" for="art_url"><?php echo $cfg[com_artF][i_url]?></label>
						<div class="col-lg-9">
					  <input name="art_url" type="text" id="art_url" placeholder="<?php echo $cfg[com_artF][i_url_p]?>" value="<?php echo $det['art_url']?>" class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><abbr title="<?php echo $cfg[com_artF][i_opt_p]?>"><?php echo $cfg[com_artF][i_opt]?></abbr></label>
						<div class="col-lg-9">
					  <label class="checkbox inline">
	  <input name="view_title" type="checkbox" id="inlineCheckbox1" value="1" <?php if (!(strcmp('1', $det['view_title']))) {echo 'checked';} ?>><?php echo $cfg[com_artF][i_optT]?></label>
	<label class="checkbox inline">
	  <input name="view_image" type="checkbox" id="inlineCheckbox2" value="1" <?php if (!(strcmp('1', $det['view_image']))) {echo 'checked';} ?>><?php echo $cfg[com_artF][i_optI]?></label>
	  <label class="checkbox inline">
	  <input name="status" type="checkbox" id="inlineCheckbox3" value="1" <?php if (!(strcmp('1', $det['status']))) {echo 'checked';} ?>><?php echo $cfg[com_artF][i_optA]?></label>
	  <label class="checkbox inline">
	  <input name="featured" type="checkbox" id="inlineCheckbox4" value="1" <?php if (!(strcmp('1', $det['featured']))) {echo 'checked';} ?>><?php echo $cfg[com_artF][i_optF]?></label>
	</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label" for=""><?php echo $cfg[com_artF][i_cat]?></label>
						<div class="col-lg-9">
							<?php echo genSelect("cat_id",detRowGSel('tbl_articles_cat','cat_id','cat_nom','cat_status','1'),$det['cat_id'],'form-control', 'required'); ?>
						</div>
					</div>
					</fieldset>
					</div>
		</div>
	</div>
	  <!-- END GENERAL DATA -->
	  </div>
	  <div class="tab-pane" id="txt">
	  <!-- BEG TEXTS -->
			<?php $txt=genFormControlLang(NULL,'textarea','des',NULL,'tmcem input-block-level',NULL,$cfg[com_artF][i_des],'col-sm-4','tbl_articles','des',$id);
			echo $txt[log];
			echo $txt[val];
			?>
	  </div>
	  <div class="tab-pane" id="mul">
			<?php
			if ($det) include('_pageFormGall.php');
			else echo $msgFS;
			?>
	  </div><!-- id="mul" -->
	  <div class="tab-pane" id="doc">
	  Documentos
	  </div><!-- id="doc" -->
	  <div class="tab-pane" id="seo">
	  SEO
	  </div><!-- id="seo" -->
	  <div class="tab-pane" id="inf">
	  INFORMATION
	  </div><!-- id="inf" -->

	  </div>
	  </div>
	</div>
</form>