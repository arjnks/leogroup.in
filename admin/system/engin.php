<?php
function chitty($value,$chitty_no)
{
 $qry="SELECT *  FROM chitty_mst WHERE chitty_no ='$chitty_no' ";
$result = @leo_mysql_query($qry);
	if($result)
	{
$chitty=leo_mysql_fetch_array($result);
if($value=='name') {return $chitty['chitty_name'];}
 else if($value=='instalment_amt') {return $chitty['instalment_amt'];}

}}	

function chitty2($value,$chitty_no)
{
 $qry="SELECT *  FROM chit WHERE chit_id ='$chitty_no' ";
$result = @leo_mysql_query($qry);
	if($result)
	{
$chitty=leo_mysql_fetch_array($result);
if($value=='name') {return $chitty['chit_name'];}
 else if($value=='instalment_amt') {return $chitty['inst_amt'];}

}}	




function customer($value,$id) 
{
	$qry="SELECT * FROM costomer WHERE costomer_id='$id'";
	$result = @leo_mysql_query($qry);
	if($result)
	{
	$chitty=leo_mysql_fetch_assoc($result);
	if($value=='name') {return $chitty['company'];}
	else  if($value=='reg_no') {return $chitty['costomer_id'];}
	else  if($value=='email') {return $chitty['email_id'];}
	else  if($value=='mobile') {return $chitty['phone_no'];}
	else  if($value=='company') {return $chitty['company'];}	
	}
}

function customer_lists($id) 
{
	$qry="SELECT costomer_id,company FROM costomer WHERE status='1'";
	$result = @leo_mysql_query($qry);
	while($chitty=leo_mysql_fetch_array($result))
	{
		if($id==$chitty['costomer_id']){ $s ="selected"; }else{ $s =""; }
		echo '<option '.$s.' value="'.$chitty['costomer_id'].'">'.$chitty['company'].'</option>';
	}
}







function get_pay_amount($sttno,$cust_no,$chitty_no,$inst_no)
{
$qry0="select * from chitty_result where inst_no='$inst_no' and chitty_no='$chitty_no' ";
$result0=@leo_mysql_query($qry0);
if($result0)
    {
	
	if(leo_mysql_num_rows($result0)>=1)
	{
		$c_result=leo_mysql_fetch_array($result0);
		$inst_no=$c_result['inst_no'];
	
		## ---------------------  auction result's statemaent numbers.  ------------------------>
			$var= preg_replace('(\r\n)is', '<br/>',$c_result['auction']);
			$varcount =count($auctions=split('[<br/>]', $var));
			for($i=0; $i<$varcount; $i++)
			{
			if($vars=preg_match("'(.*?)(-)(.*?)'",$auctions[$i],$var)=='1')
			$acution_sttnos[]=$var[1] ;
			}
		## --------------------- getting auction result's statemaent numbers. (ends)  ------------------------>
	
		## --------------------- getting prized result's  details.  ------------------------>
			 $prized_prize=$c_result['prized_amount'];
			 $prized_sttnos= split('[,]',$c_result['prized_sttnos']);
		## --------------------- getting prized result's  details. (ends)  ------------------------>
	
		## --------------------- getting  bonus_prize result's  details.  ------------------------>
			$bonus_prize=$c_result['bonus_prize'];
			$bonus_sttnos= split('[,]',$c_result['bonus_sttno']);
		## --------------------- getting bonus_prize result's  details. (ends)  ------------------------>
	
		## --------------------- getting  fixed_prize result's  details.  ------------------------>
			$fixed_prize=$c_result['fixed_amount'];
			$fixed_sttnos= split('[,]',$c_result['fixed_sttnos']);
		## --------------------- getting fixed_prize result's  details. (ends)  ------------------------>
	
		## --------------------- getting  bumber_prize result's  details.  ------------------------>
			$bumber_prize=$c_result['bumber_prize'];
			$bumber_sttnos= split('[,]',$c_result['bumber_sttno']);
		## --------------------- getting bumber_prize result's  details. (ends)  ------------------------>
	
		## --------------------- getting  others_prize result's  details.  ------------------------>
			$others_prize=$c_result['others_prize'];
			$others_sttnos= split('[,]',$c_result['others_sttnos']);
		## --------------------- getting others_prize result's  details. (ends)  ------------------------>
	
			$prized_pay_amount=$c_result['prized_pay_amount'];
			$auctioned_pay_amount=$c_result['auctioned_pay_amount'];
			$non_prized_pay_amount=$c_result['non_prized_pay_amount'];

		for($i=0;$i<count($acution_sttnos); $i++) //cheking sttno in  auction result's
		{ if($sttno==$acution_sttnos[$i]){ $value=$auctioned_pay_amount; break;} }

		for($i=0;$i<count($prized_sttnos); $i++) //cheking sttno in  prized result's
		{ if($sttno==$prized_sttnos[$i]){ $value=$prized_pay_amount; break;} }

		for($i=0;$i<count($bonus_sttnos); $i++) //cheking sttno in  bonus result's
		{ if($sttno==$bonus_sttnos[$i]){ $value=$non_prized_pay_amount; break;} }
	
		for($i=0;$i<count($fixed_sttnos); $i++) //cheking sttno in  fixed result's
		{ if($sttno==$fixed_sttnos[$i]){ $value=$non_prized_pay_amount; break;} }

		if($value) {return $value;} else{ return $non_prized_pay_amount;}
	}
	else {return chitty('instalment_amt',$chitty_no);}
    }
}




	
?>
