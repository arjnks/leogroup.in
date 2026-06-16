<?php
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
                        <a class="active-menu"  href="add-image.php"><i class="fa fa-edit fa-2x"></i> Add Gallery </a>
                    </li>				
					<li>
                        <a href="add-company.php"><i class="fa fa-users"></i>Add Client</a>
                     </li>
                     <li>
                        <a href="add-logo.php"><i class="fa fa-plus"></i>Add Logos</a>
                     </li>
				
                	
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Add Image</h2>   
                      
                       
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
                                     <div class="col-md-3">
                                     <div class="form-group">
                                            <label>Select Album</label>
                                            <select class="form-control" id="selcat" name="selcat">
                                                <option value="">Album Name</option>
                                                <?php 
                                                require_once("../config.php");
                                                $sel=$con->prepare("select *  from tb_cat");
                                                $sel->execute();
                                                while($row=$sel->fetch(PDO::FETCH_ASSOC))
                                                {
                                                
                                                echo "<option value=".$row['catid'].">".$row['cname']."</option>";
                                                }?>
                                            </select>
                                        </div>
										</div>
										
										    <div class="col-md-12">
										    <div class="form-group">
                                            <label>Browse Image</label>
                                         <input id="main_fileUpload" name="image1"multiple="multiple" type="file"/> 
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
                         <div class="col-md-3">
                                     <div class="form-group">
                                            <label>Select Album</label>
                                            <select class="form-control" id="selalbum" name="selcat" onchange="selimg()">
                                                <option value="">Album Name</option>
                                                <?php 
                                                require_once("../config.php");
                                                $sel=$con->prepare("select *  from tb_cat");
                                                $sel->execute();
                                                while($row=$sel->fetch(PDO::FETCH_ASSOC))
                                                {
                                                
                                                echo "<option value=".$row['catid'].">".$row['cname']."</option>";
                                                }?>
                                            </select>
                                        </div>
                    </div><br><br>
                         <div class="row">
                          <div class="col-md-12" id="img">
                            
            </div>
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
      $catid=$_POST["selcat"];
      $fname=$_FILES["image1"]["name"];
      $fsize=$_FILES["image1"]["size"];
     $cont=$_FILES["image1"]["tmp_name"];
     $cont2= @getimagesize($_FILES["image1"]["tmp_name"]);
  $width = $cont2[0];
    $height = $cont2[1];
  if($fname!="")
  {
        $fna=$catid.$fname;
    $target = "gallery/";
     $target_file = $target . $fna;
   //This gets all the other information from the form
    $Filename=basename( $_FILES['image1']['name']);


//Writes the Filename to the server
if(move_uploaded_file($_FILES['image1']['tmp_name'], $target_file)) {
    //Tells you if its all ok
    //Writes the information to the database
  if ($width<="800") 
  {
    $img=$con->prepare("INSERT INTO `tb_gallery`(`catid`,`path`,`status`) VALUES ('$catid','$target_file','1')");
    $img->execute();
  }
  else
  {
    ?>
    <script type="text/javascript">
      alert("File Dimension is Wrong");
    </script>
    <?php
  }
} else {
    //Gives and error if its not
    echo "Sorry, there was a problem uploading your file.";
}
}

    }

    ?>
    <script type="text/javascript">
      function selimg()
      {
        var cat=$("#selalbum").val();
        
                  $.ajax({
                url:"ajaxcmp.php",
                type:"post",
                data:{type:8,catid:cat},
                success:function(data)
                {

                 $("#img").html(data);
                }
        });
        
      }
       function del(gid)
     {
       $.ajax({
                url:"ajaxcmp.php",
                type:"post",
                data:{type:9,gid:gid},
                success:function(data)
                {
                  window.location.reload();
                }
        });
     }
    </script>
   
</body>
</html>
