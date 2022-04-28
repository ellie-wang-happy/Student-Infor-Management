<?php
// Include studentDAO file
require_once('./dao/studentDAO.php');
$studentDAO = new studentDAO(); 
 
// Define variables and initialize with empty values
$name = $birtdate = $image = "";
$name_err = $birthdate_err = $image_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    // Validate image 
    $input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Please upload an image.";     
    } else{
        $image = $input_image;
    }              
    // Validate birthdate
    $input_birthdate = trim($_POST["birthdate"]);
    if(empty($input_birthdate)){
        $birthdate_err = "Please enter the birthdate amount.";     
    }elseif(!filter_var($input_birthdate, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(\d{4}-(\d{2})-(\d{2}))$/")))){
        $birthdate_err = "Please input a valid date";
     } else{
        $birthdate = $input_birthdate;
    }
   
     
    // Check input errors before inserting in database
    if(empty($name_err) && empty($image_err) && empty($birthdate_err)){   
        $student = new Student($id, $name, $birthdate, $image);
        $result = $studentDAO->updateStudent($student);
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $studentDAO->getMysqli()->close();
    }

} else {
   // Check existence of id parameter before processing further
  if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
       $id =  trim($_GET["id"]);
       $student = $studentDAO->getStudent($id);
            
       if($student){
        // Retrieve individual field value
           $name = $student->getName();
           $birtdate = $student->getBirthDate(); 
           $image = $student->getImage();
        } else{
        // URL doesn't contain valid id. Redirect to error page
             header("location: error.php");
             exit();
       }
    } else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
    } 
    // Close connection
    $studentDAO->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        #upload{
            margin: 0 auto;
            display: block;
        }
         #filename{
            border:none;
        } 
    </style>
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.4.1.slim.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>

</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the student record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>BirthDate</label>
                            <input type="text" name="birthdate" class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $birtdate; ?>">
                            <span class="invalid-feedback"><?php echo $birthdate_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label><br/>
                           <?php  echo "<div><img src=" .'imgs/' . $image . " class='img-fluid img-thumbnail' width =300 height=300> </div>"; ?>
                            <input  id="filename" type="text" name ="image" value="<?php echo $image?>"> 
                           <p id="uploadError"></p>
                           <span class="invalid-feedback"><?php echo $image_err;?></span>
                        </div>                     
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit"> 
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>           
        </div>
        <button id="upload" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Change Another Image </button>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	        <div class="modal-dialog">
	        	<div class="modal-content">
		        	<div class="modal-header">
			        	<h5 class="modal-title">Upload</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        </div>
			        <div class="modal-body">
			        	<input type="file" accept="imgage/*" id="imageFile">
                        <p id="uploadError"></p>
		        	</div>
		        	<div class="modal-footer">
			        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary" onclick="uploadFile()">Upload</button>
			        </div>
		        </div><!-- /.modal-content -->
	        </div><!-- /.modal -->
        </div><!-- /.modal fade -->
    </div>  
   
</body>
</html>