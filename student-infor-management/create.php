<?php
// Include studentDAO file
require_once('./dao/studentDAO.php');

// Define variables and initialize with empty values
$name = $birthdate = $image = "";
$name_err = $birthdate_err = $image_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate birthdate
    $input_birthdate = trim($_POST["birthdate"]);
    if(empty($input_birthdate)){
        $birthdate_err = "Please enter an birthdate.";     
     }elseif(!filter_var($input_birthdate, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(\d{4}-(\d{2})-(\d{2}))$/")))){
        $birthdate_err = "Please input a valid date";
     }else{
        $birthdate = $input_birthdate;
    }
   
    // Validate image
     $input_image = trim($_POST["image"]) ;
     if(empty($input_image)){
         $image_err = "Please upload an image";     
     } else{
         $image = $input_image;
     }
  
      
    // Check input errors before inserting in database
    if(empty($name_err) && empty($birthdate_err) && empty($image_err)){
        $studentDAO = new studentDAO();    
        $student = new Student(0, $name, $birthdate, $image);
        $addResult = $studentDAO->addStudent($student);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $studentDAO->getMysqli()->close();
        }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add student record to the database.</p>
					
					<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>BirthDate</label>
                            <textarea name="birthdate" placeholder ="YYYY-MM-DD" class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>"><?php echo $birthdate; ?></textarea>
                            <span class="invalid-feedback"><?php echo $birthdate_err;?></span>
                        </div>
                        <div class="form-group" >
                           <label >Image</label><br/> 
                           <input  id="filename" type="text" name ="image" value="">
                           <p id="uploadError"></p>
                           <span class="invalid-feedback"><?php echo $image_err;?></span>
                           <?php  echo "<div><img src=" .'imgs/' . $image . " class='img-fluid img-thumbnail' width =400 height=400 alt='image'> </div>"; ?> 
                        </div>
                        </div>
                        <input type="submit" class="btn btn-primary"  value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
        <button id="upload" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Upload an Image </button>
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
        <?include 'footer.php';?>
    </div>
</body>
</html>

