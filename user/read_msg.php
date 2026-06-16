<div id="chitties">
    <?php 
	echo '<label class="blue">Inbox - ';			
	$msg_id = $_GET['text'];
	$qr_led = "select * from `message` where `id`='$msg_id'";
	$qqa = leo_mysql_query($qr_led);
	$num = leo_mysql_num_rows($qqa);
	if($num>0)
	{	
	$res = leo_mysql_fetch_assoc($qqa); echo $res['subject'].'</label><br/>';							
	?>        
        <div class="ledg_tabl" style="background:#FFFFFF; text-align:left;">
		<div style="border-bottom:#999999 1px dashed; margin-left:10px; float:left; margin-right:10px; line-height:25px; min-height:30px; width:880px;">&nbsp;
        <span style=" float:left; font-size:13px;"><b><?php echo $res['subject']; ?></b></span>
        <span style=" float:right; font-size:12px;">
        <img border="0" style="margin-bottom:0px;" height="11" src="../images/clock.png" ><?php echo date(' h:i a ',$res['time']); ?>&nbsp;
        <img border="0" style="margin-bottom:-2px;" height="13" src="../images/calender.png" > <?php echo date(' d - M, Y',$res['time']); ?></span></div>
        <br clear="all" />
		<div style="padding-left:10px; font-size:13px; line-height:18px; padding-right:10px; text-align:justify; margin:10px 0px 10px 0px;">
		<?php echo $res['message']; ?></div></div>  
	<?php	
    }	
    else
    { echo ' </label><br/>';	}	
    ?>
    <div id="hover_btns" style="width:500px; margin-top:-5px;">
    <div style="width:100px; float:left; line-height:28px;" onClick="goto_href('compose');" class="user_btns">
    <img border="0" style="margin-bottom:-5px;" height="18" src="../images/reply.png"> &nbsp; Reply</div>
    <div style="width:100px; float:left; margin-left:5px; line-height:28px;" onClick="delete_mail('<?php echo $res['id']; ?>');" class="user_btns">
    <img border="0" style="margin-bottom:-3px;" height="16" src="../admin/theme/images/delete.png"> &nbsp; Delete</div>
    </div><br clear="all">
    <div style="clear:both; height:5px;"></div>
    </div>