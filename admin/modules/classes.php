<?php

class ImageUploader{
	private $max_size;
	private $max_height;
	private $max_width;
	private $upload_dir;
	private $file_name;
	private $file_size;
	private $file_tmp;
	private $file_type;
	private $image_name; //the name we set as uploaded
	
	
	function __construct($max_size, $max_width, $max_height, $upload_dir)
	{
		 $this->max_size = $max_size;
		 $this->max_height = $max_height;
		 $this->max_width = $max_width;
		 $this->upload_dir = $upload_dir;
	}
	

	function setImage($name)
	{
		$this->file_name = $_FILES[$name]['name'];
		$this->file_size = $_FILES[$name]['size'];
		$this->file_tmp = $_FILES[$name]['tmp_name'];
		$this->file_type = $_FILES[$name]['type'];
	}
	
	
	function setImageName($name)
	{
		$this->image_name = $name;
	}
	
	
	function deleteExisting()
	{
		$jpg =  $this->upload_dir.''.$this->image_name.'.jpg';
		if(file_exists($jpg)) unlink($jpg);
		
		$jpeg =  $this->upload_dir.''.$this->image_name.'.jpeg';
		if(file_exists($jpeg)) unlink($jpeg);		
			
		$gif =  $this->upload_dir.''.$this->image_name.'.gif';
		if(file_exists($gif)) unlink($gif); 		
			
		$png =  $this->upload_dir.''.$this->image_name.'.png';
		if(file_exists($png)) unlink($png);		
	}
	

	function upload()
	{
		$ext = strrchr($this->file_name, '.');
		$name = $this->upload_dir.''.$this->image_name.''.$ext;
		if(!move_uploaded_file($this->file_tmp, $name))
			{
			$_SESSION['ERRMSG']=$_FILES[$this->file_name]['error'];
			session_write_close();
			header("location:  ./?p=photos");
			exit();
			}
		else
		return $this->image_name.''.$ext;
	}
	

		
	function checkSize()
	{
		if($this->file_size > ($this->max_size*1024))
		return false;
		else
		return true;
	}
	

	
	function checkHeight()
	{
		$file = getimagesize($this->file_tmp);
		//$height = $file[1];
		if($file[1] > $this->max_height)
		return false;
		else
		return true;
	}
	
	
	function checkWidth()
	{
		$file = getimagesize($this->file_tmp);
		//$width = $file[0];
		if($file[0] > $this->max_height)
		return false;
		else
		return true;
	}
	
	
	function checkExt()
	{
	echo $file_type;	
	if (($this->file_type != 'image/jpg') && ($this->file_type != 'image/jpeg') && 	($this->file_type != 'image/gif') && ($this->file_type != 'image/png'))
	return false;
	else return true;		
	}
}







class SimpleImage {
   
   var $image;
   var $image_type;
 
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   	

    function save($filename) {
	$image_type=IMAGETYPE_JPEG;
	$compression=50;
	$permissions=null;
	if( $image_type == IMAGETYPE_JPEG ) {
	return imagejpeg($this->image,$filename,$compression);  }
	
	else if( $image_type == IMAGETYPE_GIF ) {
        return imagegif($this->image,$filename);  } 
	else if( $image_type == IMAGETYPE_PNG ) {
        return imagepng($this->image,$filename); } 
  
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }

   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   
	

   function resize($width,$height) {
	$back_color = sscanf('#FFFFFF', '#%2x%2x%2x');
	$new_image = imagecreatetruecolor($width, $height);
	$back_col = imagecolorallocate($this->image,$back_color[0],$back_color[1],$back_color[2]);
	imagefill($this->image, 0, 0, $back_col);
	imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
     $this->image =  $new_image;   
   }      
   
}

?>
