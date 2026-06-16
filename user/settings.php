<script type="text/javascript">
function change_pwd()
{
	var old_pwd = document.settings.old_pwd.value;
	var new_pwd = document.settings.new_pwd.value;
	var con_pwd = document.settings.con_pwd.value;
	
	if(old_pwd==''){ alert('Enter your old Password'); document.settings.old_pwd.focus(); return false; }
	else if(new_pwd==''){ alert('Enter new Password'); document.settings.new_pwd.focus(); return false; }
	else if(con_pwd==''){ alert('Confirm the new Password'); document.settings.con_pwd.focus(); return false; }
	
	else if(con_pwd!=new_pwd){ alert('Password Confirmation faild'); document.settings.con_pwd.value=''; document.settings.con_pwd.focus(); return false; }
	
	else { document.settings.submit(); }	
}
</script>
<div id="chitties">
    <?php 
	echo '<label class="blue"> Settings </label><br/>';							
	?>
        <div class="ledg_tabl" style="background:#FFFFFF; text-align:left;">
		<div style="border-bottom:#999999 1px dashed; margin-left:10px; float:left; margin-right:10px; line-height:25px; min-height:30px; width:880px;">&nbsp;
        <span style=" float:left; font-size:13px;"><b> Change Password</b></span>
        <span style=" float:right; font-size:12px;">
        <img border="0" style="margin-bottom:0px;" height="11" src="../images/clock.png" ><?php echo date(' h:i a '); ?>&nbsp;
        <img border="0" style="margin-bottom:-2px;" height="13" src="../images/calender.png" > <?php echo date(' d - M, Y'); ?></span></div>
        <br clear="all" />
		<div style="padding-left:10px; font-size:13px; padding-right:10px; text-align:center; margin:10px 0px 10px 0px;">
        <style> .textbox{font-family:Arial, Helvetica, sans-serif; background:#FFFFFF; font-size:13px;} </style>
        <form action="" name="settings" method="post">
        <table align="center" cellpadding="3" border="0">
        <tr>
        <th style="text-align:left; font-size:12px;">Old Password : </th>
        <th><input name="old_pwd" class="textbox" style="width:350px;" type="password"></th>
        </tr>
        <tr>
        <th style="text-align:left; font-size:12px;">New Password :  </th>
        <th><input name="new_pwd" class="textbox" style="width:350px;" type="password"></th>
        </tr>
        <tr>
          <th style="text-align:left; font-size:12px;">Confirm Password : </th>
          <th><input name="con_pwd" class="textbox" style="width:350px;"  type="password"></th>
        </tr>
        <tr>
          <th style="text-align:left; font-size:12px;">&nbsp;</th>
          <th>
          
    <div id="hover_btns" style="width:400px; margin-top:-5px; margin-left:50px;">
    <div style="width:100px; float:left; line-height:28px;" onClick="change_pwd();" class="user_btns">Change</div>
    <div style="width:100px; float:left; margin-left:5px; line-height:28px;" onClick="goto_href('ledger');" class="user_btns">
    Cancel</div>
    </div><br clear="all">
    <div style="clear:both; height:5px;"></div>
    </div>
    
          </th>
        </tr>
        </table>
        
        </form>
        
        </div> 
   
   
    
         </div></div> 