<?php
if(!isset($_SESSION)){
session_start();
}
error_reporting(0);
include('../include/db.php');

if(isset($_POST['username'])){
	
	
	if(isset($_POST['cuname']) && isset($_POST['nuname']) && isset($_POST['cfname'])) {
	
	
	$cuname	=	$_POST['cuname'];
	$nuname	=	$_POST['nuname'];
	$cfname	=	$_POST['cfname'];
	
	$sel_username	=	"SELECT * FROM login_tb WHERE username='$cuname' AND status=1";
	$stm_username	=	$db_con->prepare($sel_username);
	$stm_username	->	execute();
	
	$r_count	=	$stm_username->rowCount();
	
	if($r_count==1){
		
		
		$up_username	=	"UPDATE login_tb SET username='$nuname' WHERE username='$cuname' AND status=1";
		$up_username	=	$db_con->prepare($up_username);
		$up_username	->	execute();
		
		?>
		<script>
			alert("Username successfully changed");
			window.location.href="password_change.php";
		</script>
		
		<?php
		
	}
	
	else{
		?>
		<script>
			alert("Sorry!! ");
			window.location.href="password_change.php";
		</script>
		
		<?php
	}
	
}
else{
	?>
		<script>
			alert("Please fill all fields");
			window.location.href="password_change.php";
		</script>
		
		<?php
}
}

if(isset($_POST['password'])){
	
	if(isset($_POST['cpwd']) && isset($_POST['npwd']) && isset($_POST['cfpwd'])) {
	
	$cpwd	=	md5($_POST['cpwd']);
	$npwd	=	md5($_POST['npwd']);
	$cfpwd	=	$_POST['cfpwd'];
	
	$sel_password	=	"SELECT * FROM login_tb WHERE password='$cpwd' AND status=1";
	$stm_password	=	$db_con->prepare($sel_password);
	$stm_password	->	execute();
	
	$r_count	=	$stm_password->rowCount();
	
	if($r_count==1){
		
		
		$up_password	=	"UPDATE login_tb SET password='$npwd' WHERE password='$cpwd' AND status=1";
		$up_password	=	$db_con->prepare($up_password);
		$up_password	->	execute();
		
		?>
		<script>
			alert("Password successfully changed");
			window.location.href="password_change.php";
		</script>
		
		<?php
		
	}
	
	else{
		?>
		<script>
			alert("Sorry!! ");
			window.location.href="password_change.php";
		</script>
		
		<?php
	}
	
}else
	{
		?>
		<script>
			alert("Please fill all fields");
			window.location.href="password_change.php";
		</script>
		
		<?php
	}	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>leogroup</title>
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
	
	<script>
		function confUsername(){
			
			
			var cfuname	=	document.getElementById('cfuname').value;
			var nuname	=	document.getElementById('nuname').value;
			
		
				if(cfuname!=nuname){
					
					
					document.getElementById('cfuname').value="";
					alert("Username does not match");
				}	
			
		}
		
		function confPassword(){
			
			
			var cfpwd	=	document.getElementById('cfpwd').value;
			var npwd	=	document.getElementById('npwd').value;
			
				if(cfpwd!=npwd){
					
					
					document.getElementById('cfpwd').value="";
					alert("Password does not match");
				}	
			
		}
		
		
	</script>
	
</head>	
	<div id="header">
		<div id="top">
			<br>
                <h1><a style="margin-left: 25px;" href="file_upload.php">Leogroup<h2 style="margin-left: 25px;">StockManagement</h2></a></h1>
              <div id="top-navigation">
              	
              	<br><br>
              		 
                    <a style="margin-right: 150px;" href="../include/logout2.php">Logout</a>
              </div>
            </div>
	</div>
	
	<div id="container">
	<div class="shell">
		<div id="sidebar2">
			
		</div>
		<br><br><br><br>
		<div id="sidebar2">
				<div class="box">
    
					<!-- Box Head -->
					<div class="box-head">
						<h2>Change Username</h2>
					</div>
					<!-- End Box Head -->
                    					
					<form action="password_change.php" method="post">
						
						<!-- Form -->
						<div class="form">
                        
								<p>
									
									<label>Current Username <span></span></label>
									<input type="text" class="field size2" name="cuname" value="" required/>
								</p>	
									
                                <p>
									
									<label>New Username<span></span></label>
									<input type="text" class="field size2" name="nuname" id="nuname" value="" required/>
                                    
								</p>
                                
                                <p>
									
                                   
									<label>Confirm Username<span></span></label>
									<input type="text" class="field size2" name="cfname" id="cfuname" value="" required onchange="confUsername();"/>
									<span id="sp"></span>
								</p>
                                
                                <!-- Form Buttons -->
                                <p class="buttons">
                                    
                                   
                                    <input type="submit" class="button" name="username" value="Change Username" />
                                </p>
                                <!-- End Form Buttons -->
                                
						</div>
						<!-- End Form -->
						
					</form>
                    
               	</div>
				<!-- End Box -->	
         </div><!--sider-->     
         
<!--------------------------------------------------------------------------------------------------------------------------------------------------->

<div id="sidebar1">
				<div class="box">
    
					<!-- Box Head -->
					<div class="box-head">
						<h2>Change Password</h2>
					</div>
					<!-- End Box Head -->
                    					
					<form action="password_change.php" method="post">
						
						<!-- Form -->
						<div class="form">
                        
								<p>
									
									<label>Current Password <span></span></label>
									<input type="password" class="field size2" name="cpwd" id="cpwd" value="" required/>
								</p>	
									
                                <p>
									
									<label>New Password<span></span></label>
									<input type="password" class="field size2" name="npwd" id="npwd" value="" required/>
                                    
								</p>
                                
                                <p>
									
                                   
									<label>Confirm Password<span></span></label>
									<input type="password" class="field size2" name="cfpwd" id="cfpwd" value="" required onchange="confPassword();"/>
								</p>
                                
                                <!-- Form Buttons -->
                                <p class="buttons">
                                    
                                   
                                    <input type="submit" class="button" name="password" value="Change Password" />
                                </p>
                                <!-- End Form Buttons -->
                                
						</div>
						<!-- End Form -->
						
					</form>
                    
               	</div>
				<!-- End Box -->	
         </div><!--sider-->



<!------------------------------------------------------------------------------------------------------------------------------------------------------>         
         
         
            
	</div>
</div>
<!-- End Container -->

</body>
</html>
