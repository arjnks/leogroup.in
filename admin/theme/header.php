<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $pagename; ?> Admin panel</title>
<script type="text/javascript" src="./theme/calendar/jsDatePick.min.1.3.js"></script>	
<link rel="stylesheet" type="text/css" media="all" href="./theme/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="./theme/lightbox.css" type="text/css" media="screen" />
<style type="text/css" >
/*<![CDATA[*/
<?php include('./theme/style.css');?>
/*]]>*/
</style>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%M %d, %Y"
			
		});

	new JsDatePick({
			useMode:2,
			target:"date2",
			dateFormat:"%M %d, %Y"
			
		});
		
	new JsDatePick({
			useMode:2,
			target:"date3",
			dateFormat:"%Y-%m-%d"
			
		});
		
	};
	
function go_topage(page,val){	window.location.href=page+val;}

	</script>
<?php enc();?>
<!-- Opening <div header>-->
<div id="header" style=" height:89px; ">
<!-- logo -->
<div style="height:120px; margin-top:-5px;"><img height="90" src="../images/logo.png">
<span style="float:right; padding-right:10px; line-height:19px; color:#18199B; font-weight:bold; font-size:11px"><?php echo "IP : $ip <br> Date : ".date('d - M, Y') ."<br> Time : ".date('h :i a'); ?></span> </div>
</div>
<!-- closing <div header>-->
<!-- Opening <div navigation>-->
<div id="navigation">
<?php if(isset($_SESSION['adminlogin'])) {?>
<div class="left">Logged in as <b> Admin</b></div>
<a href="./">Home</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="./?p=logout" >Logout</a>
<?php } else { echo '<br />';}?>
</div>
<!-- closing <div navigation>-->
<!-- Opening <div page>-->
<div id="page">
<br />