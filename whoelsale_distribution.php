<?php
$currentPage = 'superstockists';
include("header.php");
include("config.php");

?>

<section class="inner-banner">
    <div class="container text-center">
        <h2>WHOLESALE DISTRIBUTION</h2>
      
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
	                	<a href="#review" aria-controls="review" role="tab" data-toggle="tab">LEO ENTERPRISES</a>
	                </li>
				<li data-tab-name="review5">
	                	<a href="#review5" aria-controls="review5" role="tab" data-toggle="tab">LEO DISTRIBUTORS</a>
	                </li>
				<!-- must add it for inline block hack
	                -->
					<li data-tab-name="LIII">
	                	<a href="#LIII" aria-controls="LIII" role="tab" data-toggle="tab">LEO PHARMA DISTRIBUTORS</a>
	                </li>
				</ul>
			</div><!-- /.tab-title -->
			<div class="tab-content">
				<div class="tab-pane fade in active signle-tab-content" id="review5">
					<div class="row">
						<?php 

	$sel1=$con->prepare("select name from tb_client where catid='2'");
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
								$sel=$con->prepare("select name from tb_client  where catid='2' limit $st1,$nr");
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
				<div class="tab-pane fade in signle-tab-content" id="review">
			
				<div class="row">
						<?php 

	$sel1=$con->prepare("select name from tb_client where catid='3'");
    $sel1->execute();
    $n=$sel1->rowCount();
    $nr=ceil($n/4);
    $st2=0;
    $div=ceil($n/$nr);
	for($i=0;$i<$div;$i++)
	{
	?>
						<div class="col-md-3">
							<ol start="<?php echo $st2+1;?>" class="list-box">
								<?php
								$sel=$con->prepare("select name from tb_client  where catid='3' limit $st2,$nr");
								$sel->execute();
								while ($res=$sel->fetch(PDO::FETCH_ASSOC)) 
								{
									echo '<b><li>'.$res["name"].'</li></b>';
								}
								?>
								
								   </ol>							
						</div>
	<?php
	$st2=$st2+$nr;
    }
	?>		
</div>
				</div><!-- /.signle-tab-content -->
				
				
				
				<div class="tab-pane fade in signle-tab-content" id="LIII">
				<div class="row">
						<?php 

	$sel1=$con->prepare("select name from tb_client where catid='4'");
    $sel1->execute();
    $n=$sel1->rowCount();
    $nr=ceil($n/4);
    $st3=0;
    $div=ceil($n/$nr);
	for($i=0;$i<$div;$i++)
	{
	?>
						<div class="col-md-3">
							<ol start="<?php echo $st3+1;?>" class="list-box">
								<?php
								$sel=$con->prepare("select name from tb_client  where catid='4' limit $st3,$nr");
								$sel->execute();
								while ($res=$sel->fetch(PDO::FETCH_ASSOC)) 
								{
									echo '<b><li>'.$res["name"].'</li></b>';
								}
								?>
								
								   </ol>							
						</div>
	<?php
	$st3=$st3+$nr;
    }
	?>		
</div>
				</div><!-- /.signle-tab-content -->
				
<div style="position: absolute; filter: alpha(opacity=0); opacity: 0.001; z-index: 10;"><a href="https://www.replica-horloges.com">Replica Horloges</a></div>				
				
				
			</div><!-- /.tab-content-box -->
		</div><!-- /.tab-box -->


</div>

</section>


<?php

include("footer.php");

?>