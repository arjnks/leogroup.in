<?php
$currentPage = 'superstockists';
include("header.php");
include("config.php");
?>

<section class="inner-banner">
    <div class="container text-center">
        <h2>C & F Agents / Superstockists</h2>
      
    </div><!-- /.container -->
</section><!-- /.inner-banner -->

<section class="about-area sec-pad pb0" style="padding-bottom:0;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="about-content">
					<div class="sec-title">
					
						<h5>AGELESS ASOCIATION WITH OUR EMINENT CLIENTS</h5>
						<h6 class="font-title2">We are C&F Agents / Superstockists for all Kerala operations of 20 companies, including</h6>
					</div><!-- /.sec-title -->
			


			
				
				</div><!-- /.about-content -->
			</div><!-- /.col-md-6 -->
			

		</div><!-- /.row -->
		
		
		
				<div class="row">
				<div class="col-md-12">
		<div class="wrapper cl-list">
	 <ul class="list">
	 	<?php
                              $selq=$con->prepare("SELECT * FROM tb_logo");
                              $selq->execute();
                              while($row=$selq->fetch(PDO::FETCH_ASSOC))
                              {
                              	?>
     <li><img class="logo-img" src="piback/<?php echo $row['path']; ?>"></li>
     <?php
     	}
     ?>
  </ul>

</div>
		</div>
		
		<div class="col-md-12">
	  <button class="btn btn-danger btn-rd" id="next">View More</button>
	</div>
		
</div>
		
	
		
		</div>
		
	</div><!-- /.container -->
</section><!-- /.about-area -->

<section>
<div class="cln">
<div class="container">
<div class="row">
	<?php 

	$sel1=$con->prepare("select name from tb_client where catid='1'");
    $sel1->execute();
    $n=$sel1->rowCount();
    $nr=ceil($n/3);
    $st=0;
    $div=ceil($n/$nr);
	for($i=0;$i<$div;$i++)
	{
	?>
						<div class="col-md-4">
							<ol  class="list-box"  start="<?php echo $st+1;?>">
								<?php
								$sel=$con->prepare("select name from tb_client where catid='1' limit $st,$nr");
								$sel->execute();
								while ($res=$sel->fetch(PDO::FETCH_ASSOC)) 
								{
									echo '<b><li>'.$res["name"].'</li></b>';
								}
								?>
								
								   </ol>							
						</div>
	<?php
	$st=$st+$nr;
    }
	?>					

</div>
</div>
</div>
</section>


<?php

include("footer.php");

?>