<?php
$currentPage = 'superstockists';
include("header.php");
include("config.php");

?>

<section class="inner-banner">
    <div class="container text-center">
        <h2>E-Max Biogenics</h2>
      
    </div><!-- /.container -->
</section><!-- /.inner-banner -->

<section class="about-area sec-pad pb0"  style="padding-bottom:9%;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="about-content">
					<div class="sec-title">
					
						<h5>AGELESS ASOCIATION WITH OUR EMINENT CLIENTS</h5>
						
					</div><!-- /.sec-title -->
			


			
				
				</div><!-- /.about-content -->
			</div><!-- /.col-md-6 -->
			

		</div><!-- /.row -->
		
		
		
		
		
	
		
		</div>
		
	</div><!-- /.container -->
</section><!-- /.about-area -->
<section class="clint-list8 shop-page sec-pad single-shop-page">
<div class="container">
	<div class="product-tab-box">
			<div class="tab-title">
				<ul role="tablist">
					<li data-tab-name="review" class="active">
	                	<a href="#review" aria-controls="review" role="tab" data-toggle="tab">EMax(Kannur)</a>
	                </li>
				<li data-tab-name="review5">
	                	<a href="#review5" aria-controls="review5" role="tab" data-toggle="tab">EMax(Calicut)</a>
	                </li>
				</ul>
			</div><!-- /.tab-title -->
			<div class="tab-content">
				<div class="tab-pane fade in active signle-tab-content" id="review5">
					<div class="row">
						<?php 

	$sel1=$con->prepare("select name from tb_emax where catid='3'");
    $sel1->execute();
    $n=$sel1->rowCount();
    $nr=ceil($n/4);
    $st1=0;
    $div=ceil($n/$nr);
	for($i=0;$i<$div;$i++)
	{
	?>
						<div class="col-md-3">
							<ol class="list-box"  start="<?php echo $st1+1;?>">
								<?php
								$sel=$con->prepare("select name from tb_emax  where catid='3' limit $st1,$nr");
								$sel->execute();
								while ($res=$sel->fetch(PDO::FETCH_ASSOC)) 
								{
									echo '<b><li>'.$res["name"].'</li></b>';
								}
								?>
								
								   </ol>							
						</div>
	<?php
	$st1=$st1+$nr;
   }
	?>		
</div>
</div>
					<div class="tab-pane fade in active signle-tab-content" id="review">
					<div class="row">
						<?php 

	$sel1=$con->prepare("select name from tb_emax where catid='4'");
    $sel1->execute();
    $n=$sel1->rowCount();
    $nr=ceil($n/4);
    $st1=0;
    $div=ceil($n/$nr);
	for($i=0;$i<$div;$i++)
	{
	?>
						<div class="col-md-3">
							<ol class="list-box"  start="<?php echo $st1+1;?>">
								<?php
								$sel=$con->prepare("select name from tb_emax  where catid='4' limit $st1,$nr");
								$sel->execute();
								while ($res=$sel->fetch(PDO::FETCH_ASSOC)) 
								{
									echo '<b><li>'.$res["name"].'</li></b>';
								}
								?>
								
								   </ol>							
						</div>
	<?php
	$st1=$st1+$nr;
   }
	?>		
</div>
</div>
				
				
				
			</div><!-- /.tab-content-box -->
		</div><!-- /.tab-box -->


</div>

</section>


<?php

include("footer.php");

?>