<?php
	//print_r($_POST);
	//print_r($_FILES);
	sleep(10);
	$uploadDir = "upload";	
	if (isset($_FILES['photoloc']['name'])){
		move_uploaded_file($_FILES['photoloc']['tmp_name'],$uploadDir ."/" . $_FILES['photoloc']['name'] );
		
		
	}	
	$result = [
		"status"=>"OK",
		"fin_id"=> $_POST["fin_id"]			
	];
	header('Content-Type: application/json');
	echo json_encode($result);
?>