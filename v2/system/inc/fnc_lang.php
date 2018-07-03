<?php
function setLangTxt($table,$lang,$idr){
	Global $conn;
	$vP=FALSE;
	$vD=FALSE;
	//Det Languague table
	$dLT=detRow('db_lang_table','table_name',$table);
	$idLT=$dLT['id'];//ID Language Table
	$LOGd.='db_lang_table id. '.$idLT.'<br>';
	if($dLT){
		//var_dump($lang);
		//echo '<br>';
		//FOREACH FIELDS
		foreach ($lang as $lKey=>$lVal){
			
			$lKeyE=explode(':',$lKey);
			
			$lKeyE_field=$lKeyE[0];
			$lKeyE_lang=$lKeyE[1];
			
			$LOGd.='Key. '.$lKey.' - Val. '.$lVal.'<br>';
			$LOGd.='field. '.$lKeyE_field.' - Lang. '.$lKeyE_lang.'<hr>';
			
			$paramsN=NULL;//REINICIAR EL $paramsN siempre ya que si entra a un bucle se almacena y da error
			$paramsN[]=array(
				array("cond"=>"AND","field"=>"idt","comp"=>"=","val"=>$idLT),
				array("cond"=>"AND","field"=>"field_name","comp"=>'=',"val"=>$lKeyE_field),
				array("cond"=>"AND","field"=>"idr","comp"=>'=',"val"=>$idr),
				array("cond"=>"AND","field"=>"lang","comp"=>'=',"val"=>$lKeyE_lang)
			);
			$dLTT=detRowNP('db_lang_txt',$paramsN);
			if($dLTT){
				$LOGd.='<p>UPDATE FIELD. </p>';
				$qry=sprintf('UPDATE db_lang_txt SET txt=%s WHERE idt=%s AND field_name=%s AND idr=%s AND lang=%s LIMIT 1',
							SSQL($lVal,'text'),
							SSQL($idLT,'text'),
							SSQL($lKeyE_field,'text'),
							SSQL($idr,'text'),
							SSQL($lKeyE_lang,'text'));
				$LOGd.=$qry;
				if(mysqli_query($conn,$qry)){
					$vP=TRUE;
				}
			}else{
				$LOGd.='<p>INSERT FIELD. </p>';
				$qry=sprintf('INSERT INTO db_lang_txt (txt,idt,field_name,idr,lang) VALUES (%s,%s,%s,%s,%s)',
							SSQL($lVal,'text'),
							SSQL($idLT,'text'),
							SSQL($lKeyE_field,'text'),
							SSQL($idr,'text'),
							SSQL($lKeyE_lang,'text'));
				$LOGd.=$qry;
				if(mysqli_query($conn,$qry)){
					$vP=TRUE;
				}
			}
		}
		
	}else{
		$LOG.='<p>Language table no exists in dabatase!</p>';
	}
	if($vD) $LOG.=$LOGd;
	$ret[log]=$LOG;
	$ret[est]=$vP;
	$ret[val]=$val;
	return($ret);
}

function genFormControlLang($cssC=NULL,$type='text',$name=NULL,$iid=NULL,$css=NULL,$placeh=NULL,$label=NULL,$cssL=NULL,$table,$field,$idr){
			Global $conn;
			$vD=FALSE;
			//Det Languague table
			$dLT=detRow('db_lang_table','table_name',$table);
			
			$LOGd.='db_lang_table id. '.$idLT.'<br>';
			if($dLT){
				$idLT=$dLT['id'];//ID Language Table
			}else{
				$qryILT=sprintf('INSERT INTO db_lang_table (table_name) VALUES (%s)',
							   SSQL($table,'text'));
				if(mysqli_query($conn,$qryILT)){
					$idLT=mysqli_insert_id($conn);
				}else $LOG.='Error while insert Language Table'.mysqli_error($conn);
			}
	
			if($idLT){
				//QRY Languages
				$qry='SELECT * FROM db_lang WHERE est=1 ORDER BY def ASC';
				$RS=mysqli_query($conn, $qry) or die (mysqli_error($conn));
				//detRowGSel('db_lang','id','min','est','1');
				$dRS=mysqli_fetch_assoc($RS);
				$LOGd.= '<hr>';
				$tRS=mysqli_num_rows($RS);
				if($tRS>0){
					$val.='<div class="panel panel-default">';
					$val.='<div class="panel-heading">'.$label.'</div>';
					$val.='<div class="panel-body">';
					do{//LOOP Languages
						$dRS_lang=NULL;
						$LOGd.='Lang. '.$dRS[sVAL].'<br>';
						$paramsN=NULL;//REINICIAR EL $paramsN siempre ya que si entra a un bucle se almacena y da error
						$paramsN[]=array(
							array("cond"=>"AND","field"=>"idt","comp"=>"=","val"=>$idLT),
							array("cond"=>"AND","field"=>"field_name","comp"=>'=',"val"=>$field),
							array("cond"=>"AND","field"=>"idr","comp"=>'=',"val"=>$idr),
							array("cond"=>"AND","field"=>"lang","comp"=>'=',"val"=>$dRS['min'])
						);
						$LOGd.='AFT detRowNP';
						$dLTT=detRowNP('db_lang_txt',$paramsN);
						$dRS_lang=$dRS['min'];
						$dRS_controlN="lang[".$field.':'.$dRS_lang."]";
						$LOGd.='BEF detRowNP';
						
						switch($type){
							case 'text':
								$val.='<div class="form-group">';
								$val.="<label class='control-label col-sm-4' for='".$iid."'>";
								$val.='<span class="badge"><i class="fas fa-language fa-lg"></i> '.$dRS_lang.'</span>';
								$val.="</label>";
								$val.="<div class='$cssC'>";
								$val.="<input type='".$type."' name='".$dRS_controlN."' id='".$iid."' value='".$dLTT[txt]."' class='".$css."' placeholder='".$placeh."'>";
								$val.='</div>';
								$val.='</div>';
							break;
							case 'textarea':
								$val.='<div class="form-group">';
								
								$val.="<label class='control-label col-sm-2' for='".$iid."'>";
								$val.='<span class="badge"><i class="fas fa-language fa-lg"></i> '.$dRS_lang.'</span>';
								$val.="</label>";
								
								$val.="<div class='col-sm-10'>";
								$val.="<textarea name='".$dRS_controlN."' id='".$iid."' class='".$css."'>";
								$val.=$dLTT[txt];
								$val.="</textarea>";
								$val.='</div>';
								$val.='</div>';
							break;
						}
					}while($dRS=mysqli_fetch_assoc($RS));
					$val.='</div>';
					$val.='</div>';
				}else $LOG.='<p>No Languagues enabled in database!</p>';
			}else $LOG.='<p>Language table no exists in dabatase!</p>';
			
			if($vD) $LOG.=$LOGd;
			$ret[log]=$LOG;
			$ret[val]=$val;
			return($ret);
		}

?>