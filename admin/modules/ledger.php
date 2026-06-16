<?php
// Update ledger txt file -----------------
ini_set('memory_limit', '-1');

if(isset($_POST['search']))
{
	$chit_name=$_POST['chit_names2'];
	$cu_id=$_POST['cu_id'];
	header("location:  ./?p=ledger&tab=find&chit_name=".$chit_name."&cu_id=".$cu_id);
}
 function chit_names()
{
	$qry=leo_mysql_query("select chit_id,chit_name   from chit"); 
	while($res=leo_mysql_fetch_array($qry))
	{	
		if(isset($_GET['chit_name']) && $_GET['chit_name']==$res['chit_id']){ $t='selected="selected"';}else{$t='';}
		 echo '<option  value="'.$res['chit_id'].'" '.$t.'>'.$res['chit_name'].'</option>'; 
	}
}

if(isset($_POST['sub_ledger']))
{
   if($_FILES['ledger_file']['name']==''){ $error[] = "Please upload the file"; }
   else if($_FILES['ledger_file']['type']!='text/plain') { $error[] = "Please upload only text files"; }
   else if($_FILES['ledger_file']['name']!='ledger.txt' && $_FILES['ledger_file']['name']!='LEDGER.TXT') { $error[] = "Please upload ledger.txt file"; }
	
	if($error)
	{
		$_SESSION['AERRMSG']=$error;
		session_write_close();
		header("location:  ./?p=ledger&tab=");
		exit();
	}
	else
	{
		$del_led = 0;
		//$q_del=leo_mysql_query("DELETE FROM ledger");
		$target_path="upload/".$_FILES["ledger_file"]["name"];
		move_uploaded_file($_FILES["ledger_file"]["tmp_name"],"upload/".$_FILES["ledger_file"]["name"]);
		$lines = file($target_path, FILE_SKIP_EMPTY_LINES);
		// Loop through the $lines array to get each line
		$sql =''; $c=''; $q_inc=5000;
		$q_count=count($lines);
		for($k=0;$k<=$q_count;$k++)
		{
			if(20 == count(explode(',',$lines[$k])))
			{
				$cols = explode(',',$lines[$k]);
				$v0 =	date("Y-m-d", strtotime(clean($cols[0])));$v1 = clean($cols[1]); $v2 = clean($cols[2]);
				$v3 = clean($cols[3]); $v4 = clean($cols[4]); $v5 = clean($cols[5]);
				$v6 = clean($cols[6]); $v7 = clean($cols[7]); $v8 = clean($cols[8]);
				$v9 = clean($cols[9]); $v10 = clean($cols[10]); $v11 = clean($cols[11]);
				$v12 = clean($cols[12]); $v13 = clean($cols[13]); 
				$v14 = clean($cols[14]); $v15 = clean($cols[15]);$v16 = clean($cols[16]);
				
				
				$v17 = clean($cols[17]);$v18 = clean($cols[18]);$v19 = clean($cols[19]);
				
				$sql.=$c."('$v0','$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12','$v13','$v14','$v15','$v16','$v17','$v18','$v19')";
				$c=',';
			}
			
			if($k>$q_inc || $k==$q_count)
			{
				if($sql!='') 
				{ 
					if($del_led==0)
					{
					$q_del = leo_mysql_query("DELETE FROM ledger WHERE date < DATE_SUB(NOW(), INTERVAL 30 DAY);"); $del_led = 1; 
					}
					/*$chk="SELECT * FROM `ledger` WHERE `date`='$v0' AND `costomer_id`='$v1' AND `code`='$v2' AND `name`='$v3' AND `prate`='$v4' AND `op_stock`='$v5' AND `purchase_qty`='$v6' AND `purchase_free`='$v7' AND `preturn`='$v8' AND `sales_qty`='$v9' AND `sales_free`='$v10' AND `s_value`='$v11' AND `s_return`='$v12' AND `excess`='$v13' AND `short`='$v14' AND `cl_stock`='$v15' AND `cl_value`='$v16'" ;
					$dd=leo_mysql_query($chk);
					$hh=leo_mysql_num_rows($dd);
					if($hh!=0)
					{*/
					$sql = "insert into ledger values ".$sql; 
					$ins=leo_mysql_query($sql); 
				    //}
				}
				$sql =''; $c=''; $q_inc=($q_inc+5000);
			}
		}
	
		if($del_led==0)
		{
			$_SESSION['ERRMSG']= ' Please Confirm you are uploading Customer ledger File'.$sql;
			session_write_close();
			header("location:  ./?p=ledger&tab=");
			exit();
		}
		else
		{		
			if($ins)
			{
				file_put_contents("../user/as_on.txt",$_POST['date']);
				$_SESSION['SUCMSG']=" The ledger datas has been sucessfully Uploaded ";
				session_write_close();
				header("location:  ./?p=ledger&tab=");
				exit();
			}
			else
			{
				$_SESSION['ERRMSG']=leo_mysql_error().$sql;
				session_write_close();
				header("location:  ./?p=ledger&tab=");
				exit();
			}
		}
	}
}

//<-------------------------------- delete  ------------------------->//
if(isset($_POST['delete']))
{
	$id=$_GET['delete'];
	$reurl = $_SERVER['HTTP_REFER'];
	$qry="delete from `ledger` where `id`=$id";
	$result=leo_mysql_query($qry);
	
	if($result)
	{
		$_SESSION['SUCMSG']=" A ledger has been sucessfully deleted ";
		session_write_close();
		header("location:  ./?p=ledger&tab=");
		exit();
		}
	else 
		{
		$_SESSION['ERRMSG']=leo_mysql_error();
		session_write_close();
		header("location:  ./?p=ledger&tab=");
		exit();
		}
}
//<-------------------------------- delete ------------------------->//


$pagename="ledger-";
include('theme/header.php'); ?>
<h1>ledger Management</h1>
<style>.star { background:url(theme/images/ylwstar.png) repeat-x;  }</style>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script>
$(function() {
$( "#date_from" ).datepicker({
changeMonth: true,
changeYear: true
});
});

$(function() {
$( "#date_to" ).datepicker({
changeMonth: true,
changeYear: true
});
});

</script>
<script type="text/javascript">
function validate_date(){
var from=document.getElementById("date_from").value;
var to=document.getElementById("date_to").value;
if(from=="" ){
alert("Please select date ");
document.getElementById("date_from").focus();
return false;
}
else if(to=="" )
{
alert("Please fill two fields");
document.getElementById("date_from").focus();
return false;
}
}
function date_function()
{
var from_date = document.getElementById("date_from").value;
var to_date = document.getElementById("date_to").value;
window.location.href= "?p=ledger&tab=search&from_date="+from_date+"&to_date="+to_date;
} 
 
</script>
<div id="leftbar">
<ul>
<li><a href="./?p=ledger&tab=" <?php activelink(''); ?>>View / Upload ledger</a></li>
<li><a href="./?p=ledger&tab=find" <?php activelink('find'); ?>>Find</a></li></ul>
</div>
<div id="content">

<?php
#-------------- Delete news----------------->
if(isset($_GET['delete']))
 {
echo '<div class="errormsg">
Do you realy want to delete this news
<br /><br />
<form  action="" method="post">
<input type="hidden" value="'.$_GET['delete'].'" name="id">
<input type="submit" value="Yes" name="delete" class="button">
<input type="button" value="no" name="no" onClick="window.location=\'?p=ledger&tab=\'" class="button">
</form></div>';
 }
#-------------- /Delete news----------------->
if(isset($_GET['tab']) && $_GET['tab']=='search' &&  isset($_GET['from_date']))
{?> 
<fieldset  class="result1"><legend>ledger</legend>
<div style="width:735px; overflow:auto;">
<table cellpadding="0" cellspacing="0" width="100%">
<tr style="background:#2BB9D1; height:25px;">
<th class="status">Date</th>
<th class="thumb" >Customer ID</th>
<th class="status">Code</th>
<th class="status">Name</th>
<th class="status">Prate</th>
<th class="status">OpStock</th>
<th class="status">Purchase Qty</th>
<th class="status">Purchase Free</th>
<th class="status">Preturn</th>
<th class="status">Sales Qty</th>
<th class="status">Sales Free</th>

<th class="status">Sales Qty Spoke</th>
<th class="status">Sales Free Spoke</th>

<th class="status">S Value</th>
<th class="status">S Return</th>
<th class="status">Excess</th>
<th class="status">Short</th>
<th class="status">Cl Stock</th>

<th class="status">Cl Stock Spoke</th>

<th class="status">Cl Value</th>
<?php
if(isset($_GET['from_date']) && $_GET['from_date']!='' )
{
	$dt_from =date("Y-m-d", strtotime($_GET['from_date']));
	$dt_to = date("Y-m-d", strtotime($_GET['to_date']));
	$sub_qry = " where `date` between '" . $dt_from . "' AND  '". $dt_to . "'";
}
else
{
	$dt_from = '';
	$dt_to ='';
	$sub_qry = "";
}

$cqry1="SELECT COUNT(*) FROM `ledger` ".$sub_qry; 
$cresult = @leo_mysql_query($cqry1);	
$row = mysql_fetch_row($cresult); 
$total_records = $row[0]; 
$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> 
		 <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> &nbsp; No ledger Exists &nbsp; 
		  <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> </div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.' &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Page(s) : '.($next_page-1) .' / '.$total_pages.'
		&nbsp; Go to : <select onchange="go_topage(\'?p=ledger&tab=search&from_date='.$_GET['from_date'].'&to_date='.$_GET['to_date'].'&page=\',this.value);" style="padding:0px; width:50px; height:20px;">'; 
		 	for($pi=1;$pi<=$total_pages;$pi++) { if($page==$pi) $s='selected'; else $s=''; echo "<option $s> $pi </option>"; } echo '</select>
			</div>';}
		echo'<ul >';
		  if(isset($_GET['page']))
		  {
			 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
			 else { 
			 $pre_page = ($page-1);
			// if(isset($_GET['from_date'])){$cust_txt='&cust_txt='.$_GET['cust_txt'];}else{$cust_txt='';}
			 echo '<li><a href="?p=ledger&tab=search&from_date='.$_GET['from_date'].'&to_date='.$_GET['to_date'].'&page='.$pre_page.'">Previous Page</a></li>';}
		  }
		  else
		  {
		  echo '<li>Previous Page</li>'; $start_from="0";
		  }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="?p=ledger&tab=search&from_date='.$_GET['from_date'].'&to_date='.$_GET['to_date'].'&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
 $view="select * from `ledger` $sub_qry LIMIT $start_from , $count";
$sql=leo_mysql_query($view);
$i=1;
while($db=leo_mysql_fetch_array($sql))
{
	if($i%2==0){ $alt="alt"; } else{ $alt=""; } 
	echo '<tr>
	<td align="center"> '.$db['date'].'</td>
	<td align="center">'.$db['costomer_id'].'</td>
	<td align="center">'.$db['code'].'</td>
	<td align="center">'.$db['name'].'</td>
	<td align="right" style="padding-right:10px;text-align:right;">'.$db['prate'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['op_stock'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['purchase_qty'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['purchase_free'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['preturn'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['sales_qty'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['sales_free'].'</td>
	
	
	<td style="padding-right:10px;text-align:right;">'.$db['salesqty_spoke'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['salesfree_spoke'].'</td>
	
	<td style="padding-right:10px;text-align:right;">'.$db['s_value'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['s_return'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['excess'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['short'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['cl_stock'].'</td>
	
	<td style="padding-right:10px;text-align:right;">'.$db['cl_stock_spoke'].'</td>
	
	<td style="padding-right:10px;text-align:right;">'.$db['cl_value'].'</td>';
	//<td class="created '.$alt.'">'.date('M d, Y',$db['date']).'</td>
	//<td class="action '.$alt.'"><a href="?p=ledger&tab=&edit='.$db['id'].'"><img src="./theme/images/edit.png" title="Edit This " alt="Edit This"></a>
  	//<a href="?p=ledger&tab=&delete='.$db['id'].'&imgc='.$db['thumb_image'].'"><img src="./theme/images/delete.png" title="Delete this" alt="Delete this"></a></td>';
	echo '</tr>';
	$i=$i+1;
}
echo '</table></div>';

?>
</fieldset>
<?php
}

else if(isset($_GET['tab']) && $_GET['tab']=='find')
{ ?>
<fieldset class="fieldset"><legend>Find</legend>
<form action="" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" >Enter the Customer ID :&nbsp;<input name="cu_id" class="textbox" style="width:300px;" type="text" value="<?php if(isset($_GET['cu_id']) && $_GET['cu_id']!='' ) {echo $_GET['cu_id']; } else {}?>" /> <input name="search" onclick="document.getElementById('hider').style.display='block';" class="button" type="submit"  value="search"/></td>
    <td style="border:none; width:220px;"><img id="hider" src="theme/images/loader.gif" style="margin-bottom:-5px; display:none; margin-left:10px;" height="20" />
    </td>
  </tr>
</table>
</form>
</fieldset>
<?php
 if(isset($_GET['tab']) && $_GET['tab']=='find' &&  isset($_GET['cu_id']))
{?> 
<fieldset  class="result1"><legend>ledger</legend>
<div style="width:735px; overflow:auto;">
<table cellpadding="0" cellspacing="0" width="100%">
<tr style="background:#2BB9D1; height:25px;">
<th class="status">Date</th>
<th class="thumb" >Customer ID</th>
<th class="status">Code</th>
<th class="status">Name</th>
<th class="status">Prate</th>
<th class="status">OpStock</th>
<th class="status">Purchase Qty</th>
<th class="status">Purchase Free</th>

<th class="status">Sales Qty Spoke</th>
<th class="status">Sales Free Spoke</th>

<th class="status">Preturn</th>
<th class="status">Sales Qty</th>
<th class="status">Sales Free</th>
<th class="status">S Value</th>
<th class="status">S Return</th>
<th class="status">Excess</th>
<th class="status">Short</th>
<th class="status">Cl Stock</th>

<th class="status">Cl Stock Spoke</th>

<th class="status">Cl Value</th>
<?php
if(isset($_GET['cu_id']) && $_GET['cu_id']!='' )
{
	$cu_id = $_GET['cu_id'];
	$sub_qry = " where  costomer_id='".$cu_id."'";
}
else
{
	$cu_id = '';
	$sub_qry = "";
}

$cqry1="SELECT COUNT(*) FROM `ledger` ".$sub_qry; 
$cresult = @leo_mysql_query($cqry1);	
$row = mysql_fetch_row($cresult); 
$total_records = $row[0]; 
$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> 
		 <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> &nbsp; No ledger Exists &nbsp; 
		  <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> </div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.' &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Page(s) : '.($next_page-1) .' / '.$total_pages.'
		&nbsp; Go to : <select onchange="go_topage(\'?p=ledger&tab=find&cu_id='.$cu_id.'&page=\',this.value);" style="padding:0px; width:50px; height:20px;">'; 
		 	for($pi=1;$pi<=$total_pages;$pi++) { if($page==$pi) $s='selected'; else $s=''; echo "<option $s> $pi </option>"; } echo '</select>
			</div>';}
		echo'<ul >';
		  if(isset($_GET['page']))
		  {
			 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
			 else { 
			 $pre_page = ($page-1);
			 if(isset($_GET['cust_txt'])){$cust_txt='&cust_txt='.$_GET['cust_txt'];}else{$cust_txt='';}
			 echo '<li><a href="./?p=ledger&tab=find&cu_id='.$cu_id.'&page='.$pre_page.$cust_txt.'">Previous Page</a></li>';}
		  }
		  else
		  {
		  echo '<li>Previous Page</li>'; $start_from="0";
		  }
		  if(isset($_GET['cust_txt'])){$cust_txt='&cust_txt='.$_GET['cust_txt'];}else{$cust_txt='';}
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=ledger&tab=find&cu_id='.$cu_id.'&page='.$next_page.$cust_txt.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
//if(isset($_GET['cust_txt']) && $_GET['cust_txt']!=''){$find_cust=" where costomer_id='".$_GET['cust_txt']."'";}else{$find_cust='';}
$view="select * from `ledger` $sub_qry LIMIT $start_from , $count";
$sql=leo_mysql_query($view);
$i=1;
while($db=leo_mysql_fetch_array($sql))
{
	if($i%2==0){ $alt="alt"; } else{ $alt=""; } 
	echo '<tr>
	<td align="center"> '.$db['date'].'</td>
	<td align="center">'.$db['costomer_id'].'</td>
	<td align="center">'.$db['code'].'</td>
	<td align="center">'.$db['name'].'</td>
	<td align="right" style="padding-right:10px;text-align:right;">'.$db['prate'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['op_stock'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['purchase_qty'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['purchase_free'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['preturn'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['sales_qty'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['sales_free'].'</td>
	
		<td style="padding-right:10px;text-align:right;">'.$db['salesqty_spoke'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['salesfree_spoke'].'</td>
	
	<td style="padding-right:10px;text-align:right;">'.$db['s_value'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['s_return'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['excess'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['short'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['cl_stock'].'</td>
	
	<td style="padding-right:10px;text-align:right;">'.$db['cl_stock_spoke'].'</td>
	
	<td style="padding-right:10px;text-align:right;">'.$db['cl_value'].'</td>';
	//<td class="created '.$alt.'">'.date('M d, Y',$db['date']).'</td>
	//<td class="action '.$alt.'"><a href="?p=ledger&tab=&edit='.$db['id'].'"><img src="./theme/images/edit.png" title="Edit This " alt="Edit This"></a>
  	//<a href="?p=ledger&tab=&delete='.$db['id'].'&imgc='.$db['thumb_image'].'"><img src="./theme/images/delete.png" title="Delete this" alt="Delete this"></a></td>';
	echo '</tr>';
	$i=$i+1;
}
echo '</table></div>';

?>
</fieldset>
<?php
}

}
else
{
?>
<fieldset class="result1"><legend>Upload ledger</legend>
<script type="text/javascript">
	window.onload = function(){
	new JsDatePick({
			useMode:2,
			target:"dateymd",
			dateFormat:"%d - %M, %Y"
			
		});
	};
	</script>
<?php msgs(); ?>
<!-- loading image -->
<div id="load" style="position:absolute;display:none;
position:fixed;   top: 0%;  left: 0%; width:100%;  height:100%;  z-index:1001;
background-color:black;  -moz-opacity:0.6;  opacity:.60; filter: alpha(opacity=60);">
<div style="background:#000000;top:30%; left:40%; position:fixed;"><img height="200" src="theme/images/loads.gif" /></div></div>
<!-- loading image -->

<form action="" method="post"  enctype="multipart/form-data">
<table cellpadding="0" cellspacing="0">
<tr><th style="width:200px;" valign=""> Upload Customer ledger File : </th><td style="border:none;">
<input type="file" name="ledger_file"  class="button">
<input name="date" class="textbox" style="width:140px;" value="<?php echo date('d - M, Y');?>" id="dateymd" type="text" />
<input type="submit" value="Upload" class="button" onclick="document.getElementById('load').style.display='block';"  name="sub_ledger" />
<small style="color:#0099CC; font-size:11px;"><br />File Name : ledger.txt</small>
</td></tr></table>
</form>
</fieldset>
<fieldset style="display:none;" class="result1"><legend>Search Customers</legend>
<?php msgs(); ?>
<form action="" method="get"  enctype="multipart/form-data">
<input type="hidden" name="p" class="textbox" value="ledger" />
<input type="hidden" name="tab" class="textbox" value="" />
<table cellpadding="0" cellspacing="0">
<tr><!--<th style="width:125px;">Enter the Customer ID : </th><td style="border:none;">
<input type="text" name="cust_txt" class="textbox" value="<?php //if(isset($_GET['cust_txt'])) echo $_GET['cust_txt']; ?>" style="width:100px;" />
<input type="submit" onclick="document.getElementById('hider').style.display='block';" value="Find" class="button" name="find_cust" />--> Date From&nbsp;&nbsp;<input name="date_from" id="date_from" type="text"  />&nbsp;&nbsp;To&nbsp;<input name="date_to" id="date_to" type="text" />&nbsp;&nbsp;&nbsp;<input name="go"  value="Go" type="button"  onclick="date_function(); " />
</td>
    <td style="border:none;"><img id="hider" src="theme/images/loader.gif" style="margin-bottom:-5px; display:none; margin-left:10px;" height="20" />
    </td>
</td></tr></table>
</form> 
</fieldset>
<fieldset class="result1" style="overflow:scroll;"><legend>ledger</legend>
<?php msgs(); ?>
<style> #content  .result1 th  { text-align:center;} #content  .result1 td{text-align:left;padding:3px  5px  3px  5px; }</style>
<div style="width:735px; overflow:auto;">
<table cellpadding="0" cellspacing="0"  width="100%" style="overflow:scroll;">
<tr style="background:#2BB9D1; height:25px;">
<th class="thumb">Date</th>
<th class="thumb">Customer ID</th><th class="status">Code</th>
<th class="status">Name</th><th class="status">Prate</th>
<th class="status">OpStock</th><th class="status">Purchase Qty</th>
<th class="status">Purchase Free</th><th class="status">Preturn</th>
<th class="status">Sales Qty</th><th class="status">Sales Free</th>

<th class="status">Sales Qty Spoke</th>
<th class="status">Sales Free Spoke</th>

<th class="status">S Value</th><th class="status">S Return</th>
<th class="status">Excess</th><th class="status">Short</th>

<th class="status">Cl Stock Spoke</th>

<th class="status">Cl Stock</th><th class="status">Cl Value</th>
</tr>
<?php
if(isset($_GET['cust_txt']) && $_GET['cust_txt']!=''){$find_cust=" where costomer_id='".$_GET['cust_txt']."'";}else{$find_cust='';}
$cqry1="SELECT COUNT(*) FROM `ledger` ".$find_cust; 
$cresult = @leo_mysql_query($cqry1); 
$row = mysql_fetch_row($cresult); 
$total_records = $row[0]; 
$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> 
		<span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> &nbsp; No ledger Exists &nbsp; 
		<span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> &nbsp; </div>';  }
		else	
		{ 
		if(isset($_GET['cust_txt'])){$cust_txt='&cust_txt='.$_GET['cust_txt'];}else{$cust_txt='';}
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.' &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Page(s) : '.($next_page-1) .' / '.$total_pages.'
		&nbsp; Go to : <select onchange="go_topage(\'?p=ledger&tab='.$cust_txt.'&page=\',this.value);" style="padding:0px; width:50px; height:20px;">'; 
		 	for($pi=1;$pi<=$total_pages;$pi++) { if($page==$pi) $s='selected'; else $s=''; echo "<option $s> $pi </option>"; } echo '</select>
			</div>';}
		echo'<ul >';
		  if(isset($_GET['page']))
		  {
			 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
			 else { 
			 $pre_page = ($page-1);
			 if(isset($_GET['cust_txt'])){$cust_txt='&cust_txt='.$_GET['cust_txt'];}else{$cust_txt='';}
			 echo '<li><a href="./?p=ledger&tab=&page='.$pre_page.$cust_txt.'">Previous Page</a></li>';}
		  }
		  else
		  {
		  echo '<li>Previous Page</li>'; $start_from="0";
		  }
		  if(isset($_GET['cust_txt'])){$cust_txt='&cust_txt='.$_GET['cust_txt'];}else{$cust_txt='';}
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=ledger&tab=&page='.$next_page.$cust_txt.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
if(isset($_GET['cust_txt']) && $_GET['cust_txt']!=''){$find_cust=" where costomer_id='".$_GET['cust_txt']."'";}else{$find_cust='';}
$view="select * from `ledger` $find_cust LIMIT $start_from , $count";
$sql=leo_mysql_query($view);
$i=1;
while($db=leo_mysql_fetch_array($sql))
{
	if($i%2==0){ $alt="alt"; } else{ $alt=""; } 
	echo '<tr>
	<td align="center">'.$db['date'].'</td>
	<td align="center">'.$db['costomer_id'].'</td>
	<td align="center">'.$db['code'].'</td><td align="center">'.$db['name'].'</td>
	<td align="right" style="padding-right:10px;text-align:right;">'.$db['prate'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['op_stock'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['purchase_qty'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['purchase_free'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['preturn'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['sales_qty'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['sales_free'].'</td>
	
	<td style="padding-right:10px;text-align:right;">'.$db['salesqty_spoke'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['salesfree_spoke'].'</td>	
	
	<td style="padding-right:10px;text-align:right;">'.$db['s_value'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['s_return'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['excess'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['short'].'</td>
	<td style="padding-right:10px;text-align:right;">'.$db['cl_stock'].'</td>
	
		<td style="padding-right:10px;text-align:right;">'.$db['cl_stock_spoke'].'</td>
	
	<td style="padding-right:10px;text-align:right;">'.$db['cl_value'].'</td>';
	/*<td align="right" style="padding-right:10px;">'.$db['full_amount'].'</td>
	<td align="right" style="padding-right:10px;">'.$db['net_amount'].'</td>
	<td align="right" style="padding-right:10px;">'.$db['bonus'].'</td>
	<td align="right" style="padding-right:10px;">'.$db['suspence_amt'].'</td>';*/
	//<td class="created '.$alt.'">'.date('M d, Y',$db['date']).'</td>
	//<td class="action '.$alt.'"><a href="?p=ledger&tab=&edit='.$db['id'].'"><img src="./theme/images/edit.png" title="Edit This " alt="Edit This"></a>
  	//<a href="?p=ledger&tab=&delete='.$db['id'].'&imgc='.$db['thumb_image'].'"><img src="./theme/images/delete.png" title="Delete this" alt="Delete this"></a></td>';
	echo '</tr>';
	$i=$i+1;;
}
echo '</table></div></fieldset>';
}
echo '</div>';
include('theme/footer.php'); ?>