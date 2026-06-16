<?php
	if (isset($_POST["btnsend"]))
	 {
 		$to =$_POST["to"];
		$subject = $_POST["subject"];
		$txt = $_POST["mesage"];
		if(mail($to,$subject,$txt))
        {?><script type="text/javascript">
         alert("send mail successfuly");
        </script>
     <?php   }
        else {?>
        	<script type="text/javascript"> alert("Error");</script>
         
     <?php   }

	}
?>
<script type="text/javascript">
	window.location="http://leogroup.in/user/?p=compose";
</script>