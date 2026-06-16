 <style>
	.left{float:left;color:#000;}
	.pageprag{ margin-top:2px; text-align:left; background:#EFEFEF;font-size:12px; margin-left:5px;margin-right:5px; line-height:31px; padding-left:5px;}
	.pageprag ul{margin:0px;padding:0;list-style:none; text-align:right;}
	.pageprag ul li{display: inline;padding:2px 5px 2px 5px ; margin:5px; color:#C2C2C2; border:1px solid #C5C2C2; background:#DCDADA; }
	.pageprag ul li a{text-decoration:none;}
</style>
<div id="chitties">
      <?php
			echo '<label class="blue">Inbox</label><br/>';
			
			$qry1="SELECT COUNT(*) FROM `message` where `to`='$cos_id'";
			$result1 = @leo_mysql_query($qry1);	
			$row = mysql_fetch_row($result1); 
			$total_records = $row[0]; 
			$total_pages = ceil($total_records / $count);
			
			if($total_records!="0"){
			echo ' <div class="pageprag">';
			if($total_records!="0") { echo'<div class="left">
			Total : '.$total_records.' &nbsp;&nbsp;&nbsp; Pages : '.($next_page-1) .' / '.$total_pages.'</div>';}
			echo'<ul >';
			if(isset($_GET['page']))
			{
			if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
			else { 
			$pre_page = ($page-1); 
			echo '<li><a href="./?p=inbox&page='.$pre_page.'">Previous Page</a></li>'; } 
			}
			else 
			{ echo '<li>Previous Page</li>'; $start_from="0"; }
			if($next_page>$total_pages){ echo "<li>Next page</li>";}
			else {	echo '<li><a href="?p=inbox&page='.$next_page.'">Next Page</a></li>'; } 
			echo ' </ul></div>'; 
			} 
		?>        
        <table border="0" cellpadding="1" cellspacing="1" class="ledg_tabl">
          <tr class="inti_tr2" style="font-size:11px;">
                <th style="width:30px;">No</th>
                <th style="width:150px;">Subject</th>
                <th>Message</th>
                <th style="width:90px;">Date & Time</th>
                <th style="width:60px;">Action</th>
          </tr>
          <?php 
	   $n = (($count*$page)-$count)+1;
	   $qr_led = "select * from `message` where `to`='$cos_id' order by date desc  LIMIT $start_from , $count";
	   $qqa = leo_mysql_query($qr_led);
	   $num = leo_mysql_num_rows($qqa);
	   if($num>0)
	   {
		   while($res = leo_mysql_fetch_array($qqa))
		   {
		   echo '<tr id="h_rows" style="font-size:11px;">
			<td>'.$n.'</td>
			<td>'.$res['subject'].'</td>
			<td style=" text-align:left;">'.smalltext($res['message'],190).'</td>
			<td>'.date('d - M, Y',$res['time']).'<br><img border="0" height="10" src="../images/clock.png"> '.date('h:i a ',$res['time']).'</td>
			<td>
			<a target="_blank" href="?p=msg&text='.$res['id'].'"><img title="View" border="0" height="15" alt="View" src="../admin/theme/images/view.png"></a>&nbsp;
        	<a href="javascript:delete_mail('.$res['id'].');"><img title="Delete" border="0" height="15" alt="Delete" src="../admin/theme/images/delete.png"></a>
			</td></tr>'; 
			$n++;
			 }
		?></table><?php	
		}
		else
		{echo '
		<tr id="h_rows" style="font-size:11px;"><td colspan="5"><b>No Messages Exists</b></td></tr></table>';  }
			
		
		if($total_records!="0")
		{ 
			echo ' <div class="pageprag" style="margin-top:-5px;margin-bottom:10px;">'; 
			if($total_records!="0") { echo'<div class="left"> 
			Total Records : '.$total_records.' &nbsp;&nbsp;&nbsp; Pages : '.($next_page-1) .' / '.$total_pages.'</div>'; } 
			echo'<ul >';
			if(isset($_GET['page'])) 
			{ 
			if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; } 
			else { 
			$pre_page = ($page-1); 
			echo '<li><a href="?p=inbox&page='.$pre_page.'">Previous Page</a></li>'; } 
			}
			else
			{ echo '<li>Previous Page</li>'; $start_from="0"; } 
			if($next_page>$total_pages){ echo "<li>Next page</li>"; } 
			else {	echo '<li><a href="?p=inbox&page='.$next_page.'">Next Page</a></li>'; } 
			echo ' </ul></div>';
		}
		?>
      </div>
