<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Leo Group</title>
    <!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">
</head>
<body>
<a data-toggle="tooltip" data-placement="top" title="Call Us" href="tel:+91 9605 068 517"><div class="call-fixed"><img class="fixed-call" src="img/ftr-call.png"></div></a>
<a data-toggle="tooltip" data-placement="top" title="Find Us" href="https://goo.gl/maps/fBHKLuAuvco" target="_blank"><div class="mail-fixed"><img class="fixed-path" src="img/map-icon4.png"></div></a>
<a class="mail-ico5" data-toggle="modal" data-target="#myModal"><div class="gmap-fixed"><img class="fixed-mail" src="img/mail-ftr.png"></div></a>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="margin-top: 13%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Quick Enquiry</h4>
        </div>
		<form method="post" id="frmenq">
        <div class="modal-body">
         <div class="col-md-4">
		 	<div class="form-group">
					    	<input type="text" class="form-control" id="name" placeholder="Your Name">
				  		</div>
		 </div>
         <div class="col-md-4">
		 	<div class="form-group">
				t	    	<input type="text" class="form-control" id="email" placeholder="Your Email ID">
				  		</div>
		 
		 </div>
         <div class="col-md-4">
		 	<div class="form-group">
					    	<input type="text" class="form-control" id="phone" placeholder="Your Phone Number">
				  		</div>
		 
		 </div>
		   <div class="col-md-12">
		 	<div class="form-group">
					    	<textarea  class="form-control" rows="4" cols="50" id="msg" placeholder="Enter Your Message"></textarea>
		  		</div>
		 
		 </div>
		 
		 
		 
		 
		 <div class="col-md-9 no-padding">
		 
		 <div class="col-md-5">
	<div class="form-group">
	
	 <input name="cap" id="cap" type="text" class="form-control" placeholder="Enter captcha"  />
              </div>
	
	</div>
	<div class="col-md-4 col-xs-4">
	  <img style="margin-top: 5px;" class="refresh_ico" width="101px" height="39px" src="numbercaptcha/image2.php" id="visit_captcha56" />
	</div>
	
		<div class="col-md-3">
	<div class="form-group">
	

 <a href="javascript:void();" onclick="var c='numbercaptcha/image2.php?'+Math.random();
            document.getElementById('visit_captcha56').src=c;document.getElementById('captcha').src=c;
            " id="change-image"><img class="refresh_ico" src="img/refresh.png" style="margin-top: 8px;" width="33" height="33" title="change image"  alt="" /></a>


	</div>
		 
		 
		 
		 </div>
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		
        </div>
		
		
		 
		 		   <div class="col-md-3">
		 <button type="button" onclick="sndmsg()" class="btn btn-default submit pull-right"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Send Message</button>
		 
		 </div>
    
      </div>
</form>
</div>
</div>
</div>
<div class="preloader"></div><!-- /.preloader -->

<section class="top-bar">
	<div class="container-fluid">
		<div class="contact-info pull-left animated fadeInLeft">
			<a href="#"><i class="fa fa-envelope"></i> sidharthram@leogroup.in</a><!--
			--><a href="tel:9605068517"><i class="fa fa-phone"></i> +91 9605 068 517</a> , <a href="tel:04872355333" style="margin-left: 10px;">0487 235 5333</a>
		</div><!-- /.contact-info pull-left -->
		<div class="social pull-right animated wobble">
			<a href="https://www.facebook.com/leogroupthrissur" target="_blank" class="fa fa-facebook"></a><!--
			--><a href="#" class="fa fa-twitter"></a><!--

		</div><!- /.social -->
	</div><!-- /.container-fulid -->
</section><!-- /.top-bar -->

<header class="header header-fixed header-1 stricky">
	<nav class="navbar navbar-default header-navigation ">
	    <div class="container-fluid">
	        <!-- Brand and toggle get grouped for better mobile display -->
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-bar" aria-expanded="false">
	                <span class="sr-only">Toggle navigation</span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </button>
	            <a class="navbar-brand animated left" href="index-2.html" >
	                <img src="img/logo.png" alt="Awesome Image"style="margin-left: -20px;"/>
	            </a>
	        </div>

	        <!-- Collect the nav links, forms, and other content for toggling -->
	        <div class="collapse navbar-collapse animated fadeInRight" id="main-nav-bar" >	            
	            <ul class="nav  navbar-nav navigation-box main-navigation mainmenu navbar-right">
	                <li class="<?php if($currentPage =='index'){echo 'current';}?>">
	                    <a href="index.php">Home</a>
	                </li>
	                 <li class="<?php if($currentPage =='about'){echo 'current';}?>">
	                    <a href="about.php">About Us</a>                    
	                </li>
	                 <li class="<?php if($currentPage =='superstockists'){echo 'current';}?>">
	                    <a href="#">Our Clients</a>                    
                        <ul class="sub-menu">                           
                            <li><a href="c_and_f_superstockists.php">C & F Agents / Superstockists</a></li>

                            <li><a href="whoelsale_distribution.php">Wholesale Distribution</a></li>
                           <li><a href="redistribution.php">Redistribution</a></li>
                            <li><a href="other_brands.php">Other Brands</a></li>
                            <li><a href="#">Logistics</a></li>
    
                        </ul><!-- /.sub-menu -->
	                </li>
	                 <li class="<?php if($currentPage =='speciality'){echo 'current';}?>"><a href="#">Specialty/Life Saving Drugs</a>
	                 	 <ul class="sub-menu">                           
                            <li><a href="emaxbio.php">E-Max Biogenics</a></li>
                        </ul>

	                 </li>
	               <li class="<?php if($currentPage =='infrastructure'){echo 'current';}?>">
	                    <a href="infrastructure.php">Infrastucture</a>                    
	             
	                </li>
					     <li class="<?php if($currentPage =='logistics'){echo 'current';}?>">
	                    <a href="logistics.php">Logistics</a>                    
	             
	                </li>
					      <li class="<?php if($currentPage =='team'){echo 'current';}?>">
	                    <a href="team.php">Our Team</a>                    
	             
	                </li>
	            
	                <li class="<?php if($currentPage =='gallery'){echo 'current';}?>">
	                    <a href="gallery.php">Gallery</a>                    
	                </li>
	            </ul>	            
	        </div><!-- /.navbar-collapse -->

	 
	    </div><!-- /.container-fluid -->
	</nav>
	<script type="text/javascript">
		function sndmsg()
		{
			var capt=$("#cap").val();
			var email=$("#email").val();
			var name=$("#name").val();
			var phn=$("#phone").val();
			var msg=$("#msg").val();
			$.ajax({
				url:"ajaxanju.php",
				type:"post",
				data:{type:1,capt:capt,email:email,name:name,phn:phn,msg:msg},
				success:function(data)
				{
					$("#cap").val("");
					if(data==1)
					{
						alert("Wrong Captcha Please Refresh Captcha")
					}
					else
					{
						document.getElementById('frmenq').reset();
						alert(data);
					}
				}
			})
		}
	</script>	
</header>