<?php
$pagename="Welcome - ";
include('./theme/header.php');?>
<h1>Home</h1>
<!-- Opening <div left>-->
<div id="leftbar" style="width:300px;">
 <img src="../images/packagebuild.gif" />
 
<span class="run_small" style="color:#FFFFFF;">
<strong class="fontbold"><br>Leo Group<br> House of Leo<br></strong>
Pazhaya Nadakkavu,<br>
Thrissur - 680 001, Kerala, India.</strong><br>
Telephone no : +91 487 2422869, 2421653 <br /> Fax : +91 487 2441722<br>
Email : <a style="color:#FFFFFF;" href="mailto:haridas@leogroup.in">haridas@leogroup.in</a></span>


</div>
<!-- closing <div left>-->
<!-- Opening <div content>-->
<br />
<div class="mainmenu">
<ul>
<li><a href="./?p=customers&tab=">Manage Customers</a></li>
<li><a href="./?p=ledger&tab=">Manage Ledger</a></li>
<li><a href="./file_upload.php">Manage Stock</a></li>

<li><a href="./?p=message&tab=sent">Customer Messages</a></li>
<?php /*?><li><a href="./?p=sendmail&tab=">Manage E-Mails</a></li>
<li><a href="./?p=sendsms&tab=">Manage Sms</a></li>  <?php */?>
<?php /*?><li><a href="javascript:alert('This Fecility Temporarily Unavailable');"> Manage E-Mails </a></li>
<?php */?><li><a href="javascript:alert('This Facility not available !');"> Manage Sms </a></li>  
<li><a href="./?p=settings&tab=changepwd">Settings</a></li>
</ul>
</div>
<br />
<?php include('./theme/footer.php');?>
