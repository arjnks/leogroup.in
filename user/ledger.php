
<style media="print">
body{ background:none; margin:0px; padding:0px;}
.noprint, #noprint{ display:none;}
.printonly, #printonly{ display:block;}
#chitties{ background:#fff; width:100%; position:absolute; }
.ledg_tabl{background:#FFFFFF;-moz-border-radius:2px; css-border-radius:2px; -webkit-border-radius:2px;  height:auto;
-khtml-border-radius:2px; border-radius:2px; border:solid 1px; border-color:#666666; padding:3px;width:100%; 	}
.inti_tr2 th{ border-bottom:#000 1px solid; background:#FFFFFF; color:#000000; }
.ledg_tabl td{ height:25px; border-bottom:#000 1px dashed; }
</style> 
<style media="screen">.printonly, #printonly{ display:none;}</style>
<script type="text/javascript" src="../admin/theme/calendar/jsDatePick.min.1.3.js" ></script>

<link rel="stylesheet" type="text/css" href="../admin/theme/calendar/jsDatePick_ltr.min.css" />
<script  type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
window.onload = function(){
};
function bababa(cid)
{
  var frm=document.getElementById('date5').value;
  var email=document.getElementById('txtEmail').value;
  var temail=document.getElementById('txtTemail').value;
  if(email==""||temail=="")
  {

  	alert("Enter Email");
  }
  else
  {
 $.ajax({url:"senddet.php",type:"post",data:{cid:cid,fdate:frm,email:email,temail:temail},success:function(data){alert(data)}});
  }
}
function ledger(cid)
{
	 var fr0m=document.getElementById('date5').value;
   
     $.ajax({url:"left.php",type:"post",data:{srch:1,cid:cid,fdate:fr0m},
     	success:function(data)
     	{
     		document.getElementById('btnsnd').style.display="block";
     		$("#ta").html(data);
    	}
     });

}
</script>
<style>
    @media print {
  .display-print {
    display: none !important;
  }
  .logo-print{
      display:block!important;
      /*justify-content:space-between;*/
      
  }
}
.logo-print{
      display:none;
  }
</style>
<div id="chitties">

    <div id="hover_btns" class="noprint" style="width:105px;float:right; margin-top:5px;">
    <div style="width:100px; float:left; line-height:28px;" onclick="window.print();" class="user_btns">
    <img border="0" style="margin-bottom:-4px;" height="18" src="../images/print.png"> &nbsp; Print &nbsp; &nbsp; </div><div style="display: none;" id="btnsnd"> 
    <button type="button"style="width:100px; float:left; line-height:28px;" onclick="bababa('<?php echo $cos_id?>')" class="user_btns"><img border="0" style="margin-bottom:-2px;" height="18" src="../images/send.png"> &nbsp;<b> Send</b></button> </div>
    </div>
    
		<div class="logo-print">
   <img src="logo-tab.jpg" style="width:100%;">
   <!--<img src="address.jpeg" style="width:50%;">-->
   </div>
      <?php
	  		$as_on = file_get_contents("as_on.txt");
			/*$qry1="SELECT COUNT(*) FROM ledger where costomer_id='$cos_id'";
			$result1 = @leo_mysql_query($qry1);	
			$row = mysql_fetch_row($result1); 
			$total_records = $row[0]; 
			$total_pages = ceil($total_records / $count);
			
			if($total_records=="0"){echo '</table><div class="warnmsg"> No Ledger Exists</div>';  }
			else	
			{ 
			echo ' <div class="pageprag">';
			if($total_records!="0") { echo'<div class="left">
			Total Records : '.$total_records.' &nbsp;&nbsp;&nbsp; Pages : '.($next_page-1) .' / '.$total_pages.'</div>';}
			echo'<ul >';
			if(isset($_GET['page']))
			{
			if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
			else { 
			$pre_page = ($page-1); 
			echo '<li><a href="./ledger.php?coid='.$cos_id.'&page='.$pre_page.'">Previous Page</a></li>'; } 
			}
			else 
			{ echo '<li>Previous Page</li>'; $start_from="0"; }
			if($next_page>$total_pages){ echo "<li>Next page</li>";}
			else {	echo '<li><a href="./ledger.php?coid='.$cos_id.'&page='.$next_page.'">Next Page</a></li>'; } 
			echo ' </ul></div>'; 
			} */
			
			if(isset($_POST['from'])&&$_POST['from']!="")
			{
			$as_on_date=$_POST['from'];
			$as_on_date=date("d-M-Y",strtotime($_POST['from']));
			
			
			}
			else
			{
			$as_on_date=date("d-M-Y");
			}
			echo '<label id="noprint" class="blue">My Ledger<br /></label><label id="printonly" class="blue">'.$customer['company'].'</label>
			<span class="blue_2"> Closing Stock Register As On : '.$as_on_date.'</span>';
		?>
       <div class="display-print">
           <form action="" method="post">
       	Date : <input type="date" id="date5" name="from" value=""/> <input type="button" name="search" value="Search" style="width: 90px;" onclick="ledger('<?php echo $cos_id?>')" /> &nbsp;&nbsp;&nbsp;&nbsp; Email :<input type="text" name="txtEmail" id="txtEmail" placeholder="From Mail" style="width: 140px;">  <input type="text" name="txtTemail" id="txtTemail" placeholder="To Mail" style="width: 140px;"></form></div>
    <div id="ta">
        <table border="0" cellpadding="1" cellspacing="1" class="ledg_tabl">
          <tr class="inti_tr2" style="font-size:11px;">
                <th>Code </th>
                <th>Name</th>
                <th>Prate</th>
                <th>OpStock</th>
                <th>Purchase Qty</th>
                <th>Purchase Free</th>
                <th>Preturn</th>
                <th>Sales Qty</th>
                <th>Sales Free</th>
                
                <th class="status">Sales Qty Spoke</th>
                <th class="status">Sales Free Spoke</th>
                
                <th>S Value</th>
                <th>S Return</th>
                <th>Excess</th>
                <th>Short</th>
                <th>Cl Stock</th>
                
                <th class="status">Cl Stock Spoke</th>
                
                <th>Cl Value</th>
          </tr>
		<tr><td colspan="15"><b style="font-size:12px;"> No Ledger Exists </b></td></tr>;
		</table>
		</div>
 </div>