<?php
error_reporting(0);
date_default_timezone_set("Asia/Kolkata");
session_start();
include('../stockupload/include/db.php');
if(isset($_POST['add']))
{
	
		
			  $file			     =	 $_FILES['uploadfile'];
			 
			  $file_name		 =	 $file['name'];
			  $file_temp_name	 =	 $file['tmp_name'];
			  $error			 =	 $file['error'];
			  $type			     =	 $file['type'];
			  $size			     =	 $file['size'];
			  $save_path		 =	 "upload/".$file_name; 

	
	if($type == "text/plain"){
		
		$del_sql = "DELETE FROM stock_tb";
				$del_stm  = $db_con->prepare($del_sql);
				$del_stm  ->	execute();
						
	if(move_uploaded_file($file_temp_name,$save_path))
												{
	$lines = file($save_path, FILE_SKIP_EMPTY_LINES);
		
		$qline =''; $c='';
		foreach ($lines as $line)
		{
			$qarr=explode(',',$line);
			
			if(4== count($qarr))
			{	
				$d0= $qarr[0];
				$d1=$qarr[1];
				$d2=$qarr[2];
				$d3=$qarr[3];
				
			}
			
			$date=date_create($qarr[0]);
			$dd = date_format($date,"Y-m-d H:i:s");
			 
				$sql = "INSERT INTO `stock_tb`(p_date,company_name,product_name,p_count) 
							VALUES ('$dd','$qarr[1]','$qarr[2]','$qarr[3]')";
				$stm  = $db_con->prepare($sql);
				$stm  ->	execute();
			
			
		}


				?>
		<script>
		alert("Successfully Uploaded");
		</script>
		<?php
													
												}												
						}
	else{
		?>
		<script>
		alert("Choose TXT file only");
		</script>
		<?php
	}
	
	
	}

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Home</title>
	<link rel="stylesheet" href="../stockupload/css/style.css" type="text/css" media="all" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> 
    
  
    
        <script type="text/javascript">
            $(document).ready(function(){
                function loading_show(){
                    $('#loading').html("<img src='../stockupload/images/loading.gif'/>").fadeIn('fast');
                }
                function loading_hide(){
                    $('#loading').fadeOut('fast');
                }                
                function loadData(page){
                    loading_show();                    
                    $.ajax
                    ({
                        type: "POST",
                        url: "../stockupload/admin/fileupload_data.php",
                        data: "page="+page,
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
        </script>
        


        <style type="text/css">
            body{
                background:#f9ebae;
				font-family: Verdana, sans-serif;
				font-size:11px;
				line-height:14px;
				color:#5e5e5e;
            }
            #loading{
                width: 100%;
                position: absolute;
                top: 100px;
                left: 100px;
				margin-top:200px;
            }
            #container .pagination ul li.inactive,
            #container .pagination ul li.inactive:hover{
                background-color:#ededed;
                color:#A00000;
                border:1px solid #bababa;
                cursor: default;
            }
            #container .data ul li{
                list-style: none;
                font-family: verdana;
                margin: 5px 0 5px 0;
                color: #A00000;
                font-size: 13px;
            }

            #container .pagination{
                width: 700px;
                height: 25px;
            }
            #container .pagination ul li{
                list-style: none;
                float: left;
                border: 1px solid #006699;
                padding: 2px 6px 2px 6px;
                margin: 0 3px 0 3px;
                font-family: arial;
                font-size: 14px;
                color: #A00000;
                font-weight: bold;
                background-color: #f2f2f2;
            }
            #container .pagination ul li:hover{
                color: #A00000;
                background-color: #A00000;
                cursor: pointer;
            }
			.go_button
			{
			background-color:#f2f2f2;
			border:1px solid #006699;
			color:#A00000;
			padding:2px 6px 2px 6px;
			cursor:pointer;
			position:absolute;
			margin-top:-1px;
			}
			.total
			{
			float:right;
			font-family:arial;
			color:#A00000;
			}

        </style>

    </head>
    <body>
    <!-- Header -->
    <div id="header">
        <div class="shell">
            <!-- Logo + Top Nav -->
            <div id="top">
                <h1><a href="#"></a></h1>
              <div id="top-navigation">
              	<br><br><br>
<a href="password_change.php">Settings</a>/
                    <a href="../stockupload/include/logout2.php">Logout</a>
              </div>
            </div>
           
            <!-- End Logo + Top Nav -->
		
		<!-- Main Nav -->
	
        <!-- End Main Nav -->
	</div>
</div>
<!-- End Header -->
<div class="form">

<div class="shell">
	
		
<div>							
	<form action="file_upload.php" method="post" enctype="multipart/form-data">
								<p>
									
									<label>Upload Stock file <span></span></label>
									Upload Stock file <input type="file" name="uploadfile" id="uploadfile">
									<input type="submit" class="button" id="add" name="add" value="Upload" />
								</p>	
						</form>		

</div>
</div>

        <div id="loading"></div>
        <div id="container">
            <div class="data"></div>
            <div class="pagination"></div>
        </div>
