<?php
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
font-size: 16px;"> <a href="#" class="btn btn-danger square-btn-adjust">Logout</a> </div>
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
                        <a   href="add-image.php"><i class="fa fa-edit fa-2x"></i> Add Gallery </a>
                    </li>				
					<li>
                        <a class="active-menu" href="add-company.php"><i class="fa fa-users"></i>Add Client</a>
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
                     <h2>Add Client</h2>   
                      
                       
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
                                <div class="col-md-12" id="client">
                             
                                    <form role="form" method="post">
                                     <div class="col-md-3">
                                     <div class="form-group">
                                            <label>Select Group</label>
                                            <select class="form-control" name="selgrp">
                                              <option>Select Group</option>
                                                <option value="1">C & F Agents / Superstockists </option>
                                                <option value="2">LEO DISTRIBUTORS</option>
                                                <option value="3">LEO ENTERPRISES</option>
                                                <option value="4">ARIES ENTERPRISES</option>
                                            </select>
                                        </div>
										</div>
										
										    <div class="col-md-12">
										    <div class="form-group col-md-3" style="margin-left: -14px;">
                                            <label>Client Name</label><br> 
                                          <input type="text" name="txtCname" class="form-control">
                                        </div>
										 </div>
										     <div class="col-md-12">
                                 <div class="form-group mgtp25" style="margin-top:19px;">
                                    
                                        <button type="submit" class="btn btn-default" name="btnlog">Submit</button>
                                
</div>
</div>
					
                             
                                    </form>
                                    <br />
                                   
     

                                 
    </div>
                          
                             
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                      <table class="table table-striped table-bordered" >
                        <thead>
                          <th>Company Name</th>
                          <th>Group</th>
                          <th>Action</th>
                        </thead>
                        <tbody>
                          <?php 
                          require_once("../config.php");
                          $sel=$con->prepare("select * from tb_client");
                          $sel->execute();
                          while ($row=$sel->fetch(PDO::FETCH_ASSOC))
                           {
                            if($row["catid"]=='1')
                              $grp="C & F Agents / Superstockists";
                            elseif ($row["catid"]=='2') 
                              $grp="LEO DISTRIBUTORS";
                             elseif ($row["catid"]=='3') 
                              $grp="LEO ENTERPRISES";
                             elseif ($row["catid"]=='4') 
                              $grp="ARIES ENTERPRISES"; 
                          ?>
                          <tr>
                            <td><?php echo $row["name"]?></td>
                            <td><?php echo $grp;?></td>
                            <td>   <button class="btn btn-warning btn-xs" onclick="edit(<?php echo $row["cid"];?>)">Edit</button>    
                      <button class="btn btn-info btn-xs" onclick="del(<?php echo $row["cid"];?>)">Delete</button></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                      
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
if(isset($_POST["btnlog"]))
{
  $name=$_POST["txtCname"];
  $grp=$_POST["selgrp"];
  $s=$con->prepare("INSERT INTO `tb_client`(`catid`, `name`) VALUES ('$grp','$name')");
  $s->execute();
  $cnt=$s->rowCount();
  if($cnt==1)
  {
    ?>
    <script type="text/javascript">
      window.location="add-company.php";
      </script>
    <?php
  }
}
    ?>
   <script type="text/javascript">
     function edit(cid)
     {
        $.ajax({
                url:"ajaxcmp.php",
                type:"post",
                data:{type:1,cid:cid},
                success:function(data)
                {
                  $("#client").html(data);
                }
        });
     }
     function del(cid)
     {
       $.ajax({
                url:"ajaxcmp.php",
                type:"post",
                data:{type:2,cid:cid},
                success:function(data)
                {
                  window.location.reload();
                }
        });
     }
     function upd(cid)
     {

       var grup=$("#selgrp").val();
       var name=$("#txtCname").val();
       $.ajax({
                url:"ajaxcmp.php",
                type:"post",
                data:{type:3,cid:cid,grup:grup,name:name},
                success:function(data)
                {
                window.location.reload();
                }
        });
     }
   </script>
</body>
</html>

 