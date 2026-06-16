<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> 
        <script type="text/javascript">
		    function searchButton(){ 
			var item_search=document.getElementById('item_search').value;
            $(document).ready(function(){
                function loading_show(){
                    $('#loading').html("<img src='images/loading.gif'/>").fadeIn('fast');
                }
                function loading_hide(){
                    $('#loading').fadeOut('fast');
                }                
                function loadData(page){
                    loading_show();                    
                    $.ajax
                    ({
                        type: "POST",
                        url: "item_search.php",
                        data: { page : page,
								item_search	:	item_search
								},
                        success: function(msg)
                        {
						//alert(page);
                            $("#container").ajaxComplete(function(event, request, settings)
                            {
                                loading_hide();
                                $("#container").html(msg);
                            });
                        }
                    });
                }
                loadData(1);  // For first time page load default results
                $('#container .pagination li.active').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
                    
                });           
                $('#go_btn').live('click',function(){
                    var page = parseInt($('.goto').val());
                    var no_of_pages = parseInt($('.total').attr('a'));
                    if(page != 0 && page <= no_of_pages){
                        loadData(page);
                    }else{
                        alert('Enter a PAGE between 1 and '+no_of_pages);
                        $('.goto').val("").focus();
                        return false;
                    }
                    
                });
            });
			}
        </script>
		
<?php
session_start();
error_reporting(0);
include('../include/db.php');
include('../include/login_check.php');	

if($_POST['page'])
{

$page = $_POST['page'];
$cur_page = $page;
$page -= 1;
$per_page = 15;

$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;

$item=$_POST['item_search'];

$item_name	="%".$_POST['item_search']."%";	
					
$query_pag_data = "SELECT * FROM stock_tb
				WHERE product_name LIKE :product_name
				ORDER BY product_name ASC";
			$stmt_page_data=$db_con->prepare($query_pag_data);
			$stmt_page_data->bindparam('product_name',$item_name);
			$stmt_page_data->execute();
$msg = "";

/*--------------------------------------------- */
$query_pag_num 	= "SELECT COUNT(*) AS count FROM `stock_tb` WHERE product_name LIKE :product_name";
$result_pag_num = $db_con->prepare($query_pag_num);
$result_pag_num ->bindparam('product_name',$item_name);
$result_pag_num	->execute();
$row = $result_pag_num->fetch(PDO::FETCH_ASSOC);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);





if($count == 0){ ?>
   <b style=" color:#FF0000; ">No data Found..</b>
<?php }else {
?> 

<div id="container">
	<div class="shell">
	
		<div id="main">
			<div class="cl">&nbsp;</div>
			
			<!-- Content -->
			<div id="content">
            
 <!--Box-->    
            
            <!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2 class="left">Menu List</h2>
						<div class="right">
						<label>search item</label>
			<input type="text" name="item_search" id="item_search" value="" class="field small-field" />
			<input type="submit" class="button" value="search" name="search" onclick="searchButton();"/>
						</div>
					</div>
                    

                   
                    <div class="table2">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
                        
							<tr>
								<!--<th width="13">Menu ID</th>-->
                                
								<th>Date</th>
								<th>Company Name</th>
								<th>Product Name</th>
                                <th>Count</th>
                              <!--  <th>Category</th>
								<th width="110" class="ac">Content Control</th> -->
								
							</tr>
                            <?php $i=1; ?>
                            <?php while ($row = $stmt_page_data->fetch(PDO::FETCH_ASSOC)) {?>
                           
							<tr>
								<!--<td><?php echo $i; ?></td><?php $i=$i+1; ?>-->
								
                                <td><?php echo ucfirst($row['p_date']);?></td>
                                <td><?php echo $row['company_name'];?></td>
                                <td><?php echo $row['product_name'];?></td>
								<td><?php echo ucfirst($row['p_count']);?></td>
							<!--	<td><?php echo ucfirst($row['category']);?></td>
								<?php  if ($row['menu_status']==1){?>
         
        	<td><a href="active.php?menu_id=<?php echo $row['menu_id']?>" title="click to active Today's Special"><font color="blue">Not Special</font></a></td>
        <?php } else if ($row['menu_status']==2) { ?>
        
        	<td><a href="deactive.php?menu_id=<?php echo $row['menu_id']?>" title="click to deactive Special"> <font color="#669966">Special</font></a></td>
        
        <?php } ?>-->
                                
							</tr>
							<?php } ?>
                            
						</table>
</div>


<?php 
}
echo '<br>';



 /*---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
 /*----------------------------------------------------------------------------------------------------------- */
$msg .= "<div class='pagination'><ul>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
    $msg .= "<li p='1' class='active'>First</li>";
} else if ($first_btn) {
    $msg .= "<li p='1' class='inactive'>First</li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' class='active'>Previous</li>";
} else if ($previous_btn) {
    $msg .= "<li class='inactive'>Previous</li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $msg .= "<li p='$i' style='color:#fff;background-color:#006699;' class='active'>{$i}</li>";
    else
        $msg .= "<li p='$i' class='active'>{$i}</li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' class='active'>Next</li>";
} else if ($next_btn) {
    $msg .= "<li class='inactive'>Next</li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
    $msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
} else if ($last_btn) {
    $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
}
$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:10px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";

$total_string = "<span style='' class='total' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b> / Total Records <b>".$count."</b></span>";
$msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination
echo $msg;

echo '<br>';



$msg = "<div class='data'><ul>" . $msg . "</ul></div>"; 

}

?>
</div>


                
                </div>
			<!-- End Content -->	
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>
<!-- End Container -->



</body>
</html>

</body>
</html>
