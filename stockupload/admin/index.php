<?php
session_start();
include('../include/db.php');
error_reporting(0);
date_default_timezone_set("Asia/Kolkata");

#800000

// init variables
	$min_number = 1;
	$max_number = 15;

	// generating random numbers
	$random_number1 = mt_rand($min_number, $max_number);
	$random_number2 = mt_rand($min_number, $max_number);



if(isset($_POST['submit'])) 
{


		$captchaResult = $_POST["captchaResult"];
		$firstNumber = $_POST["firstNumber"];
		$secondNumber = $_POST["secondNumber"];

		$checkTotal = $firstNumber + $secondNumber;

		if ($captchaResult == $checkTotal) 
		{
			
			if (!empty($_POST['username']) && !empty($_POST['password'])) 
			{
			$username=$_POST['username'];
			$password=md5($_POST['password']);
			$sql_select="SELECT * FROM login_tb WHERE username='$username' AND password='$password'";

						$stmt_select=$db_con->prepare($sql_select);
						//$stmt_select->bindparam('username',$username);
						//$stmt_select->bindparam('password',$password);
						$stmt_select->execute();

						$count=$stmt_select->rowCount();
							$resultset = $stmt_select->fetch(PDO::FETCH_ASSOC);
							if($count==1)
								{


								$date=date("y-m-d");
								$time=date("h:i:m");
								$_SESSION['log_id']=$resultset['log_id'];
								$_SESSION['username']=$resultset['username'];
								$_SESSION['status']=$resultset['status'];
							
								
								header('location:home.php');
								}
								
								
							else

							{
						echo '<script> alert("username or password does not match");</script>';
							}
						
						}
						}
						
						else 	{
									echo '<script> alert("Wrong Captcha. Try Again");</script>';
									
								}
}				


?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title></title>
   
        <link rel="stylesheet" href="../css/login.css">

  </head>

  <body>
<!-- Header -->
<div id="header">
	<div class="shell">
		<!-- Logo + Top Nav -->
		<div id="top">
			<br><br>
			<h1><font color="white"></font></h1>
			
		</div>
		<!-- End Logo + Top Nav -->
		<!-- Main Nav -->
		
		</div>
		<!-- End Main Nav -->
	</div>
</div>
<!-- End Header -->
    <div class="wrapper">
	<div class="container">
		<h1><font color="#800000">Login</font></h1>
		
		<form class="form" name="user_login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" 
        method="post">
			<input type="text" placeholder="Username" value="" name="username" />
			<input type="password" placeholder="Password" value="" name="password" />
            <?php echo $random_number1 . ' + ' . $random_number2 . ' = ?'; ?>
			<input name="captchaResult" type="text" size="2" 
            placeholder="<?php echo $random_number1 . ' + ' . $random_number2 . ' = ?'; ?>"/>
			<input name="firstNumber" type="hidden" value="<?php echo $random_number1; ?>" />
			<input name="secondNumber" type="hidden" value="<?php echo $random_number2; ?>" />
            
			<button type="submit" name="submit">Login</button>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
        <li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="../js/index.js"></script>

    
    
    
  </body>
</html>
