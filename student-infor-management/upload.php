<?php  
//the upload file name
$filename = basename($_FILES['file']['name']);
$dir = "imgs/";
//set the target file path 
$filepath=$dir . $filename;
$uploadOK=""; //return filename if upload file success
$filext = strtolower(pathinfo($filepath,PATHINFO_EXTENSION));
$validext= array("png","jpg","jpeg","tif");
if(isset($_POST["upload"])){   
  $check = getimagesize($_FILES['file']['tmp_name']);
  //check if the file is an image
if(($check != false)&&(in_array($filext,$validext))){
    //if file exists, don't upload
      if(file_exists($filepath)){
         $uploadOK=$filename;
      }
      else if(move_uploaded_file($_FILES['file']['tmp_name'], $filepath)){ //upload file to target path
       $uploadOK=$filename;
     }
  } else{
       $uploadok="";
  }

  echo $uploadOK;

}

?>