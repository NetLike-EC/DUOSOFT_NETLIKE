<?php 
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$det=detRow('tbl_articles_cat','md5(cat_id)',$ids);
if ($det){
	$id=$det[cat_id];
	$acc=md5("UPDac");
	$img=vImg('data/img/blogc/',$det['cat_img']);
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc">'.$cfg[i][upd].$cfg[b][upd].'</button>';
}else {
	$acc=md5("INSac");
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc">'.$cfg[i][ins].$cfg[b][ins].'</button>';
}
$btnNew=genLink($urlc,$cfg[i]['new'].$cfg[b]['new'],$css='btn btn-default') ?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" class="form-horizontal">
	<fieldset>
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
		<input name="form" type="hidden" id="form" value="<?php echo md5('formPCat') ?>">
		<input name="ids" type="hidden" id="ids" value="<?php echo $ids ?>" />
		<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>" />
	</fieldset>
	
	<?php echo genPageHeader($dM[id],'navbar') ?>
	<?php echo genPageHeader(NULL,'header','h2',array(id=>$det['cat_id'],nom=>$det['cat_nom']),NULL,$btnAcc.$btnNew) ?>
	<div class="row">
		<div class="col-sm-7">
			<div class="well well-sm">
			<fieldset class="form-horizontal">
				<div class="form-group">
					<label class="col-md-3 control-label" for="cat_nom"><?php echo $cfg[com_artcF][f_cat] ?></label>
					<div class="col-md-9">
						<?php  echo genSelect("idP",detRowGSel('tbl_articles_cat','cat_id','cat_nom','cat_status','1'),$det['cat_idp'],'form-control', 'required','idP',NULL,TRUE,NULL,NULL);
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="cat_nom"><?php echo $cfg[com_artcF][f_nom]?></label>
					<div class="col-md-9">
						<input name="cat_nom" type="text" id="cat_nom" value="<?php echo $det['cat_nom']?>" class="form-control" required></div>
				</div>
				<?php $contMenTit=genFormControlLang('col-sm-8','text','tit',NULL,'form-control',NULL,$cfg[com_artcF][f_tit],'col-sm-4','tbl_articles_cat','tit',$id);
				echo $contMenTit[log];
				echo $contMenTit[val];
				?>
				<?php $contMenTit=genFormControlLang('col-sm-8','text','des',NULL,'form-control',NULL,$cfg[com_artcF][f_des],'col-sm-4','tbl_articles_cat','des',$id);
				echo $contMenTit[log];
				echo $contMenTit[val];
				?>
				<div class="form-group">
					<label class="col-md-3 control-label" for="cat_url"><?php echo $cfg[com_artcF][f_url]?></label>
					<div class="col-md-9">
						<input name="cat_url" type="text" id="cat_url" placeholder="<?php echo $cfg[com_artcF][f_url_p]?>" value="<?php echo $det['cat_url']; ?>" class="form-control" required></div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="txtIcon"><?php echo $cfg[com_artcF][f_ico]?></label>
					<div class="col-md-9">
						<div class="input-group">
							<input name="cat_icon" type="text" id="txtIcon" value="<?php echo $det['cat_icon']?>" class="form-control" placeholder="<?php echo $cfg[com_artcF][f_ico_p]?>">
							<div class="input-group-addon"><i class="<?php echo $det['cat_icon'] ?>" id="iconRes"></i></div>
						</div>
					</div>
				</div>
			</fieldset>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="well well-sm text-center">
				<a href="<?php echo $img['n'] ?>" class="thumbnail fancybox"><img src="<?php echo $img['t'] ?>" class="img-md"/></a><br/>
				<input name="userfile" type="file" id="userfile"/>
				<input name="imagea" type="hidden" id="imagea" value="<?php echo $det['cat_img'] ?>">
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">Items related</div>
		<?php
		$qryLA=sprintf("SELECT * FROM tbl_articles WHERE md5(cat_id)=%s",
					  SSQL($ids,'text'));
		$RSla=mysqli_query($conn,$qryLA);
		$dRSla=mysqli_fetch_assoc($RSla);
		$tRSla=mysqli_num_rows($RSla);
		if($tRSla>0){ ?>
		<ul class="list-group">
			<?php do{ ?>
			<li class="list-group-item">
				<?php echo $dRSla['title'] ?>
			</li>
			<?php }while($dRSla=mysqli_fetch_assoc($RSla)); ?>
		</ul>	
		<?php }else{ ?>
		<div class="panel-body">No items</div>
		<?php } ?>
	</div>
</form>