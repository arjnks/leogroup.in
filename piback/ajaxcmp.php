<?php 
require_once("../config.php");
if($_POST["type"]==1)
{
  $cid=$_POST["cid"];
	$sel=$con->prepare("select * from tb_client WHERE cid='$cid'");
	$sel->execute();
	$res=$sel->fetch(PDO::FETCH_ASSOC);
	                      if($res["catid"]=='1')
                              $grup="C & F Agents / Superstockists";
                            elseif ($res["catid"]=='2') 
                              $grup="LEO DISTRIBUTORS";
                             elseif ($res["catid"]=='3') 
                              $grup="LEO ENTERPRISES";
                             elseif ($res["catid"]=='4') 
                              $grup="ARIES ENTERPRISES"; 
	?>

	<div class="col-md-12" id="client">
                             
                                    <form role="form" method="post">
                                     <div class="col-md-3">
                                     	<input type="hidden" name="txtcid" value="<?php echo $res["cid"]?>">
                                     <div class="form-group">
                                            <label>Select Group</label>
                                            <select class="form-control" name="selgrp" id="selgrp">
                                              <option value="<?php echo $res["catid"]?>"><?php echo $grup;?></option>
                                                <option value="1">C & F Agents / Superstockists </option>
                                                <option value="2">LEO DISTRIBUTORS</option>
                                                <option value="3">LEO ENTERPRISES</option>
                                                <option value="4">ARIES ENTERPRISES</option>
                                            </select>
                                        </div>
										</div>
										
										    <div class="col-md-12">
										    <div class="form-group col-md-3" style="margin-left: -14px;">
                                            <label>Client Name</label><br> 
                                          <input type="text" name="txtCname" id="txtCname" class="form-control" value="<?php echo $res["name"];?>">
                                        </div>
										 </div>
										     <div class="col-md-12">
                                 <div class="form-group mgtp25" style="margin-top:19px;">
                                    
                                        <button type="button" class="btn btn-default" name="btnupd" onclick="upd(<?php echo $res["cid"]?>)">Update</button>
                                
</div>
</div>
					
                             
                                    </form>
                                    <br />
                                   
     

                                 
    </div>

    <?php
}

if($_POST["type"]==3)
{
	$grop=$_POST["grup"];
	$name=$_POST["name"];
	$cid=$_POST["cid"];
	$upd=$con->prepare("UPDATE `tb_client` SET `catid`='$grop',`name`='$name' WHERE cid='$cid'");
   $upd->execute();
}
if($_POST["type"]==2)
{
	$cid=$_POST["cid"];
	$del=$con->prepare("delete from tb_client WHERE cid='$cid'");
	$del->execute();
}
if($_POST["type"]==5)
{
	$cid=$_POST["catid"];
	$del1=$con->prepare("delete from tb_gallery WHERE catid='$cid'");
	$del1->execute();
	$del=$con->prepare("delete from tb_cat WHERE catid='$cid'");
	$del->execute();
}
if ($_POST["type"]==8) 
{
	$catid=$_POST["catid"];
	?>
	<div class="col-md-12" id="img">
	
                    <?php 
                    $sell=$con->prepare("select *  from tb_gallery WHERE catid='$catid'");
                    $sell->execute();
                    while($res=$sell->fetch(PDO::FETCH_ASSOC))
                      {?>
                      	<div class="col-md-2">
                             <div class="img-wraper" style="width:100%;">
                      <div class="admin-img" style=" width: 177px;height: 168px;float: left;margin-right: 8px;">
                                           <div><img src="<?php echo $res["path"]?>"></div>
                   
              <button type="button" class="btn btn-danger" style=" width: 159px;" name="btnsub" onclick="del(<?php echo $res["gid"]?>)">Delete</button>
                       </div>  </div>   </div>
                     <?php }?>
                    
                       
           
            </div> 
<?php }
if ($_POST["type"]==9) 
{
    $gid=$_POST["gid"];
	$del=$con->prepare("delete from tb_gallery WHERE gid='$gid'");
	$del->execute();

}
?>
  