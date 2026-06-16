<?php
$currentPage = 'gallery';
include("header.php");
include("config.php");
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
		<h4>All Albums</h4>
	
		
		</div>
			</div>
			
			
			

		</div><!-- /.row -->
		
	
	
			
	
			
	
		
		</div><!-- /.container -->
</section><!-- /.about-area -->










<section class="gallery-section sec-pad" style="height: auto;">
	<div class="container">
	<div class="gallery-all" style="min-height:500px;padding:50px 0px;">
<?php 
  $sel=$con->prepare("select *  from tb_cat");
 $sel->execute();
 while($row=$sel->fetch(PDO::FETCH_ASSOC))
 {
 	 $sell=$con->prepare("select * from tb_gallery WHERE catid='$row[catid]'");
     $sell->execute();
     $res=$sell->fetch(PDO::FETCH_ASSOC);
?>
<div class="col-md-3">
<div class="gl-title">
<div class="gl_all">
<img class="img-responsive img-wt-bord skw-1" src="img/gallery/9.jpg">
<img class="img-responsive img-wt-bord skw-3" src="img/gallery/12.jpg">
<img class="img-responsive img-wt-bord skw-2" src="<?php echo "piback/".$res["path"];?>">

</div>
</div>
<div class="clearfix"></div>
<div class="glr-titls" onclick="gallery(<?php echo $row["catid"];?>)"><h4><?php echo $row["cname"]?></h4></div>
</div>
<?php } ?>



	
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	</div><!-- /.container -->
</section><!-- /.gallery-section -->

<script type="text/javascript">
	function gallery(catid)
	{
		window.location="gallery2.php?catid="+catid;
	}
</script>


<?php

include("footer.php");

?>








