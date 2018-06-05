<?php require_once('../../../init.php');
function imagename_savedatabase($codpac,$filename){
	$query_insert_temp='INSERT INTO tbl_images_clientes (pac_cod, img_path, img_status) VALUES ("'.$codpac.'" ,"'.$filename.'", "'."1".'")';
	mysql_query($query_insert_temp)or die(mysql_error());
}
/* 
Description: 
- The script receives some data with method="post". 
- One of this data may be a path of an image that was previously uploaded 
  to a temporary directory in the server. If this datum exists, the script 
  move the image from the temporary directory to a final one. 
- The script process the rest of the data and produces some output.  
*/ 
$pathToMove = "../../../images/db/pac/"; 

$imagePathParameterName = "uploadedImagePath";
$imageDescriptionParameterName = "imageDescription"; 

$imagePath = $_POST[$imagePathParameterName]; 
$description = $_POST[$imageDescriptionParameterName]; 

// the funtion file_exists doesn't find files whose name has special 
// characters, like tildes 
if (($imagePath != null) && (file_exists($imagePath))){
  $imagePathToMove = $pathToMove . basename($imagePath); 
  if(file_exists($imagePathToMove)) unlink($imagePathToMove);
  if(rename($imagePath, $imagePathToMove)){
	  echo "<h2>Imagen Guardada!</h2>";
	  imagename_savedatabase($description, basename($imagePath));
	  echo "<img src='".$imagePathToMove."'/>";
  }
  else echo "There was an error moving the file " . $imagePath . " to " . $imagePathToMove;
} 
else echo "No se ha cargado la imagen";
?>