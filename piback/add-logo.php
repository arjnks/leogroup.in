<?php
require_once("../config.php");
error_reporting(0);
session_start();
if(!isset( $_SESSION["uid"]))
{
  ?>
  <script type="text/javascript">
    window.location="login/login.php";
  </script>
<?php
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Leogroup</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
	 <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Leo Group admin</a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> <a href="login/logout.php" class="btn btn-danger square-btn-adjust">Logout</a>  </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="assets/img/find_user.png" class="user-image img-responsive"/>
					</li>
				
						
                    <li>
                        <a href="index.php"><i class="fa fa-sitemap fa-3x"></i> Add Album</a>
                    </li>
                  
                    <li>
                        <a href="add-image.php"><i class="fa fa-edit fa-2x"></i> Add Gallery </a>
                    </li>				
					<li>
                        <a href="add-company.php"><i class="fa fa-users"></i>Add Client</a>
                     </li>  
				              <li>
                        <a class="active-menu" href="add-logo.php"><i class="fa fa-plus"></i>Add Logos</a>
                     </li>
                	
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Add Logos</h2>   
                      
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                      
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                             
                                    <form role="form" method="post" enctype="multipart/form-data" id="frmalbum">
                                    
										
										    <div class="col-md-12">
										    <div class="form-group">
                                            <label>Browse Logo</label>
                                         <input id="main_fileUpload" name="image1" type="file"/> 
                                        </div>
										 </div>
										     <div class="col-md-12">
                                 <div class="form-group mgtp25" style="margin-top:19px;">
                                    
                                        <button type="submit" class="btn btn-default" name="btnsub">Submit</button>
                                
</div>
</div>
  </form>
                                    <br />
										
		
</div>
                                    
                             
                      
                                   
     

                                 
    </div>
                                
                             
                            </div>


                            
                        </div>

                        <h4>View Image</h4>
                        <br>
                         
                        <div class="row">
                            <?php
                              $selq=$con->prepare("SELECT * FROM tb_logo");
                              $selq->execute();
                              while($row=$selq->fetch(PDO::FETCH_ASSOC))
                              {
                            ?>
                            <div style="height: 115px;" class="col-md-2">
                              <img class="img-responsive" src="<?php echo $row['path']; ?>">
                              <div style="bottom: 10px;position: absolute;left: 45px;">
                              <a class="btn btn-danger" href="dellog.php?id=<?php echo $row['id']; ?>">Delete</a>
                              </div>
                            </div>
                            <?php
                              }
                            ?>
                        </div>      
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
                <!-- /. ROW  -->
          
                <!-- /. ROW  -->
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    <?php
    if(isset($_POST["btnsub"]))
    {


      $target_dir = "logofold/";
$target_file = $target_dir . basename($_FILES["image1"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image1"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
      ?>
        <script type="text/javascript">
          alert("File is not an image.");
        </script>
        <?php
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
  ?>
        <script type="text/javascript">
          alert("Sorry, file already exists.");
        </script>
        <?php
    $uploadOk = 0;
}
// Check file size
if ($_FILES["image1"]["size"] > 500000) {
  ?>
        <script type="text/javascript">
          alert("Sorry, your file is too large.");
        </script>
        <?php
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  ?>
        <script type="text/javascript">
          alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        </script>
        <?php
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  ?>
        <script type="text/javascript">
          alert("Sorry, your file was not uploaded.");
          window.location="add-logo.php";
        </script>
        <?php
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["image1"]["tmp_name"], $target_file)) {
        $img=$con->prepare("INSERT INTO `tb_logo`(`path`) VALUES ('$target_file')");
      $img->execute();
      ?>
        <script type="text/javascript">
          alert("Uploading File Successfull..");
          window.location="add-logo.php";
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
          alert("There Was an error in uploading your file..");
          window.location="add-logo.php";
        </script>
        <?php
    }
}

    }
    ?>
   
</body>
</html>
