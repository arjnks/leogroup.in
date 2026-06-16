<?php
ob_start();
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
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
                <a class="navbar-brand" href="index.php">Leo Group Admin</a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"><a href="login/logout.php" class="btn btn-danger square-btn-adjust">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="assets/img/find_user.png" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                        <a class="active-menu" href="index.php"><i class="fa fa-sitemap fa-3x"></i> Add Album</a>
                    </li>
					 <li>
                        <a href="add-image.php"><i class="fa fa-edit fa-2x"></i> Add Gallery </a>
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
                     <h2>Add Album</h2>   
                      
                       
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
                                <div class="col-md-6">
                                    <h5>Album Name</h5>
                                    <form role="form" method="post">
                                        <div class="form-group">
                                        
                                            <input class="form-control" name="txtCatname" />
                                         
                                        </div>
                                     
                                    
                                
                                    
                                        <button type="submit" class="btn btn-default" name="btnsub">Submit</button>
                                

                                    </form>
                                    <br />
                                   
     

                                 
    </div>
                                <div class="col-md-10">
                                  <table class="table table-striped table-bordered" >
                        <thead>
                          <th>Album Name</th>
                          <th>Total Photos</th>
                          <th>Action</th>
                        </thead>
                        <tbody>
                          <?php
                          require_once("../config.php");
                          $sel=$con->prepare("select * from tb_cat");
                          $sel->execute();
                          while ($row=$sel->fetch(PDO::FETCH_ASSOC))
                          {
                            $sel1=$con->prepare("select * from tb_gallery where catid='$row[catid]'");
                            $sel1->execute();
                            $cnt=$sel1->rowCount();
                          ?>
                          <tr>
                            <td><?php echo $row["cname"];?></td>
                            <td><?php echo $cnt?></td>
                            <td> <button class="btn btn-danger btn-xs" onclick="del(<?php echo $row["catid"];?>)">Delete</button></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>

                                </div>
                             
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
require_once("../config.php");
if (isset($_POST["btnsub"]))
{
    $cat=$_POST["txtCatname"];
   $s=$con->prepare("INSERT INTO `tb_cat`(`cname`) VALUES ('$cat')");
  $s->execute();
  $cnt=$s->rowCount();
  if($cnt==1)
  {
    echo $cnt;
    ?>
    <script type="text/javascript">
      window.location="index.php";
      </script>
    <?php
  }
}
    ?>
    <script type="text/javascript">
     function del(catid)
     {
      $.ajax({
                url:"ajaxcmp.php",
                type:"post",
                data:{type:5,catid:catid},
                success:function(data)
                {
                  window.location.reload();
                }
        });
     }
    </script>
</body>
</html>
<?php
ob_end_flush();
?>

