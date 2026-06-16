<div class="ftr-brd" style="width:50%;background-color:#557f3a;height:8px;float:left;"></div>
<div class="ftr-brd" style="width:50%;background-color:#00619a;height:8px;float:left;"></div>
<footer class="footer">
	<div class="container">
	<div class="row">
		<div class="col-md-4">
		<a href="#" class="footer-logo"><img class="img-responsive" src="img/footer-logo.png" alt="Awesome Image"/></a>

		</div>
		<div class="col-md-8">
		<div class="footer-menu">
		<ul>
		<li class="<?php if($currentPage =='index'){echo 'footer-active';}?>"><a href="index.php">home<a/></li>
		<li class="<?php if($currentPage =='about'){echo 'footer-active';}?>"><a href="about.php">About Us<a/></li>
		<li class="<?php if($currentPage =='superstockists'){echo 'footer-active';}?>"><a href="superstockists.php">Our Clients<a/></li>
		<li class="<?php if($currentPage =='infrastructure'){echo 'footer-active';}?>"><a href="infrastructure.php">Infrastructure<a/></li>
		<li class="<?php if($currentPage =='logistics'){echo 'footer-active';}?>"><a href="logistics.php">Logistics<a/></li>
		<li class="<?php if($currentPage =='team'){echo 'footer-active';}?>"><a href="team.php">Our Team<a/></li>
		<li class="<?php if($currentPage =='gallery'){echo 'footer-active';}?>"><a href="gallery.php">Gallery<a/></li>
		</ul>
		
		</div>
		</div>
	
	</div>
		<div class="row">
	
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="footer-widget about-widget">
<div class="title">
					<h3>CONTACT US</h3>
					</div>

<div class="adrs">
<p>Leo Logistics Park, NH Bypass Junction,
Kuttanellur, Thrissur , 680014</p>


</div>

<div class="tel">
<p>Tel : <a href="tel:9605 068 517">+91 9605 068 517</a>, <a href="tel:0487 235 5333">0487 235 5333</a> </p>
<p>Fax : +91 487 2441722</p>
<p>Email : sidharthram@leogroup.in</p>

</div>





</div><!-- /.footer-widget -->



			</div><!-- /.col-md-3 -->
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="footer-widget link-widget">
					<div class="title" style="margin-bottom: 28px;">
						<h3>Reach Us</h3>
					</div><!-- /.title -->
				<div class="gmap">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31383.19257474634!2d76.21706748717999!3d10.50861521625528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba7ee460b30228b%3A0xc2bd71f1a4a95ed!2sLeo!5e0!3m2!1sen!2sin!4v1545346792288" width="100%" height="190" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				</div><!-- /.footer-widget -->
			</div><!-- /.col-md-2 -->
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="footer-widget social-widget">
					<div class="title">
						<h3>Gallery</h3>
					</div><!-- /.title -->
			<div class="gallery_block">
			<a href="gallery.php">
			<img class="img-responsive" src="img/ftr-glry.jpg">
			</a>
			</div>
			
				</div><!-- /.footer-widget -->
			</div><!-- /.col-md-4 -->
		
		</div><!-- /.row -->
		
		<div class="row footer2">
		<div class="col-md-6">
		<div class="adrs-menuftr">


</div>
		
		</div>
		
			<div class="col-md-6">
			<div class="copy-rt">
			<p>Copyright © 2018 - Leo Group | Powered by <a href="http://programersglobal.com/" target="_blank">PROGRAMERS</a></p>
			
			</div>
			</div>
		
		
		</div>
		
		
	</div><!-- /.container -->

</footer><!-- /.footer -->

<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-double-up"></span></div>

<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<!-- <script src="http://code.jquery.com/jquery-latest.min.js"></script> -->
<script src="assets/jquery.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){

      var list = $(".list li");
      var numToShow = 10;
      var button = $("#next");
      var numInList = list.length;
      list.hide();
      if (numInList > numToShow) {
        button.show();
      }
      list.slice(0, numToShow).show();

      button.click(function(){
          var showing = list.filter(':visible').length;
          list.slice(showing - 1, showing + numToShow).fadeIn();
          var nowShowing = list.filter(':visible').length;
          if (nowShowing >= numInList) {
            button.hide();
          }
      });

});
	
	</script>
	
	
<script>
	$(document).ready(function(){

      var list = $(".gallery_list li");
      var numToShow = 8;
      var button = $("#next");
      var numInList = list.length;
      list.hide();
      if (numInList > numToShow) {
        button.show();
      }
      list.slice(0, numToShow).show();

      button.click(function(){
          var showing = list.filter(':visible').length;
          list.slice(showing - 1, showing + numToShow).fadeIn();
          var nowShowing = list.filter(':visible').length;
          if (nowShowing >= numInList) {
            button.hide();
          }
      });

});
	
	</script>
<script src="assets/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="assets/owl.carousel-2/owl.carousel.min.js"></script>
<script src="assets/isotope.js"></script>
<script src="assets/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script src="assets/waypoints.min.js"></script>
<script src="assets/jquery.counterup.min.js"></script>
<script src="assets/wow.min.js"></script>
<script src="assets/nouislider/nouislider.js"></script>
<script src="assets/bootstrap-touch-spin/jquery.bootstrap-touchspin.js"></script>
<script src="js/custom.js"></script>

</body>

<!-- Mirrored from html.tonatheme.com/2018/brentcreek/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Dec 2018 19:44:08 GMT -->
</html>