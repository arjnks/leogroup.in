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
 <?php 

 require_once("./../admin/system/config.php"); 

          if(isset($_POST["srch"]))
          {
             $cos_id=$_POST["cid"];
          	 $from=$_POST["fdate"];
	   $s_value_total = 0; $cl_value_total = 0;

  $qr_led="SELECT * FROM `ledger` WHERE `costomer_id`='$cos_id' and `date`='$from' order by name";
		 
	   $qqa=leo_mysql_query($qr_led);
	   $num=leo_mysql_num_rows($qqa);
	   if($num>0)
	   {
		   while($res=leo_mysql_fetch_array($qqa))
		   {
		   echo '<tr style="font-size:11px;" id="h_rows">
		    <td style="text-align:left;">'.$res['code'].'</td>
            <td style="text-align:left;">'.$res['name'].'</td>
            <td style="text-align:right;">'.$res['prate'].'</td>
            <td>'.$res['op_stock'].'</td>
            <td>'.$res['purchase_qty'].'</td>
            <td>'.$res['purchase_free'].'</td>
            <td>'.$res['preturn'].'</td>
            <td>'.$res['sales_qty'].'</td>
            <td>'.$res['sales_free'].'</td>
            
            
        
            <td>'.$res['salesqty_spoke'].'</td>
            <td>'.$res['salesfree_spoke'].'</td>
            
            
            <td style="text-align:right;">'.$res['s_value'].'</td>
            <td>'.$res['s_return'].'</td>
            <td>'.$res['excess'].'</td>
            <td>'.$res['short'].'</td>
            <td>'.$res['cl_stock'].'</td>
            
             <td>'.$res['cl_stock_spoke'].'</td>
            
            <td style="text-align:right;">'.$res['cl_value'].'</td></tr>';			
			$s_value_total += $res['s_value'];
			$cl_value_total += $res['cl_value'];
			 }

		 ?>
         <tr style="font-size:11px; border:#000 1px solid; font-weight:bold;">
		    <td colspan="2" style="text-align:left; border:none;">Grand Total : </td>
            <td style="text-align:right;"></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <td style="text-align:right;"><?php echo $s_value_total;?></td><td></td><td></td><td></td><td></td>
            <td style="text-align:right;"><?php echo $cl_value_total;?></td></tr> 
            
                
        <?php
		}
	}
  else
    {
      echo '<tr><td colspan="15"><b style="font-size:12px;"> No Ledger Exists </b></td></tr>    ';
    }
    ?>