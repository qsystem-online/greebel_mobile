<?php
	print_r($_POST);
	print_r($_FILES);
	
	if (($_FILES['avatar']['name']!="")){
		// Where the file is going to be stored
		$target_dir = "upload/";
		$file = $_FILES['avatar']['name'];
		$path = pathinfo($file);
		$filename = $path['filename'];
		$ext = $path['extension'];
		$temp_name = $_FILES['avatar']['tmp_name'];
		$path_filename_ext = $target_dir.$filename.".".$ext;
 
		// Check if file already exists
		if (file_exists($path_filename_ext)) {
			echo "Sorry, file already exists.";
		}else{
			try{
				move_uploaded_file($temp_name,$path_filename_ext);
				echo "Congratulations! File Uploaded Successfully.";
			}catch(Exception $e){
				echo $e->getMessage();
				
			}
			
		}
	}
	
?>