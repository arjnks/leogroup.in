<script type="text/javascript">

</script>
<div id="chitties">
    <?php 
	echo '<label class="blue"> Compose Message </label><br/>';							
	?>
        <div class="ledg_tabl" style="background:#FFFFFF; text-align:left;">
		<div style="border-bottom:#999999 1px dashed; margin-left:10px; float:left; margin-right:10px; line-height:25px; min-height:30px; width:880px;">&nbsp;
        <span style=" float:left; font-size:13px;"><b> Send a Message to Administrator</b></span>
        <span style=" float:right; font-size:12px;">
        
          &nbsp; 
    
    
        <img border="0" style="margin-bottom:0px;" height="11" src="../images/clock.png" ><?php echo date(' h:i a '); ?>&nbsp;
        <img border="0" style="margin-bottom:-2px;" height="13" src="../images/calender.png" > <?php echo date(' d - M, Y'); ?></span></div>
        <br clear="all" />
		<div style="padding-left:10px; font-size:13px; padding-right:10px; text-align:center; margin:10px 0px 10px 0px;">
        <style> .textbox{font-family:Arial, Helvetica, sans-serif; background:#FFFFFF; font-size:13px;} </style>
        <form action="email.php" name="compose" method="post">
        <table align="center" cellpadding="3" border="0">
        <tr>
        <th style="text-align:left; font-size:12px;">To : </th>
        <th><input name="to" class="textbox" style="width:740px;" value="programerstest@gmail.com" readonly="" type="text"></th>
        </tr>
        <tr>
        <th style="text-align:left; font-size:12px;">Subject :  </th>
        <th><input name="subject" class="textbox" style="width:740px;"  type="text"></th>
        </tr>
        </table>
        <textarea name="mesage" onblur="if(this.value=='')this.value='Enter your message here...';" onclick="if(this.value=='Enter your message here...')this.value='';" class="textbox" style="width:800px;" rows="10">Enter your message here...</textarea>
       
        </div> 
   
    <div id="hover_btns" style="width:500px; margin-top:-5px; margin-left:50px;">
    <div style="width:100px; float:left; line-height:28px;" class="user_btns">
    <button type="submit" name="btnsend" style="background-color: transparent;border: none;margin-top: 3px;color: white;"><img border="0" style="margin-bottom:-2px;" height="18" src="../images/send.png" > &nbsp;<b> Send</b></button></div>
    <div style="width:100px; float:left; margin-left:5px; line-height:28px;" onClick="goto_href('inbox');" class="user_btns">
    Cancel</div>
    </div><br clear="all"></form>
    <div style="clear:both; height:5px;"></div>
    </div>
    
         </div></div> 