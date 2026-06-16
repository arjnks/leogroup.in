<?php
$currentPage = 'gallery';
include("header.php");
include("config.php");
$catid=$_GET["catid"];
$sel=$con->prepare("select * from tb_cat WHERE catid='$catid'");
 $sel->execute();
 $row=$sel->fetch(PDO::FETCH_ASSOC);
?>

<section class="inner-banner">
    <div class="container text-center">
        <h2>Gallery</h2>
      
    </div><!-- /.container -->
</section><!-- /.inner-banner -->

<section class="about-area sec-pad pb0" style="padding-bottom: 15px;">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
		<div class="glry_title text-left">
		<h4><b><?php echo $row["cname"];?></b></h4>
	
		
		</div>
			</div>
			
		
			
			

		</div><!-- /.row -->
		
	
	
			
	
			
	
		
		</div>
		
	</div><!-- /.container -->
</section><!-- /.about-area -->










<section class="gallery-section sec-pad" style="height: auto;">
	<div class="container">

		<div class="masonary-layout row filter-layout gallery-wrapper" data-filter-class="filter">
		<ul class="list gallery_list" style="position:relative !important;">
			<?php
	 $sell=$con->prepare("select * from tb_gallery WHERE catid='$catid'");
     $sell->execute();
     while($res=$sell->fetch(PDO::FETCH_ASSOC))
     {
			?>
			<li class="col-md-3 col-sm-6 col-xs-12 masonary-item single-filter-item busniess">
				<div class="single-gallery">
					<img class="img-responsive" src="<?php echo "piback/".$res["path"];?>" alt="Awesome Image"/>
					<div class="overlay">
						<div class="content">
							<div class="box">
								<div class="icon-box">
								<a href="<?php echo "piback/".$res["path"];?>" class="img-popup"><i class="fa fa-search"></i></a><!--
								
								</div><!/.icon-box -->
							
							</div><!-- /.box -->
						</div><!-- /.content -->
					</div><!-- /.overlay -->
				</div><!-- /.single-gallery -->
				</div>
			</li><!-- /.col-md-4 -->
			<?php }?>
			</ul>
		</div><!-- /.masonary-layout --> 
		
		
			<div class="col-md-12">
	  <button class="btn btn-danger btn-rd" id="next" style="margin-top: 41px;">View More</button>
	</div>
		
	</div><!-- /.container -->
</section><!-- /.gallery-section -->




<?php

include("footer.php");

?>








